<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\StudenttransactionsController;

use App\Controller\BinnaclesController;

/**
 * Concepts Controller
 *
 * @property \App\Model\Table\ConceptsTable $Concepts
 */
class ConceptsController extends AppController
{
    public function testFunction()
    {
		$contador = 0;
		$contadorRegistros = 0;
		
		$month = '07';
		$year = '2019';
		
		$conceptos = $this->Concepts->find('all', ['conditions' => 
			[['concept' => 'Servicio educativo 2019'],
			['MONTH(created)' => $month], 
			['YEAR(created)' => $year],
			['annulled' => false]],
			'order' => ['id' => 'ASC'] ]);
			
		$contadorRegistros = $conceptos->count();
		
		$this->Flash->success(__('Total registros encontrados: ' . $contadorRegistros));
				
		if ($contadorRegistros > 0)
		{		
			foreach ($conceptos as $concepto)
			{
				$this->Flash->success(__('Concepto: ' . $concepto->concept));
			}
		}
				
		$this->Flash->success(__('Registros actualizados ' . $contador));	
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $concepts = $this->paginate($this->Concepts);

        $this->set(compact('concepts'));
        $this->set('_serialize', ['concepts']);
    }

    /**
     * View method
     *
     * @param string|null $id Concept id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $concept = $this->Concepts->get($id, [
            'contain' => []
        ]);

        $this->set('concept', $concept);
        $this->set('_serialize', ['concept']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($billId = null, $studentName = null, $transactionIdentifier = null, 
        $monthlyPayment = null, $amountPayable = null, $observation = null, $fiscal = null)
    {
        $concept = $this->Concepts->newEntity();
        $concept->bill_id = $billId;
        $concept->quantity = 1;
        $concept->accounting_code = "001";
        $concept->student_name = $studentName;
        $concept->transaction_identifier = $transactionIdentifier;
        $concept->concept = $monthlyPayment;
        $concept->amount = $amountPayable;
        $concept->observation = $observation;
        $concept->annulled = 0;
		$concept->concept_migration = 1;
		
		if ($fiscal == 0)
		{
			if (substr($monthlyPayment, 0, 10) == "Matrícula" || substr($monthlyPayment, 0, 14) == "Seguro escolar" || substr($monthlyPayment, 0, 3) == "Ago")
			{
				$concept->concept_migration = 0;
			}
		}

        if (!($this->Concepts->save($concept)))
        {
            $this->Flash->error(__('El concepto de la factura no pudo ser guardado, intente nuevamente'));
        }
        else
        {
            return;
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Concept id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($idBill = null, $billNumber = null)
    {
        $this->autoRender = false;
        
        $studentTransactions = new StudenttransactionsController();
        
        $concepts = $this->Concepts->find('all')->where(['bill_id' => $idBill]);
    
        $aConcepts = $concepts->toArray();
			    
        foreach ($aConcepts as $aConcept) 
        {    
            $concept = $this->Concepts->get($aConcept->id);
            
            $concept->annulled = 1;
            
            if (!($this->Concepts->save($concept))) 
            {
                $this->Flash->error(__('El concepto de la factura no pudo ser anulado'));
            }
            else
            {
                $studentTransactions->reverseTransaction($concept->transaction_identifier, $concept->amount, $billNumber);   
            }
        }
        return;
    }

    /**
     * Delete method
     *
     * @param string|null $id Concept id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $concept = $this->Concepts->get($id);
        if ($this->Concepts->delete($concept)) {
            $this->Flash->success(__('The concept has been deleted.'));
        } else {
            $this->Flash->error(__('The concept could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
    public function monetaryReconversion()
    {				
		$binnacles = new BinnaclesController;
	
		$concepts = $this->Concepts->find('all', ['conditions' => ['id >' => 0]]);
	
		$account1 = $concepts->count();
			
		$account2 = 0;
		
		foreach ($concepts as $concept)
        {		
			$conceptGet = $this->Concepts->get($concept->id);
			
			$previousAmount = $conceptGet->amount;
										
			$conceptGet->amount = $previousAmount / 100000;
					
			if ($this->Concepts->save($conceptGet))
			{
				$account2++;
			}
			else
			{
				$binnacles->add('controller', 'Concepts', 'monetaryReconversion', 'No se actualizó registro con id: ' . $conceptGet->id);
			}
		}

		$binnacles->add('controller', 'Concepts', 'monetaryReconversion', 'Total registros seleccionados: ' . $account1);
		$binnacles->add('controller', 'Concepts', 'monetaryReconversion', 'Total registros actualizados: ' . $account2);

		return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
	}	
}