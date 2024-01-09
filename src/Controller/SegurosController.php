<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Seguros Controller
 *
 * @property \App\Model\Table\SegurosTable $Seguros
 */
class SegurosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $seguros = $this->paginate($this->Seguros);

        $this->set(compact('seguros'));
        $this->set('_serialize', ['seguros']);
    }

    /**
     * View method
     *
     * @param string|null $id Seguro id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $seguro = $this->Seguros->get($id, [
            'contain' => []
        ]);

        $this->set('seguro', $seguro);
        $this->set('_serialize', ['seguro']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;

        $seguro = $this->Seguros->newEntity();
        $seguro->requesting_user = $this->Auth->user('username');
        
        if ($this->Seguros->save($seguro)) 
        {
            $lastRecord = $this->Seguros->find('all', ['conditions' => ['requesting_user' => $this->Auth->user('username')],
                'order' => ['Seguros.created' => 'DESC'] ]);

            $row = $lastRecord->first();
                
            $billId = $row['id'];

            return $billId;
        }
        else
        {
            $this->Flash->error(__('No se generó el número consecutivo para el recibo de seguro, intente de nuevo'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Seguro id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seguro = $this->Seguros->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seguro = $this->Seguros->patchEntity($seguro, $this->request->data);
            if ($this->Seguros->save($seguro)) {
                $this->Flash->success(__('The seguro has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The seguro could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('seguro'));
        $this->set('_serialize', ['seguro']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Seguro id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seguro = $this->Seguros->get($id);
        if ($this->Seguros->delete($seguro)) {
            $this->Flash->success(__('The seguro has been deleted.'));
        } else {
            $this->Flash->error(__('The seguro could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
