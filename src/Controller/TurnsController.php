<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\PaymentsController;

use App\Controller\BinnaclesController;

use Cake\I18n\Time;


/**
 * Turns Controller
 *
 * @property \App\Model\Table\TurnsTable $Turns
 */
class TurnsController extends AppController
{
	public function pruebaFuncion()
	{
		/* $turn = $this->Turns->get(808);
		
		$this->loadModel('Bills');
		
		$anuladas = $this->Bills->find('all', ['conditions' => ['date_annulled >=' => $turn->start_date],
			'order' => ['Bills.created' => 'ASC']]);
			
		foreach ($anuladas as $anulada)
		{
			echo "<br /> Factura anulada " . $anulada->bill_number;
		} */
	}

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		if ($this->Auth->user('id') == 1)
		{
			$query = $this->Turns->find('all')
				->contain(['Users'])
				->order(['start_date' => 'DESC']);			
		}
		elseif ($this->Auth->user('id') == 978)
		{
			$query = $this->Turns->find('all')
				->contain(['Users'])
				->where(['user_id !=' => 1])
				->order(['start_date' => 'DESC']);			
		}
		else
		{
			$query = $this->Turns->find('all')
				->contain(['Users'])
				->where(['user_id' => $this->Auth->user('id')])
				->order(['start_date' => 'DESC']);
		}
   
		$this->set('turns', $this->paginate($query));
		
        $this->set(compact('turns'));
        $this->set('_serialize', ['turns']);
    }

    /**
     * View method
     *
     * @param string|null $id Turn id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $turn = $this->Turns->get($id, [
            'contain' => []
        ]);

        $this->set('turn', $turn);
        $this->set('_serialize', ['turn']);
    }

    public function checkTurnOpen()
    {
        $openTurn = $this->Turns->find('all')->where(['user_id' => $this->Auth->user('id'), 'status' => true]);
        
        $result = $openTurn->toArray(); 
        
        if ($result)
        {
            $this->Flash->error(__('Usted tiene un turno abierto, por favor ciérrelo primero para poder abrir otro'));    
        }
        else
        {
            return $this->redirect(['action' => 'add']);
        }
    }

    public function checkTurnClose()
    {
        $openTurn = $this->Turns->find('all')->where(['user_id' => $this->Auth->user('id'), 'status' => true]);
        
        $result = $openTurn->toArray(); 
        
        if ($result)
        {
            return $this->redirect(['action' => 'edit', $result[0]['id']]);
        }
        else
        {
            $this->Flash->error(__('Usted no tiene turnos abiertos'));    
        }
    }

    public function checkTurnInvoice($menuOption)
    {
        $openTurn = $this->Turns->find('all')->where(['user_id' => $this->Auth->user('id'), 'status' => true]);
        
        $result = $openTurn->toArray(); 
        
        if ($result)
        {
            setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
            date_default_timezone_set('America/Caracas');

            $dateTurn = $result[0]['start_date'];
            $dateTurni = $dateTurn->year . $dateTurn->month . $dateTurn->day;
            $currentDate = Time::now();
            $currentDatei = $currentDate->year . $currentDate->month . $currentDate->day;
            
            if ($dateTurni == $currentDatei)
            {
                if ($menuOption == 'Anular')
                {
                    return $this->redirect(['controller' => 'bills', 'action' => 'annulInvoice', $result[0]['id'], $result[0]['turn']]);
                }
				elseif ($menuOption == 'NC')
				{
					return $this->redirect(['controller' => 'bills', 'action' => 'notaContable']);
				}
				else
                {
                    return $this->redirect(['controller' => 'bills', 'action' => 'createInvoice', $menuOption, $result[0]['id'], $result[0]['turn']]);
                }
            }
            else
            {
                $this->Flash->error(__('Por favor cierre el turno, porque no coincide con la fecha de hoy y luego abra un turno nuevo')); 
            }
        }
        else
        {
            $this->Flash->error(__('Usted no tiene un turno abierto, por favor abra un turno para poder facturar o anular facturas'));    
        }
    }

    public function add()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
        
        $currentDate = Time::now();
        
        if ($currentDate->day < 10)
        {
            $startDate = "0" . $currentDate->day;
        }
        else
        {
            $startDate = $currentDate->day;
        }
        if ($currentDate->month < 10)
        {
            $startDate .= "/0" . $currentDate->month;
        }
        else
        {
            $startDate .= "/" . $currentDate->month;
        }
        $startDate .= "/" . $currentDate->year;
        
        $turn = $this->Turns->newEntity();
        if ($this->request->is('post')) 
        {
            $turn = $this->Turns->patchEntity($turn, $this->request->data);
            $turn->user_id = $this->Auth->user('id');
            $turn->start_date = Time::now();
            $turn->end_date = Time::now();
            $turn->status = 1;
            $turn->initial_cash = 0;
            $turn->cash_received = 0;
            $turn->cash_paid = 0;
            $turn->real_cash = 0;
            $turn->debit_card_amount = 0;
            $turn->real_debit_card_amount = 0;
            $turn->credit_card_amount = 0;
            $turn->real_credit_amount = 0;
            $turn->transfer_amount = 0;
            $turn->real_transfer_amount = 0;
            $turn->deposit_amount = 0;
            $turn->real_deposit_amount = 0;
            $turn->check_amount = 0;
            $turn->real_check_amount = 0;
            $turn->retention_amount = 0;
            $turn->real_retention_amount = 0;
            $turn->total_system = 0;
            $turn->total_box = 0;
            $turn->total_difference = 0;
            $turn->opening_supervisor = 0;
            $turn->supervisor_close = 0;
            if ($this->Turns->save($turn)) 
            {
                $this->Flash->success(__('El turno ha sido abierto satisfactoriamente'));
    
                return $this->redirect(['controller' => 'users', 'action' => 'wait']);
            } 
            else 
            {
                    $this->Flash->error(__('El turno no pudo ser abierto, intente de nuevo'));
            }
        }
        $this->set(compact('turn', 'startDate'));
        $this->set('_serialize', ['turn', 'startDate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Turn id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    public function edit($id = null)
    {
		$turn = $this->Turns->get($id);
            
        if ($turn->status == 0)
        {
            $this->Flash->error(__('Este turno ya fue cerrado anteriormente'));
            return $this->redirect(['controller' => 'users', 'action' => 'wait']);
        }

		if ($this->request->is(['patch', 'post', 'put'])) 
        {
            setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
            date_default_timezone_set('America/Caracas');
			
			$turn = $this->Turns->patchEntity($turn, $this->request->data);
        
            $turn->end_date = Time::now();
            $turn->status = 0;
			
            if ($this->Turns->save($turn))
            {
                return $this->redirect(['action' => 'imprimirReporteCierre', $turn->id]);
            }
            else 
            {
                $this->Flash->error(__('El turno no pudo ser cerrado, intente nuevamente'));
                return $this->redirect(['controller' => 'users', 'action' => 'wait']);
            }			
		}
		else
		{
			$this->loadModel('Bills');
			$this->loadModel('Monedas');	
			
			$payment = new PaymentsController();
			
			$lastNumber = 0;
			$lastControl = 0;
			
			$indicadorFacturasAnticipos = 0;
			$indicadorServiciosEducativos = 0;
			$indicadorReintegros = 0;
			$indicadorCompras = 0;
			$indicadorVueltoCompra = 0;
			$indicadorNotasCredito = 0;
			$indicadorNotasDebito = 0;
			$indicadorFacturasRecibos = 0;
			$indicadorSobrantes = 0;
			$indicadorFacturasAnuladas = 0;
			$indicadorRecibosAnulados = 0;
			$codigoRetornoResultado = 0;

			$vectorPagos = []; 
			$contadorNumero = 1;
					
			$moneda = $this->Monedas->get(2);
			$tasaDolar = $moneda->tasa_cambio_dolar; 
			
			$moneda = $this->Monedas->get(3);
			$tasaEuro = $moneda->tasa_cambio_dolar; 
			
			$tasaDolarEuro = round($tasaEuro / $tasaDolar, 2);
					
			$vectorTotalesRecibidos = $this->vectorTotalesRecibidos();
			
			$usuario = $this->Turns->Users->get($turn->user_id);
		
			$cajero = $usuario->first_name . ' ' . $usuario->surname; 
			
			$totalFormasPago = [];
			
			$totalFormasPago['Efectivo $'] = ['moneda' => '$', 'monto' => 0, 'montoBs' => 0];
			$totalFormasPago['Efectivo €'] = ['moneda' => '€', 'monto' => 0, 'montoBs' => 0];
			$totalFormasPago['Efectivo Bs.'] = ['moneda' => 'Bs.', 'monto' => 0, 'montoBs' => 0];
			$totalFormasPago['Zelle $'] = ['moneda' => '$', 'monto' => 0, 'montoBs' => 0];
			$totalFormasPago['Euros €'] = ['moneda' => '€', 'monto' => 0, 'montoBs' => 0];
			$totalFormasPago['TDB/TDC Bs.'] = ['moneda' => 'Bs.', 'monto' => 0, 'montoBs' => 0];
			$totalFormasPago['Transferencia Bs.'] = ['moneda' => 'Bs.', 'monto' => 0, 'montoBs' => 0];
			$totalFormasPago['Depósito Bs.'] = ['moneda' => 'Bs.', 'monto' => 0, 'montoBs' => 0];
			$totalFormasPago['Cheque Bs.'] = ['moneda' => 'Bs.', 'monto' => 0, 'montoBs' => 0];
			$totalFormasPago['Total general cobrado Bs.'] = ['moneda' => 'Bs.', 'monto' => "", 'montoBs' => 0];
			
			$totalDescuentosRecargos = 0;
			$totalGeneralSobrantes = 0;
			$totalGeneralReintegrosSobrantes = 0;
			$totalGeneralCompensado = 0; 
			$totalGeneralFacturado = 0;
			$totalFacturasRecibos = 0;
							
			$documentosAnulados = $this->Bills->find('all', ['conditions' => ['annulled' => true, 'turn' => $id],
				'order' => ['Bills.id' => 'ASC']]);
				
			$contadorAnulados = $documentosAnulados->count();
			
			if ($contadorAnulados > 0)
			{
				foreach ($documentosAnulados as $anulado)
				{
					if ($anulado->fiscal == 1)
					{
						$indicadorFacturasAnuladas = 1;
					}
					else
					{
						$indicadorRecibosAnulados = 1;
					}
				}
			}
								
			$resultado = $payment->busquedaPagosContabilidad($id);
			
			$codigoRetornoResultado = $resultado['codigoRetorno'];
			$facturas = $resultado['facturas'];
			$pagosFacturas = $resultado['pagosFacturas'];
						
			if ($codigoRetornoResultado != 1)
			{			
				foreach ($facturas as $factura)
				{
					$tasaDolarEuroFactura = round(($factura->tasa_euro / $factura->tasa_cambio), 5);
					
					if ($factura->tipo_documento == "Factura" || $factura->tipo_documento == "Recibo de anticipo" )
					{
						$indicadorFacturasAnticipos = 1;
						
						if ($factura->vector_sobrantes_compensados != null)
						{		
							$vectorSobrantesCompensados = json_decode($factura->vector_sobrantes_compensados, true);
							
							foreach ($vectorSobrantesCompensados as $sobranteCompensado)
							{
								$vectorTotalesRecibidos['Más compensaciones de sobrantes']['Efectivo $'] += $sobranteCompensado['saldoCompensado'];
								$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo $'] += $sobranteCompensado['saldoCompensado'];
							}	
						}
					}
					elseif ($factura->tipo_documento == "Recibo de servicio educativo")
					{
						$indicadorServiciosEducativos = 1;
					}
					elseif ($factura->tipo_documento == "Recibo de reintegro")
					{
						$indicadorReintegros = 1;
						
						if ($factura->moneda_id == 1)
						{
							$vectorTotalesRecibidos['Menos reintegros']['Efectivo Bs.'] -= $factura->amount_paid;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo Bs.'] -= $factura->amount_paid;	
						}
						elseif ($factura->moneda_id == 2)
						{
							$vectorTotalesRecibidos['Menos reintegros']['Efectivo $'] -= $factura->amount_paid;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo $'] -= $factura->amount_paid;	
						}					
						else
						{
							$vectorTotalesRecibidos['Menos reintegros']['Efectivo €'] -= $factura->amount_paid;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo €'] -= $factura->amount_paid;	
						}									
					}
					elseif ($factura->tipo_documento == "Recibo de compra")
					{
						$indicadorCompras = 1;
						
						if ($factura->moneda_id == 1)
						{
							$vectorTotalesRecibidos['Menos compras']['Efectivo Bs.'] -= $factura->amount_paid;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo Bs.'] -= $factura->amount_paid;	
						}
						elseif ($factura->moneda_id == 2)
						{
							$vectorTotalesRecibidos['Menos compras']['Efectivo $'] -= $factura->amount_paid;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo $'] -= $factura->amount_paid;	
						}					
						else
						{
							$vectorTotalesRecibidos['Menos compras']['Efectivo €'] -= $factura->amount_paid;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo €'] -= $factura->amount_paid;	
						}	
					}
					elseif ($factura->tipo_documento == "Recibo de vuelto de compra")
					{
						$indicadorVueltoCompra = 1;
						
						if ($factura->moneda_id == 1)
						{
							$vectorTotalesRecibidos['Más vueltos de compras']['Efectivo Bs.'] += $factura->amount_paid;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo Bs.'] += $factura->amount_paid;	
						}
						elseif ($factura->moneda_id == 2)
						{
							$vectorTotalesRecibidos['Más vueltos de compras']['Efectivo $'] += $factura->amount_paid;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo $'] += $factura->amount_paid;	
						}					
						else
						{
							$vectorTotalesRecibidos['Más vueltos de compras']['Efectivo €'] += $factura->amount_paid;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo €'] += $factura->amount_paid;	
						}	
					}
					elseif ($factura->tipo_documento == "Nota de crédito")
					{
						$montoDolarNC = round($factura->amount_paid / $factura->tasa_cambio, 2);
												
						$facturaOriginalNC = $this->Bills->get($factura->id_documento_padre);
						
						$montoDolarFacturaOriginal = round($facturaOriginalNC->amount_paid / $facturaOriginalNC->tasa_cambio, 2);
		
						$porcentajeFacturaOriginalNC = $montoDolarNC / $montoDolarFacturaOriginal;
															
						$pagosFacturaOriginal = $payment->busquedaPagosFactura($factura->id_documento_padre);
						
						$codigoRetornoPagos = $pagosFacturaOriginal['codigoRetorno'];
						
						if ($codigoRetornoPagos == 0)
						{
							$pagosOriginal = $pagosFacturaOriginal['pagosFactura'];	
							foreach ($pagosOriginal as $pagoOriginal)
							{
								switch ($pagoOriginal->payment_type) 
								{
									case "Efectivo":
										if ($pagoOriginal->moneda == "$")
										{
											$porcentajePagoIndividual = round($pagoOriginal->amount * $porcentajeFacturaOriginalNC, 2);
											$vectorTotalesRecibidos['Notas de crédito']['Efectivo $'] += $porcentajePagoIndividual;
											$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Efectivo $'] -= $porcentajePagoIndividual;
											$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo $'] -= $porcentajePagoIndividual;
										}
										elseif ($pagoOriginal->moneda == "€")
										{
											$porcentajePagoIndividual = round($pagoOriginal->amount * $porcentajeFacturaOriginalNC, 2);
											$vectorTotalesRecibidos['Notas de crédito']['Efectivo €'] += $porcentajePagoIndividual;
											$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Efectivo €'] -= $porcentajePagoIndividual;
											$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo €'] -= $porcentajePagoIndividual;
										}
										else
										{
											$montoDolarPagoOriginal = round($pagoOriginal->amount / $facturaOriginalNC->tasa_cambio, 2);
											$montoBolivaresPagoOriginalActualizado = round($montoDolarPagoOriginal * $factura->tasa_cambio, 2);											
											$porcentajePagoIndividual = round($montoBolivaresPagoOriginalActualizado * $porcentajeFacturaOriginalNC, 2);
											$vectorTotalesRecibidos['Notas de crédito']['Efectivo Bs.'] += $porcentajePagoIndividual;
											$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Efectivo Bs.'] -= $porcentajePagoIndividual;
											$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo Bs.'] -= $porcentajePagoIndividual;											
										}										
										break;
									case "Transferencia":
										if ($pagoOriginal->bank == "Zelle")
										{
											$porcentajePagoIndividual = round($pagoOriginal->amount * $porcentajeFacturaOriginalNC, 2);
											$vectorTotalesRecibidos['Notas de crédito']['Zelle $'] += $porcentajePagoIndividual;
											$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Zelle $'] -= $porcentajePagoIndividual;
											$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Zelle $'] -= $porcentajePagoIndividual;
										}
										elseif ($pagoOriginal->bank == "Euros")
										{
											$porcentajePagoIndividual = round($pagoOriginal->amount * $porcentajeFacturaOriginalNC, 2);
											$vectorTotalesRecibidos['Notas de crédito']['Euros €'] += $porcentajePagoIndividual;
											$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Euros €'] -= $porcentajePagoIndividual;
											$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Euros €'] -= $porcentajePagoIndividual;
										}
										else
										{
											$montoDolarPagoOriginal = round($pagoOriginal->amount / $facturaOriginalNC->tasa_cambio, 2);
											$montoBolivaresPagoOriginalActualizado = round($montoDolarPagoOriginal * $factura->tasa_cambio, 2);											
											$porcentajePagoIndividual = round($montoBolivaresPagoOriginalActualizado * $porcentajeFacturaOriginalNC, 2);
											$vectorTotalesRecibidos['Notas de crédito']['Transferencia Bs.'] += $porcentajePagoIndividual;
											$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Transferencia Bs.'] -= $porcentajePagoIndividual;
											$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Transferencia Bs.'] -= $porcentajePagoIndividual;											
										}										
										break;
									case "Tarjeta de débito":
										$montoDolarPagoOriginal = round($pagoOriginal->amount / $facturaOriginalNC->tasa_cambio, 2);
										$montoBolivaresPagoOriginalActualizado = round($montoDolarPagoOriginal * $factura->tasa_cambio, 2);											
										$porcentajePagoIndividual = round($montoBolivaresPagoOriginalActualizado * $porcentajeFacturaOriginalNC, 2);
										$vectorTotalesRecibidos['Notas de crédito']['TDB/TDC Bs.'] += $porcentajePagoIndividual;
										$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['TDB/TDC Bs.'] -= $porcentajePagoIndividual;
										$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['TDB/TDC Bs.'] -= $porcentajePagoIndividual;											
										break;
									case "Tarjeta de crédito":
										$montoDolarPagoOriginal = round($pagoOriginal->amount / $facturaOriginalNC->tasa_cambio, 2);
										$montoBolivaresPagoOriginalActualizado = round($montoDolarPagoOriginal * $factura->tasa_cambio, 2);											
										$porcentajePagoIndividual = round($montoBolivaresPagoOriginalActualizado * $porcentajeFacturaOriginalNC, 2);
										$vectorTotalesRecibidos['Notas de crédito']['TDB/TDC Bs.'] += $porcentajePagoIndividual;
										$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['TDB/TDC Bs.'] -= $porcentajePagoIndividual;
										$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['TDB/TDC Bs.'] -= $porcentajePagoIndividual;											
										break;
									case "Depósito":
										$montoDolarPagoOriginal = round($pagoOriginal->amount / $facturaOriginalNC->tasa_cambio, 2);
										$montoBolivaresPagoOriginalActualizado = round($montoDolarPagoOriginal * $factura->tasa_cambio, 2);											
										$porcentajePagoIndividual = round($montoBolivaresPagoOriginalActualizado * $porcentajeFacturaOriginalNC, 2);
										$vectorTotalesRecibidos['Notas de crédito']['Depósito Bs.'] += $porcentajePagoIndividual;
										$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Depósito Bs.'] -= $porcentajePagoIndividual;
										$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Depósito Bs.'] -= $porcentajePagoIndividual;											
										break;
									case "Cheque":
										$montoDolarPagoOriginal = round($pagoOriginal->amount / $facturaOriginalNC->tasa_cambio, 2);
										$montoBolivaresPagoOriginalActualizado = round($montoDolarPagoOriginal * $factura->tasa_cambio, 2);											
										$porcentajePagoIndividual = round($montoBolivaresPagoOriginalActualizado * $porcentajeFacturaOriginalNC, 2);
										$vectorTotalesRecibidos['Notas de crédito']['Cheque Bs.'] += $porcentajePagoIndividual;
										$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Cheque Bs.'] -= $porcentajePagoIndividual;
										$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Cheque Bs.'] -= $porcentajePagoIndividual;											
										break;
									default:
										break;
								}
							}
						}
						else
						{
							$this->Flash->error(__('No se encontraron pagos para la factura original con ID ' . $factura->id_documento_padre));
						}
						
						$indicadorNotasCredito = 1;
					}
					elseif ($factura->tipo_documento == "Nota de débito")
					{
						$indicadorNotasDebito = 1;
					}
					elseif ($factura->tipo_documento == "Recibo de sobrante")
					{
						$indicadorSobrantes = 1;
						$sobranteMenosReintegro = $factura->amount_paid - $factura->reintegro_sobrante;
						$totalGeneralSobrantes += $sobranteMenosReintegro;
						$totalGeneralReintegrosSobrantes += $factura->reintegro_sobrante;
						
						$vectorTotalesRecibidos['Menos sobrantes (vueltos pendientes por entregar)']['Efectivo $'] -= $sobranteMenosReintegro;
						$vectorTotalesRecibidos['Menos reintegros de vueltos de este turno']['Efectivo $'] -= $factura->reintegro_sobrante;
						$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo $'] -= $factura->amount_paid;	
					}
					
					if ($factura->id_anticipo > 0)
					{
						$indicadorFacturasRecibos = 1;
						$totalFacturasRecibos += $factura->amount_paid;
					}
					
					if ($factura->amount != 0)
					{
						$totalDescuentosRecargos += $factura->amount;

					}
					
					if ($factura->moneda_id == 1)
					{
						$montoFacturaBolivares = $factura->amount_paid;
						$montoFacturaDolares = round($factura->amount_paid / $factura->tasa_cambio, 2);				
					}
					elseif ($factura->moneda_id == 2)
					{
						$montoFacturaBolivares = round($factura->amount_paid * $factura->tasa_cambio, 2);
						$montoFacturaDolares = $factura->amount_paid;
					}
					else
					{
						$montoFacturaBolivares = round($factura->amount_paid * $factura->tasa_euro, 2);
						$montoFacturaDolares = round($factura->amount_paid * $tasaDolarEuroFactura, 2);
					}
					
					if ($factura->tipo_documento == "Factura" || $factura->tipo_documento == "Recibo de anticipo")
					{
						$totalGeneralCompensado += round($factura->saldo_compensado_dolar * $factura->tasa_cambio, 2);
						$totalGeneralFacturado += $factura->amount_paid;
					}
					
					$vectorPagos[$factura->id] = 
						['Nro' => $contadorNumero,
						'fecha' => $factura->date_and_time,
						'nroControl' => $factura->control_number,
						'nroFactura' => $factura->bill_number,
						'tipoDocumento' => $factura->tipo_documento,
						'familia' => $factura->parentsandguardian->family,
						'tasaDolar' => $factura->tasa_cambio,
						'tasaEuro' => $factura->tasa_euro,
						'tasaDolarEuro' => $tasaDolarEuroFactura,
						'totalFacturaBolivar' => $montoFacturaBolivares,
						'descuentoRecargo' => $factura->amount,
						'totalFacturaDolar' => $montoFacturaDolares,
						'efectivoDolar' => 0,
						'efectivoEuro' => 0,
						'efectivoBolivar' => 0,
						'zelleDolar' => 0,
						'euros' => 0,
						'tddTdcBolivar' => 0,
						'transferenciaBolivar' => 0,
						'depositoBolivar' => 0,
						'chequeBolivar' => 0,
						'compensadoDolar' => $factura->saldo_compensado_dolar,
						'totalCobradoDolar' => 0,
						'tasaTemporalDolar' => $factura->tasa_temporal_dolar,
						'tasaTemporalEuro' => $factura->tasa_temporal_euro,
						'cuotasAlumnoBecado' => $factura->cuotas_alumno_becado,
						'cambioMontoCuota' => $factura->cambio_monto_cuota];	
					$contadorNumero++;
				}
			}
			
			if ($codigoRetornoResultado == 0)
			{
				foreach ($pagosFacturas as $pago)
				{
					if ($pago->payment_type == "Efectivo" && $pago->moneda == "$")
					{
						$vectorPagos[$pago->bill->id]['efectivoDolar'] += $pago->amount;
						$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += $pago->amount;
											
						if ($pago->bill->tipo_documento == "Factura")
						{
							$vectorTotalesRecibidos['Facturas']['Efectivo $'] += $pago->amount;
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Efectivo $'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo $'] += $pago->amount; 
							$totalFormasPago['Efectivo $']['monto'] += $pago->amount;
							$totalFormasPago['Efectivo $']['montoBs'] += round($pago->amount * $pago->bill->tasa_cambio, 2);
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += round($pago->amount * $pago->bill->tasa_cambio, 2);
						}
						elseif ($pago->bill->tipo_documento == "Recibo de anticipo")
						{
							$vectorTotalesRecibidos['Anticipos de inscripción']['Efectivo $'] += $pago->amount; 
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Efectivo $'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo $'] += $pago->amount;
							$totalFormasPago['Efectivo $']['monto'] += $pago->amount;
							$totalFormasPago['Efectivo $']['montoBs'] += round($pago->amount * $pago->bill->tasa_cambio, 2);
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += round($pago->amount * $pago->bill->tasa_cambio, 2);
						}					
					}
					elseif ($pago->payment_type == "Efectivo" && $pago->moneda == "€")
					{
						$vectorPagos[$pago->bill->id]['efectivoEuro'] += $pago->amount;
						$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount * $pago->bill->tasa_dolar_euro, 2);

						if ($pago->bill->tipo_documento == "Factura")
						{
							$vectorTotalesRecibidos['Facturas']['Efectivo €'] += $pago->amount;
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Efectivo €'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo €'] += $pago->amount; 
							$totalFormasPago['Efectivo €']['monto'] += $pago->amount;
							$totalFormasPago['Efectivo €']['montoBs'] += round($pago->amount * $pago->bill->tasa_euro, 2);
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += round($pago->amount * $pago->bill->tasa_euro, 2);
						}
						elseif ($pago->bill->tipo_documento == "Recibo de anticipo")
						{
							$vectorTotalesRecibidos['Anticipos de inscripción']['Efectivo €'] += $pago->amount; 
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Efectivo €'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo €'] += $pago->amount;
							$totalFormasPago['Efectivo €']['monto'] += $pago->amount;
							$totalFormasPago['Efectivo €']['montoBs'] += round($pago->amount * $pago->bill->tasa_euro, 2);
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += round($pago->amount * $pago->bill->tasa_euro, 2);
						}				
					}
					elseif ($pago->payment_type == "Efectivo" && $pago->moneda == "Bs.")
					{
						$vectorPagos[$pago->bill->id]['efectivoBolivar'] += $pago->amount;
						$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio, 2);
						
						if ($pago->bill->tipo_documento == "Factura")
						{
							$vectorTotalesRecibidos['Facturas']['Efectivo Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Efectivo Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo Bs.'] += $pago->amount; 
							$totalFormasPago['Efectivo Bs.']['monto'] += $pago->amount;
							$totalFormasPago['Efectivo Bs.']['montoBs'] += $pago->amount;
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += $pago->amount;
						}
						elseif ($pago->bill->tipo_documento == "Recibo de anticipo")
						{
							$vectorTotalesRecibidos['Anticipos de inscripción']['Efectivo Bs.'] += $pago->amount; 
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Efectivo Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Efectivo Bs.'] += $pago->amount;
							$totalFormasPago['Efectivo Bs.']['monto'] += $pago->amount;
							$totalFormasPago['Efectivo Bs.']['montoBs'] += $pago->amount;
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += $pago->amount;
						}					
					}			
					elseif ($pago->payment_type == "Tarjeta de débito" && $pago->moneda == "Bs.")
					{
						$vectorPagos[$pago->bill->id]['tddTdcBolivar'] += $pago->amount;
						$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio, 2);
						
						if ($pago->bill->tipo_documento == "Factura")
						{
							$vectorTotalesRecibidos['Facturas']['TDB/TDC Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['TDB/TDC Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['TDB/TDC Bs.'] += $pago->amount; 
							$totalFormasPago['TDB/TDC Bs.']['monto'] += $pago->amount;
							$totalFormasPago['TDB/TDC Bs.']['montoBs'] += $pago->amount;
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += $pago->amount;
						}
						elseif ($pago->bill->tipo_documento == "Recibo de anticipo")
						{
							$vectorTotalesRecibidos['Anticipos de inscripción']['TDB/TDC Bs.'] += $pago->amount; 
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['TDB/TDC Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['TDB/TDC Bs.'] += $pago->amount;
							$totalFormasPago['TDB/TDC Bs.']['monto'] += $pago->amount;
							$totalFormasPago['TDB/TDC Bs.']['montoBs'] += $pago->amount;
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += $pago->amount;
						}								
					}
					elseif ($pago->payment_type == "Tarjeta de crédito" && $pago->moneda == "Bs.")
					{
						$vectorPagos[$pago->bill->id]['tddTdcBolivar'] += $pago->amount;
						$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio, 2);
						
						if ($pago->bill->tipo_documento == "Factura")
						{
							$vectorTotalesRecibidos['Facturas']['TDB/TDC Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['TDB/TDC Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['TDB/TDC Bs.'] += $pago->amount; 
							$totalFormasPago['TDB/TDC Bs.']['monto'] += $pago->amount;
							$totalFormasPago['TDB/TDC Bs.']['montoBs'] += $pago->amount;
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += $pago->amount;
						}
						elseif ($pago->bill->tipo_documento == "Recibo de anticipo")
						{
							$vectorTotalesRecibidos['Anticipos de inscripción']['TDB/TDC Bs.'] += $pago->amount; 
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['TDB/TDC Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['TDB/TDC Bs.'] += $pago->amount;
							$totalFormasPago['TDB/TDC Bs.']['monto'] += $pago->amount;
							$totalFormasPago['TDB/TDC Bs.']['montoBs'] += $pago->amount;
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += $pago->amount;
						}
					}			
					elseif ($pago->banco_receptor == "Zelle" && $pago->moneda == "$")
					{
						$vectorPagos[$pago->bill->id]['zelleDolar'] += $pago->amount;
						$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += $pago->amount;
						
						if ($pago->bill->tipo_documento == "Factura")
						{
							$vectorTotalesRecibidos['Facturas']['Zelle $'] += $pago->amount;
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Zelle $'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Zelle $'] += $pago->amount; 
							$totalFormasPago['Zelle $']['monto'] += $pago->amount;
							$totalFormasPago['Zelle $']['montoBs'] += round($pago->amount * $pago->bill->tasa_cambio, 2);
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += round($pago->amount * $pago->bill->tasa_cambio, 2);
						}
						elseif ($pago->bill->tipo_documento == "Recibo de anticipo")
						{
							$vectorTotalesRecibidos['Anticipos de inscripción']['Zelle $'] += $pago->amount; 
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Zelle $'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Zelle $'] += $pago->amount;
							$totalFormasPago['Zelle $']['monto'] += $pago->amount;
							$totalFormasPago['Zelle $']['montoBs'] += round($pago->amount * $pago->bill->tasa_cambio, 2);
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += round($pago->amount * $pago->bill->tasa_cambio, 2);
						}
					}
					elseif ($pago->banco_receptor == "Euros" && $pago->moneda == "€")
					{
						$vectorPagos[$pago->bill->id]['euros'] += $pago->amount;
						$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount * $pago->bill->tasa_dolar_euro, 2);
												
						if ($pago->bill->tipo_documento == "Factura")
						{
							$vectorTotalesRecibidos['Facturas']['Euros €'] += $pago->amount;
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Euros €'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Euros €'] += $pago->amount; 
							$totalFormasPago['Euros €']['monto'] += $pago->amount;
							$totalFormasPago['Euros €']['montoBs'] += round($pago->amount * $pago->bill->tasa_euro, 2);
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += round($pago->amount * $pago->bill->tasa_euro, 2);
						}
						elseif ($pago->bill->tipo_documento == "Recibo de anticipo")
						{
							$vectorTotalesRecibidos['Anticipos de inscripción']['Euros €'] += $pago->amount; 
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Euros €'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Euros €'] += $pago->amount;
							$totalFormasPago['Euros €']['monto'] += $pago->amount;
							$totalFormasPago['Euros €']['montoBs'] += round($pago->amount * $pago->bill->tasa_euro, 2);
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += round($pago->amount * $pago->bill->tasa_euro, 2);
						}				
					}
					elseif ($pago->payment_type == "Transferencia" && $pago->moneda == "Bs.")
					{
						$vectorPagos[$pago->bill->id]['transferenciaBolivar'] += $pago->amount;
						$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio, 2);
						
						if ($pago->bill->tipo_documento == "Factura")
						{
							$vectorTotalesRecibidos['Facturas']['Transferencia Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Transferencia Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Transferencia Bs.'] += $pago->amount; 
							$totalFormasPago['Transferencia Bs.']['monto'] += $pago->amount;
							$totalFormasPago['Transferencia Bs.']['montoBs'] += $pago->amount;
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += $pago->amount;
						}
						elseif ($pago->bill->tipo_documento == "Recibo de anticipo")
						{
							$vectorTotalesRecibidos['Anticipos de inscripción']['Transferencia Bs.'] += $pago->amount; 
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Transferencia Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Transferencia Bs.'] += $pago->amount;
							$totalFormasPago['Transferencia Bs.']['monto'] += $pago->amount;
							$totalFormasPago['Transferencia Bs.']['montoBs'] += $pago->amount;
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += $pago->amount;
						}					
					}			
					elseif ($pago->payment_type == "Depósito" && $pago->moneda == "Bs.")
					{
						$vectorPagos[$pago->bill->id]['depositoBolivar'] += $pago->amount;
						$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio, 2);
						
						if ($pago->bill->tipo_documento == "Factura")
						{
							$vectorTotalesRecibidos['Facturas']['Depósito Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Depósito Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Depósito Bs.'] += $pago->amount; 
							$totalFormasPago['Depósito Bs.']['monto'] += $pago->amount;
							$totalFormasPago['Depósito Bs.']['montoBs'] += $pago->amount;
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += $pago->amount;
						}
						elseif ($pago->bill->tipo_documento == "Recibo de anticipo")
						{
							$vectorTotalesRecibidos['Anticipos de inscripción']['Depósito Bs.'] += $pago->amount; 
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Depósito Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Depósito Bs.'] += $pago->amount;
							$totalFormasPago['Depósito Bs.']['monto'] += $pago->amount;
							$totalFormasPago['Depósito Bs.']['montoBs'] += $pago->amount;
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += $pago->amount;
						}				
					}				
					elseif ($pago->payment_type == "Cheque" && $pago->moneda == "Bs.")
					{
						$vectorPagos[$pago->bill->id]['chequeBolivar'] += $pago->amount;
						$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio, 2);
						
						if ($pago->bill->tipo_documento == "Factura")
						{
							$vectorTotalesRecibidos['Facturas']['Cheque Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Cheque Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Cheque Bs.'] += $pago->amount; 
							$totalFormasPago['Cheque Bs.']['monto'] += $pago->amount;
							$totalFormasPago['Cheque Bs.']['montoBs'] += $pago->amount;
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += $pago->amount;
						}
						elseif ($pago->bill->tipo_documento == "Recibo de anticipo")
						{
							$vectorTotalesRecibidos['Anticipos de inscripción']['Cheque Bs.'] += $pago->amount; 
							$vectorTotalesRecibidos['Total facturas - notas de crédito + anticipos de inscripción']['Cheque Bs.'] += $pago->amount;
							$vectorTotalesRecibidos['Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname')]['Cheque Bs.'] += $pago->amount;
							$totalFormasPago['Cheque Bs.']['monto'] += $pago->amount;
							$totalFormasPago['Cheque Bs.']['montoBs'] += $pago->amount;
							$totalFormasPago['Total general cobrado Bs.']['montoBs'] += $pago->amount;
						}					
					}	
				}
			}
			
			$turn->vector_pagos = json_encode($vectorPagos);
			$turn->vector_totales_recibidos = json_encode($vectorTotalesRecibidos);
			$turn->total_formas_pago = json_encode($totalFormasPago);
			$turn->total_descuentos_recargos = $totalDescuentosRecargos;
			$turn->total_general_sobrantes = $totalGeneralSobrantes;
			$turn->total_general_reintegros_sobrantes = $totalGeneralReintegrosSobrantes;
			$turn->total_general_compensado = $totalGeneralCompensado;
			$turn->total_general_facturado = $totalGeneralFacturado;
			$turn->total_facturas_recibos = $totalFacturasRecibos;
			$turn->tasa_dolar = $tasaDolar;
			$turn->tasa_euro = $tasaEuro;
			$turn->tasa_euro_dolar = $tasaDolarEuro;
 			
            if (!($this->Turns->save($turn)))
            {
				$this->Flash->error(__('No se pudieron guardar los contadores del turno, por favor intente nuevamente'));
                return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
            }
			
			$ultimoRegistro = $this->Bills->find('all', ['conditions' => ['turn' => $id, 'fiscal' => 1],
				'order' => ['created' => 'DESC'] ]);

			$contadorRegistro = $ultimoRegistro->count();
				
			if ($contadorRegistro > 0)
			{	
				$factura = $ultimoRegistro->first();

				$lastNumber = $factura->bill_number;
				$lastControl = $factura->control_number;
			}
			
			$vista = "turnsEdit";
													
			$this->set(compact
				('turn',
				'lastNumber',
				'lastControl',
				'facturas',
				'vectorPagos',
				'cajero',
				'vectorTotalesRecibidos',
				'totalFormasPago',
				'totalDescuentosRecargos',
				'totalGeneralCompensado',
				'totalGeneralFacturado',
				'totalFacturasRecibos',
				'tasaDolar',
				'tasaEuro',
				'indicadorFacturasAnticipos',
				'indicadorServiciosEducativos',
				'indicadorReintegros',
				'indicadorCompras',
				'indicadorVueltoCompra',
				'indicadorNotasCredito',
				'indicadorNotasDebito',
				'indicadorSobrantes',
				'indicadorFacturasRecibos',
				'indicadorFacturasAnuladas',
				'indicadorRecibosAnulados',
				'documentosAnulados',
				'totalGeneralSobrantes',
				'totalGeneralReintegrosSobrantes',
				'vista'));	
				
			$this->set('_serialize', 
				['turn',
				'lastNumber',
				'lastControl',				
				'facturas',
				'vectorPagos', 
				'cajero', 
				'vectorTotalesRecibidos', 
				'totalFormasPago',
				'totalDescuentosRecargos',				
				'totalGeneralCompensado', 
				'totalGeneralFacturado', 
				'totalFacturasRecibos',
				'tasaDolar', 
				'tasaEuro',
				'indicadorFacturasAnticipos',
				'indicadorServiciosEducativos',
				'indicadorReintegros',
				'indicadorCompras',
				'indicadorVueltoCompra',
				'indicadorNotasCredito',
				'indicadorNotasDebito',
				'indicadorSobrantes',
				'indicadorFacturasRecibos',
				'indicadorFacturasAnuladas',
				'indicadorRecibosAnulados',
				'documentosAnulados',
				'totalGeneralSobrantes',
				'totalGeneralReintegrosSobrantes',
				'vista']);
		}
	}
    
    function closeTurn()
    {
        $this->autoRender = false;
        
        if ($this->request->is('post')) 
        {
            $turnData = $_POST['turnData']; 
            $_POST = [];

            $turn = $this->Turns->get($turnData['id']);   
            
            if ($turn->status == 0)
            {
                $this->Flash->error(__('Este turno ya fue cerrado anteriormente'));
                return $this->redirect(['controller' => 'users', 'action' => 'wait']);
            }

            setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
            date_default_timezone_set('America/Caracas');
        
            $turn->end_date = Time::now();
            $turn->status = 0;
            $turn->cash_received = $turnData['cashReceived'];
            $turn->real_cash = $turnData['realCash'];
            $turn->debit_card_amount = $turnData['debitCardAmount'];
            $turn->real_debit_card_amount = $turnData['realDebitCardAmount'];
            $turn->credit_card_amount = $turnData['creditCardAmount'];
            $turn->real_credit_amount = $turnData['realCreditCardAmount'];
            $turn->transfer_amount = $turnData['transferAmount'];
            $turn->real_transfer_amount = $turnData['realTransferAmount'];
            $turn->deposit_amount = $turnData['depositAmount'];
            $turn->real_deposit_amount = $turnData['realDepositAmount'];
            $turn->check_amount = $turnData['checkAmount'];
            $turn->real_check_amount = $turnData['realCheckAmount'];
            $turn->retention_amount = $turnData['retentionAmount'];
            $turn->real_retention_amount = $turnData['realRetentionAmount'];
            $turn->total_system = $turnData['totalSystem'];
            $turn->total_box = $turnData['totalBox'];
            $turn->total_difference = $turnData['totalDifference'];

            if ($this->Turns->save($turn))
            {
                return $this->redirect(['action' => 'printClose', $turnData['id']]);
            }
            else 
            {
                $this->Flash->error(__('El turno no pudo ser cerrado, intente nuevamente'));
                return $this->redirect(['controller' => 'users', 'action' => 'wait']);
            }
        }
    }
    
    function printClose($idTurn = null)
    {
        $this->Flash->success(__('Cierre de turno guardado con el número: ' . $idTurn));

        $this->set(compact('idTurn'));
        $this->set('_serialize', ['idTurn']);
    }

    public function turnpdf($idTurn = null, $cajero = null)
    {
        $payment = new PaymentsController();
        
        $turn = $this->Turns->get($idTurn); 
				
		$fechaTurnoFormateada = date_format($turn->start_date, "Y-m-d");
		$fechaTurno = $turn->start_date;
		$fechaProximoDia = $fechaTurno->addDay(1);
		$fechaProximoDiaFormateada = date_format($fechaProximoDia, "Y-m-d");
				
        $resultado = $payment->searchPayments($idTurn, $fechaTurnoFormateada, $fechaProximoDiaFormateada);
        
		$paymentsTurn = $resultado[0];
		$indicadorServicioEducativo = $resultado[1];
		$pagosServicioEducativo = $resultado[2];
		
        $receipt = 0;
        
        foreach ($paymentsTurn as $paymentsTurns) 
        {
            if ($paymentsTurns->fiscal == 0)
            {
                $receipt = 1;
				break;
            }			
        }
		
		$this->loadModel('Bills');
		
		$notasContables = $this->Bills->find('all', ['conditions' => ['turn' => $idTurn, 'OR' => [['tipo_documento' => 'Nota de crédito'], ['tipo_documento' => 'Nota de débito']]],
			'order' => ['Bills.created' => 'ASC'],
			'contain' => ['Parentsandguardians']]);
			
		$contadorNotas = $notasContables->count();
		$indicadorNotasCredito = 0;
		$totalNotasCredito = 0;
		$indicadorNotasDebito = 0;
		$totalNotasDebito = 0;
		
		if ($contadorNotas > 0)
		{
			foreach ($notasContables as $notas)
			{
				if ($notas->tipo_documento == "Nota de crédito")
				{
					$indicadorNotasCredito = 1;
					$totalNotasCredito += $notas->amount_paid;
				}
				else
				{
					$indicadorNotasDebito = 1;
					$totalNotasDebito += $notas->amount_paid;
				}
			}
		}
		
		$facturasRecibo = $this->Bills->find('all', ['conditions' => ['turn' => $idTurn, 'id_anticipo >' => 0],
			'order' => ['Bills.created' => 'ASC'],
			'contain' => ['Parentsandguardians']]);
			
		$contadorFacturasRecibo = $facturasRecibo->count();
		$indicadorFacturasRecibo = 0;
		$totalFacturasRecibo = 0;
		
		if ($contadorFacturasRecibo > 0)
		{
			$indicadorFacturasRecibo = 1;
			foreach ($facturasRecibo as $factura)
			{
				$totalFacturasRecibo += $factura->amount_paid;
			}
		}		
		
		$anuladas = $this->Bills->find('all', ['conditions' => ['date_annulled >=' => $turn->start_date],
			'order' => ['Bills.created' => 'ASC']]);
			
		$contadorAnuladas = $anuladas->count();
		$indicadorAnuladas = 0;
		
		if ($contadorAnuladas > 0)
		{
			$indicadorAnuladas = 1;
		}				
		
        $this->viewBuilder()
            ->className('Dompdf.Pdf')
            ->layout('default')
            ->options(['config' => [
                'filename' => $idTurn,
                'render' => 'browser',
            ]]);
			
		if (!(isset($cajero)))
		{
			$cajero = "";
		}

        $this->set(compact('turn', 'paymentsTurn', 'receipt', 'indicadorServicioEducativo', 'pagosServicioEducativo', 'indicadorNotasCredito', 'indicadorNotasDebito', 'notasContables', 'totalNotasCredito', 'totalNotasDebito', 'facturasRecibo', 'indicadorFacturasRecibo', 'totalFacturasRecibo', 'anuladas', 'indicadorAnuladas', 'contadorAnuladas', 'cajero'));
        $this->set('_serialize', ['turn', 'paymentsTurn', 'receipt', 'indicadorServicioEducativo', 'pagosServicioEducativo', 'indicadorNotasCredito', 'indicadorNotasDebito', 'notasContables', 'totalNotasCredito', 'totalNotasDebito', 'facturasRecibo', 'indicadorFacturasRecibo', 'totalFacturasRecibo', 'anuladas', 'indicadorAnuladas', 'contadorAnuladas', 'cajero']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Turn id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $turn = $this->Turns->get($id);
        if ($this->Turns->delete($turn)) {
            $this->Flash->success(__('The turn has been deleted.'));
        } else {
            $this->Flash->error(__('The turn could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function monetaryReconversion()
    {				
		$binnacles = new BinnaclesController;
	
		$turns = $this->Turns->find('all', ['conditions' => ['id >' => 0]]);
	
		$account1 = $turns->count();
			
		$account2 = 0;
		
		foreach ($turns as $turn)
        {		
			$turnGet = $this->Turns->get($turn->id);
			
			$previousAmount = $turnGet->initial_cash;
										
			$turnGet->initial_cash = $previousAmount / 100000;	

			$previousAmount = $turnGet->cash_received;
										
			$turnGet->cash_received = $previousAmount / 100000;	
			
			$previousAmount = $turnGet->cash_paid;
										
			$turnGet->cash_paid = $previousAmount / 100000;	
			
			$previousAmount = $turnGet->real_cash;
										
			$turnGet->real_cash = $previousAmount / 100000;	
			
			$previousAmount = $turnGet->debit_card_amount;
										
			$turnGet->debit_card_amount = $previousAmount / 100000;	
			
			$previousAmount = $turnGet->real_debit_card_amount;
										
			$turnGet->real_debit_card_amount = $previousAmount / 100000;	
			
			$previousAmount = $turnGet->credit_card_amount;
										
			$turnGet->credit_card_amount = $previousAmount / 100000;	
			
			$previousAmount = $turnGet->real_credit_amount;
										
			$turnGet->real_credit_amount = $previousAmount / 100000;	
					
			$previousAmount = $turnGet->transfer_amount;
										
			$turnGet->transfer_amount = $previousAmount / 100000;	
			
			$previousAmount = $turnGet->real_transfer_amount;
										
			$turnGet->real_transfer_amount = $previousAmount / 100000;
			
			$previousAmount = $turnGet->deposit_amount;
										
			$turnGet->deposit_amount = $previousAmount / 100000;	
			
			$previousAmount = $turnGet->real_deposit_amount;
										
			$turnGet->real_deposit_amount = $previousAmount / 100000;	
			
			$previousAmount = $turnGet->check_amount;
										
			$turnGet->check_amount = $previousAmount / 100000;	
			
			$previousAmount = $turnGet->real_check_amount;
										
			$turnGet->real_check_amount = $previousAmount / 100000;	
			
			$previousAmount = $turnGet->retention_amount;
										
			$turnGet->retention_amount = $previousAmount / 100000;
			
			$previousAmount = $turnGet->real_retention_amount;
										
			$turnGet->real_retention_amount = $previousAmount / 100000;	
			
			$previousAmount = $turnGet->total_system;
										
			$turnGet->total_system = $previousAmount / 100000;	
			
			$previousAmount = $turnGet->total_box;
										
			$turnGet->total_box = $previousAmount / 100000;	
			
			$previousAmount = $turnGet->total_difference;
										
			$turnGet->total_difference = $previousAmount / 100000;	
						
			if ($this->Turns->save($turnGet))
			{
				$account2++;
			}
			else
			{
				$binnacles->add('controller', 'Turns', 'monetaryReconversion', 'No se actualizó registro con id: ' . $turnGet->id);
			}
		}

		$binnacles->add('controller', 'Turns', 'monetaryReconversion', 'Total registros seleccionados: ' . $account1);
		$binnacles->add('controller', 'Turns', 'monetaryReconversion', 'Total registros actualizados: ' . $account2);
		
		return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
	}
	public function objetoTotalesFiscales()
	{
		$formaPago = 
			['Efectivo',
			'Tarjeta de débito',
			'Tarjeta de crédito',
			'Depósito',
            'Transferencia',
            'Cheque',
            'Retención de impuesto'];
			
		$monedas = ['$', '€', 'Bs.'];

		$vectorTotalesFiscales = [];
				
		foreach($formaPago as $forma)
		{
			foreach ($monedas as $moneda)
			{
				$vectorTotalesFiscales[] = ['formaPago' => $forma, 'moneda' => $moneda, 'monto' => 0];
			}
		}
		
		$jsonTotalesFiscales = json_encode($vectorTotalesFiscales, JSON_FORCE_OBJECT);
		
		$objetoTotalesFiscales = json_decode($jsonTotalesFiscales);
						
		Return $objetoTotalesFiscales;
	}
	
	public function objetoAnticipos()
	{
		$formaPago = 
			['Efectivo',
			'Tarjeta de débito',
			'Tarjeta de crédito',
			'Depósito',
            'Transferencia',
            'Cheque',
            'Retención de impuesto'];
			
		$monedas = ['$', '€', 'Bs.'];

		$vectorAnticipos = [];
				
		foreach($formaPago as $forma)
		{
			foreach ($monedas as $moneda)
			{
				$vectorAnticipos[] = ['formaPago' => $forma, 'moneda' => $moneda, 'monto' => 0];
			}
		}
		
		$jsonAnticipos = json_encode($vectorAnticipos, JSON_FORCE_OBJECT);
		
		$objetoAnticipos = json_decode($jsonAnticipos);
						
		Return $objetoAnticipos;
	}
	
	public function objetoServiciosEducativos()
	{
		$formaPago = 
			['Efectivo',
			'Tarjeta de débito',
			'Tarjeta de crédito',
			'Depósito',
            'Transferencia',
            'Cheque',
            'Retención de impuesto'];
			
		$monedas = ['$', '€', 'Bs.'];

		$vectorServiciosEducativos = [];
				
		foreach($formaPago as $forma)
		{
			foreach ($monedas as $moneda)
			{
				$vectorServiciosEducativos[] = ['formaPago' => $forma, 'moneda' => $moneda, 'monto' => 0];
			}
		}
		
		$jsonServiciosEducativos = json_encode($vectorServiciosEducativos, JSON_FORCE_OBJECT);
		
		$objetoServiciosEducativos = json_decode($jsonServiciosEducativos);
						
		Return $objetoServiciosEducativos;
	}
	
	public function objetoBancosReceptores()
	{
		$bancos = 
			['Banesco',
			'Plaza',
			'Provincial',
			'Venezuela',
            'Zelle'];
			
		$monedas = ['$', '€', 'Bs.'];

		$vectorBancosReceptores = [];
				
		foreach($bancos as $banco)
		{
			foreach ($monedas as $moneda)
			{
				$vectorBancosReceptores[] = ['banco' => $banco, 'moneda' => $moneda, 'monto' => 0];
			}
		}
		
		$jsonBancos = json_encode($vectorBancosReceptores, JSON_FORCE_OBJECT);
		
		$objetoBancosReceptores = json_decode($jsonBancos);
		
		Return $objetoBancosReceptores;
	}
	
	public function vectorTotalesRecibidos()
	{
		$renglonTotal = 
			['Facturas',
			'Notas de crédito',
			'Anticipos de inscripción',
			'Total facturas - notas de crédito + anticipos de inscripción',
			'Menos reintegros',
			'Menos compras',
			'Menos sobrantes (vueltos pendientes por entregar)',
			'Menos reintegros de vueltos de este turno',
			'Más vueltos de compras',
			'Más compensaciones de sobrantes',
			'Total a recibir de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname'),
            'Total recibido de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname'),
            'Diferencia'];
			
		$vectorTotalesRecibidos = [];
				
		foreach($renglonTotal as $renglon)
		{
			if ($renglon == 'Total recibido de ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('surname') || $renglon == "Diferencia")
			{
				$vectorTotalesRecibidos[$renglon] = 
					['Efectivo $' => "",
					'Efectivo €' => "",
					'Efectivo Bs.' => "",
					'Zelle $' => "",
					'Euros €' => "",
					'TDB/TDC Bs.' => "",
					'Transferencia Bs.' => "",
					'Depósito Bs.' => "", 
					'Cheque Bs.' => ""];				
			}
			else
			{
				$vectorTotalesRecibidos[$renglon] = 
					['Efectivo $' => 0,
					'Efectivo €' => 0,
					'Efectivo Bs.' => 0,
					'Zelle $' => 0,
					'Euros €' => 0,
					'TDB/TDC Bs.' => 0,
					'Transferencia Bs.' => 0,
					'Depósito Bs.' => 0, 
					'Cheque Bs.' => 0];
			}
		}
							
		Return $vectorTotalesRecibidos;
	}
	
    function imprimirReporteCierre($idTurn = null)
    {
        $this->Flash->success(__('Cierre de turno guardado con el número: ' . $idTurn));

        $this->set(compact('idTurn'));
        $this->set('_serialize', ['idTurn']);
    }
	
    public function reporteCierre($id = null)
    {
		$turn = $this->Turns->get($id);
            
        if ($turn->status == 1)
        {
            $this->Flash->error(__('Este turno no ha sido cerrado'));
            return $this->redirect(['controller' => 'users', 'action' => 'wait']);
        }

		$this->loadModel('Bills');		
		$payment = new PaymentsController();
					
		$indicadorFacturasAnticipos = 0;
		$indicadorServiciosEducativos = 0;
		$indicadorReintegros = 0;
		$indicadorCompras = 0;
		$indicadorVueltoCompra = 0;
		$indicadorNotasCredito = 0;
		$indicadorNotasDebito = 0;
		$indicadorFacturasRecibos = 0;
		$indicadorSobrantes = 0;
		$indicadorSobrantesRegistrados = 0;
		$indicadorFacturasAnuladas = 0;
		$indicadorRecibosAnulados = 0;
		$codigoRetornoResultado = 0;
		$indicadorDescuentosRecargosRegistrados = 0;
							
		$usuario = $this->Turns->Users->get($turn->user_id);
	
		$cajero = $usuario->first_name . ' ' . $usuario->surname;

		$vectorPagos = json_decode($turn->vector_pagos, true);
		$vectorTotalesRecibidos = json_decode($turn->vector_totales_recibidos, true);
		$totalFormasPago = json_decode($turn->total_formas_pago, true);
		
		$totalGeneralSobrantes = $turn->total_general_sobrantes;
		$totalGeneralReintegrosSobrantes = $turn->total_general_reintegros_sobrantes;
		
		if ($totalGeneralSobrantes > 0 || $totalGeneralReintegrosSobrantes > 0)
		{
			$indicadorSobrantesRegistrados = 1;
		}
		
		$totalDescuentosRecargos = $turn->total_descuentos_recargos;
		
		if ($totalDescuentosRecargos != 0)
		{
			$indicadorDescuentosRecargosRegistrados = 1;
		}
		
		$totalGeneralCompensado = $turn->total_general_compensado;
		$totalGeneralFacturado = $turn->total_general_facturado;
		$totalFacturasRecibos = $turn->total_facturas_recibos;
		
		if ($totalFacturasRecibos > 0)
		{
			$indicadorFacturasRecibos = 1;
		}
		
		$tasaDolar = $turn->tasa_dolar;
		$tasaEuro = $turn->tasa_euro;
		
		$documentosAnulados = $this->Bills->find('all', ['conditions' => ['annulled' => true, 'turn' => $id],
			'order' => ['Bills.id' => 'ASC']]);
			
		$contadorAnulados = $documentosAnulados->count();
		
		if ($contadorAnulados > 0)
		{
			foreach ($documentosAnulados as $anulado)
			{
				if ($anulado->fiscal == 1)
				{
					$indicadorFacturasAnuladas = 1;
				}
				else
				{
					$indicadorRecibosAnulados = 1;
				}
			}
		}
							
		$resultado = $payment->busquedaPagosContabilidad($id);
		
		$codigoRetornoResultado = $resultado['codigoRetorno'];
		$facturas = $resultado['facturas'];
		$pagosFacturas = $resultado['pagosFacturas'];
			
		if ($codigoRetornoResultado != 1)
		{
			foreach ($facturas as $factura)
			{
				if ($factura->tipo_documento == "Factura" || $factura->tipo_documento == "Recibo de anticipo" )
				{
					$indicadorFacturasAnticipos = 1;
				}
				elseif ($factura->tipo_documento == "Recibo de servicio educativo")
				{
					$indicadorServiciosEducativos = 1;
				}
				elseif ($factura->tipo_documento == "Recibo de reintegro")
				{
					$indicadorReintegros = 1;									
				}
				elseif ($factura->tipo_documento == "Recibo de compra")
				{
					$indicadorCompras = 1;
				}
				elseif ($factura->tipo_documento == "Recibo de vuelto de compra")
				{
					$indicadorVueltoCompra = 1;
				}
				elseif ($factura->tipo_documento == "Nota de crédito")
				{
					$indicadorNotasCredito = 1;
				}
				elseif ($factura->tipo_documento == "Nota de débito")
				{
					$indicadorNotasDebito = 1;
				}
				elseif ($factura->tipo_documento == "Recibo de sobrante")
				{
					$indicadorSobrantes = 1;
					if ($indicadorSobrantesRegistrados == 0)
					{
						$sobranteMenosReintegro = $factura->amount_paid - $factura->reintegro_sobrante;
						$totalGeneralSobrantes += $sobranteMenosReintegro;
						$totalGeneralReintegrosSobrantes += $factura->reintegro_sobrante;
					}
				}
								
				if ($factura->amount != 0)
				{
					if ($indicadorDescuentosRecargosRegistrados == 0)
					{
						$totalDescuentosRecargos += $factura->amount;
					}
				}
			}
		}
															
		$this->set(compact
			('turn',
			'facturas',
			'vectorPagos',
			'cajero',
			'vectorTotalesRecibidos',
			'totalFormasPago',
			'totalDescuentosRecargos',
			'totalGeneralCompensado',
			'totalGeneralFacturado',
			'totalFacturasRecibos',
			'tasaDolar',
			'tasaEuro',
			'indicadorFacturasAnticipos',
			'indicadorServiciosEducativos',
			'indicadorReintegros',
			'indicadorCompras',
			'indicadorVueltoCompra',
			'indicadorNotasCredito',
			'indicadorNotasDebito',
			'indicadorFacturasRecibos',
			'indicadorSobrantes',
			'indicadorFacturasAnuladas',
			'indicadorRecibosAnulados',
			'documentosAnulados',
			'totalGeneralSobrantes',
			'totalGeneralReintegrosSobrantes'));	
			
		$this->set('_serialize', 
			['turn',
			'facturas',
			'vectorPagos', 
			'cajero', 
			'vectorTotalesRecibidos', 
			'totalFormasPago', 
			'totalDescuentosRecargos',
			'totalGeneralCompensado', 
			'totalGeneralFacturado', 
			'totalFacturasRecibos',
			'tasaDolar', 
			'tasaEuro',
			'indicadorFacturasAnticipos',
			'indicadorServiciosEducativos',
			'indicadorReintegros',
			'indicadorCompras',
			'indicadorNotasCredito',
			'indicadorNotasDebito',
			'indicadorFacturasRecibos',
			'indicadorSobrantes',
			'indicadorFacturasAnuladas',
			'indicadorRecibosAnulados',
			'documentosAnulados',
			'totalGeneralSobrantes',
			'totalGeneralReintegrosSobrantes']);	
	}
	
    public function excelDocumentos($id = null)
    {
		$payment = new PaymentsController();
		
		$vectorPagos = []; 
		
		$contadorNumero = 1;
					
		$turn = $this->Turns->get($id);
            		
		$usuario = $this->Turns->Users->get($turn->user_id);
		
		$cajero = $usuario->first_name . ' ' . $usuario->surname; 
							
		$resultado = $payment->busquedaPagosContabilidad($id);
				
		if ($resultado['codigoRetorno'] != 0)
		{
			$this->Flash->error(__('No se encontraron pagos en este turno'));
            return $this->redirect(['controller' => 'users', 'action' => 'wait']);						
		}
		
		$facturas = $resultado['facturas'];
		$pagosFacturas = $resultado['pagosFacturas'];
		
		foreach ($facturas as $factura)
		{
			if ($factura->moneda_id == 1)
			{
				$montoFacturaBolivares = $factura->amount_paid;
				$montoFacturaDolares = round($factura->amount_paid / $factura->tasa_cambio, 2);				
			}
			elseif ($factura->moneda_id == 2)
			{
				$montoFacturaBolivares = round($factura->amount_paid * $factura->tasa_cambio, 2);
				$montoFacturaDolares = $factura->amount_paid;
			}
			else
			{
				$montoFacturaBolivares = round($factura->amount_paid * $factura->tasa_euro, 2);
				$montoFacturaDolares = round($factura->amount_paid * $factura->tasa_dolar_euro, 2);
			}
			
			$vectorPagos[$factura->id] = 
				['Nro' => $contadorNumero,
				'fechaHora' => $factura->date_and_time,
				'nroFactura' => $factura->bill_number,
				'nroControl' => $factura->control_number,
				'tipoDocumento' => $factura->tipo_documento,
				'familia' => $factura->parentsandguardian->family,
				'tasaDolar' => $factura->tasa_cambio,
				'tasaEuro' => $factura->tasa_euro,
				'tasaDolarEuro' => $factura->tasa_dolar_euro,
				'totalFacturaBolivar' => $montoFacturaBolivares,
				'efectivoDolar' => 0,
				'efectivoEuro' => 0,
				'efectivoBolivar' => 0,
				'zelleDolar' => 0,
				'euros' => 0,
				'tddTdcBolivar' => 0,
				'transferenciaBolivar' => 0,
				'depositoBolivar' => 0,
				'chequeBolivar' => 0,
				'totalFacturadoDolar' => $montoFacturaDolares,
				'ncNdDolar' => $factura->saldo_compensado_dolar,
				'totalCobradoDolar' => 0];	
			$contadorNumero++;
		}
		
		foreach ($pagosFacturas as $pago)
		{
			$tasaDolarEuroFactura = round($pago->bill->tasa_euro / $pago->bill->tasa_cambio, 5);
			
			if ($pago->payment_type == "Efectivo" && $pago->moneda == "$")
			{
				$vectorPagos[$pago->bill->id]['efectivoDolar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += $pago->amount;
			}
			elseif ($pago->payment_type == "Efectivo" && $pago->moneda == "€")
			{
				$vectorPagos[$pago->bill->id]['efectivoEuro'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount * $tasaDolarEuroFactura, 2);
			}
			elseif ($pago->payment_type == "Efectivo" && $pago->moneda == "Bs.")
			{
				$vectorPagos[$pago->bill->id]['efectivoBolivar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio, 2);
			}			
			elseif ($pago->payment_type == "Tarjeta de débito" && $pago->moneda == "Bs.")
			{
				$vectorPagos[$pago->bill->id]['tddTdcBolivar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio, 2);
			}
			elseif ($pago->payment_type == "Tarjeta de crédito" && $pago->moneda == "Bs.")
			{
				$vectorPagos[$pago->bill->id]['tddTdcBolivar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio, 2);
			}			
			elseif ($pago->banco_receptor == "Zelle" && $pago->moneda == "$")
			{
				$vectorPagos[$pago->bill->id]['zelleDolar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += $pago->amount;
			}
			elseif ($pago->banco_receptor == "Euros" && $pago->moneda == "€")
			{
				$vectorPagos[$pago->bill->id]['euros'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount * $tasaDolarEuroFactura, 2);
			}
			elseif ($pago->payment_type == "Transferencia" && $pago->moneda == "Bs.")
			{
				$vectorPagos[$pago->bill->id]['transferenciaBolivar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio, 2);
			}			
			elseif ($pago->payment_type == "Depósito" && $pago->moneda == "Bs.")
			{
				$vectorPagos[$pago->bill->id]['depositoBolivar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio, 2);
			}				
			elseif ($pago->payment_type == "Cheque" && $pago->moneda == "Bs.")
			{
				$vectorPagos[$pago->bill->id]['chequeBolivar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio, 2);
			}						
		}
							
		$this->set(compact('turn', 'vectorPagos', 'cajero'));
		$this->set('_serialize', ['turn', 'vectorPagos', 'cajero']);
	}
	
    public function excelPagos($id = null)
    {
		$payment = new PaymentsController();
		
		$vectorPagos = []; 
		$contador = 0;
		$contadorNumero = 1;
		$montoFacturaBolivares = 0;
		$montoFacturaDolares = 0;
					
		$turn = $this->Turns->get($id);
            
        if ($turn->status == 1)
        {
            $this->Flash->error(__('Este turno no se ha cerrado'));
            return $this->redirect(['controller' => 'users', 'action' => 'wait']);
        }
		
		$usuario = $this->Turns->Users->get($turn->user_id);
		
		$cajero = $usuario->first_name . ' ' . $usuario->surname; 
							
		$resultado = $payment->busquedaPagosContabilidad($id);
				
		if ($resultado['codigoRetorno'] != 0)
		{
			$this->Flash->error(__('No se encontraron pagos en este turno'));
            return $this->redirect(['controller' => 'users', 'action' => 'wait']);						
		}
		
		$facturas = $resultado['facturas'];
		$pagosFacturas = $resultado['pagosFacturas'];
		
		foreach ($facturas as $factura)
		{
			foreach ($pagosFacturas as $pago)
			{				
				if ($factura->id == $pago->bill->id)
				{		
					if ($factura->moneda_id == 1)
					{
						$montoFacturaBolivares = $factura->amount_paid;
						$montoFacturaDolares = round($factura->amount_paid / $factura->tasa_cambio, 2);				
					}
					elseif ($factura->moneda_id == 2)
					{
						$montoFacturaBolivares = round($factura->amount_paid * $factura->tasa_cambio, 2);
						$montoFacturaDolares = $factura->amount_paid;
					}
					else
					{
						$montoFacturaBolivares = round($factura->amount_paid * $factura->tasa_euro, 2);
						$montoFacturaDolares = round($factura->amount_paid * $factura->tasa_dolar_euro, 2);
					}
					
					$vectorPagos[$contador] = 
						['Nro' => $contadorNumero,
						'fechaHora' => $factura->date_and_time,
						'nroFactura' => $factura->bill_number,
						'nroControl' => $factura->control_number,
						'tipoDocumento' => $factura->tipo_documento,
						'familia' => $factura->parentsandguardian->family,
						'tasaDolar' => $factura->tasa_cambio,
						'tasaEuro' => $factura->tasa_euro,
						'tasaDolarEuro' => $factura->tasa_dolar_euro,
						'totalFacturaBolivar' => $montoFacturaBolivares,
						'totalFacturaDolar' => $montoFacturaDolares,
						'efectivoDolar' => 0,
						'efectivoEuro' => 0,
						'efectivoBolivar' => 0,
						'zelleDolar' => 0,
						'euros' => 0,
						'tddTdcBolivar' => 0,
						'transferenciaBolivar' => 0,
						'depositoBolivar' => 0,
						'chequeBolivar' => 0,
						'bancoEmisor' => $pago->bank,
						'bancoReceptor' => $pago->banco_receptor,
						'cuentaTarjeta' => $pago->account_or_card,
						'serial' => $pago->serial,
						'comentario' => $pago->comentario];

					$contadorNumero++;

					if ($pago->payment_type == "Efectivo" && $pago->moneda == "$")
					{
						$vectorPagos[$contador]['efectivoDolar'] += $pago->amount;
					}
					elseif ($pago->payment_type == "Efectivo" && $pago->moneda == "€")
					{
						$vectorPagos[$contador]['efectivoEuro'] += $pago->amount;
					}
					elseif ($pago->payment_type == "Efectivo" && $pago->moneda == "Bs.")
					{
						$vectorPagos[$contador]['efectivoBolivar'] += $pago->amount;
					}			
					elseif ($pago->payment_type == "Tarjeta de débito" && $pago->moneda == "Bs.")
					{
						$vectorPagos[$contador]['tddTdcBolivar'] += $pago->amount;
					}
					elseif ($pago->payment_type == "Tarjeta de crédito" && $pago->moneda == "Bs.")
					{
						$vectorPagos[$contador]['tddTdcBolivar'] += $pago->amount;
					}			
					elseif ($pago->banco_receptor == "Zelle" && $pago->moneda == "$")
					{
						$vectorPagos[$contador]['zelleDolar'] += $pago->amount;
					}
					elseif ($pago->banco_receptor == "Euros" && $pago->moneda == "€")
					{
						$vectorPagos[$contador]['euros'] += $pago->amount;
					}
					elseif ($pago->payment_type == "Transferencia" && $pago->moneda == "Bs.")
					{
						$vectorPagos[$contador]['transferenciaBolivar'] += $pago->amount;
					}			
					elseif ($pago->payment_type == "Depósito" && $pago->moneda == "Bs.")
					{
						$vectorPagos[$contador]['depositoBolivar'] += $pago->amount;
					}				
					elseif ($pago->payment_type == "Cheque" && $pago->moneda == "Bs.")
					{
						$vectorPagos[$contador]['chequeBolivar'] += $pago->amount;
					}
					$contador++;
				}
			}
		}
										
		$this->set(compact('turn', 'vectorPagos', 'cajero'));
		$this->set('_serialize', ['turn', 'vectorPagos', 'cajero']);
	}	
}