<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 */
class PaymentsController extends AppController
{

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
    public function add($billId = null, $paymentType = null, $amountPaid = null, $bank = null,
                $accountOrCard = null, $serial = null, $idTurn = null, $family = null)
    {
        $payment = $this->Payments->newEntity();
        $payment->bill_id = $billId;
        $payment->payment_type = $paymentType;
        $payment->amount = $amountPaid;
        $payment->bank = $bank;
        $payment->account_or_card = $accountOrCard;
        $payment->serial = $serial;
        $payment->bill_number = $billId;
        $payment->responsible_user = $this->Auth->user('id');
        $payment->turn = $idTurn;
        $payment->annulled = 0;
        $payment->name_family = $family; 
        
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
    
    public function searchPayments($turn = null)
    {
        $this->autoRender = false;
        
        $paymentsTurn = $this->Payments->find('all')->where(['turn' => $turn])
            ->order(['Payments.name_family' => 'ASC', 'Payments.bill_number' => 'ASC', 'Payments.payment_type' => 'ASC']);
            
        return $paymentsTurn;
    }
}
