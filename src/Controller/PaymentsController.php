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
    public function add($billId = null, $billNumber = null, $paymentType = null, $amountPaid = null, $bank = null,
                $accountOrCard = null, $serial = null, $idTurn = null, $family = null, $fiscal = null)
    {
        $payment = $this->Payments->newEntity();
        $payment->bill_id = $billId;
        $payment->payment_type = $paymentType;
        $payment->amount = $amountPaid;
        $payment->bank = $bank;
        $payment->account_or_card = $accountOrCard;
        $payment->serial = $serial;
        $payment->bill_number = $billNumber;
        $payment->responsible_user = $this->Auth->user('id');
        $payment->turn = $idTurn;
        $payment->annulled = 0;
        $payment->name_family = $family; 
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
							$montoServicioEducativo = $paymentTurns->amount;
							$paymentTurns->amount = 0;
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
}