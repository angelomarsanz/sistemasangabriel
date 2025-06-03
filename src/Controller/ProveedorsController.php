<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Proveedors Controller
 *
 * @property \App\Model\Table\ProveedorsTable $Proveedors
 */
class ProveedorsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $proveedors = $this->paginate($this->Proveedors);

        $this->set(compact('proveedors'));
        $this->set('_serialize', ['proveedors']);
    }

    /**
     * View method
     *
     * @param string|null $id Proveedore id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $proveedore = $this->Proveedors->get($id, [
            'contain' => []
        ]);

        $this->set('proveedore', $proveedore);
        $this->set('_serialize', ['proveedore']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;

        $proveedore = $this->Proveedors->newEntity();
        $proveedore->requesting_user = $this->Auth->user('username');
        
        if ($this->Proveedors->save($proveedore)) 
        {
            $lastRecord = $this->Proveedors->find('all', ['conditions' => ['requesting_user' => $this->Auth->user('username')],
                'order' => ['Proveedors.created' => 'DESC'] ]);

            $row = $lastRecord->first();
                
            $billId = $row['id'];

            return $billId;
        }
        else
        {
            $this->Flash->error(__('No se generó el número consecutivo para el recibo de proveedore, intente de nuevo'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Proveedore id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $proveedore = $this->Proveedors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $proveedore = $this->Proveedors->patchEntity($proveedore, $this->request->data);
            if ($this->Proveedors->save($proveedore)) {
                $this->Flash->success(__('The proveedore has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The proveedore could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('proveedore'));
        $this->set('_serialize', ['proveedore']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Proveedore id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $proveedore = $this->Proveedors->get($id);
        if ($this->Proveedors->delete($proveedore)) {
            $this->Flash->success(__('The proveedore has been deleted.'));
        } else {
            $this->Flash->error(__('The proveedore could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function reactProveedors()
    {

    }
}