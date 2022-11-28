<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Notas Controller
 *
 * @property \App\Model\Table\NotasTable $Notas
 */
class NotasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $Notas = $this->paginate($this->Notas);

        $this->set(compact('notas'));
        $this->set('_serialize', ['notas']);
    }

    /**
     * View method
     *
     * @param string|null $id Nota id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $nota = $this->Notas->get($id, [
            'contain' => []
        ]);

        $this->set('nota', $nota);
        $this->set('_serialize', ['nota']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;

        $nota = $this->Notas->newEntity();
        $nota->requesting_user = $this->Auth->user('username');
        
        if ($this->Notas->save($nota)) 
        {
            $lastRecord = $this->Notas->find('all', ['conditions' => ['requesting_user' => $this->Auth->user('username')],
                'order' => ['Notas.created' => 'DESC'] ]);

            $row = $lastRecord->first();
                
            $billId = $row['id'];

            return $billId;
        }
        else
        {
            $this->Flash->error(__('No se generó el número consecutivo para la nota de entrega, intente de nuevo'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Nota id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $nota = $this->Notas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $nota = $this->Notas->patchEntity($nota, $this->request->data);
            if ($this->Notas->save($nota)) {
                $this->Flash->success(__('The nota has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The nota could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('nota'));
        $this->set('_serialize', ['nota']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Nota id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $nota = $this->Notas->get($id);
        if ($this->Notas->delete($nota)) {
            $this->Flash->success(__('The nota has been deleted.'));
        } else {
            $this->Flash->error(__('The nota could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
