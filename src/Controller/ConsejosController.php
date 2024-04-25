<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Consejos Controller
 *
 * @property \App\Model\Table\ConsejosTable $Consejos
 */
class ConsejosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $consejos = $this->paginate($this->Consejos);

        $this->set(compact('consejos'));
        $this->set('_serialize', ['consejos']);
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
        $consejo = $this->Consejos->get($id, [
            'contain' => []
        ]);

        $this->set('consejo', $consejo);
        $this->set('_serialize', ['consejo']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;

        $consejo = $this->Consejos->newEntity();
        $consejo->requesting_user = $this->Auth->user('username');
        
        if ($this->Consejos->save($consejo)) 
        {
            $lastRecord = $this->Consejos->find('all', ['conditions' => ['requesting_user' => $this->Auth->user('username')],
                'order' => ['Consejos.created' => 'DESC'] ]);

            $row = $lastRecord->first();
                
            $billId = $row['id'];

            return $billId;
        }
        else
        {
            $this->Flash->error(__('No se generó el número consecutivo para el recibo de consejo, intente de nuevo'));
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
        $consejo = $this->Consejos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consejo = $this->Consejos->patchEntity($consejo, $this->request->data);
            if ($this->Consejos->save($consejo)) {
                $this->Flash->success(__('The consejo has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The consejo could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('consejo'));
        $this->set('_serialize', ['consejo']);
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
        $consejo = $this->Consejos->get($id);
        if ($this->Consejos->delete($consejo)) {
            $this->Flash->success(__('The consejo has been deleted.'));
        } else {
            $this->Flash->error(__('The consejo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
