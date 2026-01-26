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
		if (substr($transaccion->monthlyPayment, 0, 17) == "Consejo educativo")
		{
			$concept->amount = $transaccion->montoAPagarDolar;
			$concept->saldo = $transaccion->montoAPagarDolar;
		}
		else
		{
        	$concept->amount = $transaccion->montoAPagarBolivar;
			$concept->saldo = $transaccion->montoAPagarBolivar;
		}
        $concept->observation = $transaccion->observation;
        $concept->annulled = 0;
		$concept->concept_migration = 0;		

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
    public function edit($idBill = null, $billNumber = null, $tasaCambio = null, $tipo_documento = null, $tipo_operacion = null)
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
				if ($concept->transaction_identifier != 999999 && $tipo_operacion != "Sustitución")
				{
					$studentTransactions->reverseTransaction($concept->transaction_identifier, $concept->amount, $billNumber, $tasaCambio, $tipo_documento);   
				}
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
			$conceptoNota->saldo = round($montoNota/$tasaCambio, 2);
			
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
	
	public function conceptosReciboAdicional($idRecibo = null, $concepto = null, $monto = null)
	{
		$codigoRetorno = 0;
		
		$conceptoNuevo = $this->Concepts->newEntity();
		$conceptoNuevo->bill_id = $idRecibo;
		$conceptoNuevo->quantity = 1;
		$conceptoNuevo->accounting_code = "001";
		$conceptoNuevo->student_name = "";
		$conceptoNuevo->transaction_identifier = 999999;
		$conceptoNuevo->concept = $concepto;
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
	public function conceptosPedidoFactura($idPedido = null, $idFactura = null, $tasa_dolar_original = null, $tasa_dolar_actual = null)
	{
		$codigoRetorno = 0;
		
		$conceptos = $this->Concepts->find('all', ['conditions' => ['bill_id' => $idPedido], 'order' => ['created' => 'ASC']]);

		$contadorConceptos = $conceptos->count();
		
		if ($contadorConceptos > 0)
		{
			foreach ($conceptos as $concepto)
			{
				$nuevoConcepto = $this->Concepts->newEntity();
				$nuevoConcepto->bill_id = $idFactura;
				$nuevoConcepto->quantity = 1;
				$nuevoConcepto->accounting_code = "001";
				$nuevoConcepto->student_name = $concepto->student_name;
				$nuevoConcepto->transaction_identifier = $concepto->transaction_identifier;
				$nuevoConcepto->concept = $concepto->concept;

				$monto_dolar_concepto = round($concepto->amount/$tasa_dolar_original, 2);
				$nuevo_monto_bolivar_concepto = round($monto_dolar_concepto * $tasa_dolar_actual, 2);

				$nuevoConcepto->amount = $nuevo_monto_bolivar_concepto;
				$nuevoConcepto->observation = $concepto->observation;
				$nuevoConcepto->annulled = 0;
				$nuevoConcepto->concept_migration = 0;		
				$nuevoConcepto->saldo = $concepto->saldo;

				if (!($this->Concepts->save($nuevoConcepto)))
				{
					$binnacles = new BinnaclesController;
					
					$binnacles->add('controller', 'Concepts', 'conceptosPedidoFactura', 'El concepto correspondiente a la factura con ID '.$idFactura.' no fue guardado');
					
					$this->Flash->error(__('El concepto de la factura con ID ' . $idFactura.' no pudo ser guardado'));
					$codigoRetorno = 1;
					break;
				}
			}
		}
		else
		{
			$binnacles = new BinnaclesController;
			
			$binnacles->add('controller', 'Concepts', 'conceptosPedidoFactura', 'No se encontraron conceptos para el pedido con ID '.$idPedido);
			
			$this->Flash->error(__('No se encontraron pagos para el pedido con ID '.$idPedido));
			$codigoRetorno = 1;	
		}
		return $codigoRetorno;
	}
	public function agregarConceptoNotaCreditoDescuento($nota_credito = null)
    {
		$codigoRetornoConcepto = 0;
		$conceptoNota = $this->Concepts->newEntity();
		$conceptoNota->bill_id = $nota_credito->id;
		$conceptoNota->quantity = 1;
		$conceptoNota->accounting_code = "001";
		$conceptoNota->student_name = "";
		$conceptoNota->transaction_identifier = 0;
		$conceptoNota->concept = "Descuento por pronto pago";
		$conceptoNota->amount = $nota_credito->amount_paid;
		$conceptoNota->observation = "";
		$conceptoNota->annulled = 0;
		$conceptoNota->concept_migration = 0;
		$conceptoNota->saldo = $nota_credito->amount_paid;
		if (!($this->Concepts->save($conceptoNota)))
		{
			$codigoRetornoConcepto = 1;
			$this->Flash->error(__('No se pudo registrar el concepto de la nota de crédito'));
		}
        return $codigoRetornoConcepto;
	}

    public function agregarConceptoNotaIgtf($idNota = null, $montoNotaIgtf = null, $tasaCambio = null)
    {
		$codigoRetornoConcepto = 0;
		
		$conceptoNota = $this->Concepts->newEntity();
		$conceptoNota->bill_id = $idNota;
		$conceptoNota->quantity = 1;
		$conceptoNota->accounting_code = "001";
		$conceptoNota->student_name = "";
		$conceptoNota->transaction_identifier = 0;
		$conceptoNota->concept = "IGTF";
		$conceptoNota->amount = round($montoNotaIgtf * $tasaCambio, 2);
		$conceptoNota->observation = "";
		$conceptoNota->annulled = 0;
		$conceptoNota->concept_migration = 1;
		$conceptoNota->saldo = $montoNotaIgtf;
		
		if (!($this->Concepts->save($conceptoNota)))
		{
			$codigoRetornoConcepto = 1;
			$this->Flash->error(__('El concepto de la nota de IGTF no pudo ser guardado, intente nuevamente'));
		}
       	return $codigoRetornoConcepto;
	}
	public function busquedaConceptos($turno = null)
	{
		$conceptosConsejoEducativo = [];
		$conceptosServicioEducativo = [];

		$conceptos = $this->Concepts->find('all')
			->contain(['Bills'])
			->where(['Bills.annulled' => 0, 'Bills.turn' => $turno])
			->order(['Bills.bill_number' => 'ASC']);

		$contadorConceptos = $conceptos->count();

		if ($contadorConceptos > 0)
		{
			foreach ($conceptos as $concepto)
			{
				if ($concepto->bill->tipo_documento == 'Recibo de Consejo Educativo')
				{
					$conceptosConsejoEducativo[$concepto->bill->id] = $concepto->concept;
				}
				if ($concepto->bill->tipo_documento == 'Recibo de servicio educativo')
				{
					$conceptosServicioEducativo[] = ['bill_id' => $concepto->bill->id, 'concepto' => $concepto->student_name];
				}
			}
		}

		return $conceptosTurno = ['consejoEducativo' => $conceptosConsejoEducativo, 'servicioEducativo' => $conceptosServicioEducativo];
	}
}