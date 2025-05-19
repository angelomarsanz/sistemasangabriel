<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Movimientos Controller
 *
 * @property \App\Model\Table\MovimientosTable $Movimientos
 */
class MovimientosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $movimientos = $this->paginate($this->Movimientos);

        $this->set(compact('movimientos'));
        $this->set('_serialize', ['movimientos']);
    }

    /**
     * View method
     *
     * @param string|null $id Movimiento id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $movimiento = $this->Movimientos->get($id, [
            'contain' => []
        ]);

        $this->set('movimiento', $movimiento);
        $this->set('_serialize', ['movimiento']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;

        $movimiento = $this->Movimientos->newEntity();
        $movimiento->requesting_user = $this->Auth->user('username');
        
        if ($this->Movimientos->save($movimiento)) 
        {
            $lastRecord = $this->Movimientos->find('all', ['conditions' => ['requesting_user' => $this->Auth->user('username')],
                'order' => ['Movimientos.created' => 'DESC'] ]);

            $row = $lastRecord->first();
                
            $billId = $row['id'];

            return $billId;
        }
        else
        {
            $this->Flash->error(__('No se generó el número consecutivo para el recibo de movimiento, intente de nuevo'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Movimiento id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $movimiento = $this->Movimientos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $movimiento = $this->Movimientos->patchEntity($movimiento, $this->request->data);
            if ($this->Movimientos->save($movimiento)) {
                $this->Flash->success(__('The movimiento has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The movimiento could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('movimiento'));
        $this->set('_serialize', ['movimiento']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Movimiento id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $movimiento = $this->Movimientos->get($id);
        if ($this->Movimientos->delete($movimiento)) {
            $this->Flash->success(__('The movimiento has been deleted.'));
        } else {
            $this->Flash->error(__('The movimiento could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
