<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\ExcelsController;

use Cake\ORM\TableRegistry;

use Cake\I18n\Time;

class StudenttransactionsController extends AppController
{
    public function testFunction()
    {

	}

    public function index()
    {
       if ($this->request->is('post'))
        {
            $studenttransactions = $this->Studenttransactions->find('all')->where(['student_id' => $_POST['idStudent'],
                'amount >' => 0, 'paid_out' => 0]);

            $student = $_POST['student'];

            $this->set(compact('studenttransactions', 'student'));
            $this->set('_serialize', ['studenttransactions', 'student']);
        }
    }

    public function view($id = null)
    {
        $studenttransaction = $this->Studenttransactions->get($id, [
            'contain' => []
        ]);

        $this->set('studenttransaction', $studenttransaction);
        $this->set('_serialize', ['studenttransaction']);
    }

    public function add()
    {
        $this->loadModel('Rates');

        $concept = 'Inscripción';

        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
                               'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();
        
        echo $row['amount'];

        $studenttransaction = $this->Studenttransactions->newEntity();
        if ($this->request->is('post')) {
            $studenttransaction = $this->Studenttransactions->patchEntity($studenttransaction, $this->request->data);
            echo $studenttransaction;
            if ($this->Studenttransactions->save($studenttransaction)) {
                $this->Flash->success(__('The studenttransaction has been saved.'));

//                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The studenttransaction could not be saved. Please, try again.'));
            }
        }
        
        $students = $this->Studenttransactions->Students->find('list', ['limit' => 200]);
        
        $this->set(compact('studenttransaction', 'students'));
        $this->set('_serialize', ['studenttransaction']);
    }

    public function edit($id = null, $billNumber = null, $amountPayable = null)
    {
        $studenttransaction = $this->Studenttransactions->get($id);
        
        $studenttransaction->amount = $studenttransaction->amount - $amountPayable;
        
        if ($studenttransaction->amount > 0)
        {
            $studenttransaction->partial_payment = 1;
        } 
        else
        {
            $studenttransaction->paid_out = 1;
        }
        
        $studenttransaction->bill_number = $billNumber;

        if (!($this->Studenttransactions->save($studenttransaction)))
        {
            $this->Flash->error(__('La transacción del alumno no pudo ser actualizada, vuelva a intentar.'));
        }
        return;
    }

    public function reverseTransaction($id = null, $amount = null, $billNumber = null)
    {
        $studentTransaction = $this->Studenttransactions->get($id);
        
        $studentTransaction->amount = $studentTransaction->amount + $amount;
        
        $studentTransaction->paid_out = 0;
        
        if ($studentTransaction->amount < $studentTransaction->original_amount)
        {
            $studentTransaction->partial_payment = 1;
        } 
        else
        {
            $studentTransaction->partial_payment = 0;
        }
        
        if ($studentTransaction->bill_number == $billNumber)
        {
            $studentTransaction->bill_number = 0;
        }
        
        if (!($this->Studenttransactions->save($studentTransaction)))
        {
            $this->Flash->error(__('La transacción del alumno no pudo ser actualizada, vuelva a intentar.'));
        }
        else
        {
            return;
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $studenttransaction = $this->Studenttransactions->get($id);
        if ($this->Studenttransactions->delete($studenttransaction)) {
            $this->Flash->success(__('The studenttransaction has been deleted.'));
        } else {
            $this->Flash->error(__('The studenttransaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function createQuotasRegularPrevious($studentId = null)
    {
        $this->loadModel('Rates');

        $concept = 'Matrícula';
        
        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
                               'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();

        $quotaYear = date('Y') - 1;
        
        $nextYear = $quotaYear + 1;
        
        $studenttransaction = $this->Studenttransactions->newEntity();
        
        $studenttransaction->student_id = $studentId;
        
        $studenttransaction->transaction_type = 'Matrícula';
        $studenttransaction->transaction_description = 'Matrícula' . ' ' . $quotaYear;
        $studenttransaction->amount = $row['amount'];
        $studenttransaction->original_amount = $row['amount'];
        $studenttransaction->invoiced = 0;
        $studenttransaction->paid_out = 0;
        $studenttransaction->partial_payment = 0;
        $studenttransaction->bill_number = 0;
        $studenttransaction->payment_date = 0;
        $studenttransaction->transaction_migration = 0;
        
        if ($this->Studenttransactions->save($studenttransaction)) 
        {
            $concept = 'Seguro escolar';
            
            $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 'order' => ['Rates.created' => 'DESC'] ]);
            
            $row = $lastRecord->first();

            $studenttransaction = $this->Studenttransactions->newEntity();
                
            $studenttransaction->student_id = $studentId;
                
            $studenttransaction->transaction_type = 'Seguro escolar';
            $studenttransaction->transaction_description = 'Seguro escolar' . ' ' . $quotaYear;
            $studenttransaction->amount = $row['amount'];
            $studenttransaction->original_amount = $row['amount'];
            $studenttransaction->invoiced = 0;
            $studenttransaction->paid_out = 0;
            $studenttransaction->partial_payment = 0;
            $studenttransaction->bill_number = 0;
            $studenttransaction->payment_date = 0;
            $studenttransaction->transaction_migration = 0;

            if (!($this->Studenttransactions->save($studenttransaction)))
            {
                $this->Flash->error(__('No se pudo grabar la cuota de seguro escolar'));
            }
            else
            {
                $concept = 'Mensualidad';
            
                $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 'order' => ['Rates.created' => 'DESC'] ]);
            
                $row = $lastRecord->first();

                for ($i = 1; $i <= 12; $i++) 
                {
                    $studenttransaction = $this->Studenttransactions->newEntity();
                    
                    $studenttransaction->student_id = $studentId;
                
                    if ($i < 5)
                    {
                        $monthNumber = $i + 8;
                    }
                    else
                    {
                        $monthNumber = $i - 4;
                    }
                    
                    $nameOfTheMonth = $this->nameMonth($monthNumber);
        
                    $studenttransaction->transaction_type = 'Mensualidad';
					
			        if ($monthNumber < 10)
					{
						$monthString = "0" . $monthNumber;
					}
					else
					{
						$monthString = (string) $monthNumber;
					}
                        
                    if ($monthNumber < 9)
					{
                        $studenttransaction->transaction_description = $nameOfTheMonth . ' ' . $nextYear;						
						$studenttransaction->payment_date = $nextYear . '-' . $monthString . '-01';						
                    }
					else
					{		
						$studenttransaction->transaction_description = $nameOfTheMonth . ' ' . $quotaYear;
						$studenttransaction->payment_date = $quotaYear . '-' . $monthString . '-01';
                    }        
					
                    $studenttransaction->paid_out = 0;
                    
                    if ($nameOfTheMonth == "Ago")
                    {
                        $studenttransaction->amount = 44000;
                    }
                    else
                    {
                        $studenttransaction->amount = $row['amount'];
                    }
                    $studenttransaction->original_amount = $row['amount'];
                    $studenttransaction->invoiced = 0;
                    $studenttransaction->paid_out = 0;
					$studenttransaction->partial_payment = 0;
                    $studenttransaction->bill_number = 0;
                    $studenttransaction->transaction_migration = 0;

                    if (!($this->Studenttransactions->save($studenttransaction))) 
                    {
                        $this->Flash->error(__('The studenttransaction could not be saved. Please, try again.'));
                        break;
                    }
                }
            } 
        }
        else 
        {
            $this->Flash->error(__('The studenttransaction could not be saved. Please, try again.'));
        }
    }

    public function createQuotasRegular($studentId = null)
    {
        $this->loadModel('Rates');

        $concept = 'Matrícula';
        
        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
                               'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();

        $quotaYear = date('Y');
        
        $nextYear = $quotaYear + 1;
        
        $studenttransaction = $this->Studenttransactions->newEntity();
        
        $studenttransaction->student_id = $studentId;
        
        $studenttransaction->transaction_type = 'Matrícula';
        $studenttransaction->transaction_description = 'Matrícula' . ' ' . $quotaYear;
        $studenttransaction->amount = $row['amount'];
        $studenttransaction->original_amount = $row['amount'];
        $studenttransaction->invoiced = 0;
        $studenttransaction->paid_out = 0;
        $studenttransaction->partial_payment = 0;
        $studenttransaction->bill_number = 0;
        $studenttransaction->payment_date = 0;
        $studenttransaction->transaction_migration = 0;
        
        if ($this->Studenttransactions->save($studenttransaction)) 
        {
            $concept = 'Seguro escolar';
            
            $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 'order' => ['Rates.created' => 'DESC'] ]);
            
            $row = $lastRecord->first();

            $studenttransaction = $this->Studenttransactions->newEntity();
                
            $studenttransaction->student_id = $studentId;
                
            $studenttransaction->transaction_type = 'Seguro escolar';
            $studenttransaction->transaction_description = 'Seguro escolar' . ' ' . $quotaYear;
            $studenttransaction->amount = $row['amount'];
            $studenttransaction->original_amount = $row['amount'];
            $studenttransaction->invoiced = 0;
            $studenttransaction->paid_out = 0;
            $studenttransaction->partial_payment = 0;
            $studenttransaction->bill_number = 0;
            $studenttransaction->payment_date = 0;
            $studenttransaction->transaction_migration = 0;

            if (!($this->Studenttransactions->save($studenttransaction)))
            {
                $this->Flash->error(__('No se pudo grabar la cuota de seguro escolar'));
            }
            else
            {
                $concept = 'Mensualidad';
            
                $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 'order' => ['Rates.created' => 'DESC'] ]);
            
                $row = $lastRecord->first();

                for ($i = 1; $i <= 12; $i++) 
                {
                    $studenttransaction = $this->Studenttransactions->newEntity();
                    
                    $studenttransaction->student_id = $studentId;
                
                    if ($i < 5)
                    {
                        $monthNumber = $i + 8;
                    }
                    else
                    {
                        $monthNumber = $i - 4;
                    }
                    
                    $nameOfTheMonth = $this->nameMonth($monthNumber);
        
                    $studenttransaction->transaction_type = 'Mensualidad';
                        
			        if ($monthNumber < 10)
					{
						$monthString = "0" . $monthNumber;
					}
					else
					{
						$monthString = (string) $monthNumber;
					}
                        
                    if ($monthNumber < 9)
					{
                        $studenttransaction->transaction_description = $nameOfTheMonth . ' ' . $nextYear;				
						$studenttransaction->payment_date = $nextYear . '-' . $monthString . '-01';						
                    }
					else
					{		
						$studenttransaction->transaction_description = $nameOfTheMonth . ' ' . $quotaYear;
						$studenttransaction->payment_date = $quotaYear . '-' . $monthString . '-01';
                    }        
					
                    $studenttransaction->paid_out = 0;
                    $studenttransaction->amount = $row['amount'];
                    $studenttransaction->original_amount = $row['amount'];
                    $studenttransaction->invoiced = 0;
                    $studenttransaction->paid_out = 0;
					$studenttransaction->partial_payment = 0;
                    $studenttransaction->bill_number = 0;
                    $studenttransaction->transaction_migration = 0;

                    if (!($this->Studenttransactions->save($studenttransaction))) 
                    {
                        $this->Flash->error(__('The studenttransaction could not be saved. Please, try again.'));
                        break;
                    }
                }
            } 
        }
        else 
        {
            $this->Flash->error(__('The studenttransaction could not be saved. Please, try again.'));
        }
    }

    public function createQuotasNew($studentId = null, $startYear = null)
    {
        $this->loadModel('Rates');

        $concept = 'Matrícula';
        
        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
                               'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();

        $quotaYear = $startYear;
        
        $nextYear = $quotaYear + 1;
        
        $studenttransaction = $this->Studenttransactions->newEntity();
        
        $studenttransaction->student_id = $studentId;
        
        $studenttransaction->transaction_type = 'Matrícula';
        $studenttransaction->transaction_description = 'Matrícula' . ' ' . $quotaYear;
        $studenttransaction->amount = $row['amount'];
        $studenttransaction->original_amount = $row['amount'];
        $studenttransaction->invoiced = 0;
        $studenttransaction->paid_out = 0;
        $studenttransaction->partial_payment = 0;
        $studenttransaction->bill_number = 0;
        $studenttransaction->payment_date = 0;
        $studenttransaction->transaction_migration = 0;
        
        if ($this->Studenttransactions->save($studenttransaction)) 
        {
            $concept = 'Servicio educativo';
            
            $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 'order' => ['Rates.created' => 'DESC'] ]);
            
            $row = $lastRecord->first();

            $studenttransaction = $this->Studenttransactions->newEntity();
                
            $studenttransaction->student_id = $studentId;
                
            $studenttransaction->transaction_type = 'Servicio educativo';
            $studenttransaction->transaction_description = 'Servicio educativo' . ' ' . $quotaYear;
            $studenttransaction->amount = $row['amount'];
            $studenttransaction->original_amount = $row['amount'];
            $studenttransaction->invoiced = 0;
            $studenttransaction->paid_out = 0;
            $studenttransaction->partial_payment = 0;
            $studenttransaction->bill_number = 0;
            $studenttransaction->payment_date = 0;
            $studenttransaction->transaction_migration = 0;

            if (!($this->Studenttransactions->save($studenttransaction)))
            {
                $this->Flash->error(__('No se pudo grabar la cuota de servicio educativo'));
            }

            $concept = 'Mensualidad';
            
            $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 'order' => ['Rates.created' => 'DESC'] ]);
            
            $row = $lastRecord->first();

            for ($i = 1; $i <= 12; $i++) 
            {
                $studenttransaction = $this->Studenttransactions->newEntity();
                    
                $studenttransaction->student_id = $studentId;
                
                if ($i < 5)
                {
                    $monthNumber = $i + 8;
                }
                else
                {
                    $monthNumber = $i - 4;
                }
                    
                $nameOfTheMonth = $this->nameMonth($monthNumber);
        
                $studenttransaction->transaction_type = 'Mensualidad';
                        
                if ($monthNumber < 9)
                    $studenttransaction->transaction_description = $nameOfTheMonth . ' ' . $nextYear;
                else
                    $studenttransaction->transaction_description = $nameOfTheMonth . ' ' . $quotaYear;

				if ($monthNumber < 10)
				{
					$monthString = "0" . $monthNumber;
				}
				else
				{
					$monthString = (string) $monthNumber;
				}
					
				if ($monthNumber < 9)
				{
					$studenttransaction->transaction_description = $nameOfTheMonth . ' ' . $nextYear;						
					$studenttransaction->payment_date = $nextYear . '-' . $monthString . '-01';						
				}
				else
				{		
					$studenttransaction->transaction_description = $nameOfTheMonth . ' ' . $quotaYear;
					$studenttransaction->payment_date = $quotaYear . '-' . $monthString . '-01';
				}
					
                $studenttransaction->paid_out = 0;
                $studenttransaction->amount = $row['amount'];
                $studenttransaction->original_amount = $row['amount'];
                $studenttransaction->invoiced = 0;
                $studenttransaction->paid_out = 0;
				$studenttransaction->partial_payment = 0;
                $studenttransaction->bill_number = 0;
                $studenttransaction->transaction_migration = 0;

                if (!($this->Studenttransactions->save($studenttransaction))) 
                {
                    $this->Flash->error(__('The studenttransaction could not be saved. Please, try again.'));
                    break;
                }
            }
        } 
        else 
        {
            $this->Flash->error(__('The studenttransaction could not be saved. Please, try again.'));
        }
    }

    function nameMonth($monthNumber = null)
    {
        if ($monthNumber < 10)
        {
            $monthString = "0" . $monthNumber;
        }
        else
        {
        $monthString = (string) $monthNumber;
        }
        $monthsSpanish = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        $monthsEnglish = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $spanishMonth = str_replace($monthsEnglish, $monthsSpanish, $monthString);
        return $spanishMonth;
    }

    public function installmentsPayable($parentId = null, $studentId = null, $studentName = null, $description = null, $balance = null)
    {
        if ($description == 'Inscripción')
        {
            $checkInscription = $this->Studenttransactions->find('all', ['conditions' => ['student_id' => $studentId, 
                'transaction_description' => 'Matrícula 2017'], 
                'order' => ['Studenttransactions.created' => 'DESC'] ]);
    
            $row = $checkInscription->first();
        
            if (!($row))
                $this->createQuotasInscription($studentId);
        }
        
        $query = $this->Studenttransactions->find('all')->where(['Studenttransactions.student_id' => $studentId, 'paid_out' => 0]);
        $this->set('studenttransactions', $this->paginate($query));

        $this->set(compact('studenttransactions', 'parentId', 'studentName', 'description', 'balance'));
        $this->set('_serialize', ['studenttransactions']);
    }
    
    public function checkIn($parentId = null, $studentTransactionId = null, $studentName, $description = null)
    {
        $this->loadModel('Parentsandguardians');

        $studenttransaction = $this->Studenttransactions->get($studentTransactionId, [
            'contain' => []
        ]);
        
        $studenttransaction->invoiced = 1;
        
        if ($this->Studenttransactions->save($studenttransaction)) 
        {
            $this->Flash->success(__('La cuota ha sido facturada'));
            
            $parentsandguardians = $this->Parentsandguardians->get($parentId);
        
            $parentsandguardians->balance = $parentsandguardians->balance + $studenttransaction->amount;
            
            if (!($this->Parentsandguardians->save($parentsandguardians))) 
                $this->Flash->error(__('El saldo de la factura no pudo ser actualizado, intente nuevamente'));
            
            return $this->redirect(['action' => 'installmentsPayable', $parentId, $studenttransaction->student_id, $studentName, $description, $parentsandguardians->balance]);
        }
        else 
        {
            $this->Flash->error(__('The studenttransaction could not be saved. Please, try again.'));
        }
        $this->set(compact('studenttransaction'));
        $this->set('_serialize', ['studenttransaction']);
    }
    public function searchQuotas($studentId = null)
    {
        $this->autoRender = false;

        $jsondata = [];

        $jsondata[0]["transaction_description"] = "Sin transacciones"; 
        $jsondata[1]["transaction_description"] = "Con transacciones"; 

        return $jsondata[1]["transaction_description"];
    }

    public function responsejson($studentId = null)
    {
        $studenttransactions = $this->Studenttransactions->find('all')->where(['student_id' => $studentId]);
    
        $results = $studenttransactions->toArray();
        
        $json = json_encode($results); 
        
        return $json;
    }
    public function invoiceFee($id = null, $billNumber = null)
    {
        $studenttransaction = $this->Studenttransactions->get($id);
        
        $studenttransaction->invoiced = 1;
        $studenttransaction->bill_number = $billNumber;
        
        if (!($this->Studenttransactions->save($studenttransaction))) 
        {
            $this->Flash->error(__('La transacción del estudiante no pudo ser actualizada, intente nuevamente'));
        }
    }
    public function differenceAugust()
    {
        $this->loadModel('Rates');

        $concept = 'Diferencia agosto';
        
        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
                               'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();

        $studenttransactions = $this->Studenttransactions->find('all', ['conditions' => ['transaction_description' => "Ago 2017"]]);
        
        $results = $studenttransactions->toArray();
        
        if ($results) 
        {
            $accountantRecords = 0;
            
            foreach ($results as $result)
            {
                $studenttransaction = $this->Studenttransactions->get($result->id);
                
                $studenttransaction->amount = $row['amount'];
                $studenttransaction->original_amount = $row['amount'];
                $studenttransaction->paid_out = 0;

                if (!($this->Studenttransactions->save($studenttransaction))) 
                {
                    $this->Flash->error(__('La transacción del estudiante no pudo ser actualizada, intente nuevamente'));
                }
                else
                {
                    $accountantRecords++;
                }
            }
            echo "Total registros actualizados: " . $accountantRecords++;
        }
    }

    public function adjustTransactions()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) 
        {
            $transactions = json_decode($_POST['transactions']);
            $_POST = [];
    
            $transactionIndicator = 0;
    
            foreach ($transactions as $transaction) 
            {
                $studenttransaction = $this->Studenttransactions->get($transaction->idTransaction);
                
                $studenttransaction->original_amount = $transaction->originalAmount;

                $studenttransaction->amount = $transaction->originalAmount - $transaction->amount;

                if ($studenttransaction->amount > $studenttransaction->original_amount)
                {
                    $this->Flash->error(__('Error: El monto pendiente por pagar no debe ser mayor al monto de la cuota: ' . $studenttransaction->transaction_description . ' Pendiente: ' . $studenttransaction->amount . ' Cuota: ' . $studenttransaction->original_amount));
                    
                    $transactionIndicator = 1;                     
                }
                else
                {
                    if ($studenttransaction->amount == 0)
                    {
                        $studenttransaction->paid_out = 1;
                        $studenttransaction->partial_payment = 0;                            
                    }
                    elseif ($studenttransaction->amount == $studenttransaction->originalAmount)
                    {
                        $studenttransaction->paid_out = 0;
                        $studenttransaction->partial_payment = 0;                                                
                    }
                    else
                    {
                        $studenttransaction->paid_out = 0;
                        $studenttransaction->partial_payment = 1;                                                
                    }

                    if (!($this->Studenttransactions->save($studenttransaction)))  
                    {
                        $this->Flash->error(__('No se pudo actualizar la cuota' . $studenttransaction->transaction_description));
                        
                        $transactionIndicator = 1;   
                    }
                }                  
            }

            if ($transactionIndicator == 0)
            {
                $this->Flash->success(__('Las coutas fueron actualizadas correctamente'));
                
                return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
            }
            else
            {
                $this->Flash->error(__('Alguna cuota no fue actualizada, por favor intente nuevamente'));

                return $this->redirect(['controller' => 'Students', 'action' => 'modifyTransactions']);
            }
        }
        else
        {
            $this->Flash->error(__('Por motivos de seguridad se cerró la sesión. Por favor intente 
                actualizar las cuotas nuevamente'));

            return $this->redirect(['controller' => 'Students', 'action' => 'modifyTransactions']);
        }
    }
    public function newRegistration($newAmount = null, $yearRegistration = null)
    {
        $this->autoRender = false;
        
        $studentTransactions = $this->Studenttransactions->find('all', ['conditions' => ['transaction_description' => 'Matrícula ' . $yearRegistration]]);

        $account = 0;

        if ($studentTransactions) 
        {
            foreach ($studentTransactions as $studentTransaction)
            {

                $studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);

                if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
                {
                    $studentTransactionGet->original_amount = $newAmount;
                    $studentTransactionGet->amount = $newAmount;
                    $studentTransactionGet->paid_out = 0;
                    $studentTransactionGet->partial_payment = 0;
                }
                elseif ($studentTransactionGet->original_amount > $studentTransactionGet->amount)
                {
                    $differenceAmount = $newAmount - $studentTransactionGet->original_amount;
                    $studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
                    $studentTransactionGet->original_amount = $newAmount;
                    $studentTransactionGet->paid_out = 0;
                    $studentTransactionGet->partial_payment = 1;
                }

                if (!($this->Studenttransactions->save($studentTransactionGet)))
                {
                    $this->Flash->error(__('No pudo ser grabada la matrícula correspondiente al alumno cuyo ID es: ' . $studentTransaction->student_id));
                }

            $account++;
            
            }
            $this->Flash->success(__('Total matrículas actualizadas:  ' . $account)); 
        }
        return;
    }
    
    public function newMonthlyPayment($previousMonthlyPayment = null, $newAmount = null, $monthFrom = null, $yearFrom = null, $defaulters = null, $swDateException = null,$dateException = null)
    {
		$this->autoRender = false;
	
		$excels = new ExcelsController();
		
        $arrayResult = [];

        $previousMonthlyPayment80 = $previousMonthlyPayment * 0.8;
        
        $previousMonthlyPayment50 = $previousMonthlyPayment * 0.5;
        
        $newAmount80 = $newAmount * 0.8;
        
        $newAmount50 = $newAmount * 0.5;

        $yearMonthFrom = $yearFrom . $monthFrom;
		
		$dateFrom = new Time($yearFrom . '-' . $monthFrom . '-01 00:00:00');
			       
        $accountGeneral = 0;
        $accountDifferentAugust = 0;
        $accountAugust = 0;
        $accountPaymentException = 0;
        $accountAdjust = 0;
        $accountOutSequence = 0;
		$account20 = 0;
		$account50 = 0;
		$accountRegular = 0;
		$accountIrregular = 0;
		$swAdjust = 0;
		$previousIdStudent = 0;
		$swTruncateExcels = 0;
		$swErrorTransactions = 0;
		
		if ($defaulters == 1)
		{
			$arrayResult = $this->adjustDefaulters($yearFrom, $monthFrom, $newAmount); 
		}
				
		$studentTransactions = $this->Studenttransactions->find('all', ['conditions' => [['transaction_type' => 'Mensualidad'], ['payment_date >=' => $dateFrom]], 
			'order' => ['Studenttransactions.student_id' => 'ASC', 'payment_date' => 'ASC']]);
			
		$accountSelect = $studentTransactions->count();
		
        if ($studentTransactions) 
        {
            foreach ($studentTransactions as $studentTransaction)
            {			
                $accountGeneral++;
                
                $month = substr($studentTransaction->transaction_description, 0, 3);
                        
                if ($month != 'Ago')
                {
                    $accountDifferentAugust++;
													
					if ($swDateException == 1)
					{
						if ($studentTransaction->payment_date == $dateFrom)
						{							
							if ($studentTransaction->amount == 0)
							{
								if ($previousIdStudent != $studentTransaction->student_id)
								{
									$previousIdStudent = $studentTransaction->student_id;
								
									$swAdjust = $this->verifyPayment($dateFrom, $dateException, $studentTransaction->student_id);
							
									if ($swAdjust == 0)
									{
										$columns = [];
										
										$accountPaymentException++;
										
										$student = $this->Studenttransactions->Students->get($studentTransaction->student_id);
										
										$columns['report'] = 'Alumnos pago completo año escolar';
										$columns['number'] = $accountPaymentException;
										$columns['col1'] = $student->full_name;
										
										if ($swTruncateExcels == 0)
										{
											$excels->truncateTable();
											$swTruncateExcels = 1;
										}
										
										$swExcel = $excels->add($columns);

										if ($swExcel == 1)
										{
											$this->Flash->error(__('No pudo ser grabado en la tabla Excels el alumno: ' . $student->full_name));
										}
									}
									else
									{
										$accountAdjust++;
									}
								}
								else
								{
									$swAdjust = 0;
									$accountOutSequence++;
								}
							}
							else
							{
								$swAdjust = 1;
								$accountAdjust++;
							}
						}
					}
					else
					{
						$accountAdjust++;
						$swAdjust = 1;
					}
					
					if ($swAdjust == 1)
					{                       
						$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
						
						if ($studentTransaction->original_amount == $previousMonthlyPayment80)
						{
							$account20++;
							
							if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
							{
								$studentTransactionGet->original_amount = $newAmount80;
								$studentTransactionGet->amount = $newAmount80;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 0;
							}
							elseif ($studentTransactionGet->original_amount > $studentTransactionGet->amount)
							{
								$differenceAmount = $newAmount80 - $studentTransactionGet->original_amount;
								$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
								$studentTransactionGet->original_amount = $newAmount80;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 1;
							}
						}
						elseif ($studentTransaction->original_amount == $previousMonthlyPayment50)
						{
							$account50++;
							if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
							{
								$studentTransactionGet->original_amount = $newAmount50;
								$studentTransactionGet->amount = $newAmount50;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 0;
							}
							elseif ($studentTransactionGet->original_amount > $studentTransactionGet->amount)
							{
								$differenceAmount = $newAmount50 - $studentTransactionGet->original_amount;
								$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
								$studentTransactionGet->original_amount = $newAmount50;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 1;
							}
						}
						elseif ($studentTransaction->original_amount == $previousMonthlyPayment)
						{
							$accountRegular++;    
							if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
							{
								$studentTransactionGet->original_amount = $newAmount;
								$studentTransactionGet->amount = $newAmount;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 0;
							}
							elseif ($studentTransactionGet->original_amount > $studentTransactionGet->amount)
							{
								$differenceAmount = $newAmount - $studentTransactionGet->original_amount;
								$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
								$studentTransactionGet->original_amount = $newAmount;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 1;
							}
						}
						else
						{
							$accountIrregular++;     
						}

                        if (!($this->Studenttransactions->save($studentTransactionGet)))
                        {
							$swErrorTransactions = 1;
                        }

					}  
                }
				else
				{
					$accountAugust++;
				}
            }
			if ($swErrorTransactions == 0)
			{
				$arrayResult['indicator'] = 0;
				$arrayResult['message'] = 'Se actualizaron las mensualidades correctamente';			
			}
			else
			{
				$arrayResult['indicator'] = 1;
				$arrayResult['message'] = 'Error al actualizar las mensualidades';				
			}
			$arrayResult['adjust'] = $accountAdjust;
			$arrayResult['notAdjust'] = $accountPaymentException; 			
		}
		else
		{
			$arrayResult['indicator'] = 1;
			$arrayResult['message'] = 'No se encontraron mensualidades';
			$arrayResult['adjust'] = 0;
			$arrayResult['notAdjust'] = 0;
		}
        return $arrayResult;
    }

    function numberMonth($month = null)
    {
        $monthsSpanish = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $monthsEnglish = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        $spanishMonth = str_replace($monthsEnglish, $monthsSpanish, $month);
        return $spanishMonth;
    }
    public function searchLevel()
    {
        if ($this->request->is('post')) 
        {
            return $this->redirect(['action' => 'assignSection', $_POST['level_of_study']]);
        }
    }
    public function assignSection()
    {
        if ($this->request->is('post'))
        {
            if (isset($_POST['level']))
            {
                $level = $_POST['level'];
            }
            else
            {
                $result = 0;
                
                $accountStudent = 0;
                
                foreach ($_POST['student'] as $valor)
                {
                    $student = $this->Studenttransactions->Students->get($valor['id']);

                    if ($accountStudent == 0)
                    {
                        $level = $student->level_of_study;
                        
                        $sublevel = $this->levelSublevel($level);
                        
                        $sections = $this->Studenttransactions->Students->Sections->find('all')
                            ->where(['sublevel' => $sublevel])
                            ->order(['Sections.section' => 'ASC']);
                    }

                    foreach ($sections as $section)
                    {
                        if ($valor['section'] == $section->section)
                        {
                            $student->section_id = $section->id;
                        }
                    }
    
                    if (!($this->Studenttransactions->Students->save($student)))
                    {
                        $result = 1;
                        
                        $this->Flash->error(__('No pudo ser actualizado el alumno identificado con el id: ' . $valor['id']));            
                    }
                    $accountStudent++;
                }
                if ($result == 0)
                {
                    $this->Flash->success(__('Los alumnos fueron asignados exitosamente a su sección'));
                }
                
            }
        }
        
        $assign = 1;

        if (isset($level))
        {
            $studentTransactions = TableRegistry::get('Studenttransactions');
            
            $this->loadModel('Rates');
            
            $concept = 'Matrícula';
            
            $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
               'order' => ['Rates.created' => 'DESC'] ]);

            $row = $lastRecord->first();

            if($row)
            {
                $inscribed = $studentTransactions->find()
                    ->select(
                        ['Studenttransactions.id',
                        'Students.level_of_study'])
                    ->contain(['Students'])
                    ->where([['Studenttransactions.transaction_description' => 'Matrícula 2017'],
                        ['Studenttransactions.amount <' => $row->amount],
                        ['Students.level_of_study IS NOT NULL'], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]]);
        
                $totalEnrolled = $inscribed->count();
                
                $studentsLevel = $studentTransactions->find()
                    ->select(
                        ['Studenttransactions.id',
                        'Studenttransactions.transaction_description',
                        'Studenttransactions.amount',
                        'Students.id',
                        'Students.surname',
                        'Students.second_surname',
                        'Students.first_name',
                        'Students.second_name',
                        'Students.level_of_study',
                        'Students.section_id',
                        'Sections.level',
                        'Sections.sublevel',
                        'Sections.section'])
                    ->contain(['Students' => ['Sections']])
                    ->where([['Studenttransactions.transaction_description' => 'Matrícula 2017'],
                        ['Studenttransactions.amount <' => $row->amount],
                        ['Students.level_of_study' => $level]])
                    ->order(['Students.surname' => 'ASC', 'Students.second_name' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);
                    
                $totalLevel = $studentsLevel->count();
                
                $sectionA = 0;
                $sectionB = 0;
                $sectionC = 0;

                if ($level != '')
                {
                    $sublevel = $this->levelSublevel($level);

                    $sections = $this->Studenttransactions->Students->Sections->find('all')
                        ->where(['sublevel' => $sublevel])
                        ->order(['Sections.section' => 'ASC']);

                    foreach ($sections as $section)
                    {
                        if ($section->section == 'A')
                        {
                            $idSectionA = $section->id;
                        }
                    }                    
                }

                foreach ($studentsLevel as $studentsLevels)
                {     
                    if ($level != '')
                    {
                        $swSection = 0;

                        foreach ($sections as $section)
                        {
                            if ($studentsLevels->student->section_id == $section->id)
                            {
                                $swSection = 1;
                            }
                        }

                        if ($swSection == 0)
                        {
                            $student = $this->Studenttransactions->Students->get($studentsLevels->student->id);

                            $student->section_id = $idSectionA;        

                            if (!($this->Studenttransactions->Students->save($student)))
                            {                       
                                $this->Flash->error(__('No pudo ser actualizado el alumno identificado con el id: ' . $student->id));            
                            }

                        }
                    }

                    if ($studentsLevels->student->section->section == 'A')
                    {
                        $sectionA++;
                    }
                    elseif ($studentsLevels->student->section->section == 'B')
                    {
                        $sectionB++;
                    }
                    elseif ($studentsLevels->student->section->section == 'C')
                    {
                        $sectionC++;
                    }
                    else
                    {
                        $sectionA++;
                    }
                }
                
                $levelChat = $this->replaceCharacters($level);

                $lastRate = $row->amount;
                
                $this->set(compact('level', 'studentsLevel', 'totalEnrolled', 'totalLevel', 'sectionA', 'sectionB', 'sectionC', 'levelChat', 'assign', 'lastRate'));
                $this->set('_serialize', ['level', 'studentsLevel', 'totalEnrolled', 'totalLevel', 'sectionA', 'sectionB', 'sectionC', 'levelChat', 'assign', 'lastRate']);
            }
        }
        else
        {
            $this->set(compact('assign'));
            $this->set('_serialize', ['assign']);
        }
    }
    public function levelSublevel($level = null)
    {
        $levelOfStudy = ['Pre-escolar, pre-kinder',                                
                        'Pre-escolar, kinder',
                        'Pre-escolar, preparatorio',
                        'Primaria, 1er. grado',
                        'Primaria, 2do. grado',
                        'Primaria, 3er. grado',
                        'Primaria, 4to. grado',
                        'Primaria, 5to. grado',
                        'Primaria, 6to. grado',
                        'Secundaria, 1er. año',
                        'Secundaria, 2do. año',
                        'Secundaria, 3er. año',
                        'Secundaria, 4to. año',
                        'Secundaria, 5to. año'];
        $sub = ["Pre-kinder",
                    "Kinder",
                    "Preparatorio",
                    "1er. Grado",
                    "2do. Grado",
                    "3er. Grado",
                    "4to. Grado",
                    "5to. Grado",
                    "6to. Grado",
                    "1er. Año",
                    "2do. Año",
                    "3er. Año",
                    "4to. Año",
                    "5to. Año"];
        $sublevel = str_replace($levelOfStudy, $sub, $level);
        return $sublevel;
    }
    public function searchSections()
    {
        if ($this->request->is('post')) 
        {
            return $this->redirect(['action' => 'reportSections', $_POST['level_of_study'],  $_POST['section']]);
        }

        $this->set(compact('sections'));
    }
    public function reportSections($level = null, $section = null)
    {
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);
        
        $studentTransactions = TableRegistry::get('Studenttransactions');

        $studentsFor = $studentTransactions->find()
            ->select(
                ['Studenttransactions.id',
                'Studenttransactions.transaction_description',
                'Studenttransactions.amount',
                'Students.id',
                'Students.surname',
                'Students.second_surname',
                'Students.first_name',
                'Students.second_name',
                'Students.level_of_study',
                'Students.section_id',
                'Sections.level',
                'Sections.sublevel',
                'Sections.section'])
            ->contain(['Students' => ['Sections']])
            ->where([['Studenttransactions.transaction_description' => 'Matrícula 2017'],
                ['Studenttransactions.amount <' => 69500],
                ['Students.level_of_study' => $level],
                'Sections.section' => $section])
            ->order(['Students.surname' => 'ASC', 'Students.second_name' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);

        $account = $studentsFor->count();
        
        $totalPages = ceil($studentsFor->count() / 30);

        $this->set(compact('school', 'studentsFor', 'level', 'section', 'totalPages'));
        $this->set('_serialize', ['school', 'studentsFor', 'level', 'section', 'totalPages']);
    }
    public function reportLevel($level = null)
    {
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);

        $this->loadModel('Rates');
        
        $concept = 'Matrícula';
        
        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
           'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();

        if($row)
        {
            $studentTransactions = TableRegistry::get('Studenttransactions');

            $studentsFor = $studentTransactions->find()
                ->select(
                    ['Studenttransactions.id',
                    'Studenttransactions.transaction_description',
                    'Studenttransactions.amount',
                    'Students.id',
                    'Students.surname',
                    'Students.second_surname',
                    'Students.first_name',
                    'Students.second_name',
                    'Students.level_of_study',
                    'Students.section_id',
                    'Sections.level',
                    'Sections.sublevel',
                    'Sections.section'])
                ->contain(['Students' => ['Sections']])
                ->where([['Studenttransactions.transaction_description' => 'Matrícula 2017'],
                    ['Studenttransactions.amount <' => $row->amount],
                    ['Students.level_of_study' => $level]])
                ->order(['Sections.section' => 'ASC', 'Students.surname' => 'ASC', 'Students.second_name' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);

            $account = $studentsFor->count();
            
            $totalPages = ceil($studentsFor->count() / 30) + 2;
            
            $levelChatScript = $this->replaceChatScript($level);

            $this->set(compact('school', 'studentsFor', 'level', 'totalPages', 'levelChatScript'));
            $this->set('_serialize', ['school', 'studentsFor', 'level', 'totalPages', 'levelChatScript']);
        }
    }
    public function replaceCharacters($level = null)
    {
        $levelOfStudy = ['Pre-escolar, pre-kinder',                                
                        'Pre-escolar, kinder',
                        'Pre-escolar, preparatorio',
                        'Primaria, 1er. grado',
                        'Primaria, 2do. grado',
                        'Primaria, 3er. grado',
                        'Primaria, 4to. grado',
                        'Primaria, 5to. grado',
                        'Primaria, 6to. grado',
                        'Secundaria, 1er. año',
                        'Secundaria, 2do. año',
                        'Secundaria, 3er. año',
                        'Secundaria, 4to. año',
                        'Secundaria, 5to. año'];
        $chat = ['Pre-escolar%2c%20pre-kinder',                                
                        'Pre-escolar%2c%20kinder',
                        'Pre-escolar%2c%20preparatorio',
                        'Primaria%2c%201er.%20grado',
                        'Primaria%2c%202do.%20grado',
                        'Primaria%2c%203er.%20grado',
                        'Primaria%2c%204to.%20grado',
                        'Primaria%2c%205to.%20grado',
                        'Primaria%2c%206to.%20grado',
                        'Secundaria%2c%201er.%20año',
                        'Secundaria%2c%202do.%20año',
                        'Secundaria%2c%203er.%20año',
                        'Secundaria%2c%204to.%20año',
                        'Secundaria%2c%205to.%20año'];
        $levelChat = str_replace($levelOfStudy, $chat, $level);
        return $levelChat;
    }
    public function replaceChatScript($level = null)
    {
        $levelOfStudy = ['Pre-escolar, pre-kinder',                                
                        'Pre-escolar, kinder',
                        'Pre-escolar, preparatorio',
                        'Primaria, 1er. grado',
                        'Primaria, 2do. grado',
                        'Primaria, 3er. grado',
                        'Primaria, 4to. grado',
                        'Primaria, 5to. grado',
                        'Primaria, 6to. grado',
                        'Secundaria, 1er. año',
                        'Secundaria, 2do. año',
                        'Secundaria, 3er. año',
                        'Secundaria, 4to. año',
                        'Secundaria, 5to. año'];
        $chat = ['Pre-kinder',                                
                    'Kinder',
                    'Preparatorio',
                    '1er_grado',
                    '2do_grado',
                    '3er_grado',
                    '4to_grado',
                    '5to_grado',
                    '6to_grado',
                    '1er_año',
                    '2do_año',
                    '3er_año',
                    '4to_año',
                    '5to_año'];
        $levelChatScript = str_replace($levelOfStudy, $chat, $level);
        return $levelChatScript;
    }
    public function reportStudentGeneral()
    {
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);

        $this->loadModel('Rates');
        
        $concept = 'Matrícula';
        
        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
           'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();

        if($row)
        {
            $studentTransactions = TableRegistry::get('Studenttransactions');

            $studentsFor = $studentTransactions->find()
                ->select(
                    ['Studenttransactions.id',
                    'Studenttransactions.transaction_description',
                    'Studenttransactions.amount',
                    'Students.id',
                    'Students.surname',
                    'Students.second_surname',
                    'Students.first_name',
                    'Students.second_name',
                    'Students.level_of_study',
                    'Students.type_of_identification',
                    'Students.identity_card',
                    'Students.section_id',
                    'Students.sex',
                    'Students.birthdate',
                    'Parentsandguardians.type_of_identification',
                    'Parentsandguardians.identidy_card',
                    'Parentsandguardians.surname',
                    'Parentsandguardians.second_surname',
                    'Parentsandguardians.first_name',
                    'Parentsandguardians.second_name'])
                ->contain(['Students' => ['Parentsandguardians']])
                ->where([['Studenttransactions.transaction_description' => 'Matrícula 2017'],
                    ['Studenttransactions.amount <' => $row->amount], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]])
                ->order(['Students.surname' => 'ASC', 'Students.second_name' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);

            $account = $studentsFor->count();
            
            $totalPages = ceil($studentsFor->count() / 20);

            setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
            date_default_timezone_set('America/Caracas');

            $currentDate = Time::now();

            $this->set(compact('school', 'studentsFor', 'totalPages', 'currentDate'));
            $this->set('_serialize', ['school', 'studentsFor', 'totalPages', 'currentDate']);
        }
    }
    
    public function reportFamilyStudents()
    {
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);

        $this->loadModel('Rates');
        
        $concept = 'Matrícula';
        
        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
           'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();

        if($row)
        {
            $studentTransactions = TableRegistry::get('Studenttransactions');

            $studentsFor = $studentTransactions->find()
                ->select(
                    ['Studenttransactions.id',
                    'Studenttransactions.transaction_description',
                    'Studenttransactions.amount',
                    'Students.id',
                    'Students.surname',
                    'Students.second_surname',
                    'Students.first_name',
                    'Students.second_name',
                    'Students.level_of_study',
                    'Students.type_of_identification',
                    'Students.identity_card',
                    'Students.section_id',
                    'Parentsandguardians.id',
                    'Parentsandguardians.type_of_identification',
                    'Parentsandguardians.identidy_card',
                    'Parentsandguardians.surname',
                    'Parentsandguardians.second_surname',
                    'Parentsandguardians.first_name',
                    'Parentsandguardians.second_name'])
                ->contain(['Students' => ['Parentsandguardians']])
                ->where([['Studenttransactions.transaction_description' => 'Matrícula 2017'],
                    ['Studenttransactions.amount <' => $row->amount], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]])
                ->order(['Parentsandguardians.id' => 'ASC']);

            $account = $studentsFor->count();
            
            setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
            date_default_timezone_set('America/Caracas');

            $currentDate = Time::now();

            $idParent = 0;
            $accountRecords = 0;
            $accountChildren = 0;
            $accountFamily = 0;
            $accountUnHijo = 0;
            $accountDosHijos = 0;
            $accountTresHijos = 0;
            $accountCuatroHijos = 0;
            $accountCincoOMas = 0;

            foreach ($studentsFor as $studentsFors)
            {
                if ($accountRecords == 0)
                {
                    $idParent = $studentsFors->student->parentsandguardian->id;
                    $accountChildren++;
                    $accountFamily++;
                    $accountRecords++;
                }
                else
                {
                    if ($idParent != $studentsFors->student->parentsandguardian->id)
                    {
                        if ($accountChildren < 1)
                        {
                            $this->Flash->error(__('Error en contador de registros del padre identificado con el ID: ' . $studentsFors->student->parentsandguardian->id));
                        }
                        elseif ($accountChildren == 1)
                        {
                            $accountUnHijo++;
                        }
                        elseif ($accountChildren == 2)
                        {
                            $accountDosHijos++;
                        }
                        elseif ($accountChildren == 3)
                        {
                            $accountTresHijos++;
                        }
                        elseif ($accountChildren == 4)
                        {
                            $accountCuatroHijos++;
                        }
                        elseif ($accountChildren >= 5)
                        {
                            $accountCincoOMas++;
                        }
                        $idParent = $studentsFors->student->parentsandguardian->id;
                        $accountChildren = 1;
                        $accountFamily++;
                        $accountRecords++;
                    }
                    else
                    {
                        $accountChildren++; 
                        $accountRecords++;                        
                    }
                }
            }
            if ($accountChildren < 1)
            {
                $this->Flash->error(__('Error en contador de registros del padre identificado con el ID: ' . $studentsFors->student->parentsandguardian->id));
            }
            elseif ($accountChildren == 1)
            {
                $accountUnHijo++;
            }
            elseif ($accountChildren == 2)
            {
                $accountDosHijos++;
            }
            elseif ($accountChildren == 3)
            {
                $accountTresHijos++;
            }
            elseif ($accountChildren == 4)
            {
                $accountCuatroHijos++;
            }
            elseif ($accountChildren >= 5)
            {
                $accountCincoOMas++;
            }

            $this->set(compact('school', 'studentsFor', 'currentDate', 'account', 'accountUnHijo', 'accountDosHijos', 'accountTresHijos', 'accountCuatroHijos', 'accountCincoOMas', 'accountFamily'));
            $this->set('_serialize', ['school', 'studentsFor', 'currentDate', 'account', 'accountUnHijo', 'accountDosHijos', 'accountTresHijos', 'accountCuatroHijos', 'accountCincoOMas', 'accountFamily']);
        }
    }
    public function discountQuota80()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $idParent = 0;
        $accountRecords = 0;
        $accountChildren = 0;
        $accountTresHijos = 0;
        $arrayStudents = [];
        $accountStudents = 0;
        $arrayDiscounts = [];
        $swDiscounts = 0;
        $accountDiscounts = 0;
        $arrayDiscarded = [];
        $accountDiscarded = 0;

        $currentDate = time::now();

        $currentYear = $currentDate->year;
        
        $lastYear = $currentDate->year - 1;
        
        $nextYear = $currentDate->year + 1;
        
        $currentMonth = $currentDate->month;
        
        $currentYearMonth = $currentDate->year . $currentDate->month;

        if ($currentMonth > 8)
        {
            $startingYear = $currentYear;
            
            $finalYear = $nextYear;  
        }
        else
        {
            $startingYear = $lastYear;
            
            $finalYear = $currentYear;  
        }

		$students20 = $this->Studenttransactions->Students->find('all', ['conditions' => ['Students.discount' => 20]]);
		
        if ($students20)
		{
			foreach ($students20 as $students20s)
			{
				$student = $this->Studenttransactions->Students->get($student20s->id);
				
				$student->discount = 0;
				
				if (!($this->Studenttransactions->Students->save($student)))
				{
					$this->Flash->error(__('No se pudo inicializar la columna discount en el registro Nro. ' . $student20s->id));
				}
            }
		}
		
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);

        $this->loadModel('Rates');
        
        $concept = 'Matrícula';
        
        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
           'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();

        if($row)
        {
            $registration = 'Matrícula ' . $startingYear;
            
            $studentTransactions = TableRegistry::get('Studenttransactions');

            $studentsFor = $studentTransactions->find()
                ->select(
                    ['Studenttransactions.id',
                    'Studenttransactions.transaction_type',
                    'Studenttransactions.transaction_description',
                    'Studenttransactions.amount',
                    'Students.id',
                    'Students.surname',
                    'Students.second_surname',
                    'Students.first_name',
                    'Students.second_name',
                    'Students.level_of_study',
                    'Students.scholarship',
                    'Parentsandguardians.id',
                    'Parentsandguardians.family'])
                ->contain(['Students' => ['Parentsandguardians']])
                ->where([['Studenttransactions.transaction_description' => $registration],
                    ['Studenttransactions.amount <' => $row->amount]])
                ->order(['Parentsandguardians.id' => 'ASC']);
                
            $account = $studentsFor->count();
            
            $conceptM = 'Mensualidad';
            
            $lastRecordM = $this->Rates->find('all', ['conditions' => ['concept' => $conceptM], 
               'order' => ['Rates.created' => 'DESC'] ]);
    
            $rowM = $lastRecordM->first();

            if ($rowM)
            {
                $schoolPeriod = ['Sep ' . $startingYear,
                                'Oct ' . $startingYear,
                                'Nov ' . $startingYear,
                                'Dic ' . $startingYear,
                                'Ene ' . $finalYear,
                                'Feb ' . $finalYear,
                                'Mar ' . $finalYear,
                                'Abr ' . $finalYear,
                                'May ' . $finalYear,
                                'Jun ' . $finalYear,
                                'Jul ' . $finalYear];
 
                $studentsDiscounts = $studentTransactions->find()
                    ->select(
                        ['Studenttransactions.id',
                        'Studenttransactions.student_id',
                        'Studenttransactions.transaction_type',
                        'Studenttransactions.transaction_description',
                        'Studenttransactions.paid_out',
                        'Studenttransactions.original_amount',
                        'Studenttransactions.amount'])
                    ->where([['Studenttransactions.transaction_type' => 'Mensualidad'],
                    ['Studenttransactions.transaction_description IN' => $schoolPeriod]])
                    ->order(['Studenttransactions.student_id' => 'ASC']);
                    
                $accountFee = $studentsDiscounts->count();
                
                foreach ($studentsFor as $studentsFors)
                {
                    if ($accountRecords == 0)
                    {
                        $idParent = $studentsFors->student->parentsandguardian->id;
                        
                        $level = $studentsFors->student->level_of_study;
                        
                        $order = $this->orderLevel($level);
                        
                        if ($order == 0)
                        {
                            $arrayDiscarded[$accountDiscarded]['reason'] = 'Datos sin actualizar';
                            $arrayDiscarded[$accountDiscarded]['student'] = $studentsFors->student->full_name;
                            $arrayDiscarded[$accountDiscarded]['id'] = $studentsFors->student->id;
                            $accountDiscarded++;
                        }
                        
                        $arrayStudents[$accountStudents]['order'] =  $order;
                        $arrayStudents[$accountStudents]['student'] = $studentsFors->student->full_name;
                        $arrayStudents[$accountStudents]['grade'] = $studentsFors->student->level_of_study;
                        $arrayStudents[$accountStudents]['scholarship'] = $studentsFors->student->scholarship;
                        $arrayStudents[$accountStudents]['id'] = $studentsFors->student->id;
                        $arrayStudents[$accountStudents]['family'] = $studentsFors->student->parentsandguardian->family;
                        $arrayStudents[$accountStudents]['idFamily'] = $studentsFors->student->parentsandguardian->id;
                        
                        $accountStudents++;
                        $accountRecords++;
                        $accountChildren++;
                        
                    }
                    else
                    {
                        if ($idParent != $studentsFors->student->parentsandguardian->id)
                        {
                            if ($accountChildren == 3)
                            {
                                $accountTresHijos++;
                                $arrayGeneral = $this->discount80($arrayStudents, $studentsDiscounts, $rowM->amount, $arrayDiscounts, $accountDiscounts, $arrayDiscarded, $accountDiscarded);
                                $arrayDiscounts = $arrayGeneral[0];
                                $accountDiscounts = $arrayGeneral[1];
                                $arrayDiscarded = $arrayGeneral[2];
                                $accountDiscarded = $arrayGeneral[3];
                            }
                            $accountStudents = 0;
                            $accountChildren = 0;
                            $arrayStudents = [];

                            $idParent = $studentsFors->student->parentsandguardian->id;
                            
                            $level = $studentsFors->student->level_of_study;
                            
                            $order = $this->orderLevel($level);
                            
                            if ($order == 0)
                            {
                                $arrayDiscarded[$accountDiscarded]['reason'] = 'Datos sin actualizar';
                                $arrayDiscarded[$accountDiscarded]['student'] = $studentsFors->student->full_name;
                                $arrayDiscarded[$accountDiscarded]['id'] = $studentsFors->student->id;
                                $accountDiscarded++;
                            }
                            
                            $arrayStudents[$accountStudents]['order'] =  $order;
                            $arrayStudents[$accountStudents]['student'] = $studentsFors->student->full_name;
                            $arrayStudents[$accountStudents]['grade'] = $studentsFors->student->level_of_study;
                            $arrayStudents[$accountStudents]['scholarship'] = $studentsFors->student->scholarship;
                            $arrayStudents[$accountStudents]['id'] = $studentsFors->student->id;
                            $arrayStudents[$accountStudents]['family'] = $studentsFors->student->parentsandguardian->family;
                            $arrayStudents[$accountStudents]['idFamily'] = $studentsFors->student->parentsandguardian->id;

                            $accountStudents++;
                            $accountRecords++;
                            $accountChildren++;
                            
                        }
                        else
                        {
                            $level = $studentsFors->student->level_of_study;
                            
                            $order = $this->orderLevel($level);
                            
                            if ($order == 0)
                            {
                                $arrayDiscarded[$accountDiscarded]['reason'] = 'Datos sin actualizar';
                                $arrayDiscarded[$accountDiscarded]['student'] = $studentsFors->student->full_name;
                                $arrayDiscarded[$accountDiscarded]['id'] = $studentsFors->student->id;
                                $accountDiscarded++;
                            }
                            
                            $arrayStudents[$accountStudents]['order'] =  $order;
                            $arrayStudents[$accountStudents]['student'] = $studentsFors->student->full_name;
                            $arrayStudents[$accountStudents]['grade'] = $studentsFors->student->level_of_study;
                            $arrayStudents[$accountStudents]['scholarship'] = $studentsFors->student->scholarship;
                            $arrayStudents[$accountStudents]['id'] = $studentsFors->student->id;
                            $arrayStudents[$accountStudents]['family'] = $studentsFors->student->parentsandguardian->family;
                            $arrayStudents[$accountStudents]['idFamily'] = $studentsFors->student->parentsandguardian->id;
                            
                            $accountStudents++;
                            $accountRecords++;
                            $accountChildren++;
                        }
                    }
                }
                if ($accountChildren == 3)
                {
                    $accountTresHijos++;
                    $arrayGeneral = $this->discount80($arrayStudents, $studentsDiscounts, $rowM->amount, $arrayDiscounts, $accountDiscounts, $arrayDiscarded, $accountDiscarded);
                    $arrayDiscounts = $arrayGeneral[0];
                    $accountDiscounts = $arrayGeneral[1];
                    $arrayDiscarded = $arrayGeneral[2];
                    $accountDiscarded = $arrayGeneral[3];
                }

                sort($arrayDiscounts);
                sort($arrayDiscarded);

                $this->set(compact('school', 'currentDate', 'arrayDiscounts', 'account', 'accountTresHijos', 'arrayDiscarded'));
                $this->set('_serialize', ['school', 'currentDate', 'arrayDiscounts', 'account', 'accountTresHijos', 'arrayDiscarded']);
            }
        }
    }
    
    public function discount80($arrayStudents = null, $studentsDiscounts = null, $amount = null, $arrayDiscounts = null, $accountDiscounts = null, $arrayDiscarded = null, $accountDiscarded = null)
    {
        $fee80 = $amount * 0.8;

        arsort($arrayStudents);
        $accountHigher = 1;

        foreach ($arrayStudents as $arrayStudent)
        {

            if ($accountHigher == 1)
            {
                $swDiscounts = 0;
				$swUpdateStudent = 0;
                foreach ($studentsDiscounts as $studentsDiscount)
                {
                    if ($studentsDiscount->student_id == $arrayStudent['id'])
                    {
						if ($swDiscountStudent == 0)
						{
							$student = $this->Studenttransactions->Students->get($arrayStudent['id']);
				
							$student->discount = 20;
				
							if (!($this->Studenttransactions->Students->save($student)))
							{
								$this->Flash->error(__('No se pudo actualizar la columna discount en el registro Nro. ' . $arrayStudent['id']));
							}
							$swUpdateStudent = 1;
						}
						if ($studentsDiscount->original_amount == $fee80)
                        {
                            $arrayDiscarded[$accountDiscarded]['reason'] = 'Descuento 20% aplicado anteriormente';
                            $arrayDiscarded[$accountDiscarded]['student'] = $arrayStudent['student'];
                            $arrayDiscarded[$accountDiscarded]['id'] =  $arrayStudent['id'];
                            $accountDiscarded++;
                        }
                        elseif ($studentsDiscount->original_amount == $amount)
                        {
                            if ($arrayStudent['scholarship'] == true)
                            {
                                $arrayDiscarded[$accountDiscarded]['reason'] = 'Alumno becado';
                                $arrayDiscarded[$accountDiscarded]['student'] = $arrayStudent['student'];
                                $arrayDiscarded[$accountDiscarded]['id'] =  $arrayStudent['id'];
                                $accountDiscarded++;
                            }
                            else
                            {
                                if ($studentsDiscount->paid_out == 0)
                                {
                                    $studenttransaction = $this->Studenttransactions->get($studentsDiscount->id);

                                    $subscriber = $studenttransaction->original_amount - $studenttransaction->amount;
                                    
                                    $studenttransaction->original_amount = $fee80;
                                    
                                    $studenttransaction->amount = $fee80 - $subscriber;
                                    
                                    if ($studenttransaction->amount == 0)
                                    {
                                        $studenttransaction->paid_out = 1;
                                    }
                                    else
                                    {
                                        $studenttransaction->paid_out = 0;
                                    }
                                                            
                                    if (!($this->Studenttransactions->save($studenttransaction)))
                                    {
                                        $arrayDiscarded[$accountDiscarded]['reason'] = 'No se pudo hacer descuento en cuota ' . $studenttransaction->id;
                                        $arrayDiscarded[$accountDiscarded]['student'] = $arrayStudent['student'];
                                        $arrayDiscarded[$accountDiscarded]['id'] =  $arrayStudent['id'];
                                        $accountDiscarded++;
                                    }

                                    if ($swDiscounts == 0)
                                    {

                                        $arrayDiscounts[$accountDiscounts]['family'] = $arrayStudent['family'];
                                        $arrayDiscounts[$accountDiscounts]['discount'] = '20%';
                                        $arrayDiscounts[$accountDiscounts]['student'] = $arrayStudent['student'];
                                        $arrayDiscounts[$accountDiscounts]['grade'] = $arrayStudent['grade'];
                                        $arrayDiscounts[$accountDiscounts]['id'] = $arrayStudent['id'];
                                        $accountDiscounts++;
                                        $swDiscounts = 1;                                                            
                                    }
                                }
                                else
                                {
                                    $arrayDiscarded[$accountDiscarded]['reason'] = 'Mensualidad ya pagada';
                                    $arrayDiscarded[$accountDiscarded]['student'] = $arrayStudent['student'];
                                    $arrayDiscarded[$accountDiscarded]['id'] =  $arrayStudent['id'];
                                    $accountDiscarded++;
                                }
                            }
                        }
                        else
                        {
                            $arrayDiscarded[$accountDiscarded]['reason'] = 'El monto de la cuota no coincide';
                            $arrayDiscarded[$accountDiscarded]['student'] = $arrayStudent['student'];
                            $arrayDiscarded[$accountDiscarded]['id'] =  $arrayStudent['id'];
                            $accountDiscarded++;
                        }
                    }
                }
            }
            else
            {
                foreach ($studentsDiscounts as $studentsDiscount)
                {
                    if ($studentsDiscount->student_id == $arrayStudent['id'])
                    {
                        if ($studentsDiscount->original_amount != $amount)
                        {
                            $arrayDiscarded[$accountDiscarded]['reason'] = 'El monto de la cuota no coincide';
                            $arrayDiscarded[$accountDiscarded]['student'] = $arrayStudent['student'];
                            $arrayDiscarded[$accountDiscarded]['id'] =  $arrayStudent['id'];
                            $accountDiscarded++;
                        }
                    }
                }
            }
            $accountHigher++;
        }
        
        return [$arrayDiscounts, $accountDiscounts, $arrayDiscarded, $accountDiscarded];
    }

    public function discountQuota50()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $idParent = 0;
        $accountRecords = 0;
        $accountChildren = 0;
        $accountCuatroOmas = 0;
        $arrayStudents = [];
        $accountStudents = 0;
        $arrayDiscounts = [];
        $swDiscounts = 0;
        $accountDiscounts = 0;
        $arrayDiscarded = [];
        $accountDiscarded = 0;

        $currentDate = time::now();

        $currentYear = $currentDate->year;
        
        $lastYear = $currentDate->year - 1;
        
        $nextYear = $currentDate->year + 1;
        
        $currentMonth = $currentDate->month;
        
        $currentYearMonth = $currentDate->year . $currentDate->month;

        if ($currentMonth > 8)
        {
            $startingYear = $currentYear;
            
            $finalYear = $nextYear;  
        }
        else
        {
            $startingYear = $lastYear;
            
            $finalYear = $currentYear;  
        }

		$students50 = $this->Studenttransactions->Students->find('all', ['conditions' => ['Students.discount' => 50]]);

        if ($students50)
		{
			foreach ($students50 as $students50s)
			{
				$student = $this->Studenttransactions->Students->get($student50s->id);
				
				$student->discount = 0;
				
				if (!($this->Studenttransactions->Students->save($student)))
				{
					$this->Flash->error(__('No se pudo inicializar la columna discount en el registro Nro. ' . $student50s->id));
				}
            }
		}
		
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);

        $this->loadModel('Rates');
        
        $concept = 'Matrícula';
        
        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
           'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();

        if($row)
        {
            $registration = 'Matrícula ' . $startingYear;
            
            $studentTransactions = TableRegistry::get('Studenttransactions');

            $studentsFor = $studentTransactions->find()
                ->select(
                    ['Studenttransactions.id',
                    'Studenttransactions.transaction_type',
                    'Studenttransactions.transaction_description',
                    'Studenttransactions.amount',
                    'Students.id',
                    'Students.surname',
                    'Students.second_surname',
                    'Students.first_name',
                    'Students.second_name',
                    'Students.level_of_study',
                    'Students.scholarship',
                    'Parentsandguardians.id',
                    'Parentsandguardians.family'])
                ->contain(['Students' => ['Parentsandguardians']])
                ->where([['Studenttransactions.transaction_description' => $registration],
                    ['Studenttransactions.amount <' => $row->amount]])
                ->order(['Parentsandguardians.id' => 'ASC']);
                
            $account = $studentsFor->count();
            
            $conceptM = 'Mensualidad';
            
            $lastRecordM = $this->Rates->find('all', ['conditions' => ['concept' => $conceptM], 
               'order' => ['Rates.created' => 'DESC'] ]);
    
            $rowM = $lastRecordM->first();

            if ($rowM)
            {
                $schoolPeriod = ['Sep ' . $startingYear,
                                'Oct ' . $startingYear,
                                'Nov ' . $startingYear,
                                'Dic ' . $startingYear,
                                'Ene ' . $finalYear,
                                'Feb ' . $finalYear,
                                'Mar ' . $finalYear,
                                'Abr ' . $finalYear,
                                'May ' . $finalYear,
                                'Jun ' . $finalYear,
                                'Jul ' . $finalYear];
 
                $studentsDiscounts = $studentTransactions->find()
                    ->select(
                        ['Studenttransactions.id',
                        'Studenttransactions.student_id',
                        'Studenttransactions.transaction_type',
                        'Studenttransactions.transaction_description',
                        'Studenttransactions.paid_out',
                        'Studenttransactions.original_amount',
                        'Studenttransactions.amount'])
                    ->where([['Studenttransactions.transaction_type' => 'Mensualidad'],
                    ['Studenttransactions.transaction_description IN' => $schoolPeriod]])
                    ->order(['Studenttransactions.student_id' => 'ASC']);
                    
                $accountFee = $studentsDiscounts->count();
                
                foreach ($studentsFor as $studentsFors)
                {
                    if ($accountRecords == 0)
                    {
                        $idParent = $studentsFors->student->parentsandguardian->id;
                        
                        $level = $studentsFors->student->level_of_study;
                        
                        $order = $this->orderLevel($level);
                        
                        if ($order == 0)
                        {
                            $arrayDiscarded[$accountDiscarded]['reason'] = 'Datos sin actualizar';
                            $arrayDiscarded[$accountDiscarded]['student'] = $studentsFors->student->full_name;
                            $arrayDiscarded[$accountDiscarded]['id'] = $studentsFors->student->id;
                            $accountDiscarded++;
                        }
                        
                        $arrayStudents[$accountStudents]['order'] =  $order;
                        $arrayStudents[$accountStudents]['student'] = $studentsFors->student->full_name;
                        $arrayStudents[$accountStudents]['grade'] = $studentsFors->student->level_of_study;
                        $arrayStudents[$accountStudents]['scholarship'] = $studentsFors->student->scholarship;
                        $arrayStudents[$accountStudents]['id'] = $studentsFors->student->id;
                        $arrayStudents[$accountStudents]['family'] = $studentsFors->student->parentsandguardian->family;
                        $arrayStudents[$accountStudents]['idFamily'] = $studentsFors->student->parentsandguardian->id;
                        
                        $accountStudents++;
                        $accountRecords++;
                        $accountChildren++;
                        
                    }
                    else
                    {
                        if ($idParent != $studentsFors->student->parentsandguardian->id)
                        {
                            if ($accountChildren > 3)
                            {
                                $accountCuatroOmas++;
                                $arrayGeneral = $this->discount50($arrayStudents, $studentsDiscounts, $rowM->amount, $arrayDiscounts, $accountDiscounts, $arrayDiscarded, $accountDiscarded);
                                $arrayDiscounts = $arrayGeneral[0];
                                $accountDiscounts = $arrayGeneral[1];
                                $arrayDiscarded = $arrayGeneral[2];
                                $accountDiscarded = $arrayGeneral[3];
                            }
                            $accountStudents = 0;
                            $accountChildren = 0;
                            $arrayStudents = [];

                            $idParent = $studentsFors->student->parentsandguardian->id;
                            
                            $level = $studentsFors->student->level_of_study;
                            
                            $order = $this->orderLevel($level);
                            
                            if ($order == 0)
                            {
                                $arrayDiscarded[$accountDiscarded]['reason'] = 'Datos sin actualizar';
                                $arrayDiscarded[$accountDiscarded]['student'] = $studentsFors->student->full_name;
                                $arrayDiscarded[$accountDiscarded]['id'] = $studentsFors->student->id;
                                $accountDiscarded++;
                            }
                            
                            $arrayStudents[$accountStudents]['order'] =  $order;
                            $arrayStudents[$accountStudents]['student'] = $studentsFors->student->full_name;
                            $arrayStudents[$accountStudents]['grade'] = $studentsFors->student->level_of_study;
                            $arrayStudents[$accountStudents]['scholarship'] = $studentsFors->student->scholarship;
                            $arrayStudents[$accountStudents]['id'] = $studentsFors->student->id;
                            $arrayStudents[$accountStudents]['family'] = $studentsFors->student->parentsandguardian->family;
                            $arrayStudents[$accountStudents]['idFamily'] = $studentsFors->student->parentsandguardian->id;

                            $accountStudents++;
                            $accountRecords++;
                            $accountChildren++;
                            
                        }
                        else
                        {
                            $level = $studentsFors->student->level_of_study;
                            
                            $order = $this->orderLevel($level);
                            
                            if ($order == 0)
                            {
                                $arrayDiscarded[$accountDiscarded]['reason'] = 'Datos sin actualizar';
                                $arrayDiscarded[$accountDiscarded]['student'] = $studentsFors->student->full_name;
                                $arrayDiscarded[$accountDiscarded]['id'] = $studentsFors->student->id;
                                $accountDiscarded++;
                            }
                            
                            $arrayStudents[$accountStudents]['order'] =  $order;
                            $arrayStudents[$accountStudents]['student'] = $studentsFors->student->full_name;
                            $arrayStudents[$accountStudents]['grade'] = $studentsFors->student->level_of_study;
                            $arrayStudents[$accountStudents]['scholarship'] = $studentsFors->student->scholarship;
                            $arrayStudents[$accountStudents]['id'] = $studentsFors->student->id;
                            $arrayStudents[$accountStudents]['family'] = $studentsFors->student->parentsandguardian->family;
                            $arrayStudents[$accountStudents]['idFamily'] = $studentsFors->student->parentsandguardian->id;
                            
                            $accountStudents++;
                            $accountRecords++;
                            $accountChildren++;
                        }
                    }
                }
                if ($accountChildren > 3)
                {
                    $accountCuatroOmas++;
                    $arrayGeneral = $this->discount50($arrayStudents, $studentsDiscounts, $rowM->amount, $arrayDiscounts, $accountDiscounts, $arrayDiscarded, $accountDiscarded);
                    $arrayDiscounts = $arrayGeneral[0];
                    $accountDiscounts = $arrayGeneral[1];
                    $arrayDiscarded = $arrayGeneral[2];
                    $accountDiscarded = $arrayGeneral[3];
                }

                sort($arrayDiscounts);
                sort($arrayDiscarded);

                $this->set(compact('school', 'currentDate', 'arrayDiscounts', 'account', 'accountCuatroOmas', 'arrayDiscarded'));
                $this->set('_serialize', ['school', 'currentDate', 'arrayDiscounts', 'account', 'accountCuatroOmas', 'arrayDiscarded']);
            }
        }
    }
    
    public function discount50($arrayStudents = null, $studentsDiscounts = null, $amount = null, $arrayDiscounts = null, $accountDiscounts = null, $arrayDiscarded = null, $accountDiscarded = null)
    {        
        $fee50 = $amount * 0.5;

        arsort($arrayStudents);
        $accountHigher = 1;

        foreach ($arrayStudents as $arrayStudent)
        {
            if ($accountHigher == 1)
            {
                $swDiscounts = 0;
				$swUpdateStudent = 0;
                foreach ($studentsDiscounts as $studentsDiscount)
                {
                    if ($studentsDiscount->student_id == $arrayStudent['id'])
                    {
						if ($swDiscountStudent == 0)
						{
							$student = $this->Studenttransactions->Students->get($arrayStudent['id']);
				
							$student->discount = 50;
				
							if (!($this->Studenttransactions->Students->save($student)))
							{
								$this->Flash->error(__('No se pudo actualizar la columna discount en el registro Nro. ' . $arrayStudent['id']));
							}
							$swUpdateStudent = 1;
						}
                        if ($studentsDiscount->original_amount == $fee50)
                        {
                            $arrayDiscarded[$accountDiscarded]['reason'] = 'Descuento 50% aplicado anteriormente';
                            $arrayDiscarded[$accountDiscarded]['student'] = $arrayStudent['student'];
                            $arrayDiscarded[$accountDiscarded]['id'] =  $arrayStudent['id'];
                            $accountDiscarded++;
                        }
                        elseif ($studentsDiscount->original_amount == $amount)
                        {
                            if ($arrayStudent['scholarship'] == true)
                            {
                                $arrayDiscarded[$accountDiscarded]['reason'] = 'Alumno becado';
                                $arrayDiscarded[$accountDiscarded]['student'] = $arrayStudent['student'];
                                $arrayDiscarded[$accountDiscarded]['id'] =  $arrayStudent['id'];
                                $accountDiscarded++;
                            }
                            else
                            {
                                if ($studentsDiscount->paid_out == 0)
                                {
                                    $studenttransaction = $this->Studenttransactions->get($studentsDiscount->id);

                                    $subscriber = $studenttransaction->original_amount - $studenttransaction->amount;
                                    
                                    $studenttransaction->original_amount = $fee50;
                                    
                                    $studenttransaction->amount = $fee50 - $subscriber;
                                    
                                    if ($studenttransaction->amount == 0)
                                    {
                                        $studenttransaction->paid_out = 1;
                                    }
                                    else
                                    {
                                        $studenttransaction->paid_out = 0;
                                    }
                                    
                                    if (!($this->Studenttransactions->save($studenttransaction)))
                                    {
                                        $arrayDiscarded[$accountDiscarded]['reason'] = 'No se pudo hacer descuento en cuota ' . $studenttransaction->id;
                                        $arrayDiscarded[$accountDiscarded]['student'] = $arrayStudent['student'];
                                        $arrayDiscarded[$accountDiscarded]['id'] =  $arrayStudent['id'];
                                        $accountDiscarded++;
                                    }

                                    if ($swDiscounts == 0)
                                    {

                                        $arrayDiscounts[$accountDiscounts]['family'] = $arrayStudent['family'];
                                        $arrayDiscounts[$accountDiscounts]['discount'] = '50%';
                                        $arrayDiscounts[$accountDiscounts]['student'] = $arrayStudent['student'];
                                        $arrayDiscounts[$accountDiscounts]['grade'] = $arrayStudent['grade'];
                                        $arrayDiscounts[$accountDiscounts]['id'] = $arrayStudent['id'];
                                        $accountDiscounts++;
                                        $swDiscounts = 1;                                                            
                                    }
                                }
                                else
                                {
                                    $arrayDiscarded[$accountDiscarded]['reason'] = 'Mensualidad ya pagada';
                                    $arrayDiscarded[$accountDiscarded]['student'] = $arrayStudent['student'];
                                    $arrayDiscarded[$accountDiscarded]['id'] =  $arrayStudent['id'];
                                    $accountDiscarded++;
                                }
                            }
                        }
                        else
                        {
                            $arrayDiscarded[$accountDiscarded]['reason'] = 'El monto de la cuota no coincide';
                            $arrayDiscarded[$accountDiscarded]['student'] = $arrayStudent['student'];
                            $arrayDiscarded[$accountDiscarded]['id'] =  $arrayStudent['id'];
                            $accountDiscarded++;
                        }
                    }
                }
            }
            else
            {
                foreach ($studentsDiscounts as $studentsDiscount)
                {
                    if ($studentsDiscount->student_id == $arrayStudent['id'])
                    {
                        if ($studentsDiscount->original_amount != $amount)
                        {
                            $arrayDiscarded[$accountDiscarded]['reason'] = 'El monto de la cuota no coincide';
                            $arrayDiscarded[$accountDiscarded]['student'] = $arrayStudent['student'];
                            $arrayDiscarded[$accountDiscarded]['id'] =  $arrayStudent['id'];
                            $accountDiscarded++;
                        }
                    }
                }
            }
            $accountHigher++;
        }
        
        return [$arrayDiscounts, $accountDiscounts, $arrayDiscarded, $accountDiscarded];
    }

    public function discountFamily80()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $currentDate = time::now();

        $currentYear = $currentDate->year;
        
        $lastYear = $currentDate->year - 1;
        
        $nextYear = $currentDate->year + 1;
        
        $currentMonth = $currentDate->month;
        
        $currentYearMonth = $currentDate->year . $currentDate->month;

        if ($currentMonth > 8)
        {
            $startingYear = $currentYear;
            
            $finalYear = $nextYear;  
        }
        else
        {
            $startingYear = $lastYear;
            
            $finalYear = $currentYear;  
        }
        
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);

        $this->loadModel('Rates');
        
        $concept = 'Matrícula';
        
        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
           'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();

        if($row)
        {
            $registration = 'Matrícula ' . $startingYear;
            
            $studentTransactions = TableRegistry::get('Studenttransactions');

            $studentsFor = $studentTransactions->find()
                ->select(
                    ['Studenttransactions.id',
                    'Studenttransactions.transaction_type',
                    'Studenttransactions.transaction_description',
                    'Studenttransactions.amount',
                    'Students.id',
                    'Students.surname',
                    'Students.second_surname',
                    'Students.first_name',
                    'Students.second_name',
                    'Students.level_of_study',
                    'Students.scholarship',
                    'Parentsandguardians.id',
                    'Parentsandguardians.family'])
                ->contain(['Students' => ['Parentsandguardians']])
                ->where([['Studenttransactions.transaction_description' => $registration],
                    ['Studenttransactions.amount <' => $row->amount], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]])
                ->order(['Parentsandguardians.id' => 'ASC']);
                
            $account = $studentsFor->count();
            

            $idParent = 0;
            $accountRecords = 0;
            $accountChildren = 0;
            $accountTresHijos = 0;
            $arrayFamily80 = [];
            $accountFamily80 = 0;

            foreach ($studentsFor as $studentsFors)
            {
                if ($accountRecords == 0)
                {
                    $idParent = $studentsFors->student->parentsandguardian->id;
                    
                    $currentFamily = $studentsFors->student->parentsandguardian->family;
                    $currentFamilyId = $studentsFors->student->parentsandguardian->id;
                    $accountChildren++;
                    $accountRecords++;

                }
                else
                {
                    if ($idParent != $studentsFors->student->parentsandguardian->id)
                    {
                        if ($accountChildren == 3)
                        {
                            $arrayFamily80[$accountFamily80]['family'] = $currentFamily;
                            $arrayFamily80[$accountFamily80]['id'] = $currentFamilyId;
                            $accountFamily80++;
                            $accountTresHijos++;
                        }
                        $idParent = $studentsFors->student->parentsandguardian->id;
                        
                        $currentFamily = $studentsFors->student->parentsandguardian->family;
                        $currentFamilyId = $studentsFors->student->parentsandguardian->id;
                        
                        $accountChildren = 1;
                        $accountRecords++;

                    }
                    else
                    {
                        $accountChildren++;
                        $accountRecords++;
                    }
                }
            }
            if ($accountChildren == 3)
            {
                $arrayFamily80[$accountFamily80]['family'] = $currentFamily;
                $arrayFamily80[$accountFamily80]['id'] = $currentFamilyId;
                $accountFamily80++;
                $accountTresHijos++;
            }
            sort($arrayFamily80);

            $this->set(compact('school', 'currentDate', 'arrayFamily80', 'account', 'accountTresHijos'));
            $this->set('_serialize', ['school', 'currentDate', 'arrayFamily80', 'account', 'accountTresHijos']);
        }
    }

    public function discountFamily50()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $currentDate = time::now();

        $currentYear = $currentDate->year;
        
        $lastYear = $currentDate->year - 1;
        
        $nextYear = $currentDate->year + 1;
        
        $currentMonth = $currentDate->month;
        
        $currentYearMonth = $currentDate->year . $currentDate->month;

        if ($currentMonth > 8)
        {
            $startingYear = $currentYear;
            
            $finalYear = $nextYear;  
        }
        else
        {
            $startingYear = $lastYear;
            
            $finalYear = $currentYear;  
        }
        
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);

        $this->loadModel('Rates');
        
        $concept = 'Matrícula';
        
        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
           'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();

        if($row)
        {
            $registration = 'Matrícula ' . $startingYear;
            
            $studentTransactions = TableRegistry::get('Studenttransactions');

            $studentsFor = $studentTransactions->find()
                ->select(
                    ['Studenttransactions.id',
                    'Studenttransactions.transaction_type',
                    'Studenttransactions.transaction_description',
                    'Studenttransactions.amount',
                    'Students.id',
                    'Students.surname',
                    'Students.second_surname',
                    'Students.first_name',
                    'Students.second_name',
                    'Students.level_of_study',
                    'Students.scholarship',
                    'Parentsandguardians.id',
                    'Parentsandguardians.family'])
                ->contain(['Students' => ['Parentsandguardians']])
                ->where([['Studenttransactions.transaction_description' => $registration],
                    ['Studenttransactions.amount <' => $row->amount], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]])
                ->order(['Parentsandguardians.id' => 'ASC']);
                
            $account = $studentsFor->count();
            

            $idParent = 0;
            $accountRecords = 0;
            $accountChildren = 0;
            $accountCuatroOmas = 0;
            $arrayFamily50 = [];
            $accountFamily50 = 0;

            foreach ($studentsFor as $studentsFors)
            {
                if ($accountRecords == 0)
                {
                    $idParent = $studentsFors->student->parentsandguardian->id;
                    
                    $currentFamily = $studentsFors->student->parentsandguardian->family;
                    $currentFamilyId = $studentsFors->student->parentsandguardian->id;
                    $accountChildren++;
                    $accountRecords++;

                }
                else
                {
                    if ($idParent != $studentsFors->student->parentsandguardian->id)
                    {
                        if ($accountChildren > 3)
                        {
                            $arrayFamily50[$accountFamily50]['family'] = $currentFamily;
                            $arrayFamily50[$accountFamily50]['id'] = $currentFamilyId;
                            $accountFamily50++;
                            $accountCuatroOmas++;
                        }
                        $idParent = $studentsFors->student->parentsandguardian->id;
                        
                        $currentFamily = $studentsFors->student->parentsandguardian->family;
                        $currentFamilyId = $studentsFors->student->parentsandguardian->id;
                        
                        $accountChildren = 1;
                        $accountRecords++;

                    }
                    else
                    {
                        $accountChildren++;
                        $accountRecords++;
                    }
                }
            }
            if ($accountChildren > 3)
            {
                $arrayFamily50[$accountFamily50]['family'] = $currentFamily;
                $arrayFamily50[$accountFamily50]['id'] = $currentFamilyId;
                $accountFamily50++;
                $accountCuatroOmas++;
            }
            sort($arrayFamily50);

            $this->set(compact('school', 'currentDate', 'arrayFamily50', 'account', 'accountCuatroOmas'));
            $this->set('_serialize', ['school', 'currentDate', 'arrayFamily50', 'account', 'accountCuatroOmas']);
        }
    }


    public function orderLevel($level = null)
    {
        $levelOfStudy = ['',
                        'Pre-escolar, pre-kinder',                                
                        'Pre-escolar, kinder',
                        'Pre-escolar, preparatorio',
                        'Primaria, 1er. grado',
                        'Primaria, 2do. grado',
                        'Primaria, 3er. grado',
                        'Primaria, 4to. grado',
                        'Primaria, 5to. grado',
                        'Primaria, 6to. grado',
                        'Secundaria, 1er. año',
                        'Secundaria, 2do. año',
                        'Secundaria, 3er. año',
                        'Secundaria, 4to. año',
                        'Secundaria, 5to. año'];
        $position = [0,
                    1,
                    2,
                    3,
                    4,
                    5,
                    6,
                    7,
                    8,
                    9,
                    10,
                    11,
                    12,
                    13,
                    14];
        $order = str_replace($levelOfStudy, $position, $level);
        return $order;
    }
	public function verifyPayment($dateFrom = null, $dateException = null,  $idStudent = null)
	{
		$this->autoRender = false;
		
		$this->loadModel('Bills');
		
		$swAdjust = 0;
		
		$previousBill = 0;
		
		$verifyTransactions = $this->Studenttransactions->find('all', ['conditions' => [['student_id' => $idStudent], ['transaction_type' => 'Mensualidad'], 
			['payment_date >' => $dateFrom]], 'order' => ['Studenttransactions.student_id' => 'ASC', 'payment_date' => 'ASC']]);			

        foreach ($verifyTransactions as $verifyTransaction)
        {			               
            $month = substr($verifyTransaction->transaction_description, 0, 3);
                        
            if ($month != 'Ago')
			{
				if ($verifyTransaction->amount == 0)
				{
					if ($verifyTransaction->bill_number > $previousBill)
					{
						$previousBill = $verifyTransaction->bill_number;
						
						$lastRecord = $this->Bills->find('all', ['conditions' => ['bill_number' => $verifyTransaction->bill_number], 
							'order' => ['created' => 'DESC'] ]);

						$bill = $lastRecord->first();
        
						if ($bill->date_and_time > $dateException)
						{
							$swAdjust = 1;
							break;
						}
					}
				}
				else
				{
					$swAdjust = 1;
					break;
				}
			}	
		}
		return $swAdjust;
	}
    public function modifyTransactions()
    {
		$studentTransactions = $this->Studenttransactions->find('all', ['conditions' => [['transaction_type' => 'Mensualidad']]]);
	
		$account1 = $studentTransactions->count();
		
		$account2 = 0;
	
		foreach ($studentTransactions as $studentTransaction)
        {		
			$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
						
			$month = substr($studentTransactionGet->transaction_description, 0, 3);
				
			$year = substr($studentTransactionGet->transaction_description, 4, 4);
				
			$numberOfTheMonth = $this->numberMonth($month);
		
			$studentTransactionGet->payment_date = $year . '-' . $numberOfTheMonth . '-01'; 
			
			if ($this->Studenttransactions->save($studentTransactionGet))
			{
				$account2++;
			}
			else
			{
				$this->Flash->error(__('No pudo ser grabada la matrícula correspondiente al alumno cuyo ID es: ' . $studentTransactionGet->student_id));
			}
		}

		$this->Flash->success(__('Total registros seleccionados: ' . $account1));
		$this->Flash->success(__('Total registros actualizados: ' . $account2));
		
		return $this->redirect(['controller' => 'users', 'action' => 'wait']);

	}	
    public function newMonthlyDefaulters()
    {	
		if ($this->request->is('post')) 
        {		
			$monthFrom = $_POST['month_from'];

			$yearFrom = $_POST['year_from'];
		
			$monthUntil = $_POST['month_until'];
		
			$yearUntil = $_POST['year_until'];
		
			$previousMonthlyPayment = $_POST['previous_amount'];
			
			$newAmount = $_POST['new_amount'];
			
			$this->Flash->success(__('Cuota anterior: ' . number_format($previousMonthlyPayment, 2, ",", ".") . ' Nueva cuota: ' . number_format($newAmount, 2, ",", ".")));
			
			$this->Flash->success(__('Año mes desde: ' . $yearFrom . '-'. $monthFrom . ' Año mes hasta: ' . $yearUntil . '-'. $monthUntil));
		
			$excels = new ExcelsController();
			
			$previousMonthlyPayment80 = $previousMonthlyPayment * 0.8;
			
			$previousMonthlyPayment50 = $previousMonthlyPayment * 0.5;
			
			$newAmount80 = $newAmount * 0.8;
			
			$newAmount50 = $newAmount * 0.5;

			$yearMonthFrom = $yearFrom . $monthFrom;
			
			$dateFrom = new Time($yearFrom . '-' . $monthFrom . '-01 00:00:00');
			
			$dateUntil = new Time($yearUntil . '-' . $monthUntil . '-01 00:00:00');
			
			$arrayResult = [];	       
			$accountGeneral = 0;
			$accountDifferentAugust = 0;
			$accountAugust = 0;
			$accountAdjust = 0;
			$accountOutSequence = 0;
			$account20 = 0;
			$account50 = 0;
			$accountRegular = 0;
			$accountIrregular = 0;
			$swAdjust = 0;
			$previousIdStudent = 0;
			$swErrorTransactions = 0;
			$accountStudentAdjust = 0;
			$accountSave = 0;
			$swSave = 0;
			$sw20 = 0;
			$sw50 = 0;
			$swRegular = 0;
					
			$studentTransactions = $this->Studenttransactions->find('all', ['conditions' => [['transaction_type' => 'Mensualidad'], ['payment_date >=' => $dateFrom], ['payment_date <=' => $dateUntil]], 
				'order' => ['Studenttransactions.student_id' => 'ASC', 'payment_date' => 'ASC']]);
				
			$accountSelect = $studentTransactions->count();
			
			if ($studentTransactions) 
			{
				foreach ($studentTransactions as $studentTransaction)
				{			
					$accountGeneral++;
					
					$month = substr($studentTransaction->transaction_description, 0, 3);
							
					if ($month != 'Ago')
					{
						$accountDifferentAugust++;
						
						if ($accountDifferentAugust == 1)
						{
							$previousIdStudent = $studentTransaction->student_id;
						}
						
						if ($previousIdStudent != $studentTransaction->student_id)
						{
							if ($swAdjust == 1)
							{
								$student = $this->Studenttransactions->Students->get($previousIdStudent);
								
								$accountStudentAdjust++;
								
								$columns['report'] = 'Alumnos morosos cuota ajustada';
								$columns['number'] = $accountStudentAdjust;
								$columns['col1'] = $student->id;
								$columns['col2'] = $student->full_name;
								$columns['col3'] = $sw20;
								$columns['col4'] = $sw50;
								$columns['col5'] = $swRegular;
								$columns['col6'] = $previousMonthlyPayment;
								
								
								$swExcel = $excels->add($columns);

								if ($swExcel == 1)
								{
									$this->Flash->error(__('No pudo ser grabado en la tabla Excels el alumno: ' . $student->full_name));
								}
							}					
							$previousIdStudent = $studentTransaction->student_id;
							$swAdjust = 0;
							$sw20 = 0;
							$sw50 = 0;
							$swRegular = 0;
						}		
						
						$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
						
						if ($studentTransaction->original_amount == $previousMonthlyPayment80)
						{
							if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
							{
								$studentTransactionGet->original_amount = $newAmount80;
								$studentTransactionGet->amount = $newAmount80;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 0;
								$sw20 = 1;
								$account20++;
								$accountAdjust++;
								$swAdjust = 1;
								$swSave = 1;
							}
							elseif ($studentTransactionGet->amount > 0)
							{
								$differenceAmount = $newAmount80 - $studentTransactionGet->original_amount;
								$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
								$studentTransactionGet->original_amount = $newAmount80;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 1;
								$sw20 = 1;
								$account20++;
								$accountAdjust++;
								$swAdjust = 1;
								$swSave = 1;
							}
						}
						elseif ($studentTransaction->original_amount == $previousMonthlyPayment50)
						{
							if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
							{
								$studentTransactionGet->original_amount = $newAmount50;
								$studentTransactionGet->amount = $newAmount50;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 0;
								$sw50 = 1;
								$account50++;
								$accountAdjust++;
								$swAdjust = 1;
								$swSave = 1;
							}
							elseif ($studentTransactionGet->amount > 0)
							{
								$differenceAmount = $newAmount50 - $studentTransactionGet->original_amount;
								$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
								$studentTransactionGet->original_amount = $newAmount50;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 1;
								$sw50 = 1;
								$account50++;
								$accountAdjust++;
								$swAdjust = 1;
								$swSave = 1;
							}
						}
						elseif ($studentTransaction->original_amount == $previousMonthlyPayment)
						{    
							if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
							{
								$studentTransactionGet->original_amount = $newAmount;
								$studentTransactionGet->amount = $newAmount;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 0;
								$swRegular = 1;
								$accountRegular++;
								$accountAdjust++;
								$swAdjust = 1;
								$swSave = 1;
							}
							elseif ($studentTransactionGet->amount > 0)
							{
								$differenceAmount = $newAmount - $studentTransactionGet->original_amount;
								$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
								$studentTransactionGet->original_amount = $newAmount;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 1;
								$swRegular = 1;
								$accountRegular++;
								$accountAdjust++;
								$swAdjust = 1;
								$swSave = 1;
							}
						}
						else
						{
							$accountIrregular++;     
						}

						if ($swSave == 1)
						{
							if (!($this->Studenttransactions->save($studentTransactionGet)))
							{
								$swErrorTransactions = 1;
							} 
							$swSave = 0;
							$accountSave++;
						}
					}
					else
					{
						$accountAugust++;
					}
				}
				if ($swAdjust == 1)
				{
					$student = $this->Studenttransactions->Students->get($previousIdStudent);
					
					$accountStudentAdjust++;
					
					$columns['report'] = 'Alumnos morosos cuota ajustada';
					$columns['number'] = $accountStudentAdjust;
					$columns['col1'] = $student->full_name;
					$columns['col2'] = $sw20;
					$columns['col3'] = $sw50;
					$columns['col4'] = $swRegular;
					
					$swExcel = $excels->add($columns);

					if ($swExcel == 1)
					{
						$this->Flash->error(__('No pudo ser grabado en la tabla Excels el alumno: ' . $student->full_name));
					}
				}					

				if ($swErrorTransactions == 0)
				{
					$arrayResult['indicator'] = 0;
					$arrayResult['message'] = 'Se actualizaron las mensualidades correctamente';	
					$this->Flash->success(__('Se actualizaron las mensualidades correctamente'));
				}
				else
				{
					$arrayResult['indicator'] = 1;
					$arrayResult['message'] = 'Error al actualizar las mensualidades';		
					$this->Flash->error(__('Error al actualizar las mensualidades'));
				}
				$arrayResult['adjust'] = $accountAdjust;
				$this->Flash->success(__('Alumnos a los que se les ajustó las mensualidades: ' . $accountStudentAdjust));
				$this->Flash->success(__('Mensualidades ajustadas: ' . $accountAdjust));
				$this->Flash->success(__('Registros actualizados de Studenttransactions: ' . $accountSave));
				$this->Flash->success(__('Registros actualizados de Studenttransactions 20%: ' . $account20));
				$this->Flash->success(__('Registros actualizados de Studenttransactions 50%: ' . $account50));
				$this->Flash->success(__('Registros actualizados de Studenttransactions regulares: ' . $accountRegular));
			}
			else
			{
				$arrayResult['indicator'] = 1;
				$arrayResult['message'] = 'No se encontraron mensualidades';
				$arrayResult['adjust'] = 0;
				$this->Flash->error(__('No se encontraron mensualidades'));
			}
			return $this->redirect(['controller' => 'users', 'action' => 'wait']);
		}
	}
}