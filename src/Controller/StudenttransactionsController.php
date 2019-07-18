<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\ExcelsController;

use App\Controller\BinnaclesController;

use Cake\ORM\TableRegistry;

use Cake\I18n\Time;

class StudenttransactionsController extends AppController
{
    public function testFunction()
    {			
        $transaccionesEstudiantes = $this->Studenttransactions->find('all')
			->where(['transaction_type' => 'Servicio educativo', 'created >' => '2019-01-31 00:00:00']);
		
		$contador = $transaccionesEstudiantes->count();
				
		foreach($transaccionesEstudiantes as $transaccionesEstudiante)
		{
			$nuevoEstudiante = $this->Studenttransactions->Students->get($transaccionesEstudiante->student_id);

			$febrero2019 = $this->Studenttransactions->find('all')
				->where(['student_id' => $transaccionesEstudiante->student_id, 'transaction_description' => 'Feb 2019'])
				->order(['created' => "DESC"]);
			
			$row = $febrero2019->first();
				
			if ($row)
			{
				if ($row->paid_out == 1)
				{
					$this->Flash->error(__('2018 - ' . $transaccionesEstudiante->student_id . ' ' . $nuevoEstudiante->surname . " " . $nuevoEstudiante->first_name));
				}	
				else
				{
					$this->Flash->success(__('2019 - ' . $transaccionesEstudiante->student_id . ' ' . $nuevoEstudiante->surname . " " . $nuevoEstudiante->first_name));					

					$nuevoEstudiante->number_of_brothers = 2019;
					$nuevoEstudiante->balance = 2019;
					$nuevoEstudiante->new_student = 1;
					
					if (!($this->Studenttransactions->Students->save($nuevoEstudiante))) 
					{
						$this->Flash->error(__('Error actualizando - ' . $transaccionesEstudiante->student_id . ' ' . $nuevoEstudiante->surname . " " . $nuevoEstudiante->first_name));
					}
					else
					{
						$cuotas = $this->Studenttransactions->find('all')
							->where(['student_id' => $transaccionesEstudiante->student_id]);
						
						foreach ($cuotas as $cuota)
						{
							$transaccion = $this->Studenttransactions->get($cuota->id);
							
							if ($transaccion->transaction_type == "Matrícula")
							{
								$transaccion->transaction_description = "Matrícula 2019";
								$transaccion->amount_dollar = 40;
							}
							elseif ($transaccion->transaction_type == "Servicio educativo")
							{
								$transaccion->transaction_description = "Servicio educativo 2019";
								$transaccion->amount_dollar = 450;
							}
							elseif ($transaccion->transaction_type == "Mensualidad")
							{
								$mesTransaccion = substr($transaccion->transaction_description, 0, 4);
								$anoTransaccion = substr($transaccion->transaction_description, 4, 4);
								$nuevoAno = $anoTransaccion + 1;
								$mesAnoArreglado = $mesTransaccion . $nuevoAno;
							
								$transaccion->transaction_description = $mesAnoArreglado;
															
								$ano = $transaccion->payment_date->year;
								$anoMasUno = $ano + 1;
								
								$mes = $transaccion->payment_date->month;
																						
								if ($mes < 10)
								{
									$mesCadena = "0" . $mes;
								}
								else
								{
									$mesCadena = (string) $mes;
								}

								$nuevoPaymentDate = $anoMasUno . '-' . $mesCadena . '-01';
																
								$transaccion->payment_date = $nuevoPaymentDate;
							}
							if (!($this->Studenttransactions->save($transaccion))) 
							{ 
								$this->Flash->error(__('No se pudo modificar la cuota con ID ' . $cuota->id));
							}
						}
					}
				}
			}
		}
		$this->Flash->success(__('Total alumnos nuevos ' . $contador));
	}

    public function index()
    {
       if ($this->request->is('post'))
       {			
			$this->loadModel('Rates');
			
			$rate = $this->Rates->get(58);
			
			$dollarExchangeRate = $rate->amount; 
			
			$lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => 'Mensualidad'],
				'order' => ['Rates.created' => 'DESC'] ]);
				
			$row = $lastRecord->first();
				
			if ($row)
			{
				$amountMonthly = round($row->amount * $dollarExchangeRate);	
			}
			else
			{
				$amountMonthly = 0;
			}

            $studenttransactions = $this->Studenttransactions->find('all')
				->where(['student_id' => $_POST['idStudent']]);
									
            $student = $_POST['student'];

            $this->set(compact('studenttransactions', 'student', 'amountMonthly'));
            $this->set('_serialize', ['studenttransactions', 'student', 'amountMonthly']);
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

    public function edit($id = null, $billNumber = null, $originalAmount = null, $amountPayable = null, $tarifaDolar = null)
    {
        $studenttransaction = $this->Studenttransactions->get($id);
		
		$studenttransaction->original_amount = $originalAmount; 
		$studenttransaction->amount = $studenttransaction->amount + $amountPayable;
		$studenttransaction->amount_dollar = $tarifaDolar;
	
		if ($studenttransaction->amount == $studenttransaction->original_amount)
		{
			$studenttransaction->partial_payment = 0;
			$studenttransaction->paid_out = 1;
		} 
		else
		{
			$studenttransaction->partial_payment = 1;
		}
			
        $studenttransaction->bill_number = $billNumber;

        if (!($this->Studenttransactions->save($studenttransaction)))
        {
            $this->Flash->error(__('La transacción del alumno no pudo ser actualizada, vuelva a intentar.'));
        }

		if ($studenttransaction->transaction_type == 'Matrícula')
		{
			$year = substr($studenttransaction->transaction_description, 11, 4);
			
			$student = $this->Studenttransactions->Students->get($studenttransaction->student_id);

			if ($student->number_of_brothers == 0)
			{
				$student->number_of_brothers = $year;
			}
			
			$student->balance = $year;
			
			if (!($this->Studenttransactions->Students->save($student)))
			{
				$this->Flash->error(__('Los datos del alumno no pudieron ser actualizados, vuelva a intentar.'));
			}	
		}
        return;
    }

    public function reverseTransaction($id = null, $amount = null, $billNumber = null)
    {
        $studenttransaction = $this->Studenttransactions->get($id);
        
		$studenttransaction->amount = $studenttransaction->amount - $amount;
		
		$studenttransaction->paid_out = 0;
		
		if ($studenttransaction->amount == 0)
		{
			$studenttransaction->partial_payment = 0;
		} 
		else
		{
			$studenttransaction->partial_payment = 1;
		}
			
        if ($studenttransaction->bill_number == $billNumber)
        {
            $studenttransaction->bill_number = 0;
        }
        
        if (!($this->Studenttransactions->save($studenttransaction)))
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
		$indicadorError = 0;
		
		$this->loadModel('Schools');
		
		$school = $this->Schools->get(2);
			
		$quotaYear = $school->previous_year_registration;
		       
        $nextYear = $quotaYear + 1;
        
        $studenttransaction = $this->Studenttransactions->newEntity();
        
        $studenttransaction->student_id = $studentId;
        $studenttransaction->transaction_type = 'Matrícula';
        $studenttransaction->transaction_description = 'Matrícula' . ' ' . $quotaYear;
        $studenttransaction->amount = 0;
        $studenttransaction->original_amount = 0;
        $studenttransaction->invoiced = 0;
        $studenttransaction->paid_out = 0;
        $studenttransaction->partial_payment = 0;
        $studenttransaction->bill_number = 0;
        $studenttransaction->payment_date = 0;
        $studenttransaction->transaction_migration = 0;
		$studenttransaction->amount_dollar = 0;
        
        if (!($this->Studenttransactions->save($studenttransaction))) 
        {
			$indicadorError = 1;
		}
		
		if ($indicadorError == 0)
		{

		$studenttransaction = $this->Studenttransactions->newEntity();
		
		$studenttransaction->student_id = $studentId;
		$studenttransaction->amount = 0;
		$studenttransaction->original_amount = 0;
		$studenttransaction->invoiced = 0;
		$studenttransaction->paid_out = 0;
		$studenttransaction->partial_payment = 0;
		$studenttransaction->bill_number = 0;
		$studenttransaction->payment_date = 0;
		$studenttransaction->transaction_migration = 0;
		$studenttransaction->amount_dollar = 0;

            $studenttransaction->transaction_type = 'Seguro escolar';
            $studenttransaction->transaction_description = 'Seguro escolar' . ' ' . $quotaYear;

            if (!($this->Studenttransactions->save($studenttransaction)))
            {
                $indicadorError = 1;
            }
		}
		
		if ($quotaYear > 2018)
		{
			if ($indicadorError == 0)
			{
				$studenttransaction = $this->Studenttransactions->newEntity();
		
				$studenttransaction->student_id = $studentId;
				$studenttransaction->amount = 0;
				$studenttransaction->original_amount = 0;
				$studenttransaction->invoiced = 0;
				$studenttransaction->paid_out = 0;
				$studenttransaction->partial_payment = 0;
				$studenttransaction->bill_number = 0;
				$studenttransaction->payment_date = 0;
				$studenttransaction->transaction_migration = 0;
				$studenttransaction->amount_dollar = 0;

				$studenttransaction->transaction_type = 'Thales';
				$studenttransaction->transaction_description = 'Thales' . ' ' . $quotaYear;

				if (!($this->Studenttransactions->save($studenttransaction)))
				{
					$indicadorError = 1;
				}
			}
		}
			
		if ($indicadorError == 0)
        {				
			for ($i = 1; $i <= 12; $i++) 
			{
				$studenttransaction = $this->Studenttransactions->newEntity();
		
				$studenttransaction->student_id = $studentId;
				$studenttransaction->amount = 0;
				$studenttransaction->original_amount = 0;
				$studenttransaction->invoiced = 0;
				$studenttransaction->paid_out = 0;
				$studenttransaction->partial_payment = 0;
				$studenttransaction->bill_number = 0;
				$studenttransaction->transaction_migration = 0;
				$studenttransaction->amount_dollar = 0;                                    
				
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
								
				if (!($this->Studenttransactions->save($studenttransaction))) 
				{
					$indicadorError = 1;
					break;
				}
			}
             
        }
		
		return $indicadorError;
	}

    public function createQuotasRegular($studentId = null)
    {
		$indicadorError = 0;
		
		$this->loadModel('Schools');
		
		$school = $this->Schools->get(2);
			
		$quotaYear = $school->current_year_registration;
		        
        $nextYear = $quotaYear + 1;
        
        $studenttransaction = $this->Studenttransactions->newEntity();
        
        $studenttransaction->student_id = $studentId;
        $studenttransaction->transaction_type = 'Matrícula';
        $studenttransaction->transaction_description = 'Matrícula' . ' ' . $quotaYear;
        $studenttransaction->amount = 0;
        $studenttransaction->original_amount = 0;
        $studenttransaction->invoiced = 0;
        $studenttransaction->paid_out = 0;
        $studenttransaction->partial_payment = 0;
        $studenttransaction->bill_number = 0;
        $studenttransaction->payment_date = 0;
        $studenttransaction->transaction_migration = 0;
		$studenttransaction->amount_dollar = 0;
		
        if (!($this->Studenttransactions->save($studenttransaction))) 
        {
			$indicadorError = 1;
		}
		
		if ($indicadorError == 0)
		{
		$studenttransaction = $this->Studenttransactions->newEntity();
		
		$studenttransaction->student_id = $studentId;
		$studenttransaction->amount = 0;
		$studenttransaction->original_amount = 0;
		$studenttransaction->invoiced = 0;
		$studenttransaction->paid_out = 0;
		$studenttransaction->partial_payment = 0;
		$studenttransaction->bill_number = 0;
		$studenttransaction->payment_date = 0;
		$studenttransaction->transaction_migration = 0;
		$studenttransaction->amount_dollar = 0;

            $studenttransaction->transaction_type = 'Seguro escolar';
            $studenttransaction->transaction_description = 'Seguro escolar' . ' ' . $quotaYear;

            if (!($this->Studenttransactions->save($studenttransaction)))
            {
                $indicadorError = 1;
            }
		}

		if ($indicadorError == 0)
		{
		$studenttransaction = $this->Studenttransactions->newEntity();
		
		$studenttransaction->student_id = $studentId;
		$studenttransaction->amount = 0;
		$studenttransaction->original_amount = 0;
		$studenttransaction->invoiced = 0;
		$studenttransaction->paid_out = 0;
		$studenttransaction->partial_payment = 0;
		$studenttransaction->bill_number = 0;
		$studenttransaction->payment_date = 0;
		$studenttransaction->transaction_migration = 0;
			$studenttransaction->amount_dollar = 0;

            $studenttransaction->transaction_type = 'Thales';
            $studenttransaction->transaction_description = 'Thales' . ' ' . $quotaYear;

            if (!($this->Studenttransactions->save($studenttransaction)))
            {
                $indicadorError = 1;
            }
		}

		if ($indicadorError == 0)
		{				
			for ($i = 1; $i <= 12; $i++) 
			{    
			$studenttransaction = $this->Studenttransactions->newEntity();
	
			$studenttransaction->student_id = $studentId;
			$studenttransaction->amount = 0;
			$studenttransaction->original_amount = 0;
			$studenttransaction->invoiced = 0;
			$studenttransaction->paid_out = 0;
			$studenttransaction->partial_payment = 0;
			$studenttransaction->bill_number = 0;
			$studenttransaction->transaction_migration = 0;
				$studenttransaction->amount_dollar = 0;
           
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
				
				if (!($this->Studenttransactions->save($studenttransaction))) 
				{
					$indicadorError = 1;
					break;
				}
			}
            
        }

		return $indicadorError;
    }

    public function createQuotasNew($studentId = null, $startYear = null)
    {
		$indicadorError = 0;
		
        $quotaYear = $startYear;
        
        $nextYear = $quotaYear + 1;
        
        $studenttransaction = $this->Studenttransactions->newEntity();
        
        $studenttransaction->student_id = $studentId;
        
        $studenttransaction->transaction_type = 'Matrícula';
        $studenttransaction->transaction_description = 'Matrícula' . ' ' . $quotaYear;
        $studenttransaction->amount = 0;
        $studenttransaction->original_amount = 0;
        $studenttransaction->invoiced = 0;
        $studenttransaction->paid_out = 0;
        $studenttransaction->partial_payment = 0;
        $studenttransaction->bill_number = 0;
        $studenttransaction->payment_date = 0;
        $studenttransaction->transaction_migration = 0;
		$studenttransaction->amount_dollar = 0;
        
        if (!($this->Studenttransactions->save($studenttransaction))) 
        {
			$indicadorError = 1;
		}

		if ($indicadorError == 0)
		{

		$studenttransaction = $this->Studenttransactions->newEntity();
		
		$studenttransaction->student_id = $studentId;	
		$studenttransaction->amount = 0;
		$studenttransaction->original_amount = 0;
		$studenttransaction->invoiced = 0;
		$studenttransaction->paid_out = 0;
		$studenttransaction->partial_payment = 0;
		$studenttransaction->bill_number = 0;
		$studenttransaction->payment_date = 0;
		$studenttransaction->transaction_migration = 0;
		$studenttransaction->amount_dollar = 0;
               
            $studenttransaction->transaction_type = 'Servicio educativo';
            $studenttransaction->transaction_description = 'Servicio educativo' . ' ' . $quotaYear;

            if (!($this->Studenttransactions->save($studenttransaction)))
            {
                $indicadorError = 1;
            }
		}
		
		if ($indicadorError == 0)
		{

            for ($i = 1; $i <= 12; $i++) 
            {                
		$studenttransaction = $this->Studenttransactions->newEntity();
		
		$studenttransaction->student_id = $studentId;	
		$studenttransaction->amount = 0;
		$studenttransaction->original_amount = 0;
		$studenttransaction->invoiced = 0;
		$studenttransaction->paid_out = 0;
		$studenttransaction->partial_payment = 0;
		$studenttransaction->bill_number = 0;
		$studenttransaction->transaction_migration = 0;
		$studenttransaction->amount_dollar = 0;


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
					
                if (!($this->Studenttransactions->save($studenttransaction))) 
                {
                    $indicadorError = 1;
                    break;
                }
            }
		}
		
		return $indicadorError;
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
    public function differenceAugust($newAmount = null, $yearDifference = null, $noDifference = null)
    {
		$this->autoRender = false;
		
		$binnacles = new BinnaclesController;

		$binnacles->add('controller', 'Studenttransactions', 'differenceAugust', '$newAmount: ' . $newAmount . ' $yearDifference: ' . $yearDifference . ' $noDifference: ' . $noDifference );
		
		$accountRecords = 0;
		
		$swUpdate = 0;
					
		$swError = 0;
						
		$arrayResult = [];	
		$arrayResult['indicator'] = 0;
		$arrayResult['message'] = '';
		$arrayResult['adjust'] = 0;
		
		$arrayResult = $this->resetStudents();

		if ($arrayResult['indicator'] == 0)
		{
			$studentTransactions = $this->Studenttransactions->find('all', ['conditions' => ['transaction_description' => "Ago " . $yearDifference]]);
							
			if ($studentTransactions)
			{			
				foreach ($studentTransactions as $studentTransaction)
				{
					$swUpdate = 0;
					$arrayResult = [];	
					$arrayResult['indicator'] = 0;
					$arrayResult['message'] = '';
										
					if ($noDifference == 0)
					{
						$swUpdate = 1;
						$arrayResult = $this->updateTransaction($studentTransaction, $newAmount);
					}	
					elseif ($studentTransaction->paid_out == 0)
					{
						$swUpdate = 1;
						$arrayResult = $this->updateTransaction($studentTransaction, $newAmount);						
					}
										
					if ($arrayResult['indicator'] == 0)
					{
						if ($swUpdate == 1)
						{
							$accountRecords++;
						}
					}
					else
					{
						$swError = 1;
						break;
					}
				}
			}
			else
			{
				$binnacles->add('controller', 'Studenttransactions', 'differenceAugust', 'No se encontraron transacciones de agosto ' . $yearDifference);
				$swError = 1;					
			}
			
			$arrayResult['indicator'] = $swError;
			
			if ($swError == 0)
			{
				$binnacles->add('controller', 'Studenttransactions', 'differenceAugust', 'Registros actualizados: ' . $accountRecords);
				$arrayResult['message'] = 'Se actualizó exitosamente la diferencia de agosto';
				$arrayResult['adjust'] = $accountRecords; 
			}
			else
			{
				$binnacles->add('controller', 'Studenttransactions', 'differenceAugust', 'Programa con error, solo se actualizaron ' . $accountRecords . ' transacciones');
				$arrayResult['message'] = 'No se actualizó exitosamente la diferencia de agosto';
				$arrayResult['adjust'] = $accountRecords;
			}
		}
		else
		{
			$arrayResult['adjust'] = 0;
		}
			
		return $arrayResult;
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
				
				if ($studenttransaction->original_amount != $transaction->originalAmount)
                {
					$studenttransaction->original_amount = $transaction->originalAmount;

					if ($studenttransaction->amount > $studenttransaction->original_amount)
					{
						$this->Flash->error(__('Error: El monto de la cuota no puede ser menor al monto abonado: ' . $studenttransaction->transaction_description . ' Cuota: ' . $studenttransaction->original_amount . ' Abonado: ' . $studenttransaction->amount));
						
						$transactionIndicator = 1;                     
					}
					else
					{
						if ($studenttransaction->amount == $studenttransaction->original_amount)
						{
							$studenttransaction->paid_out = 1;
							$studenttransaction->partial_payment = 0;                            
						}
						elseif ($studenttransaction->amount == 0)
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
            }

            if ($transactionIndicator == 0)
            {
                $this->Flash->success(__('Las cuotas fueron actualizadas correctamente'));
                
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
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
		
		$excels = new ExcelsController();
		
		$binnacles = new BinnaclesController;
			
		$swError = 0;
						
		$arrayResult = [];
		$arrayResult['indicator'] = 0;
		$arrayResult['adjust'] = 0;

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
		$accountDateFrom = 0;
		$accountAmountCero = 0;
		$accountStudentChange = 0;
		$accountSelect = 0;
		$adjustDefaulters = 0;
		
		if ($defaulters == 1)
		{
			$swError = $this->discountStudents($monthFrom, $yearFrom, $previousMonthlyPayment);
			if ($swError == 0)
			{
				$arrayResult = $this->adjustDefaulters($monthFrom, $yearFrom, $newAmount); 
			}
		}
		
		if ($arrayResult['indicator'] == 0)
		{	
			$adjustDefaulters = $arrayResult['adjust'];
			
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
							if ($studentTransaction->payment_date->year == $dateFrom->year && $studentTransaction->payment_date->month == $dateFrom->month)
							{			
								$accountDateFrom++;
								
								if ($studentTransaction->amount == 0)
								{
									$accountAmountCero++;
									
									if ($previousIdStudent != $studentTransaction->student_id)
									{
										$accountStudentChange++;
										
										$previousIdStudent = $studentTransaction->student_id;
									
										$swAdjust = $this->verifyPayment($dateFrom, $dateException, $studentTransaction->student_id);
																		
										if ($swAdjust == 0)
										{
											if ($accountPaymentException == 0)
											{
												$columns = [];
												$columns['report'] = 'Alumnos pago completo año escolar';
												$columns['start_end'] = 'start';
											
												$swError = $excels->add($columns);	
												if ($swError > 0)
												{
													$arrayResult['indicator'] = 1;
													$arrayResult['message'] = 'No se pudo inicializar la tabla excel con el reporte de Alumnos pago completo año escolar';
													break;
												}
											}											
											$accountPaymentException++;
											
											$student = $this->Studenttransactions->Students->get($studentTransaction->student_id);

											$columns = [];
											$columns['report'] = 'Alumnos pago completo año escolar';
											$columns['number'] = $accountPaymentException;
											$columns['col1'] = $student->id;
											$columns['col2'] = $student->full_name;
											
											$swError = $excels->add($columns);
											
											if ($swError > 0)
											{
												$arrayResult['indicator'] = 1;
												$arrayResult['message'] = 'No se pudo grabar en la tabla excel el alumno pago completo año escolar id ' . student_id;
												break;
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
								$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', 'No se pudo grabar la transacción con el id ' . $studentTransactionGet->id);
								$swError = 1;
								break;
							} 
						}  
					}
					else
					{
						$accountAugust++;
					}
				}
				if ($swError == 0)
				{
					if ($swDateException == 1 && $accountAdjust > 0)
					{
						$columns = [];
						$columns['report'] = 'Alumnos pago completo año escolar';
						$columns['start_end'] = 'end';
					
						$swError = $excels->add($columns);	
						if ($swError == 0)
						{
							$arrayResult['indicator'] = 0;
							$arrayResult['message'] = 'Se actualizaron las mensualidades correctamente';							
						}
						else
						{
							$arrayResult['indicator'] = 1;
							$arrayResult['message'] = 'No se pudo finalizar la tabla excel con el reporte de alumnos pago completo año escolar';
						}						
					}
					else
					{
						$arrayResult['indicator'] = 0;
						$arrayResult['message'] = 'Se actualizaron las mensualidades correctamente';
					}
				}
				else
				{
					$arrayResult['indicator'] = 1;
					$arrayResult['message'] = 'Error al actualizar las mensualidades';				
				}
				
			}
			else
			{
				$arrayResult['indicator'] = 1;
				$arrayResult['message'] = 'No se encontraron mensualidades';
			}
		}
		else
		{ 
			$arrayResult['indicator'] = 1;
			$arrayResult['message'] = 'No se pudieron actualizar las mensualidades de alumnos morosos';		
		}
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$yearFrom: ' . $yearFrom);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$monthFrom: ' . $monthFrom);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$dateFrom->year: ' . $dateFrom->year);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$dateFrom->month: ' . $dateFrom->month);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$dateFrom: ' . $dateFrom);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountSelect: ' . $accountSelect);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountDifferentAugust: ' . $accountDifferentAugust);	
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountAugust: ' . $accountAugust);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountDateFrom: ' . $accountDateFrom);	
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountAmountCero: ' . $accountAmountCero);		
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountOutSequence: ' . $accountOutSequence);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountAdjust: ' . $accountAdjust);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountPaymentException: ' . $accountPaymentException);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$dateException: ' . $dateException);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$adjustDefaulters: ' . $adjustDefaulters);		
		
		$arrayResult['adjust'] = $accountAdjust;
		$arrayResult['notAdjust'] = $accountPaymentException; 	
		$arrayResult['adjustDefaulters'] = $adjustDefaulters;		
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
		/* Antes de iniciar el proceso de renovación de matrícula 2019-2020 se debe crear
		en Students el campo "regular_renewal_year" y comparar contra "current_year_registration"
		si son iguales dar acceso a asignar secciones, de lo contrario enviar mensaje que se debe ejecutar al
		inicio del año escolar */
		
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
					/*
                    if (!($this->Studenttransactions->Students->save($student)))
                    {
                        $result = 1;
                        
                        $this->Flash->error(__('No pudo ser actualizado el alumno identificado con el id: ' . $valor['id']));            
                    }
					*/
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
            
			$this->loadModel('Schools');

			$school = $this->Schools->get(2);
			
			$currentYearRegistration = $school->current_year_registration;
						
			$transactionDescription = 'Matrícula ' . $currentYearRegistration;
			
			$inscribed = $studentTransactions->find()
				->select(
					['Studenttransactions.id',
					'Students.level_of_study'])
				->contain(['Students'])
				->where([['Studenttransactions.transaction_description' => $transactionDescription],
					['Studenttransactions.amount >' => 0],
					['Students.level_of_study !=' => ""], 
					['Students.student_condition' => 'Regular']]);
	
			$totalEnrolled = $inscribed->count();
						
			$studentsLevel = $studentTransactions->find()
				->select(
					['Studenttransactions.id',
					'Studenttransactions.transaction_description',
					'Studenttransactions.amount',
					'Studenttransactions.original_amount',
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
				->where([['Studenttransactions.transaction_description' => $transactionDescription],
					['Studenttransactions.amount >' => 0],
					['Students.level_of_study' => $level],
					['Students.student_condition' => 'Regular']])
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
					/*
					if ($swSection == 0)
					{
						$student = $this->Studenttransactions->Students->get($studentsLevels->student->id);

						$student->section_id = $idSectionA;        

						if (!($this->Studenttransactions->Students->save($student)))
						{                       
							$this->Flash->error(__('No pudo ser actualizado el alumno identificado con el id: ' . $student->id));            
						}
					}
					*/
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
		
			$this->set(compact('level', 'studentsLevel', 'totalEnrolled', 'totalLevel', 'sectionA', 'sectionB', 'sectionC', 'levelChat', 'assign'));
			$this->set('_serialize', ['level', 'studentsLevel', 'totalEnrolled', 'totalLevel', 'sectionA', 'sectionB', 'sectionC', 'levelChat', 'assign']);
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

		$currentYearRegistration = $school->current_year_registration;
					
		$transactionDescription = 'Matrícula ' . $currentYearRegistration;

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
			->where([['Studenttransactions.transaction_description' => $transactionDescription],
				['Studenttransactions.amount < Studenttransactions.original_amount'],
				['Students.level_of_study' => $level],
				['Students.student_condition' => 'Regular']])
			->order(['Sections.section' => 'ASC', 'Students.surname' => 'ASC', 'Students.second_name' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);

		$account = $studentsFor->count();
		
		$totalPages = ceil($studentsFor->count() / 30) + 2;
		
		$levelChatScript = $this->replaceChatScript($level);

		$this->set(compact('school', 'studentsFor', 'level', 'totalPages', 'levelChatScript'));
		$this->set('_serialize', ['school', 'studentsFor', 'level', 'totalPages', 'levelChatScript']);
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
		
		$concept = 'Matrícula ' . $school->current_year_registration;

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
			->where([['Studenttransactions.transaction_description' => $concept],
				['Studenttransactions.amount < Studenttransactions.original_amount'], ['Students.student_condition' => 'Regular']])
			->order(['Students.surname' => 'ASC', 'Students.second_name' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);

            $account = $studentsFor->count();
            
            $totalPages = ceil($studentsFor->count() / 20);

            setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
            date_default_timezone_set('America/Caracas');

            $currentDate = Time::now();

            $this->set(compact('school', 'studentsFor', 'totalPages', 'currentDate'));
            $this->set('_serialize', ['school', 'studentsFor', 'totalPages', 'currentDate']);

    }
    
    public function reportFamilyStudents()
    {
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);
			
		$currentYearRegistration = $school->current_year_registration;
					
		$transactionDescription = 'Matrícula ' . $currentYearRegistration;
		
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
			->where([['Studenttransactions.transaction_description' => $transactionDescription],
				['Studenttransactions.amount < Studenttransactions.original_amount'], ['Students.student_condition' => 'Regular']])
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

    public function discountQuota20()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $currentDate = time::now();

		$idParent = 0;
        $accountRecords = 0;
        $accountChildren = 0;
        $arrayStudents = [];
		$discountUpdate20 = 0;
		$accountStudents = 0;
		
        $this->loadModel('Schools');
		
		$this->loadModel('Sections');

        $school = $this->Schools->get(2);

        $currentYear = $school->current_school_year;
        
        $lastYear = $currentYear - 1;
        
        $nextYear = $currentYear + 1;
        
        $startingYear = $currentYear;
            
        $finalYear = $nextYear;  

		$students20 = $this->Studenttransactions->Students->find('all', ['conditions' => ['Students.discount' => 20]]);
		
        if ($students20)
		{
			foreach ($students20 as $students20s)
			{
				$student = $this->Studenttransactions->Students->get($students20s->id);
				
				$student->discount = 0;
				
				if (!($this->Studenttransactions->Students->save($student)))
				{
					$this->Flash->error(__('No se pudo inicializar la columna discount en el registro Nro. ' . $student20s->id));
				}
            }
		}
		
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
				'Students.section_id',
				'Students.level_of_study',
				'Students.scholarship',
				'Parentsandguardians.id',
				'Parentsandguardians.family'])
			->contain(['Students' => ['Parentsandguardians']])
			->where([['Studenttransactions.transaction_description' => $registration],
				['Studenttransactions.amount >' => 0], ['Students.student_condition' => 'Regular']])
			->order(['Parentsandguardians.id' => 'ASC']);
			
		$account = $studentsFor->count();
				
		foreach ($studentsFor as $studentsFors)
		{
			if ($accountRecords == 0)
			{
				$idParent = $studentsFors->student->parentsandguardian->id;
			}
			
			if ($idParent != $studentsFors->student->parentsandguardian->id)
			{
				if ($accountChildren == 3)
				{
					$this->discount20($arrayStudents);
					$discountUpdate20++;
				}
				$accountStudents = 0;
				$accountChildren = 0;
				$arrayStudents = [];

				$idParent = $studentsFors->student->parentsandguardian->id;
			}
			
			if ($school->current_school_year < $school->current_year_registration)
			{
				if ($studentsFors->student->section_id === null)
				{
					$this->Flash->success(__('Id Alumno ' . $studentsFors->student->id . ' section_id ' . $studentsFors->student->section_id));
					$level = "No asignado";
				}
				else
				{
					$seccion = $this->Sections->get($studentsFors->student->section_id);
					$level = $seccion->sublevel;
				}
				$order = $this->gradoPosicion($level);
			}
			else
			{
				$level = $studentsFors->student->level_of_study;
				$order = $this->orderLevel($level);	
			}
													
			$arrayStudents[$accountStudents]['order'] = $order;
			$arrayStudents[$accountStudents]['id'] = $studentsFors->student->id;

			$accountStudents++;
			$accountRecords++;
			$accountChildren++;	
		}			

		if ($accountChildren == 3)
		{
			$this->discount20($arrayStudents);
			$discountUpdate20++;
		}
				
		$this->Flash->success(__('Total alumnos a los que se les aplicó el descuento del 20%: ' . $discountUpdate20));
    }
    
    public function discount20($arrayStudents)
    {
        arsort($arrayStudents);

        foreach ($arrayStudents as $arrayStudent)
        {
			$student = $this->Studenttransactions->Students->get($arrayStudent['id']);
				
			$student->discount = 20;

			if (!($this->Studenttransactions->Students->save($student)))
			{
				$this->Flash->error(__('No se pudo actualizar la columna discount en el registro Nro. ' . $arrayStudent['id']));
			}
			break;
		}
    }

    public function discountQuota50()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $currentDate = time::now();

		$idParent = 0;
        $accountRecords = 0;
        $accountChildren = 0;
        $arrayStudents = [];
		$discountUpdate50 = 0;
		$accountStudents = 0;
		
        $this->loadModel('Schools');
		
		$this->loadModel('Sections');

        $school = $this->Schools->get(2);

        $currentYear = $school->current_school_year;
        
        $lastYear = $currentYear - 1;
        
        $nextYear = $currentYear + 1;
        
        $startingYear = $currentYear;
            
        $finalYear = $nextYear;  

		$students50 = $this->Studenttransactions->Students->find('all', ['conditions' => ['Students.discount' => 50]]);
		
        if ($students50)
		{
			foreach ($students50 as $students50s)
			{
				$student = $this->Studenttransactions->Students->get($students50s->id);
				
				$student->discount = 0;
				
				if (!($this->Studenttransactions->Students->save($student)))
				{
					$this->Flash->error(__('No se pudo inicializar la columna discount en el registro Nro. ' . $student50s->id));
				}
            }
		}
		
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
				'Students.section_id',
				'Students.level_of_study',
				'Students.scholarship',
				'Parentsandguardians.id',
				'Parentsandguardians.family'])
			->contain(['Students' => ['Parentsandguardians']])
			->where([['Studenttransactions.transaction_description' => $registration],
				['Studenttransactions.amount >' => 0], ['Students.student_condition' => 'Regular']])
			->order(['Parentsandguardians.id' => 'ASC']);
			
		$account = $studentsFor->count();
				
		foreach ($studentsFor as $studentsFors)
		{
			if ($accountRecords == 0)
			{
				$idParent = $studentsFors->student->parentsandguardian->id;
			}
			
			if ($idParent != $studentsFors->student->parentsandguardian->id)
			{
				if ($accountChildren > 3)
				{
					$this->discount50($arrayStudents);
					$discountUpdate50++;
				}
				$accountStudents = 0;
				$accountChildren = 0;
				$arrayStudents = [];

				$idParent = $studentsFors->student->parentsandguardian->id;
			}
			
			if ($school->current_school_year < $school->current_year_registration)
			{
				if ($studentsFors->student->section_id === null)
				{
					$this->Flash->success(__('Id Alumno ' . $studentsFors->student->id . ' section_id ' . $studentsFors->student->section_id));
					$level = "No asignado";
				}
				else
				{
					$seccion = $this->Sections->get($studentsFors->student->section_id);
					$level = $seccion->sublevel;
				}
				$order = $this->gradoPosicion($level);
			}
			else
			{
				$level = $studentsFors->student->level_of_study;
				$order = $this->orderLevel($level);	
			}
													
			$arrayStudents[$accountStudents]['order'] =  $order;
			$arrayStudents[$accountStudents]['id'] = $studentsFors->student->id;

			$accountStudents++;
			$accountRecords++;
			$accountChildren++;	
		}			

		if ($accountChildren > 3)
		{
			$this->discount50($arrayStudents);
			$discountUpdate50++;
		}
				
		$this->Flash->success(__('Total alumnos a los que se les aplicó el descuento del 50%: ' . $discountUpdate50));
    }
    
    public function discount50($arrayStudents)
    {
        arsort($arrayStudents);

        foreach ($arrayStudents as $arrayStudent)
        {
			$student = $this->Studenttransactions->Students->get($arrayStudent['id']);
				
			$student->discount = 50;

			if (!($this->Studenttransactions->Students->save($student)))
			{
				$this->Flash->error(__('No se pudo actualizar la columna discount en el registro Nro. ' . $arrayStudent['id']));
			}
			break;
		}
    }
	
    public function discountFamily80()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $currentDate = time::now();
	
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);
		
        $currentYear = $school->current_year_registration;
               
		$registration = 'Matrícula ' . $currentYear;
		
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
				['Studenttransactions.amount >' => 0], ['Students.student_condition' => 'Regular']])
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

    public function discountFamily50()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $currentDate = time::now();

        $this->loadModel('Schools');

        $school = $this->Schools->get(2);
		
        $currentYear = $school->current_year_registration;

		$registration = 'Matrícula ' . $currentYear;
		
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
				['Studenttransactions.amount >' => 0], ['Students.student_condition' => 'Regular']])
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
	
    public function gradoPosicion($level = null)
    {
        $levelOfStudy = ['No asignado',
                        'Pre-kinder',                                
                        'Kinder',
                        'Preparatorio',
                        '1er. Grado',
                        '2do. Grado',
                        '3er. Grado',
                        '4to. Grado',
                        '5to. Grado',
                        '6to. Grado',
                        '1er. Año',
                        '2do. Año',
                        '3er. Año',
                        '4to. Año',
                        '5to. Año'];
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
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
		
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
		$studentTransactions = $this->Studenttransactions->find('all', ['conditions' => [['transaction_description' => 'Matrícula 2018']]]);
	
		$account1 = $studentTransactions->count();
		
		$account2 = 0;
	
		foreach ($studentTransactions as $studentTransaction)
        {		
			if ($studentTransaction->amount > 0)
			{
				$student = $this->Studenttransactions->Students->get($studentTransaction->student_id);
				$student->balance = substr($studentTransaction->transaction_description, 11, 4);
				if ($this->Studenttransactions->Students->save($student))
				{
					$account2++;
				}
				else
				{
					$this->Flash->error(__('No pudo ser grabada la matrícula correspondiente al alumno cuyo ID es: ' . $studentTransactionGet->student_id));
				}
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
						
						if ($accountDifferentAugust == 0)
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
    public function adjustDefaulters($monthUntil = null, $yearUntil = null, $newAmount = null)
    {
		$this->autoRender = false;
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
		
		$binnacles = new BinnaclesController;	

		$excels = new ExcelsController();
		
		$swError = 0;
		
		$arrayResult = [];
		
		$dateUntil = new Time($yearUntil . '-' . $monthUntil . '-01 00:00:00');		
								
		$newAmount80 = $newAmount * 0.8;
		
		$newAmount50 = $newAmount * 0.5;
	
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
		$accountStudentAdjust = 0;
		$accountSave = 0;
		$swSave = 0;
				
		$studentTransactions = $this->Studenttransactions->find('all', 
			['contain' => ['Students'],
			'conditions' => [['Students.student_condition' => 'Regular'], ['Students.section_id >' => 1], ['Studenttransactions.transaction_type' => 'Mensualidad'], ['Studenttransactions.payment_date <' => $dateUntil], ['Studenttransactions.paid_out' => 0]], 
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
					if ($accountDifferentAugust == 0)
					{
						$student = $this->Studenttransactions->Students->get($studentTransaction->student_id);
						
						$previousIdStudent = $studentTransaction->student_id;
					}
					
					$accountDifferentAugust++;
					
					if ($previousIdStudent != $studentTransaction->student_id)
					{
						if ($swAdjust == 1)
						{
							if ($accountStudentAdjust == 0)
							{
								$columns = [];
								$columns['report'] = 'Alumnos morosos cuota ajustada';
								$columns['start_end'] = 'start';
								
								$swError = $excels->add($columns);								
							}
							
							if ($swError == 0)
							{
								$accountStudentAdjust++;
								
								$columns = [];
								$columns['report'] = 'Alumnos morosos cuota ajustada';
								$columns['number'] = $accountStudentAdjust;
								$columns['col1'] = $student->id;
								$columns['col2'] = $student->full_name;
								$columns['col3'] = $student->discount;
							
								$swError = $excels->add($columns);

								if ($swError > 0)		
								{
									break;
								}
							}
							else
							{
								break;
							}
						}					
						$previousIdStudent = $studentTransaction->student_id;
						$student = $this->Studenttransactions->Students->get($studentTransaction->student_id);
						$swAdjust = 0;
					}		
					
					$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
										
					if ($student->discount == 20)
					{
						if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
						{
							$studentTransactionGet->original_amount = $newAmount80;
							$studentTransactionGet->amount = $newAmount80;
							$studentTransactionGet->paid_out = 0;
							$studentTransactionGet->partial_payment = 0;
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
							$account20++;
							$accountAdjust++;
							$swAdjust = 1;
							$swSave = 1;
						}
					}
					elseif ($student->discount == 50)
					{
						if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
						{
							$studentTransactionGet->original_amount = $newAmount50;
							$studentTransactionGet->amount = $newAmount50;
							$studentTransactionGet->paid_out = 0;
							$studentTransactionGet->partial_payment = 0;
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
							$account50++;
							$accountAdjust++;
							$swAdjust = 1;
							$swSave = 1;
						}
					} 
					elseif ($student->discount == null)
					{    
						if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
						{
							$studentTransactionGet->original_amount = $newAmount;
							$studentTransactionGet->amount = $newAmount;
							$studentTransactionGet->paid_out = 0;
							$studentTransactionGet->partial_payment = 0;
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
						if ($this->Studenttransactions->save($studentTransactionGet))
						{ 
							$accountSave++;	
						}	
						else
						{
							$binnacles->add('controller', 'Studenttransactions', 'adjustDefaulters', 'No se pudo actualizar la mensualidad con id: ' . $studentTransactionGet->id);
							$swError = 1;
							break;
						}
						$swSave = 0;
					}
				}
				else
				{
					$accountAugust++;
				}
			}
			if ($swError == 0)
			{
				if ($swAdjust == 1)
				{				
					$accountStudentAdjust++;
					
					$columns = [];
					$columns['report'] = 'Alumnos morosos cuota ajustada';
					$columns['number'] = $accountStudentAdjust;
					$columns['col1'] = $student->id;
					$columns['col2'] = $student->full_name;
					$columns['col3'] = $student->discount;
					
					$swError = $excels->add($columns);
				}
				if ($swError == 0 && $accountStudentAdjust > 0)
				{
					$columns = [];
					$columns['report'] = 'Alumnos morosos cuota ajustada';
					$columns['start_end'] = 'end';
				
					$swError = $excels->add($columns);
				}
			}
		}
		else
		{
			$binnacles->add('controller', 'Studenttransactions', 'adjustDefaulters', 'No se encontraron alumnos con mensualidades morosas');
			$swError = 1;
		}
		$arrayResult['indicator'] = $swError;
		$arrayResult['adjust'] = $accountStudentAdjust;
		return $arrayResult;
	}

	public function discountStudents($monthFrom = null, $yearFrom = null, $monthlyPayment = null)
	{
		$this->autoRender = false;
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');		
		
		$excels = new ExcelsController();
			
		$binnacles = new BinnaclesController;
		
		$swError = 0;
							
		$monthlyPayment80 = $monthlyPayment * 0.8;
		
		$monthlyPayment50 = $monthlyPayment * 0.5;
			
		$dateFrom = new Time($yearFrom . '-' . $monthFrom . '-01 00:00:00');
		
		$swError = $this->initialDiscount();
			
		if ($swError == 0)
		{
			$studentTransactions = $this->Studenttransactions->find('all', 
				['conditions' => 
				[['transaction_type' => 'Mensualidad'], 
				['payment_date' => $dateFrom],
				['OR' => [['Studenttransactions.original_amount' => $monthlyPayment80], ['Studenttransactions.original_amount' => $monthlyPayment50]]]], 
				'order' => 
				['Studenttransactions.student_id' => 'ASC', 'payment_date' => 'ASC']]);
							
			if ($studentTransactions) 
			{				
				$account20 = 0;
				$account50 = 0;
				$accountStudentDiscount = 0;
							
				foreach ($studentTransactions as $studentTransaction)
				{
					$student = $this->Studenttransactions->Students->get($studentTransaction->student_id);
					
					if ($studentTransaction->original_amount == $monthlyPayment80)
					{
						$account20++;
						$discountPercentage = 20;
						$student->discount = 20;
					}
					elseif ($studentTransaction->original_amount == $monthlyPayment50)
					{
						$account50++;
						$discountPercentage = 50;	
						$student->discount = 50;
					}		

					if ($this->Studenttransactions->Students->save($student))
					{
						if ($accountStudentDiscount == 0)
						{
							$columns = [];
							$columns['report'] = 'Alumnos con discount 20% y 50%';
							$columns['start_end'] = 'start';
							
							$swError = $excels->add($columns);								
						}
						
						if ($swError == 0)
						{
							$accountStudentDiscount++;

							$columns = [];											
							$columns['report'] = 'Alumnos con discount 20% y 50%';
							$columns['number'] = $accountStudentDiscount;
							$columns['col1'] = $student->id;
							$columns['col2'] = $student->full_name;
							$columns['col3'] = $studentTransaction->original_amount;
							$columns['col4'] = $discountPercentage;
																
							$swError = $excels->add($columns);
							
							if ($swError > 0)
							{
								break;
							}
						}
						else
						{
							break;
						}
					}
					else
					{
						$binnacles->add('controller', 'Studenttransactions', 'discountStudent', 'No se pudo actualizar la columna discount del alumno ' . $student->id);
						$swError = 1;
						break;
					}
				}
				if ($swError == 0 && $accountStudentDiscount > 0)
				{
					$columns = [];
					$columns['report'] = 'Alumnos con discount 20% y 50%';
					$columns['start_end'] = 'end';
				
					$swError = $excels->add($columns);
				}
			}
			else
			{
				$binnacles->add('controller', 'Studenttransactions', 'discountStudent', 'No se encontraron alumnos con descuento del 20% y 50%');
				$swError = 1;				
			}
		}
		return $swError;
	}
	
	public function initialDiscount()
	{
		$this->autoRender = false;
		
		$binnacles = new BinnaclesController;
		
		$swError = 0;
		
		$discountStudents = $this->Studenttransactions->Students->find('all', ['conditions' => [['Students.id >' => 1], ['Students.discount IS NOT NULL']]]);
		
		if ($discountStudents)
		{			
			foreach ($discountStudents as $discountStudent)
			{			
				$student = $this->Studenttransactions->Students->get($discountStudent->id);
			
				$student->discount = null;
			
				if (!($this->Studenttransactions->Students->save($student)))
				{
					$binnacles->add('controller', 'Studenttransactions', 'initialDiscount', 'No se pudo inicializar la columna discount del alumno ' . $discountStudent->id);
					$swError = 1;
				}
			}
		}
		else
		{
			$binnacles->add('controller', 'Studenttransactions', 'initialDiscount', 'No se encontraron alumnos con descuento');
			$swError = 1;			
		}
		return $swError;
	}
	public function resetStudents()
	{
		$this->autoRender = false;
		
		$binnacles = new BinnaclesController;
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
				
		$currentDate = time::now();
		
		$lastYear = $currentDate->year - 1;
								
		$accountUpdate = 0;
					
		$swError = 0;
					
		$arrayResult = [];	
		$arrayResult['indicator'] = 0;
		$arrayResult['message'] = '';

		$students = $this->Studenttransactions->Students->find('all', 
			['conditions' => [['Students.id >' => 1], ['Students.student_condition' => 'Regular'], ['Students.balance <=' => $lastYear]]]);

		if ($students)
		{
			foreach ($students as $student)
			{
				$studentGet = $this->Studenttransactions->Students->get($student->id);
				
				if ($studentGet->section_id == 1)
				{
					$studentGet->student_condition = 'Retirado';
					$binnacles->add('controller', 'Studenttransactions', 'resetStudents', 'Alumno retirado por section_id == 1: ' . $studentGet->full_name . ' id: ' . $studentGet->id);
				}					
				if ($studentGet->balance < $lastYear && $studentGet->level_of_study == "")
				{
					$studentGet->student_condition = 'Retirado';
					$binnacles->add('controller', 'Studenttransactions', 'resetStudents', 'Alumno retirado por level_of_study == Blancos: ' . $studentGet->full_name . ' id: ' . $studentGet->id);					
				}
				$studentGet->level_of_study = "";
				$studentGet->new_student = 0;
                if ($this->Studenttransactions->Students->save($studentGet))
                { 
					$accountUpdate++;
				}
				else
				{
					$binnacles->add('controller', 'Studenttransactions', 'resetStudents', 'No se pudo actualizar el alumno con id ' . $studentGet->id);
					$swError = 1;	
					break;
				}
			}
		}
		else
		{
			$binnacles->add('controller', 'Studenttransactions', 'resetStudents', 'No se encontraron alumnos inscritos en años anteriores');
			$swError = 1;				
		}
		$arrayResult['indicator'] = $swError;
		
		if ($swError == 0)
		{
			$binnacles->add('controller', 'Studenttransactions', 'resetStudents', 'Se resetearon ' . $accountUpdate . ' alumnos');
			$arrayResult['message'] = 'Actualización exitosa de los estatus de los alumnos';
		}
		else
		{
			$binnacles->add('controller', 'Studenttransactions', 'resetStudents', 'Error en la ejecución del programa. Solo se resetearon ' . $accountUpdate . ' alumnos');
			$arrayResult['message'] = 'No se actualizaron correctamente los estatus de los alumnos';
		}
		return $arrayResult;
	}
	public function updateTransaction($studentTransaction = null, $newAmount = null)
	{
		$this->autoRender = false;
		
		$binnacles = new BinnaclesController;
				
		$arrayResult = [];	
		$arrayResult['indicator'] = 0;
		$arrayResult['message'] = '';
		
		$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
		
		$studentTransactionGet->original_amount = $newAmount;
		$studentTransactionGet->amount = $newAmount;
		$studentTransactionGet->paid_out = 0;
		$studentTransactionGet->partial_payment = 0;
		
		if ($this->Studenttransactions->save($studentTransactionGet))
		{ 
			$arrayResult['message'] = 'La transacción identificada con el id: ' . $studentTransactionGet->id . ' se actualizó exitosamente';			
		}
		else
		{ 
			$binnacles->add('controller', 'Studenttransactions', 'differenceAugust', 'No se pudo actualizar la transacción con el id ' . $studentTransactionGet->id);
			$arrayResult['indicator'] = 1;
			$arrayResult['message'] = 'No se pudo grabar la transacción con el id ' . $studentTransactionGet->id;
		} 
		return $arrayResult;
	}
	
    public function modifyPaymentDate()
    {
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
				
		$defaultDate = new Time();
			
		$defaultDate
			->year(1970)
			->month(01)
			->day(01)
			->hour(00)
			->minute(00)
			->second(00);
					
		$studentTransactions = $this->Studenttransactions->find('all', ['conditions' => ['payment_date <' => $defaultDate]]);
	
		$account1 = $studentTransactions->count();
			
		$account2 = 0;
		
		foreach ($studentTransactions as $studentTransaction)
        {		
			$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
							
			$studentTransactionGet->payment_date = $defaultDate; 
			
			if ($this->Studenttransactions->save($studentTransactionGet))
			{
				$account2++;
			}
			else
			{
				$this->Flash->error(__('No pudo ser grabada la transacción con id: ' . $studentTransactionGet->id));
			}
		}

		$this->Flash->success(__('Total registros seleccionados: ' . $account1));
		$this->Flash->success(__('Total registros actualizados: ' . $account2));
		
		return $this->redirect(['controller' => 'users', 'action' => 'wait']);
	}
    public function monetaryReconversion()
    {				
		$binnacles = new BinnaclesController;
	
		$studentTransactions = $this->Studenttransactions->find('all', ['conditions' => ['id >' => 0]]);
	
		$account1 = $studentTransactions->count();
			
		$account2 = 0;
		
		foreach ($studentTransactions as $studentTransaction)
        {		
			$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
			
			$previousAmount = $studentTransactionGet->amount;
										
			$studentTransactionGet->amount = $previousAmount / 100000;

			$previousAmount = $studentTransactionGet->original_amount;
										
			$studentTransactionGet->original_amount = $previousAmount / 100000;			
			
			if ($this->Studenttransactions->save($studentTransactionGet))
			{
				$account2++;
			}
			else
			{
				$binnacles->add('controller', 'Studenttransactions', 'monetaryReconversion', 'No se actualizó registro con id: ' . $studentTransactionGet->id);
			}
		}

		$binnacles->add('controller', 'Studenttransactions', 'monetaryReconversion', 'Total registros seleccionados: ' . $account1);
		$binnacles->add('controller', 'Studenttransactions', 'monetaryReconversion', 'Total registros actualizados: ' . $account2);
		
		return $this->redirect(['controller' => 'Users', 'action' => 'logout']);	
	}
    public function differenceRegistration($newAmount = null, $yearDifference = null)
    {
		$this->autoRender = false;
		
		$binnacles = new BinnaclesController;

		$binnacles->add('controller', 'Studenttransactions', 'differenceRegistration', '$newAmount: ' . $newAmount . ' $yearDifference: ' . $yearDifference);
		
		$accountRecords = 0;
		
		$swError = 0;
						
		$arrayResult = [];	
		$arrayResult['indicator'] = 0;
		$arrayResult['message'] = '';
		$arrayResult['adjust'] = 0;
		
		$studentTransactions = $this->Studenttransactions->find('all', [
			'contain' => ['Students'],
			'conditions' => 
			[['Studenttransactions.transaction_description' => "Matrícula " . $yearDifference], 
			['Students.new_student' => 0]], 
			]);
						
		if ($studentTransactions)
		{			
			foreach ($studentTransactions as $studentTransaction)
			{									
				$arrayResult = $this->updateRegistration($studentTransaction, $newAmount);
									
				if ($arrayResult['indicator'] == 0)
				{
					$accountRecords++;
				}
				else
				{
					$swError = 1;
					break;
				}
			}
		}
		else
		{
			$binnacles->add('controller', 'Studenttransactions', 'differenceRegistration', 'No se encontraron transacciones de matrícula de alumnos regulares ' . $yearDifference);
			$swError = 1;					
		}
		
		$arrayResult['indicator'] = $swError;
		
		if ($swError == 0)
		{
			$binnacles->add('controller', 'Studenttransactions', 'differenceRegistration', 'Registros actualizados: ' . $accountRecords);
			$arrayResult['message'] = 'Se actualizó exitosamente la diferencia de Matrícula';
			$arrayResult['adjust'] = $accountRecords; 
		}
		else
		{
			$binnacles->add('controller', 'Studenttransactions', 'differenceRegistrationRegular', 'Programa con error, solo se actualizaron ' . $accountRecords . ' transacciones');
			$arrayResult['message'] = 'No se actualizó exitosamente la diferencia de inscripción';
			$arrayResult['adjust'] = $accountRecords;
		}		
		return $arrayResult;
    }
	public function updateRegistration($studentTransaction = null, $newAmount = null)
	{
		$this->autoRender = false;
		
		$binnacles = new BinnaclesController;
								
		$arrayResult = [];	
		$arrayResult['indicator'] = 0;
		$arrayResult['message'] = '';
		
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
		
		if ($this->Studenttransactions->save($studentTransactionGet))
		{ 
			$arrayResult['message'] = 'La transacción identificada con el id: ' . $studentTransactionGet->id . ' se actualizó exitosamente';			
		}
		else
		{ 
			$binnacles->add('controller', 'Studenttransactions', 'updateRegistrationRegular', 'No se pudo actualizar la transacción con el id ' . $studentTransactionGet->id);
			$arrayResult['indicator'] = 1;
			$arrayResult['message'] = 'No se pudo actualizar la transacción con el id ' . $studentTransactionGet->id;
		}		
		return $arrayResult;
	}

    public function scholarshipIndex()
    {
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
				
		$yearFrom = $school->current_school_year;
		$yearUntil = $yearFrom + 1;

		$enrollment = 'Matrícula ' . $yearFrom;
		
        $query = $this->Studenttransactions->find('all')
			->contain(['Students'])
            ->where([['Studenttransactions.transaction_description' => $enrollment],
				['Studenttransactions.amount >' => 0],
				['Students.id >' => 1],
				['Students.section_id >' => 1],
				['Students.balance' => $yearFrom],
				['Students.student_condition' => 'Regular'],
				['Students.scholarship' => 1]])				
            ->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC']);

        $this->set('studenttransactions', $this->paginate($query));

        $this->set(compact('studenttransactions'));
        $this->set('_serialize', ['studenttransactions']);
    }

// Función creada para corregir cualquier error en la tabla Studenttransactions
	
	public function correctTransaction()
	{
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
							
		$studentTransactions = $this->Studenttransactions->find('all', 
			['conditions' => ['Studenttransactions.transaction_description' => 'Ago 2019']]); 
				
		$contador = 0;
		foreach ($studentTransactions as $studentTransaction)
        {		
			$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
								
			$studentTransactionGet->amount_dollar = 0;
															
			if (!($this->Studenttransactions->save($studentTransactionGet)))
			{
				$this->Flash->error(__('No se pudo actualizar la transacción identificada con el ID: ' . $studentTransactionGet->id . ' Correspondiente al estudiante: ' . $studentTransaction->student->full_name));
			}   
			$contador++;	
		}
				
        $this->set(compact('studentTransactions', 'contador'));
        $this->set('_serialize', ['studentTransactions', 'contador']);
	}	
	public function reportePagos()
	{
		if ($this->request->is('post'))
		{
			if (isset($_POST["concepto"]) && isset($_POST["ano_concepto"]))
			{
				return $this->redirect(['action' => 'reportePagosConcepto', $_POST["concepto"], $_POST["ano_concepto"]]);
			}

		}	
	}
	public function reportePagosConcepto($concepto = null, $anoConcepto = null)
	{
		$conceptoReporte = $concepto . " " . $anoConcepto;
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
        $fechaHoy = Time::now();
		
		$studentTransactions = TableRegistry::get('Studenttransactions');
		
		$pagosRecibidos = $studentTransactions->find()
			->select(
				['Studenttransactions.id',
				'Studenttransactions.transaction_description',
				'Studenttransactions.amount',
				'Students.id',
				'Students.surname',
				'Students.second_surname',
				'Students.first_name',
				'Students.second_name',
				'Students.student_condition',
				'Parentsandguardians.family'])
			->contain(['Students' => ['Parentsandguardians']])
			->where([['Studenttransactions.transaction_description' => $conceptoReporte],
				['Studenttransactions.amount > 0'], ['Students.student_condition' => 'Regular']])
			->order(['Parentsandguardians.family', 'Students.surname' => 'ASC', 'Students.second_name' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);			

		$contadorRegistros = $pagosRecibidos->count();
					
		$totalConcepto = 0;
			
		foreach ($pagosRecibidos as $pagosRecibido)
		{
			$totalConcepto = $totalConcepto + $pagosRecibido->amount;
		}
			
        $this->set(compact('pagosRecibidos', 'conceptoReporte', 'totalConcepto', 'fechaHoy'));
        $this->set('_serialize', ['pagosRecibidos', 'conceptoReporte', 'totalConcepto', 'fechaHoy']);
	}
}