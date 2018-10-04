<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\StudenttransactionsController;

use Cake\Mailer\Email;

use App\Controller\BinnaclesController;

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
		$binnacles = new BinnaclesController;
		$swDateexception = 0;
		$dateException = null;
		$arrayResult = [];
		$arrayMail = [];
		$noDifference = 0;
		
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
				return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
			}	
			elseif ($rate->concept == "Diferencia de agosto")
			{                        
				$this->loadModel('Schools');

				$school = $this->Schools->get(2);
				
				$school->current_year_registration = $rate->rate_year;
				
				$school->previous_year_registration = $rate->rate_year - 1;
				
				$school->next_year_registration = $rate->rate_year + 1;
				
				if ($this->Schools->save($school)) 
				{
					$binnacles->add('controller', 'Rates', 'add', 'Se actualizaron correctamente los años de período de inscripción');

					$lastRecord = $this->Rates->find('all', ['conditions' => [['concept' => $rate->concept], ['rate_year' => $rate->rate_year]], 
						'order' => ['Rates.created' => 'DESC'] ]);
				   
					$row = $lastRecord->first();
				
					if ($row)
					{
						$noDifference = 1;
					}
				
					$arrayResult = $studentTransactions->differenceAugust($rate->amount, $rate->rate_year, $noDifference);
										
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
				}
				else
				{
					$binnacles->add('controller', 'Rates', 'add', 'No se pudieron actualizar los años de inscripción');						
					$arrayMail['error'] = 1;
					$arrayMail['adjust'] = 0;
				}
				$arrayMail['year'] = $rate->rate_year;
				$binnacles->add('controller', 'Rates', 'add', 'Se ejecutó la función de enviar correo de diferencia de agosto');
				$result = $this->mailAugust($arrayMail);
				return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
			}
			elseif ($rate->concept == "Diferencia de matrícula")
			{
				$error = 0;
				$messageError = '';
								
				$arrayResult = $studentTransactions->differenceRegistration($rate->amount, $rate->rate_year);
									
				if ($arrayResult['indicator'] == 0)
				{
					if (!($this->Rates->save($rate))) 
					{ 
						$error = 1;
						$messageError = 'No se pudo actualizar la tarifa';
					}
				}
				else
				{
					$error = 1;
					$messageError = 'No se pudo actualizaron correctamente las diferencias de matrícula';
				}
				$binnacles->add('controller', 'Rates', 'add', 'Error: ' . $error . ' Mensaje: ' . $messageError);
				return $this->redirect(['controller' => 'Users', 'action' => 'logout']);					
			}
			else
			{
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
          ->to('u.esangabriel.admon@gmail.com') 
//          ->to('transemainc@gmail.com') 
		  ->cc('angelomarsanz@gmail.com')
          ->from('sistemasangabriel@gmail.com') 
          ->subject('Resultados ajuste de mensualidades')
          ->viewVars([ 
            'varError' => $arrayMail['error'],
            'varAdjust' => $arrayMail['adjust'],
            'varNotAdjust' => $arrayMail['notAdjust'],
			'varAdjustDefaulters' => $arrayMail['adjustDefaulters']
          ]);
  
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
    public function consultFee()
    {
        $this->autoRender = false;

		$binnacles = new BinnaclesController;
		
        if ($this->request->is('json')) 
        {
			$binnacles->add('controller', 'Rates', 'consultFee', 'Valor recibido: ' . $_POST['yearAugust']);
			
            $jsondata = [];
			
            $lastRecord = $this->Rates->find('all', ['conditions' => [['concept' => 'Agosto'], ['rate_year' => $_POST['yearAugust']]], 
				'order' => ['Rates.created' => 'DESC']]);

            $row = $lastRecord->first();
			
            if ($row) 
            {
                $jsondata["success"] = true;
				$jsondata["message"] = "Búsqueda exitosa";
                $jsondata["data"] = $row->amount;
			}
			else
			{
                $jsondata["success"] = false;
				$jsondata["message"] = "Falló la búsqueda";
                $jsondata["data"] = "No se encontró el monto abonado al mes de agosto " . $_POST['yearAugust'];
            }
			
			$binnacles->add('controller', 'Rates', 'consultFee', $jsondata['success'] . ' ' . $jsondata['data']);

            exit(json_encode($jsondata, JSON_FORCE_OBJECT));
        }
    }
    public function mailAugust($arrayMail = null)
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
          ->template('difference_august') 
          ->emailFormat('html') 
          ->to('u.esangabriel.admon@gmail.com') 
//          ->to('transemainc@gmail.com')  
		  ->cc('angelomarsanz@gmail.com')
          ->from('sistemasangabriel@gmail.com') 
          ->subject('Resultado actualización monto diferencia de agosto ' . $arrayMail['year'])
          ->viewVars([ 
            'varError' => $arrayMail['error'],
			'varYear' => $arrayMail['year'],
            'varAdjust' => $arrayMail['adjust']
          ]);
  
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
    public function monetaryReconversion()
    {				
		$binnacles = new BinnaclesController;
	
		$rates = $this->Rates->find('all', ['conditions' => ['id >' => 0]]);
	
		$account1 = $rates->count();
			
		$account2 = 0;
		
		foreach ($rates as $rate)
        {		
			$rateGet = $this->Rates->get($rate->id);
			
			$previousAmount = $rateGet->amount;
										
			$rateGet->amount = $previousAmount / 100000;
	
			if ($this->Rates->save($rateGet))
			{
				$account2++;
			}
			else
			{
				$binnacles->add('controller', 'Rates', 'monetaryReconversion', 'No se actualizó registro con id: ' . $rateGet->id);
			}
		}

		$binnacles->add('controller', 'Rates', 'monetaryReconversion', 'Total registros seleccionados: ' . $account1);
		$binnacles->add('controller', 'Rates', 'monetaryReconversion', 'Total registros actualizados: ' . $account2);
		return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
	}
}