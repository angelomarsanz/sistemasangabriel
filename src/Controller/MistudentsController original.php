<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Mistudents Controller
 *
 * @property \App\Model\Table\MistudentsTable $Mistudents
 */
class MistudentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $mistudents = $this->paginate($this->Mistudents);

        $this->set(compact('mistudents'));
        $this->set('_serialize', ['mistudents']);
    }

    /**
     * View method
     *
     * @param string|null $id Mistudent id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mistudent = $this->Mistudents->get($id, [
            'contain' => []
        ]);

        $this->set('mistudent', $mistudent);
        $this->set('_serialize', ['mistudent']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mistudent = $this->Mistudents->newEntity();
        if ($this->request->is('post')) {
            $mistudent = $this->Mistudents->patchEntity($mistudent, $this->request->data);
            if ($this->Mistudents->save($mistudent)) {
                $this->Flash->success(__('The mistudent has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The mistudent could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('mistudent'));
        $this->set('_serialize', ['mistudent']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Mistudent id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mistudent = $this->Mistudents->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mistudent = $this->Mistudents->patchEntity($mistudent, $this->request->data);
            if ($this->Mistudents->save($mistudent)) {
                $this->Flash->success(__('The mistudent has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The mistudent could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('mistudent'));
        $this->set('_serialize', ['mistudent']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Mistudent id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mistudent = $this->Mistudents->get($id);
        if ($this->Mistudents->delete($mistudent)) {
            $this->Flash->success(__('The mistudent has been deleted.'));
        } else {
            $this->Flash->error(__('The mistudent could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
