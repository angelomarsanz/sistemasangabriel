<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Excepciones Controller
 *
 * @property \App\Model\Table\ExcepcionesTable $Excepciones
 */
class ExcepcionesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $excepciones = $this->paginate($this->Excepciones);

        $this->set(compact('excepciones'));
        $this->set('_serialize', ['excepciones']);
    }

    /**
     * View method
     *
     * @param string|null $id Excepcion id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $excepcion = $this->Excepciones->get($id, [
            'contain' => []
        ]);

        $this->set('excepcion', $excepcion);
        $this->set('_serialize', ['excepcion']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $excepcion = $this->Excepciones->newEntity();
        if ($this->request->is('post')) {
            $excepcion = $this->Excepciones->patchEntity($excepcion, $this->request->data);
            if ($this->Excepciones->save($excepcion)) {
                $this->Flash->success(__('The excepcion has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The excepcion could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('excepcion'));
        $this->set('_serialize', ['excepcion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Excepcion id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $excepcion = $this->Excepciones->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $excepcion = $this->Excepciones->patchEntity($excepcion, $this->request->data);
            if ($this->Excepciones->save($excepcion)) {
                $this->Flash->success(__('The excepcion has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The excepcion could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('excepcion'));
        $this->set('_serialize', ['excepcion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Excepcion id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $excepcion = $this->Excepciones->get($id);
        if ($this->Excepciones->delete($excepcion)) {
            $this->Flash->success(__('The excepcion has been deleted.'));
        } else {
            $this->Flash->error(__('The excepcion could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }	
}