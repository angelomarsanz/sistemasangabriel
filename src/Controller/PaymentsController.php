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
    public function pagoReciboSobrante($idRecibo = null, $numeroRecibo = null, $monto = null, $turno = null)
    {
		$nuevoPago = $this->Payments->newEntity();
		$nuevoPago->bill_id = $idRecibo;
		$nuevoPago->moneda = "$";
		$nuevoPago->orden_moneda = 1;
		$nuevoPago->payment_type = "Efectivo";
		$nuevoPago->bank = "N/A";
		$nuevoPago->banco_receptor = "N/A";
		$nuevoPago->account_or_card = "N/A";
		$nuevoPago->serial = "N/A";
		$nuevoPago->bill_number = $numeroRecibo;
		$nuevoPago->responsible_user = $this->Auth->user('id');
		$nuevoPago->turn = $turno;
		$nuevoPago->annulled = 0;
		$nuevoPago->name_family = $familia; 
		$nuevoPago->fiscal = 0;     
		$nuevoPago->amount = $monto;
		$nuevoPago->comentario = "";

		if (!($this->Payments->save($nuevoPago))) 
		{
			$binnacles = new BinnaclesController;
			
			$binnacles->add('controller', 'Payments', 'pagosReciboSobrante', 'El pago correspondiente al recibo con ID ' . $idRecibo . ' no fue guardado');
			
			$this->Flash->error(__('El pago correspondiente al recibo con ID ' . $idRecibo . ' no fue guardado, vuelva a intentar por favor.'));
			$codigoRetorno = 1;
		}	
		return $codigoRetorno; 
    }
	
    public function busquedaPagos($turn = null, $fechaTurnoFormateada = null, $fechaProximoDiaFormateada = null)
    {
        $this->autoRender = false;
		
		$conceptoRecibos = [];
		$conceptoRecibos[] = ['idFactura' => 0, 'tipoRecibo' => '', 'montoDolar' => 0, 'saldoDolar' => 0];
		
		$pagosRecibos = [];
									
		$montoRecibo = 0;
		
		$indicadorRecibos = 0;
		
		$indicadorServiciosEducativos = 0;
		
		$indicadorSobrantes = 0;
		
		$indicadorReintegros = 0;
		
		$indicadorCompensadas = 0;
		
		$resultado = [];
		
		$this->loadModel('Concepts');
	
		$recibos = $this->Concepts->find('all')
			->contain(['Bills'])
			->where(['OR' => [['concept' => 'Sobrante'], ['SUBSTRING(concept, 1, 18) =' => 'Servicio educativo']], 'annulled' => 0, 'created >=' => $fechaTurnoFormateada, 'created <' => $fechaProximoDiaFormateada])
			->order(['bill_id' => 'ASC', 'created' => 'ASC']);
			
		$contadorRegistros = $recibos->count();
			
		if ($contadorRegistros > 0)
		{
			$indicadorRecibos = 1;
			
				foreach ($recibos as $recibo)
				{
					$montoConceptoDolar = round($recibo->amount * $recibo->bill->tasa_cambio);
					
					if (substr($servicio->concept, 0, 18) == "Servicio educativo")
					{
						$indicadorServiciosEducativos = 1;
						$conceptoRecibos[] = ['idFactura' => $recibo->bill_id, 'tipoRecibo' => 'Servicio educativo', 'montoDolar' => $montoConceptoDolar, 'saldoDolar' => $montoConceptoDolar];
					}
					else
					{
						$indicadorSobrantes = 1;
						$conceptoRecibos[] = ['idFactura' => $recibo->bill_id, 'tipoRecibo' => 'Sobrante', 'montoDolar' => $montoConceptoDolar, 'saldoDolar' => $montoConceptoDolar];
					}
				}	
			
		}
							
        $paymentsTurn = $this->Payments->find('all')
			->contain(['Bills'])
			->where(['turn' => $turn, 'annulled' => 0])
            ->order(['Payments.payment_type' => 'ASC', 'Payments.orden_moneda' => 'ASC', 'Payments.id' => 'ASC']);
            
        $billId = 0;
		$tasaDolar = 0;
		$tasaEuro = 0;
		$montoDolar = 0;
		$montoDolarEuro = 0;
		
        foreach ($paymentsTurn as $paymentsTurns) 
        {    
            if ($billId == 0)
            {
                $billId = $paymentsTurns->bill_id;
                
                $bill = $this->Payments->Bills->get($billId);
				
				$idFactura = $paymentsTurns->bill_id;
				
				$tasaDolar = $paymentsTurns->bill->tasa_cambio;
				
				$tasaEuro = $paymentsTurns->bill->tasa_euro;
							
				$tasaDolarEuro = $paymentsTurns->bill->tasa_dolar_euro;
            }
			
            if ($billId != $paymentsTurns->bill_id)
            {
                $billId = $paymentsTurns->bill_id;

                $bill = $this->Payments->Bills->get($billId);
				
				$idFactura = $paymentsTurns->bill_id;
				
				$tasaDolar = $paymentsTurns->bill->tasa_cambio;
				
				$tasaEuro = $paymentsTurns->bill->tasa_euro;
				
				$tasaDolarEuro = $paymentsTurns->bill->tasa_dolar_euro;
            }
			            
            if ($paymentsTurns->payment_type == "Tarjeta de débito" || $paymentsTurns->payment_type == "Tarjeta de crédito")
            {
                $paymentsTurns->serial = $paymentsTurns->account_or_card;
            }
			
			foreach ($conceptoRecibos as $concepto)
			{				
				if ($concepto['idFactura'] == $idFactura)
				{
					if ($concepto['saldoDolar'] > 0)
					{						
						if ($paymentsTurn->moneda == "$")
						{
							if ($concepto['saldoDolar'] >= $paymentsTurns->amount)
							{
								$concepto['saldoDolar'] -= $paymentsTurns->amount;
								$montoRecibo = $paymentsTurns->amount;
								$paymentsTurns->amount = 0;
							}
							else
							{
								$paymentsTurns->amount -= $concepto['saldoDolar'];
								$montoRecibo = $concepto['saldoDolar'];
								$concept['saldoDolar'] = 0;
							}
						}
						elseif ($paymentsTurn->moneda == "€")
						{
							if (round($concepto['saldoDolar'] / $tasaDolarEuro) >= $paymentsTurns->amount)
							{
								$concepto['saldoDolar'] -= round($paymentsTurns->amount * $tasaDolarEuro);
								$montoRecibo = $paymentsTurns->amount;
								$paymentsTurns->amount = 0;
							}
							else
							{
								$paymentsTurns->amount -= round($concepto['saldoDolar'] / $tasaDolarEuro);
								$montoRecibo = round($concepto['saldoDolar'] / $tasaDolarEuro);
								$concept['saldoDolar'] = 0;
							}							
						}
						else
						{
							if (round($concepto['saldoDolar'] * $tasaDolar) >= $paymentsTurns->amount)
							{
								$concepto['saldoDolar'] -= round($paymentsTurns->amount / $tasaDolar);
								$montoRecibo = $paymentsTurns->amount;
								$paymentsTurns->amount = 0;
							}
							else
							{
								$paymentsTurns->amount -= round($concepto['saldoDolar'] * $tasaDolar);
								$montoRecibo = round($concepto['saldoDolar'] * $tasaDolar);
								$concept['saldoDolar'] = 0;
							}	
						}

						$pagosRecibos[] = ['id' => $paymentsTurns->id,
													'moneda' => $paymentsTurns->moneda,
													'tipoRecibo' => $concepto['tipoRecibo'];
													'tipoPago' => $paymentsTurns->payment_type,
													'fecha' => $paymentsTurns->created,
													'nroFactura' => $paymentsTurns->bill_number,
													'nroControl' => $paymentsTurns->bill->bill_number,
													'familia' => $paymentsTurns->name_family,
													'monto' => $montoRecibo,
													'bancoEmisor' => $paymentsTurns->bank,
													'bancoReceptor' => $paymentsTurns->banco_receptor,
													'serial' => $paymentsTurns->serial,
													'comentario' => $paymentsTurns->comentario,
													'tasaDolar' => $tasaDolar,
													'tasaEuro' => $tasaEuro,
													'tasaDolarEuro' => $tasaDolarEuro];
					}
				}
			}
        }
		
		$reintegros = $this->Concepts->find('all')
			->contain(['Bills' => ['Parendsandguardians'])
			->where(['concept' => 'Reintegro', 'annulled' => 0, 'created >=' => $fechaTurnoFormateada, 'created <' => $fechaProximoDiaFormateada])
			->order(['bill_id' => 'ASC', 'created' => 'ASC']);
			
		$contadorReintegros = $reintegros->count();
			
		if ($contadorRegistros > 0)
		{
			$indicadorReintegros = 1;
		}
		
		$facturasCompensadas = $this->Concepts->Bills->find('all')
			->contain(['Parendsandguardians'])
			->where(['saldo_compensado >' => 0, 'annulled' => 0, 'created >=' => $fechaTurnoFormateada, 'created <' => $fechaProximoDiaFormateada])
			->order(['bill_id' => 'ASC', 'created' => 'ASC']);
			
		$contadorCompensadas = $facturasCompensadas->count();
			
		if ($contadorCompensadas > 0)
		{
			$indicadorCompensadas = 1;
		}
		
        $recibidoBancos = $this->Payments->find('all')
			->contain(['Bills'])
			->where(['turn' => $turn, 'annulled' => 0])
            ->order(['Payments.payment_type' => 'ASC', 'Payments.created' => 'ASC']);
				
		$resultado = [$paymentsTurn, $indicadorRecibos, $indicadorServiciosEducativos, $indicadorSobrantes, $pagosRecibos, $indicadorReintegros, $reintegros, $indicadorCompensadas, $facturasCompensadas, $recibidoBancos];

        return $resultado;
    }
}