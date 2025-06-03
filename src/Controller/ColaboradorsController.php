<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Colaboradors Controller
 *
 * @property \App\Model\Table\ColaboradorsTable $Colaboradors
 */
class ColaboradorsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $colaboradors = $this->paginate($this->Colaboradors);

        $this->set(compact('colaboradors'));
        $this->set('_serialize', ['colaboradors']);
    }

    /**
     * View method
     *
     * @param string|null $id Colaborador id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $colaborador = $this->Colaboradors->get($id, [
            'contain' => []
        ]);

        $this->set('colaborador', $colaborador);
        $this->set('_serialize', ['colaborador']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;

        $colaborador = $this->Colaboradors->newEntity();
        $colaborador->requesting_user = $this->Auth->user('username');
        
        if ($this->Colaboradors->save($colaborador)) 
        {
            $lastRecord = $this->Colaboradors->find('all', ['conditions' => ['requesting_user' => $this->Auth->user('username')],
                'order' => ['Colaboradors.created' => 'DESC'] ]);

            $row = $lastRecord->first();
                
            $billId = $row['id'];

            return $billId;
        }
        else
        {
            $this->Flash->error(__('No se generó el número consecutivo para el recibo de colaborador, intente de nuevo'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Colaborador id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $colaborador = $this->Colaboradors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $colaborador = $this->Colaboradors->patchEntity($colaborador, $this->request->data);
            if ($this->Colaboradors->save($colaborador)) {
                $this->Flash->success(__('The colaborador has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The colaborador could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('colaborador'));
        $this->set('_serialize', ['colaborador']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Colaborador id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $colaborador = $this->Colaboradors->get($id);
        if ($this->Colaboradors->delete($colaborador)) {
            $this->Flash->success(__('The colaborador has been deleted.'));
        } else {
            $this->Flash->error(__('The colaborador could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
