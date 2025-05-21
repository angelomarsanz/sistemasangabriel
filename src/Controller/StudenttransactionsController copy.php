<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\ExcelsController;

use App\Controller\BinnaclesController;

use Cake\ORM\TableRegistry;

use App\Controller\EventosController;

use Cake\I18n\Time;

class StudenttransactionsController extends AppController
{
	public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
    }

    public function isAuthorized($user)
    {
		if(isset($user['role']))
		{
			if ($user['role'] === 'Control de estudios')
			{
				if(in_array($this->request->action, ['reportStudentGeneral', 'scholarshipIndex']))
				{
					return true;
				}				
			}
			elseif ($user['role'] === 'Representante')
			{
				if(in_array($this->request->action, ['consultaDeudaRepresentante']))
				{
					return true;
				}				
			}
			elseif ($user['role'] === 'Seniat')
			{
				if(in_array($this->request->action, []))
				{
					return true;
				}				
			}
		}

        return parent::isAuthorized($user);
    }        

    public function testFunction()
    {
		/*
		$transaccion = $this->Studenttransactions->get(92058);

		$this->set(compact('transaccion'));
		*/
	}
	
    public function testFunction2()
    {
		
		$transacciones = $this->Studenttransactions->find('all')
			->contain(['Students' => ['Sections']])
			->where(['Studenttransactions.transaction_description' => 'Jul 2024', 'Students.balance' => 
			2023, 'Students.becado_ano_anterior' => 0, 'Sections.orden >' => 41])
			->order(['Studenttransactions.amount_dollar' => 'ASC']);
		
		$this->set(compact('transacciones'));
	}
	
    public function index($idEstudiante = null, $controlador = 'Users', $accion = 'wait')
    {
		if ($this->request->is('post'))
	    {
			if (isset($_POST['id_estudiante'])) 
			{
				if ($_POST['id_estudiante'] != null)
				{
					$idEstudiante = $_POST['id_estudiante'];
					$estudiante = $_POST['estudiante'];
					$periodoEscolar = $_POST['periodo_escolar'];
					$estatusCuotas = $_POST['estatus_cuotas'];
					
					$condiciones = 
						[
							'student_id' => $idEstudiante, 
							'ano_escolar' => $periodoEscolar,
							'invoiced'  => $estatusCuotas 		
						];						

					$transaccionesEstudiante = $this->Studenttransactions->find('all', ['conditions' => $condiciones]);
					$contadorTransacciones = $transaccionesEstudiante->count();

					$this->set(compact('idEstudiante', 'estudiante', 'periodoEscolar', 'estatusCuotas', 'contadorTransacciones', 'transaccionesEstudiante', 'controlador', 'accion'));
	
				}
				else
				{
					$this->Flash->error(__('No se indicó el nombre del estudiante'));
				}
			} 
			elseif (isset($_POST['id_transaccion'])) 
			{
				$idEstudiante = $_POST['id_estudiante_modificado'];
				$estudiante = $_POST['estudiante_modificado'];
				$periodoEscolar = $_POST['periodo_escolar_modificado'];
				$estatusCuotas = $_POST['estatus_cuotas_modificado'];
				$invoiced = [];
				if (isset($_POST['invoiced']))
				{
					$invoiced = $_POST['invoiced'];
				}
				$amount =  $_POST['amount'];
				$originalAmount =  $_POST['original_amount'];
				$partialPayment =  $_POST['partial_payment'];
				$paidOut =  $_POST['paid_out'];
				$amountDollar =  $_POST['amount_dollar'];
				$porcentajeDescuento =  $_POST['porcentaje_descuento'];
				$idTransaccion = $_POST['id_transaccion'];

				$modificarCampos = [];
				$indicadorError = 0;

				foreach ($idTransaccion as $indice => $id)
				{	
					if (isset($invoiced[$indice]))
					{
						$modificarTransaccion['invoiced'] = 'Cambiar estatus registro';
					}
					else
					{
						$modificarTransaccion['invoiced'] = 'No cambiar estatus registro';
					}

					$modificarTransaccion['amount'] = $amount[$indice];
					$modificarTransaccion['original_amount'] = $originalAmount[$indice];
					$modificarTransaccion['partial_payment'] = $partialPayment[$indice];
					$modificarTransaccion['paid_out'] = $paidOut[$indice];
					$modificarTransaccion['amount_dollar'] = $amountDollar[$indice];
					$modificarTransaccion['porcentaje_descuento'] = $porcentajeDescuento[$indice];
					$modificarTransaccion['id'] = $id;

					$codigoRetorno = $this->modificarTransaccion($modificarTransaccion);
					if ($codigoRetorno > 0)
					{
						$indicadorError = 1;
						$this->Flash->error(__('No se pudieron hacer los cambios en la cuota con el id : '.$id));
						break;
					}
				}
				if ($indicadorError == 0)
				{
					$this->Flash->success(__('El estatus de las cuotas se cambió exitosamente'));
				}

				$condiciones = 
				[
					'student_id' => $idEstudiante, 
					'ano_escolar' => $periodoEscolar,
					'invoiced'  => $estatusCuotas		
				];						

				$transaccionesEstudiante = $this->Studenttransactions->find('all', ['conditions' => $condiciones]);
				$contadorTransacciones = $transaccionesEstudiante->count();

				$this->set(compact('idEstudiante', 'estudiante', 'periodoEscolar', 'estatusCuotas', 'contadorTransacciones', 'transaccionesEstudiante', 'controlador', 'accion'));
			}
       	}
		else
		{
			if ($idEstudiante != null)
			{
				$registroEstudiante = $this->Studenttransactions->Students->get($idEstudiante);
				$estudiante = $registroEstudiante->full_name;
				$this->loadModel('Schools');
				$school = $this->Schools->get(2);
				$periodoEscolar = $school->current_school_year;
				$estatusCuotas = 0;
				$transaccionesEstudiante = $this->Studenttransactions->find('all', 
					['conditions' => 
						[
							'student_id' => $idEstudiante, 
							'ano_escolar' => $periodoEscolar,
						]
					]);
				$contadorTransacciones = $transaccionesEstudiante->count();

				$this->set(compact('idEstudiante', 'estudiante', 'periodoEscolar', 'estatusCuotas', 'contadorTransacciones', 'transaccionesEstudiante', 'controlador', 'accion'));
			}
		}
    }

	public function modificarTransaccion($modificarTransaccion = null)
	{
		$transaccion = $this->Studenttransactions->get($modificarTransaccion['id']);
		
		if ($modificarTransaccion['invoiced'] == 'Cambiar estatus registro')
		{
			$transaccion->invoiced = $transaccion->invoiced ? false : true;
		}

		$transaccion->amount = $modificarTransaccion['amount'];
		$transaccion->original_amount = $modificarTransaccion['original_amount'];
		$transaccion->partial_payment = $modificarTransaccion['partial_payment'];
		$transaccion->paid_out = $modificarTransaccion['paid_out'];
		$transaccion->amount_dollar = $modificarTransaccion['amount_dollar'];
		$transaccion->porcentaje_descuento = $modificarTransaccion['porcentaje_descuento'];

		if ($this->Studenttransactions->save($transaccion)) 
		{
			return 0;
		}
		else
		{
			return 1;
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

    public function edit($transaccion = null, $billNumber = null, $tipo_documento = null)
	{
        $studenttransaction = $this->Studenttransactions->get($transaccion->transactionIdentifier);

		$studenttransaction->respaldo_registro = null;

		$respaldo_registro = 
			[
				"tipo_documento" => $tipo_documento,
				"numero_documento" => $billNumber,
				"transaccion" => $studenttransaction
			];

		$studenttransaction->respaldo_registro = json_encode($respaldo_registro);  

		if ($transaccion->descuentoAlumno != 1)
		{
			$studenttransaction->porcentaje_descuento = round((1 - $transaccion->descuentoAlumno) * 100, 2);
		}
						
		if ($studenttransaction->amount_dollar === null)
		{
			$studenttransaction->amount_dollar = $transaccion->montoAPagarDolar;
		}
		else
		{
			$studenttransaction->amount_dollar += $transaccion->montoAPagarDolar;
		}
		
		$studenttransaction->original_amount = $transaccion->tarifaDolarOriginal;	
		$studenttransaction->amount = $transaccion->tarifaDolar;
		
		if ($transaccion->tarifaDolarOriginal != $transaccion->tarifaDolar)
		{
			$eventos = new EventosController;
								
			$eventos->add('controller', 'Studenttransactions', 'edit', 'Se modificó el monto de la cuota ' . $transaccion->monthlyPayment . ' de ' . $transaccion->tarifaDolarOriginal . ' a ' . $transaccion->tarifaDolar . ' $ del alumno ' . $transaccion->studentName . ' en la factura Nro. ' . $billNumber);
		}
						
		if ($transaccion->observation == "Abono")
		{
			$studenttransaction->partial_payment = 1;
			$studenttransaction->paid_out = 0;
		} 
		else
		{
			$studenttransaction->partial_payment = 0;
			$studenttransaction->paid_out = 1;
		}
			
        $studenttransaction->bill_number = $billNumber;

        if (!($this->Studenttransactions->save($studenttransaction)))
        {
            $this->Flash->error(__('La transacción del alumno no pudo ser actualizada, vuelva a intentar.'));
        }
		else
		{
			if ($studenttransaction->transaction_type == 'Matrícula')
			{
				$year = substr($studenttransaction->transaction_description, 11, 4);
				
				$student = $this->Studenttransactions->Students->get($studenttransaction->student_id);

				if ($student->number_of_brothers == 0)
				{
					$student->respaldo_primer_ano_inscripcion = 0;
					$student->respaldo_ultimo_ano_inscripcion = 0;
					$student->respaldo_seccion_id = 1;
					$student->respaldo_nivel_de_estudio = "";

					$student->number_of_brothers = $year;
				}
				else
				{
					$student->respaldo_primer_ano_inscripcion = $student->number_of_brothers;
					$student->respaldo_ultimo_ano_inscripcion = $student->balance;
					$student->respaldo_seccion_id = $student->section_id;
					$student->respaldo_nivel_de_estudio = $student->level_of_study;	
				}
				
				$student->balance = $year;

				if (!($this->Studenttransactions->Students->save($student)))
				{
					$this->Flash->error(__('Los datos del alumno no pudieron ser actualizados, vuelva a intentar.'));
				}	
			}
		}
        return;
    }

    public function reverseTransaction($id = null, $amount = null, $billNumber = null, $tasaCambio = null, $tipo_documento)
    {
		$excepciones = [
			'Matrícula 2024' => 190,
			'Ago 2025' => 190
		]; 

        $studenttransaction = $this->Studenttransactions->get($id);

		$montoReversoDolar = round($amount / $tasaCambio, 2); 

		$studenttransaction->amount_dollar = $studenttransaction->amount_dollar - $montoReversoDolar;
				
		if ($studenttransaction->original_amount != $studenttransaction->amount)
		{
			$studenttransaction->amount = $studenttransaction->original_amount;
		}
			
		if ($studenttransaction->amount == 0 && $studenttransaction->amount_dollar == 0)
		{
			$studenttransaction->partial_payment = 0;
			$studenttransaction->paid_out = 0;
		}
		elseif ($studenttransaction->amount_dollar == 0)
		{
			$studenttransaction->partial_payment = 0;
			$studenttransaction->paid_out = 0;
		}
		elseif ($studenttransaction->amount > $studenttransaction->amount_dollar)
		{
			$studenttransaction->partial_payment = 1;
			$studenttransaction->paid_out = 0;
			if (isset($excepciones[$studenttransaction->transaction_description]))
			{
				if ($excepciones[$studenttransaction->transaction_description] == $studenttransaction->amount_dollar)
				{
					$studenttransaction->partial_payment = 0;
					$studenttransaction->paid_out = 1;
				}
			}
		} 
		else
		{
			$studenttransaction->partial_payment = 0;
			$studenttransaction->paid_out = 1;
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
			if ($studenttransaction->transaction_type == 'Matrícula')
			{			
				$student = $this->Studenttransactions->Students->get($studenttransaction->student_id);

				$student->number_of_brothers = $student->respaldo_primer_ano_inscripcion;
				$student->balance = $student->respaldo_ultimo_ano_inscripcion;
				$student->section_id = $student->respaldo_seccion_id;
				$student->level_of_study = $student->respaldo_nivel_de_estudio;	
				
				if (!($this->Studenttransactions->Students->save($student)))
				{
					$this->Flash->error(__('Los datos del alumno no pudieron ser actualizados, vuelva a intentar.'));
				}	
			}

		}
		return;
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
		$studenttransaction->ano_escolar = $quotaYear;
		$studenttransaction->porcentaje_descuento = 0;
        
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
			$studenttransaction->ano_escolar = $quotaYear;
			$studenttransaction->porcentaje_descuento = 0;

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
				$studenttransaction->ano_escolar = $quotaYear;
				$studenttransaction->porcentaje_descuento = 0;

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
				$studenttransaction->ano_escolar = $quotaYear;
				$studenttransaction->porcentaje_descuento = 0;				
				
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
		$studenttransaction->ano_escolar = $quotaYear;
		$studenttransaction->porcentaje_descuento = 0;
		
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
			$studenttransaction->ano_escolar = $quotaYear;
			$studenttransaction->porcentaje_descuento = 0;

            $studenttransaction->transaction_type = 'Seguro escolar';
            $studenttransaction->transaction_description = 'Seguro escolar' . ' ' . $quotaYear;

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
				$studenttransaction->ano_escolar = $quotaYear;
				$studenttransaction->porcentaje_descuento = 0;
           
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
		$studenttransaction->ano_escolar = $quotaYear;
		$studenttransaction->porcentaje_descuento = 0;
        
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
			$studenttransaction->ano_escolar = $quotaYear;
			$studenttransaction->porcentaje_descuento = 0;
               
            $studenttransaction->transaction_type = 'Servicio educativo';
            $studenttransaction->transaction_description = 'Servicio educativo' . ' ' . $quotaYear;

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
			$studenttransaction->ano_escolar = $quotaYear;
			$studenttransaction->porcentaje_descuento = 0;

            $studenttransaction->transaction_type = 'Seguro escolar';
            $studenttransaction->transaction_description = 'Seguro escolar' . ' ' . $quotaYear;

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
				$studenttransaction->ano_escolar = $quotaYear;
				$studenttransaction->porcentaje_descuento = 0;

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
        $studenttransactions = $this->Studenttransactions->find('all')->where(['student_id' => $studentId, 'invoiced' => 0]);
    
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

    public function assignSection()
    {	
        if ($this->request->is('post'))
        {
			$this->loadModel('Schools');

			$school = $this->Schools->get(2);
			
			$currentYearRegistration = $school->current_year_registration;
			
			$anoEscolarActual = $school->current_school_year;
			
			setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
			date_default_timezone_set('America/Caracas');

			$fechaHoraActual = Time::now();
			
			if ($currentYearRegistration != $anoEscolarActual)
			{
				if ($fechaHoraActual->month == 9)
				{
					$estudiantes = $this->Studenttransactions->Students->find()
						->where(['Students.student_condition' => 'Regular']);
				
					$indicadorNoActualizado = 0;
					foreach ($estudiantes as $estudiante)
					{
						$estudianteBuscado = $this->Studenttransactions->Students->get($estudiante->id);
						
						$estudianteBuscado->becado_ano_anterior = $estudianteBuscado->scholarship;
						$estudianteBuscado->tipo_descuento_ano_anterior = $estudianteBuscado->tipo_descuento;
						$estudianteBuscado->descuento_ano_anterior = $estudianteBuscado->discount;
						
						if (!($this->Studenttransactions->Students->save($estudianteBuscado)))
						{
							$this->Flash->error(__('No se pudo actualizar el estudiante con el ID: ' . $estudianteBuscado->id));
							$indicadorNoActualizado = 1;
						}
					}
					if ($indicadorNoActualizado == 0)
					{
						$school->current_school_year = $school->current_year_registration;
						if (!($this->Schools->save($school))) 
						{
							$this->Flash->error(__('No se pudo actualizar el año escolar'));
							return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
						}	
						else
						{
							$this->Flash->success(__('Se actualizaron correctamente los datos para el nuevo año escolar'));
						}
					}
				}
				else
				{
					$this->Flash->error(__('Estimado usuario no se pueden asignar secciones cuando se inicia el período de inscripción de alumnos regulares: ' . $fechaHoraActual->month));
					return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
				}
			}
			
            if (isset($_POST['level'])) // Si el usuario requiere que se muestren los alumnos inscritos para un nivel de estudio específico
            {
                $level = $_POST['level'];
            }
            else // El usuario ya actualizó las secciones en el formulario y se procede a actualizar en la base de datos
            {
                $result = 0;
                
                $accountStudent = 0;
                
                foreach ($_POST['student'] as $valor)
                {
                    $student = $this->Studenttransactions->Students->get($valor['id']);

                    if ($accountStudent == 0) // Si es el primer alumno de este grupo
                    {
                        $level = $student->level_of_study; // Tomamos el nivel de estudio del grupo
                        
                        $sublevel = $this->levelSublevel($level); 
                        
                        $sections = $this->Studenttransactions->Students->Sections->find('all')
                            ->where(['sublevel' => $sublevel])
                            ->order(['Sections.section' => 'ASC']);
                    }

                    foreach ($sections as $section)
                    {
                        if ($valor['section'] == $section->section)
                        {
                            $student->section_id = $section->id; // actualizamos la sección del alumno de acuerdo con la sección que asignó el usuario
                        }
                    }
					
                    if (!($this->Studenttransactions->Students->save($student))) // Se actualizan los datos en la base de datos
                    {
                        $result = 1;
                        
                        $this->Flash->error(__('No pudo ser actualizado el alumno identificado con el id: ' . $valor['id']));            
                    }
					
                    $accountStudent++;
                }
                if ($result == 0) // Si todo ok
                {
                    $this->Flash->success(__('Los alumnos fueron asignados exitosamente a su sección'));
                } 
            }
        }
		
		$assign = 1;
		        
        if (isset($level))
        {
            $studentTransactions = TableRegistry::get('Studenttransactions');
            						
			$transactionDescription = 'Matrícula ' . $currentYearRegistration;
			
			// Busqueda de todos los inscritos
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
						
			// Busqueda de todos los inscritos en el nivel de estudio que seleccionó el usuario			
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

				// Búsqueda de todas las secciones que pertenecen al nivel de estudio 
				$sections = $this->Studenttransactions->Students->Sections->find('all')
					->where(['sublevel' => $sublevel])
					->order(['Sections.section' => 'ASC']);

				foreach ($sections as $section)
				{
					if ($section->section == 'A')
					{
						$idSectionA = $section->id; // Guardo el ID de la sección "A" del nivel de estudio
					}
				}                    
			}

			foreach ($studentsLevel as $studentsLevels) // Recorro todos los estudiantes inscritos en el nivel de estudio seleccionado
			{     
				if ($level != '')
				{
					$swSection = 0;

					foreach ($sections as $section) 
					{
						if ($studentsLevels->student->section_id == $section->id) // Si coincide la sección del estudiante con alguna de las secciones del nivel de estudio que seleccionó el usuario
						{
							$swSection = 1; // Asigno el valor 1, que quiere decir que el estudiante ya fue asignado a la nueva sección en su nuevo nivel de estudio
						}
					}
					
					if ($swSection == 0) // Si no se le ha asignado la sección al estudiante en su nuevo nivel de estudio
					{
						$student = $this->Studenttransactions->Students->get($studentsLevels->student->id);

						$student->section_id = $idSectionA; // Le asigno la sección "A" como genérica        

						if (!($this->Studenttransactions->Students->save($student))) // Actualizo la base de datos con la nueva sección del alumno
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
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
            date_default_timezone_set('America/Caracas');

        $fechaActual = Time::now();
		
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
				['Studenttransactions.amount >' => 0],
				['Students.level_of_study' => $level],
				['Students.student_condition' => 'Regular']])
			->order(['Sections.section' => 'ASC', 'Students.surname' => 'ASC', 'Students.second_name' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);

		$account = $studentsFor->count();
		
		$totalPages = ceil($studentsFor->count() / 30) + 2;
		
		$levelChatScript = $this->replaceChatScript($level);

		$this->set(compact('school', 'studentsFor', 'level', 'totalPages', 'levelChatScript', 'fechaActual'));
		$this->set('_serialize', ['school', 'studentsFor', 'level', 'totalPages', 'levelChatScript', 'fechaActual']);
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
		$anio_periodo_actual = $school->current_school_year;

		if ($this->request->is('post')) 
        {
			setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
			date_default_timezone_set('America/Caracas');

			$currentDate = Time::now();

			$tipo_reporte = $_POST['tipo_reporte'];
			$periodo_escolar = $_POST['periodo_escolar'];
			$matricula_anio = 'Matrícula '.substr($periodo_escolar, 0, 4);
			$seguro_anio = 'Seguro escolar '.substr($periodo_escolar, 0, 4);

			$this->loadModel('Schools');
	
			$school = $this->Schools->get(2);
			
			$anio_periodo_actual = $school->current_school_year;

			if ($tipo_reporte == 'Reporte para aseguradora')
			{
				$datos_reporte = $this->reporteParaAseguradora($anio_periodo_actual);
				$studentsFor = $datos_reporte['studentsFor'];
				$totalPages = $datos_reporte['totalPages'];
				$alumnosAdicionales = $datos_reporte['alumnosAdicionales'];

				$this->set(compact('tipo_reporte', 'school', 'currentDate', 'studentsFor', 'totalPages', 'alumnosAdicionales'));	
			}
			else
			{
				$vector_condiciones_matricula = 
					[
						"Studenttransactions.transaction_description" => $matricula_anio, 
						"Studenttransactions.amount_dollar >" => 0, 
						"Students.student_condition" => 'Regular'
					]; 
				if ($tipo_reporte == 'Reporte de alumnos solventes')
				{
					$vector_condiciones_seguro = 
					[
						"Studenttransactions.transaction_description" => $seguro_anio, 
						"Studenttransactions.paid_out" => 1, 
						"Students.student_condition" => 'Regular'
					]; 
				}
				else
				{
					$vector_condiciones_seguro = 
					[
						"Studenttransactions.transaction_description" => $seguro_anio, 
						"Studenttransactions.paid_out" => 0, 
						"Students.student_condition" => 'Regular'
					]; 
				}
				$datos_reporte = $this->reportePagoSeguro($vector_condiciones_matricula, $vector_condiciones_seguro);
				$alumnos_seleccionados = $datos_reporte['alumnos_seleccionados'];
				$this->set(compact('tipo_reporte', 'school', 'currentDate', 'alumnos_seleccionados'));	
			}
		}
		else
		{
			$anio_periodo_anterior = $school->current_school_year -1;
			$anio_periodo_proximo = $school->current_school_year + 1;
			$anio_periodo_proximo_2 = $school->current_school_year + 2;

			$periodo_escolar_anterior = $anio_periodo_anterior."-".$anio_periodo_actual;
			$periodo_escolar_actual = $anio_periodo_actual."-".$anio_periodo_proximo;
			$periodo_escolar_proximo = $anio_periodo_proximo."-".$anio_periodo_proximo_2;

			$this->set(compact('periodo_escolar_anterior', 'periodo_escolar_actual', 'periodo_escolar_proximo'));
		}
	}

    public function reporteParaAseguradora($anio_escolar = null)
    {
		$this->loadModel('Excels');
	
		$matricula_anio = 'Matrícula '.$anio_escolar;

		$studentTransactions = TableRegistry::get('Studenttransactions');

		$studentsFor = $studentTransactions->find()
			->contain(['Students' => ['Parentsandguardians']])
			->where(['Studenttransactions.transaction_description' => $matricula_anio, 'Studenttransactions.amount_dollar >' => 0, 'Students.student_condition' => 'Regular'])
			->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);

		$ultimoEnvio = $this->Excels->find('all');

		$alumnosAdicionales = [];

		foreach ($studentsFor as $studentsFors)
		{
			$encontrado = 0;

			foreach ($ultimoEnvio as $envio)
			{
				if ($studentsFors->student->id == $envio->codigo_colegio)
				{
					$encontrado = 1;
					break;
				} 
			}
			if ($encontrado == 0)
			{
				$alumnosAdicionales[] = $studentsFors->student->id;	
			}
		}

		$account = $studentsFor->count();
		
		$totalPages = ceil($studentsFor->count() / 20);

		$datos_reporte = 
			[
				'studentsFor' => $studentsFor,
				'totalPages' => $totalPages,
				'alumnosAdicionales' => $alumnosAdicionales
			];
		
		return $datos_reporte;
	}

    public function reportePagoSeguro($vector_condiciones_matricula = null, $vector_condiciones_seguro = null)
    {
		$alumnos_seleccionados = [];

		$transacciones_estudiantes = TableRegistry::get('Studenttransactions');

		$estudiantes_matricula = $transacciones_estudiantes->find()
			->contain(['Students' => ['Parentsandguardians']])
			->where($vector_condiciones_matricula)
			->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);

		$contador_estudiantes_matricula = $estudiantes_matricula->count();

		$estudiantes_seguro = $transacciones_estudiantes->find()
			->contain(['Students'])
			->where($vector_condiciones_seguro)
			->order(['Students.id' => 'ASC']);

		$contador_estudiantes_seguro = $estudiantes_seguro->count();


		foreach ($estudiantes_matricula as $estudiante_m)
		{
			$encontrado = 0;

			foreach ($estudiantes_seguro as $estudiante_s)
			{
				if ($estudiante_m->student->id == $estudiante_s->student->id)
				{
					$encontrado = 1;
					break;
				} 
			}
			if ($encontrado == 1)
			{
				$alumnos_seleccionados[] = 
					[
						"estudiante" => $estudiante_m->student->full_name,
						"familia" => $estudiante_m->student->parentsandguardian->family,
						"nivel_estudios" => $estudiante_m->student->level_of_study,
						"id" => $estudiante_m->student->id						
					];	
			}
		}

		$datos_reporte = 
			[
				'alumnos_seleccionados' => $alumnos_seleccionados
			];
		
		return $datos_reporte;
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
		
        $this->loadModel('Schools');
		
		$this->loadModel('Sections');

        $school = $this->Schools->get(2);

        $currentYear = $school->current_school_year;
        
        $lastYear = $currentYear - 1;
        
        $nextYear = $currentYear + 1;
        
        $startingYear = $currentYear;
            
        $finalYear = $nextYear;  

		$students20 = $this->Studenttransactions->Students->find('all', ['conditions' => ['Students.tipo_descuento' => 'Hijos', 'OR' => [['Students.discount' => 20], ['Students.discount' => 0]]]]);
		
        if ($students20)
		{
			foreach ($students20 as $students20s)
			{
				$student = $this->Studenttransactions->Students->get($students20s->id);
				
				$student->tipo_descuento = '';
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
			->contain(['Students' => ['Parentsandguardians', 'Sections']])
			->where([['Studenttransactions.transaction_description' => $registration],
				['Studenttransactions.amount_dollar >' => 0], ['Students.student_condition' => 'Regular'], ['Students.section_id >' => 1]])
			->order(['Parentsandguardians.id' => 'ASC', 'Sections.orden' => 'DESC']);
			
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
					$aplicarDescuento = $this->aplicarDescuentoHijos($arrayStudents, 20);
					if ($aplicarDescuento == 0)
					{
						$discountUpdate20++;
					}
				}
				$accountStudents = 0;
				$accountChildren = 0;
				$arrayStudents = [];

				$idParent = $studentsFors->student->parentsandguardian->id;
			}
			
			$arrayStudents[] = $studentsFors->student->id;

			$accountRecords++;
			$accountChildren++;	
		}			

		if ($accountChildren == 3)
		{
			$aplicarDescuento = $this->aplicarDescuentoHijos($arrayStudents, 20);
			if ($aplicarDescuento == 0)
			{
				$discountUpdate20++;
			}
		}
				
		$this->Flash->success(__('Total alumnos a los que se les aplicó el descuento del 20%: ' . $discountUpdate20));
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
		
        $this->loadModel('Schools');
		
		$this->loadModel('Sections');

        $school = $this->Schools->get(2);

        $currentYear = $school->current_school_year;
        
        $lastYear = $currentYear - 1;
        
        $nextYear = $currentYear + 1;
        
        $startingYear = $currentYear;
            
        $finalYear = $nextYear;  

		$students50 = $this->Studenttransactions->Students->find('all', ['conditions' => ['Students.tipo_descuento' => 'Hijos', 'OR' => [['Students.discount' => 50], ['Students.discount' => 0]]]]);
		
        if ($students50)
		{
			foreach ($students50 as $students50s)
			{
				$student = $this->Studenttransactions->Students->get($students50s->id);
				
				$student->tipo_descuento = '';
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
			->contain(['Students' => ['Parentsandguardians', 'Sections']])
			->where([['Studenttransactions.transaction_description' => $registration],
				['Studenttransactions.amount_dollar >' => 0], ['Students.student_condition' => 'Regular'], ['Students.section_id >' => 1]])
			->order(['Parentsandguardians.id' => 'ASC', 'Sections.orden' => 'DESC']);
			
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
					$aplicarDescuento = $this->aplicarDescuentoHijos($arrayStudents, 50);
					if ($aplicarDescuento == 0)
					{
						$discountUpdate50++;
					}
				}
				$accountStudents = 0;
				$accountChildren = 0;
				$arrayStudents = [];

				$idParent = $studentsFors->student->parentsandguardian->id;
			}
																
			$arrayStudents[] = $studentsFors->student->id;

			$accountRecords++;
			$accountChildren++;	
		}			

		if ($accountChildren > 3)
		{
			$aplicarDescuento = $this->aplicarDescuentoHijos($arrayStudents, 50);
			if ($aplicarDescuento == 0)
			{
				$discountUpdate50++;
			}
		}		
		$this->Flash->success(__('Total alumnos a los que se les aplicó el descuento del 50%: ' . $discountUpdate50));
    }

    public function aplicarDescuentoHijos($arrayStudents = null, $descuento = null)
    {
		$descuentoAplicado = 0;
        foreach ($arrayStudents as $arrayStudent)
        {
			$student = $this->Studenttransactions->Students->get($arrayStudent);
			$aplicarDescuento = 0;
			if ($student->scholarship == 0)
			{
				if ($student->tipo_descuento != 'Becado' && $student->tipo_descuento != 'Especial')
				{
					$aplicarDescuento = 1;
				}
			}
			if ($aplicarDescuento == 1)
			{
				$student->discount = $descuento;
				$student->tipo_descuento = "Hijos";
				if ($this->Studenttransactions->Students->save($student))
				{
					$descuentoAplicado = 1;
				}
				else
				{
					$this->Flash->error(__('No se pudo actualizar la columna discount en el registro Nro. ' . $arrayStudent['id']));
				}
			}
			else
			{
				$this->Flash->error(__('No se pudo aplicar el descuento al estudiante '.$student->full_name.', ya que tiene otro tipo de beca'));
			}
			break;
		}
		if ($descuentoAplicado == 1)
		{
			return 0;
		}
		else
		{
			return 1;
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
		$anio_periodo_actual = $school->current_school_year;

		if ($this->request->is('post'))
		{
			$periodo_escolar = $_POST['periodo_escolar'];
			$matricula_anio = 'Matrícula '.substr($periodo_escolar, 0, 4);

			if (substr($periodo_escolar, 0, 4) >= $anio_periodo_actual)
			{
				$columna_becado = "Students.scholarship";
			}
			else
			{
				$columna_becado = "Students.becado_ano_anterior";
			}  

			$studenttransactions = $this->Studenttransactions->find('all')
			->contain(['Students'])
			->where([['Studenttransactions.transaction_description' => $matricula_anio],
				['Studenttransactions.amount_dollar >' => 0],
				['Students.id >' => 1],
				['Students.student_condition' => 'Regular'],
				[$columna_becado => 1]])				
			->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC']);

			$contador_estudiantes = $studenttransactions->count();
		
			$this->set(compact('periodo_escolar', 'studenttransactions', 'contador_estudiantes', ));
		}
		else
		{
			$anio_periodo_anterior = $school->current_school_year -1;
			$anio_periodo_proximo = $school->current_school_year + 1;
			$anio_periodo_proximo_2 = $school->current_school_year + 2;

			$periodo_escolar_anterior = $anio_periodo_anterior."-".$anio_periodo_actual;
			$periodo_escolar_actual = $anio_periodo_actual."-".$anio_periodo_proximo;
			$periodo_escolar_proximo = $anio_periodo_proximo."-".$anio_periodo_proximo_2;
			$this->set(compact('periodo_escolar_anterior', 'periodo_escolar_actual', 'periodo_escolar_proximo'));
		}
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
				'Studenttransactions.amount_dollar',
				'Students.id',
				'Students.surname',
				'Students.second_surname',
				'Students.first_name',
				'Students.second_name',
				'Students.student_condition',
				'Parentsandguardians.family'])
			->contain(['Students' => ['Parentsandguardians']])
			->where([['Studenttransactions.transaction_description' => $conceptoReporte],
				['Studenttransactions.amount_dollar > 0'], ['Students.student_condition' => 'Regular']])
			->order(['Parentsandguardians.family', 'Students.surname' => 'ASC', 'Students.second_name' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);			

		$contadorRegistros = $pagosRecibidos->count();
					
		$totalConcepto = 0;
			
		foreach ($pagosRecibidos as $pagosRecibido)
		{
			$totalConcepto = $totalConcepto + $pagosRecibido->amount_dollar;
		}
			
        $this->set(compact('pagosRecibidos', 'conceptoReporte', 'totalConcepto', 'fechaHoy'));
        $this->set('_serialize', ['pagosRecibidos', 'conceptoReporte', 'totalConcepto', 'fechaHoy']);
	}
	
    public function notaTransaccion($idTransaccion = null, $numeroNotaContable = null, $valor = null, $tipoNota = null, $tasaCambio = null)
    {
		$excepciones = [
			'Matrícula 2024' => 190,
			'Ago 2025' => 190
		]; 

		$estudianteController = new StudentsController();
        
		$codigoRetornoTransaccion = 0;
				
		$diferenciaOriginalActual = 0;
		
		$tarifaDolar = 0;
		
        $transaccionEstudiante = $this->Studenttransactions->get($idTransaccion);
				
		$montoNotaDolar = round($valor / $tasaCambio, 2); 
		
		if ($tipoNota == "Crédito")
		{
			$transaccionEstudiante->amount_dollar = $transaccionEstudiante->amount_dollar - $montoNotaDolar;
		}
		else
		{
			$transaccionEstudiante->amount_dollar = $transaccionEstudiante->amount_dollar + $montoNotaDolar;
		}
				
		$mesesTarifas = $estudianteController->mesesTarifas(0);
		$otrasTarifas = $estudianteController->otrasTarifas(0);
		
		if ($transaccionEstudiante->transaction_type == "Mensualidad" && substr($transaccionEstudiante->transaction_description, 0, 3) != "Ago")
		{				
			$ano = $transaccionEstudiante->payment_date->year;
								
			$mes = $transaccionEstudiante->payment_date->month;
																						
			if ($mes < 10)
			{
				$mesCadena = "0" . $mes;
			}
			else
			{
				$mesCadena = (string) $mes;
			}
			$anoMes = $ano . $mesCadena;
						
			foreach ($mesesTarifas as $mesTarifa)
			{
				if ($mesTarifa['anoMes'] == $anoMes)
				{
					$tarifaDolar = $mesTarifa['tarifaDolar'];

					$estudiante = $this->Studenttransactions->Students->get($transaccionEstudiante->student_id);
				   
					if ($estudiante->discount === null )
					{
						$descuentoFamilia = 1;
					}
					else
					{	
						$descuentoFamilia = (100 - $estudiante->discount) / 100;
					}
					
					$tarifaDolar = round($tarifaDolar * $descuentoFamilia, 2);
					break;
				}
			}
		}
		else
		{
			foreach ($otrasTarifas as $otras)
			{				
				if ($otras['conceptoAno'] == $transaccionEstudiante->transaction_description)
				{
					$tarifaDolar = $otras['tarifaDolar'];
					break;
				}
			}
		}
		
		$diferenciaOriginalActual = $transaccionEstudiante->original_amount - $transaccionEstudiante->amount;
		
		$tarifaDolar = $tarifaDolar - $diferenciaOriginalActual;	
		
		if ($transaccionEstudiante->amount_dollar == $tarifaDolar)
		{
			$transaccionEstudiante->partial_payment = 0;
			$transaccionEstudiante->paid_out = 1;
		}
		elseif ($transaccionEstudiante->amount_dollar > $tarifaDolar)
		{
			$transaccionEstudiante->partial_payment = 0;
			$transaccionEstudiante->paid_out = 1;
		}
		else
		{
			if ($transaccionEstudiante->amount_dollar == 0)
			{
				$transaccionEstudiante->partial_payment = 0;
				$transaccionEstudiante->paid_out = 0;
			}
			else
			{
				$transaccionEstudiante->partial_payment = 1;
				$transaccionEstudiante->paid_out = 0;
				if (isset($excepciones[$transaccionEstudiante->transaction_description]))
				{
					if ($excepciones[$transaccionEstudiante->transaction_description] == $transaccionEstudiante->amount_dollar)
					{
						$transaccionEstudiante->partial_payment = 0;
						$transaccionEstudiante->paid_out = 1;
					}
				}
			}
		}

		if ($codigoRetornoTransaccion == 0)
		{
			$transaccionEstudiante->bill_number = $numeroNotaContable;

			if (!($this->Studenttransactions->save($transaccionEstudiante)))
			{
				$codigoRetornoTransaccion = 1;
				$this->Flash->error(__('La transacción del alumno no pudo ser actualizada, vuelva a intentar.'));
			}
			else
			{						
				if ($transaccionEstudiante->transaction_type == 'Matrícula')
				{
					if ($transaccionEstudiante->amount == 0)
					{
						$estudiante = $this->Studenttransactions->Students->get($transaccionEstudiante->student_id);
						
						if ($estudiante->number_of_brothers == $estudiante->balance)
						{
							$estudiante->number_of_brothers = 0;
							$estudiante->balance = 0;
						}
						else
						{
							$estudiante->balance -= 1; 
						}
						
						if (!($this->Studenttransactions->Students->save($estudiante)))
						{
							$codigoRetornoTransaccion = 1;
							$this->Flash->error(__('Los datos del alumno no pudieron ser actualizados, vuelva a intentar.'));
						}
					}
				}
			}
		}
        return $codigoRetornoTransaccion;
    }
	
	public function modificarParciales()
	{
		$contadorBusqueda = 0;
		$contadorCaso1 = 0;
		$contadorCaso2 = 0;
		$contadorCaso3 = 0;

		$contadorActualizadas = 0;
		
		$transaccionesEstudiante = TableRegistry::get('Studenttransactions');
		
		$transacciones = $transaccionesEstudiante->find('all')
			->where(['invoiced' => 0, 'partial_payment' => 1]);
			
		$contadorBusqueda = $transacciones->count();
		
		if ($contadorBusqueda > 0)
		{
			foreach ($transacciones as $transaccion)
			{
				$transaccionGet = $this->Studenttransactions->get($transaccion->id);
				
				if ($transaccionGet->paid_out == 0 && $transaccionGet->bill_number != 0)
				{
					$transaccionGet->amount = $transaccionGet->amount_dollar;
					$transaccionGet->original_amount = $transaccionGet->amount_dollar;
					$contadorCaso1++;
				}
				elseif ($transaccionGet->paid_out == 0 && $transaccionGet->bill_number == 0)
				{
					if ($transaccionGet->id != 49081 && $transaccionGet->bill_number != 49095) 
					{
						$transaccionGet->partial_payment = 0;
					}
					$transaccionGet->amount = $transaccionGet->amount_dollar;
					$transaccionGet->original_amount = $transaccionGet->amount_dollar;
					$contadorCaso2++;
				}
				elseif ($transaccionGet->paid_out == 1)
				{
					$transaccionGet->partial_payment = 0;
					$transaccionGet->amount = $transaccionGet->amount_dollar;
					$transaccionGet->original_amount = $transaccionGet->amount_dollar;
					$contadorCaso3++;
				}
				/* if (!($this->Studenttransactions->save($transaccionGet))) 
				{
					$this->Flash->error(__('La transacción con el id ' . $transaccion->id . ' no pudo ser actualizada'));
				}
				else
				{
					$contadorActualizadas++;
				} */
			}
		}
		
		$this->Flash->success(__('Total transaccciones encontradas ' . $contadorBusqueda));
		$this->Flash->success(__('Total transaccciones caso 1 ' . $contadorCaso1));
		$this->Flash->success(__('Total transaccciones caso 2 ' . $contadorCaso2));
		$this->Flash->success(__('Total transaccciones caso 3 ' . $contadorCaso3));
		$this->Flash->success(__('Total actualizadas ' . $contadorActualizadas));
	
        $this->set(compact('transacciones'));
        $this->set('_serialize', ['transacciones']);
	}
	public function modificarTotales()
	{
		$contadorBusqueda = 0;
		$contadorActualizadas = 0;
		
		$transaccionesEstudiante = TableRegistry::get('Studenttransactions');
		
		$transacciones = $transaccionesEstudiante->find('all')
			->where(['invoiced' => 0, 'partial_payment' => 0, 'paid_out' => 1, 'amount_dollar !=' => 999999 ]);
			
		$contadorBusqueda = $transacciones->count();
		
		if ($contadorBusqueda > 0)
		{
			foreach ($transacciones as $transaccion)
			{
				$transaccionGet = $this->Studenttransactions->get($transaccion->id);
				
				$transaccionGet->amount = $transaccionGet->amount_dollar;
				$transaccionGet->original_amount = $transaccionGet->amount_dollar;

				/* if (!($this->Studenttransactions->save($transaccionGet))) 
				{
					$this->Flash->error(__('La transacción con el id ' . $transaccion->id . ' no pudo ser actualizada'));
				}
				else
				{
					$contadorActualizadas++;
				} */
			}
		}
		
		$this->Flash->success(__('Total transaccciones encontradas ' . $contadorBusqueda));
		$this->Flash->success(__('Total actualizadas ' . $contadorActualizadas));
	
        $this->set(compact('transacciones'));
        $this->set('_serialize', ['transacciones']);
	}
	public function modificarNoPagadas()
	{
		$contadorBusqueda = 0;
		$contadorActualizadas = 0;
		
		$transaccionesEstudiante = TableRegistry::get('Studenttransactions');
		
		$transacciones = $transaccionesEstudiante->find('all')
			->where(['invoiced' => 0, 'partial_payment' => 0, 'paid_out' => 0 ]);
			
		$contadorBusqueda = $transacciones->count();
		
		if ($contadorBusqueda > 0)
		{
			foreach ($transacciones as $transaccion)
			{
				$transaccionGet = $this->Studenttransactions->get($transaccion->id);
				
				$transaccionGet->amount = 0;
				$transaccionGet->original_amount = 0;

				/* if (!($this->Studenttransactions->save($transaccionGet))) 
				{
					$this->Flash->error(__('La transacción con el id ' . $transaccion->id . ' no pudo ser actualizada'));
				}
				else
				{
					$contadorActualizadas++;
				} */
			}
		}
		
		$this->Flash->success(__('Total transaccciones encontradas ' . $contadorBusqueda));
		$this->Flash->success(__('Total actualizadas ' . $contadorActualizadas));
	
        $this->set(compact('transacciones'));
        $this->set('_serialize', ['transacciones']);
	}
	public function anoEscolar()
	{
		$contadorBusqueda = 0;
		$contadorMensualidad2018 = 0;
		$contadorMensualidad2019 = 0;
		$contadorMatricula2019 = 0;
		$contadorSeguro2019 = 0;
		$contadorServicio2019 = 0;
		$contadorThales2019 = 0;
		$contadorActualizadas = 0;
		
		$transaccionesEstudiante = TableRegistry::get('Studenttransactions');
		
		$transacciones = $transaccionesEstudiante->find('all')->where(['invoiced' => 0]);
			
		$contadorBusqueda = $transacciones->count();
		
		$this->Flash->success(__('Total transacciones activas ' . $contadorBusqueda));
		
		foreach ($transacciones as $transaccion)
		{
			$actualizar = 0;	
			$ano2019 = new Time('2019-09-01 00:00:00');

			$transaccionGet = $this->Studenttransactions->get($transaccion->id);
			
			if ($transaccion->transaction_type == 'Mensualidad' && $transaccion->payment_date < $ano2019)
			{
				$transaccionGet->ano_escolar = 2018;
				$contadorMensualidad2018++;
				$actualizar = 1;
			}
			elseif ($transaccion->transaction_type == 'Mensualidad' && $transaccion->payment_date >= $ano2019)
			{
				$transaccionGet->ano_escolar = 2019;
				$contadorMensualidad2019++;
				$actualizar = 1;
			}						
			elseif ($transaccion->transaction_type == 'Matrícula' && $transaccion->transaction_description == 'Matrícula 2019')
			{
				$transaccionGet->ano_escolar = 2019;
				$contadorMatricula2019++;
				$actualizar = 1;
			}
			elseif ($transaccion->transaction_type == 'Seguro escolar' && $transaccion->transaction_description == 'Seguro escolar 2019')
			{
				$transaccionGet->ano_escolar = 2019;
				$contadorSeguro2019++;
				$actualizar = 1;
			}
			elseif ($transaccion->transaction_type == 'Servicio educativo' && $transaccion->transaction_description == 'Servicio educativo 2019')
			{
				$transaccionGet->ano_escolar = 2019;
				$contadorServicio2019++;
				$actualizar = 1;
			}
			elseif ($transaccion->transaction_type == 'Thales' && $transaccion->transaction_description == 'Thales 2019')
			{
				$transaccionGet->ano_escolar = 2019;
				$contadorThales2019++;
				$actualizar = 1;
			}
			
			if ($actualizar == 1)
			{			
				if (!($this->Studenttransactions->save($transaccionGet))) 
				{
					$this->Flash->error(__('La transacción con el id ' . $transaccion->id . ' no pudo ser actualizada'));
				}
				else
				{
					$contadorActualizadas++;
				}
			}
		}
		
		$this->Flash->success(__('Total mensualidades 2018 ' . $contadorMensualidad2018));
		$this->Flash->success(__('Total mensualidades 2019 ' . $contadorMensualidad2019));
		$this->Flash->success(__('Total matrículas 2019 ' . $contadorMatricula2019));
		$this->Flash->success(__('Total seguro 2019 ' . $contadorSeguro2019));
		$this->Flash->success(__('Total servicio educativo 2019 ' . $contadorServicio2019));
		$this->Flash->success(__('Total Thales 2019 ' . $contadorThales2019));
		$this->Flash->success(__('Total actualizadas ' . $contadorActualizadas));
	
        $this->set(compact('transacciones'));
        $this->set('_serialize', ['transacciones']);
	}

	// Ejecutar al iniciar el año escolar

	public function marcarEliminado()
	{
		$contadorBusqueda = 0;
		$contadorMensualidades = 0;
		$contadorMatriculas = 0;
		$contadorSeguro = 0;
		$contadorServicio = 0;
		$contadorThales = 0;
		$contadorActualizadas = 0;
		
		$transaccionesEstudiante = TableRegistry::get('Studenttransactions');
		
		$transacciones = $transaccionesEstudiante->find('all');
			
		$contadorBusqueda = $transacciones->count();
		
		$this->Flash->success(__('Total transacciones busqueda ' . $contadorBusqueda));
		
		foreach ($transacciones as $transaccion)
		{
			$marcar = 0;
			
			$fechaHasta = new Time('2020-09-01 00:00:00');
			
			if ($transaccion->invoiced == 0)
			{
				if ($transaccion->transaction_type == 'Mensualidad' && $transaccion->payment_date < $fechaHasta)
				{
					$marcar = 1;
					$contadorMensualidades++;
				}
				elseif ($transaccion->transaction_type == 'Matrícula' && $transaccion->transaction_description != 'Matrícula 2020' && $transaccion->transaction_description != 'Matrícula 2021')
				{
					$marcar = 1;
					$contadorMatriculas++;
				}
				elseif ($transaccion->transaction_type == 'Seguro escolar' && $transaccion->transaction_description != 'Seguro escolar 2020' && $transaccion->transaction_description != 'Seguro escolar 2021')
				{
					$marcar = 1;
					$contadorSeguro++;
				}
				elseif ($transaccion->transaction_type == 'Servicio educativo' && $transaccion->transaction_description != 'Servicio educativo 2020' && $transaccion->transaction_description != 'Servicio educativo 2021')
				{
					$marcar = 1;
					$contadorServicio++;
				}
				elseif ($transaccion->transaction_type == 'Thales')
				{
					$marcar = 1;
					$contadorThales++;
				}

				
				if ($marcar == 1)
				{
					$transaccionGet = $this->Studenttransactions->get($transaccion->id);
				
					$transaccionGet->invoiced = 1;
				
					if (!($this->Studenttransactions->save($transaccionGet))) 
					{
						$this->Flash->error(__('La transacción con el id ' . $transaccion->id . ' no pudo ser actualizada'));
					}
					else
					{
						$contadorActualizadas++;
					} 
				}
			}
		}
		
		$this->Flash->success(__('Total mensualidades ' . $contadorMensualidades));
		$this->Flash->success(__('Total matrículas ' . $contadorMatriculas));
		$this->Flash->success(__('Total seguro ' . $contadorSeguro));
		$this->Flash->success(__('Total servicio educativo ' . $contadorServicio));
		$this->Flash->success(__('Total Thales ' . $contadorThales));
		$this->Flash->success(__('Total actualizadas ' . $contadorActualizadas));
	
        $this->set(compact('transacciones'));
        $this->set('_serialize', ['transacciones']);
	}

	// Ejecutar al iniciar el año escolar

	public function eliminarMarcado()
	{
		$contadorBusqueda = 0;
		$contadorEliminadas = 0;
		
		$transaccionesEstudiante = TableRegistry::get('Studenttransactions');
		
		$transacciones = $transaccionesEstudiante->find('all');
				
		$this->Flash->success(__('Total transacciones busqueda ' . $contadorBusqueda));
		
		foreach ($transacciones as $transaccion)
		{
			$marcar = 0;
					
			if ($transaccion->invoiced == 1)
			{		
				$studenttransaction = $this->Studenttransactions->get($transaccion->id);
				
				if (!($this->Studenttransactions->delete($studenttransaction)))
				{
					$this->Flash->error(__('La transacción con el id ' . $transaccion->id . ' no pudo ser actualizada'));
				}				
				else
				{
					$contadorEliminadas++;
				}
			}
		}
		
		$this->Flash->success(__('Total registros marcados para eliminar ' . $contadorBusqueda));
		$this->Flash->success(__('Total transacciones eliminadas ' . $contadorEliminadas));
	
        $this->set(compact('transacciones'));
        $this->set('_serialize', ['transacciones']);
	}

	public function actualizarTransaccionBecado($idEstudiante = null, $anoEscolar = null)
	{
		$this->autoRender = false;

		$codigoRetorno = 0;

		$errorActualización = 0;

		$estudianteController = new StudentsController();

		$mesesTarifas = $estudianteController->mesesTarifas(0);

		$transaccciones = $this->Studenttransactions->find('all')
			->where(['student_id' => $idEstudiante, 'ano_escolar' => $anoEscolar, 'transaction_type' => 'Mensualidad', 'paid_out' => 1]);

		$contadorBusqueda = $transaccciones->count();

		$this->Flash->success(__('Total transacciones ' . $contadorBusqueda . ' del estudiante con el ID: ' . $idEstudiante));		

		foreach ($transaccciones as $transaccion)
		{
			if (substr($transaccion->transaction_description, 0, 3) != "Ago")
			{				
				$ano = $transaccion->payment_date->year;
								
				$mes = $transaccion->payment_date->month;
													
				if ($mes < 10)
				{
					$mesCadena = "0" . $mes;
				}
				else
				{
					$mesCadena = (string) $mes;
				}

				$anoMes = $ano . $mesCadena;
							
				foreach ($mesesTarifas as $mesTarifa)
				{
					if ($mesTarifa['anoMes'] == $anoMes)
					{
						$tarifaDolar = $mesTarifa['tarifaDolar'];

						if ($transaccion->amount < $tarifaDolar)
						{
							$porcentajeDescontado = 100 - (($transaccion->amount / $tarifaDolar) * 100); 

							$transaccionModificar = $this->Studenttransactions->get($transaccion->id);

							$transaccionModificar->porcentaje_descuento = $porcentajeDescontado;

							if (!($this->Studenttransactions->save($transaccionModificar)))				
							{
								$this->Flash->error(__('No se pudo actualizar la transacción con el ID ' . $transaccionModificar->id));
								$errorActualización = 1;
								break;
							}
							else
							{
								$codigoRetorno++;
							}
						}
					}
				}
			}

			if ($errorActualización == 1)
			{
				$codigoRetorno = 99;
				break;
			}

		}

		return $codigoRetorno;
	}

	public function generalMorosidadRepresentantes()
    {	
		if ($this->request->is('post')) 
        {
			return $this->redirect(['controller' => 'Studenttransactions', 'action' => 'reporteGeneralMorosidadRepresentantes', $_POST["mes"], $_POST["periodo_escolar"], "General de Representantes", $_POST["consejo_educativo"], $_POST["indicador_recalculo"], $_POST["telefono"]]);
        }
	}

	public function reporteGeneralMorosidadRepresentantes($mes = null, $periodo_escolar = null, $tipo_reporte = null, $consejo_educativo, $indicador_recalculo = null, $telefono = null)
	{	
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

		$currentDate = Time::now();
               	
		$this->loadModel('Schools');

		$this->loadModel('Schools');
		$school = $this->Schools->get(2);
		$anioEscolarActual = $school->current_school_year;

		$this->loadModel('Monedas');	
		$moneda = $this->Monedas->get(2);
		$dollarExchangeRate = $moneda->tasa_cambio_dolar; 

		$mes_numero_nombre =
			[
				"00" => "Matrícula",
				"09" => "Septiembre",
				"10" => "Octubre",
				"11" => "Noviembre",
				"12" => "Diciembre",
				"01" => "Enero",
				"02" => "Febrero",
				"03" => "Marzo",
				"04" => "Abril",
				"05" => "Mayo",
				"06" => "Junio", 
				"07" => "Julio", 
				"08" => "Agosto",
				"15" => "Consejo educativo"
			];

		$nombre_mes_reporte = $mes_numero_nombre[$mes];

		$mes_ubicacion_anio = 
			[
				"00" => 0,
				"09" => 0,
				"10" => 0,
				"11" => 0,
				"12" => 0,
				"01" => 1,
				"02" => 1,
				"03" => 1,
				"04" => 1,
				"05" => 1,
				"06" => 1,
				"07" => 1,
				"08" => 1,
				"15" => 0
			];

		$anio = substr($periodo_escolar, 0, 4);
		$proximoAnio = substr($periodo_escolar, 5, 4);

		$anio_correspondiente_mes = $anio + $mes_ubicacion_anio[$mes];
														
		$anio_mes_dia_hasta = $anio_correspondiente_mes.$mes."01";

		$mes_anio_desde = "09/".$anio;
		$mes_anio_hasta = $mes."/".$anio_correspondiente_mes;

		$anio_mes_dia_agosto = $proximoAnio."0801";

		$total_cuotas_periodo = 0;
								
		$detalle_morosos = [];

		$vector_morosidad = 
			[
				"Familia" => "",
				"Dif" => 0,
				"SE"  => 0,
				"Seg" => 0,
				"Sep" => 0,
				"Oct" => 0,
				"Nov" => 0,
				"Dic" => 0,
				"Ene" => 0,
				"Feb" => 0,
				"Mar" => 0,
				"Abr" => 0,
				"May" => 0,
				"Jun" => 0,
				"Jul" => 0,
				"CE"  => 0,
				"Total $" => 0,
				"Teléfono" => ""
			];

		$totales_morosidad = 
			[
				"Dif" => 0,
				"SE"  => 0,
				"Seg" => 0,
			  	"Sep" => 0,
			  	"Oct" => 0,
			  	"Nov" => 0,
			  	"Dic" => 0,
			  	"Ene" => 0,
			  	"Feb" => 0,
			  	"Mar" => 0,
			  	"Abr" => 0,
			  	"May" => 0,
			  	"Jun" => 0,
			  	"Jul" => 0,
			  	"CE"  => 0,
			  	"Total $" => 0
			];
		
		$id_representante_anterior = 0;
		$indice_vector = "";

		$contador_transacciones = 0;

		$transacciones_estudiantes = $this->Studenttransactions->find('all')
		->contain(['Students' => ['Parentsandguardians', 'Sections']])
		->where(['Studenttransactions.invoiced' => 0, 'Studenttransactions.ano_escolar' => $anio, 'Students.student_condition' => 'Regular', 'Students.balance' => $anio])
		->order(['Parentsandguardians.family' => 'ASC', 'Parentsandguardians.surname' => 'ASC', 'Parentsandguardians.first_name' => 'ASC', 'Parentsandguardians.id' => 'ASC', 'Studenttransactions.payment_date' => 'ASC']);

		if ($transacciones_estudiantes->count() == 0)
		{
			$this->Flash->error(__('No se encontraron cuotas pendientes'));		
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
		}

		$vector_cuotas = $this->saldoCuotas($mes, $anio, $periodo_escolar, $indicador_recalculo, $transacciones_estudiantes, $anio_mes_dia_hasta, $anio_mes_dia_agosto); 
				
		foreach ($transacciones_estudiantes as $transaccion)
		{ 
			if (isset($vector_cuotas[$transaccion->id]))
			{
				$contador_transacciones++;
				/*
				if ($contador_transacciones == 1000)
				{
					break;
				}
				*/
				$monto_cuota = $vector_cuotas[$transaccion->id]["monto_cuota"];
				$saldo_cuota = $vector_cuotas[$transaccion->id]["saldo_cuota"];
		
				$total_cuotas_periodo += $monto_cuota;

				$indicadorProcesar = 0;
				if ($transaccion->transaction_type == 'Servicio educativo' && $transaccion->paid_out == 0 && $saldo_cuota >= 0)
				{
					$indicadorProcesar = 1;
				}
				elseif ($saldo_cuota > 0)
				{
					$indicadorProcesar = 1;				
				}

				if ($indicadorProcesar == 1)
				{
					if ($id_representante_anterior != $transaccion->student->parentsandguardian->id)
					{
						$familia = trim($transaccion->student->parentsandguardian->family)." (".trim($transaccion->student->parentsandguardian->surname)." ".trim($transaccion->student->parentsandguardian->first_name).")";
		
						$detalle_morosos[$transaccion->student->parentsandguardian->id] = $vector_morosidad;
						$detalle_morosos[$transaccion->student->parentsandguardian->id]["Familia"] = $familia;
						$detalle_morosos[$transaccion->student->parentsandguardian->id]["Teléfono"] = $transaccion->student->parentsandguardian->cell_phone;

						$id_representante_anterior = $transaccion->student->parentsandguardian->id;
					}

					if (substr($transaccion->transaction_description, 0, 3) == 'Mat' || substr($transaccion->transaction_description, 0, 3) == 'Ago')
					{
						$detalle_morosos[$transaccion->student->parentsandguardian->id]['Dif'] += $saldo_cuota; 
						$totales_morosidad['Dif'] += $saldo_cuota; 
					}
					elseif ($transaccion->transaction_type ==  'Servicio educativo')
					{
						$detalle_morosos[$transaccion->student->parentsandguardian->id]['SE'] += $saldo_cuota; 
						$totales_morosidad['SE'] += $saldo_cuota; 
					}
					elseif ($transaccion->transaction_type ==  'Seguro escolar')
					{
						$detalle_morosos[$transaccion->student->parentsandguardian->id]['Seg'] += $saldo_cuota; 
						$totales_morosidad['Seg'] += $saldo_cuota; 
					}
					elseif ($transaccion->transaction_type ==  'Mensualidad')
					{
						$detalle_morosos[$transaccion->student->parentsandguardian->id][substr($transaccion->transaction_description, 0, 3)] += $saldo_cuota; 
						$totales_morosidad[substr($transaccion->transaction_description, 0, 3)] += $saldo_cuota; 
					}
					$detalle_morosos[$transaccion->student->parentsandguardian->id]["Total $"] += $saldo_cuota; 
					$totales_morosidad["Total $"] += $saldo_cuota; 
				}
			} 
		}

		// Si se requiere mostrar la deuda de Consejo Educativo, se añaden al vector $detalles_morososos los representantes que tienen el Consejo Educativo pendiente de pago y se actualizan las variables de totales

		if ($consejo_educativo == 'Sí')
		{
			$vectorConsejo = $this->vectorConsejoEducativo($anio, $anioEscolarActual, $periodo_escolar, $total_cuotas_periodo, $detalle_morosos, $vector_morosidad, $totales_morosidad);

			$total_cuotas_periodo = $vectorConsejo['total_cuotas_periodo'];
			$detalle_morosos = $vectorConsejo['detalle_morosos'];
			$totales_morosidad = $vectorConsejo['totales_morosidad'];
		}
								
		$this->set(compact('mes', 'periodo_escolar', 'tipo_reporte', 'telefono', 'currentDate', 'school', 'dollarExchangeRate', 'mes_anio_desde', 'mes_anio_hasta', 'nombre_mes_reporte', 'anio_correspondiente_mes', 'detalle_morosos', 'total_cuotas_periodo', 'totales_morosidad', 'vector_cuotas'));
	}

	public function saldoCuotas($mes = null, $anio = null, $periodo_escolar = null, $indicador_recalculo = null, $transacciones = null, $anio_mes_dia_hasta = null, $anio_mes_dia_agosto = null)
	{	
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

		$this->verificarAnioUltimaInscripcion(); 

		$vector_cuotas = [];
               
        $currentDate = Time::now();
	
		if ($currentDate->month < 10)
		{
			$mes_actual = "0".$currentDate->month; 
		}
		else
		{
			$mes_actual = $currentDate->month; 
		}

		$anio_mes_actual = $currentDate->year.$mes_actual;

		$this->loadModel('Schools');
		$school = $this->Schools->get(2);
		$anio_escolar_actual = $school->current_school_year;

		$anio_mes_cuota = "";

		$anio_mes_recalculo_cuotas_atrasadas = "202209";
		
		$controlador_estudiantes = new StudentsController();
        			
		$mesesTarifas = $controlador_estudiantes->mesesTarifas(0);
		$otrasTarifas = $controlador_estudiantes->otrasTarifas(0);

		$descuentosRecargosEspeciales =
			[
				'Ago 2025' => -10
			];

		$anio = substr($periodo_escolar, 0, 4);

		$vectorEstudiantesInscritos = $this->vectorEstudiantesInscritos($anio);

		$monto_cuota = 0;
		$saldo_cuota = 0;

		foreach ($transacciones as $transaccion)
		{
			if (isset($vectorEstudiantesInscritos[$transaccion->student->id]))
			{
				$anio_transaccion = $transaccion->payment_date->year;
				$mes_transaccion = $transaccion->payment_date->month;

				if ($transaccion->transaction_type == 'Matrícula' || $transaccion->transaction_type == 'Servicio educativo' || $transaccion->transaction_type == 'Seguro escolar')
				{
					$anio_transaccion = $anio;
					$mes_transaccion = '00';
				}
				elseif ($mes_transaccion < 10)
				{
					$mes_transaccion = "0".$mes_transaccion;
				}

				$anio_mes_dia_transaccion = $anio_transaccion.$mes_transaccion.'01';
				$anio_mes_transaccion = $anio_transaccion.$mes_transaccion;
				$anio_mes_cuota = $anio_mes_transaccion; 

				if ($anio_mes_dia_transaccion <= $anio_mes_dia_hasta || $anio_mes_dia_transaccion == $anio_mes_dia_agosto)
				{
					$incluir = 'Sí';
					if ($transaccion->transaction_type == 'Matrícula' || substr($transaccion->transaction_description, 0, 3) == 'Ago')
					{
						if ($transaccion->student->section->orden > 41)
						{
							$incluir = 'No';
						}
					}
					elseif ($transaccion->transaction_type == 'Mensualidad' || substr($transaccion->transaction_description, 0, 3) != 'Ago')
					{
						if ($anio == $anio_escolar_actual)
						{
							if ($transaccion->student->discount == 100)
							{
								$incluir = 'No';
							}
						}
						else
						{
							if ($transaccion->student->descuento_ano_anterior == 100)
							{
								$indicadorBecado = 'No';
							}
						}
					}

					if ($incluir == 'Sí')
					{
						$monto_cuota = 0;
						$monto_neto_cuota = 0;
						$saldo_cuota = 0;
						$monto_descuento_pronto_pago = 0;

						if ($transaccion->transaction_type == 'Matrícula' || $transaccion->transaction_type == 'Seguro escolar' ||substr($transaccion->transaction_description, 0, 3) == 'Ago')
						{
							foreach ($otrasTarifas as $otras)
							{				
								if ($otras['conceptoAno'] == $transaccion->transaction_description)
								{
									if (isset($descuentosRecargosEspeciales[$transaccion->transaction_description]))
									{
										$monto_cuota = $otras['tarifaDolar'] + $descuentosRecargosEspeciales[$transaccion->transaction_description];
									}
									else
									{
										$monto_cuota = $otras['tarifaDolar'];
									}
									break;
								}
							}
						}
						elseif ($transaccion->transaction_type == 'Servicio educativo')
						{
							$monto_cuota = $transaccion->amount;	
						}
						else
						{
							if ($indicador_recalculo == 'Sí' && $anio_mes_transaccion >= $anio_mes_recalculo_cuotas_atrasadas && $anio_mes_transaccion < $anio_mes_actual && $transaccion->paid_out == 0)
							{
								$anio_mes_cuota = $anio_mes_actual;
							}
							elseif ($indicador_recalculo == 'No' && $anio_transaccion < $anio_escolar_actual && $transaccion->paid_out == 0)
							{
								$anio_mes_cuota = $anio_escolar_actual.'07';
							}

							foreach ($mesesTarifas as $mesesTarifa)
							{
								if ($mesesTarifa["anoMes"] == $anio_mes_cuota)
								{
									if ($transaccion->amount_dollar == 0)
									{
										$monto_cuota = round(($mesesTarifa["tarifaDolar"] * (100 - $transaccion->student->discount)) / 100, 2);
									}
									else
									{
										$monto_cuota = round(($mesesTarifa["tarifaDolar"] * (100 - $transaccion->porcentaje_descuento)) / 100, 2);
									}
									break;
								}
							}
						}
				
						if ($transaccion->transaction_type != 'Servicio educativo' && $monto_cuota == 0)
						{
							$this->Flash->error(__('No se encontraron la tarifa para la cuota con el id: '.$transaccion->id));
							return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
						}

						$monto_neto_cuota = $monto_cuota;

						if ($transaccion->paid_out == 0)
						{													
							$saldo_cuota = round($monto_neto_cuota - $transaccion->amount_dollar, 2);
						}
						else
						{
							if ($transaccion->transaction_type == 'Matrícula' || $transaccion->transaction_type == 'Servicio educativo' || $transaccion->transaction_type == 'Seguro escolar' || substr($transaccion->transaction_description, 0, 3) == 'Ago')
							{
								$saldo_cuota = round($monto_neto_cuota - $transaccion->amount_dollar, 2);
							}
							else
							{
								$descuento_por_ajuste = round($transaccion->original_amount - $transaccion->amount, 2);
								$cuota_menos_descuento_por_ajuste = round($monto_cuota - $descuento_por_ajuste, 2); 

								if ($cuota_menos_descuento_por_ajuste > $transaccion->amount_dollar)
								{
									$monto_descuento_pronto_pago = $this->tarifaProntoPagoCuota($anio_mes_transaccion); 
									$monto_neto_cuota = round($cuota_menos_descuento_por_ajuste - $monto_descuento_pronto_pago, 2);
									$saldo_cuota = round($monto_neto_cuota - $transaccion->amount_dollar, 2);
								}
							}
						}

						$vector_cuotas[$transaccion->id] = ["id_estudiante" => $transaccion->student_id, "transaction_description" => $transaccion->transaction_description, "monto_cuota" => $monto_neto_cuota, "saldo_cuota" => $saldo_cuota];
					}
				}
			}
		}
		return $vector_cuotas;
	}

	public function consejoEducativoPorCobrar ()
	{
		$this->loadModel('Schools');
		$school = $this->Schools->get(2);
		$anioEscolarAnterior = $school->current_school_year - 1;
		$anioEscolarActual = $school->current_school_year;
		$proximoAnioEscolar = $school->current_school_year + 1;

        $periodoEscolarAnterior = $anioEscolarAnterior.'-'.$anioEscolarActual;
		$periodoEscolarActual = $anioEscolarActual.'-'.$proximoAnioEscolar;
	
		if ($this->request->is('post'))
	    {
			setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
			date_default_timezone_set('America/Caracas');
			$currentDate = Time::now();

			$periodo_escolar = $_POST['periodo_escolar'];
			$anio = substr($periodo_escolar, 0, 4);
			$telefono = $_POST['telefono'];
			$detalle_morosos = [];
			$total_cuotas_periodo = 0;
			$vector_morosidad = 
				[
					"Familia" => "",
			 		"CE" => 0,
			 		"Total $" => 0,
			 		"Teléfono" => ""
				];

			$totales_morosidad = 
				[
				 "CE" => 0,
				 "Total $" => 0
				];

			$vectorConsejo = $this->vectorConsejoEducativo($anio, $anioEscolarActual, $periodo_escolar, $total_cuotas_periodo, $detalle_morosos, $vector_morosidad, $totales_morosidad);

			$total_cuotas_periodo = $vectorConsejo['total_cuotas_periodo'];
			$detalle_morosos = $vectorConsejo['detalle_morosos'];
			$totales_morosidad = $vectorConsejo['totales_morosidad'];

			$this->set(compact('anio', 'periodo_escolar', 'telefono', 'currentDate', 'school', 'detalle_morosos', 'total_cuotas_periodo', 'totales_morosidad'));
		}
		else
		{
			$this->set(compact('periodoEscolarAnterior', 'periodoEscolarActual'));
		}
	}

	public function vectorConsejoEducativo($anio = null, $anioEscolarActual = null, $periodo_escolar = null, $total_cuotas_periodo = null, $detalle_morosos = null, $vector_morosidad = null, $totales_morosidad = null)
	{
		$this->loadModel('Rates');
		$tarifaConsejoEducativo = 0;
		$tarifas = $this->Rates->find('all')
			->where(["Concept" => "Consejo Educativo", "rate_year" => $anio])
			->order(['id' => 'DESC']);;

		if ($tarifas->count() > 0)
		{
			$primerRegistroEncontrado = $tarifas->first();
			$tarifaConsejoEducativo = $primerRegistroEncontrado->amount;
		}

		if ($anio < $anioEscolarActual)
		{
			$matriculas_estudiantes = $this->Studenttransactions->find('all')
			->contain(['Students' => ['Parentsandguardians', 'Sections']])
			->where(['Studenttransactions.invoiced' => 0, 'Studenttransactions.transaction_description' => 'Matrícula '.$anio, 'Students.balance >=' => $anio, 'Parentsandguardians.estatus_registro' => 'Activo']);
		}
		else
		{
			$matriculas_estudiantes = $this->Studenttransactions->find('all')
			->contain(['Students' => ['Parentsandguardians', 'Sections']])
			->where(['Studenttransactions.invoiced' => 0, 'Studenttransactions.transaction_description' => 'Matrícula '.$anio, 'Students.balance' => $anio, 'Students.student_condition' => 'Regular', 'Parentsandguardians.estatus_registro' => 'Activo']);
		}
		
		if ($matriculas_estudiantes->count() == 0)
		{
			$this->Flash->error(__('No se encontraron matrículas de estudiante'));		
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
		}

		$vectorRecibosConsejoEducativo = [];
		$conceptoConsejoEducativo = "Consejo Educativo ".$periodo_escolar;
		$this->loadModel('Concepts');

		$recibosConsejoEducativo = $this->Concepts->find()
			->contain(['Bills'])
			->where(['Bills.annulled' => false,
				'Concepts.concept' => $conceptoConsejoEducativo])
			->order(['Bills.parentsandguardian_id' => 'ASC']);

		if ($recibosConsejoEducativo->count() > 0)
		{
			foreach ($recibosConsejoEducativo as $recibo)
			{
				$vectorRecibosConsejoEducativo[$recibo->bill->parentsandguardian_id] = $recibo->bill->bill_number; 
			}
		}

		$idsFamiliasConsejoVerificadas = [];
		foreach ($matriculas_estudiantes as $matricula)
		{
			if (!(isset($idsFamiliasConsejoVerificadas[$matricula->student->parentsandguardian->id])))
			{
				if (isset($vectorRecibosConsejoEducativo[$matricula->student->parentsandguardian->id]))
				{
					$total_cuotas_periodo += $tarifaConsejoEducativo;
				}
				else
				{
					$indicadorRegistrar = 0;
					if ($anio < $anioEscolarActual)
					{
						if ($matricula->student->parentsandguardian->id_familia_pagadora_consejo_anterior == 0)
						{
							if ($matricula->student->parentsandguardian->consejo_exonerado_anterior == 0)
							{
								$indicadorRegistrar = 1;
							}
						}
					}
					else
					{
						if ($matricula->student->parentsandguardian->id_familia_pagadora_consejo == 0)
						{
							if ($matricula->student->parentsandguardian->consejo_exonerado == 0)
							{
									$indicadorRegistrar = 1;
							}
						}
					}
					if ($indicadorRegistrar == 1)
					{
						if (!isset($detalle_morosos[$matricula->student->parentsandguardian->id]))
						{
							$familia = trim($matricula->student->parentsandguardian->family)." (".trim($matricula->student->parentsandguardian->surname)." ".trim($matricula->student->parentsandguardian->first_name).")";

							$detalle_morosos[$matricula->student->parentsandguardian->id] = $vector_morosidad;
							$detalle_morosos[$matricula->student->parentsandguardian->id]["Familia"] = $familia;
							$detalle_morosos[$matricula->student->parentsandguardian->id]["Teléfono"] = $matricula->student->parentsandguardian->cell_phone;
						}

						$total_cuotas_periodo += $tarifaConsejoEducativo;
						$detalle_morosos[$matricula->student->parentsandguardian->id]["CE"] = $tarifaConsejoEducativo;
						$detalle_morosos[$matricula->student->parentsandguardian->id]["Total $"] += $tarifaConsejoEducativo; 
						$totales_morosidad['CE'] += $tarifaConsejoEducativo;
						$totales_morosidad["Total $"] += $tarifaConsejoEducativo; 
					}
				}
				$idsFamiliasConsejoVerificadas[$matricula->student->parentsandguardian->id] = $tarifaConsejoEducativo;
			}
		}
		$vectorConsejo =
			[
				'total_cuotas_periodo' => $total_cuotas_periodo,
				'detalle_morosos' => $detalle_morosos,
				'totales_morosidad' => $totales_morosidad
			];
		return $vectorConsejo;
	}
	
	public function familiasDiferenciasMensualidadesAdelantadas()
    {	
		if ($this->request->is('post')) 
        {
			return $this->redirect(['controller' => 'Studenttransactions', 'action' => 'reporteFamiliasDiferenciasMensualidadesAdelantadas', $_POST["mes"]]);
        }
	}

	public function reporteFamiliasDiferenciasMensualidadesAdelantadas($mes = null)
	{		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
               
        $currentDate = Time::now();
				
		if ($currentDate->month < 10)
		{
			$mes_actual = "0".$currentDate->month; 
		}
		else
		{
			$mes_actual = $currentDate->month; 
		}

		$anio_mes_actual = $currentDate->year.$mes_actual;

		$anio_mes_cuota = "";

		$anio_mes_recalculo_cuotas_atrasadas = "202209";
		
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
				
		$this->loadModel('Monedas');	
		$moneda = $this->Monedas->get(2);
		$dollarExchangeRate = $moneda->tasa_cambio_dolar; 

		$controlador_estudiantes = new StudentsController();
        			
		$mesesTarifas = $controlador_estudiantes->mesesTarifas(0);

		$mes_numero_nombre =
			[
				"09" => "Septiembre",
				"10" => "Octubre",
				"11" => "Noviembre",
				"12" => "Diciembre",
				"01" => "Enero",
				"02" => "Febrero",
				"03" => "Marzo",
				"04" => "Abril",
				"05" => "Mayo",
				"06" => "Junio", 
				"07" => "Julio", 
			];

		$nombre_mes_reporte = $mes_numero_nombre[$mes];

		$mes_ubicacion_anio = 
			[
				"09" => 0,
				"10" => 0,
				"11" => 0,
				"12" => 0,
				"01" => 1,
				"02" => 1,
				"03" => 1,
				"04" => 1,
				"05" => 1,
				"06" => 1,
				"07" => 1
			];

		$anio = $school->current_school_year;

		$anio_correspondiente_mes = $anio + $mes_ubicacion_anio[$mes];
														
		$anio_mes_dia_hasta = $anio_correspondiente_mes."-".$mes."-01";

		$mes_anio_hasta = $mes."/".$anio_correspondiente_mes;

		$total_cuotas_periodo = 0;
								
		$detalle_morosos = [];

		$vector_morosidad = 
			["Familia" => "",
			 "Sep" => 0,
			 "Oct" => 0,
			 "Nov" => 0,
			 "Dic" => 0,
			 "Ene" => 0,
			 "Feb" => 0,
			 "Mar" => 0,
			 "Abr" => 0,
			 "May" => 0,
			 "Jun" => 0,
			 "Jul" => 0,
			 "Total $" => 0,
			 "Teléfono" => ""];

		$total_morosos = 0;

		$id_representante_anterior = 0;
		$indice_vector = "";

		$contador_transacciones = 0;

		$transacciones_estudiantes = $this->Studenttransactions->find('all')
		->contain(['Students' => ['Parentsandguardians']])
		->where(['Studenttransactions.invoiced' => 0, 'Studenttransactions.transaction_type' => 'Mensualidad', 'Studenttransactions.ano_escolar' => $anio, 'Studenttransactions.payment_date' => $anio_mes_dia_hasta, 'SUBSTRING(Studenttransactions.transaction_description, 1, 3) !=' => 'Ago',  'Studenttransactions.paid_out' => 1, 'Students.student_condition' => 'Regular', 'Students.balance' => $anio, 'Students.scholarship' => 0])
		->order(['Parentsandguardians.family' => 'ASC', 'Parentsandguardians.surname' => 'ASC', 'Parentsandguardians.first_name' => 'ASC', 'Parentsandguardians.id' => 'ASC', 'Studenttransactions.payment_date' => 'ASC']);
		
		if ($transacciones_estudiantes->count() == 0)
		{
			$this->Flash->error(__('No se encontraron mensualidades adelantadas'));		
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
		}
				
		foreach ($transacciones_estudiantes as $transaccion)
		{
			$monto_descuento_pronto_pago = 0; 
			$contador_transacciones++;
			$anio_transaccion = $transaccion->payment_date->year;
			$mes_transaccion = $transaccion->payment_date->month;

			if ($mes_transaccion < 10)
			{
				$mes_transaccion = "0".$mes_transaccion;
			}

			$anio_mes_transaccion = $anio_transaccion.$mes_transaccion;

			if ($anio_mes_transaccion >= $anio_mes_recalculo_cuotas_atrasadas && $anio_mes_transaccion < $anio_mes_actual && $transaccion->paid_out == 0)
			{
				$anio_mes_cuota = $anio_mes_actual;
			}
			else
			{
				$anio_mes_cuota = $anio_mes_transaccion;
			}

			$monto_cuota = 0;

			foreach ($mesesTarifas as $mesesTarifa)
			{
				if ($mesesTarifa["anoMes"] == $anio_mes_cuota)
				{
					$monto_cuota = round(($mesesTarifa["tarifaDolar"] * (100 - $transaccion->porcentaje_descuento)) / 100, 2);
					break;
				}
			}
		
			if ($monto_cuota == 0)
			{
				$this->Flash->error(__('No se encontraron la tarifa para la mensualidad '.$anio_mes_cuota));
				return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
			}

			$total_cuotas_periodo += $monto_cuota;

			$saldo_cuota = 0;

			$descuento_por_ajuste = round($transaccion->original_amount - $transaccion->amount, 2);
			$cuota_menos_descuento_por_ajuste = round($monto_cuota - $descuento_por_ajuste, 2); 

			if ($cuota_menos_descuento_por_ajuste > $transaccion->amount_dollar)
			{
				if ($transaccion->paid_out == 1)
				{
					$monto_descuento_pronto_pago = $this->tarifaProntoPagoCuota($anio_mes_transaccion); 
				}
				$saldo_cuota = round($cuota_menos_descuento_por_ajuste - $transaccion->amount_dollar + $monto_descuento_pronto_pago, 2); 
			}
			
			if ($saldo_cuota > 0)
			{
				if ($id_representante_anterior != $transaccion->student->parentsandguardian->id)
				{
					$familia = trim($transaccion->student->parentsandguardian->family)." (".trim($transaccion->student->parentsandguardian->surname)." ".trim($transaccion->student->parentsandguardian->first_name).")";

					$detalle_morosos[$transaccion->student->parentsandguardian->id] = $vector_morosidad;
					$detalle_morosos[$transaccion->student->parentsandguardian->id]["Familia"] = $familia;
					$detalle_morosos[$transaccion->student->parentsandguardian->id]["Teléfono"] = $transaccion->student->parentsandguardian->cell_phone;
					$id_representante_anterior = $transaccion->student->parentsandguardian->id;
				}
				
				$detalle_morosos[$transaccion->student->parentsandguardian->id][substr($transaccion->transaction_description, 0, 3)] = $saldo_cuota; 
				$detalle_morosos[$transaccion->student->parentsandguardian->id]["Total $"] += $saldo_cuota; 

				$total_morosos += $saldo_cuota;
			}
		}
					
		$this->set(compact('school', 'currentDate', 'dollarExchangeRate', 'mes', 'mes_anio_hasta', 'nombre_mes_reporte', 'anio_correspondiente_mes', 'detalle_morosos', 'total_cuotas_periodo', 'total_morosos'));
	}

	public function agregarCuotaSeguro()
	{
		$this->loadModel('Schools');
		$schools = $this->Schools->get(2);
        $actual_anio_inscripcion = $schools->current_year_registration;
		$transacciones_agregadas = [];

		$estudiantes_nuevos = $this->Studenttransactions->Students->find('all')
		->where(['Students.student_condition' => 'Regular', 'Students.	new_student' => 1]);

		$contador_estudiantes_nuevos = $estudiantes_nuevos->count();

		$this->Flash->success(__('Cantidad de estudiantes nuevos '.$contador_estudiantes_nuevos));

		foreach ($estudiantes_nuevos as $estudiante)
		{
			if ($estudiante->created->year == $actual_anio_inscripcion)
			{
				$studenttransaction = $this->Studenttransactions->newEntity();
				
				$studenttransaction->student_id = $estudiante->id;
				$studenttransaction->amount = 0;
				$studenttransaction->original_amount = 0;
				$studenttransaction->invoiced = 0;
				$studenttransaction->paid_out = 0;
				$studenttransaction->partial_payment = 0;
				$studenttransaction->bill_number = 0;
				$studenttransaction->payment_date = 0;
				$studenttransaction->transaction_migration = 0;
				$studenttransaction->amount_dollar = 0;
				$studenttransaction->ano_escolar = $actual_anio_inscripcion;
				$studenttransaction->porcentaje_descuento = 0;

				$studenttransaction->transaction_type = 'Seguro escolar';
				$studenttransaction->transaction_description = 'Seguro escolar' . ' ' . $actual_anio_inscripcion;
				
				// if ($this->Studenttransactions->save($studenttransaction))
				// {
					$transacciones_agregadas[] =
						[
							'estudiante' => $estudiante->full_name,
							'id' => $estudiante->id
						];
				/* }
				else
				{
					$this->Flash->error(__('La transacción para el estudiante '.$estudiante->full_name.' no se pudo registrar'));
				} */		
			}
		}
		$this->set(compact('transacciones_agregadas'));
	}

	public function cuentasCobradasPorCobrar()
    {	
		if ($this->request->is('post')) 
        {
			return $this->redirect(['controller' => 'Studenttransactions', 'action' => 'reporteCuentasCobradasPorCobrar', $_POST["tipo_reporte"],  $_POST["concepto"]]);
        }
	}

	public function reporteCuentasCobradasPorCobrar($tipo_reporte = null, $concepto = null)
	{	
		$this->verificarAnioUltimaInscripcion();
		$this->verificarDescuentoBecados();
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

		$currentDate = Time::now();

		if ($currentDate->month < 10)
		{
			$mes_actual = "0".$currentDate->month; 
		}
		else
		{
			$mes_actual = $currentDate->month; 
		}
		
		$anio_mes_actual = $currentDate->year.$mes_actual;

		$anio_mes_cuota = "";

		$anio_mes_recalculo_cuotas_atrasadas = "202209";
		
		$controlador_estudiantes = new StudentsController();
        			
		$mesesTarifas = $controlador_estudiantes->mesesTarifas(0);
		$otrasTarifas = $controlador_estudiantes->otrasTarifas(0);
               					
		$this->loadModel('Monedas');	
		$moneda = $this->Monedas->get(2);
		$dollarExchangeRate = $moneda->tasa_cambio_dolar; 

		$numero_concepto =
			[
				"13" => "Matrícula",
				"14" => "Seguro escolar",
				"15" => "Servicio educativo",
				"09" => "Septiembre",
				"10" => "Octubre",
				"11" => "Noviembre",
				"12" => "Diciembre",
				"01" => "Enero",
				"02" => "Febrero",
				"03" => "Marzo",
				"04" => "Abril",
				"05" => "Mayo",
				"06" => "Junio", 
				"07" => "Julio", 
				"08" => "Agosto"
			];

		$numero_concepto_abreviado =
			[
				"13" => "Matrícula",
				"14" => "Seguro escolar",
				"15" => "Servicio educativo",
				"09" => "Sep",
				"10" => "Oct",
				"11" => "Nov",
				"12" => "Dic",
				"01" => "Ene",
				"02" => "Feb",
				"03" => "Mar",
				"04" => "Abr",
				"05" => "May",
				"06" => "Jun", 
				"07" => "Jul", 
				"08" => "Ago"
			];

		$nombre_concepto = $numero_concepto[$concepto];
		$nombre_concepto_abreviado = $numero_concepto_abreviado[$concepto];

		if ($concepto == "13" || $concepto == "14" || $concepto == "15" || $concepto == "08")
		{
			$indicadorConceptos = "Inscripcion";
		}
		else
		{
			$indicadorConceptos = "Mensualidades";
		}

		$concepto_ubicacion_anio = 
			[
				"13" => 0,
				"14" => 0,
				"15" => 0,
				"09" => 0,
				"10" => 0,
				"11" => 0,
				"12" => 0,
				"01" => 1,
				"02" => 1,
				"03" => 1,
				"04" => 1,
				"05" => 1,
				"06" => 1,
				"07" => 1,
				"08" => 1
			];

		$this->loadModel('Schools');
		$school = $this->Schools->get(2);
		$anio = $school->current_school_year;
		$proximoAnioEscolar = $anio + 1;
		$actualAnioInscripcion = $school->current_year_registration;
		$anioInscripcion = $anio == $actualAnioInscripcion ? "Students.balance" : "Students.balance >="; 
		$periodoEscolar = "Año escolar ".$anio."-".$proximoAnioEscolar;
		$vectorCuotasProntoPago = $this->vectorCuotasProntoPago($periodoEscolar);

		$anio_correspondiente_concepto = $anio + $concepto_ubicacion_anio[$concepto];
														
		$concepto_anio = $nombre_concepto." ".$anio_correspondiente_concepto;

		$concepto_anio_abreviado = $nombre_concepto_abreviado." ".$anio_correspondiente_concepto;

		$vector_cuotas;

		$contador_transacciones = 0;

		if ($tipo_reporte == "Totales generales")
		{
			$orden_reporte = ['Students.discount' => 'ASC'];
		}
		elseif ($tipo_reporte == "Por grado")
		{
			$orden_reporte = ['Sections.orden' => 'ASC', 'Students.discount' => 'ASC'];
		}
		else
		{
			$orden_reporte = ['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC',];
		}

		$nivel_estudios_posicion =
			[
				"No asignado" => 1,
				"Maternal" => 2,
				"Pre-escolar" => 3,
				"Primaria" => 4,
				"Secundaria" => 5
			];

		$transacciones_estudiantes = $this->Studenttransactions->find('all')
		->contain(['Students' => ['Sections']])
		->where(['Studenttransactions.invoiced' => 0, 'Studenttransactions.ano_escolar' => $anio, 'transaction_description' => $concepto_anio_abreviado, 'Students.student_condition' => 'Regular', $anioInscripcion => $anio])
		->order($orden_reporte);
		
		if ($transacciones_estudiantes->count() == 0)
		{
			$this->Flash->error(__('No se encontraron cuotas'));		
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
		}

		foreach ($transacciones_estudiantes as $transaccion)
		{
			$monto_cuota = 0;
			$cobrado_completo = 0;
			$abono = 0;
			$monto_descuento_pronto_pago = 0;
			$por_cobrar_cuota = 0;

			if ($transaccion->transaction_type == "Matrícula" || $transaccion->transaction_type == "Seguro escolar" || substr($transaccion->transaction_description, 0, 3) == "Ago")
			{
				foreach ($otrasTarifas as $otras)
				{				
					if ($otras['conceptoAno'] == $transaccion->transaction_description)
					{
						$monto_cuota = $otras['tarifaDolar'];
						break;
					}
				}
				if ($transaccion->paid_out == 0)
				{
					$abono = $transaccion->amount_dollar;													
					$por_cobrar_cuota = round($monto_cuota - $transaccion->amount_dollar, 2);
				}
				else
				{
					if ($monto_cuota > $transaccion->amount_dollar)
					{
						$abono = $transaccion->amount_dollar;
						$por_cobrar_cuota = round($monto_cuota - $transaccion->amount_dollar, 2);
					}
					else
					{
						$cobrado_completo = $transaccion->amount_dollar;
					}
				}
			}
			elseif ($transaccion->transaction_type == "Servicio educativo")
			{
				$monto_cuota = $transaccion->amount;
				if ($monto_cuota > $transaccion->amount_dollar)
				{
					$abono = $transaccion->amount_dollar;
				}
				else
				{
					$cobrado_completo = $transaccion->amount_dollar;
				}
				$por_cobrar_cuota = round($monto_cuota - $transaccion->amount_dollar, 2);
			}
			elseif ($transaccion->transaction_type == "Mensualidad" && $transaccion->student->scholarship == 0)
			{	
				$monto_descuento_pronto_pago_anticipado = 0;
				$monto_descuento_pronto_pago = 0;

				$anio_transaccion = $transaccion->payment_date->year;
				$mes_transaccion = $transaccion->payment_date->month;

				if ($mes_transaccion < 10)
				{
					$mes_transaccion = "0".$mes_transaccion;
				}

				$anio_mes_transaccion = $anio_transaccion.$mes_transaccion;

				if ($anio_mes_transaccion >= $anio_mes_recalculo_cuotas_atrasadas && $anio_mes_transaccion < $anio_mes_actual && $transaccion->paid_out == 0)
				{
					$anio_mes_cuota = $anio_mes_actual;
				}
				else
				{
					$anio_mes_cuota = $anio_mes_transaccion;
				}

				foreach ($mesesTarifas as $mesesTarifa)
				{
					if ($mesesTarifa["anoMes"] == $anio_mes_cuota)
					{
						$monto_cuota = round(($mesesTarifa["tarifaDolar"] * (100 - $transaccion->student->discount)) / 100, 2);
						break;
					}
				}
			
				if ($monto_cuota == 0)
				{
					$this->Flash->error(__('No se encontró la tarifa para la cuota '.$anio_mes_cuota));
					return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
				}

				if ($transaccion->paid_out == 0)
				{
					$abono = $transaccion->amount_dollar;													
					$por_cobrar_cuota = round($monto_cuota - $transaccion->amount_dollar, 2);
				}
				else
				{
					$descuento_por_ajuste = round($transaccion->original_amount - $transaccion->amount, 2);
					$cuota_menos_descuento_por_ajuste = round($monto_cuota - $descuento_por_ajuste, 2); 

					if ($cuota_menos_descuento_por_ajuste > $transaccion->amount_dollar)
					{
						$monto_descuento_pronto_pago_anticipado = $this->tarifaProntoPagoCuota($anio_mes_transaccion); 
						$monto_cuota = $cuota_menos_descuento_por_ajuste;
						$abono = round($transaccion->amount_dollar - $monto_descuento_pronto_pago_anticipado, 2);
						$por_cobrar_cuota = round($monto_cuota - $transaccion->amount_dollar + $monto_descuento_pronto_pago_anticipado, 2);
					}
					else
					{
						if (isset($vectorCuotasProntoPago[$transaccion->id]))
						{
							$monto_descuento_pronto_pago = $vectorCuotasProntoPago[$transaccion->id];
							$cobrado_completo = round($monto_cuota - $monto_descuento_pronto_pago, 2);
						}
						else
						{
							$cobrado_completo = $monto_cuota;
						}
					}
				}
			}

			if ($por_cobrar_cuota == 0)
			{
				$indicador_que_pagaron = 1;
				$indicador_por_pagar = 0;
			}
			else
			{
				$indicador_que_pagaron = 0;
				$indicador_por_pagar = 1;
			}

			if ($tipo_reporte == "Totales generales")
			{
				if ($indicadorConceptos == "Inscripcion")
				{
					$indice_nivel = 0;
					$indice_beca = 0;
					if (isset($vector_cuotas[$indice_nivel][$indice_beca]))
					{
						$vector_cuotas[$indice_nivel][$indice_beca]["cantidad_estudiantes"]++;
						$vector_cuotas[$indice_nivel][$indice_beca]["que_pagaron"] += $indicador_que_pagaron;
						$vector_cuotas[$indice_nivel][$indice_beca]["por_pagar"] += $indicador_por_pagar;
						$vector_cuotas[$indice_nivel][$indice_beca]["monto_cuota"] += $monto_cuota;
						$vector_cuotas[$indice_nivel][$indice_beca]["cobrado_completo"] += $cobrado_completo;
						$vector_cuotas[$indice_nivel][$indice_beca]["abono"] += $abono;
						$vector_cuotas[$indice_nivel][$indice_beca]["pronto_pago"] += $monto_descuento_pronto_pago;
						$vector_cuotas[$indice_nivel][$indice_beca]["por_cobrar_cuota"] += $por_cobrar_cuota;						
					}
					else
					{
						$vector_cuotas[$indice_nivel][$indice_beca] = 
							[
								"nombre_estudiante" => "",
								"nivel_estudios" => "General",
								"grado" => "",
								"porcentaje_descuento" => 0,
								"cantidad_estudiantes" => 1,
								"que_pagaron" => $indicador_que_pagaron,
								"por_pagar" => $indicador_por_pagar,
								"monto_cuota" => $monto_cuota, 
								"cobrado_completo" => $cobrado_completo,
								"abono" => $abono,
								"pronto_pago" => $monto_descuento_pronto_pago,  
								"por_cobrar_cuota" => $por_cobrar_cuota, 		
							];
					}

					$indice_nivel = $nivel_estudios_posicion[$transaccion->student->section->level];
					
					if (isset($vector_cuotas[$indice_nivel][$indice_beca]))
					{
						$vector_cuotas[$indice_nivel][$indice_beca]["cantidad_estudiantes"]++;
						$vector_cuotas[$indice_nivel][$indice_beca]["que_pagaron"] += $indicador_que_pagaron;
						$vector_cuotas[$indice_nivel][$indice_beca]["por_pagar"] += $indicador_por_pagar;
						$vector_cuotas[$indice_nivel][$indice_beca]["monto_cuota"] += $monto_cuota;
						$vector_cuotas[$indice_nivel][$indice_beca]["cobrado_completo"] += $cobrado_completo;
						$vector_cuotas[$indice_nivel][$indice_beca]["abono"] += $abono;
						$vector_cuotas[$indice_nivel][$indice_beca]["pronto_pago"] += $monto_descuento_pronto_pago;
						$vector_cuotas[$indice_nivel][$indice_beca]["por_cobrar_cuota"] += $por_cobrar_cuota;						
					}
					else
					{
						$vector_cuotas[$indice_nivel][$indice_beca] = 
							[
								"nombre_estudiante" => "",
								"nivel_estudios" => $transaccion->student->section->level,
								"grado" => "",
								"porcentaje_descuento" => 0,
								"cantidad_estudiantes" => 1,
								"que_pagaron" => $indicador_que_pagaron,
								"por_pagar" => $indicador_por_pagar,
								"monto_cuota" => $monto_cuota, 
								"cobrado_completo" => $cobrado_completo,
								"abono" => $abono,
								"pronto_pago" => $monto_descuento_pronto_pago,  
								"por_cobrar_cuota" => $por_cobrar_cuota, 		
							];
					}
				}
				else
				{
					$indice_nivel = 0;
					$indice_beca = $transaccion->student->discount;

					if (isset($vector_cuotas[$indice_nivel][$indice_beca]))
					{
						$vector_cuotas[$indice_nivel][$indice_beca]["cantidad_estudiantes"]++;
						$vector_cuotas[$indice_nivel][$indice_beca]["que_pagaron"] += $indicador_que_pagaron;
						$vector_cuotas[$indice_nivel][$indice_beca]["por_pagar"] += $indicador_por_pagar;
						$vector_cuotas[$indice_nivel][$indice_beca]["monto_cuota"] += $monto_cuota;
						$vector_cuotas[$indice_nivel][$indice_beca]["cobrado_completo"] += $cobrado_completo;
						$vector_cuotas[$indice_nivel][$indice_beca]["abono"] += $abono;
						$vector_cuotas[$indice_nivel][$indice_beca]["pronto_pago"] += $monto_descuento_pronto_pago;  
						$vector_cuotas[$indice_nivel][$indice_beca]["por_cobrar_cuota"] += $por_cobrar_cuota;	
					}
					else
					{
						$vector_cuotas[$indice_nivel][$indice_beca] = 
							[
								"nombre_estudiante" => "",
								"nivel_estudios" => "General",
								"grado" => "",
								"porcentaje_descuento" => $transaccion->student->discount,
								"cantidad_estudiantes" => 1,
								"que_pagaron" => $indicador_que_pagaron,
								"por_pagar" => $indicador_por_pagar,
								"monto_cuota" => $monto_cuota, 
								"cobrado_completo" => $cobrado_completo, 
								"abono" => $abono,
								"pronto_pago" => $monto_descuento_pronto_pago,
								"por_cobrar_cuota" => $por_cobrar_cuota, 		
							];
					}

					$indice_nivel = $nivel_estudios_posicion[$transaccion->student->section->level];

					if (isset($vector_cuotas[$indice_nivel][$indice_beca]))
					{
						$vector_cuotas[$indice_nivel][$indice_beca]["cantidad_estudiantes"]++;
						$vector_cuotas[$indice_nivel][$indice_beca]["que_pagaron"] += $indicador_que_pagaron;
						$vector_cuotas[$indice_nivel][$indice_beca]["por_pagar"] += $indicador_por_pagar;
						$vector_cuotas[$indice_nivel][$indice_beca]["monto_cuota"] += $monto_cuota;
						$vector_cuotas[$indice_nivel][$indice_beca]["cobrado_completo"] += $cobrado_completo;
						$vector_cuotas[$indice_nivel][$indice_beca]["abono"] += $abono;
						$vector_cuotas[$indice_nivel][$indice_beca]["pronto_pago"] += $monto_descuento_pronto_pago;  
						$vector_cuotas[$indice_nivel][$indice_beca]["por_cobrar_cuota"] += $por_cobrar_cuota;	
					}
					else
					{
						$vector_cuotas[$indice_nivel][$indice_beca] = 
							[
								"nombre_estudiante" => "",
								"nivel_estudios" => $transaccion->student->section->level,
								"grado" => "",
								"porcentaje_descuento" => $transaccion->student->discount,
								"cantidad_estudiantes" => 1,
								"que_pagaron" => $indicador_que_pagaron,
								"por_pagar" => $indicador_por_pagar,
								"monto_cuota" => $monto_cuota, 
								"cobrado_completo" => $cobrado_completo, 
								"abono" => $abono,
								"pronto_pago" => $monto_descuento_pronto_pago,
								"por_cobrar_cuota" => $por_cobrar_cuota, 		
							];
					}
					
				}

			}
			elseif ($tipo_reporte == "Por grado")
			{
				$indice_grado = $transaccion->student->section->orden;
				if ($transaccion->student->section->sublevel == "No asignado")
				{
					$grado = "Sin asignar sección";
				}
				else
				{
					$grado = $transaccion->student->section->sublevel." ".$transaccion->student->section->section;
				}

				if ($indicadorConceptos == "Inscripcion")
				{
					$indice_beca = 0;
					if (isset($vector_cuotas[$indice_grado][$indice_beca]))
					{
						$vector_cuotas[$indice_grado][$indice_beca]["cantidad_estudiantes"]++;
						$vector_cuotas[$indice_grado][$indice_beca]["que_pagaron"] += $indicador_que_pagaron;
						$vector_cuotas[$indice_grado][$indice_beca]["por_pagar"] += $indicador_por_pagar;
						$vector_cuotas[$indice_grado][$indice_beca]["monto_cuota"] += $monto_cuota;
						$vector_cuotas[$indice_grado][$indice_beca]["cobrado_completo"] += $cobrado_completo;
						$vector_cuotas[$indice_grado][$indice_beca]["abono"] += $abono;
						$vector_cuotas[$indice_grado][$indice_beca]["pronto_pago"] += $monto_descuento_pronto_pago; 
						$vector_cuotas[$indice_grado][$indice_beca]["por_cobrar_cuota"] += $por_cobrar_cuota;
					}
					else
					{
						$vector_cuotas[$indice_grado][$indice_beca] = 
							[
								"nombre_estudiante" => "",
								"nivel_estudios" => $transaccion->student->section->level,
								"grado" => $grado,
								"porcentaje_descuento" => 0,
								"cantidad_estudiantes" => 1,
								"que_pagaron" => $indicador_que_pagaron,
								"por_pagar" => $indicador_por_pagar,
								"monto_cuota" => $monto_cuota, 
								"cobrado_completo" => $cobrado_completo, 
								"abono" => $abono,
								"pronto_pago" => $monto_descuento_pronto_pago,
								"por_cobrar_cuota" => $por_cobrar_cuota, 		
							];
					}
				}
				else
				{
					$indice_beca = $transaccion->student->discount;
					if (isset($vector_cuotas[$indice_grado][$indice_beca]))
					{
						$vector_cuotas[$indice_grado][$indice_beca]["cantidad_estudiantes"]++;
						$vector_cuotas[$indice_grado][$indice_beca]["que_pagaron"] += $indicador_que_pagaron;
						$vector_cuotas[$indice_grado][$indice_beca]["por_pagar"] += $indicador_por_pagar;
						$vector_cuotas[$indice_grado][$indice_beca]["monto_cuota"] += $monto_cuota;
						$vector_cuotas[$indice_grado][$indice_beca]["cobrado_completo"] += $cobrado_completo;
						$vector_cuotas[$indice_grado][$indice_beca]["abono"] += $abono;
						$vector_cuotas[$indice_grado][$indice_beca]["pronto_pago"] += $monto_descuento_pronto_pago; 
						$vector_cuotas[$indice_grado][$indice_beca]["por_cobrar_cuota"] += $por_cobrar_cuota;
					}
					else
					{
						$vector_cuotas[$indice_grado][$indice_beca] = 
							[
								"nombre_estudiante" => "",
								"nivel_estudios" => $transaccion->student->section->level,
								"grado" => $grado,
								"porcentaje_descuento" => $transaccion->student->discount,
								"cantidad_estudiantes" => 1,
								"que_pagaron" => $indicador_que_pagaron,
								"por_pagar" => $indicador_por_pagar,
								"monto_cuota" => $monto_cuota, 
								"cobrado_completo" => $cobrado_completo, 
								"abono" => $abono,
								"pronto_pago" => $monto_descuento_pronto_pago,
								"por_cobrar_cuota" => $por_cobrar_cuota, 		
							];
					}
				}
			}
			else
			{
				if ($transaccion->student->section->sublevel == "No asignado")
				{
					$grado = "Sin asignar sección";
				}
				else
				{
					$grado = $transaccion->student->section->sublevel." ".$transaccion->student->section->section;
				}

				if ($indicadorConceptos == "Inscripcion")
				{
					$vector_cuotas[0][] = 
						[
							"nombre_estudiante" => $transaccion->student->full_name,
							"nivel_estudios" => $transaccion->student->section->level, 
							"grado" => $grado,
							"porcentaje_descuento" => 0,
							"cantidad_estudiantes" => 0,
							"que_pagaron" => 0,
							"por_pagar" => 0,
							"monto_cuota" => $monto_cuota, 
							"cobrado_completo" => $cobrado_completo, 
							"abono" => $abono,
							"pronto_pago" => $monto_descuento_pronto_pago,
							"por_cobrar_cuota" => $por_cobrar_cuota 
						];
				}
				else
				{
					$vector_cuotas[0][] = 
						[
							"nombre_estudiante" => $transaccion->student->full_name,
							"nivel_estudios" => $transaccion->student->section->level, 
							"grado" => $grado,
							"porcentaje_descuento" => $transaccion->student->discount,
							"cantidad_estudiantes" => 0,
							"que_pagaron" => 0,
							"por_pagar" => 0,
							"monto_cuota" => $monto_cuota, 
							"cobrado_completo" => $cobrado_completo, 
							"abono" => $abono,
							"pronto_pago" => $monto_descuento_pronto_pago,
							"por_cobrar_cuota" => $por_cobrar_cuota 
						];
				}
			}
		}	

		ksort($vector_cuotas);

		$this->set(compact('currentDate', 'tipo_reporte', 'concepto_anio', 'vector_cuotas', 'indicadorConceptos'));
	}

	/*
	Esta función retorna un vector con las cuotas de los estudiantes que tienen descuento pronto pago
	*/
	public function vectorCuotasProntoPago($periodoEscolar = null)
	{
		$this->loadModel('Concepts');
		$binnacles = new BinnaclesController;

		$vectorNotasCreditoProntoPago = [];
		$vectorConceptosProntoPago = [];
		$vectorCuotasProntoPago = [];

		$vectorMeses = 
			[
				"Sep "  => "09",
				"Oct "  => "10",
				"Nov "  => "11",
				"Dic "  => "12",
				"Ene "  => "01",
				"Feb "  => "02",
				"Mar "  => "03",
				"Abr "  => "04",
				"May "  => "05",
				"Jun "  => "06",
				"Jul "  => "07"
			];

		$facturasPedidosConDescuento = $this->Concepts->find()
			->contain(['Bills'])
			->where(['Bills.school_year' => $periodoEscolar,
					'Bills.annulled' => false,
					'OR' => [['Bills.tipo_documento' => 'Factura'], ['Bills.tipo_documento' => 'Pedido']],
					'Bills.amount <' => 0])
			->order(['Concepts.id' => 'ASC']);

		if ($facturasPedidosConDescuento->count() > 0)
		{
			$notasCreditoProntoPago = $this->Concepts->find()
				->contain(['Bills'])
				->where(['Bills.school_year' => $periodoEscolar,
						'Bills.annulled' => false,
						'Bills.tipo_documento' => 'Nota de crédito',
						'Concepts.concept' => 'Descuento por pronto pago'])
				->order(['Concepts.id' => 'ASC']);
			if ($notasCreditoProntoPago->count() > 0)
			{
				$notasDebitoProntoPago = $this->Concepts->find()
					->contain(['Bills'])
					->where(['Bills.school_year' => $periodoEscolar,
							'Bills.annulled' => false,
							'Bills.tipo_documento' => 'Nota de débito',
							'OR' => [['Concepts.concept' => 'Descuento por pronto pago'], ['Concepts.concept' => 'Anulación descuento por pronto pago']]])
					->order(['Concepts.id' => 'ASC']);

				if ($notasDebitoProntoPago->count() > 0)
				{
					foreach ($notasCreditoProntoPago as $notaCredito)
					{
						$indicadorEncontrado = 0;
						foreach ($notasDebitoProntoPago as $notaDebito)
						{
							if ($notaCredito->bill->id == $notaDebito->bill->id_documento_padre)
							{
								$indicadorEncontrado = 1;
								break;
							}
						}
						if ($indicadorEncontrado == 0)
						{
							$vectorNotasCreditoProntoPago[$notaCredito->bill->id_documento_padre] = round($notaCredito->bill->amount_paid / $notaCredito->bill->tasa_cambio, 2);
						}
					}
				}
				else
				{
					foreach ($notasCreditoProntoPago as $notaCredito)
					{
						$vectorNotasCreditoProntoPago[$notaCredito->bill->id_documento_padre] = round($notaCredito->bill->amount_paid / $notaCredito->bill->tasa_cambio, 2);
					}
				}
			}
			foreach($facturasPedidosConDescuento as $facturaPedido)
			{
				$nombreCuota = substr($facturaPedido->concept, 0, 4);
				$anioCuota = "";
				$numeroMesCuota = "";
				$anioMesCuota = "";
				$indiceVector = 0;
				$tarifaProntoPagoCuota = 0;
				if (isset($vectorMeses[$nombreCuota]))
				{
					$idFacturaPedido = $facturaPedido->bill->id;
					$idConcepto = $facturaPedido->id; 
					$anioCuota = substr($facturaPedido->concept, 4, 4);
					$numeroMesCuota = $vectorMeses[$nombreCuota];
					$anioMesCuota = $anioCuota.$numeroMesCuota;
					$indiceVector = $idFacturaPedido.$anioMesCuota.$idConcepto;
					$tarifaProntoPagoCuota = $this->tarifaProntoPagoCuota($anioMesCuota);
					if ($tarifaProntoPagoCuota == 0)
					{
						$binnacles->add('controller', 'Studenttransactions', 'vectorDescuentosProntoPago', 'No existe tarifa de pronto pago para la cuota '.$anioMesCuota.' correspondiente al concepto con el ID '.$idConcepto);
					}
					else					
					{
						if ($facturaPedido->bill->tipo_documento == "Pedido")
						{
							$vectorConceptosProntoPago[$indiceVector] = 
							[
								"idFactura" => $idFacturaPedido,
								"idConcepto" => $idConcepto,
								"idTransaccion" => $facturaPedido->transaction_identifier,
								"montoTotalProntoPagoDolar" => round($facturaPedido->bill->amount / $facturaPedido->bill->tasa_cambio, 2),
								"tarifaProntoPagoCuota" => $tarifaProntoPagoCuota
							];
						}
						else
						{
							if (isset($vectorNotasCreditoProntoPago[$idFacturaPedido]))
							{
								$montoTotalProntoPagoDolar = $vectorNotasCreditoProntoPago[$idFacturaPedido];
								$vectorConceptosProntoPago[$indiceVector] = 
									[
										"idFactura" => $idFacturaPedido,
										"idConcepto" => $idConcepto,
										"idTransaccion" => $facturaPedido->transaction_identifier,
										"montoTotalProntoPagoDolar" => $montoTotalProntoPagoDolar,
										"tarifaProntoPagoCuota" => $tarifaProntoPagoCuota
									];
							}
						}
					}
				}
			}
			$facturaAnterior = 0;
			$saldoProntoPago = 0;
			foreach ($vectorConceptosProntoPago as $concepto)
			{
				if ($facturaAnterior != $concepto["idFactura"])
				{
					if ($saldoProntoPago > 0)
					{
						$binnacles->add('controller', 'Studenttransactions', 'vectorDescuentosProntoPago', 'Quedó un saldo pronto pago mayor a cero: '.$saldoProntoPago.' para la factura o Pedido con ID: '.$concepto["idFactura"]);
						$saldoProntoPago = 0;
					}
					$vectorCuotasProntoPago[$concepto["idTransaccion"]] = $concepto["tarifaProntoPagoCuota"];
					$saldoProntoPago = round($concepto["montoTotalProntoPagoDolar"] - $concepto["tarifaProntoPagoCuota"], 2);
					$facturaAnterior = $concepto["idFactura"];
				}
				else
				{
					if ($saldoProntoPago > 0)
					{
						if ($saldoProntoPago >= $concepto["tarifaProntoPagoCuota"])
						{
							$vectorCuotasProntoPago[$concepto["idTransaccion"]] = $concepto["tarifaProntoPagoCuota"];
							$saldoProntoPago = round($saldoProntoPago - $concepto["tarifaProntoPagoCuota"], 2);
						}
						else 
						{
							$vectorCuotasProntoPago[$concepto["idTransaccion"]] = $saldoProntoPago;
							$saldoProntoPago = 0;
						}
					}
				}
			}
		}
		
		return $vectorCuotasProntoPago;
	}
	public function tarifaProntoPagoCuota($anioMesCuota) // Descuento pronto pago
	{
		$this->loadModel('Rates');
		$tarifaProntoPagoCuota = 0;

		$tarifasProntoPago = $this->Rates->find()
			->where(['concept' => 'Pronto pago'])
			->order(['id' => 'ASC']);

		foreach ($tarifasProntoPago as $tarifa)
		{
			$anioMesTarifa = $tarifa->rate_year.$tarifa->rate_month;
			if ($anioMesTarifa > $anioMesCuota)
			{
				break;
			}
			else
			{
				$tarifaProntoPagoCuota = $tarifa->amount;
			}
		}

		return $tarifaProntoPagoCuota;
	}
	/* 
	Verifica si todos los estudiantes que hayan abonado o pagado totalmente la matrícula tengan actualizada la columna "balance" con el año correspondiente a la última inscripción que hizo
	*/
	public function verificarAnioUltimaInscripcion()
	{
		$this->loadModel('Schools');
		$school = $this->Schools->get(2);
		$anio = $school->current_school_year;

		$binnacles = new BinnaclesController;

		$transacciones_matricula = $this->Studenttransactions->find('all')
			->contain(['Students'])
			->where(['invoiced' => 0, 'ano_escolar' => $anio, 'transaction_type' => 'Matrícula', 'amount_dollar >' => 0, 'Students.student_condition' => 'Regular']);
			
		foreach ($transacciones_matricula as $transaccion)
		{
			if ($transaccion->student->balance < $anio)
			{
				$estudiante = $this->Studenttransactions->Students->get($transaccion->student_id);
				$estudiante->balance = $anio;
				if ($this->Studenttransactions->Students->save($estudiante))
				{
					$binnacles->add('controller', 'Studenttransactions', 'verificarAnioUltimaInscripcion', 'Se actualizó el campo balance con el año: '.$anio.' Para el estudiante con el ID: '.$transaccion->student_id);
				}
				else
				{
					$binnacles->add('controller', 'Studenttransactions', 'verificarAnioUltimaInscripcion', 'No se pudo actualizar el campo balance con el año: '.$anio.' Para el estudiante con el ID: '.$transaccion->student_id);
				}	
			}
		}
		return;
	}
	public function reporteEstudiantesDiferenciasInscripcion()
	{
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		$currentDate = Time::now();

		$this->verificarAnioUltimaInscripcion();
		$this->loadModel('Schools');
		$school = $this->Schools->get(2);
		$anio = $school->current_school_year;
		$proximoAnio = $anio +1;

		$controlador_estudiantes = new StudentsController();        			
		$otrasTarifas = $controlador_estudiantes->otrasTarifas(0);

		$matriculaEncontrada = 0;
		$agostoEncontrado = 0;
		$tarifaMatricula = 0;
		$tarifaAgosto = 0;
		$descuentosRecargosEspeciales =
			[
				'Ago 2025' => -10
			];

		$tarifaConDescuentoRecargoEspecial = 0;
		$nuevoEstudiante = '';

		foreach ($otrasTarifas as $otras)
		{				
			if ($otras['conceptoAno'] == 'Matrícula '.$anio)
			{
				$tarifaMatricula = $otras['tarifaDolar'];
				$matriculaEncontrada = 1;
			}
			elseif ($otras['conceptoAno'] == 'Ago '.$proximoAnio)
			{
				$tarifaAgosto = $otras['tarifaDolar'];
				$agostoEncontrado = 1;
			}

			if ($matriculaEncontrada == 1 && $agostoEncontrado == 1)
			{
				break;
			}
		}

		$vectorDiferenciasInscripcion;
		$indiceVector = 0;
		$indicadorEstudianteConDiferencias = 0;

		$vectorEstudiantesInscritos = $this->vectorEstudiantesInscritos($anio);

		$transaccionesInscripcion = $this->Studenttransactions->find('all')
			->contain(['Students' => ['Parentsandguardians', 'Sections']])
			->where(['Studenttransactions.invoiced' => 0, ['OR' => [['Studenttransactions.transaction_description' => 'Matrícula '.$anio], ['Studenttransactions.transaction_description' => 'Ago '.$proximoAnio]]], 'Students.balance' => $anio, 'Students.student_condition' => 'Regular', 'Sections.orden <' => 42])
			->order(["Students.surname" => "ASC", "Students.second_surname" => "ASC", "Students.first_name" => "ASC", "Students.second_name" => "ASC"]);

		foreach ($transaccionesInscripcion as $transaccion)
		{
			if (isset($vectorEstudiantesInscritos[$transaccion->student->id]))
			{
				$indiceVector = $transaccion->student->id;

				if (isset($descuentosRecargosEspeciales['Matrícula '.$anio]))
				{
					$tarifaConDescuentoRecargoEspecial = round($tarifaMatricula + $descuentosRecargosEspeciales['Matrícula '.$anio], 2);
				}
				else
				{
					$tarifaConDescuentoRecargoEspecial = $tarifaMatricula;
				}
				if ($transaccion->transaction_description == 'Matrícula '.$anio && $transaccion->amount_dollar < $tarifaConDescuentoRecargoEspecial)
				{	
					$vectorDiferenciasInscripcion[$indiceVector]['diferenciaMatricula'] = round($tarifaConDescuentoRecargoEspecial - $transaccion->amount_dollar, 2);
					$indicadorEstudianteConDiferencias = 1;
				}

				if (isset($descuentosRecargosEspeciales['Ago '.$proximoAnio]))
				{
					$tarifaConDescuentoRecargoEspecial = round($tarifaAgosto + $descuentosRecargosEspeciales['Ago '.$proximoAnio], 2);
				}
				else
				{
					$tarifaConDescuentoRecargoEspecial = $tarifaAgosto;
				}

				if ($transaccion->transaction_description == 'Ago '.$proximoAnio && $transaccion->amount_dollar < $tarifaConDescuentoRecargoEspecial)
				{	
					$vectorDiferenciasInscripcion[$indiceVector]['diferenciaAgosto'] = round($tarifaConDescuentoRecargoEspecial - $transaccion->amount_dollar, 2);
					$indicadorEstudianteConDiferencias = 1;
				}
				if ($indicadorEstudianteConDiferencias == 1)
				{
					if ($transaccion->student->new_student == 1)
					{
						$nuevoEstudiante = 'Sí';
					}
					else
					{
						$nuevoEstudiante = 'No';
					}
					if (!(isset($vectorDiferenciasInscripcion[$indiceVector]['nombreEstudiante'])))
					{
						$vectorDiferenciasInscripcion[$indiceVector]['nombreEstudiante'] = $transaccion->student->full_name;
					}

					if (!(isset($vectorDiferenciasInscripcion[$indiceVector]['nuevoEstudiante'])))
					{
						$vectorDiferenciasInscripcion[$indiceVector]['nuevoEstudiante'] = $nuevoEstudiante;
					}
					
					if (!(isset($vectorDiferenciasInscripcion[$indiceVector]['nombreRepresentante'])))
					{
						$vectorDiferenciasInscripcion[$indiceVector]['nombreRepresentante'] = $transaccion->student->parentsandguardian->full_name;
					}

					if (!(isset($vectorDiferenciasInscripcion[$indiceVector]['telefonoRepresentante'])))
					{
						$vectorDiferenciasInscripcion[$indiceVector]['telefonoRepresentante'] = $transaccion->student->parentsandguardian->cell_phone;
					}

					if (!(isset($vectorDiferenciasInscripcion[$indiceVector]['diferenciaMatricula'])))
					{
						$vectorDiferenciasInscripcion[$indiceVector]['diferenciaMatricula'] = 0;
					}
					if (!(isset($vectorDiferenciasInscripcion[$indiceVector]['diferenciaAgosto'])))
					{
						$vectorDiferenciasInscripcion[$indiceVector]['diferenciaAgosto'] = 0;
					}
						
					$indicadorEstudianteConDiferencias = 0;
				}
			}
		}
		$this->set(compact('vectorDiferenciasInscripcion', 'currentDate', 'anio', 'proximoAnio'));
	}

	public function reporteServicioEducativoPendiente()
	{
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		$currentDate = Time::now();

		$this->verificarAnioUltimaInscripcion();
		$this->loadModel('Schools');
		$school = $this->Schools->get(2);
		$anio = $school->current_school_year;
		$proximoAnio = $anio +1;

		$controlador_estudiantes = new StudentsController();        			
		$otrasTarifas = $controlador_estudiantes->otrasTarifas(0);

		$matriculaEncontrada = 0;
		$agostoEncontrado = 0;
		$tarifaMatricula = 0;
		$tarifaAgosto = 0;

		$vectorDiferenciasInscripcion;
		$indiceVector = 0;
		$saldoCuota = 0;

		$transaccionesInscripcion = $this->Studenttransactions->find('all')
			->contain(['Students'])
			->where(['Studenttransactions.invoiced' => 0, 'Studenttransactions.transaction_description' => 'Servicio educativo '.$anio, 'Students.balance' => $anio, 'Students.student_condition' => 'Regular', 'Students.new_student' => 1])
			->order(["Students.second_surname" => "ASC", "Studenttransactions.id" => "ASC"]);

		$vectorEstudiantesInscritos = $this->vectorEstudiantesInscritos($anio);

		foreach ($transaccionesInscripcion as $transaccion)
		{
			if (isset($vectorEstudiantesInscritos[$transaccion->student->id]))
			{
				$indiceVector = $transaccion->student->id;
				$saldoCuota = $transaccion->amount - $transaccion->amount_dollar;
				if ($transaccion->paid_out == 0 && $saldoCuota >= 0)
				{	
					$vectorDiferenciasInscripcion[$indiceVector]['nombreEstudiante'] = $transaccion->student->full_name;
					$vectorDiferenciasInscripcion[$indiceVector]['diferenciaServicioEducativo'] = round($transaccion->amount - $transaccion->amount_dollar, 2);		
				}
			}
		}
		$this->set(compact('vectorDiferenciasInscripcion', 'currentDate'));
	}

	public function cuentasCobradasPorCobrarAcumulado()
    {	
		if ($this->request->is('post')) 
        {
			return $this->redirect(['controller' => 'Studenttransactions', 'action' => 'reporteCuentasCobradasPorCobrarAcumulado', $_POST["tipo_reporte"],  $_POST["mes_desde"], $_POST["mes_hasta"]], );
        }
	}
	public function reporteCuentasCobradasPorCobrarAcumulado($tipo_reporte = null, $mesDesde = null, $mesHasta = null)
	{
		$this->verificarAnioUltimaInscripcion();
		$this->verificarDescuentoBecados();
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

		$currentDate = Time::now();

		if ($currentDate->month < 10)
		{
			$mes_actual = "0".$currentDate->month; 
		}
		else
		{
			$mes_actual = $currentDate->month; 
		}
		
		$anio_mes_actual = $currentDate->year.$mes_actual;

		$anio_mes_cuota = "";

		$anio_mes_recalculo_cuotas_atrasadas = "202209";
		
		$controlador_estudiantes = new StudentsController();
        			
		$mesesTarifas = $controlador_estudiantes->mesesTarifas(0);
               					
		$this->loadModel('Monedas');	
		$moneda = $this->Monedas->get(2);
		$dollarExchangeRate = $moneda->tasa_cambio_dolar; 

		$numero_concepto =
			[
				"09" => "Septiembre",
				"10" => "Octubre",
				"11" => "Noviembre",
				"12" => "Diciembre",
				"01" => "Enero",
				"02" => "Febrero",
				"03" => "Marzo",
				"04" => "Abril",
				"05" => "Mayo",
				"06" => "Junio", 
				"07" => "Julio" 
			];

		$numero_concepto_abreviado =
			[
				"09" => "Sep",
				"10" => "Oct",
				"11" => "Nov",
				"12" => "Dic",
				"01" => "Ene",
				"02" => "Feb",
				"03" => "Mar",
				"04" => "Abr",
				"05" => "May",
				"06" => "Jun", 
				"07" => "Jul" 
			];

		$nombre_concepto_desde = $numero_concepto[$mesDesde];
		$nombre_concepto_abreviado_desde = $numero_concepto_abreviado[$mesDesde];

		$nombre_concepto_hasta = $numero_concepto[$mesHasta];
		$nombre_concepto_abreviado_hasta = $numero_concepto_abreviado[$mesHasta];

		$concepto_ubicacion_anio = 
			[
				"09" => 0,
				"10" => 0,
				"11" => 0,
				"12" => 0,
				"01" => 1,
				"02" => 1,
				"03" => 1,
				"04" => 1,
				"05" => 1,
				"06" => 1,
				"07" => 1
			];

		$this->loadModel('Schools');
		$school = $this->Schools->get(2);
		$anio = $school->current_school_year;
		$proximoAnioEscolar = $anio + 1;
		$actualAnioInscripcion = $school->current_year_registration;
		$anioInscripcion = $anio == $actualAnioInscripcion ? "Students.balance" : "Students.balance >="; 
		$periodoEscolar = "Año escolar ".$anio."-".$proximoAnioEscolar;
		$vectorCuotasProntoPago = $this->vectorCuotasProntoPago($periodoEscolar);

		$anio_correspondiente_concepto_desde = $anio + $concepto_ubicacion_anio[$mesDesde];													
		$concepto_anio_desde = $nombre_concepto_desde." ".$anio_correspondiente_concepto_desde;
		$concepto_anio_abreviado_desde = $nombre_concepto_abreviado_desde." ".$anio_correspondiente_concepto_desde;
		$anio_mes_dia_desde = $anio_correspondiente_concepto_desde."-".$mesDesde."-01";

		$anio_correspondiente_concepto_hasta = $anio + $concepto_ubicacion_anio[$mesHasta];													
		$concepto_anio_hasta = $nombre_concepto_hasta." ".$anio_correspondiente_concepto_hasta;
		$concepto_anio_abreviado_hasta = $nombre_concepto_abreviado_hasta." ".$anio_correspondiente_concepto_hasta;
		$anio_mes_dia_hasta = $anio_correspondiente_concepto_hasta."-".$mesHasta."-01";

		$vector_cuotas;

		$contador_transacciones = 0;

		if ($tipo_reporte == "Totales generales")
		{
			$orden_reporte = ['Students.discount' => 'ASC', 'Students.id' => 'ASC'];
		}
		elseif ($tipo_reporte == "Por grado")
		{
			$orden_reporte = ['Sections.orden' => 'ASC', 'Students.discount' => 'ASC', 'Students.id' => 'ASC'];
		}
		else
		{
			$orden_reporte = ['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC', 'Students.id' => 'ASC'];
		}

		$nivel_estudios_posicion =
			[
				"No asignado" => 1,
				"Maternal" => 2,
				"Pre-escolar" => 3,
				"Primaria" => 4,
				"Secundaria" => 5
			];

		$contadorTransacciones = 0;
		$idEstudianteAnterior = 0;
		$indicadorPorPagar = 0;
		$contadorEstudiantes = 0;
		$contadorEstudiantesQuePagaron = 0;
		$contadorEstudiantesPorPagar = 0;

		$transacciones_estudiantes = $this->Studenttransactions->find('all')
		->contain(['Students' => ['Sections']])
		->where(['Studenttransactions.invoiced' => 0, 'Studenttransactions.transaction_type' => "Mensualidad", 'Studenttransactions.ano_escolar' => $anio, 'payment_date >=' => $anio_mes_dia_desde, 'payment_date <=' => $anio_mes_dia_hasta, 'Students.student_condition' => 'Regular', $anioInscripcion => $anio])
		->order($orden_reporte);

		$contadorTransaccionesEstudiantes = $transacciones_estudiantes->count();
		
		if ($contadorTransaccionesEstudiantes == 0)
		{
			$this->Flash->error(__('No se encontraron cuotas'));		
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
		}

		foreach ($transacciones_estudiantes as $transaccion)
		{
			$contador_transacciones++;
			$monto_cuota = 0;
			$cobrado_completo = 0;
			$abono = 0;
			$monto_descuento_pronto_pago = 0;
			$por_cobrar_cuota = 0;

			if ($transaccion->student->scholarship == 0)  
			{	
				$monto_descuento_pronto_pago_anticipado = 0;
				$monto_descuento_pronto_pago = 0;

				$anio_transaccion = $transaccion->payment_date->year;
				$mes_transaccion = $transaccion->payment_date->month;

				if ($mes_transaccion < 10)
				{
					$mes_transaccion = "0".$mes_transaccion;
				}

				$anio_mes_transaccion = $anio_transaccion.$mes_transaccion;

				if ($anio_mes_transaccion >= $anio_mes_recalculo_cuotas_atrasadas && $anio_mes_transaccion < $anio_mes_actual && $transaccion->paid_out == 0)
				{
					$anio_mes_cuota = $anio_mes_actual;
				}
				else
				{
					$anio_mes_cuota = $anio_mes_transaccion;
				}

				foreach ($mesesTarifas as $mesesTarifa)
				{
					if ($mesesTarifa["anoMes"] == $anio_mes_cuota)
					{
						$monto_cuota = round(($mesesTarifa["tarifaDolar"] * (100 - $transaccion->student->discount)) / 100, 2);
						break;
					}
				}
			
				if ($monto_cuota == 0)
				{
					$this->Flash->error(__('No se encontró la tarifa para la cuota '.$anio_mes_cuota));
					return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
				}

				if ($transaccion->paid_out == 0)
				{
					$abono = $transaccion->amount_dollar;													
					$por_cobrar_cuota = round($monto_cuota - $transaccion->amount_dollar, 2);
				}
				else
				{
					$descuento_por_ajuste = round($transaccion->original_amount - $transaccion->amount, 2);
					$cuota_menos_descuento_por_ajuste = round($monto_cuota - $descuento_por_ajuste, 2); 

					if ($cuota_menos_descuento_por_ajuste > $transaccion->amount_dollar)
					{
						$monto_descuento_pronto_pago_anticipado = $this->tarifaProntoPagoCuota($anio_mes_transaccion); 
						$monto_cuota = $cuota_menos_descuento_por_ajuste;
						$abono = round($transaccion->amount_dollar - $monto_descuento_pronto_pago_anticipado, 2);
						$por_cobrar_cuota = round($monto_cuota - $transaccion->amount_dollar + $monto_descuento_pronto_pago_anticipado, 2);
					}
					else
					{
						if (isset($vectorCuotasProntoPago[$transaccion->id]))
						{
							$monto_descuento_pronto_pago = $vectorCuotasProntoPago[$transaccion->id];
							$cobrado_completo = round($monto_cuota - $monto_descuento_pronto_pago, 2);
						}
						else
						{
							$cobrado_completo = $monto_cuota;
						}
					}
				}
			}

			if ($mesDesde == $mesHasta)
			{
				$contadorEstudiantes = 1;
				if ($por_cobrar_cuota == 0)
				{
					$contadorEstudiantesQuePagaron = 1;
					$contadorEstudiantesPorPagar = 0;
				}
				else
				{
					$contadorEstudiantesQuePagaron = 0;
					$contadorEstudiantesPorPagar = 1;
				}
			}
			else
			{
				if ($contadorTransacciones == 1)
				{
					$idEstudianteAnterior = $transaccion->student->id;
				}
				elseif ($idEstudianteAnterior != $transaccion->student->id)
				{
					$contadorEstudiantes = 1;
					if ($indicadorPorPagar == 0)
					{
						$contadorEstudiantesQuePagaron = 1;
					}
					else
					{
						$contadorEstudiantesPorPagar = 1;
					}
					$idEstudianteAnterior = $transaccion->student->id;
					$indicadorPorPagar = 0;
				}
				else
				{
					$contadorEstudiantes = 0;
					$contadorEstudiantesQuePagaron = 0;
					$contadorEstudiantesPorPagar = 0;
				}
				if ($por_cobrar_cuota > 0)
				{
					$indicadorPorPagar = 1;
				}
			}

			if ($tipo_reporte == "Totales generales")
			{
				$indice_nivel = 0;
				$indice_beca = $transaccion->student->discount;

				if (isset($vector_cuotas[$indice_nivel][$indice_beca]))
				{
					$vector_cuotas[$indice_nivel][$indice_beca]["cantidad_estudiantes"] += $contadorEstudiantes;
					$vector_cuotas[$indice_nivel][$indice_beca]["que_pagaron"] += $contadorEstudiantesQuePagaron;
					$vector_cuotas[$indice_nivel][$indice_beca]["por_pagar"] += $contadorEstudiantesPorPagar;
					$vector_cuotas[$indice_nivel][$indice_beca]["monto_cuota"] += $monto_cuota;
					$vector_cuotas[$indice_nivel][$indice_beca]["cobrado_completo"] += $cobrado_completo;
					$vector_cuotas[$indice_nivel][$indice_beca]["abono"] += $abono;
					$vector_cuotas[$indice_nivel][$indice_beca]["pronto_pago"] += $monto_descuento_pronto_pago;  
					$vector_cuotas[$indice_nivel][$indice_beca]["por_cobrar_cuota"] += $por_cobrar_cuota;
					
					if ($mesDesde != $mesHasta && $contadorTransacciones == $contadorTransaccionesEstudiantes)
					{
						$vector_cuotas[$indice_nivel][$indice_beca]["cantidad_estudiantes"]++;
						if ($indicadorPorpagar == 0)
						{
							$vector_cuotas[$indice_nivel][$indice_beca]["que_pagaron"]++;
						}
						else
						{
							$vector_cuotas[$indice_nivel][$indice_beca]["por_pagar"]++;
						}
					}
				}
				else
				{
					$vector_cuotas[$indice_nivel][$indice_beca] = 
						[
							"nombre_estudiante" => "",
							"nivel_estudios" => "General",
							"grado" => "",
							"porcentaje_descuento" => $transaccion->student->discount,
							"cantidad_estudiantes" => $contadorEstudiantes,
							"que_pagaron" => $contadorEstudiantesQuePagaron,
							"por_pagar" => $contadorEstudiantesPorPagar,
							"monto_cuota" => $monto_cuota, 
							"cobrado_completo" => $cobrado_completo, 
							"abono" => $abono,
							"pronto_pago" => $monto_descuento_pronto_pago,
							"por_cobrar_cuota" => $por_cobrar_cuota, 		
						];
				}

				$indice_nivel = $nivel_estudios_posicion[$transaccion->student->section->level];

				if (isset($vector_cuotas[$indice_nivel][$indice_beca]))
				{
					$vector_cuotas[$indice_nivel][$indice_beca]["cantidad_estudiantes"] += $contadorEstudiantes;
					$vector_cuotas[$indice_nivel][$indice_beca]["que_pagaron"] += $contadorEstudiantesQuePagaron;
					$vector_cuotas[$indice_nivel][$indice_beca]["por_pagar"] += $contadorEstudiantesPorPagar;
					$vector_cuotas[$indice_nivel][$indice_beca]["monto_cuota"] += $monto_cuota;
					$vector_cuotas[$indice_nivel][$indice_beca]["cobrado_completo"] += $cobrado_completo;
					$vector_cuotas[$indice_nivel][$indice_beca]["abono"] += $abono;
					$vector_cuotas[$indice_nivel][$indice_beca]["pronto_pago"] += $monto_descuento_pronto_pago;  
					$vector_cuotas[$indice_nivel][$indice_beca]["por_cobrar_cuota"] += $por_cobrar_cuota;
					
					if ($mesDesde != $mesHasta && $contadorTransacciones == $contadorTransaccionesEstudiantes)
					{
						$vector_cuotas[$indice_nivel][$indice_beca]["cantidad_estudiantes"]++;
						if ($indicadorPorpagar == 0)
						{
							$vector_cuotas[$indice_nivel][$indice_beca]["que_pagaron"]++;
						}
						else
						{
							$vector_cuotas[$indice_nivel][$indice_beca]["por_pagar"]++;
						}
					}	
				}
				else
				{
					$vector_cuotas[$indice_nivel][$indice_beca] = 
						[
							"nombre_estudiante" => "",
							"nivel_estudios" => $transaccion->student->section->level,
							"grado" => "",
							"porcentaje_descuento" => $transaccion->student->discount,
							"cantidad_estudiantes" => $contadorEstudiantes,
							"que_pagaron" => $contadorEstudiantesQuePagaron,
							"por_pagar" => $contadorEstudiantesPorPagar,
							"monto_cuota" => $monto_cuota, 
							"cobrado_completo" => $cobrado_completo, 
							"abono" => $abono,
							"pronto_pago" => $monto_descuento_pronto_pago,
							"por_cobrar_cuota" => $por_cobrar_cuota, 		
						];
				}
			}
			elseif ($tipo_reporte == "Por grado")
			{
				$indice_grado = $transaccion->student->section->orden;
				if ($transaccion->student->section->sublevel == "No asignado")
				{
					$grado = "Sin asignar sección";
				}
				else
				{
					$grado = $transaccion->student->section->sublevel." ".$transaccion->student->section->section;
				}
				$indice_beca = $transaccion->student->discount;
				if (isset($vector_cuotas[$indice_grado][$indice_beca]))
				{
					$vector_cuotas[$indice_grado][$indice_beca]["cantidad_estudiantes"] += $contadorEstudiantes;
					$vector_cuotas[$indice_grado][$indice_beca]["que_pagaron"] += $contadorEstudiantesQuePagaron;
					$vector_cuotas[$indice_grado][$indice_beca]["por_pagar"] += $contadorEstudiantesPorPagar;
					$vector_cuotas[$indice_grado][$indice_beca]["monto_cuota"] += $monto_cuota;
					$vector_cuotas[$indice_grado][$indice_beca]["cobrado_completo"] += $cobrado_completo;
					$vector_cuotas[$indice_grado][$indice_beca]["abono"] += $abono;
					$vector_cuotas[$indice_grado][$indice_beca]["pronto_pago"] += $monto_descuento_pronto_pago; 
					$vector_cuotas[$indice_grado][$indice_beca]["por_cobrar_cuota"] += $por_cobrar_cuota;

					if ($mesDesde != $mesHasta && $contadorTransacciones == $contadorTransaccionesEstudiantes)
					{
						$vector_cuotas[$indice_nivel][$indice_beca]["cantidad_estudiantes"]++;
						if ($indicadorPorpagar == 0)
						{
							$vector_cuotas[$indice_nivel][$indice_beca]["que_pagaron"]++;
						}
						else
						{
							$vector_cuotas[$indice_nivel][$indice_beca]["por_pagar"]++;
						}
					}	
				}
				else
				{
					$vector_cuotas[$indice_grado][$indice_beca] = 
						[
							"nombre_estudiante" => "",
							"nivel_estudios" => $transaccion->student->section->level,
							"grado" => $grado,
							"porcentaje_descuento" => $transaccion->student->discount,
							"cantidad_estudiantes" => $contadorEstudiantes,
							"que_pagaron" => $contadorEstudiantesQuePagaron,
							"por_pagar" => $contadorEstudiantesPorPagar,
							"monto_cuota" => $monto_cuota, 
							"cobrado_completo" => $cobrado_completo, 
							"abono" => $abono,
							"pronto_pago" => $monto_descuento_pronto_pago,
							"por_cobrar_cuota" => $por_cobrar_cuota, 		
						];
				}
			}
			else
			{
				$indice_alumno = $transaccion->student->full_name.$transaccion->student->id;
				if ($transaccion->student->section->sublevel == "No asignado")
				{
					$grado = "Sin asignar sección";
				}
				else
				{
					$grado = $transaccion->student->section->sublevel." ".$transaccion->student->section->section;
				}

				if (isset($vector_cuotas[0][$indice_alumno]))
				{
					$vector_cuotas[0][$indice_alumno]["monto_cuota"] += $monto_cuota;
					$vector_cuotas[0][$indice_alumno]["cobrado_completo"] += $cobrado_completo;
					$vector_cuotas[0][$indice_alumno]["abono"] += $abono;
					$vector_cuotas[0][$indice_alumno]["pronto_pago"] += $monto_descuento_pronto_pago; 
					$vector_cuotas[0][$indice_alumno]["por_cobrar_cuota"] += $por_cobrar_cuota;
				}
				else
				{
					$vector_cuotas[0][$indice_alumno] = 
						[
							"nombre_estudiante" => $transaccion->student->full_name,
							"nivel_estudios" => $transaccion->student->section->level, 
							"grado" => $grado,
							"porcentaje_descuento" => $transaccion->student->discount,
							"cantidad_estudiantes" => 0,
							"que_pagaron" => 0,
							"por_pagar" => 0,
							"monto_cuota" => $monto_cuota, 
							"cobrado_completo" => $cobrado_completo, 
							"abono" => $abono,
							"pronto_pago" => $monto_descuento_pronto_pago,
							"por_cobrar_cuota" => $por_cobrar_cuota 
						];
				}
			}
		}	

		ksort($vector_cuotas);

		$this->set(compact('currentDate', 'tipo_reporte', 'concepto_anio_desde', 'concepto_anio_hasta', 'vector_cuotas'));
	}
	public function verificarDescuentoBecados()
	{
		$becados = $this->Studenttransactions->Students->find()
			->where(['Students.student_condition' => 'Regular', 'Students.scholarship' => 1]);
		if ($becados->count() > 0)
		{
			foreach ($becados as $becado)
			{
				if ($becado->scholarship == 1)
				{
					if ($becado->tipo_descuento != "Becado" || $becado->discuont != 100)
					{
						$estudiante = $this->Studenttransactions->Students->get($becado->id);
						$estudiante->tipo_descuento = "Becado";
						$estudiante->discount = 100;

						if (!($this->Studenttransactions->Students->save($estudiante)))
						{
							$this->Flash->error(__('Los datos del alumno con el ID: '.$becado->id. ' no pudieron ser actualizados'));
						}	
					}
				}
			}
		}
	}
	// Estudiantes egresados del año anterior
	public function estudiantesEgresados()
    {
		$transacciones = $this->Studenttransactions->find('all')
			->contain(['Students' => ['Sections']])
			->where(['Studenttransactions.transaction_description' => 'Jul 2024', 'Students.balance' => '2023', 'Students.becado_ano_anterior' => 0, 'Sections.orden >' => 41])
			->order(['Studenttransactions.amount_dollar' => 'ASC']);
		$this->set(compact('transacciones'));
	}
	public function pagosParcialesConceptosInscripcion ()
	{
		$pagosParcialesConceptosInscripcion = $this->Studenttransactions->find('all')
			->contain(['Students' => ['Sections']])
			->where(['Students.balance' => '2024', 'Students.student_condition' => 'Regular', 'Studenttransactions.amount_dollar <' => 190, 'OR' => [['Studenttransactions.transaction_description' => 'Matrícula 2023'], ['Studenttransactions.transaction_description' => 'Matrícula 2024'], ['Studenttransactions.transaction_description' => 'Ago 2024'], ['Studenttransactions.transaction_description' => 'Ago 2025']]])
			->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC']);
			
		$this->set(compact('pagosParcialesConceptosInscripcion'));
	}
	// Genera un vector con el nombre de los estudiantes que pagaron total o parcialmente la matrícula del año requerido

	public function vectorEstudiantesInscritos($anioEscolar)
	{
		$vectorEstudiantesInscritos = [];
		$estudiantesInscritos = $this->Studenttransactions->find('all')
		->contain(['Students'])
		->where(['Studenttransactions.invoiced' => 0, 'Studenttransactions.transaction_description' => 'Matrícula '.$anioEscolar, 'Studenttransactions.amount_dollar >' => 0 ])
		->order(["Students.id" => "ASC"]);

		foreach ($estudiantesInscritos as $estudiante)
		{
			$vectorEstudiantesInscritos[$estudiante->student->id] = $estudiante->student->full_name;
		}
		return $vectorEstudiantesInscritos;
	}

    public function consultaDeudaRepresentante($idUsuario = null, $rolUsuario = null, $idRepresentante = null, $idEstudiante = null, $controlador = 'Users', $accion = 'wait')
    {
		if ($this->request->is('post'))
	    {
			if (isset($_POST['id_estudiante'])) 
			{
				$this->loadModel('Schools');
				$school = $this->Schools->get(2);
				$anioEscolarActual = $school->current_school_year;
				$idUsuario = $_POST['id_usuario'];
				$rolUsuario = $_POST['rol_usuario'];
				$idRepresentante = $_POST['id_representante'];
				$idEstudiante = $_POST['id_estudiante'];
				$estudiante = $_POST['estudiante'];
				$periodoEscolar = $_POST['periodo_escolar'];
				$registrarCuota = 0;
				$porcentajeDescuento = 0;
				$porcentajeDescuentoDecimal = 0;
				$anioMesTransaccion = '';
				$tarifaCuota = 0;
				$diferenciaOriginalMonto = 0;
				$pendienteCuota = 0;
				$registroEstudiante = '';
				$totalDeudaEstudiante = 0;
				$vectorTransacciones = [];
				$mesesTarifas = '';
				$otrasTarifas = '';
				$contadorCuotasRegistradas = 0;
				$anoTransaccion = 0;
				$mesTransaccion = 0;
				
				$condiciones = 
					[
						'student_id' => $idEstudiante, 
						'ano_escolar' => $periodoEscolar,
						'invoiced'  => 0 		
					];						

				$transaccionesEstudiante = $this->Studenttransactions->find('all', ['conditions' => $condiciones]);
				$contadorTransacciones = $transaccionesEstudiante->count();

				if ($contadorTransacciones > 0)
				{
					$contadorCuotasRegistradas = 0;
					$ajustesTarifaCuota =
						[
							'Ago 2025' => -10
						];
					foreach ($transaccionesEstudiante as $indice => $transaccion)
					{
						$registrarCuota = 0;
						$porcentajeDescuento = 0;
						$porcentajeDescuentoDecimal = 0;
						$anioMesTransaccion = '';
						$tarifaCuota = 0;
						$diferenciaOriginalMonto = 0;
						$pendienteCuota = 0;
						$anoTransaccion = 0;
						$mesTransaccion = 0;

						$registroEstudiante = $this->Studenttransactions->Students->get($idEstudiante);

						$this->loadModel('Monedas');
					
						$moneda = $this->Monedas->get(2);
						$tasaCambioDolar = $moneda->tasa_cambio_dolar;

						$controladorEstudiantes = new StudentsController();

						$mesesTarifas = $controladorEstudiantes->mesesTarifas($tasaCambioDolar);	

						$otrasTarifas = $controladorEstudiantes->otrasTarifas($tasaCambioDolar);

						if ($rolUsuario == 'Representante')
						{
							if ($transaccion->transaction_type == 'Matrícula' || $transaccion->transaction_type == 'Mensualidad')
							{
								$registrarCuota = 1; 
							}
						}
						else
						{ 
							$registrarCuota = 1;
						} 

						if ($transaccion->transaction_type == 'Mensualidad' && substr($transaccion->transaction_description, 0, 3) != 'Ago')
						{
							$anioTransaccion = $transaccion->payment_date->year;

							if ($transaccion->payment_date->month < 10)
							{
								$mesTransaccion = '0'.$transaccion->payment_date->month;
							}
							else
							{
								$mesTransaccion = $transaccion->payment_date->month;
							}
							$anioMesTransaccion = $anioTransaccion.$mesTransaccion;

							foreach ($mesesTarifas as $indice => $mesTarifa)
							{
								if ($anioMesTransaccion == $mesTarifa['anoMes'])
								{
									$tarifaCuota = $mesTarifa['tarifaDolar'];
									break;
								}
							}    
							$diferenciaOriginalMonto = round($transaccion->original_amount - $transaccion->amount, 2);
							if ($diferenciaOriginalMonto > 0)
							{
								$tarifaCuota = round($tarifaCuota - $diferenciaOriginalMonto, 2);
							}
							if ($transaccion->paid_out == 1)
							{ 
								$porcentajeDescuento = $transaccion->porcentaje_descuento;
							}
							else
							{
								if ($transaccion->ano_escolar < $anioEscolarActual)
								{
									$porcentajeDescuento = $registroEstudiante->descuento_ano_anterior;
								}
								elseif ($transaccion->ano_escolar == $anioEscolarActual)
								{
									$porcentajeDescuento = $registroEstudiante->discount;
								}
							}
							if ($porcentajeDescuento == 0)
							{
								$porcentajeDescuentoDecimal = 1;
							}
							else
							{
								$porcentajeDescuentoDecimal = round((100 - $porcentajeDescuento)/100, 2);
							}
							$tarifaCuota = round($tarifaCuota * $porcentajeDescuentoDecimal, 2);
						}
						else
						{
							if (substr($transaccion->transaction_description, 0, 18) == 'Servicio educativo')
							{
								$tarifaCuota = $transaccion->amount;
							}
							else
							{
								foreach ($otrasTarifas as $indice => $otraTarifa)
								{
									if ($transaccion->transaction_description == $otraTarifa['conceptoAno'])
									{
										$tarifaCuota = $otraTarifa['tarifaDolar'];
										break;
									}
								}
							}
							$diferenciaOriginalMonto = round($transaccion->original_amount - $transaccion->amount, 2);
							if ($diferenciaOriginalMonto > 0)
							{
								$tarifaCuota = round($tarifaCuota - $diferenciaOriginalMonto, 2);
							}
						}

						if (isset($ajustesTarifaCuota[$transaccion->transaction_description]))
						{
							$tarifaCuota = round($tarifaCuota + $ajustesTarifaCuota[$transaccion->transaction_description]);
						}
						
						if ($registrarCuota == 1)
						{
							$contadorCuotasRegistradas++;
							$pendienteCuota = round($tarifaCuota - $transaccion->amount_dollar, 2);
							$totalDeudaEstudiante = round($totalDeudaEstudiante + $pendienteCuota, 2);
							$vectorTransacciones[] = 
								[
									'id' => $transaccion->id,
									'cuota' => $transaccion->transaction_description,
									'tarifaCuota' => $tarifaCuota,
									'montoAbonado' => $transaccion->amount_dollar,
									'pendienteCuota' => $pendienteCuota,
									'porcentajeDescuento' => $porcentajeDescuento
								];
						}
					}
				}

				$this->set(compact('idUsuario', 'rolUsuario', 'idRepresentante', 'idEstudiante', 'estudiante', 'periodoEscolar', 'anioEscolarActual', 'registroEstudiante', 'mesesTarifas', 'otrasTarifas', 'contadorCuotasRegistradas', 'vectorTransacciones', 'totalDeudaEstudiante', 'controlador', 'accion'));
			}
			else
			{
				$this->Flash->error(__('No se indicó el nombre del estudiante'));
			}
       	}
		else
		{
			if ($rolUsuario == 'Representante')
			{
				$this->loadModel('Parentsandguardians');
				$representantes = $this->Parentsandguardians->find('all')->where(['user_id' => $idUsuario]);
				$representante = $representantes->first();
				$idRepresentante = $representante->id;
			}
			$this->set(compact('idUsuario', 'rolUsuario', 'idRepresentante', 'controlador', 'accion'));
		}
    }
}