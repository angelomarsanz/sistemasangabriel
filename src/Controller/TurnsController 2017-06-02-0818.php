<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\PaymentsController;

use Cake\I18n\Time;


/**
 * Turns Controller
 *
 * @property \App\Model\Table\TurnsTable $Turns
 */
class TurnsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $turns = $this->paginate($this->Turns);

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
                if ($menuOption == 'Mensualidades')
                {
                    return $this->redirect(['controller' => 'bills', 'action' => 'createInvoice', $result[0]['id'], $result[0]['turn']]);
                }
                elseif ($menuOption == 'Anular')
                {
                    return $this->redirect(['controller' => 'bills', 'action' => 'annulInvoice', $result[0]['id'], $result[0]['turn']]);
                }
                elseif ($menuOption == "Inscripción regulares")
                {
                    return $this->redirect(['controller' => 'bills', 'action' => 'createInvoiceRegistration', $result[0]['id'], $result[0]['turn']]);
                }
                elseif ($menuOption == "Inscripción nuevos")
                {
                    return $this->redirect(['controller' => 'bills', 'action' => 'createInvoiceRegistrationNew', $result[0]['id'], $result[0]['turn']]);
                }
            }
            else
            {
                $this->Flash->error(__('Por favor cierre el turno, porque no coincide con la fecha de hoy y luego abra un turno nuevo')); 
            }
        }
        else
        {
            $this->Flash->error(__('Usted no tiene un turno abierto, por favor abra un turno para poder facturar'));    
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
                $this->Flash->success(__('El turno ha sido abierto satisfactoriamente.'));
    
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
        
        $turn = $this->Turns->get($id);
        
        $paymentsTurn = $payment->searchPayments($id);
        
        $totalAmounts = $turn->initial_cash;
        
        foreach ($paymentsTurn as $paymentsTurns) 
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

        $this->set(compact('turn', 'paymentsTurn', 'totalAmounts'));
        $this->set('_serialize', ['turn', 'paymentsTurn', 'totalAmounts']);
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
        
        $paymentsTurn = $payment->searchPayments($idTurn);
        
        $this->viewBuilder()
            ->className('Dompdf.Pdf')
            ->layout('default')
            ->options(['config' => [
                'filename' => $idTurn,
                'render' => 'browser',
            ]]);

        $this->set(compact('turn', 'paymentsTurn'));
        $this->set('_serialize', ['turn', 'paymentsTurn']);
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
}
