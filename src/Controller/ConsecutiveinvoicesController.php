<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Consecutiveinvoices Controller
 *
 * @property \App\Model\Table\ConsecutiveinvoicesTable $Consecutiveinvoices
 */
class ConsecutiveinvoicesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $consecutiveinvoices = $this->paginate($this->Consecutiveinvoices);

        $this->set(compact('consecutiveinvoices'));
        $this->set('_serialize', ['consecutiveinvoices']);
    }

    /**
     * View method
     *
     * @param string|null $id Consecutiveinvoice id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $consecutiveinvoice = $this->Consecutiveinvoices->get($id, [
            'contain' => []
        ]);

        $this->set('consecutiveinvoice', $consecutiveinvoice);
        $this->set('_serialize', ['consecutiveinvoice']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;

        $consecutiveinvoice = $this->Consecutiveinvoices->newEntity();
        $consecutiveinvoice->requesting_user = $this->Auth->user('username');
        
        if ($this->Consecutiveinvoices->save($consecutiveinvoice)) 
        {
            $lastRecord = $this->Consecutiveinvoices->find('all', ['conditions' => ['requesting_user' => $this->Auth->user('username')],
                'order' => ['Consecutiveinvoices.id' => 'DESC'] ]);

            $row = $lastRecord->first();
                
            $billId = $row['id'];

            return $billId;
        }
        else
        {
            $this->Flash->error(__('No se generó el número consecutivo de la factura, intente de nuevo'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Consecutiveinvoice id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $consecutiveinvoice = $this->Consecutiveinvoices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consecutiveinvoice = $this->Consecutiveinvoices->patchEntity($consecutiveinvoice, $this->request->data);
            if ($this->Consecutiveinvoices->save($consecutiveinvoice)) {
                $this->Flash->success(__('The consecutiveinvoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The consecutiveinvoice could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('consecutiveinvoice'));
        $this->set('_serialize', ['consecutiveinvoice']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Consecutiveinvoice id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consecutiveinvoice = $this->Consecutiveinvoices->get($id);
        if ($this->Consecutiveinvoices->delete($consecutiveinvoice)) {
            $this->Flash->success(__('The consecutiveinvoice has been deleted.'));
        } else {
            $this->Flash->error(__('The consecutiveinvoice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
