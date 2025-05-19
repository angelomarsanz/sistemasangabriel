<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Proveedores Controller
 *
 * @property \App\Model\Table\ProveedoresTable $Proveedores
 */
class ProveedoresController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $proveedores = $this->paginate($this->Proveedores);

        $this->set(compact('proveedores'));
        $this->set('_serialize', ['proveedores']);
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
        $proveedore = $this->Proveedores->get($id, [
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

        $proveedore = $this->Proveedores->newEntity();
        $proveedore->requesting_user = $this->Auth->user('username');
        
        if ($this->Proveedores->save($proveedore)) 
        {
            $lastRecord = $this->Proveedores->find('all', ['conditions' => ['requesting_user' => $this->Auth->user('username')],
                'order' => ['Proveedores.created' => 'DESC'] ]);

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
        $proveedore = $this->Proveedores->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $proveedore = $this->Proveedores->patchEntity($proveedore, $this->request->data);
            if ($this->Proveedores->save($proveedore)) {
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
        $proveedore = $this->Proveedores->get($id);
        if ($this->Proveedores->delete($proveedore)) {
            $this->Flash->success(__('The proveedore has been deleted.'));
        } else {
            $this->Flash->error(__('The proveedore could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
