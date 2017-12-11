<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Miparentsandguardians Controller
 *
 * @property \App\Model\Table\MiparentsandguardiansTable $Miparentsandguardians
 */
class MiparentsandguardiansController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $miparentsandguardians = $this->paginate($this->Miparentsandguardians);

        $this->set(compact('miparentsandguardians'));
        $this->set('_serialize', ['miparentsandguardians']);
    }

    /**
     * View method
     *
     * @param string|null $id Miparentsandguardian id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $miparentsandguardian = $this->Miparentsandguardians->get($id, [
            'contain' => []
        ]);

        $this->set('miparentsandguardian', $miparentsandguardian);
        $this->set('_serialize', ['miparentsandguardian']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $miparentsandguardian = $this->Miparentsandguardians->newEntity();
        if ($this->request->is('post')) {
            $miparentsandguardian = $this->Miparentsandguardians->patchEntity($miparentsandguardian, $this->request->data);
            if ($this->Miparentsandguardians->save($miparentsandguardian)) {
                $this->Flash->success(__('The miparentsandguardian has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The miparentsandguardian could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('miparentsandguardian'));
        $this->set('_serialize', ['miparentsandguardian']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Miparentsandguardian id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $miparentsandguardian = $this->Miparentsandguardians->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $miparentsandguardian = $this->Miparentsandguardians->patchEntity($miparentsandguardian, $this->request->data);
            if ($this->Miparentsandguardians->save($miparentsandguardian)) {
                $this->Flash->success(__('The miparentsandguardian has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The miparentsandguardian could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('miparentsandguardian'));
        $this->set('_serialize', ['miparentsandguardian']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Miparentsandguardian id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $miparentsandguardian = $this->Miparentsandguardians->get($id);
        if ($this->Miparentsandguardians->delete($miparentsandguardian)) {
            $this->Flash->success(__('The miparentsandguardian has been deleted.'));
        } else {
            $this->Flash->error(__('The miparentsandguardian could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
