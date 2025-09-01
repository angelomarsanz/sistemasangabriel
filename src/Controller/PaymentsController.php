<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Controller\BinnaclesController;
use Cake\I18n\Time;
use Cake\Event\Event;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 */
class PaymentsController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Si la solicitud es una petición de AJAX, usa el layout 'ajax'
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        }
    }

    public function isAuthorized($user)
    {
		if(isset($user['role']))
		{
			// Inicio cambios Seniat
			if ($user['role'] === 'Seniat')
			{
				if(in_array($this->request->action, ['verificarSerial']))
				{
					return true;
				}
			}
			// Fin cambios Seniat
		}
        return parent::isAuthorized($user);
    }        

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
		$payment->monto_igtf_dolar = $pago->monto_igtf_dolar;  

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

		$facturasNotas = [];
		
		$resultado = ['codigoRetorno' => 0, 'facturas' => '', 'pagosFacturas' => '', 'facturasNotas' => ''];

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
				foreach($facturas as $factura)
				{
					if ($factura->tipo_documento == 'Nota de crédito' || $factura->tipo_documento == 'Nota de débito')
					{
						$facturaAfectada = $this->Payments->Bills->get($factura->id_documento_padre);

						$facturasNotas[$facturaAfectada->id] = ['controlAfectada' => $facturaAfectada->control_number, 'numeroAfectada' => $facturaAfectada->bill_number, 'fechaAfectada' => $facturaAfectada->date_and_time];
					}	
				}
				$resultado['facturasNotas'] = $facturasNotas;
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
	public function pagosPedidoFactura($idPedido = null, $idFactura = null, $numeroFactura = null, $idTurno = null, $igtf = null)
    {	
		$codigoRetorno = 0;
		$porcentaje_igtf = 0.03;
		
		$pagos = $this->Payments->find('all', ['conditions' => ['bill_id' => $idPedido], 'order' => ['payment_type' => 'ASC', 'created' => 'ASC']]);
		
		$contadorPagos = $pagos->count();
		
		if ($contadorPagos > 0)
		{
			$saldo_monto_igtf = $igtf['monto_igtf_dolar'];
			$contador_pagos_divisas = 0;
			foreach ($pagos as $pago)
			{
				if ($pago->moneda == "$" || $pago->moneda == "€")
				{
					$contador_pagos_divisas++;
				}
			}

			foreach ($pagos as $pago)
			{
				$nuevoPago = $this->Payments->newEntity();
				$familia = $pago->name_family;
				$nuevoPago->bill_id = $idFactura;
				$nuevoPago->moneda = $pago->moneda;
				$nuevoPago->orden_moneda = $pago->orden_moneda;
				$nuevoPago->payment_type = $pago->payment_type;
				$nuevoPago->bank = $pago->bank;
				$nuevoPago->banco_receptor = $pago->banco_receptor;
				$nuevoPago->account_or_card = $pago->account_or_card;
				$nuevoPago->serial = $pago->serial;
				$nuevoPago->bill_number = $numeroFactura;
				$nuevoPago->responsible_user = $this->Auth->user('id');
				$nuevoPago->turn = $idTurno;
				$nuevoPago->annulled = 0;
				$nuevoPago->name_family = $pago->name_family; 
				$nuevoPago->comentario = $pago->comentario; 
				$nuevoPago->fiscal = 1;     
				$nuevoPago->amount = $pago->amount;
				$nuevoPago->monto_igtf_dolar = 0;

				if (!($this->Payments->save($nuevoPago))) 
				{
					$binnacles = new BinnaclesController;
					
					$binnacles->add('controller', 'Payments', 'pagosPedidoFactura', 'El pago correspondiente a la factura con ID ' . $idFactura . ' no fue guardado');
					
					$this->Flash->error(__('El pago correspondiente a la factura con ID '.$idFactura.' no fue guardado, vuelva a intentar por favor.'));
					$codigoRetorno = 1;
					break;
				}
			}
			if ($codigoRetorno == 0 && $igtf['monto_igtf_dolar'] > 0)
			{
				$pago_igtf = $this->Payments->newEntity();
				$pago_igtf->bill_id = $idFactura;
				$pago_igtf->payment_type = $igtf["metodo_de_pago"];
				$pago_igtf->moneda = $igtf["moneda_de_pago"];

				if ($igtf["moneda_de_pago"] == "$")
				{
					$pago_igtf->amount = $igtf["monto_igtf_dolar"];
					$pago_igtf->orden_moneda = 1;
				}
				elseif ($igtf["moneda_de_pago"] == "€")
				{
					$pago_igtf->amount = $igtf["monto_igtf_euro"];
					$pago_igtf->orden_moneda = 2;
				}
				else
				{
					$pago_igtf->amount = $igtf["monto_igtf_bolivar"];
					$pago_igtf->orden_moneda = 3;
				}
				$pago_igtf->bank = "";
				$pago_igtf->account_or_card = "";
				$pago_igtf->serial = "";
				$pago_igtf->bill_number = $numeroFactura;
				$pago_igtf->responsible_user = $this->Auth->user('id');
				$pago_igtf->turn = $idTurno;
				$pago_igtf->annulled = 0;
				$pago_igtf->name_family = $familia;
				$pago_igtf->banco_receptor = "";
				$pago_igtf->comentario = "";
				$pago_igtf->fiscal = 1;
				$pago_igtf->monto_igtf_dolar = $pago_igtf->amount; 
				     
				if (!($this->Payments->save($pago_igtf))) 
				{
					$this->Flash->error(__('El pago no fue guardado, vuelva a intentar por favor.'));
					$codigoRetorno = 1;
				}
			}
		}
		else
		{
			$eventos = new EventosController;
			
			$eventos->add('controller', 'Payments', 'pagosPedidoFactura', 'No se encontraron pagos para el pedido con ID '.$idPedido);
			
			$this->Flash->error(__('No se encontraron pagos para el pedido con ID '.$idPedido));
			$codigoRetorno = 1;	
		}
		return $codigoRetorno; 
    }
	public function datosReporteFormasDePago()
	{
		// Esta función no necesita una vista, por lo que deshabilitamos el renderizado.
		$this->viewBuilder()->setLayout('ajax');
		$this->autoRender = false;

		// Validar que la solicitud sea AJAX
		if (!$this->request->is('ajax')) {
			$this->response->withStatus(403);
			return $this->response->withStringBody(json_encode(['success' => false, 'message' => 'Acceso denegado.']));
		}

		// Obtener los filtros enviados desde el cliente
		$filters = $this->request->getData();
		
		// Cargar los modelos necesarios para la consulta
		$this->loadModel('Bills');
		$this->loadModel('Parentsandguardians');
		$this->loadModel('Students');
		
		// Construir el query base, uniendo las tablas
		$query = $this->Payments->find('all')
			->contain([
				'Bills',
				'Bills.Parentsandguardians',
				'Bills.Parentsandguardians.Students' => function ($q) {
					return $q->where(['Students.student_condition' => 'Regular']);
				}
			])
			->where([
				'Payments.annulled' => 0, // Suponemos que 0 es no anulado
				'Bills.annulled' => 0,
			]);

		$contadorQueryOriginal = $query->count();
		
		// Aplicar filtros de fecha y año
		$year = $filters['year'];
		if (!empty($filters['months'])) {
			$monthConditions = [];
			foreach ($filters['months'] as $month) {
				if ($month === 'all') {
					$monthConditions = [];
					break;
				}
				$monthConditions[] = ['MONTH(Bills.date_and_time)' => $month];
			}
			if (!empty($monthConditions)) {
				$query->where(['OR' => $monthConditions]);
			}
		}
		$query->where(['YEAR(Bills.date_and_time)' => $year]);
		
		$contadorQueryAnioMes = $query->count();

		// Aplicar filtro de tipo de documento
		if ($filters['documentType'] === 'facturas') {
			$query->where(['Bills.tipo_documento' => 'Factura']);
		} else { // pedidos
			$query->where([
				'OR' => [
					['Bills.tipo_documento' => 'Pedido'],
					['Bills.tipo_documento' => 'Recibo de anticipo']
				]
			]);
		}

		// Aplicar filtro de tipo de persona
		if ($filters['personType'] === 'juridica') {
			$query->where(['OR' => [
				['Bills.identification LIKE' => 'J -%'],
				['Bills.identification LIKE' => 'G -%']
			]]);
		} elseif ($filters['personType'] === 'natural') {
			$query->where(['OR' => [
				['Bills.identification LIKE' => 'V -%'],
				['Bills.identification LIKE' => 'E -%'],
				['Bills.identification LIKE' => 'P -%']
			]]);
		} elseif ($filters['personType'] === 'ambas') {
			$query->where(['OR' => [
				['Bills.identification LIKE' => 'J -%'],
				['Bills.identification LIKE' => 'G -%'],
				['Bills.identification LIKE' => 'V -%'],
				['Bills.identification LIKE' => 'E -%'],
				['Bills.identification LIKE' => 'P -%']
			]]);
		}
		// Si se selecciona 'ambas', se filtran explícitamente todos los tipos de persona conocidos.
		$contadorQueryTipoPersona = $query->count();
		
		// Aplicar filtro de formas de pago
		$paymentConditions = [];
		foreach ($filters['paymentForms'] as $form) {
			switch ($form) {
				case 'efectivo_dolar':
					$paymentConditions[] = ['Payments.payment_type' => 'Efectivo', 'Payments.moneda' => '$'];
					break;
				case 'efectivo_euro':
					$paymentConditions[] = ['Payments.payment_type' => 'Efectivo', 'Payments.moneda' => '€'];
					break;
				case 'efectivo_bolivar':
					$paymentConditions[] = ['Payments.payment_type' => 'Efectivo', 'Payments.moneda' => 'Bs.'];
					break;
				case 'punto_venta':
					$paymentConditions[] = ['OR' => [['Payments.payment_type' => 'Tarjeta de débito'], ['Payments.payment_type' => 'Tarjeta de crédito']], 'Payments.moneda' => 'Bs.'];
					break;
				case 'zelle':
					$paymentConditions[] = ['Payments.payment_type' => 'Transferencia', 'Payments.bank' => 'Zelle'];
					break;
				case 'euros_transf':
					$paymentConditions[] = ['Payments.payment_type' => 'Transferencia', 'Payments.bank' => 'Euros'];
					break;
				case 'transferencia_bs':
					// 👉 Corrección para transferencias en bolívares
					$paymentConditions[] = ['Payments.payment_type' => 'Transferencia', 'Payments.moneda' => 'Bs.'];
					break;
				case 'todas':
					// Si se selecciona 'todas', no se agrega ninguna condición específica
					break;
			}
		}

		if (!empty($paymentConditions)) {
			$query->where(['OR' => $paymentConditions]);
		}

		if (!empty($paymentConditions)) {
			// Aquí está el cambio crucial
			$query->where(['OR' => $paymentConditions]);
		}

		// Aplicar ordenamiento
		if ($filters['orderBy'] === 'familia' || $filters['orderBy'] === 'familia_agrupado') {
			$query->order(['Parentsandguardians.family' => 'ASC']);
		} else { // factura
			$query->order(['Bills.bill_number' => 'ASC']);
		}

		// Obtener los resultados y procesarlos
		$results = $query->toArray();
		$reportData = [];
		$totals = ['totalGeneral' => 0];
		$cantidad = 0;

		if ($filters['orderBy'] === 'familia_agrupado') {
			$groupedByFamily = [];
			foreach ($results as $payment) {
				$familyId = $payment->bill->parentsandguardian->id;
				$paymentLabel = $this->getPaymentLabel($payment);
		
				if (!isset($groupedByFamily[$familyId])) {
					$representative = $payment->bill->parentsandguardian;
					$students = [];
					if (!empty($representative->students)) {
						foreach ($representative->students as $student) {
							$students[] = $student->first_name . ' ' . $student->second_name;
						}
					}
					$groupedByFamily[$familyId] = [
						'familia' => $representative->family . ' (' . $representative->first_name . ' ' . $representative->surname . ')',
						'students' => $students,
						'cedulaRif' => $payment->bill->identification,
						'razonSocial' => $payment->bill->client,
						'payments' => []
					];
				}
		
				if (!isset($groupedByFamily[$familyId]['payments'][$paymentLabel])) {
					$groupedByFamily[$familyId]['payments'][$paymentLabel] = 0;
				}
				$groupedByFamily[$familyId]['payments'][$paymentLabel] += $payment->amount;
		
				// Actualizar totales generales
				if (!isset($totals[$paymentLabel])) {
					$totals[$paymentLabel] = 0;
				}
				$totals[$paymentLabel] += $payment->amount;
				$totals['totalGeneral'] += $payment->amount;
			}
		
			// Aplanar los datos agrupados para el reporte
			foreach ($groupedByFamily as $familyData) {
				foreach ($familyData['payments'] as $paymentLabel => $amount) {
					$reportData[] = [
						'familia' => $familyData['familia'],
						'students' => $familyData['students'],
						'cedulaRif' => $familyData['cedulaRif'],
						'razonSocial' => $familyData['razonSocial'],
						'formaPago' => $paymentLabel,
						'monto' => $amount
					];
				}
			}
			$cantidad = count($groupedByFamily); // La cantidad de operaciones es el número de familias
		} else {
			// Agrupar los pagos por factura para un mejor procesamiento
			$groupedByBill = [];
			foreach ($results as $payment) {
				$billId = $payment->bill->id;
				if (!isset($groupedByBill[$billId])) {
					$groupedByBill[$billId] = $payment->bill;
					$groupedByBill[$billId]['payments'] = [];
				}
				$groupedByBill[$billId]['payments'][] = $payment;
			}
	
			foreach ($groupedByBill as $bill) {
				$cantidad++;
				foreach ($bill->payments as $payment) {
					// Lógica para el resumen de totales
					$paymentLabel = $this->getPaymentLabel($payment);
					if (!isset($totals[$paymentLabel])) {
						$totals[$paymentLabel] = 0;
					}
					$totals[$paymentLabel] += $payment->amount;
					$totals['totalGeneral'] += $payment->amount;
	
					// Lógica para el detalle del reporte
					$representative = $bill->parentsandguardian;
					$students = [];
					if (!empty($representative->students)) {
						foreach ($representative->students as $student) {
							$students[] = $student->first_name . ' ' . $student->second_name;
						}
					}
					
					$reportData[] = [
						'familia' => $representative->family . ' (' . $representative->first_name . ' ' . $representative->surname . ')',
						'students' => $students,
						'facturaControl' => $bill->bill_number . ' / ' . $bill->control_number,
						'cedulaRif' => $bill->identification,
						'razonSocial' => $bill->client,
						'fechaFactura' => date_format($bill->date_and_time, 'd-m-Y'),
						'formaPago' => $paymentLabel,
						'monto' => $payment->amount
					];
				}
			}
		}

		// Formato final de la respuesta
		$response = [
			'success' => true,
			'data' => [
				'filters' => $filters,
				'cantidad' => $cantidad,
				'totals' => $totals,
				'details' => $reportData,
				'contadorQueryOriginal' => $contadorQueryOriginal,
				'year' => $year,
				'monthConditions' => $monthConditions,
				'contadorQueryAnioMes' => $contadorQueryAnioMes,
				'contadorQueryTipoPersona' => $contadorQueryTipoPersona

			]
		];

		return $this->response->withType('application/json')->withStringBody(json_encode($response));
	}

	/**
	 * Helper para obtener la etiqueta de la forma de pago
	 * @param object $payment
	 * @return string
	 */
	private function getPaymentLabel($payment)
	{
		if ($payment->payment_type === 'Efectivo') {
			return "Efectivo {$payment->moneda}";
		}

		if ($payment->payment_type === 'Transferencia') {
			if ($payment->bank === 'Zelle') {
				return "Zelle $";
			} elseif ($payment->bank === 'Euros') {
				return "Euros €";
			} else {
				return "Transferencia Bs.";
			}
		}

		if ($payment->payment_type === 'Tarjeta de débito' || $payment->payment_type === 'Tarjeta de crédito') {
			return "Punto de venta Bs.";
		}

		return $payment->payment_type;
	}

}