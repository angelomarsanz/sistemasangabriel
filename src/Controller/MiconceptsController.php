<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Miconcepts Controller
 *
 * @property \App\Model\Table\MiconceptsTable $Miconcepts
 */
class MiconceptsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $miconcepts = $this->paginate($this->Miconcepts);

        $this->set(compact('miconcepts'));
        $this->set('_serialize', ['miconcepts']);
    }

    /**
     * View method
     *
     * @param string|null $id Miconcept id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $miconcept = $this->Miconcepts->get($id, [
            'contain' => []
        ]);

        $this->set('miconcept', $miconcept);
        $this->set('_serialize', ['miconcept']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $miconcept = $this->Miconcepts->newEntity();
        if ($this->request->is('post')) {
            $miconcept = $this->Miconcepts->patchEntity($miconcept, $this->request->data);
            if ($this->Miconcepts->save($miconcept)) {
                $this->Flash->success(__('The miconcept has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The miconcept could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('miconcept'));
        $this->set('_serialize', ['miconcept']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Miconcept id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $miconcept = $this->Miconcepts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $miconcept = $this->Miconcepts->patchEntity($miconcept, $this->request->data);
            if ($this->Miconcepts->save($miconcept)) {
                $this->Flash->success(__('The miconcept has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The miconcept could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('miconcept'));
        $this->set('_serialize', ['miconcept']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Miconcept id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $miconcept = $this->Miconcepts->get($id);
        if ($this->Miconcepts->delete($miconcept)) {
            $this->Flash->success(__('The miconcept has been deleted.'));
        } else {
            $this->Flash->error(__('The miconcept could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function migrateConcepts()
    {
        $this->loadModel('Bills');
        
        $this->loadModel('Concepts');
        
        $miConcepts = $this->Miconcepts->find('all')->order(['Miconcepts.idd' => 'ASC']);
        
        $results = $miConcepts->toArray();
        
        $newBill = " "; 
    
        foreach ($results as $result) 
        {
            if ($result->idd != $newBill)
            {
                $lastRecord = $this->Bills->find('all', ['conditions' => ['bill_number' => $result->idd],
                    'order' => ['Bills.created' => 'DESC'] ]);
    
                $row = $lastRecord->first();
                if (!(isset($row)))
                {
                    echo "Factura no encontrada: " . $result->idd;                    
                }
                $newBill = $result->idd;
            }
            $concepts = $this->Concepts->newEntity();
            $concepts->bill_id = $row->id;
            $concepts->quantity = 1;
            $concepts->accounting_code = $result->codigo_art;
            $concepts->student_name = " ";
            $concepts->transaction_identifier = 0;
            $concepts->concept = $result->descripcion;
            $concepts->amount = $result->total;
            $concepts->observation = "Migración";
            $concepts->annulled = 0;
            $concepts->concept_migration = 1;
            
            if (!($this->Concepts->save($concepts)))
            {
                $this->Flash->error(__('El concepto de la factura no pudo ser guardado, intente nuevamente'));
            }
        }
    }
}