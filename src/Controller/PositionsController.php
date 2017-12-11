<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Positions Controller
 *
 * @property \App\Model\Table\PositionsTable $Positions
 */
class PositionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $query = $this->Positions->find('all')->where([['OR' => ['Positions.record_deleted IS NULL', 'Positions.record_deleted' => 0]], ['Positions.id >' => 1]])->order(['Positions.position' => 'ASC']);

        $this->set('positions', $this->paginate($query));

        $this->set(compact('positions'));
        $this->set('_serialize', ['positions']);
    }

    /**
     * View method
     *
     * @param string|null $id Position id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $position = $this->Positions->get($id, [
            'contain' => ['Employees']
        ]);

        $this->set('position', $position);
        $this->set('_serialize', ['position']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $position = $this->Positions->newEntity();
        if ($this->request->is('post')) {
            $position = $this->Positions->patchEntity($position, $this->request->data);
            if ($this->Positions->save($position)) {
                $this->Flash->success(__('El puesto de trabajo ha sido guardado exitosamente'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('El puesto de trabajo no pudo ser guardado. Intente de nuevo'));
            }
        }
        $this->set(compact('position'));
        $this->set('_serialize', ['position']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Position id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $position = $this->Positions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $position = $this->Positions->patchEntity($position, $this->request->data);
            
            $position->responsible_user = $this->Auth->user('username');
            
            if ($this->Positions->save($position)) 
            {
                $this->Flash->success(__('El puesto de trabajo ha sido guardado exitosamente'));

                return $this->redirect(['action' => 'index']);
            } 
            else 
            {
                $this->Flash->error(__('El puesto de trabajo no pudo ser guardado. Intente de nuevo'));
            }
        }
        
        $this->set(compact('position'));
        $this->set('_serialize', ['position']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Position id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $position = $this->Positions->get($id, ['contain' => ['Employees']]);
 
        if (empty($position->employees))
        {        
            $position->record_deleted = true;
            
            if ($this->Positions->save($position)) 
            {
                $this->Flash->success(__('El puesto de trabajo fue eliminado satisfactoriamente'));
            }
            else
            {
                $this->Flash->error(__('El puesto de trabajo no pudo ser eliminado. Por favor intente de nuevo'));
            }
        }
        else
        {
            $this->Flash->error(__('No se pudo eliminar el puesto de trabajo ya que existen empleados relacionados con ese puesto de trabajo'));
        }
        return $this->redirect(['action' => 'index']);
    }
}