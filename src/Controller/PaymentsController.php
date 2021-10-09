<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\BinnaclesController;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 */
class PaymentsController extends AppController
{
	public function pruebaFuncion()
	{
		$this->loadModel('Turns');
		$this->loadModel('Concepts');
		
		$conceptoServicioEducativo = [];
		$conceptoServicioEducativo[]['idFactura'] = 0;
		$conceptoServicioEducativo[]['monto'] = 0;
		$conceptoServicioEducativo[]['saldo'] = 0;
		
		$turn = $this->Turns->get(799);
		$fechaTurnoFormateada = date_format($turn->start_date, "Y-m-d");
		$fechaTurno = $turn->start_date;
		$fechaProximoDia = $fechaTurno->addDay(1);
		$fechaProximoDiaFormateada = date_format($fechaProximoDia, "Y-m-d");
		echo "<br />fechaTurnoFormateada: " . $fechaTurnoFormateada;
		echo "<br />fechaProximoDiaFormateada: " . $fechaProximoDiaFormateada;
		
		$servicioEducativo = $this->Concepts->find('all')
			->where(['SUBSTRING(concept, 1, 18) =' => 'Servicio educativo', 'annulled' => 0, 'created >=' => $fechaTurnoFormateada, 'created <' => $fechaProximoDiaFormateada])
			->order(['bill_id' => 'ASC', 'created' => 'ASC']);
			
		$contadorRegistros = $servicioEducativo->count();
		
		if ($contadorRegistros > 0)
		{
			foreach ($servicioEducativo as $servicio)
			{
				$conceptoServicioEducativo[]['idFactura'] = $servicio->bill_id;
				$conceptoServicioEducativo[]['monto'] = $servicio->amount;
				$conceptoServicioEducativo[]['saldo'] = $servicio->amount;
			}
			
			echo "<br />";
			var_dump($conceptoServicioEducativo);
		}
		else
		{
			$this->Flash->error(__('No se encontraron registros'));
		}
	}

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $payments = $this->paginate($this->Payments);

        $this->set(compact('payments'));
        $this->set('_serialize', ['payments']);
    }

    /**
     * View method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => []
        ]);

        $this->set('payment', $payment);
        $this->set('_serialize', ['payment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($billId = null, $billNumber = null, $pago = null, $fiscal = null)
    {		
        $payment = $this->Payments->newEntity();
        $payment->bill_id = $billId;
        $payment->payment_type = $pago->paymentType;
        $payment->amount = $pago->amountPaid;
        $payment->bank = $pago->bank;
        $payment->account_or_card = $pago->accountOrCard;
        $payment->serial = $pago->serial;
        $payment->bill_number = $billNumber;
        $payment->responsible_user = $this->Auth->user('id');
        $payment->turn = $pago->idTurn;
        $payment->annulled = 0;
        $payment->name_family = $pago->family;
		$payment->moneda = $pago->moneda;
		if ($payment->moneda == '$')
		{
			$payment->orden_moneda = 1;
		}
		if ($payment->moneda == '€')
		{
			$payment->orden_moneda = 2;
		}
		else
		{
			$payment->orden_moneda = 3;
		}	
		$payment->banco_receptor = $pago->bancoReceptor;
		$payment->comentario = $pago->comentario;
        $payment->fiscal = $fiscal;        

        if (!($this->Payments->save($payment))) 
        {
            $this->Flash->error(__('El pago no fue guardado, vuelva a intentar por favor.'));
        }
        else
        {
            return;
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($idBill = null)
    {
        $this->autoRender = false;
        
        $payments = $this->Payments->find('all')->where(['bill_id' => $idBill]);
    
        $aPayments = $payments->toArray();
        
        foreach ($aPayments as $aPayment) 
        {    
            $payment = $this->Payments->get($aPayment->id);
            
            $payment->annulled = 1;
            
            if (!($this->Payments->save($payment))) 
            {
                $this->Flash->error(__('El pago no pudo ser anulado'));
            }
        }
        return;        
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        if ($this->Payments->delete($payment)) {
            $this->Flash->success(__('The payment has been deleted.'));
        } else {
            $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
    public function searchPayments($turn = null, $fechaTurnoFormateada = null, $fechaProximoDiaFormateada = null)
    {
        $this->autoRender = false;
		
		$conceptoServicioEducativo = [];
		$conceptoServicioEducativo[] = ['idFactura' => 0, 'monto' => 0, 'saldo' => 0];
		
		$pagosServicioEducativo = [];
		$pagosServicioEducativo[] = ['id' => 0,
									'tipoPago' => '',
									'fecha' => 0,
									'nroFactura' => 0,
									'nroControl' => 0,
									'familia' => '',
									'monto' => 0,
									'banco' => '',
									'serial' => ''];
									
		$montoServicioEducativo = 0;
		
		$indicadorServicioEducativo = 0;
		
		$resultado = [];
		
		$this->loadModel('Concepts');
	
		$servicioEducativo = $this->Concepts->find('all')
			->where(['SUBSTRING(concept, 1, 18) =' => 'Servicio educativo', 'annulled' => 0, 'created >=' => $fechaTurnoFormateada, 'created <' => $fechaProximoDiaFormateada])
			->order(['bill_id' => 'ASC', 'created' => 'ASC']);
			
		$contadorRegistros = $servicioEducativo->count();
			
		if ($contadorRegistros > 0)
		{
			$indicadorServicioEducativo = 1;
			
			foreach ($servicioEducativo as $servicio)
			{
				foreach ($servicioEducativo as $servicio)
				{
					$conceptoServicioEducativo[] = ['idFactura' => $servicio->bill_id, 'monto' => $servicio->amount, 'saldo' => $servicio->amount];
				}
			}
		}
							
        $paymentsTurn = $this->Payments->find('all')->where(['turn' => $turn, 'annulled' => 0])
            ->order(['Payments.payment_type' => 'ASC', 'Payments.created' => 'ASC']);
            
        $billId = 0;
		
        foreach ($paymentsTurn as $paymentsTurns) 
        {    
            if ($billId == 0)
            {
                $billId = $paymentsTurns->bill_id;
                
                $bill = $this->Payments->Bills->get($billId);
				
				$idFactura = $paymentsTurns->bill_id;
            }
			
            if ($billId != $paymentsTurns->bill_id)
            {
                $billId = $paymentsTurns->bill_id;

                $bill = $this->Payments->Bills->get($billId);
				
				$idFactura = $paymentsTurns->bill_id;
            }
			
			$paymentsTurns->bill_id = $bill->control_number;
			            
            if ($paymentsTurns->payment_type == "Tarjeta de débito" || $paymentsTurns->payment_type == "Tarjeta de crédito")
            {
                $paymentsTurns->serial = $paymentsTurns->account_or_card;
            }
			
			foreach ($conceptoServicioEducativo as $concepto)
			{				
				if ($concepto['idFactura'] == $idFactura)
				{
					if ($concepto['saldo'] > 0)
					{
						if ($concepto['saldo'] >= $paymentsTurns->amount)
						{
							$concepto['saldo'] -= $paymentsTurns->amount;
							$montoServicioEducativo = $paymentsTurns->amount;
							$paymentsTurns->amount = 0;
						}
						else
						{
							$paymentsTurns->amount -= $concepto['saldo'];
							$montoServicioEducativo = $concepto['saldo'];
							$concept['saldo'] = 0;
						}
						
						$pagosServicioEducativo[] = ['id' => $paymentsTurns->id,
													'tipoPago' => $paymentsTurns->payment_type,
													'fecha' => $paymentsTurns->created->format('d-m-Y H:i:s'),
													'nroFactura' => $paymentsTurns->bill_number,
													'nroControl' => $paymentsTurns->bill_id,
													'familia' => $paymentsTurns->name_family,
													'monto' => $montoServicioEducativo,
													'banco' => $paymentsTurns->bank,
													'serial' => $paymentsTurns->serial];
					}
				}
			}
        }
		
		$resultado = [$paymentsTurn, $indicadorServicioEducativo, $pagosServicioEducativo];

        return $resultado;
    }
	
    public function monetaryReconversion()
    {				
		$binnacles = new BinnaclesController;
	
		$payments = $this->Payments->find('all', ['conditions' => ['id >' => 0]]);
	
		$account1 = $payments->count();
			
		$account2 = 0;
		
		foreach ($payments as $payment)
        {		
			$paymentGet = $this->Payments->get($payment->id);
			
			$previousAmount = $paymentGet->amount;
										
			$paymentGet->amount = $previousAmount / 100000;
					
			if ($this->Payments->save($paymentGet))
			{
				$account2++;
			}
			else
			{
				$binnacles->add('controller', 'Payments', 'monetaryReconversion', 'No se actualizó registro con id: ' . $paymentGet->id);
			}
		}

		$binnacles->add('controller', 'Payments', 'monetaryReconversion', 'Total registros seleccionados: ' . $account1);
		$binnacles->add('controller', 'Payments', 'monetaryReconversion', 'Total registros actualizados: ' . $account2);

		return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
	}
	
    public function pagosReciboFactura($idReciboPendiente = null, $idFacturaNueva = null, $numeroNuevaFactura = null)
    {
		$this->loadModel('Concepts');
			
		$codigoRetorno = 0;
			
		$saldoServicioEducativo = 0;
			
		$servicioEducativo = $this->Concepts->find('all', ['conditions' => ['bill_id' => $idReciboPendiente, 'SUBSTRING(concept, 1, 18) =' => 'Servicio educativo']]);
	
		$contadorRegistros = $servicioEducativo->count();
		
		if ($contadorRegistros > 0)
		{
			foreach ($servicioEducativo as $servicio)
			{
				$saldoServicioEducativo += $servicio->amount; 
			}
		}
				
		$pagos = $this->Payments->find('all', ['conditions' => ['bill_id' => $idReciboPendiente], 'order' => ['payment_type' => 'ASC', 'created' => 'ASC']]);
		
		$contadorPagos = $pagos->count();
		
		if ($contadorPagos > 0)
		{
			foreach ($pagos as $pago)
			{
				$nuevoPago = $this->Payments->newEntity();
				$nuevoPago->bill_id = $idFacturaNueva;
				$nuevoPago->moneda = $pago->moneda;
				if ($nuevoPago->moneda == '$')
				{
					$nuevoPago->orden_moneda = 1;
				}
				if ($nuevoPago->moneda == '€')
				{
					$nuevoPago->orden_moneda = 2;
				}
				else
				{
					$nuevoPago->orden_moneda = 3;
				}	
				$nuevoPago->payment_type = $pago->payment_type;
				$nuevoPago->bank = $pago->bank;
				$nuevoPago->banco_receptor = $pago->banco_receptor;
				$nuevoPago->account_or_card = $pago->account_or_card;
				$nuevoPago->serial = $pago->serial;
				$nuevoPago->bill_number = $numeroNuevaFactura;
				$nuevoPago->responsible_user = $this->Auth->user('id');
				$nuevoPago->turn = $pago->turn;
				$nuevoPago->annulled = 0;
				$nuevoPago->name_family = $pago->name_family; 
				$nuevoPago->comentario = $pago->comentario; 
				$nuevoPago->fiscal = 1;     
				
				if ($saldoServicioEducativo > 0)
				{
					if ($saldoServicioEducativo >= $pago->amount)
					{
						$saldoServicioEducativo -= $pago->amount;
						$nuevoPago->amount = 0;
					}
					else
					{
		   
						$nuevoPago->amount = $pago->amount;
						$nuevoPago->amount -= $saldoServicioEducativo;
						$saldoServicioEducativo = 0;
					}	
				}
				else
				{
					$nuevoPago->amount = $pago->amount;
				}
		
				if ($nuevoPago->amount > 0)
				{
					if (!($this->Payments->save($nuevoPago))) 
					{
						$binnacles = new BinnaclesController;
						
						$binnacles->add('controller', 'Payments', 'pagosReciboFactura', 'El pago correspondiente a la factura con ID ' . $idFacturaNueva . ' no fue guardado');
						
						$this->Flash->error(__('El pago correspondiente a la factura con ID ' . $idFacturaNueva . ' no fue guardado, vuelva a intentar por favor.'));
						$codigoRetorno = 1;
						break;
					}
				}
			}
		}
		else
		{
			$binnacles = new BinnaclesController;
			
			$binnacles->add('controller', 'Payments', 'pagosReciboFactura', 'No se encontraron pagos para la factura con ID ' . $idReciboPendiente);
			
			$this->Flash->error(__('No se encontraron pagos para la factura con ID ' . $idReciboPendiente));
			$codigoRetorno = 1;	
		}
		
		return $codigoRetorno; 
    }
	
    public function busquedaPagos($turn = null)
    {
        $this->autoRender = false;
		
		$indicadorSobrantes = 0;
							
		$indicadorReintegros = 0;
		
		$indicadorCompensadas = 0;
		
		$indicadorBancos = 0;
		
		$resultado = [];
										
        $paymentsTurn = $this->Payments->find('all')
			->contain(['Bills'])
			->where(['Bills.turn' => $turn, 'Bills.annulled' => 0])
            ->order(['Payments.payment_type' => 'ASC', 'Payments.orden_moneda' => 'ASC', 'Payments.id' => 'ASC']);
            		
        foreach ($paymentsTurn as $paymentsTurns) 
        {               
            if ($paymentsTurns->payment_type == "Tarjeta de débito" || $paymentsTurns->payment_type == "Tarjeta de crédito")
            {
                $paymentsTurns->serial = $paymentsTurns->account_or_card;
            }
        }
		
		$sobrantes = $this->Payments->Bills->find('all')
			->contain(['Parentsandguardians'])
			->where(['tipo_documento' => 'Recibo de sobrante', 'annulled' => 0, 'turn' => $turn])
			->order(['Bills.id' => 'ASC']);
			
		$contadorSobrantes = $sobrantes->count();
			
		if ($contadorSobrantes > 0)
		{
			$indicadorSobrantes = 1;
		}
		
		$reintegros = $this->Payments->Bills->find('all')
			->contain(['Parentsandguardians'])
			->where(['tipo_documento' => 'Recibo de reintegro', 'annulled' => 0, 'turn' => $turn])
			->order(['Bills.id' => 'ASC']);
			
		$contadorReintegros = $reintegros->count();
			
		if ($contadorReintegros > 0)
		{
			$indicadorReintegros = 1;
		}
		
		$facturasCompensadas = $this->Payments->Bills->find('all')
			->contain(['Parentsandguardians'])
			->where(['saldo_compensado_dolar >' => 0, 'annulled' => 0, 'turn' => $turn])
			->order(['Bills.id' => 'ASC']);
			
		$contadorCompensadas = $facturasCompensadas->count();
			
		if ($contadorCompensadas > 0)
		{
			$indicadorCompensadas = 1;
		}
		
        $recibidoBancos = $this->Payments->find('all')
			->contain(['Bills'])
			->where(['Bills.turn' => $turn, 'Bills.annulled' => 0, 'Payments.banco_receptor !=' => "", 'Payments.banco_receptor !=' => "N/A"])
            ->order(['Payments.banco_receptor' => 'ASC', 'Payments.created' => 'ASC']);
			
		$contadorBancos = $recibidoBancos->count();
			
		if ($contadorBancos > 0)
		{
			
			$indicadorBancos = 1;
		}
				
		$resultado = [$paymentsTurn, $indicadorSobrantes, $sobrantes, $indicadorReintegros, $reintegros, $indicadorCompensadas, $facturasCompensadas, $indicadorBancos, $recibidoBancos];

        return $resultado;
    }
    
	public function busquedaPagosContabilidad($turn = null)
    {
        $this->autoRender = false;

		$codigoRetorno = 0;
		
		$resultado = ['codigoRetorno' => 0, 'facturas' => '', 'pagosFacturas' => ''];

		$facturas = $this->Payments->Bills->find('all')
			->contain(['Parentsandguardians'])
			->where(['Bills.turn' => $turn, 'Bills.annulled' => 0])
            ->order(['Bills.bill_number' => 'ASC']);

		$contadorFacturas = $facturas->count();
			
		if ($contadorFacturas > 0)
		{
			$resultado['facturas'] = $facturas;
			
			$pagosFacturas = $this->Payments->find('all')
				->contain(['Bills'])
				->where(['Bills.turn' => $turn, 'Bills.annulled' => 0])
				->order(['Bills.bill_number' => 'ASC', 'Payments.payment_type' => 'ASC', 'Payments.orden_moneda' => 'ASC']);
				
			$contadorPagos = $pagosFacturas->count();
			
			if ($contadorPagos > 0)
			{
				$resultado['pagosFacturas'] = $pagosFacturas;	
			}
			else
			{
				$resultado['codigoRetorno'] = 2;
			}
		}
		else
		{
			$resultado['codigoRetorno'] = 1;
		}
		
        return $resultado;
    }
	public function busquedaPagosFactura($idFactura = null)
    {
        $this->autoRender = false;
		
		$resultado = ['codigoRetorno' => 0, 'pagosFactura' => ''];
		
		$pagosFactura = $this->Payments->find('all')
			->where(['bill_id' => $idFactura])
			->order(['payment_type' => 'ASC', 'orden_moneda' => 'ASC']);
			
		$contadorPagos = $pagosFactura->count();
		
		if ($contadorPagos > 0)
		{
			$resultado['pagosFactura'] = $pagosFactura;	
		}
		else
		{
			$resultado['codigoRetorno'] = 1;
		}
		
        return $resultado;
    }
	public function verificarSerial()
    {
        $this->autoRender = false;
		$jsondata = [];

        if ($this->request->is('json')) 
        {
			
            if(isset($_POST['banco']))
            {
				$banco = $_POST['banco'];
				if(isset($_POST['serial']))
				{
					$serial = $_POST['serial'];

					$pagos = $this->Payments->find('all')
					->where(['OR' => [['payment_type' => 'Transferencia'], ['payment_type' => 'Depósito']], 'bank' => $banco, 'serial' => $serial, 'annulled' => 0])
					->order(['id' => 'DESC']);

					$pago = $pagos->first();
					
					if ($pago)
					{
						$jsondata["success"] = false;
						$jsondata["message"] = "Serial duplicado";
					}
					else
					{
						$jsondata["success"] = true;
						$jsondata["message"] = "Serial válido";
					}
				}
				else
				{
					$jsondata["success"] = false;
					$jsondata["message"] = "Falta el serial de la transaccion";
				}
			}
			else
			{
				$jsondata["success"] = false;
				$jsondata["message"] = "Falta el nombre del banco";
			}
			
			exit(json_encode($jsondata, JSON_FORCE_OBJECT));	
		}
	}
}