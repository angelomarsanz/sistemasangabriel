<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Recibos Controller
 *
 * @property \App\Model\Table\RecibosTable $Recibos
 */
class RecibosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $recibos = $this->paginate($this->Recibos);

        $this->set(compact('recibos'));
        $this->set('_serialize', ['recibos']);
    }

    /**
     * View method
     *
     * @param string|null $id Recibo id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $recibo = $this->Recibos->get($id, [
            'contain' => []
        ]);

        $this->set('recibo', $recibo);
        $this->set('_serialize', ['recibo']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;

        $recibo = $this->Recibos->newEntity();
        $recibo->requesting_user = $this->Auth->user('username');
        
        if ($this->Recibos->save($recibo)) 
        {
            $lastRecord = $this->Recibos->find('all', ['conditions' => ['requesting_user' => $this->Auth->user('username')],
                'order' => ['Recibos.created' => 'DESC'] ]);

            $row = $lastRecord->first();
                
            $billId = $row['id'];

            return $billId;
        }
        else
        {
            $this->Flash->error(__('No se generó el número consecutivo para el recibo, intente de nuevo'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Recibo id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $recibo = $this->Recibos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $recibo = $this->Recibos->patchEntity($recibo, $this->request->data);
            if ($this->Recibos->save($recibo)) {
                $this->Flash->success(__('The recibo has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The recibo could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('recibo'));
        $this->set('_serialize', ['recibo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Recibo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recibo = $this->Recibos->get($id);
        if ($this->Recibos->delete($recibo)) {
            $this->Flash->success(__('The recibo has been deleted.'));
        } else {
            $this->Flash->error(__('The recibo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
