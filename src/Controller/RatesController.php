<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\StudenttransactionsController;

use Cake\Mailer\Email;

use Cake\I18n\Time;

/**
 * Rates Controller
 *
 * @property \App\Model\Table\RatesTable $Rates
 */
class RatesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $query = $this->Rates->find('all', ['order' => ['Rates.concept' => 'ASC', 'Rates.rate_year' => 'DESC', 'Rates.rate_month' => 'DESC']]);

        $this->set('rates', $this->paginate($query));

        $this->set(compact('rates'));
        $this->set('_serialize', ['rates']);
    }

    /**
     * View method
     *
     * @param string|null $id Rate id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rate = $this->Rates->get($id, [
            'contain' => []
        ]);

        $this->set('rate', $rate);
        $this->set('_serialize', ['rate']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $studentTransactions = new StudenttransactionsController();
		$swDateexception = 0;
		$dateException = null;
		$arrayResult = [];
		$arrayMail = [];
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');

		$currentDate = Time::now();

        $rate = $this->Rates->newEntity();
        if ($this->request->is('post')) 
        {
            $rate->concept = $_POST['concept'];
			if (isset($_POST['rate_month']))
			{
				$rate->rate_month = $_POST['rate_month'];										
			}
            $rate->rate_year = $_POST['rate_year'];
            $rate->amount = $_POST['amount'];			
			
            if ($rate->concept == "Mensualidad")
            {
				if (isset($_POST['defaulters']))
				{
					$defaulters = 1;
				}
				else
				{
					$defaulters = 0;
				}
				
				if (isset($_POST['exception']))
				{
					$swDateException = 1;
					$dateException = new Time($_POST['date_exception']['year'] . '-' . $_POST['date_exception']['month'] . '-' . $_POST['date_exception']['day']);				
				}
				else
				{
					$swDateException = 0;
					$dateException = $currentDate;
				}
				
				$concept = 'Mensualidad';
                        
                $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
                   'order' => ['Rates.created' => 'DESC'] ]);

                $row = $lastRecord->first();
                
                $previousMonthlyPayment = $row->amount;
				
				$arrayResult = $studentTransactions->newMonthlyPayment($row->amount, $rate->amount, $rate->rate_month, $rate->rate_year, $defaulters, $swDateException, $dateException);   

				if ($arrayResult['indicator'] == 0)
				{
					if ($this->Rates->save($rate)) 
					{ 
						$arrayMail['error'] = 0;
					}
					else
					{
						$arrayMail['error'] = 1;							
					}
				}
				else
				{
					$arrayMail['error'] = 1;
				}
				$arrayMail['adjust'] = $arrayResult['adjust'];
				$arrayMail['notAdjust'] = $arrayResult['notAdjust'];
				$arrayMail['adjustDefaulters'] = $arrayResult['adjustDefaulters'];
				$result = $this->mailUser($arrayMail);
				exit;
			}
            else
            {
				if ($rate->concept == "Matrícula")
				{
					$studentTransactions->newRegistration($rate->amount, $rate->rate_year);
				}
				elseif ($rate->concept == "Diferencia de agosto")
				{
					
				}
				
				if ($this->Rates->save($rate)) 
				{
					$this->Flash->success(__('La tarifa ha sido guardada'));
				} 
				else 
				{
					$this->Flash->error(__('La tarifa no pudo ser guardada, intente de nuevo'));
				}		
				return $this->redirect(['action' => 'index']);				
            }
		}
        
        $this->set(compact('rate'));
        $this->set('_serialize', ['rate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rate id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rate = $this->Rates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rate = $this->Rates->patchEntity($rate, $this->request->data);
            if ($this->Rates->save($rate)) {
                $this->Flash->success(__('The rate has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rate could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('rate'));
        $this->set('_serialize', ['rate']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rate id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rate = $this->Rates->get($id);
        if ($this->Rates->delete($rate)) {
            $this->Flash->success(__('The rate has been deleted.'));
        } else {
            $this->Flash->error(__('The rate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function mailUser($arrayMail = null)
    {
		Email::configTransport('mail', [
		  'host' => 'ssl://smtp.gmail.com',
		  'port' => 465,
		  'username' => 'sistemasangabriel@gmail.com', 
		  'password' => 'fundevipp$', 
		  
		  'className' => 'Smtp', 
		  
		  'context' => [
			'ssl' => [
			  'verify_peer' => false,
			  'verify_peer_name' => false,
			  'allow_self_signed' => true
			]
		  ]
		]); 
	
		$correo = new Email(); 

        $correo
		  ->transport('mail')
          ->template('monthly_adjust') 
          ->emailFormat('html') 
//          ->to('u.esangabriel.admon@gmail.com') 
          ->to('transemainc@gmail.com') 
		  ->cc('angelomarsanz@gmail.com')
          ->from('sistemasangabriel@gmail.com') 
          ->subject('Resultados ajuste de mensualidades')
          ->viewVars([ 
            'varError' => $arrayMail['error'],
            'varAdjust' => $arrayMail['adjust'],
            'varNotAdjust' => $arrayMail['notAdjust'],
			'varAdjustDefaulters' => $arrayMail['adjustDefaulters']
          ]);
  
//        $correo->SMTPAuth = true;
//        $correo->CharSet = "utf-8";     

        if($correo->send())
        {
            $result = 0;
        }
        else
        {
            $result = 1;
        }

        return $result;
    }
}