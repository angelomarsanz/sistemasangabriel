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
		$payment = new PaymentsController();
		
		$plantillaFormaPago = $this->PlantillaFormaPago();
		$totalesFiscales = $plantillaFormaPago;
						
		$resultado = $payment->busquedaPagos($id);
				
		$paymentsTurn = $resultado[0];
		
		$vector = [];
									
		foreach ($totalesFiscales as $fiscal) 
		{			
			$fiscal['monto'] += 5;
		}
										
		$this->set(compact('totalesFiscales'));
		$this->set('_serialize', ['totalesFiscales']);
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
	public function plantillaFormaPago()
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

		$plantillaFormaPago = [];
				
		foreach($formaPago as $forma)
		{
			foreach ($monedas as $moneda)
			{
				$plantillaFormaPago[] = ['formaPago' => $forma, 'moneda' => $moneda, 'monto' => 10];
			}
		}
		
		$jsonPlantilla = json_encode($plantillaFormaPago, JSON_FORCE_OBJECT);
		
		$plantillaObjeto = json_decode($jsonPlantilla);
				
		debug($plantillaObjeto);
		
		foreach ($plantillaObjeto as $objeto)
		{
			$objeto->monto += 15;
		}
		
		debug($plantillaObjeto);
		
		Return $plantillaFormaPago;
	}
	
	public function bancosReceptores()
	{
		$bancos = 
			['Banesco',
			'Plaza',
			'Provincial',
			'Venezuela',
            'Zelle'];
			
		$monedas = ['$', '€', 'Bs.'];

		$bancosReceptores = [];
				
		foreach($bancos as $banco)
		{
			foreach ($monedas as $moneda)
			{
				$bancosReceptores[] = ['banco' => $banco, 'moneda' => $moneda, 'monto' => 0];
			}
		}
		
		Return $bancosReceptores;
	}
	
    function imprimirReporteCierre($idTurn = null)
    {
        $this->Flash->success(__('Cierre de turno guardado con el número: ' . $idTurn));

        $this->set(compact('idTurn'));
        $this->set('_serialize', ['idTurn']);
    }
	
    public function reporteCierre($id = null)
    {
		$this->loadModel('Bills');
		$payment = new PaymentsController();
		
		$indicadorFiscales = 0;
		$indicadorAnticipos = 0;
		$indicadorServiciosEducativos = 0;
		$indicadorAnuladas = 0;
		$indicadorRecibosAnulados = 0;
			
		$indicadorNotasCredito = 0;
		$totalNotasCredito = 0;
		$indicadorNotasDebito = 0;
		$totalNotasDebito = 0;
		$indicadorFacturasRecibo = 0;
		$totalFacturasRecibo = 0;
			
		$turn = $this->Turns->get($id);
            
        if ($turn->status == 1)
        {
            $this->Flash->error(__('Este turno no se ha cerrado'));
            return $this->redirect(['controller' => 'users', 'action' => 'wait']);
        }
		
		$usuario = $this->Turns->Users->get($turn->user_id);
		
		$cajero = $usuario->first_name . ' ' . $usuario->surname; 
			
		$totalesFiscales = json_decode($turn->totales_fiscales, true);
		$totalGeneralFiscales = json_decode($turn->total_general_fiscales, true);
		$totalesAnticipos = json_decode($turn->totales_anticipos, true);
		$totalGeneralAnticipos = json_decode($turn->total_general_anticipos, true);
		$totalesServiciosEducativos = json_decode($turn->totales_servicios_educativos, true);
		$totalGeneralServiciosEducativos = json_decode($turn->total_general_servicios_educativos, true);
		$totalTotales = json_decode($turn->total_totales, true);
		$totalSobrantes = json_decode($turn->total_sobrantes, true);
		$totalReintegros = json_decode($turn->total_reintegros, true);
		$totalFacturasCompensadas = json_decode($turn->total_facturas_compensadas, true);
		$totalOtrasOperaciones = json_decode($turn->total_otras_operaciones, true);
		$bancosReceptores = json_decode($turn->bancos_receptores, true);
		$totalBancosReceptores  = json_decode($turn->total_bancos_receptores, true);	
						
		$fechaTurnoFormateada = date_format($turn->start_date, "Y-m-d");
		$fechaTurno = $turn->start_date;
		$fechaProximoDia = $fechaTurno->addDay(1);
		$fechaProximoDiaFormateada = date_format($fechaProximoDia, "Y-m-d");
				
		$resultado = $payment->busquedaPagos($id);
				
		$paymentsTurn = $resultado[0];
		$indicadorSobrantes = $resultado[1];
		$sobrantes = $resultado[2];
		$indicadorReintegros = $resultado[3];
		$reintegros = $resultado[4];
		$indicadorCompensadas = $resultado[5];
		$facturasCompensadas = $resultado[6];
		$indicadorBancos = $resultado[7];
		$recibidoBancos = $resultado[8];
		
		if ($totalGeneralFiscales['$'] > 0 || $totalGeneralFiscales['€'] > 0 || $totalGeneralFiscales['Bs.'] > 0)
		{
			$indicadorFiscales = 1;
		}
		
		if ($totalGeneralAnticipos['$'] > 0 || $totalGeneralAnticipos['€'] > 0 || $totalGeneralAnticipos['Bs.'] > 0)
		{
			$indicadorAnticipos = 1;
		}
		
		if ($totalGeneralServiciosEducativos['$'] > 0 || $totalGeneralServiciosEducativos['€'] > 0 || $totalGeneralServiciosEducativos['Bs.'] > 0)
		{
			$indicadorServiciosEducativos = 1;
		}
		
		if ($indicadorSobrantes == 1)
		{
			foreach($sobrantes as $sobrante)
			{
				$totalSobrantes += $recibo->amount_paid;
				$totalOtrasOperaciones += $recibo->amount_paid;
			}
		}
		
		if ($indicadorReintegros == 1)
		{
			foreach($reintegros as $reintegro)
			{
				$totalReintegros += $reintegro->amount_paid;
				$totalOtrasOperaciones += $reintegro->amount_paid;
			}
		}
		
		if ($indicadorCompensadas == 1)
		{
			foreach($facturasCompensadas as $compensada)
			{
				$totalFacturasCompensadas += $compensada->saldo_compensado;
				$totalOtrasOperaciones += $recibo->amount_paid;
			}			
		}
								
		$notasContables = $this->Bills->find('all', ['conditions' => ['turn' => $id, 'OR' => [['tipo_documento' => 'Nota de crédito'], ['tipo_documento' => 'Nota de débito']]],
			'order' => ['Bills.created' => 'ASC'],
			'contain' => ['Parentsandguardians']]);
			
		$contadorNotas = $notasContables->count();
		
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
		
		$facturasRecibo = $this->Bills->find('all', ['conditions' => ['turn' => $id, 'id_anticipo >' => 0],
			'order' => ['Bills.created' => 'ASC'],
			'contain' => ['Parentsandguardians']]);
			
		$contadorFacturasRecibo = $facturasRecibo->count();
		
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
		
		if ($contadorAnuladas > 0)
		{
			$indicadorAnuladas = 1;
		}		

		$recibosAnulados = $this->Bills->find('all', ['conditions' => ['date_annulled >=' => $turn->start_date],
			'order' => ['Bills.created' => 'ASC']]);
			
		$contadorRecibosAnulados = $recibosAnulados->count();
		
		if ($contadorRecibosAnulados > 0)
		{
			$indicadorRecibosAnulados = 1;
		}			
		
		$origen = "reporteCierre";

		$ultimoRegistro = $this->Bills->find('all', ['conditions' => ['turn' => $id, 'fiscal' => 1],
			'order' => ['created' => 'DESC'] ]);

		$contadorRegistro = $ultimoRegistro->count();
			
		if ($contadorRegistro > 0)
		{	
			$factura = $ultimoRegistro->first();

			$lastNumber = $factura->bill_number;
			$lastControl = $factura->control_number;
		}
					
		$this->set(compact('turn', 'origen', 'paymentsTurn', 'totalAmounts', 'receipt', 'lastNumber', 'lastControl', 'totalesFiscales', 'totalGeneralFiscales', 'totalesAnticipos', 'totalGeneralAnticipos', 'totalesServiciosEducativos', 'totalGeneralServiciosEducativos', 'totalTotales', 'totalSobrantes', 'totalReintegros', 'totalFacturasCompensadas', 'totalOtrasOperaciones', 'indicadorAnticipos', 'indicadorFiscales', 'indicadorServiciosEducativos', 'indicadorSobrantes', 'sobrantes', 'indicadorReintegros', 'reintegros', 'indicadorCompensadas', 'facturasCompensadas', 'indicadorBancos', 'recibidoBancos', 'bancosReceptores', 'totalBancosReceptores', 'notasContables', 'indicadorNotasCredito', 'indicadorNotasDebito', 'indicadorFacturasRecibo', 'facturasRecibo', 'indicadorAnuladas', 'anuladas', 'indicadorRecibosAnulados', 'recibosAnulados', 'cajero'));
		$this->set('_serialize', ['turn', 'origen', 'paymentsTurn', 'totalAmounts', 'receipt', 'lastNumber', 'lastControl', 'totalesFiscales', 'totalGeneralFiscales', 'totalesAnticipos', 'totalGeneralAnticipos', 'totalesServiciosEducativos', 'totalGeneralServiciosEducativos', 'totalTotales', 'totalSobrantes', 'totalReintegros', 'totalFacturasCompensadas', 'totalOtrasOperaciones', 'indicadorAnticipos', 'indicadorFiscales', 'indicadorServiciosEducativos', 'indicadorSobrantes', 'sobrantes', 'indicadorReintegros', 'reintegros', 'indicadorCompensadas', 'facturasCompensadas', 'indicadorBancos', 'recibidoBancos', 'bancosReceptores', 'totalBancosReceptores', 'notasContables', 'indicadorNotasCredito', 'indicadorNotasDebito', 'indicadorFacturasRecibo', 'facturasRecibo', 'indicadorAnuladas', 'anuladas', 'indicadorRecibosAnulados', 'recibosAnulados', 'cajero']);
	}
	
    public function excelResumen($id = null)
    {
		$payment = new PaymentsController();
		
		$vectorPagos = []; 
					
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
			$vectorPagos[$factura->id] = 
				['fechaHora' => $factura->date_and_time,
				'nroFactura' => $factura->bill_number,
				'nroControl' => $factura->control_number,
				'familia' => $factura->parentsandguardian->family,
				'tasaDolar' => $factura->tasa_cambio,
				'tasaEuro' => $factura->tasa_euro,
				'tasaDolarEuro' => $factura->tasa_dolar_euro,
				'totalFacturaBolivar' => $factura->amount_paid,
				'efectivoDolar' => 0,
				'efectivoEuro' => 0,
				'efectivoBolivar' => 0,
				'zelleDolar' => 0,
				'tddTdcBolivar' => 0,
				'transferenciaBolivar' => 0,
				'depositoBolivar' => 0,
				'chequeBolivar' => 0,
				'totalFacturadoDolar' => round($factura->amount_paid/$factura->tasa_cambio),
				'ncNdDolar' => $factura->saldo_compensado_dolar,
				'totalCobradoDolar' => 0];		
		}
		
		foreach ($pagosFacturas as $pago)
		{
			if ($pago->payment_type == "Efectivo" && $pago->moneda == "$")
			{
				$vectorPagos[$pago->bill->id]['efectivoDolar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += $pago->amount;
			}
			elseif ($pago->payment_type == "Efectivo" && $pago->moneda == "€")
			{
				$vectorPagos[$pago->bill->id]['efectivoEuro'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount * $pago->bill->tasa_dolar_euro);
			}
			elseif ($pago->payment_type == "Efectivo" && $pago->moneda == "Bs.")
			{
				$vectorPagos[$pago->bill->id]['efectivoBolivar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio);
			}			
			elseif ($pago->payment_type == "Tarjeta de débito" && $pago->moneda == "Bs.")
			{
				$vectorPagos[$pago->bill->id]['tddTdcBolivar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio);
			}
			elseif ($pago->payment_type == "Tarjeta de crédito" && $pago->moneda == "Bs.")
			{
				$vectorPagos[$pago->bill->id]['tddTdcBolivar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio);
			}			
			elseif ($pago->banco_receptor == "Zelle" && $pago->moneda == "$")
			{
				$vectorPagos[$pago->bill->id]['ZelleDolar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += $pago->amount;
			}
			elseif ($pago->payment_type == "Transferencia" && $pago->moneda == "Bs.")
			{
				$vectorPagos[$pago->bill->id]['transferenciaBolivar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio);
			}			
			elseif ($pago->payment_type == "Depósito" && $pago->moneda == "Bs.")
			{
				$vectorPagos[$pago->bill->id]['depositoBolivar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio);
			}				
			elseif ($pago->payment_type == "Cheque" && $pago->moneda == "Bs.")
			{
				$vectorPagos[$pago->bill->id]['chequeBolivar'] += $pago->amount;
				$vectorPagos[$pago->bill->id]['totalCobradoDolar'] += round($pago->amount / $pago->bill->tasa_cambio);
			}						
		}
							
		$this->set(compact('turn', 'vectorPagos', 'cajero'));
		$this->set('_serialize', ['turn', 'vectorPagos', 'cajero']);
	}
    public function excelDetalle($id = null)
    {
		$payment = new PaymentsController();
		
		$vectorPagos = []; 
		$contador = 0;
					
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
					$vectorPagos[$contador] = 
						['fechaHora' => $factura->date_and_time,
						'nroFactura' => $factura->bill_number,
						'nroControl' => $factura->control_number,
						'familia' => $factura->parentsandguardian->family,
						'tasaDolar' => $factura->tasa_cambio,
						'tasaEuro' => $factura->tasa_euro,
						'tasaDolarEuro' => $factura->tasa_dolar_euro,
						'totalFacturaBolivar' => $factura->amount_paid,
						'efectivoDolar' => 0,
						'efectivoEuro' => 0,
						'efectivoBolivar' => 0,
						'zelleDolar' => 0,
						'tddTdcBolivar' => 0,
						'transferenciaBolivar' => 0,
						'depositoBolivar' => 0,
						'chequeBolivar' => 0,
						'bancoEmisor' => $pago->bank,
						'bancoReceptor' => $pago->banco_receptor,
						'cuentaTarjeta' => $pago->account_or_card,
						'serial' => $pago->serial,
						'comentario' => $pago->comentario];		

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
						$vectorPagos[$contador]['ZelleDolar'] += $pago->amount;
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
				elseif ($factura->id < $pago->bill->id)
				{
					break;
				}
			}
		}
										
		$this->set(compact('turn', 'vectorPagos', 'cajero'));
		$this->set('_serialize', ['turn', 'vectorPagos', 'cajero']);
	}	
}