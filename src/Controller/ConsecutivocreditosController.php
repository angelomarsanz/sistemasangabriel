<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Consecutivocreditos Controller
 *
 * @property \App\Model\Table\ConsecutivocreditosTable $Consecutivocreditos
 */
class ConsecutivocreditosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $consecutivocreditos = $this->paginate($this->Consecutivocreditos);

        $this->set(compact('consecutivocreditos'));
        $this->set('_serialize', ['consecutivocreditos']);
    }

    /**
     * View method
     *
     * @param string|null $id Consecutivocredito id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $consecutivocredito = $this->Consecutivocreditos->get($id, [
            'contain' => []
        ]);

        $this->set('consecutivocredito', $consecutivocredito);
        $this->set('_serialize', ['consecutivocredito']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;

        $consecutivoCredito = $this->Consecutivocreditos->newEntity();
		
        $consecutivoCredito->usuario_solicitante = $this->Auth->user('username');
        
        if ($this->Consecutivocreditos->save($consecutivoCredito)) 
        {
            $numerosNota = $this->Consecutivocreditos->find('all', ['conditions' => ['usuario_solicitante' => $this->Auth->user('username')],
                'order' => ['created' => 'DESC'] ]);
				
			$contadorRegistros = $numerosNota->count();
			
			if ($contadorRegistros > 0)
			{
				$ultimoNumero = $numerosNota->first();
                			
				$numeroNota = $ultimoNumero->id;

				return $numeroNota;
			}
			else
			{
				$this->Flash->error(__('No se encontraron números de nota de crédito para este usuario'));
			}
        }
        else
        {
            $this->Flash->error(__('No se generó el número consecutivo de la nota. Por favor intente de nuevo'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Consecutivocredito id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $consecutivocredito = $this->Consecutivocreditos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consecutivocredito = $this->Consecutivocreditos->patchEntity($consecutivocredito, $this->request->data);
            if ($this->Consecutivocreditos->save($consecutivocredito)) {
                $this->Flash->success(__('The consecutivocredito has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The consecutivocredito could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('consecutivocredito'));
        $this->set('_serialize', ['consecutivocredito']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Consecutivocredito id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consecutivocredito = $this->Consecutivocreditos->get($id);
        if ($this->Consecutivocreditos->delete($consecutivocredito)) {
            $this->Flash->success(__('The consecutivocredito has been deleted.'));
        } else {
            $this->Flash->error(__('The consecutivocredito could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
