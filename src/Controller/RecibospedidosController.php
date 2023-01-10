<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Recibospedidos Controller
 *
 * @property \App\Model\Table\RecibospedidosTable $Recibospedidos
 */
class RecibospedidosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $recibospedidos = $this->paginate($this->Recibospedidos);

        $this->set(compact('recibospedidos'));
        $this->set('_serialize', ['recibospedidos']);
    }

    /**
     * View method
     *
     * @param string|null $id Recibospedido id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $recibospedido = $this->Recibospedidos->get($id, [
            'contain' => []
        ]);

        $this->set('recibospedido', $recibospedido);
        $this->set('_serialize', ['recibospedido']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;

        $recibospedido = $this->Recibospedidos->newEntity();
        $recibospedido->requesting_user = $this->Auth->user('username');
        
        if ($this->Recibospedidos->save($recibospedido)) 
        {
            $lastRecord = $this->Recibospedidos->find('all', ['conditions' => ['requesting_user' => $this->Auth->user('username')],
                'order' => ['Recibospedidos.created' => 'DESC'] ]);

            $row = $lastRecord->first();
                
            $billId = $row['id'];

            return $billId;
        }
        else
        {
            $this->Flash->error(__('No se generó el número consecutivo para el recibo de pedido, intente de nuevo'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Recibospedido id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $recibospedido = $this->Recibospedidos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $recibospedido = $this->Recibospedidos->patchEntity($recibospedido, $this->request->data);
            if ($this->Recibospedidos->save($recibospedido)) {
                $this->Flash->success(__('The recibospedido has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The recibospedido could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('recibospedido'));
        $this->set('_serialize', ['recibospedido']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Recibospedido id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recibospedido = $this->Recibospedidos->get($id);
        if ($this->Recibospedidos->delete($recibospedido)) {
            $this->Flash->success(__('The recibospedido has been deleted.'));
        } else {
            $this->Flash->error(__('The recibospedido could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
