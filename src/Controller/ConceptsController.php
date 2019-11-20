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
		$vectorPagos = [];
	
		$conceptos = $this->Concepts->find('all')
			->contain(['Bills'])
			->where(['Bills.annulled' => 0, 'Concepts.concept' => 'Ago 2019', 'Bills.date_and_time >=' => '2019-06-15'])
			->order(['Concepts.bill_id' => 'ASC']);
			
		$contadorConceptos = $conceptos->count();
		
		$this->Flash->success(__('Contador conceptos ' . $contadorConceptos));
			
		if ($contadorConceptos > 0)
		{
			foreach ($conceptos as $concepto)
			{	
				$montoConcepto = round($concepto->amount / $concepto->bill->tasa_cambio);
				
				if ($montoConcepto != 25)
				{
					$vectorPagos[] = ['factura' => $concepto->bill->bill_number, 'monto' => $montoConcepto];
					$contador++;
				}
			}
		}
		$this->Flash->success(__('Total facturas con error ' . $contador));
		
        $this->set(compact('vectorPagos'));
        $this->set('_serialize', ['vectorPagos']);
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
    public function add($billId = null, $transaccion = null, $fiscal = null)
    {
        $concept = $this->Concepts->newEntity();
        $concept->bill_id = $billId;
        $concept->quantity = 1;
        $concept->accounting_code = "001";
        $concept->student_name = $transaccion->studentName;
        $concept->transaction_identifier = $transaccion->transactionIdentifier;
        $concept->concept = $transaccion->monthlyPayment;
        $concept->amount = $transaccion->montoAPagarBolivar;
        $concept->observation = $transaccion->observation;
        $concept->annulled = 0;
		$concept->concept_migration = 0;		
		$concept->saldo = $transaccion->montoAPagarBolivar;

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
    public function edit($idBill = null, $billNumber = null, $tasaCambio = null)
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
                $studentTransactions->reverseTransaction($concept->transaction_identifier, $concept->amount, $billNumber, $tasaCambio);   
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
	
    public function agregarConceptosNota($idConcepto = null, $montoNota = null, $numeroNotaContable = null, $tipoNota = null, $idNota = null, $tasaCambio = null)
    {
		$codigoRetornoConcepto = 0;
		
		$conceptoFactura = $this->Concepts->get($idConcepto);
		
		if ($tipoNota == "Crédito")
		{
			$conceptoFactura->saldo -= round($montoNota/$tasaCambio); 
		}
		else
		{
			$conceptoFactura->saldo += round($montoNota/$tasaCambio);
		}
		
		if (!($this->Concepts->save($conceptoFactura)))
		{
			$codigoRetornoConcepto = 1;	
			$this->Flash->error(__('El concepto con ID ' . $concepto->id . ' no pudo ser actualizado'));
		}
		else
		{			
			$conceptoNota = $this->Concepts->newEntity();
			$conceptoNota->bill_id = $idNota;
			$conceptoNota->quantity = 1;
			$conceptoNota->accounting_code = "001";
			$conceptoNota->student_name = $conceptoFactura->student_name;
			$conceptoNota->transaction_identifier = $conceptoFactura->transaction_identifier;
			$conceptoNota->concept = $conceptoFactura->concept;
			$conceptoNota->amount = $montoNota;
			$conceptoNota->observation = $conceptoFactura->observation;
			$conceptoNota->annulled = 0;
			$conceptoNota->concept_migration = 1;
			$conceptoNota->saldo = round($montoNota/$tasaCambio);
			
			if (!($this->Concepts->save($conceptoNota)))
			{
				$codigoRetornoConcepto = 1;
				$this->Flash->error(__('El concepto de la nota no pudo ser guardado, intente nuevamente'));
			}
		}
        return $codigoRetornoConcepto;
	}
	
	public function conceptosReciboFactura($idReciboPendiente = null, $idFacturaNueva = null)
	{
		$codigoRetorno = 0;
		
		$conceptos = $this->Concepts->find('all', ['conditions' => ['bill_id' => $idReciboPendiente, 'SUBSTRING(concept, 1, 18) !=' => 'Servicio educativo'], 'order' => ['created' => 'ASC']]);
		
		foreach ($conceptos as $concepto)
		{
			$conceptoNuevo = $this->Concepts->newEntity();
			$conceptoNuevo->bill_id = $idFacturaNueva;
			$conceptoNuevo->quantity = 1;
			$conceptoNuevo->accounting_code = "001";
			$conceptoNuevo->student_name = $concepto->student_name;
			$conceptoNuevo->transaction_identifier = $concepto->transaction_identifier;
			$conceptoNuevo->concept = $concepto->concept;
			$conceptoNuevo->amount = $concepto->amount;
			$conceptoNuevo->observation = $concepto->observation;
			$conceptoNuevo->annulled = 0;
			$conceptoNuevo->concept_migration = 0;		
			$conceptoNuevo->saldo = $concepto->saldo;

			if (!($this->Concepts->save($conceptoNuevo)))
			{
				$binnacles = new BinnaclesController;
				
				$binnacles->add('controller', 'Concepts', 'conceptosReciboFactura', 'El concepto correspondiente a la factura con ID ' . $idFacturaNueva . ' no fue guardado');
				
				$this->Flash->error(__('El concepto de la factura con ID ' . $idFacturaNueva . ' no pudo ser guardado, intente nuevamente'));
				$codigoRetorno = 1;
				break;
			}
		}
		return $codigoRetorno;
	}
	
	public function conceptosReciboCredito($idRecibo = null, $monto = null)
	{
		$codigoRetorno = 0;
		
		$conceptoNuevo = $this->Concepts->newEntity();
		$conceptoNuevo->bill_id = $idRecibo;
		$conceptoNuevo->quantity = 1;
		$conceptoNuevo->accounting_code = "001";
		$conceptoNuevo->student_name = "";
		$conceptoNuevo->transaction_identifier = 999999;
		$conceptoNuevo->concept = "Saldo a favor";
		$conceptoNuevo->amount = $monto;
		$conceptoNuevo->observation = "";
		$conceptoNuevo->annulled = 0;
		$conceptoNuevo->concept_migration = 0;		
		$conceptoNuevo->saldo = $monto;

		if (!($this->Concepts->save($conceptoNuevo)))
		{
			$binnacles = new BinnaclesController;
			
			$binnacles->add('controller', 'Concepts', 'conceptosReciboCredito', 'El concepto correspondiente al recibo con ID ' . $idRecibo . ' no fue guardado');
			
			$this->Flash->error(__('El concepto del recibo con ID ' . $idRecibo . ' no pudo ser guardado, intente nuevamente'));
			$codigoRetorno = 1;
		}
		
		return $codigoRetorno;
	}
	public function conceptosReciboReintegro($idRecibo = null, $monto = null)
	{
		$codigoRetorno = 0;
		
		$conceptoNuevo = $this->Concepts->newEntity();
		$conceptoNuevo->bill_id = $idRecibo;
		$conceptoNuevo->quantity = 1;
		$conceptoNuevo->accounting_code = "001";
		$conceptoNuevo->student_name = "";
		$conceptoNuevo->transaction_identifier = 999999;
		$conceptoNuevo->concept = "Reintegro";
		$conceptoNuevo->amount = $monto;
		$conceptoNuevo->observation = "";
		$conceptoNuevo->annulled = 0;
		$conceptoNuevo->concept_migration = 0;		
		$conceptoNuevo->saldo = $monto;

		if (!($this->Concepts->save($conceptoNuevo)))
		{
			$binnacles = new BinnaclesController;
			
			$binnacles->add('controller', 'Concepts', 'conceptosReciboCredito', 'El concepto correspondiente al recibo con ID ' . $idRecibo . ' no fue guardado');
			
			$this->Flash->error(__('El concepto del recibo con ID ' . $idRecibo . ' no pudo ser guardado, intente nuevamente'));
			$codigoRetorno = 1;
		}
		
		return $codigoRetorno;
	}
}