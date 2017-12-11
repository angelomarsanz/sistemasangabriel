<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Teachingareas Controller
 *
 * @property \App\Model\Table\TeachingareasTable $Teachingareas
 */
class TeachingareasController extends AppController
{
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['testComunicationSend', 'testComunicationReceives']);
    }

    public function testComunicationSend()
    {
        
    }
    
    public function testComunicationReceives()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) 
        {
            $jsondata = [];

            $teachingarea = $this->Teachingareas->newEntity();
        
            $teachingarea->description_teaching_area = $_POST['descriptionTeachingArea'];

            if ($this->Teachingareas->save($teachingarea)) 
            {
                $jsondata["success"] = true;
                $jsondata["data"] = 'El área de enseñanza se creó el usuario';
            }
            else
            {
                $jsondata["success"] = false;
                $jsondata["data"] = 'No se pudo crear el área de enseñanza';
            }

            exit(json_encode($jsondata, JSON_FORCE_OBJECT));
        }        
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $teachingareas = $this->paginate($this->Teachingareas);

        $this->set(compact('teachingareas'));
        $this->set('_serialize', ['teachingareas']);
    }

    /**
     * View method
     *
     * @param string|null $id Teachingarea id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $teachingarea = $this->Teachingareas->get($id, [
            'contain' => ['Employees']
        ]);

        $this->set('teachingarea', $teachingarea);
        $this->set('_serialize', ['teachingarea']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $teachingarea = $this->Teachingareas->newEntity();
        if ($this->request->is('post')) {
            $teachingarea = $this->Teachingareas->patchEntity($teachingarea, $this->request->data);
            if ($this->Teachingareas->save($teachingarea)) {
                $this->Flash->success(__('The teachingarea has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The teachingarea could not be saved. Please, try again.'));
            }
        }
        $employees = $this->Teachingareas->Employees->find('list', ['limit' => 200])->order(['Employees.surname' => 'ASC',
            'Employees.second_surname' => 'ASC', 'Employees.first_name' => 'ASC', 'Employees.second_surname' => 'ASC']);
        
        $this->set(compact('teachingarea', 'employees'));
        $this->set('_serialize', ['teachingarea']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Teachingarea id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $teachingarea = $this->Teachingareas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $teachingarea = $this->Teachingareas->patchEntity($teachingarea, $this->request->data);
            if ($this->Teachingareas->save($teachingarea)) {
                $this->Flash->success(__('The teachingarea has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The teachingarea could not be saved. Please, try again.'));
            }
        }
        $employees = $this->Teachingareas->Employees->find('list', ['limit' => 200])->order(['Employees.surname' => 'ASC',
            'Employees.second_surname' => 'ASC', 'Employees.first_name' => 'ASC', 'Employees.second_surname' => 'ASC']);
        
        $this->set(compact('teachingarea', 'employees'));
        $this->set('_serialize', ['teachingarea']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Teachingarea id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $teachingarea = $this->Teachingareas->get($id);
        if ($this->Teachingareas->delete($teachingarea)) {
            $this->Flash->success(__('The teachingarea has been deleted.'));
        } else {
            $this->Flash->error(__('The teachingarea could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}