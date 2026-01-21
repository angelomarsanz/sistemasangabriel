<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Controlnumbers Controller
 *
 * @property \App\Model\Table\ControlnumbersTable $Controlnumbers
 */
class ControlnumbersController extends AppController
{
    public function isAuthorized($user)
    {
		if(isset($user['role']))
		{
			if ($user['role'] === 'Seniat')
			{
				if(in_array($this->request->action, ['edit']))
				{
					return true;
				}				
			}
		}
        return parent::isAuthorized($user);
    }        

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $controlnumbers = $this->paginate($this->Controlnumbers);

        $this->set(compact('controlnumbers'));
        $this->set('_serialize', ['controlnumbers']);
    }

    /**
     * View method
     *
     * @param string|null $id Controlnumber id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $controlnumber = $this->Controlnumbers->get($id, [
            'contain' => []
        ]);

        $this->set('controlnumber', $controlnumber);
        $this->set('_serialize', ['controlnumber']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $controlnumber = $this->Controlnumbers->newEntity();
        if ($this->request->is('post')) {
            $controlnumber = $this->Controlnumbers->patchEntity($controlnumber, $this->request->data);
            
            $controlnumber->username = $this->Auth->user('username');
            
            if ($this->Controlnumbers->save($controlnumber)) {
                $this->Flash->success(__('The controlnumber has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The controlnumber could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('controlnumber'));
        $this->set('_serialize', ['controlnumber']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Controlnumber id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {
        $lastRecord = $this->Controlnumbers->find('all', ['conditions' => ['username' => 'adminsg'],
                'order' => ['Controlnumbers.created' => 'DESC'] ]);

        $row = $lastRecord->first();
        
        echo $row->id;
     
        $controlnumber = $this->Controlnumbers->get($row->id);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $controlnumber = $this->Controlnumbers->patchEntity($controlnumber, $this->request->data);
            if ($this->Controlnumbers->save($controlnumber)) {
                $this->Flash->success(__('El número de control fue guardado exitosamente.'));

                return $this->redirect(['controller' => 'users', 'action' => 'wait']);
            } else {
                $this->Flash->error(__('El número de control no fue guardado, intente nuevamente'));
            }
        }
        $this->set(compact('controlnumber'));
        $this->set('_serialize', ['controlnumber']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Controlnumber id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $controlnumber = $this->Controlnumbers->get($id);
        if ($this->Controlnumbers->delete($controlnumber)) {
            $this->Flash->success(__('The controlnumber has been deleted.'));
        } else {
            $this->Flash->error(__('The controlnumber could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
