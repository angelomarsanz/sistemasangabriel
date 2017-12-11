<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Consecutivereceipts Controller
 *
 * @property \App\Model\Table\ConsecutivereceiptsTable $Consecutivereceipts
 */
class ConsecutivereceiptsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $consecutivereceipts = $this->paginate($this->Consecutivereceipts);

        $this->set(compact('consecutivereceipts'));
        $this->set('_serialize', ['consecutivereceipts']);
    }

    /**
     * View method
     *
     * @param string|null $id Consecutivereceipt id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $consecutivereceipt = $this->Consecutivereceipts->get($id, [
            'contain' => []
        ]);

        $this->set('consecutivereceipt', $consecutivereceipt);
        $this->set('_serialize', ['consecutivereceipt']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;

        $consecutiveinvoice = $this->Consecutivereceipts->newEntity();
        $consecutiveinvoice->requesting_user = $this->Auth->user('username');
        
        if ($this->Consecutivereceipts->save($consecutiveinvoice)) 
        {
            $lastRecord = $this->Consecutivereceipts->find('all', ['conditions' => ['requesting_user' => $this->Auth->user('username')],
                'order' => ['Consecutivereceipts.created' => 'DESC'] ]);

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
     * @param string|null $id Consecutivereceipt id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $consecutivereceipt = $this->Consecutivereceipts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consecutivereceipt = $this->Consecutivereceipts->patchEntity($consecutivereceipt, $this->request->data);
            if ($this->Consecutivereceipts->save($consecutivereceipt)) {
                $this->Flash->success(__('The consecutivereceipt has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The consecutivereceipt could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('consecutivereceipt'));
        $this->set('_serialize', ['consecutivereceipt']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Consecutivereceipt id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consecutivereceipt = $this->Consecutivereceipts->get($id);
        if ($this->Consecutivereceipts->delete($consecutivereceipt)) {
            $this->Flash->success(__('The consecutivereceipt has been deleted.'));
        } else {
            $this->Flash->error(__('The consecutivereceipt could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
