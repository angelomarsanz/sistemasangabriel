<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Sections Controller
 *
 * @property \App\Model\Table\SectionsTable $Sections
 */
class SectionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $sections = $this->paginate($this->Sections);

        $this->set(compact('sections'));
        $this->set('_serialize', ['sections']);
    }

    /**
     * View method
     *
     * @param string|null $id Section id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $section = $this->Sections->get($id, [
            'contain' => ['Students', 'Employees']
        ]);

        $this->set('section', $section);
        $this->set('_serialize', ['section']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $section = $this->Sections->newEntity();
        if ($this->request->is('post')) {
            $section = $this->Sections->patchEntity($section, $this->request->data);

            $section->registered_students = 0;

            if ($this->Sections->save($section)) {
                $this->Flash->success(__('The section has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The section could not be saved. Please, try again.'));
            }
        }

        $employees = $this->Sections->Employees->find('list', ['limit' => 200]);
        
        $this->set(compact('section', 'employees'));
        $this->set('_serialize', ['section']);

    }

    /**
     * Edit method
     *
     * @param string|null $id Section id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $section = $this->Sections->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $section = $this->Sections->patchEntity($section, $this->request->data);

            $section->registered_students = 0;

            if ($this->Sections->save($section)) {
                $this->Flash->success(__('The section has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The section could not be saved. Please, try again.'));
            }
        }

        $employees = $this->Sections->Employees->find('list', ['limit' => 200]);
        
        $this->set(compact('section', 'employees'));
        $this->set('_serialize', ['section']);

    }

    /**
     * Delete method
     *
     * @param string|null $id Section id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $section = $this->Sections->get($id);
        if ($this->Sections->delete($section)) {
            $this->Flash->success(__('The section has been deleted.'));
        } else {
            $this->Flash->error(__('The section could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function addLot()
    {
        $section = $this->Sections->newEntity();
        $section->level = "No asignado";
        $section->sublevel = "No asignado";
        $section->section = "No asignada";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Pre-escolar";
        $section->sublevel = "Kinder";
        $section->section = "A";
        $section->maximum_amount = 20;
        $this->addRecord($section);

        $section = $this->Sections->newEntity();
        $section->level = "Pre-escolar";
        $section->sublevel = "Kinder";
        $section->section = "B";
        $section->maximum_amount = 20;
        $this->addRecord($section);

        $section = $this->Sections->newEntity();
        $section->level = "Pre-escolar";
        $section->sublevel = "Kinder";
        $section->section = "C";
        $section->maximum_amount = 20;
        $this->addRecord($section);

        $section = $this->Sections->newEntity();
        $section->level = "Pre-escolar";
        $section->sublevel = "Pre-kinder";
        $section->section = "A";
        $section->maximum_amount = 20;
        $this->addRecord($section);

        $section = $this->Sections->newEntity();
        $section->level = "Pre-escolar";
        $section->sublevel = "Pre-kinder";
        $section->section = "B";
        $section->maximum_amount = 20;
        $this->addRecord($section);

        $section = $this->Sections->newEntity();
        $section->level = "Pre-escolar";
        $section->sublevel = "Pre-kinder";
        $section->section = "C";
        $section->maximum_amount = 20;
        $this->addRecord($section);

        $section = $this->Sections->newEntity();
        $section->level = "Pre-escolar";
        $section->sublevel = "Preparatorio";
        $section->section = "A";
        $section->maximum_amount = 20;
        $this->addRecord($section);

        $section = $this->Sections->newEntity();
        $section->level = "Pre-escolar";
        $section->sublevel = "Preparatorio";
        $section->section = "B";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Pre-escolar";
        $section->sublevel = "Preparatorio";
        $section->section = "C";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "1er. Grado";
        $section->section = "A";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "1er. Grado";
        $section->section = "B";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "1er. Grado";
        $section->section = "C";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "2do. Grado";
        $section->section = "A";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "2do. Grado";
        $section->section = "B";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "2do. Grado";
        $section->section = "C";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "3er. Grado";
        $section->section = "A";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "3er. Grado";
        $section->section = "B";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "3er. Grado";
        $section->section = "C";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "4to. Grado";
        $section->section = "A";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "4to. Grado";
        $section->section = "B";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "4to. Grado";
        $section->section = "C";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "5to. Grado";
        $section->section = "A";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "5to. Grado";
        $section->section = "B";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "5to. Grado";
        $section->section = "C";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "6to. Grado";
        $section->section = "A";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "6to. Grado";
        $section->section = "B";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Primaria";
        $section->sublevel = "6to. Grado";
        $section->section = "C";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "1er. Año";
        $section->section = "A";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "1er. Año";
        $section->section = "B";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "1er. Año";
        $section->section = "C";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "2do. Año";
        $section->section = "A";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "2do. Año";
        $section->section = "B";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "2do. Año";
        $section->section = "C";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "3er. Año";
        $section->section = "A";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "3er. Año";
        $section->section = "B";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "3er. Año";
        $section->section = "C";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "4to. Año";
        $section->section = "A";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "4to. Año";
        $section->section = "B";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "4to. Año";
        $section->section = "C";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "5to. Año";
        $section->section = "A";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "5to. Año";
        $section->section = "B";
        $section->maximum_amount = 20;
        $this->addRecord($section);
        
        $section = $this->Sections->newEntity();
        $section->level = "Secundaria";
        $section->sublevel = "5to. Año";
        $section->section = "C";
        $section->maximum_amount = 20;
        $this->addRecord($section);

    }

    public function addRecord($section = null)
    {
        if ($this->Sections->save($section)) 
        {
            $this->Flash->success(__('The section has been saved.'));

            return $this->redirect(['action' => 'index']);
        }
        else 
        {
            $this->Flash->error(__('The section could not be saved. Please, try again.'));
        }        
    }
}