<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Excels Controller
 *
 * @property \App\Model\Table\ExcelsTable $Excels
 */
class ExcelsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $excels = $this->paginate($this->Excels);

        $this->set(compact('excels'));
        $this->set('_serialize', ['excels']);
    }

    /**
     * View method
     *
     * @param string|null $id Excel id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $excel = $this->Excels->get($id, [
            'contain' => []
        ]);

        $this->set('excel', $excel);
        $this->set('_serialize', ['excel']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $excel = $this->Excels->newEntity();
        if ($this->request->is('post')) {
            $excel = $this->Excels->patchEntity($excel, $this->request->data);
            if ($this->Excels->save($excel)) {
                $this->Flash->success(__('The excel has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The excel could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('excel'));
        $this->set('_serialize', ['excel']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Excel id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $excel = $this->Excels->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $excel = $this->Excels->patchEntity($excel, $this->request->data);
            if ($this->Excels->save($excel)) {
                $this->Flash->success(__('The excel has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The excel could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('excel'));
        $this->set('_serialize', ['excel']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Excel id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $excel = $this->Excels->get($id);
        if ($this->Excels->delete($excel)) {
            $this->Flash->success(__('The excel has been deleted.'));
        } else {
            $this->Flash->error(__('The excel could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
