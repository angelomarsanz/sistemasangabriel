<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\I18n\Time;

/**
 * Historicotasas Controller
 *
 * @property \App\Model\Table\HistoricotasasTable $Historicotasas
 */
class HistoricotasasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $historicotasas = $this->paginate($this->Historicotasas, ['contain' => 'Monedas', 'order' => ['created' => 'DESC']]);

        $this->set(compact('historicotasas'));
        $this->set('_serialize', ['historicotasas']);
    }

    /**
     * View method
     *
     * @param string|null $id Historicotasa id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $historicotasa = $this->Historicotasas->get($id, [
            'contain' => []
        ]);

        $this->set('historicotasa', $historicotasa);
        $this->set('_serialize', ['historicotasa']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($idMoneda = null, $tasaCambioDolar = null)
    {
		$this->autoRender = false;
		
		$codigoRetorno = 0;
		
		$binnacles = new BinnaclesController;
        
		$historicoTasa = $this->Historicotasas->newEntity();

		$historicoTasa->moneda_id = $idMoneda;
		$historicoTasa->tasa_cambio_dolar = $tasaCambioDolar;
		$historicoTasa->usuario_responsable = $this->Auth->user('username');

		if (!($this->Historicotasas->save($historicoTasa))) 
		{
			$binnacles->add('controller', 'Historicotasas', 'add', 'No se pudo grabar el histórico de la tasa correspondiente a la moneda con ID ' . $idMoneda);	
			$codigoRetorno = 1;
		}
		return $codigoRetorno;
    }

    /**
     * Edit method
     *
     * @param string|null $id Historicotasa id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $historicotasa = $this->Historicotasas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $historicotasa = $this->Historicotasas->patchEntity($historicotasa, $this->request->data);
            if ($this->Historicotasas->save($historicotasa)) {
                $this->Flash->success(__('The historicotasa has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The historicotasa could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('historicotasa'));
        $this->set('_serialize', ['historicotasa']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Historicotasa id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $historicotasa = $this->Historicotasas->get($id);
        if ($this->Historicotasas->delete($historicotasa)) {
            $this->Flash->success(__('The historicotasa has been deleted.'));
        } else {
            $this->Flash->error(__('The historicotasa could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
