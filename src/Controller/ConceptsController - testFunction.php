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
		/* $this->loadModel('Excels');
		$this->loadModel('Studenttransactions');
				
		$conceptos = $this->Concepts->find('all')
			->contain(['Bills' => ['Parentsandguardians']])
			->where(['Concepts.concept' => "Matrícula 2019"])
			->order(['Concepts.bill_id' => 'ASC']);
			
		$idAnterior = 0;
		$contadorGuardadas = 0;
		$contadorNoGuardadas = 0;
		$contadorDiferentes = 0;
		$contadorDolarCero = 0;
		
		$vectorPagos = [];
	
		foreach ($conceptos as $concepto)
		{
			if ($idAnterior != $concepto->bill_id)
			{
				$transaccion = $this->Studenttransactions->get($concepto->transaction_identifier);
				
				if ($transaccion->amount_dollar != null && $transaccion->amount_dollar > 0)
				{
					$montoConceptoRedondeado = round($concepto->amount);
				
					if ($transaccion->amount == $montoConceptoRedondeado)
					{
						$tasaDolar = $transaccion->amount / $transaccion->amount_dollar;
						
						$excel = $this->Excels->newEntity();
											
						$excel->number = $concepto->bill_id;
						$excel->col1 = $tasaDolar;
						
						if (!($this->Excels->save($excel)))
						{
							$this->Flash->success(__('La Factura no pudo se actualizada'));;
							$contadorNoGuardadas++;
						}
						else
						{
							$contadorGuardadas++;								
							$vectorPagos[] = ['idFactura' => $concepto->bill_id, 'tasaDolar' => $tasaDolar];  
						}
					}
					else
					{
						$contadorDiferentes++;
					}
				}
				else
				{
					$contadorDolarCero++;
				}
			}
			$idAnterior = $concepto->bill_id;
		}
		
		$this->Flash->success(__('Total facturas guardada: ' . $contadorGuardadas));
		$this->Flash->success(__('Total facturas no guardada: ' . $contadorNoGuardadas));
		$this->Flash->error(__('Total montos diferentes: ' . $contadorDiferentes));
		$this->Flash->success(__('Total monto cero: ' . $contadorDolarCero));
					
        $this->set(compact('vectorPagos'));
        $this->set('_serialize', ['vectorPagos']);
		
		$this->loadModel('Excels');
	
		$excels = $this->Excels->find('all');
		
		$contadorActualizadas = 0;
		$contadorYaActualizadas = 0;
		$vectorPagos = [];
		
		foreach ($excels as $excel)
		{						
			$factura = $this->Concepts->Bills->get($excel->number);
			
			if ($factura->tasa_cambio == 1)
			{
				$factura->tasa_cambio = $excel->col1;
				
				if (!($this->Concepts->Bills->save($factura)))
				{
					$this->Flash->error(__('La factura Nro. ' . $factura->bill_number . ' no pudo ser actualizada'));
				}
				else
				{
					$vectorPagos[] = 
						['nroFactura' => $excel->number, 
						'tasaCambio' => $excel->col1];  
					$contadorActualizadas++;
				} 
			}
			else
			{
				$contadorYaActualizadas++;
			}
		}
		
		$this->Flash->success(__('Facturas actualizadas ' . $contadorActualizadas));
		$this->Flash->error(__('Facturas ya actualizadas ' . $contadorYaActualizadas));
		
        $this->set(compact('vectorPagos'));
        $this->set('_serialize', ['vectorPagos']);  
					
		$conceptos = $this->Concepts->find('all')
			->contain(['Bills' => ['Parentsandguardians']])
			->where(['Concepts.created >=' => '2019-09-01', 'Concepts.annulled' => 0])
			->order(['Concepts.bill_id' => 'ASC']);
			
		$contador = 0;
		$idAnterior = 0;
		$facturasSinActualizar = 0;
		
		$vectorPagos = [];
	
		foreach ($conceptos as $concepto)
		{
			if ($idAnterior != $concepto->bill_id)
			{
				$factura = $this->Concepts->Bills->get($concepto->bill_id);
			
				if ($factura->tasa_cambio == 1)
				{
					$vectorPagos[] = 
						['idFactura' => $factura->id,
						'nroFactura' => $factura->bill_number];  
					$facturasSinActualizar++;
				}
			}
			$idAnterior = $concepto->bill_id;
			if ($contador > 5)
			{
				break;
			}
		}
		
		$this->Flash->success(__('Total facturas sin actualizar: ' . $facturasSinActualizar));
					
        $this->set(compact('vectorPagos'));
        $this->set('_serialize', ['vectorPagos']);
		
		$this->loadModel('Studenttransactions');
		
		$conceptos = $this->Concepts->find('all')
			->contain(['Bills' => ['Parentsandguardians']])
			->where(['Concepts.created >=' => '2019-09-01', 'Concepts.annulled' => 0, 'Bills.tasa_cambio' => 1])
			->order(['Concepts.bill_id' => 'ASC']);
			
		$facturasSinActualizar = 0;
		
		$vectorPagos = [];
		$idAnterior = 0;
	
		foreach ($conceptos as $concepto)
		{
			$transaccion = $this->Studenttransactions->get($concepto->transaction_identifier);
			
			if ($idAnterior != $concepto->bill_id)
			{
				$vectorPagos[] = 
					['nroFactura' => $concepto->bill->bill_number,
					'idFactura' => $concepto->bill->id,
					'fechaFactura' => $concepto->bill->date_and_time,
					'alumno' => $concepto->student_name,
					'concepto' => $concepto->concept,
					'montoConcepto' => $concepto->amount,
					'descripcionTransaccion' => $transaccion->transaction_description,
					'montoOriginal' => $transaccion->original_amount,
					'montoAbonado' => $transaccion->amount,
					'montoDolar' => $transaccion->amount_dollar,
					'indicadorPagado' => $transaccion->paid_out,
					'pagoParcial' => $transaccion->partial_payment];  
				
				$facturasSinActualizar++;
			}
			$idAnterior = $concepto->bill_id;
		}
		
		$this->Flash->success(__('Total facturas sin actualizar: ' . $facturasSinActualizar));
					
        $this->set(compact('vectorPagos'));
        $this->set('_serialize', ['vectorPagos']); 

		$this->loadModel('Studenttransactions');
		
		$conceptos = $this->Concepts->find('all')
			->contain(['Bills' => ['Parentsandguardians']])
			->where(['Concepts.created >=' => '2019-09-01', 'Concepts.annulled' => 0, 'Bills.tasa_cambio' => 1])
			->order(['Concepts.bill_id' => 'ASC']);
			
		$facturasSinActualizar = 0;
		
		$vectorPagos = [];
		$idAnterior = 0;
	
		foreach ($conceptos as $concepto)
		{
			$transaccion = $this->Studenttransactions->get($concepto->transaction_identifier);
			
			if ($idAnterior != $concepto->bill_id)
			{
				$vectorPagos[] = 
					['nroFactura' => $concepto->bill->bill_number,
					'idFactura' => $concepto->bill->id,
					'fechaFactura' => $concepto->bill->date_and_time,
					'alumno' => $concepto->student_name,
					'concepto' => $concepto->concept,
					'montoConcepto' => $concepto->amount,
					'descripcionTransaccion' => $transaccion->transaction_description,
					'montoOriginal' => $transaccion->original_amount,
					'montoAbonado' => $transaccion->amount,
					'montoDolar' => $transaccion->amount_dollar,
					'indicadorPagado' => $transaccion->paid_out,
					'pagoParcial' => $transaccion->partial_payment];  
				
				$facturasSinActualizar++;
			}
			$idAnterior = $concepto->bill_id;
		}
		
		$this->Flash->success(__('Total facturas sin actualizar: ' . $facturasSinActualizar));
					
        $this->set(compact('vectorPagos'));
        $this->set('_serialize', ['vectorPagos']);
			
		$conceptos = $this->Concepts->find('all')
			->contain(['Bills' => ['Parentsandguardians']])
			->where(['Bills.created >=' => '2019-09-01', 'Bills.annulled' => 0, 'Bills.fiscal' => 1])
			->order(['Concepts.bill_id' => 'ASC']);
				
		$vectorPagos = [];
		$contador = 0;
		$contadorDiferentes = 0;
		$idFacturaAnterior = 0;
		$numeroFacturaAnterior = 0;
		$montoFacturaAnterior = 0;
		$acumuladoConceptos = 0;
		$acumuladoPorUno = 0;
	
		foreach ($conceptos as $concepto)
		{
			if ($contador == 0)
			{
				$idFacturaAnterior = $concepto->bill->id;
				$numeroFacturaAnterior = $concepto->bill->bill_number;
				$montoFacturaAnterior = $concepto->bill->amount_paid * 1;
			}
			if ($concepto->bill->id != $idFacturaAnterior)
			{
				$acumuladoPorUno = $acumuladoConceptos * 1;
				
				if ($montoFacturaAnterior > $acumuladoPorUno)
				{
					echo "<br />";
					var_dump($montoFacturaAnterior);
					echo "<br />";
					var_dump($acumuladoPorUno);
					echo "<br />";
					
					$vectorPagos[] = 
						['nroFactura' => $numeroFacturaAnterior,
						'idFactura' => $idFacturaAnterior,
						'montoFactura' => $montoFacturaAnterior,
						'acumuladoPorUno' => $acumuladoPorUno];	
					$contadorDiferentes++;
					
					if ($contadorDiferentes > 5)
					{
						break;
					}
				}
				$idFacturaAnterior = $concepto->bill->id;
				$numeroFacturaAnterior = $concepto->bill->bill_number;
				$montoFacturaAnterior = $concepto->bill->amount_paid;
				$acumuladoConceptos = 0;
			}
			$contador++;
			$acumuladoConceptos += $concepto->amount;
		}
		
        $this->set(compact('vectorPagos'));
        $this->set('_serialize', ['vectorPagos']); */

		/* $vectorPagos = [];
		$facturasHijasServicio = 0;
		$contadorFacturas = 0;
		$contadorServicios = 0;
		
		$facturasHijas = $this->Concepts->Bills->find('all')
			->where(['id_anticipo >' => 0])
			->order(['id_anticipo' => 'ASC']);
			
		$contadorFacturas = $facturasHijas->count();
		
		$this->Flash->success(__('Contador facturas ' . $contadorFacturas));
		
		$conceptos = $this->Concepts->find('all')
			->where(['Concepts.concept' => 'Servicio educativo 2019'])
			->order(['Concepts.bill_id' => 'ASC']);
			
		$contadorServicios = $conceptos->count();
		
		$this->Flash->success(__('Contador servicios ' . $contadorServicios));
			
		if ($contadorFacturas > 0 && $contadorServicios > 0)
		{
			foreach ($conceptos as $concepto)
			{
				foreach ($facturasHijas as $hija)
				{
					if ($concepto->bill_id == $hija->id_anticipo)
					{
						$vectorPagos[] = 
							['nroFacturaHija' => $hija->bill_number,
							'idFacturaHija' => $hija->id,
							'idAnticipo' => $hija->id_anticipo];
						$facturasHijasServicio++;
					}
				}
			}
		}

		$this->Flash->success(__('Facturas correspondientes a servicios educativos ' . $facturasHijasServicio));
		
        $this->set(compact('vectorPagos'));
        $this->set('_serialize', ['vectorPagos']); */
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
		$concept->concept_migration = 0;		
		$concept->saldo = $amountPayable;

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
	
    public function agregarConceptosNota($idConcepto = null, $montoNota = null, $numeroNotaContable = null, $tipoNota = null, $idNota = null)
    {
		$codigoRetornoConcepto = 0;
		
		$conceptoFactura = $this->Concepts->get($idConcepto);
		
		if ($tipoNota == "Crédito")
		{
			$conceptoFactura->saldo -= $montoNota; 
		}
		else
		{
			$conceptoFactura->saldo += $montoNota;
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
			$conceptoNota->saldo = $montoNota;
			
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
				
				$binnacles->add('controller', 'Payments', 'conceptosReciboFactura', 'El concepto correspondiente a la factura con ID ' . $idFacturaNueva . ' no fue guardado');
				
				$this->Flash->error(__('El concepto de la factura con ID ' . $idFacturaNueva . ' no pudo ser guardado, intente nuevamente'));
				$codigoRetorno = 1;
				break;
			}
		}
		return $codigoRetorno;
	}
}