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
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
			
        $fechaObjeto = Time::now();
		
		$fechaFormateada = date_format($fechaObjeto, "Y-m-d");
		echo "<br />fecha formateada: " . $fechaFormateada;
	
		/*
		$turn = $this->Turns->get(799);
		$fecha = date_format($turn->start_date,"Y-m-d");
		echo "<br />fecha: " . $fecha;
		*/
	}

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$query = $this->Turns->find('all')
			->where(['user_id' => $this->Auth->user('id'), 'status' => 0])
			->order(['start_date' => 'DESC']);
   
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
		$lastNumber = 0;
		$lastControl = 0;

        $payment = new PaymentsController();
        
        $turn = $this->Turns->get($id);
		
		$fechaTurnoFormateada = date_format($turn->start_date, "Y-m-d");
		$fechaTurno = $turn->start_date;
		$fechaProximoDia = $fechaTurno->addDay(1);
		$fechaProximoDiaFormateada = date_format($fechaProximoDia, "Y-m-d");
				
        $resultado = $payment->searchPayments($id, $fechaTurnoFormateada, $fechaProximoDiaFormateada);
        
		$paymentsTurn = $resultado[0];
		$indicadorServicioEducativo = $resultado[1];
		$pagosServicioEducativo = $resultado[2];
		
        $totalAmounts = $turn->initial_cash;
        
        $receipt = 0;
		        
        foreach ($paymentsTurn as $paymentsTurns) 
        {			
            if ($paymentsTurns->fiscal == 0)
            {
                $receipt = 1;
            }
            else
            {
                switch ($paymentsTurns->payment_type) 
                {
                    case "Efectivo":
                        $turn->cash_received = $turn->cash_received + $paymentsTurns->amount;
                        $totalAmounts = $totalAmounts + $paymentsTurns->amount;
                        break;
                    case "Tarjeta de débito":
                        $turn->debit_card_amount = $turn->debit_card_amount + $paymentsTurns->amount;
                        $totalAmounts = $totalAmounts + $paymentsTurns->amount;
                        break;
                    case "Tarjeta de crédito":
                        $turn->credit_card_amount = $turn->credit_card_amount + $paymentsTurns->amount;
                        $totalAmounts = $totalAmounts + $paymentsTurns->amount;
                        break;
                    case "Transferencia":
                        $turn->transfer_amount = $turn->transfer_amount + $paymentsTurns->amount;
                        $totalAmounts = $totalAmounts + $paymentsTurns->amount;
                        break;
                    case "Depósito":
                        $turn->deposit_amount = $turn->deposit_amount + $paymentsTurns->amount;
                        $totalAmounts = $totalAmounts + $paymentsTurns->amount;
                        break;
                    case "Cheque":
                        $turn->check_amount = $turn->check_amount + $paymentsTurns->amount;
                        $totalAmounts = $totalAmounts + $paymentsTurns->amount;
                        break;
                    case "Retención de impuesto":
                        $turn->retention_amount = $turn->retention_amount + $paymentsTurns->amount;
                        $totalAmounts = $totalAmounts + $paymentsTurns->amount;
                        break;
                }
            }
        }

		$accountPayment = $paymentsTurn->count();
		
		if ($accountPayment > 0)
		{
			$this->loadModel('Bills');
		
            $lastRecord = $this->Bills->find('all', ['conditions' => ['turn' => $id, 'fiscal' => 1],
                'order' => ['created' => 'DESC'] ]);

            $row = $lastRecord->first();

			$lastNumber = $row->bill_number;
			$lastControl = $row->control_number;		
		}
			
        $this->set(compact('turn', 'paymentsTurn', 'totalAmounts', 'receipt', 'lastNumber', 'lastControl', 'indicadorServicioEducativo', 'pagosServicioEducativo'));
        $this->set('_serialize', ['turn', 'paymentsTurn', 'totalAmounts', 'receipt', 'lastNumber', 'lastControl', 'indicadorServicioEducativo', 'pagosServicioEducativo']);
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

    public function turnpdf($idTurn = null)
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
            }
        }
        
        $this->viewBuilder()
            ->className('Dompdf.Pdf')
            ->layout('default')
            ->options(['config' => [
                'filename' => $idTurn,
                'render' => 'browser',
            ]]);

        $this->set(compact('turn', 'paymentsTurn', 'receipt', 'indicadorServicioEducativo', 'pagosServicioEducativo'));
        $this->set('_serialize', ['turn', 'paymentsTurn', 'receipt', 'indicadorServicioEducativo', 'pagosServicioEducativo']);
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
}