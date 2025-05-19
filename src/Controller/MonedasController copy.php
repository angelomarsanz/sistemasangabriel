<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\HistoricotasasController;

use Cake\I18n\Time;

/**
 * Monedas Controller
 *
 * @property \App\Model\Table\MonedasTable $Monedas
 */
class MonedasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $monedas = $this->paginate($this->Monedas);

        $this->set(compact('monedas'));
        $this->set('_serialize', ['monedas']);
    }

    /**
     * View method
     *
     * @param string|null $id Moneda id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $moneda = $this->Monedas->get($id, [
            'contain' => []
        ]);

        $this->set('moneda', $moneda);
        $this->set('_serialize', ['moneda']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $moneda = $this->Monedas->newEntity();
        if ($this->request->is('post')) {
            $moneda = $this->Monedas->patchEntity($moneda, $this->request->data);
            if ($this->Monedas->save($moneda)) {
                $this->Flash->success(__('The moneda has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The moneda could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('moneda'));
        $this->set('_serialize', ['moneda']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Moneda id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $moneda = $this->Monedas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $moneda = $this->Monedas->patchEntity($moneda, $this->request->data);
            if ($this->Monedas->save($moneda)) {
                $this->Flash->success(__('The moneda has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The moneda could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('moneda'));
        $this->set('_serialize', ['moneda']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Moneda id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $moneda = $this->Monedas->get($id);
        if ($this->Monedas->delete($moneda)) {
            $this->Flash->success(__('The moneda has been deleted.'));
        } else {
            $this->Flash->error(__('The moneda could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
    public function actualizarTasa()
    {
        $this->autoRender = false;
		
		$binnacles = new BinnaclesController;
		
        if ($this->request->is('json')) 
        {
            if (!(isset($_POST['amount'])))
            {
                die("Solicitud no válida");    
            }

			if ($_POST['tipo'] == "Dolar")
			{
				$moneda = $this->Monedas->get(2);
			}
			else
			{
				$moneda = $this->Monedas->get(3);				
			}
			
			if (substr($_POST['amount'], -3, 1) == ',')
			{
				$replace1= str_replace('.', '', $_POST['amount']);
				$replace2 = str_replace(',', '.', $replace1);
				$moneda->tasa_cambio_dolar = $replace2;
			}
			else
			{
				$moneda->tasa_cambio_dolar = $_POST['amount'];
			}
			
			$moneda->usuario_responsable = $this->Auth->user('username'); 
				
			setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
			date_default_timezone_set('America/Caracas');
			$fechaHoraActual = Time::now();
			
			$moneda->fecha_cambio_estatus = $fechaHoraActual;
			
			if ($this->Monedas->save($moneda)) 
			{			
				$historicoTasa = new HistoricotasasController();
				
				$codigoRetorno = $historicoTasa->add($moneda->id, $moneda->tasa_cambio_dolar);
				
				if ($codigoRetorno == 0)
				{
	                $jsondata["success"] = true;
					$jsondata["message"] = "Se actualizó la tasa de cambio";
				}
				else
				{
					$jsondata["success"] = false;
					$jsondata["message"] = 'No se pudo grabar el histórico de la tasa ' . $moneda->moneda;					
				}			
            }   
            else
            {
				$binnacles->add('controller', 'Monedas', 'actualizarTasa', 'No se pudo actualizar la tasa de cambio a: ' . $_POST['amount']);
                $jsondata["success"] = false;
                $jsondata["message"] = "No se pudo actualizar la tasa de cambio";
            }

            exit(json_encode($jsondata, JSON_FORCE_OBJECT));
        }
    }
}