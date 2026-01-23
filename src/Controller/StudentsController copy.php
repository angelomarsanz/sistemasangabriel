<?php
namespace App\Controller;
use App\Controller\AppController;
use App\Controller\ParentsandguardiansController;
use App\Controller\StudenttransactionsController;
use App\Controller\BinnaclesController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Event\Event; // Necesario para el tipo de parámetro de beforeFilter

/**
 * Students Controller
 *
 * @property \App\Model\Table\StudentsTable $Students
 */
class StudentsController extends AppController
{
   /**
     * initialize method
     *
     * Este método se ejecuta antes que cualquier acción del controlador.
     * Es el lugar ideal para cargar componentes.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        // Cargar el RequestHandler para que CakePHP pueda parsear el JSON de las peticiones PUT/POST
        $this->loadComponent('RequestHandler');
    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
    }

    public function isAuthorized($user)
    {
		if(isset($user['role']))
		{
			if ($user['role'] === 'Representante')
			{
				if(in_array($this->request->action, ['index', 'view', 'edit', 'filepdf', 'profilePhoto', 'editPhoto', 'buscarEstudiantesRepresentante']))
				{
					return true;
				}
			}
			elseif ($user['role'] === 'Control de estudios')
			{
				if(in_array($this->request->action, ['familyStudents', 'reportFamilyStudents', 'familiasDescuento20', 'familiasDescuento50', 'consultStudent', 'viewStudent', 'edit', 'editStatus', 'reporteBecados', 'reportGraduateStudents', 'consultStudentDelete', 'indexConsult', 'viewConsult', 'filepdf', 'findStudent', 'findStudentDelete']))
				{
					return true;
				}				
			}
			// Inicio cambios Seniat
			elseif ($user['role'] === 'Seniat')
			{
				if(in_array($this->request->action, ['everyFamily', 'relatedStudents' ]))
				{
					return true;
				}				
			}
			// Fin cambios Seniat
        }
				
        return parent::isAuthorized($user);
    }
    
    public function testFunction()
    {
		$contador_estudiantes_actualizados = 0;

		$estudiantes = $this->Students->find('all')
			->contain(['StudenttransactionsParentsandguardians', 'Sections'])
			->where(['Students.id >' => 1, 'Students.student_condition' => 'Egresado', 'Sections.orden >' => 41]);
			
		$contadorEstudiantes = $estudiantes->count();
		
		$this->Flash->success(__('Total estudiantes '.$contadorEstudiantes));
		
		if ($contadorEstudiantes > 0)
		{
			foreach ($estudiantes as $estudiante)
			{
				$estudiante->respaldo_primer_ano_inscripcion = $estudiante->number_of_brothers;
				$estudiante->respaldo_ultimo_ano_inscripcion = $estudiante->balance;
				$estudiante->respaldo_seccion_id = $estudiante->section_id;
				$estudiante->respaldo_nivel_de_estudio = $estudiante->level_of_study;	

				if ($this->Students->save($estudiante)) 
                {
					$contador_estudiantes_actualizados++;
				} 
                else 
                {
                    $this->Flash->error(__('No se pudo actualizar el estudiante con el ID '.$estudiante->id));
                }
			}
		}
		$this->Flash->success(__('Total estudiantes actualizados '.$contador_estudiantes_actualizados));

    }
	
    public function testFunction2()
    {

    }
	
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$family = '';

		if($this->Auth->user('role') == 'Representante')
        {
            $parentsandguardians = $this->Students->Parentsandguardians->find('all')
                ->where(['Parentsandguardians.user_id =' => $this->Auth->user('id')])
				->order(['Parentsandguardians.created' => 'DESC']);

			if ($parentsandguardians->count() > 0)
			{
				$representante = $parentsandguardians->first();
				$family = $representante->family;

				$query = $this->Students->find('all')->contain(['Sections'])->where(['parentsandguardian_id' => $representante->id, 'Students.student_condition' => 'Regular', 'Sections.orden <' => 42]);

				$this->set('students', $this->paginate($query));
				$this->set(compact('representante', 'family'));
				$this->set('_serialize', ['students']);	
			}
			else
			{
				$this->Flash->error(__('No se encontraron estudiantes'));
			}
        }
        else
        {
			$query = $this->Students->find('all')->contain(['Sections'])->where([['Students.student_condition' => 'Regular'],
			['Sections.orden <' => 42]])->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC']);;
			$this->set('students', $this->paginate($query));
			$this->set(compact('family'));
			$this->set('_serialize', ['students', 'family']);
        }
    }
	
	public function listadoEstudiantes($idEstudiante = null, $controlador = 'Users', $accion = 'wait')
	{
		if ($this->request->is('post'))
		{
			if (isset($_POST['id_representante'])) 
			{
				if ($_POST['id_representante'] != null)
				{
					$idRepresentante = $_POST['id_representante'];
					$representante = $_POST['representante'];
					
					$condiciones = 
						[
							'parentsandguardian_id' => $idRepresentante, 
						];						

					$estudiantes = $this->Students->find('all', ['conditions' => $condiciones]);
					$contadorEstudiantes = $estudiantes->count();

					$this->set(compact('idRepresentante', 'representante', 'contadorEstudiantes', 'Estudiantes', 'controlador', 'accion'));
	
				}
				else
				{
					$this->Flash->error(__('No se indicaron los apellidos de la familia'));
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
				$periodoEscolar = $school->	current_school_year;
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
	
    public function indexAdmin($idFamily = null)
    {
        if ($this->request->is('post'))
        {
            $query = $this->Students->find('all')->where(['parentsandguardian_id' => $_POST['idFamily']]);
            $idFamilyP = $_POST['idFamily'];
        }    
        else
        {
            $query = $this->Students->find('all')->where(['parentsandguardian_id' => $idFamily]);
            $idFamilyP = $idFamily;
        }
            
        $this->set('students', $this->paginate($query));

        $this->set(compact('students', 'idFamilyP'));
        $this->set('_serialize', ['students', 'idFamilyp']);
    }

    public function indexConsult($idFamily = null, $family = null)
    {
        $query = $this->Students->find('all')->where([['parentsandguardian_id' => $idFamily], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]]);

        $this->set('students', $this->paginate($query));

        $this->set(compact('idFamily', 'family'));
        $this->set('_serialize', ['students', 'idFamily', 'family']);
    }

    public function previousCardboard()
    {
        if ($this->request->is('post')) 
        {
            $idFamily = $_POST['idFamily'];
            $family = $_POST['family'];

            return $this->redirect(['action' => 'indexCardboard', $idFamily, $family]);
        }
    }

    public function indexCardboard($idFamily = null, $family = null)
    {
        $query = $this->Students->find('all')->where([['parentsandguardian_id' => $idFamily], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]]);
            
        $this->set('students', $this->paginate($query));
            
        $this->set(compact('students', 'idFamily', 'family'));
        $this->set('_serialize', ['students', 'idFamily', 'family']);
    }

    public function indexCardboardInscription($billNumber = null, $idParentsandguardian = null, $family = null)
    {
        $query = $this->Students->find('all')->where([['parentsandguardian_id' => $idParentsandguardian], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]]);
        
        $this->set('students', $this->paginate($query));
        
        $this->set(compact('students', 'billNumber', 'idParentsandguardian', 'family'));
        $this->set('_serialize', ['students', 'billNumber', 'idParentsandguardian', 'family']);
    }

    public function indexAdminb($idFamily = null)
    {
        if ($this->request->is('post'))
        {
            $query = $this->Students->find('all')->where([['parentsandguardian_id' => $_POST['idFamily']], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]]);
            $idFamilyP = $_POST['idFamily'];
        }    
        else
        {
            $query = $this->Students->find('all')->where([['parentsandguardian_id' => $idFamily], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]]);
            $idFamilyP = $idFamily;
        }
            
        $this->set('students', $this->paginate($query));

        $this->set(compact('idFamilyP'));
        $this->set('_serialize', ['students', 'idFamilyp']);
    }

    /**
     * View method
     *
     * @param string|null $id Student id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $student = $this->Students->get($id, [
            'contain' => ['Users', 'Parentsandguardians']
        ]);
        
        $section = $this->Students->Sections->get($student->section_id);
        
        $assignedSection = $section->sublevel . ' ' . $section->section;

        $this->set(compact('student', 'assignedSection'));
        $this->set('_serialize', ['student', 'assignedSection']);
    }
 
    public function viewAdminb($id = null, $idFamilyP = null)
    {
        $student = $this->Students->get($id, [
            'contain' => ['Users', 'Parentsandguardians']
        ]);
        
        $section = $this->Students->Sections->get($student->section_id);
        
        $assignedSection = $section->sublevel . ' ' . $section->section;

        $this->set(compact('student', 'assignedSection', 'idFamilyP'));
        $this->set('_serialize', ['student', 'assignedSection', 'idFamilyP']);
    }

    public function viewConsult($id = null, $idFamily = null, $family = null, $controller = null, $action = null)
    {
        $student = $this->Students->get($id, [
            'contain' => ['Users', 'Parentsandguardians']
        ]);
        
        $section = $this->Students->Sections->get($student->section_id);
        
        $assignedSection = $section->sublevel . ' ' . $section->section;

        $this->set(compact('student', 'idFamily', 'family', 'assignedSection', 'controller', 'action'));
        $this->set('_serialize', ['student', 'idFamily', 'family', 'assignedSection', 'controller', 'action']);
    }

    public function viewStudent($id = null)
    {
        if ($this->request->is('post')) 
        {
            $id = $_POST['idStudent'];
        }
            
        $student = $this->Students->get($id);
        
        $section = $this->Students->Sections->get($student->section_id);
        
        $assignedSection = $section->sublevel . ' ' . $section->section;

        $this->set(compact('student', 'assignedSection'));
        $this->set('_serialize', ['student', 'assignedSection']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($userName = null)
    {
        $users = $this->Students->Users->find('all')
            ->where(['Users.username =' => $userName]);

        $resultUsers = $users->toArray();
        
        $parentsandguardians = $this->Students->Parentsandguardians->find('all')
            ->where(['Parentsandguardians.user_id =' => $this->Auth->user('id')]);

        $resultParentsandguardians = $parentsandguardians->toArray();

        if (!$resultParentsandguardians) 
        {
            $this->Flash->error(__('Por favor primero complete el perfil del representante y luego agregue el alumno'));
            return $this->redirect(['controller' => 'Parentsandguardians', 'action' => 'add']);
        }
        else  
        {
            $student = $this->Students->newEntity();
            if ($this->request->is('post')) 
            {
                $student = $this->Students->patchEntity($student, $this->request->data);
    
                $student->user_id = $resultUsers[0]['id'];
                $student->parentsandguardian_id = $resultParentsandguardians[0]['id'];
                $student->code_for_user = '';
                $student->first_name = $resultUsers[0]['first_name'];
                $student->second_name = $resultUsers[0]['second_name'];
                $student->surname = $resultUsers[0]['surname'];
                $student->second_surname = $resultUsers[0]['second_surname'];
                $student->sex = $resultUsers[0]['sex'];
                $student->school_card = '';
                $student->profile_photo = $resultUsers[0]['profile_photo'];
                $student->profile_photo_dir = $resultUsers[0]['profile_photo_dir'];
                $student->cell_phone = $resultUsers[0]['cell_phone'];
                $student->email = $resultUsers[0]['email'];
                $student->student_condition = "Regular";
                $student->section_id = 1;
                $student->scholarship = 0;
                $student->balance = 0;
                $student->creative_user = $this->Auth->user('username');
                $student->student_migration = false;
                $student->mi_id = 0;
                $student->new_student = true;

                if ($this->Students->save($student)) 
                {
                    $this->Flash->success(__('Los datos de su hijo o representado fueron guardados'));
    
                    return $this->redirect(['action' => 'index']);
                } 
                else 
                {
                    $this->Flash->error(__('El alumno no fue guardado, por favor verifique los datos e intente nuevamente'));
                }
            }
        }
        $this->set(compact('student', 'users', 'resultParentsandguardians'));
        $this->set('_serialize', ['student']);
    }
    
    public function addAdminp()
    {
        $this->autoRender = false;
        
        if ($this->request->is('post')) 
        {
            return $this->redirect(['action' => 'addAdmin', $_POST['idFamily']]);
        }
    }

    public function addAdminpb()
    {
        $this->autoRender = false;
        
        if ($this->request->is('post')) 
        {
            return $this->redirect(['action' => 'addAdminb', $_POST['idFamily']]);
        }
    }

    public function addAdmin($idParentsandguardians = null)
    {
        $studentTransactions = new StudenttransactionsController();
		$indicadorError = 0;
        
        $student = $this->Students->newEntity();
        if ($this->request->is('post')) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
    
            $student->user_id = 4;
            $student->parentsandguardian_id = $idParentsandguardians;
            $student->code_for_user = " ";
            $student->school_card = " ";
            $student->profile_photo = "";
            $student->profile_photo_dir = "";
            $student->section_id = 1;
            $student->student_condition = "Regular";
            $student->scholarship = 0;
            $student->balance = 0;
            $student->creative_user = $this->Auth->user('username');
            $student->student_migration = 0;
            $student->mi_id = 0;
            $student->new_student = 1;
            
            if ($this->Students->save($student)) 
            {
                $lastRecord = $this->Students->find('all', ['conditions' => ['creative_user' => $this->Auth->user('username')],
                'order' => ['Students.created' => 'DESC'] ]);

                $row = $lastRecord->first();
                
                $this->Flash->success(__('El alumno fue guardado exitosamente'));
                
                $indicadorError = $studentTransactions->createQuotasNew($row->id);
				
				if ($indicadorError == 0)
				{
					return $this->redirect(['action' => 'indexAdmin', $idParentsandguardians]);
				}
				else
				{
					$this->Flash->error(__('No se pudieron generar las cuotas del estudiante'));
				}
            } 
            else 
            {
                $this->Flash->error(__('El alumno no fue guardado, por favor verifique los datos e intente nuevamente'));
            }
        }
        
        $parentsandguardian = $this->Students->Parentsandguardians->get($idParentsandguardians);

        $this->set(compact('student', 'users', 'parentsandguardian'));
        $this->set('_serialize', ['student']);
    }

    public function addAdminb($idParentsandguardians = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
		$indicadorError = 0;
		
        $currentDate = Time::now();
		
		$currentYear = $currentDate->year;
		$lastYear = $currentDate->year - 1;
		$nextYear = $currentDate->year + 1;
		
        $student = $this->Students->newEntity();
        if ($this->request->is('post')) 
        {
            $studentTransactions = new StudenttransactionsController();

            $student = $this->Students->patchEntity($student, $this->request->data);

            $student->user_id = 4;
            $student->parentsandguardian_id = $idParentsandguardians;
            $student->second_surname = "";
            $student->second_name = "";
            $student->sex = "";
            $student->nationality = "";
            $student->type_of_identification = ""; 
            $student->identity_card = "";
            $student->place_of_birth = "";
            $student->country_of_birth = "";
            $student->birthdate = Time::now();
            $student->cell_phone = "";
            $student->email = "";
            $student->address = "";
            $student->level_of_study = "";
            $student->family_bond_guardian_student = "";
            $student->first_name_father = "";
            $student->second_name_father = "";
            $student->surname_father = "";
            $student->second_surname_father = "";
            $student->first_name_mother = "";
            $student->second_name_mother = "";
            $student->surname_mother = "";
            $student->second_surname_mother = "";
            $student->brothers_in_school = false;
            $student->previous_school = "";
            $student->student_illnesses = "";
            $student->observations = "";
            $student->code_for_user = "";
            $student->school_card = "";
            $student->profile_photo = "";
            $student->profile_photo_dir = "";
            $student->section_id = 1;
            $student->student_condition = "Regular";
            $student->scholarship = 0;
            $student->creative_user = $this->Auth->user('username');
            $student->student_migration = 0;
            $student->mi_id = 0;

			$incomeType = $student->number_of_brothers;

			$student->number_of_brothers = 0;

			$student->balance = 0;			

			
			if ($incomeType < 2)
			{
				$student->new_student = 1;
			}
			else
			{
				$student->new_student = 0;		
			}

			$student->respaldo_primer_ano_inscripcion = 0;
			$student->respaldo_ultimo_ano_inscripcion = 0;
			$student->respaldo_seccion_id = 1;
			$student->respaldo_nivel_de_estudio = "";	
				
            if ($this->Students->save($student)) 
            {
                $lastRecord = $this->Students->find('all', ['conditions' => ['creative_user' => $this->Auth->user('username')],
                'order' => ['Students.created' => 'DESC'] ]);

                $row = $lastRecord->first();

                if ($row)
                {
                    $this->Flash->success(__('El alumno fue guardado exitosamente'));

					
					if ($incomeType == 0)
					{
						$indicadorError = $studentTransactions->createQuotasNew($row->id, $lastYear);
					}
					elseif ($incomeType == 1)
					{
						$indicadorError = $studentTransactions->createQuotasNew($row->id, $currentYear);
					}
					else
					{
						$indicadorError = $studentTransactions->createQuotasRegular($row->id);	
					}					
					
					if ($indicadorError == 0)
					{
						return $this->redirect(['action' => 'indexAdminb', $idParentsandguardians]);
					}
					else
					{
						$this->Flash->error(__('No se pudieron generar las cuotas del estudiante'));
					}
                }
            } 
            $this->Flash->error(__('El alumno no fue guardado, por favor verifique los datos e intente nuevamente'));
        }
        
        $parentsandguardian = $this->Students->Parentsandguardians->get($idParentsandguardians);

        $this->set(compact('student', 'currentYear', 'nextYear', 'lastYear', 'idParentsandguardians'));
        $this->set('_serialize', ['student']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Student id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
 
    public function edit($id = null, $controller = null, $action = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
		$indicadorError = 0;
		
		$indicadorJulioPendiente = 0;
		
        $currentDate = Time::now();
		
		$currentYear = $currentDate->year;
		$lastYear = $currentDate->year - 1;
		$nextYear = $currentDate->year + 1;
		
		$this->loadModel('Schools');

        $school = $this->Schools->get(2);
		
	    $families = $this->Students->Parentsandguardians->find('list', ['keyField' => 'id', 'valueField' => 'family'])
						->where(['id' > 1, 'family !=' => ''])
						->order(['family' => 'ASC']);
	
        $studentTransactions = new StudenttransactionsController();

        $student = $this->Students->get($id);
        
        $parentsandguardian = $this->Students->Parentsandguardians->get($student->parentsandguardian_id);
		
        $sections = $this->Students->Sections->find('list', ['limit' => 200]);
				
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
            
            $student->brothers_in_school = 0;
		            
            if ($this->Students->save($student)) 
            {
				if ($student->new_student == 0)
				{	
					$transactionDescription = 'Matrícula ' . $school->current_year_registration;
			
					$studentTransaction = $this->Students->Studenttransactions->find('all')->where(['student_id' => $student->id, 'transaction_description' => $transactionDescription]);

					$results = $studentTransaction->toArray();

					if (!($results))
					{
						$indicadorError = $studentTransactions->createQuotasRegular($student->id);
					}
				}
				else
				{
					$transactionDescription = 'Matrícula ' . $school->current_year_registration;
			
					$studentTransaction = $this->Students->Studenttransactions->find('all')->where(['student_id' => $student->id, 'transaction_description' => $transactionDescription]);

					$results = $studentTransaction->toArray();

					if (!($results))
					{
						$transactionDescription = 'Matrícula ' . $school->next_year_registration;
			
						$studentTransaction = $this->Students->Studenttransactions->find('all')->where(['student_id' => $student->id, 'transaction_description' => $transactionDescription]);
	
						$results = $studentTransaction->toArray();
	
						if (!($results))
						{
							$indicadorError = $studentTransactions->createQuotasNew($student->id, $school->current_year_registration);
						}
					}					
				}
				
				if ($indicadorError == 0)
				{
					$this->Flash->success(__('Los datos se actualizaron exitosamente'));
				
					if (isset($controller))
					{
						return $this->redirect(['controller' => $controller, 'action' => $action, $id]);
					}
					else
					{
						return $this->redirect(['action' => 'editPhoto', $id]);
					}
				}
				else
				{
					$this->Flash->error(__('No se pudieron generar las cuotas del estudiante'));
				}
            }
            else 
            {
                $this->Flash->error(__('Los datos del alumno no se actualizaron, por favor verifique los datos e intente nuevamente'));
            }
        }
		else
		{
			if ($student->scholarship == false)
			{
				$transactionDescription = 'Jul ' . $school->current_year_registration;
					
				$busquedaJulioAnoAnterior = $this->Students->Studenttransactions->find('all')->where(['student_id' => $student->id, 'transaction_description' => $transactionDescription])->order(['id' => 'DESC']);

				$contadorRegistrosJulio = $busquedaJulioAnoAnterior->count();
				
				if ($contadorRegistrosJulio > 0)
				{				
					$registroJulio = $busquedaJulioAnoAnterior->first();
					
					$concept = 'Mensualidad';
					
					$this->loadModel('Rates');
			
					$busquedaMensualidad = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
					'order' => ['Rates.created' => 'DESC'] ]);

					$registroMensualidad = $busquedaMensualidad->first();

					if ($registroJulio->amount_dollar < $registroMensualidad->amount)
					{
						$indicadorJulioPendiente = 1;			
					}
				}
			}
		}

        $this->set(compact('student', 'parentsandguardian', 'currentYear', 'lastYear', 'nextYear', 'sections', 'families', 'indicadorJulioPendiente'));
        $this->set('_serialize', ['student', 'parentsandguardian', 'sections', 'families', 'indicadorJulioPendiente']);
    }
    
    public function reasignFamily($id = null, $controller = null, $action = null)
    {		
	    $families = $this->Students->Parentsandguardians->find('list', ['keyField' => 'id', 'valueField' => 'family'])
						->where(['id' > 1, 'family !=' => ''])
						->order(['family' => 'ASC']);
	
        $student = $this->Students->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
            	            
            if ($this->Students->save($student)) 
            {		
				$this->Flash->success(__('Los datos se actualizaron exitosamente'));
				
                if (isset($controller))
                {
                    return $this->redirect(['controller' => $controller, 'action' => $action, $id]);
                }
            }
            else 
            {
                $this->Flash->error(__('Los datos del alumno no se actualizaron, por favor verifique los datos e intente nuevamente'));
            }
        }    
        $this->set(compact('student', 'families'));
        $this->set('_serialize', ['student', 'families']);
    }
	
    public function reasignFamilyInt($id = null, $controller = null, $action = null)
    {				
		$student = $this->Students->get($id);
		
		$parentsandguardian = $this->Students->Parentsandguardians->get($student->parentsandguardian_id);
		
		if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
            	            
            if ($this->Students->save($student)) 
            {		
				$this->Flash->success(__('Los datos se actualizaron exitosamente'));
				
                if (isset($controller))
                {
                    return $this->redirect(['controller' => $controller, 'action' => $action, $id]);
                }
            }
            else 
            {
                $this->Flash->error(__('Los datos del alumno no se actualizaron, por favor verifique los datos e intente nuevamente'));
            }
        }    
        $this->set(compact('student', 'parentsandguardian'));
        $this->set('_serialize', ['student', 'parentsandguardian']);
    }
	
    public function editPhoto($id = null)
    {
        $student = $this->Students->get($id);
        
        $parentsandguardian = $this->Students->Parentsandguardians->get($student->parentsandguardian_id);

        if ($this->request->is(['patch', 'post', 'put'])) 
        {
			$student = $this->Students->patchEntity($student, $this->request->data);

			$archivoFoto = $student->profile_photo;
			
			if (isset($archivoFoto['name']))
			{
				$extensiones_permitidas = array('jpg', 'jpeg', 'gif', 'png');
				$extensionFoto = substr(strtolower(strrchr($archivoFoto['name'], '.')), 1);
				
				if ($extensionFoto != false)
				{						
					if (in_array($extensionFoto, $extensiones_permitidas))
					{
						if ($this->Students->save($student)) 
						{
							$this->Flash->success(__('La foto fue guardada exitosamente'));
							return $this->redirect(['action' => 'index']);
						}
						else 
						{
							$this->Flash->error(__('Los datos del alumno no se actualizaron, por favor verifique los datos e intente nuevamente'));
						}
					}
					else
					{
						$this->Flash->error(__('Estimado representante la foto debe tener alguna de estas extensiones: jpg, jpeg, gif o png'));
					}
				}
				else
				{
					$this->Flash->error(__('Estimado representante la foto debe tener alguna de estas extensiones: jpg, jpeg, gif o png'));
				}
			}
			else
			{
				$this->Flash->error(__('Estimado representante debe subir un archivo con alguna de estas extensiones: jpg, jpeg, gif o png'));
			}
        }    
        $this->set(compact('student', 'parentsandguardian'));
        $this->set('_serialize', ['student', 'parentsandguardian']);
    }

    
    public function editAdmin($idStudent = null, $idParentsandguardians = null)
    {
        $student = $this->Students->get($idStudent);

        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
            $student->user_id = 4;
            $student->code_for_user = " ";
            $student->school_card = " ";
            $student->profile_photo = "";
            $student->profile_photo_dir = "";
            $student->section_id = 1;
            $student->student_condition = "Regular";
            $student->scholarship = 0;
            $student->balance = 0;
            $student->creative_user = $this->Auth->user('username');

            if ($this->Students->save($student)) 
            {
                $this->Flash->success(__('El alumno fue guardado exitosamente'));

                return $this->redirect(['action' => 'indexAdmin', $idParentsandguardians]);
            } 
            else 
            {
                    $this->Flash->error(__('El alumno no fue guardado, por favor verifique los datos e intente nuevamente'));
            }
        }

        $parentsandguardian = $this->Students->Parentsandguardians->get($student->parentsandguardian_id);

        $this->set(compact('student', 'users', 'parentsandguardian'));
        $this->set('_serialize', ['student']);
    }

    public function editAdminb($idStudent = null, $idParentsandguardians = null)
    {
        $student = $this->Students->get($idStudent);

        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);

            if ($this->Students->save($student)) 
            {
                $this->Flash->success(__('El alumno fue guardado exitosamente'));

                return $this->redirect(['action' => 'indexAdminb', $idParentsandguardians]);
            } 
            else 
            {
                    $this->Flash->error(__('El alumno no fue guardado, por favor verifique los datos e intente nuevamente'));
            }
        }

        $parentsandguardian = $this->Students->Parentsandguardians->get($student->parentsandguardian_id);

        $this->set(compact('student', 'users', 'parentsandguardian'));
        $this->set('_serialize', ['student']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Student id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $student = $this->Students->get($id);

        $id = $student->user_id;

        if ($this->Students->delete($student)) 
        {
            $this->Flash->success(__('El alumno ha sido borrado'));

            $user = $this->Students->Users->get($id);

            if ($this->Students->Users->delete($user)) 
            {
                $this->Flash->success(__('Los datos de usuario del alumno han sido borrados'));
            } 
            else 
            {
                $this->Flash->error(__('Los datos de usuario del alumno no pudieron ser borrados, por favor intente nuevamente '));
            }
        } 
        else 
        {
            $this->Flash->error(__('El alumno no pudo ser borrado, por favor intente nuevamente'));  
        }
        return $this->redirect(['action' => 'index']);
    }

    public function guardian()
    {
        $student = $this->Students->newEntity();
        if ($this->request->is('post')) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);

            if ($student->parentsandguardian_id == null) 
                $this->Flash->error(__('No existe el representante'));
            else    
                return $this->redirect(['controller' => 'Students',   'action' => 'payments', $student->parentsandguardian_id, 'Inscripción']);
        }
        
        $this->set(compact('student'));

        $this->set('_serialize', ['student']);
    }

    public function monthlyPayment()
    {
    }

    public function payments($parentId = null, $description = null)
    {
        $parentsandguardian = $this->Students->Parentsandguardians->get($parentId);
        $balance = $parentsandguardian->balance;
        $query = $this->Students->find('all')->where(['parentsandguardian_id' => $parentId]);
        $this->set('students', $this->paginate($query));

        $this->set(compact('students', 'description', 'balance'));
        $this->set('_serialize', ['students']);
    }
    public function searchScholarship()
    {

    }
    public function enableScholarship($idParent = null)
    {
        if ($this->request->is('post'))
        {
            if (isset($_POST['idParent']))
            {
                $idParent = $_POST['idParent'];
            }
        }
        
        $query = $this->Students->find('all')
            ->where(['parentsandguardian_id' => $idParent])
            ->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC']);

        $this->set('students', $this->paginate($query));
        $this->set('_serialize', ['students']);
    }
    public function studentScholarship($studentId = null, $parentId = null)
    {
        $this->autoRender = false;

        $student = $this->Students->get($studentId, [
            'contain' => []
        ]);

        $student->scholarship = 1;
		$student->tipo_descuento = "Becado";
		$student->discount = 100;
        
        if ($this->Students->save($student)) 
        {
            $this->Flash->success(__('El alumno fue becado exitosamente'));

            return $this->redirect(['action' => 'enableScholarship', $parentId]);
        }
        else 
        {
            $this->Flash->error(__('El alumno no pudo ser becado, por favor intente nuevamente'));
        }
    }    

    public function deleteScholarship($studentId = null, $parentId = null)
    {
        $this->autoRender = false;

        $student = $this->Students->get($studentId, [
            'contain' => []
        ]);

        $student->scholarship = 0;
		$student->tipo_descuento = "";
		$student->discount = 0;
        
        if ($this->Students->save($student)) 
        {
            $this->Flash->success(__('La beca fue eliminada exitosamente'));
            
            if ($parentId == null)
                return $this->redirect(['controller' => 'Studenttransactions', 'action' => 'scholarshipIndex']);
            else    
                return $this->redirect(['controller' => 'Students', 'action' => 'enableScholarship', $parentId]);
        }
        else 
        {
            $this->Flash->error(__('La beca no pudo ser eliminada, por favor intente nuevamente'));
        }
    } 

    public function everyFamily()
    {
        $this->autoRender = false;

        if ($this->request->is('json')) 
        {
            $jsondata = [];

            $parentsandguardians = $this->Students->Parentsandguardians->find('all')->where([['Parentsandguardians.new_guardian' => $_POST['newFamily']], ['Parentsandguardians.guardian !=' => 1]])->order(['Parentsandguardians.family' => 'ASC']);

            $results = $parentsandguardians->toArray();

            if ($results) 
            {
                $jsondata["success"] = true;
                $jsondata["data"]["message"] = "Se encontraron familias";
                $jsondata["data"]["families"] = [];

                foreach ($results as $result)
                {
                    if ($result->id > 1)
                    {
                        $jsondata["data"]["families"][]['id'] = $result->id;
                        $jsondata["data"]["families"][]['family'] = $result->family;
                        $jsondata["data"]["families"][]['surname'] = $result->surname;
                        $jsondata["data"]["families"][]['first_name'] = $result->first_name;
                    }
                }
            }
            else
            { 
          
                $jsondata["success"] = false;
                $jsondata["data"]["message"] = "No se encontraron familias";
            }
            exit(json_encode($jsondata, JSON_FORCE_OBJECT));

        }
    }
    
    public function relatedStudents()
    {
        $this->autoRender = false;

        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
				
		$anioEscolarActual = $school->current_school_year;
		$proximoAnioEscolar = $anioEscolarActual + 1;
      
        $studenttransactions = new StudenttransactionsController();
		$representantes = new ParentsandguardiansController();
		
		$tasaTemporalDolar = 0;
		$tasaTemporalEuro = 0;
				
        if ($this->request->is('json')) 
        {
            if(isset($_POST['id']))
            {
                $parentId = $_POST['id'];
				$opcionMenu = $_POST['opcionMenu'];
                $new = $_POST['new'];
				
				if (isset($_POST['tasaTemporalDolar']))
				{
					if (substr($_POST['tasaTemporalDolar'], -3, 1) == ',')
					{
						$replace1= str_replace('.', '', $_POST['tasaTemporalDolar']);
						$replace2 = str_replace(',', '.', $replace1);
						$tasaTemporalDolar = $replace2;
					}
					else
					{
						$tasaTemporalDolar = $_POST['tasaTemporalDolar'];
					}
				}
				
				if (isset($_POST['tasaTemporalEuro']))
				{
					if (substr($_POST['tasaTemporalEuro'], -3, 1) == ',')
					{
						$replace1= str_replace('.', '', $_POST['tasaTemporalEuro']);
						$replace2 = str_replace(',', '.', $replace1);
						$tasaTemporalEuro = $replace2;
					}
					else
					{
						$tasaTemporalEuro = $_POST['tasaTemporalEuro'];
					}
				}
            }
            else 
            {
                die("Solicitud no válida.");
            }
			
			$this->loadModel('Monedas');
			
			if ($tasaTemporalDolar == 0)
			{	
				$moneda = $this->Monedas->get(2);
				$dollarExchangeRate = $moneda->tasa_cambio_dolar;
			}
			else
			{
				$dollarExchangeRate = $tasaTemporalDolar;
			}
							
			if ($tasaTemporalEuro == 0)
			{
				$moneda = $this->Monedas->get(3);
				$euro = $moneda->tasa_cambio_dolar;
			}
			else
			{
				$euro = $tasaTemporalEuro;
			}
			
			$mesesTarifas = $this->mesesTarifas($tasaTemporalDolar);	

			$otrasTarifas = $this->otrasTarifas($tasaTemporalDolar);
			    
            $currentDate = Time::now();
            
            if ($currentDate->day < 10)
            {
                $dd = "0" . $currentDate->day;
            }
            else
            {
                $dd = $currentDate->day;
            }

            if ($currentDate->month < 10)
            {
                $mm = "0" . $currentDate->month;
            }
            else
            {
                $mm = $currentDate->month;
            }
            
            $yyyy = $currentDate->year;
            
            $today = $dd . "/" . $mm . "/" . $yyyy;
            
            $reversedDate = $yyyy . "/" . $mm . "/" . $dd;

            $jsondata = [];

            $parentsandguardians = $this->Students->Parentsandguardians->get($parentId);

            $jsondata["success"] = true;
            $jsondata["data"]["message"] = "Se encontraron familias";
            $jsondata["data"]['parentsandguardian_id'] = $parentsandguardians->id;
            $jsondata["data"]['family'] = $parentsandguardians->family;
            $jsondata["data"]['first_name'] = $parentsandguardians->first_name;
            $jsondata["data"]['surname'] = $parentsandguardians->surname;
            $jsondata["data"]['today'] = $today;
            $jsondata["data"]['reversedDate'] = $reversedDate;
            $jsondata["data"]['client'] = $parentsandguardians->client;
            $jsondata["data"]['type_of_identification_client'] = $parentsandguardians->type_of_identification_client;
            $jsondata["data"]['identification_number_client'] = $parentsandguardians->identification_number_client;
            $jsondata["data"]['fiscal_address'] = $parentsandguardians->fiscal_address;
            $jsondata["data"]['tax_phone'] = $parentsandguardians->tax_phone;
            $jsondata["data"]['email'] = $parentsandguardians->email;
			$jsondata["data"]['balance'] = $parentsandguardians->balance;
			$jsondata["data"]['dollar_exchange_rate'] = $dollarExchangeRate;
			$jsondata["data"]['euro'] = $euro;
			$jsondata["data"]['meses_tarifas'] = $mesesTarifas;
			$jsondata["data"]['otras_tarifas'] = $otrasTarifas;
			
			if ($opcionMenu == "Recibo Consejo Educativo")
			{
				$representantes = new ParentsandguardiansController();
				$jsondata['data']['consejo_educativo'] = $representantes->busquedaConsejoEducativo($anioEscolarActual, $proximoAnioEscolar, $parentsandguardians);
			}
			else
			{
				$jsondata["data"]["students"] = [];
				
				if ($new == 0)
				{
					$students = $this->Students->find('all')->where([['parentsandguardian_id' => $parentId], ['new_student' => 0], ['Students.student_condition' => 'Regular']])
					->order(['Students.first_name' => 'ASC', 'Students.surname' => 'ASC']);
				}
				elseif ($new == 1)
				{
					$students = $this->Students->find('all')->where([['parentsandguardian_id' => $parentId], ['new_student' => 1], ['Students.student_condition' => 'Regular']])
					->order(['Students.first_name' => 'ASC', 'Students.surname' => 'ASC']);
				}
				else
				{
					$students = $this->Students->find('all')->where([['parentsandguardian_id' => $parentId], ['Students.student_condition' => 'Regular']])
					->order(['Students.first_name' => 'ASC', 'Students.surname' => 'ASC']);
				}

				$results = $students->toArray();

				if ($results)
				{
					foreach ($results as $result)
					{
						$sections = $this->Students->Sections->get($result->section_id);
						$transacciones = $studenttransactions->responsejson($result->id);
						
						$jsondata["data"]["students"][] = 
							[
								'id' => $result->id,
								'surname' => $result->surname,
								'second_surname' => $result->second_surname,
								'first_name' => $result->first_name,
								'second_name' => $result->second_name,
								'level_of_study' => $result->level_of_study,
								'becado_ano_anterior' => $result->becado_ano_anterior,
								'scholarship' => $result->scholarship,
								'schoolYearFrom' => $result->balance,
								'descuento_ano_anterior' => $result->descuento_ano_anterior,
								'discount_family' => $result->discount,
								'sublevel' => $sections->sublevel,
								'section' => $sections->section,
								'orden_grado' => $sections->orden,
								'alumno_nuevo' => $result->new_student,
								'servicio_educativo_exonerado' => $result->servicio_educativo_exonerado,
								'studentTransactions' => json_decode($transacciones) 
							];
					}
				}
			}
            
            exit(json_encode($jsondata, JSON_FORCE_OBJECT));
        }
    }
    public function searchForStudent()
    {
        $this->autoRender = false;

        $studenttransactions = new StudenttransactionsController();

        if ($this->request->is('json')) 
        {

            if(isset($_POST['id'])) 
                $studentId = $_POST['id'];
            else 
                die("Solicitud no válida.");

            $jsondata = [];

            $students = $this->Students->get($studentId);

            $jsondata["success"] = true;
            $jsondata["data"]["message"] = "Se encontró el alumno";
            $jsondata["data"]["first_name"] = $students->first_name;
            $jsondata["data"]["surname"] = $students->surname;
        
            $sections = $this->Students->Sections->get($students->section_id);
                    
            $jsondata["data"]["sublevel"] = $sections->sublevel;
            $jsondata["data"]["section"] = $sections->section;

            $jsondata["data"]["scholarship"] = $students->scholarship;

            $variable = $studenttransactions->responsejson($studentId);
            
            $jsondata["data"]["studenttransactions"] = []; 
            
            $jsondata["data"]["studenttransactions"] = json_decode($variable); 

            exit(json_encode($jsondata, JSON_FORCE_OBJECT));
        }
    }
    public function listStudentsSection()
    {
        $students = $this->paginate($this->Students);   

        $this->set(compact('students'));
        $this->set('_serialize', ['students']);
    }

    public function listMonthlyPayments()
    {
        if ($this->request->is('post')) 
        {
            return $this->redirect(['action' => 'relationpdf', $_POST['section_id']]);
        }

        $sections = $this->Students->Sections->find('list', ['limit' => 200, 'order'=> ['orden' => 'ASC']]);
        
        $this->set(compact('sections'));
    }

    public function relationpdf($section = null)
    {		
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
				
		$yearFrom = $school->current_school_year;
		$yearUntil = $yearFrom + 1;
			
        $yearMonthFrom = $yearFrom . '08';
        
        $yearMonthUp = $yearUntil . '08';

        $nameSection = $this->Students->Sections->get($section);
        
        $level = $this->sublevelLevel($nameSection->sublevel);

        $students = $this->Students->find('all')
            ->where([['id >' => 1], ['section_id' => $section], ['balance >=' => $yearFrom], ['Students.student_condition' => 'Regular']])
            ->order(['surname' => 'ASC', 'second_surname' => 'ASC', 'first_name' => 'ASC', 'second_name' => 'ASC']);

        $monthlyPayments = [];
        
        $accountantManager = 0;

		foreach ($students as $student) 
		{
			$studentTransactions = $this->Students->Studenttransactions->find('all')->where(['student_id' => $student->id]);

			$swSignedUp = 0;

			foreach ($studentTransactions as $studentTransaction) 
			{
				if ($studentTransaction->transaction_description == 'Matrícula ' . $yearFrom)
				{
					if ($studentTransaction->amount_dollar > 0)
					{
						$swSignedUp = 1;
					}
				}
			}                    

			if ($swSignedUp == 1)
			{
				$monthlyPayments[$accountantManager]['student'] = $student->full_name;
			
				$monthlyPayments[$accountantManager]['studentTransactions'] = [];
				
				if ($student->scholarship == true)
				{
					$monthlyPayments[$accountantManager]['tipoDescuento'] = "Completo";
					$monthlyPayments[$accountantManager]['descuento'] = 100;
				}
				elseif ($student->discount === null || $student->discount == 0)
				{
					$monthlyPayments[$accountantManager]['tipoDescuento'] = "";
					$monthlyPayments[$accountantManager]['descuento'] = 0;
				}
				else
				{
					$monthlyPayments[$accountantManager]['tipoDescuento'] = $student->tipo_descuento;
					$monthlyPayments[$accountantManager]['descuento'] = $student->discount;
				}

				foreach ($studentTransactions as $studentTransaction) 
				{
					if ($studentTransaction->transaction_type == "Mensualidad")
					{
						$month = substr($studentTransaction->transaction_description, 0, 3);
						
						$year = substr($studentTransaction->transaction_description, 4, 4);
						
						$numberOfTheMonth = $this->nameMonth($month);
						
						$yearMonth = $year . $numberOfTheMonth;
						
						if ($yearMonth > $yearMonthFrom && $yearMonth < $yearMonthUp)
						{
							if ($student->scholarship == 1)
							{
								$monthlyPayments[$accountantManager]['studentTransactions'][]['monthlyPayment'] = 'B';
							}
							else
							{
								if ($studentTransaction->paid_out == 1)
								{
									$indicadorPagado = $this->verificarDiferencia($studentTransaction);

									$monthlyPayments[$accountantManager]['studentTransactions'][]['monthlyPayment'] = $indicadorPagado;
								}
								else
								{
									$monthlyPayments[$accountantManager]['studentTransactions'][]['monthlyPayment'] = 'P';
								}
							}
						}
					}
				}  
			}
			$accountantManager++;
        }

        $this->set(compact('nameSection', 'monthlyPayments', 'yearFrom', 'yearMonthFrom', 'yearMonthUp'));
    }
    
    public function relationPayments($schoolperiod = null, $section = null)
    {
        $yearFrom = substr($schoolperiod, 0, 4);

        $yearMonthFrom = substr($schoolperiod, 0, 4) . '08';
        
        $yearMonthUp = substr($schoolperiod, 5, 4) . '08';

        $nameSection = $this->Students->Sections->get($section);
        
        $level = $this->sublevelLevel($nameSection->sublevel);

        $students = $this->Students->find('all')
            ->where([['id >' => 1], ['section_id' => $section], ['level_of_study' => $level], ['Students.student_condition' => 'Regular']])
            ->order(['surname' => 'ASC', 'second_surname' => 'ASC', 'first_name' => 'ASC', 'second_name' => 'ASC']);

        $monthlyPayments = [];
        
        $accountantManager = 0;

        $this->loadModel('Schools');

        $school = $this->Schools->get(2);

        $this->loadModel('Rates');
        
        $concept = 'Matrícula';
        
        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
           'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();

        if($row)
        {
            foreach ($students as $student) 
            {
                $studentTransactions = $this->Students->Studenttransactions->find('all')->where(['student_id' => $student->id]);

                $swSignedUp = 0;

                foreach ($studentTransactions as $studentTransaction) 
                {
                    if ($studentTransaction->transaction_description == 'Matrícula ' . $yearFrom)
                    {
                        if ($studentTransaction->amount < $row->amount)
                        {
                            $swSignedUp = 1;
                        }
                    }
                }                    

                if ($swSignedUp == 1)
                {
                    $monthlyPayments[$accountantManager]['student'] = $student->full_name;
                
                    $monthlyPayments[$accountantManager]['studentTransactions'] = [];

                    foreach ($studentTransactions as $studentTransaction) 
                    {
                        if ($studentTransaction->transaction_type == "Mensualidad")
                        {
                            $month = substr($studentTransaction->transaction_description, 0, 3);
                            
                            $year = substr($studentTransaction->transaction_description, 4, 4);
                            
                            $numberOfTheMonth = $this->nameMonth($month);
                            
                            $yearMonth = $year . $numberOfTheMonth;
                            
                            if ($yearMonth > $yearMonthFrom && $yearMonth < $yearMonthUp)
                            {
                                if ($student->scholarship == 1)
                                {
                                    $monthlyPayments[$accountantManager]['studentTransactions'][]['monthlyPayment'] = 'B';
                                }
                                else
                                {
                                    if ($studentTransaction->paid_out == 1)
                                    {
                                        $monthlyPayments[$accountantManager]['studentTransactions'][]['monthlyPayment'] = '*';    
                                    }
                                    else
                                    {
                                        $monthlyPayments[$accountantManager]['studentTransactions'][]['monthlyPayment'] = 'P'; 
                                    }
                                }
                            }
                        }
                    }  
                }
                $accountantManager++;
            }
        }

        $this->set(compact('nameSection', 'monthlyPayments', 'yearFrom', 'yearMonthFrom', 'yearMonthUp'));
    }
	
    function nameMonth($month = null)
    {
        $monthsSpanish = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $monthsEnglish = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        $spanishMonth = str_replace($monthsEnglish, $monthsSpanish, $month);
        return $spanishMonth;
    }
    
    
    public function newRegistration()
    {
        
    }

    public function registerNewStudents()
    {
		
    }

    public function newstudentpdf()
    {
        $newStudents = [];
        $accountantManager = 0;
        $newLevel = " ";
        $newStudent = " ";
        $paidOut = 0;
        $totalPaid = 0;
        $totalPayable = 0;

        $this->viewBuilder()
            ->className('Dompdf.Pdf')
            ->layout('default')
            ->options(['config' => [
                'filename' => "nuevos",
                'render' => 'browser',
            ]]);

        $students = $this->Students->find('all')->where(['Students.student_condition like' => 'Alumno nuevo%'])->order(['Students.level_of_study' => 'ASC', 
            'Students.surname' => 'ASC', 'Students.second_surname' => 'ASC',
            'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC']);;

        foreach ($students as $student) 
        {
            $studentTransactions = $this->Students->Studenttransactions->find('all')->where(['student_id' => $student->id, 'OR' => [['transaction_description' => 'Matrícula 2017'], ['transaction_description' => 'Servicio educativo 2017'], ['transaction_description' => 'Ago 2018']]]);
                
            foreach ($studentTransactions as $studentTransaction) 
            {
                if ($newLevel != $student->level_of_study)
                {
                    $newStudents[$accountantManager]['levelOfStudy'] = $student->level_of_study;
                    $newLevel = $student->level_of_study;
                }
                else
                {
                    $newStudents[$accountantManager]['levelOfStudy'] = " ";
                }
                if ($newStudent != $student->full_name)
                {
                    $newStudents[$accountantManager]['nameStudent'] = $student->full_name;
                    $newStudents[$accountantManager]['id'] = $student->id;
                    $newStudent = $student->full_name;
                }
                else
                {
                    $newStudents[$accountantManager]['nameStudent'] = " ";
                }
                
                $newStudents[$accountantManager]['transactionDescription'] = $studentTransaction->transaction_description;
                
                $paidOut = $studentTransaction->original_amount - $studentTransaction->amount;
                
                $newStudents[$accountantManager]['paidOut'] = $paidOut;
                
                $newStudents[$accountantManager]['toPay'] = $studentTransaction->amount;
                
                $totalPaid = $totalPaid + $paidOut;
                
                $totalPayable = $totalPayable + $studentTransaction->amount;
                
                $accountantManager++;
            }
        }
        
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
        
        $currentDate = Time::now();

        $this->set(compact('newStudents', 'totalPaid', 'totalPayable', 'currentDate'));
    }
    
    public function indexStudents()
    {
        
    }
    
    public function filepdf($id = null, $controlador = null, $accion = null)
    {
		$ultimoAnoInscripcion = 0;

		$this->loadModel('Schools');

        $school = $this->Schools->get(2);
	
		$usuarioActual = $this->Auth->user('username');
	
		$currentDate = Time::now();
		
		$currentYearRegistration = $school->current_year_registration;
		
        $student = $this->Students->get($id);
		
		$indicadorDescarga = 0;

		$anioInicioPeriodoActual = $school->current_school_year;
        $indicadorExoneradoDiferenciasInscripcion = 'No';
        $indicadorDeudaInscripcion = 'No';
		
		if ($student->profile_photo != "" && $student->profile_photo != " " && $student->profile_photo != "Sin foto")
		{
			$extensiones_permitidas = array('jpg', 'jpeg', 'gif', 'png');
			$extensionFoto = substr(strtolower(strrchr($student->profile_photo, '.')), 1);
			if ($extensionFoto != false)
			{	
				if (in_array($extensionFoto, $extensiones_permitidas))
				{
					$indicadorDescarga = 1;
				}
			}
		}
	
		if ($usuarioActual == 'angel2703' || $usuarioActual == 'adminsg' || $usuarioActual == 'evelin')
		{
			$indicadorDescarga = 1;
		}
		
		if ($indicadorDescarga == 1)
		{
			$matriculasEstudiante = $this->Students->Studenttransactions->find('all')->where(['student_id' => $id, 'transaction_type' => 'Matrícula'])->order(['id' => 'DESC']);

			$ultimaMatricula = $matriculasEstudiante->first();

			$ultimoAnoInscripcion =  substr($ultimaMatricula->transaction_description, 11, 4);

			$brothers = $this->Students->find('all')->where(['parentsandguardian_id' => $student->parentsandguardian_id, 'id !=' => $id]);

			$brothersArray = $brothers->toArray();
			
			$brothersPdf = [];
			$account = 0;
			
			if ($brothersArray):
				foreach ($brothersArray as $brothersArrays):
					$brothersPdf[$account]['nameStudent'] = $brothersArrays['surname'] . ' ' . $brothersArrays['first_name'];
					$brothersPdf[$account]['gradeStudent'] = $brothersArrays['level_of_study'];
					$account++;
				endforeach;
			endif;
			
			$parentsandguardian = $this->Students->Parentsandguardians->get($student->parentsandguardian_id);

			$controladorTransaccionesEstudiantes = new StudenttransactionsController();
			$respuestaBuscarDeudasInscripcion = $controladorTransaccionesEstudiantes->buscarDeudasInscripcion($parentsandguardian, $anioInicioPeriodoActual);
			$indicadorExoneradoDiferenciasInscripcion = $respuestaBuscarDeudasInscripcion['indicadorExoneradoDiferenciasInscripcion'];
			$indicadorDeudaInscripcion = $respuestaBuscarDeudasInscripcion['indicadorDeudaInscripcion'];
		}
		else
		{
			$this->Flash->error(__('Estimado usuario, antes de imprimir la ficha de inscripción debe subir una foto de perfil del estudiante con alguna de estas extensiones: .gif, .jpeg, .jpg y .png'));
			
			if (isset($origen) && $origen == "viewStudent")
			{
				return $this->redirect(['controller' => 'Students', 'action' => 'indexConsult']);	
			}
			else
			{
				return $this->redirect(['controller' => 'Students', 'action' => 'index']);
			}
		}
		$this->set(compact('student', 'brothersPdf', 'parentsandguardian', 'currentYearRegistration', 'currentDate', 'ultimoAnoInscripcion', 'controlador', 'accion', 'indicadorExoneradoDiferenciasInscripcion', 'indicadorDeudaInscripcion'));
		$this->set('_serialize', ['student', 'brothersPdf', 'parentsandguardian', 'currentYearRegistration', 'currentDate', 'ultimoAnoInscripcion', 'controlador', 'accion', 'indicadorExoneradoDiferenciasInscripcion', 'indicadorDeudaInscripcion']);
    }
    
    public function cardboardpdf($id = null)
    {
        $student = $this->Students->get($id);
        
        $this->viewBuilder()
            ->className('Dompdf.Pdf')
            ->layout('default')
            ->options(['config' => [
                'filename' => $student->full_name,
                'render' => 'browser'
            ]]);

        $this->set(compact('student'));
        $this->set('_serialize', ['student']);
    }

    public function profilePhoto($id = null)
    {
        $this->set(compact('id'));
    }
    
    public function consultStudent()
    {
        
    }
	
    public function consultStudentDelete()
    {
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);
	
		$this->set(compact('school'));
		$this->set('_serialize', ['school']);		
    }
    
    public function modifyTransactions()
    {
        
    }

    public function findStudent()
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $name = trim($this->request->query['term']);
            $results = $this->Students->find('all', [
                'conditions' => [['surname LIKE' => $name . '%'], ['Students.student_condition' => 'Regular']],
				'order' => ['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]]);
            $resultsArr = [];
            foreach ($results as $result) {
                 $resultsArr[] = ['label' => $result['surname'] . ' ' . $result['second_surname'] . ' ' . $result['first_name'] . ' ' . $result['second_name'], 'value' => $result['surname'] . ' ' . $result['second_surname'] . ' ' . $result['first_name'] . ' ' . $result['second_name'], 'id' => $result['id']];
            }
			exit(json_encode($resultsArr, JSON_FORCE_OBJECT));
        }
    }
    public function buscarEstudiantesRepresentante($idRepresentante = null)
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $name = trim($this->request->query['term']);
            $results = $this->Students->find('all', [
                'conditions' => [['surname LIKE' => $name . '%'], ['Students.student_condition' => 'Regular'], ['Students.parentsandguardian_id' => $idRepresentante]],
				'order' => ['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]]);
            $resultsArr = [];
            foreach ($results as $result) {
                 $resultsArr[] = ['label' => $result['surname'] . ' ' . $result['second_surname'] . ' ' . $result['first_name'] . ' ' . $result['second_name'], 'value' => $result['surname'] . ' ' . $result['second_surname'] . ' ' . $result['first_name'] . ' ' . $result['second_name'], 'id' => $result['id'], 'idRepresentante' => $idRepresentante];
            }
			exit(json_encode($resultsArr, JSON_FORCE_OBJECT));
        }
    }
    public function findStudentDelete()
    {
        $this->autoRender = false;
		if ($this->request->is('ajax')) {
            $name = trim($this->request->query['term']);
            $results = $this->Students->find('all', [
                'conditions' => [['surname LIKE' => $name . '%'], ['Students.student_condition !=' => 'Regular']],
				'order' => ['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]]);
            $resultsArr = [];
            foreach ($results as $result) {
                 $resultsArr[] = ['label' => $result['surname'] . ' ' . $result['second_surname'] . ' ' . $result['first_name'] . ' ' . $result['second_name'], 'value' => $result['surname'] . ' ' . $result['second_surname'] . ' ' . $result['first_name'] . ' ' . $result['second_name'], 'id' => $result['id']];
            }
			exit(json_encode($resultsArr, JSON_FORCE_OBJECT));
        }
    }
    public function reportGraduateStudents()
    {
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);

		$anterior_anio_inscripcion = $school->previous_year_registration;
			
		$currentYearRegistration = $school->current_year_registration;

		$students = TableRegistry::get('Students');

		$studentsFor = $students->find()
			->contain(['Parentsandguardians', 'Sections'])
			->where([['Students.id >' => 1],
				['Students.student_condition' => 'Regular'],
				['Students.balance' => $anterior_anio_inscripcion]])
			->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);
		
		$transacciones_estudiantes = TableRegistry::get('Studenttransactions');

		$matriculas_estudiantes = $transacciones_estudiantes->find()
			->where(['Studenttransactions.transaction_description' => "Matrícula ".$currentYearRegistration,
				'Studenttransactions.amount_dollar >' => 0]);
	  
		$currentDate = Time::now();
		
		$accountRecord = $studentsFor->count();

		$totalPages = ceil($accountRecord / 20);
		
		$this->set(compact('school', 'studentsFor', 'totalPages', 'currentDate', 'currentYearRegistration', 'anterior_anio_inscripcion', 'matriculas_estudiantes'));
		$this->set('_serialize', ['school', 'studentsFor', 'totalPages', 'currentDate', 'currentYearRegistration', 'anterior_anio_inscripcion', 'matriculas_estudiantes']);
    }
    public function SublevelLevel($sublevel = null)
    {
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

        $level = str_replace($sub, $levelOfStudy, $sublevel);
        return $level;
    }
	public function defaulters()
	{
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
               
        $currentDate = Time::now();
		
		$currentYear = $currentDate->year;
		$currentMonth = $currentDate->month;
		
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
		
		$this->loadModel('Rates');
		
		$this->loadModel('Monedas');	
		$moneda = $this->Monedas->get(2);
		$dollarExchangeRate = $moneda->tasa_cambio_dolar; 
				
		$mesesTarifas = $this->mesesTarifas(0);
						
		$yearFrom = $school->current_school_year;
		$yearUntil = $yearFrom + 1;
				
		$yearMonthFrom = $yearFrom . '09';
		
        if ($currentDate->month < 10)
        {
            $monthUntil = "0" . $currentDate->month;
        }
        else
        {
            $monthUntil = $currentDate->month;
        }
		
		$yearMonthUntil = $currentYear . $monthUntil;
					
		$yearMonthEnd = $yearUntil . '07';
				
		$totalDebt = 0;
			
        $students = TableRegistry::get('Students');
        
        $arrayResult = $students->find('regular');
        
        if ($arrayResult['indicator'] == 1)
		{
			$this->Flash->error(___('No se encontraron alumnos regulares'));
			
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
		}
		
		$studentsFor = $arrayResult['searchRequired'];

		$defaulters = [];
        
		$accountantManager = 0;	
		
		$defaulters[$accountantManager]['section'] = '';
		$defaulters[$accountantManager]['one'] = 0;
		$defaulters[$accountantManager]['two'] = 0;
		$defaulters[$accountantManager]['three'] = 0;
		$defaulters[$accountantManager]['four'] = 0;
		$defaulters[$accountantManager]['fiveMore'] = 0;
		$defaulters[$accountantManager]['solvents'] = 0;
		$defaulters[$accountantManager]['defaulters'] = 0;
		$defaulters[$accountantManager]['prepaid'] = 0;
		$defaulters[$accountantManager]['scholarship'] = 0;	

		$tDefaulters = [];
			
		$tDefaulters[0]['section'] = '';
		$tDefaulters[0]['one'] = 0;
		$tDefaulters[0]['two'] = 0;
		$tDefaulters[0]['three'] = 0;
		$tDefaulters[0]['four'] = 0;
		$tDefaulters[0]['fiveMore'] = 0;
		$tDefaulters[0]['solvents'] = 0;
		$tDefaulters[0]['defaulters'] = 0;
		$tDefaulters[0]['prepaid'] = 0;
		$tDefaulters[0]['scholarship'] = 0;
		$tDefaulters[0]['totalStudents'] = 0;
		
		$swSection = 0;
				
		foreach ($studentsFor as $studentsFors)
		{		
			$nameSection = $this->Students->Sections->get($studentsFors->section_id);
			
			if ($studentsFors->section_id > 1)
			{				
				$delinquentMonths = 0;
				
				$wholeYear = 0;
				
				$swSignedUp = 0;
				
				$scholarship = 0;
				
				if ($studentsFors->scholarship == 1)
				{
					$scholarship = 1;
				}
				else
				{				
					$studentTransactions = $this->Students->Studenttransactions->find('all')->where(['student_id' => $studentsFors->id]);

					foreach ($studentTransactions as $studentTransaction) 
					{
						if ($studentTransaction->transaction_description == 'Matrícula ' . $yearFrom)
						{
							if ($studentTransaction->amount_dollar > 0)
							{
								$swSignedUp = 1;
							}
							break;						
						}
					}
					if ($swSignedUp == 1)
					{
						foreach ($studentTransactions as $studentTransaction)
						{
							if ($studentTransaction->transaction_type == "Mensualidad")
							{
								$month = substr($studentTransaction->transaction_description, 0, 3);
									
								$year = substr($studentTransaction->transaction_description, 4, 4);
									
								$numberOfTheMonth = $this->nameMonth($month);
									
								$yearMonth = $year . $numberOfTheMonth;
									
								if ($yearMonth >= $yearMonthFrom && $yearMonth <= $yearMonthEnd)
								{
									if ($studentTransaction->paid_out == 0)
									{
										$wholeYear = 1;
										
										if ($yearMonth <= $yearMonthUntil)
										{
											foreach ($mesesTarifas as $mesesTarifa)
											{
												if ($mesesTarifa["anoMes"] == $yearMonth)
												{
													$amountMonthly = $mesesTarifa["tarifaBolivar"];
													break;
												}
											}
											$delinquentMonths++;
											$totalDebt = $totalDebt + $amountMonthly;
										}
									}
									else
									{
										foreach ($mesesTarifas as $mesesTarifa)
										{
											if ($mesesTarifa["anoMes"] == $yearMonth)
											{
												$tarifaDolarAnoMes = $mesesTarifa["tarifaDolar"];
												if ($studentTransaction->porcentaje_descuento > 0)
												{
													$tarifaDolarAnoMes = ($tarifaDolarAnoMes * $studentTransaction->porcentaje_descuento) / 100;
												}
												break;
											}
										}
										if ($studentTransaction->amount_dollar < $tarifaDolarAnoMes)
										{
											$wholeYear = 1;

											if ($yearMonth <= $yearMonthUntil)
											{											
												$diferenciaDolares = $tarifaDolarAnoMes - $studentTransaction->amount_dolar;
												$diferenciaBolivares = round($diferenciaDolares * $dollarExchangeRate);
											
												$delinquentMonths++;
												$totalDebt = $totalDebt + $diferenciaBolivares;
											}
										}
									}
								}	
							}
						}	
					}	
				}
				if ($scholarship == 1 || $swSignedUp == 1)
				{
					if ($swSection == 0)
					{
						$swSection = 1;
						
						$previousSection = $studentsFors->section_id;
						
						$defaulters[$accountantManager]['section'] = $nameSection->full_name;
						
						$arrayGeneral = $this->addCounter($defaulters, $accountantManager, $tDefaulters, $delinquentMonths, $wholeYear, $scholarship, $studentsFors->full_name);
						
						$defaulters = $arrayGeneral[0];
						
						$accountantManager = $arrayGeneral[1];

						$tDefaulters = $arrayGeneral[2];
					}
					else
					{
						if ($previousSection == $studentsFors->section_id)
						{				
							$arrayGeneral = $this->addCounter($defaulters, $accountantManager, $tDefaulters, $delinquentMonths, $wholeYear, $scholarship, $studentsFors->full_name);
						
							$defaulters = $arrayGeneral[0];
						
							$accountantManager = $arrayGeneral[1]; 		

							$tDefaulters = $arrayGeneral[2];
						}
						else
						{
							$previousSection = $studentsFors->section_id;
						
							$accountantManager++;		
							
							$defaulters[$accountantManager]['section'] = $nameSection->full_name;	
							$defaulters[$accountantManager]['one'] = 0;
							$defaulters[$accountantManager]['two'] = 0;
							$defaulters[$accountantManager]['three'] = 0;
							$defaulters[$accountantManager]['four'] = 0;
							$defaulters[$accountantManager]['fiveMore'] = 0;
							$defaulters[$accountantManager]['solvents'] = 0;
							$defaulters[$accountantManager]['defaulters'] = 0;
							$defaulters[$accountantManager]['prepaid'] = 0;	
							$defaulters[$accountantManager]['scholarship'] = 0;

							$arrayGeneral = $this->addCounter($defaulters, $accountantManager, $tDefaulters, $delinquentMonths, $wholeYear, $scholarship, $studentsFors->full_name);
						
							$defaulters = $arrayGeneral[0];
						
							$accountantManager = $arrayGeneral[1]; 

							$tDefaulters = $arrayGeneral[2];
						}
					}
				}
			}
		}
		$this->set(compact('school', 'defaulters', 'tDefaulters', 'totalDebt', 'currentDate'));
	}
	
	public function addCounter($defaulters = null, $accountantManager = null, $tDefaulters = null, $delinquentMonths = null, $wholeYear = null, $scholarship = null, $alumno = null)
	{
		if ($scholarship == 1)
		{
			$defaulters[$accountantManager]['scholarship']++;
			$tDefaulters[0]['scholarship']++;
			$tDefaulters[0]['totalStudents']++;
			
		}
		else
		{
			if ($delinquentMonths == 0) 
			{
				$defaulters[$accountantManager]['solvents']++;
				$tDefaulters[0]['solvents']++;
				$tDefaulters[0]['totalStudents']++;
			}
			else
			{
				$defaulters[$accountantManager]['defaulters']++;
				$tDefaulters[0]['defaulters']++;
				$tDefaulters[0]['totalStudents']++;
				
				switch ($delinquentMonths) 
				{	
					case 1:
						$defaulters[$accountantManager]['one']++;
						$tDefaulters[0]['one']++;
						break;
					case 2:
						$defaulters[$accountantManager]['two']++;
						$tDefaulters[0]['two']++;
						break;
					case 3:
						$defaulters[$accountantManager]['three']++;
						$tDefaulters[0]['three']++;
						break;
					case 4:
						$defaulters[$accountantManager]['four']++;
						$tDefaulters[0]['four']++;
						break;
					default:
						$defaulters[$accountantManager]['fiveMore']++;
						$tDefaulters[0]['fiveMore']++;
						break;
				}
			}
			
			if ($wholeYear == 0)
			{
				$defaulters[$accountantManager]['prepaid']++;
				$tDefaulters[0]['prepaid']++;
			}
		}
		return [$defaulters, $accountantManager, $tDefaulters];
	}
	public function reportStudentsGeneral()
	{
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
               
        $currentDate = Time::now();
		
		$currentYear = $currentDate->year;
		$currentMonth = $currentDate->month;
				
		if ($currentMonth < 9)
		{
			$yearFrom = $currentYear - 1;
			$yearUntil = $currentYear;
		}
		else
		{
			$yearFrom = $currentYear;
			$yearUntil = $currentYear + 1;
		}
		
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);

		$this->loadModel('Rates');
					
		$concept = 'Matrícula';
					
		$lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
		   'order' => ['Rates.created' => 'DESC'] ]);

		$row = $lastRecord->first();
					
		if ($row)
		{
			$amountRegistration = $row->amount;
		}
		else
		{
			$this->Flash->error(__('No se encontró el monto de la matrícula'));
			
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);		
		}
	
        $students = TableRegistry::get('Students');
        
		$studentsFor = $students->find('all')
			->select(
				['Students.id',
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
				'Students.student_condition',
				'Students.scholarship',
				'Parentsandguardians.type_of_identification',
				'Parentsandguardians.identidy_card',
				'Parentsandguardians.surname',
				'Parentsandguardians.second_surname',
				'Parentsandguardians.first_name',
				'Parentsandguardians.second_name',
				'Parentsandguardians.email',
				'Parentsandguardians.cell_phone',
				'Parentsandguardians.landline',
				'Parentsandguardians.work_phone',
				'Sections.id',
				'Sections.sublevel'])
			->contain(['Parentsandguardians', 'Sections'])
			->where([['Students.id >' => 1]])
			->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);
				
		$studentObservations = [];
        
		foreach ($studentsFor as $studentsFors)
		{										
			$studentObservations[$studentsFors->id]['observation'] = '';
			
			if ($studentsFors->student_condition == 'Regular')
			{
				$level = $this->sublevelLevel($studentsFors->section->sublevel);
				
				if ($level == $studentsFors->level_of_study)
				{						
					if ($studentsFors->scholarship == 1)
					{
						$studentObservations[$studentsFors->id]['observation'] = 'Becado';
					}
					else
					{				
						$studentTransactions = $this->Students->Studenttransactions->find('all')->where(['student_id' => $studentsFors->id]);

						foreach ($studentTransactions as $studentTransaction) 
						{
							if ($studentTransaction->transaction_description == 'Matrícula ' . $yearFrom)
							{
								if ($studentTransaction->amount < $amountRegistration)
								{
									$studentObservations[$studentsFors->id]['observation'] = 'Regular';
								}
								else
								{
									$studentObservations[$studentsFors->id]['observation'] = 'No está inscrito';
								}
								break;						
							}
						}
					}
				}
				else
				{
					$studentObservations[$studentsFors->id]['observation'] = 'No está asignado a ninguna sección';
				}
			}
			else
			{
				$studentObservations[$studentsFors->id]['observation'] = $studentsFors->student_condition;
			}
		}
		$this->set(compact('school', 'studentsFor', 'studentObservations', 'currentDate'));
	}
	public function familyStudents()
	{	
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
        $currentDate = Time::now();
		
		$binnacles = new BinnaclesController;

		$arrayExtra = [];
		
	    if ($this->request->is('post')) 
        {					
			if (isset($_POST['columnsReport']))
			{
				$columnsReport = $_POST['columnsReport'];
			}
			else
			{
				$columnsReport = [];
			}
			
			$arrayMark = $this->markColumns($columnsReport);
			
			$jsonArrayMark = json_encode($arrayMark, JSON_FORCE_OBJECT);	

			if (isset($_POST['filters_report']))
			{
				$arrayExtra[0] = $_POST['filters_report'];
				$arrayExtra[1] = $_POST['order_report'];
			}
		
			$arrayResult = $binnacles->add('controller', 'Students', 'familyStudents', $jsonArrayMark, $arrayExtra);
			
			if ($arrayResult['indicator'] == 0)
			{
				return $this->redirect(['controller' => 'Students', 'action' => 'reportFamilyStudents', $arrayResult['id']]);
			}
			else
			{
				$this->Flash->error(___('Error al guardar el archivo Binnacles'));
			}
		}
	}
	
	public function reportFamilyStudents($id = null)
	{	
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
        $currentDate = Time::now();
		
		$this->loadModel('Binnacles');
		
		$accountStudents = [];
		
		$accountStudents['Regular'] = 0; 
		$accountStudents['New'] = 0; 
		$accountStudents['Graduated'] = 0; 
		$accountStudents['Retired'] = 0; 
		$accountStudents['Expelled'] = 0;
		$accountStudents['Discontinued'] = 0;
		$accountNewRegistration = 0;
		$accountRegularRegistration = 0;
					
		$binnacle = $this->Binnacles->get($id);
		
		$objetColumnsReport = json_decode($binnacle->novelty);
						
		$arrayMark = (array) $objetColumnsReport;
				
		$filtersReport = $binnacle->extra_column1;
		
		$orderReport = $binnacle->extra_column2;
		
		$arraySignedUp = [];
					
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
		
		$anoEscolarActual = $school->current_school_year;
		$proximoAnoEscolar = $anoEscolarActual + 1;

		if ($filtersReport == "Nuevos")
		{		
			$concepto = 'Matrícula ' . $anoEscolarActual;
		}
		elseif ($filtersReport == "Nuevos próximo año escolar")
		{
			$concepto = 'Matrícula ' . $proximoAnoEscolar;
		}
		elseif ($filtersReport == "Regulares")
		{
			$concepto = 'Matrícula ' . $anoEscolarActual;
		}
		elseif ($filtersReport == "Regulares próximo año escolar")
		{
			$concepto = 'Matrícula ' . $proximoAnoEscolar;
		}		
		elseif ($filtersReport == "Nuevos y regulares")
		{		
			$concepto = 'Matrícula ' . $anoEscolarActual; 
		}
		elseif ($filtersReport == "Todos")
		{
			$concepto = 'Matrícula ' . $anoEscolarActual;
		}
			
		$students = TableRegistry::get('Students');

		$arrayResult = $students->find('family', ['filtersReport' => $filtersReport, 'orderReport' => $orderReport, 'anoEscolarActual' => $anoEscolarActual, 'proximoAnoEscolar' => $proximoAnoEscolar]);
		
		if ($arrayResult['indicator'] == 1)
		{
			$this->Flash->error(___('No se encontraron alumnos'));
			
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
		}
		else
		{
			$familyStudents = $arrayResult['searchRequired'];
		}
		
		$familiaAnterior = "";
		$contadorFamilias = 0;
		
		foreach ($familyStudents as $familyStudent)
		{
			if ($familyStudent->student_condition == "Regular")
			{
				if ($familyStudent->new_student == 0)
				{
					$accountStudents['Regular']++;
				}
				else
				{
					$accountStudents['New']++;
				}
				
				$signedUp = $this->Students->Studenttransactions->find('all')
					->select(['Studenttransactions.student_id', 
						'Studenttransactions.transaction_description', 
						'Studenttransactions.amount', 
						'Studenttransactions.original_amount',
						'Studenttransactions.amount_dollar'])
					->where([['Studenttransactions.student_id' => $familyStudent->id],
						['Studenttransactions.transaction_description' => $concepto],
						['Studenttransactions.amount_dollar >' => 0]])
					->order(['Studenttransactions.created' => 'DESC']);

				$row = $signedUp->first();	

				if ($row)
				{
					$arraySignedUp[$familyStudent->id] = 'Pagado';
					if ($familyStudent->new_student == 1)
					{
						if ($orderReport == "Familia")
						{
							if ($accountNewRegistration == 0)
							{
								$familiaAnterior = $familyStudent->parentsandguardian->family;
								$contadorFamilias++;
							}
							if ($familiaAnterior != $familyStudent->parentsandguardian->family)
							{
								$familiaAnterior = $familyStudent->parentsandguardian->family;
								$contadorFamilias++;
							}
						}							
						$accountNewRegistration++;
					}
					else
					{
						if ($orderReport == "Familia")
						{
							if ($accountRegularRegistration == 0)
							{
								$familiaAnterior = $familyStudent->parentsandguardian->family;
								$contadorFamilias++;
							}
							if ($familiaAnterior != $familyStudent->parentsandguardian->family)
							{
								$familiaAnterior = $familyStudent->parentsandguardian->family;
								$contadorFamilias++;
							}
						}												
						$accountRegularRegistration++;
					}							
				}
				else
				{
					$arraySignedUp[$familyStudent->id] = 'No pagado';
				}
			}
			elseif ($familyStudent->student_condition == "Egresado")
			{
				$accountStudents['Graduated']++;
			}
			elseif ($familyStudent->student_condition == "Retirado")
			{
				$accountStudents['Retired']++;
			}				
			elseif ($familyStudent->student_condition == "Expulsado")
			{
				$accountStudents['Expelled']++;
			}
			elseif ($familyStudent->student_condition == "Suspendido")
			{
				$accountStudents['Discontinued']++;
			}
		}	
				
		$this->set(compact('familyStudents', 'arrayMark', 'currentDate', 'accountStudents', 'arraySignedUp', 'anoEscolarActual', 'proximoAnoEscolar',  'filtersReport', 'accountNewRegistration', 'accountRegularRegistration', 'contadorFamilias', 'orderReport'));
		$this->set('_serialize', ['familyStudents', 'arrayMark', 'currenDate', 'accountStudents', 'arraySignedUp', 'anoEscolarActual', 'proximoAnoEscolar', 'filtersReport', 'accountNewRegistration', 'accountRegularRegistration', 'contadorFamilias', 'orderReport']); 		
	}
	
	public function markColumns($columnsReport = null)
	{
		$arrayMark = [];
		
		isset($columnsReport['Students.estatus']) ? $arrayMark['Students.estatus'] = 'siExl' : $arrayMark['Students.estatus'] = 'noExl';
				
		isset($columnsReport['Students.sex']) ? $arrayMark['Students.sex'] = 'siExl' : $arrayMark['Students.sex'] = 'noExl';
		
		isset($columnsReport['Students.nationality']) ? $arrayMark['Students.nationality'] = 'siExl' : $arrayMark['Students.nationality'] = 'noExl';
		
		isset($columnsReport['Students.identity_card']) ? $arrayMark['Students.identity_card'] = 'siExl' : $arrayMark['Students.identity_card'] = 'noExl';
				
		isset($columnsReport['Students.balance']) ? $arrayMark['Students.balance'] = 'siExl' : $arrayMark['Students.balance'] = 'noExl';
				
		isset($columnsReport['Students.section_id']) ? $arrayMark['Students.section_id'] = 'siExl' : $arrayMark['Students.section_id'] = 'noExl';
		
		isset($columnsReport['Students.grado_renovacion']) ? $arrayMark['Students.grado_renovacion'] = 'siExl' : $arrayMark['Students.grado_renovacion'] = 'noExl';
		
		isset($columnsReport['Parentsandguardians.full_name']) ? $arrayMark['Parentsandguardians.full_name'] = 'siExl' : $arrayMark['Parentsandguardians.full_name'] = 'noExl';
				
		isset($columnsReport['Parentsandguardians.sex']) ? $arrayMark['Parentsandguardians.sex'] = 'siExl' : $arrayMark['Parentsandguardians.sex'] = 'noExl';
		
		isset($columnsReport['Parentsandguardians.identidy_card']) ? $arrayMark['Parentsandguardians.identidy_card'] = 'siExl' : $arrayMark['Parentsandguardians.identidy_card'] = 'noExl';

		isset($columnsReport['Parentsandguardians.work_phone']) ? $arrayMark['Parentsandguardians.work_phone'] = 'siExl' : $arrayMark['Parentsandguardians.work_phone'] = 'noExl';

		isset($columnsReport['Parentsandguardians.cell_phone']) ? $arrayMark['Parentsandguardians.cell_phone'] = 'siExl' : $arrayMark['Parentsandguardians.cell_phone'] = 'noExl';

		isset($columnsReport['Parentsandguardians.email']) ? $arrayMark['Parentsandguardians.email'] = 'siExl' : $arrayMark['Parentsandguardians.email'] = 'noExl';	
		
		isset($columnsReport['Parentsandguardians.nombre_completo_padre']) ? $arrayMark['Parentsandguardians.nombre_completo_padre'] = 'siExl' : $arrayMark['Parentsandguardians.nombre_completo_padre'] = 'noExl';
						
		isset($columnsReport['Parentsandguardians.documento_identidad_padre']) ? $arrayMark['Parentsandguardians.documento_identidad_padre'] = 'siExl' : $arrayMark['Parentsandguardians.documento_identidad_padre'] = 'noExl';

		isset($columnsReport['Parentsandguardians.work_phone_father']) ? $arrayMark['Parentsandguardians.work_phone_father'] = 'siExl' : $arrayMark['Parentsandguardians.work_phone_father'] = 'noExl';

		isset($columnsReport['Parentsandguardians.cell_phone_father']) ? $arrayMark['Parentsandguardians.cell_phone_father'] = 'siExl' : $arrayMark['Parentsandguardians.cell_phone_father'] = 'noExl';

		isset($columnsReport['Parentsandguardians.email_father']) ? $arrayMark['Parentsandguardians.email_father'] = 'siExl' : $arrayMark['Parentsandguardians.email_father'] = 'noExl';	
		
		isset($columnsReport['Parentsandguardians.nombre_completo_madre']) ? $arrayMark['Parentsandguardians.nombre_completo_madre'] = 'siExl' : $arrayMark['Parentsandguardians.nombre_completo_madre'] = 'noExl';
						
		isset($columnsReport['Parentsandguardians.documento_identidad_madre']) ? $arrayMark['Parentsandguardians.documento_identidad_madre'] = 'siExl' : $arrayMark['Parentsandguardians.documento_identidad_madre'] = 'noExl';

		isset($columnsReport['Parentsandguardians.work_phone_mother']) ? $arrayMark['Parentsandguardians.work_phone_mother'] = 'siExl' : $arrayMark['Parentsandguardians.work_phone_mother'] = 'noExl';

		isset($columnsReport['Parentsandguardians.cell_phone_mother']) ? $arrayMark['Parentsandguardians.cell_phone_mother'] = 'siExl' : $arrayMark['Parentsandguardians.cell_phone_mother'] = 'noExl';

		isset($columnsReport['Parentsandguardians.email_mother']) ? $arrayMark['Parentsandguardians.email_mother'] = 'siExl' : $arrayMark['Parentsandguardians.email_mother'] = 'noExl';
		
		return $arrayMark;
	}

    public function editStatus($id = null, $controller = null, $action = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
        $currentDate = Time::now();

		$this->loadModel('Schools');
		
		$school = $this->Schools->get(2);
			
		$actual_anio_matricula = $school->current_year_registration;

		$proximo_anio_matricula = $school->next_year_registration;

		$controlador_transacciones = new StudenttransactionsController();
		
        $student = $this->Students->get($id);

		$nivel_estudios_actual = $student->level_of_study;
        
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);

			if ($student->brothers_in_school == 0)
			{
				$anio_matricula = $school->current_year_registration;
			}
			else
			{
				$anio_matricula = $school->next_year_registration;
			}
           
			$student->number_of_brothers = 0;
			
			if ($student->student_condition == "Nuevo")
			{
				$student->student_condition = "Regular";
				$student->scholarship = 0;
				$student->becado_ano_anterior = 0;
				$student->tipo_descuento_ano_anterior = "";
				$student->descuento_ano_anterior = 0;
				$student->new_student = true;
				$student->section_id = 1;
				$student->balance = 0;	
				$student->tipo_descuento = "";
				$student->discount = 0;	
				$student->respaldo_primer_ano_inscripcion = 0;	
				$student->respaldo_ultimo_ano_inscripcion = 0;	
				$student->respaldo_seccion_id = 0;
				$student->respaldo_nivel_de_estudio = "";
			}
			else
			{
				$student->level_of_study = $nivel_estudios_actual;
			}
		            
            if ($this->Students->save($student)) 
            {	
				$indicadorError = 0;

				if ($student->new_student == true)
				{
					$concepto_matricula = "Matrícula ".$anio_matricula;

					$transacciones_estudiantes = $this->Students->Studenttransactions->find('all')->where(['student_id' => $id,  'transaction_description' => $concepto_matricula]);
									
					if ($transacciones_estudiantes->count() == 0)
					{
						$indicadorError = $controlador_transacciones->createQuotasNew($id, $anio_matricula);
					} 
				}

				if ($indicadorError == 0)
				{
					$this->Flash->success(__('El estatus del alumno se actualizó correctamente'));
				}
				else
				{
					$this->Flash->error(__('No se pudieron generar las cuotas del estudiante'));
				}			
				
                if (isset($controller))
                {
                    return $this->redirect(['controller' => $controller, 'action' => $action, $id]);
                }
                else
                {
                    return $this->redirect(['controller' => 'users', 'action' => 'wait']);
                }
            }
            else 
            {
                $this->Flash->error(__('El estatus del alumno no se pudo actualizar'));
            }
        }    
        $this->set(compact('student', 'actual_anio_matricula', 'proximo_anio_matricula'));
        $this->set('_serialize', ['student', 'actual_anio_matricula', 'proximo_anio_matricula']);
    }
    public function editSection($id = null, $controller = null, $action = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
        $currentDate = Time::now();
		
		$sections = $this->Students->Sections->find('list', ['limit' => 200]);
		
        $student = $this->Students->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
            
            $student->brothers_in_school = 0;
		            
            if ($this->Students->save($student)) 
            {			
				$this->Flash->success(__('El alumno fue asignado correctamente a la sección'));
				
                if (isset($controller))
                {
                    return $this->redirect(['controller' => $controller, 'action' => $action, $id]);
                }
                else
                {
                    return $this->redirect(['controller' => 'users', 'action' => 'wait']);
                }
            }
            else 
            {
                $this->Flash->error(__('No se pudo asignar el alumno a la sección'));
            }
        }    
        $this->set(compact('student', 'sections'));
        $this->set('_serialize', ['student', 'sections']);
    }
	public function repairColumn()
	{
		$accountRecords = 0;
		
		$query = $this->Students->find('all');
		
		foreach ($query as $querys)
		{
			$student = $this->Students->get($querys->id);
			
			$student->balance = 0;			

            if (!($this->Students->save($student))) 
            {
                $this->Flash->error(__('No pudo ser actualizado el registro Nro. ' . $student->id . ' Nombre: ' . $student->full_name));
			}
			else
			{
				$accountRecords++;
			}
		}
		$this->Flash->success(__('Total registros actualizados: ' . $accountRecords));
	}
    public function sameNames()
    {		
        $this->autoRender = false; 

		$binnacles = new BinnaclesController;
        
		$jsondata = [];

        if ($this->request->is('json')) 
        { 
            if (isset($_POST['surname']) && isset($_POST['firstName']))
            {
				$surname = $_POST['surname'];
				$firstName = $_POST['firstName']; 
								
				$sameStudents = $this->Students->find('all')->where([['Students.surname LIKE' => $surname . '%'], ['Students.first_name LIKE' => $firstName . '%']])
					->contain(['Parentsandguardians'])
					->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC']);

				$count = $sameStudents->count();
				
				if ($count > 0)
				{
					$jsondata['success'] = true;
					$jsondata['data']['message'] = 'Se encontraron estudiantes con nombres similares';
					$jsondata['data']['students'] = [];
					
					foreach ($sameStudents as $sameStudent)
					{
						$jsondata['data']['students'][]['student'] = $sameStudent->full_name;
						$jsondata['data']['students'][]['family'] = $sameStudent->parentsandguardian->family;
						$jsondata['data']['students'][]['id'] = $sameStudent->id;
						$binnacles->add('controller', 'Students', 'sameNames', $sameStudent->full_name);
					}
				}
				else
				{
					$jsondata["success"] = false;
					$jsondata["data"]["message"] = 'No se encontraron estudiantes';
				}
				exit(json_encode($jsondata, JSON_FORCE_OBJECT));
            }
            else 
            {
                die("Solicitud no válida.");
            }           
        } 
    }
    public function searchFamily($id = null, $nameStudent = null, $controller = null, $action = null)
    {		
        $this->set(compact('id', 'nameStudent', 'controller', 'action'));
        $this->set('_serialize', ['id', 'nameStudent', 'controller', 'action']);
    }
	
    public function editFamily()
    {		
		$this->autoRender = false;
		
		if ($this->request->is('json')) 
        {
			$student = $this->Students->get($_POST['idStudent']);

			$student->parentsandguardian_id = $_POST['idFamily'];

            if ($this->Students->save($student)) 
            {
                $this->Flash->success(__('La familia fue reasignada exitosamente'));

                return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
            }
            else 
            {
                $this->Flash->error(__('La familia no pudo ser reasignada'));
            }
        }    
    }
	public function verifyColumn()
	{
		$accountRecords = 0;
		
		$students = $this->Students->find('all')->where(['id >' => 1]);
		
		foreach ($students as $student)
		{
			if ($student->balance > 0)
			{
				if ($student->number_of_brothers > $student->balance)
				{
					$this->Flash->error(__('En el estudiante: ' . $student->full_name . ' el campo number_of_brothers es mayor a balance'));
					$accountRecords++;
				}
			}
		}
		$this->Flash->success(__('Total registros con columna number_of_brothers mayor a balance: ' . $accountRecords));
	}
	public function verifyColumn2()
	{
		$account2016 = 0;
		$account2017 = 0;
		$account2018 = 0;
		
		$students = $this->Students->find('all')->where(['id >' => 1]);
		
		foreach ($students as $student)
		{
			if ($student->balance == 0)
			{
				if ($student->number_of_brothers == 2016)
				{
					$account2016++;
				}
				elseif ($student->number_of_brothers == 2017)
				{
					$account2017++;
				}
				else
				{
					$account2018++;
				}
			}
		}
		$this->Flash->success(__('Total registros año 2016: ' . $account2016));
		$this->Flash->success(__('Total registros año 2017: ' . $account2017));
		$this->Flash->success(__('Total registros año 2018: ' . $account2018));
	}

    public function uniqueMultidimArray($array, $key) 
    { 
        $temp_array = array(); 
        $key_array = array(); 
        
        foreach($array as $val) 
        { 
            if (!in_array($val[$key], $key_array)) 
            { 
                $key_array[] = $val[$key]; 
                $temp_array[] = $val; 
            } 
        } 
        return $temp_array; 
    } 
	
	public function mesesTarifas($tasaTemporal = null)
	{		
		$tablaMensualidades = 
			[
				201609,
				201610,
				201611,
				201612,
				
				201701,
				201702,
				201703,
				201704,
				201705,
				201706,
				201707,
				201708,
				201709,
				201710,
				201711,
				201712,
				
				201801,
				201802,
				201803,
				201804,
				201805,
				201806,
				201807,
				201808,
				201809,
				201810,
				201811,
				201812,
				
				201901,
				201902,
				201903,
				201904,
				201905,
				201906,
				201907,
				201908,
				201909,
				201910,
				201911,
				201912,
				
				202001,
				202002,
				202003,
				202004,
				202005,
				202006,
				202007,
				202008,
				202009,
				202010,
				202011,
				202012,
				
				202101,
				202102,
				202103,
				202104,
				202105,
				202106,
				202107,
				202108,
				202109,
				202110,
				202111,
				202112,
				
				202201,
				202202,
				202203,
				202204,
				202205,
				202206,
				202207,
				202208,
				202209,
				202210,
				202211,
				202212,
				
				202301,
				202302,
				202303,
				202304,
				202305,
				202306,
				202307,
				202308,
				202309,
				202310,
				202311,
				202312,
				
				202401,
				202402,
				202403,
				202404,
				202405,
				202406,
				202407,
				202408,
				202409,
				202410,
				202411,
				202412,
				
				202501,
				202502,
				202503,
				202504,
				202505,
				202506,
				202507,
				202508,
				202509,
				202510,
				202511,
				202512,
				
				202601,
				202602,
				202603,
				202604,
				202605,
				202606,
				202607,
				202608,
				202609,
				202610,
				202611,
				202612,

				202701,
				202702,
				202703,
				202704,
				202705,
				202706,
				202707,
				202708,
				202709,
				202710,
				202711,
				202712,

				202801,
				202802,
				202803,
				202804,
				202805,
				202806,
				202807,
				202808,
				202809,
				202810,
				202811,
				202812,

				202901,
				202902,
				202903,
				202904,
				202905,
				202906,
				202907,
				202908,
				202909,
				202910,
				202911,
				202912,

				203001,
				203002,
				203003,
				203004,
				203005,
				203006,
				203007,
				203008,
				203009,
				203010,
				203011,
				203012,

			];
				
		if ($tasaTemporal == 0)
		{
			$this->loadModel('Monedas');	
			$moneda = $this->Monedas->get(2);
			$dollarExchangeRate = $moneda->tasa_cambio_dolar;
		}
		else
		{
			$dollarExchangeRate = $tasaTemporal;
		}
		
		$this->loadModel('Rates');
				
		$mensualidades = $this->Rates->find('all', ['conditions' => ['concept' => 'Mensualidad'], 
			'order' => ['Rates.rate_year' => 'ASC', 'Rates.rate_month' => 'ASC', 'Rates.created' => 'DESC']]);
		
		$contadorRegistros = $mensualidades->count();
		
		if ($contadorRegistros > 0)
		{
			$mesesTarifas = [];
			$tarifaDolarAnterior = 0;
			$tarifaBolivarAnterior = 0;
			$anoMesAnterior = "";
			
			$tarifaDolarActual = 0;
			$tarifaBolivarActual = 0;
			$anoMesActual = "";
			
			foreach ($tablaMensualidades as $tablaMensualidad)
			{
				$indicadorEncontrado = 0;
				
				foreach ($mensualidades as $mensualidad)
				{
					$anoMesAnterior = $anoMesActual;
					$anoMesActual = $mensualidad->rate_year . $mensualidad->rate_month;
					
					$tarifaDolarAnterior = $tarifaDolarActual;
					$tarifaBolivarAnterior = $tarifaBolivarActual;
					
					if ($anoMesActual < 201811)
					{
						$tarifaDolarActual = round($mensualidad->amount/1000000);
						$tarifaBolivarActual = $mensualidad->amount;
					}
					else
					{
						$tarifaDolarActual = $mensualidad->amount;
						$tarifaBolivarActual = round($tarifaDolarActual * $dollarExchangeRate);
					}
					
					if ($anoMesActual == $tablaMensualidad)
					{							
						$mesesTarifas[] = ['anoMes' => $tablaMensualidad, 'tarifaDolar' => $tarifaDolarActual, 'tarifaBolivar' => $tarifaBolivarActual];
						$indicadorEncontrado = 1;
						break;
					}
					elseif ($anoMesActual > $tablaMensualidad)
					{
						break;
					}
				}
				if ($indicadorEncontrado == 0)
				{
					if ($tablaMensualidad < $anoMesActual)
					{
						$mesesTarifas[] = ['anoMes' => $tablaMensualidad, 'tarifaDolar' => $tarifaDolarAnterior, 'tarifaBolivar' => $tarifaBolivarAnterior];
					}
					else
					{
						$mesesTarifas[] = ['anoMes' => $tablaMensualidad, 'tarifaDolar' => $tarifaDolarActual, 'tarifaBolivar' => $tarifaBolivarActual];
					}
				}					
			}
		}	
		return $mesesTarifas;
	}
	
	public function otrasTarifas($tasaTemporal = null)
	{
		if ($tasaTemporal == 0)
		{
			$this->loadModel('Monedas');	
			$moneda = $this->Monedas->get(2);
			$dollarExchangeRate = $moneda->tasa_cambio_dolar;
		}
		else
		{
			$dollarExchangeRate = $tasaTemporal;
		}
		
		$this->loadModel('Rates');
				
		$tarifas = $this->Rates->find('all', ['conditions' => ['concept !=' => 'Mensualidad'], 
			'order' => ['Rates.concept' => 'ASC', 'Rates.rate_year' => 'ASC', 'Rates.created' => 'DESC']]);
		
		$contadorRegistros = $tarifas->count();
		
		if ($contadorRegistros > 0)
		{
			$otrasTarifas = [];
			$otrasConceptoAnoAnterior = "";		
			$otrasConceptoAnoActual = "";
			
			foreach ($tarifas as $tarifa)
			{
				$otrasConceptoAnoAnterior = $otrasConceptoAnoActual;
				
				if ($tarifa->concept == "Agosto")
				{	
					$otrasConceptoAnoActual = "Ago " . $tarifa->rate_year;
				}
				else
				{
					$otrasConceptoAnoActual = $tarifa->concept . " " . $tarifa->rate_year;
				}
									
				$otrasDolarActual = $tarifa->amount;				
				$otrasBolivarActual = round($otrasDolarActual * $dollarExchangeRate);
				
				if ($otrasConceptoAnoActual != $otrasConceptoAnoAnterior)
				{							
					$otrasTarifas[] = ['conceptoAno' => $otrasConceptoAnoActual, 'tarifaDolar' => $otrasDolarActual, 'tarifaBolivar' => $otrasBolivarActual];
				}
			}					
		}
		return $otrasTarifas;
	}
	
	public function familiasDescuento20()
	{
        $this->loadModel('Schools');
        $school = $this->Schools->get(2);
		
		$familiaAnterior = "";
		$contadorEstudiantes = 0;
		$vectorFamilias = [];
		
		$estudiantes20 = $this->Students->find('all')->where(['tipo_descuento' => 'Hijos', 'discount' => 20]);

		foreach ($estudiantes20 as $estudiante)
		{
			if ($contadorEstudiantes == 0)
			{
				$familiaAnterior = $estudiante->parentsandguardian_id;
				$familia = $this->Students->Parentsandguardians->get($estudiante->parentsandguardian_id);
				$vectorFamilias[] = $familia->family;
			}
			if ($familiaAnterior != $estudiante->parentsandguardian_id)
			{
				$familiaAnterior = $estudiante->parentsandguardian_id;
				$familia = $this->Students->Parentsandguardians->get($estudiante->parentsandguardian_id);
				$vectorFamilias[] = $familia->family;
			}
			$contadorEstudiantes++;
		}
		
		asort($vectorFamilias);
		
        $this->set(compact('vectorFamilias', 'school'));
        $this->set('_serialize', ['vectorFamilias', 'school']);
	}
	public function familiasDescuento50()
	{
        $this->loadModel('Schools');
        $school = $this->Schools->get(2);
		
		$familiaAnterior = "";
		$contadorEstudiantes = 0;
		$vectorFamilias = [];
		
		$estudiantes20 = $this->Students->find('all')->where(['tipo_descuento' => 'Hijos', 'discount' => 50]);

		foreach ($estudiantes20 as $estudiante)
		{
			if ($contadorEstudiantes == 0)
			{
				$familiaAnterior = $estudiante->parentsandguardian_id;
				$familia = $this->Students->Parentsandguardians->get($estudiante->parentsandguardian_id);
				$vectorFamilias[] = $familia->family;
			}
			if ($familiaAnterior != $estudiante->parentsandguardian_id)
			{
				$familiaAnterior = $estudiante->parentsandguardian_id;
				$familia = $this->Students->Parentsandguardians->get($estudiante->parentsandguardian_id);
				$vectorFamilias[] = $familia->family;
			}
			$contadorEstudiantes++;
		}
		
		asort($vectorFamilias);
        
		$this->set(compact('vectorFamilias', 'school'));
        $this->set('_serialize', ['vectorFamilias', 'school']);
	}
	
	public function morosidad()
    {
        if ($this->request->is('post')) 
        {
			return $this->redirect(['controller' => 'Students', 'action' => 'reporteMorosidad', $_POST["mes"], $_POST["ano"], $_POST["tipo_reporte"], $_POST["ano_escolar"]]);
        }
	}
	
	public function reporteMorosidad($mes = null, $ano = null, $tipoReporte = null, $anoEscolar = null)
	{
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
               
        $currentDate = Time::now();
				
		$currentYear = $currentDate->year;
		$currentMonth = $currentDate->month;
		
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
		
		$this->loadModel('Rates');
		
		$this->loadModel('Monedas');	
		$moneda = $this->Monedas->get(2);
		$dollarExchangeRate = $moneda->tasa_cambio_dolar; 
				
		$mesesTarifas = $this->mesesTarifas(0);
								
		if ($anoEscolar == "Año escolar anterior")
		{
			$yearFrom = $school->current_school_year - 1;
			$yearUntil = $school->current_school_year;
		}	
		else
		{
			$yearFrom = $school->current_school_year;
			$yearUntil = $yearFrom + 1;
		}
				
		$yearMonthFrom = $yearFrom . '09';
			
		$yearMonthUntil = $ano . $mes;
					
		$yearMonthEnd = $yearUntil . '07';
				
		$totalDebt = 0;
			
        $students = TableRegistry::get('Students');
        
        $arrayResult = $students->find('regular');
        
        if ($arrayResult['indicator'] == 1)
		{
			$this->Flash->error(___('No se encontraron alumnos regulares'));
			
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
		}
		
		$studentsFor = $arrayResult['searchRequired'];

		$defaulters = [];
        
		$accountantManager = 0;	
		
		$defaulters[$accountantManager]['section'] = '';
		$defaulters[$accountantManager]['one'] = 0;
		$defaulters[$accountantManager]['two'] = 0;
		$defaulters[$accountantManager]['three'] = 0;
		$defaulters[$accountantManager]['four'] = 0;
		$defaulters[$accountantManager]['fiveMore'] = 0;
		$defaulters[$accountantManager]['solvents'] = 0;
		$defaulters[$accountantManager]['defaulters'] = 0;
		$defaulters[$accountantManager]['prepaid'] = 0;
		$defaulters[$accountantManager]['scholarship'] = 0;	

		$tDefaulters = [];
			
		$tDefaulters[0]['section'] = '';
		$tDefaulters[0]['one'] = 0;
		$tDefaulters[0]['two'] = 0;
		$tDefaulters[0]['three'] = 0;
		$tDefaulters[0]['four'] = 0;
		$tDefaulters[0]['fiveMore'] = 0;
		$tDefaulters[0]['solvents'] = 0;
		$tDefaulters[0]['defaulters'] = 0;
		$tDefaulters[0]['prepaid'] = 0;
		$tDefaulters[0]['scholarship'] = 0;
		$tDefaulters[0]['totalStudents'] = 0;
		
		$swSection = 0;
		
		$detalleMorosos = [];
		$totalMoroso = 0;
				
		foreach ($studentsFor as $studentsFors)
		{	
			$swSignedUp = 0;
			$scholarship = 0;
			$delinquentMonths = 0;		
			$wholeYear = 0;							

			$studentTransactions = $this->Students->Studenttransactions->find('all')->where(['student_id' => $studentsFors->id, 'invoiced' => 0]);

			foreach ($studentTransactions as $studentTransaction) 
			{
				if ($studentTransaction->transaction_description == 'Matrícula ' . $yearFrom)
				{
					if ($studentTransaction->amount_dollar > 0)
					{
						$swSignedUp = 1;
					}
					break;						
				}
			}
						
			if ($swSignedUp == 1 && $studentsFors->section_id > 1)
			{
				$nameSection = $this->Students->Sections->get($studentsFors->section_id);
				
				if ($anoEscolar == "Año escolar actual")
				{
					if ($studentsFors->scholarship == 1)
					{
						$scholarship = 1;
					}
				}
				else
				{
					if ($studentsFors->becado_ano_anterior == 1)
					{
						$scholarship = 1;
					}
				}

				if ($scholarship == 0)
				{				
					foreach ($studentTransactions as $studentTransaction)
					{
						if ($studentTransaction->transaction_type == "Mensualidad")
						{
							$month = substr($studentTransaction->transaction_description, 0, 3);
								
							$year = substr($studentTransaction->transaction_description, 4, 4);
								
							$numberOfTheMonth = $this->nameMonth($month);
								
							$yearMonth = $year . $numberOfTheMonth;
								
							if ($month != "Ago")
							{
								if ($studentTransaction->paid_out == 0)
								{
									$wholeYear = 1;
									
									if ($yearMonth <= $yearMonthUntil)
									{
										foreach ($mesesTarifas as $mesesTarifa)
										{
											if ($mesesTarifa["anoMes"] == $yearMonth)
											{
												if ($studentsFors->discount != null)
												{
													$amountMonthly = round(($mesesTarifa["tarifaDolar"] * (100 - $studentsFors->discount)) / 100);
												}
												else
												{
													$amountMonthly = $mesesTarifa["tarifaDolar"];
												}
												break;
											}
										}
										$delinquentMonths++;
										$saldoCuota = $amountMonthly - $studentTransaction->amount_dolar;
										$totalDebt = $totalDebt + $saldoCuota;
										if (isset($detalleMorosos[$studentsFors->full_name]))
										{
											$detalleMorosos[$studentsFors->full_name]['cuotasPendientes']++;
											$detalleMorosos[$studentsFors->full_name]['pendiente'] += $saldoCuota; 
											$totalMoroso += $saldoCuota;
										}
										else
										{
											$detalleMorosos[$studentsFors->full_name] = 
												['grado' => $nameSection->full_name,
												'descuento' => $studentsFors->discount,
												'cuotasPendientes' => 1,
												'pendiente' => $saldoCuota];
											$totalMoroso += $saldoCuota;
										}
									}
								}
								else
								{
									foreach ($mesesTarifas as $mesesTarifa)
									{
										if ($mesesTarifa["anoMes"] == $yearMonth)
										{
											if ($studentsFors->discount != null)
											{
												$tarifaDolarAnoMes = round(($mesesTarifa["tarifaDolar"] * (100 - $studentsFors->discount)) / 100, 2);
											}
											else
											{
												$tarifaDolarAnoMes = $mesesTarifa["tarifaDolar"];
											}
											break;
										}
									}
									$descuentoAplicado = $studentTransaction->original_amount - $studentTransaction->amount;
									$cuotaAplicadaAlumno = $tarifaDolarAnoMes - $descuentoAplicado; 
									if ($studentTransaction->amount_dollar < $cuotaAplicadaAlumno)
									{
										$wholeYear = 1;

										if ($yearMonth <= $yearMonthUntil)
										{											
											$diferenciaDolares = $tarifaDolarAnoMes - $studentTransaction->amount_dollar;
											$diferenciaBolivares = round($diferenciaDolares * $dollarExchangeRate);
										
											$delinquentMonths++;
											$totalDebt = $totalDebt + $diferenciaDolares;
												
											if (isset($detalleMorosos[$studentsFors->full_name]))
											{
												$detalleMorosos[$studentsFors->full_name]['cuotasPendientes']++;
												$detalleMorosos[$studentsFors->full_name]['pendiente'] += $diferenciaDolares; 
												$totalMoroso += $diferenciaDolares;
											}
											else
											{
												$detalleMorosos[$studentsFors->full_name] = 
													['grado' => $nameSection->full_name,
													'descuento' => $studentsFors->discount,
													'cuotasPendientes' => 1,
													'pendiente' => $diferenciaDolares];
												$totalMoroso += $diferenciaDolares;
											}
										}
									}
								}
							}	
						}
					}	
				}

				if ($swSection == 0)
				{
					$swSection = 1;
					
					$previousSection = $studentsFors->section_id;
					
					$defaulters[$accountantManager]['section'] = $nameSection->full_name;
					
					$arrayGeneral = $this->addCounter($defaulters, $accountantManager, $tDefaulters, $delinquentMonths, $wholeYear, $scholarship);
					
					$defaulters = $arrayGeneral[0];
					
					$accountantManager = $arrayGeneral[1];

					$tDefaulters = $arrayGeneral[2];
				}
				else
				{
					if ($previousSection == $studentsFors->section_id)
					{				
						$arrayGeneral = $this->addCounter($defaulters, $accountantManager, $tDefaulters, $delinquentMonths, $wholeYear, $scholarship);
					
						$defaulters = $arrayGeneral[0];
					
						$accountantManager = $arrayGeneral[1]; 		

						$tDefaulters = $arrayGeneral[2];
					}
					else
					{
						$previousSection = $studentsFors->section_id;
					
						$accountantManager++;		
						
						$defaulters[$accountantManager]['section'] = $nameSection->full_name;	
						$defaulters[$accountantManager]['one'] = 0;
						$defaulters[$accountantManager]['two'] = 0;
						$defaulters[$accountantManager]['three'] = 0;
						$defaulters[$accountantManager]['four'] = 0;
						$defaulters[$accountantManager]['fiveMore'] = 0;
						$defaulters[$accountantManager]['solvents'] = 0;
						$defaulters[$accountantManager]['defaulters'] = 0;
						$defaulters[$accountantManager]['prepaid'] = 0;	
						$defaulters[$accountantManager]['scholarship'] = 0;

						$arrayGeneral = $this->addCounter($defaulters, $accountantManager, $tDefaulters, $delinquentMonths, $wholeYear, $scholarship);
					
						$defaulters = $arrayGeneral[0];
					
						$accountantManager = $arrayGeneral[1]; 

						$tDefaulters = $arrayGeneral[2];
					}
				}
			}
		}
			
		$this->set(compact('school', 'defaulters', 'tDefaulters', 'totalDebt', 'currentDate', 'ano', 'mes', 'tipoReporte', 'detalleMorosos', 'totalMoroso'));
	}
    public function relatedStudentsPrueba()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
        
        $studenttransactions = new StudenttransactionsController();
				
        if ($this->request->is('post')) 
        {
            if(isset($_POST['id']))
            {
                $parentId = $_POST['id'];
                $new = $_POST['new'];
				
				if (isset($_POST['tasaTemporal']))
				{
					if (substr($_POST['tasaTemporal'], -3, 1) == ',')
					{
						$replace1= str_replace('.', '', $_POST['tasaTemporal']);
						$replace2 = str_replace(',', '.', $replace1);
						$tasaTemporal = $replace2;
					}
					else
					{
						$tasaTemporal = $_POST['tasaTemporal'];
					}
				}
				else
				{
					$tasaTemporal = 0;
				}
            }
            else 
            {
                die("Solicitud no válida.");
            }
			
			if ($tasaTemporal == 0)
			{
				$this->loadModel('Monedas');	
				$moneda = $this->Monedas->get(2);
				$dollarExchangeRate = $moneda->tasa_cambio_dolar;
			}
			else
			{
				$dollarExchangeRate = $tasaTemporal;
			}

			$mesesTarifas = $this->mesesTarifas($tasaTemporal);	

			$otrasTarifas = $this->otrasTarifas($tasaTemporal);
			    
            $currentDate = Time::now();
            
            if ($currentDate->day < 10)
            {
                $dd = "0" . $currentDate->day;
            }
            else
            {
                $dd = $currentDate->day;
            }

            if ($currentDate->month < 10)
            {
                $mm = "0" . $currentDate->month;
            }
            else
            {
                $mm = $currentDate->month;
            }
            
            $yyyy = $currentDate->year;
            
            $today = $dd . "/" . $mm . "/" . $yyyy;
            
            $reversedDate = $yyyy . "/" . $mm . "/" . $dd;

            $jsondata = [];

            $parentsandguardians = $this->Students->Parentsandguardians->get($parentId);

            $jsondata["success"] = true;
            $jsondata["data"]["message"] = "Se encontraron familias";
            $jsondata["data"]['parentsandguardian_id'] = $parentsandguardians->id;
            $jsondata["data"]['family'] = $parentsandguardians->family;
            $jsondata["data"]['first_name'] = $parentsandguardians->first_name;
            $jsondata["data"]['surname'] = $parentsandguardians->surname;
            $jsondata["data"]['today'] = $today;
            $jsondata["data"]['reversedDate'] = $reversedDate;
            $jsondata["data"]['client'] = $parentsandguardians->client;
            $jsondata["data"]['type_of_identification_client'] = $parentsandguardians->type_of_identification_client;
            $jsondata["data"]['identification_number_client'] = $parentsandguardians->identification_number_client;
            $jsondata["data"]['fiscal_address'] = $parentsandguardians->fiscal_address;
            $jsondata["data"]['tax_phone'] = $parentsandguardians->tax_phone;
            $jsondata["data"]['email'] = $parentsandguardians->email;
			$jsondata["data"]['balance'] = $parentsandguardians->balance;
			$jsondata["data"]['dollar_exchange_rate'] = $dollarExchangeRate;
			$jsondata["data"]['meses_tarifas'] = $mesesTarifas;
			$jsondata["data"]['otras_tarifas'] = $otrasTarifas;
			
            $jsondata["data"]["students"] = [];
            
            if ($new == 0)
            {
                $students = $this->Students->find('all')->where([['parentsandguardian_id' => $parentId], ['new_student' => 0], ['Students.student_condition' => 'Regular']])
                ->order(['Students.first_name' => 'ASC', 'Students.surname' => 'ASC']);
            }
            elseif ($new == 1)
            {
                $students = $this->Students->find('all')->where([['parentsandguardian_id' => $parentId], ['new_student' => 1], ['Students.student_condition' => 'Regular']])
                ->order(['Students.first_name' => 'ASC', 'Students.surname' => 'ASC']);
            }
            else
            {
                $students = $this->Students->find('all')->where([['parentsandguardian_id' => $parentId], ['Students.student_condition' => 'Regular']])
                ->order(['Students.first_name' => 'ASC', 'Students.surname' => 'ASC']);
            }

            $results = $students->toArray();

            if ($results)
            {
                foreach ($results as $result)
                {
					$sections = $this->Students->Sections->get($result->section_id);
                    $transacciones = $studenttransactions->responsejson($result->id);
					
                    $jsondata["data"]["students"][] = 
						[
							'id' => $result->id,
							'surname' => $result->surname,
							'second_surname' => $result->second_surname,
							'first_name' => $result->first_name,
							'second_name' => $result->second_name,
							'level_of_study' => $result->level_of_study,
							'scholarship' => $result->scholarship,
							'schoolYearFrom' => $result->balance,
							'discount_family' => $result->discount,
							'sublevel' => $sections->sublevel,
							'section' => $sections->section,
							'studentTransactions' => json_decode($transacciones) 
						];
                }
            }
            
            exit(json_encode($jsondata, JSON_FORCE_OBJECT));
        }
    }
    public function busquedaAlumno()
    {
        
    }
	public function becadosAnoAnterior()
	{
		$this->loadModel('Discounts');
		$contadorTotal = 0;
		$contadorBecados = 0;
		$contadorHijos20 = 0;
		$contadorHijos50 = 0;
		
		$becados = $this->Students->find('all')->where(['OR' => [['scholarship' => true], ['discount' => 20], ['discount' => 50]]]);
        
		foreach ($becados as $becado)
		{
			$descuento = $this->Discounts->newEntity();
			$contadorTotal++;
			if ($becado->scholarship == true)
			{
				$descuento->description_discount = $becado->id;
				$descuento->discount_mode = "Becado";
				$descuento->discount_amount = 100;
				$contadorBecados++;
			}
			elseif ($becado->discount == 20)
			{
				$descuento->description_discount = $becado->id;
				$descuento->discount_mode = "Hijos";
				$descuento->discount_amount = $becado->discount;	
				$contadorHijos20++;
			}
			elseif ($becado->discount == 50)
			{
				$descuento->description_discount = $becado->id;
				$descuento->discount_mode = "Hijos";
				$descuento->discount_amount = $becado->discount;	
				$contadorHijos50++;
			}
			
			if (!($this->Discounts->save($descuento))) 
			{
                $this->Flash->error(__('No se pudo grabar el alumno en la tabla'));
			}
		}
		$this->Flash->success(__('Total alumnos becados año anterior ' . $contadorBecados));
		$this->Flash->success(__('Total alumnos beca hijos 20% ' . $contadorHijos20));
		$this->Flash->success(__('Total alumnos beca hijos 50% ' . $contadorHijos50));
		$this->Flash->success(__('Total alumnos becados ' . $contadorTotal));
	}
	public function actualizarBecadosAnoAnterior()
	{
		$this->loadModel('Discounts');
		$contadorActualizados = 0;
		$contadorBecados = 0;
		$contadorHijos20 = 0;
		$contadorHijos50 = 0;
		
		$becados = $this->Discounts->find('all');
        
		foreach ($becados as $becado)
		{
			$estudiante = $this->Students->get($becado->description_discount);
						
			if ($becado->discount_mode == "Becado")
			{
				$estudiante->becado_ano_anterior = true;
				$estudiante->tipo_descuento_ano_anterior = "Becado";
				$estudiante->descuento_ano_anterior = 100;
				$contadorBecados++;
			}
			elseif ($becado->discount_mode == "Hijos" && $becado->discount_amount == 20)
			{
				$estudiante->tipo_descuento_ano_anterior = "Hijos";
				$estudiante->descuento_ano_anterior = $becado->discount_amount;
				$contadorHijos20++;
			}			
			elseif ($becado->discount_mode == "Hijos" && $becado->discount_amount == 50)
			{
				$estudiante->tipo_descuento_ano_anterior = "Hijos";
				$estudiante->descuento_ano_anterior = $becado->discount_amount;
				$contadorHijos50++;
			}

			$contadorActualizados++;
			
			if (!($this->Students->save($estudiante))) 
			{
                $this->Flash->error(__('No se pudo actualizar el alumno en la tabla'));
			}
		}
		$this->Flash->success(__('Total alumnos becados ' . $contadorBecados));
		$this->Flash->success(__('Total alumnos beca hijos 20% ' . $contadorHijos20));
		$this->Flash->success(__('Total alumnos beca hijos 50% ' . $contadorHijos50));
		$this->Flash->success(__('Total alumnos actualizados ' . $contadorActualizados));
	}
	public function becasEspeciales()
	{
		
	}
    public function aplicarBecaEspecial($id = null, $controller = null, $action = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
        $student = $this->Students->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
			
			$student->scholarship = 0;

			if ($student->discount == 100)
			{
				$student->scholarship = 1;
				$student->tipo_descuento = "Becado";
			}
			else if ($student->discount > 0 && $student->discount < 100)
			{
				$student->tipo_descuento = "Especial";
			}
			else
			{
				$student->tipo_descuento = "";
			}
            		            
            if ($this->Students->save($student)) 
            {
				$this->Flash->success(__('La beca se aplicó exitosamente'));
				return $this->redirect(['controller' => 'Users', 'action' => 'wait']);;
            }
            else 
            {
                $this->Flash->error(__('La beca no se pudo aplicar correctamente'));
            }
        }    
        $this->set(compact('student', 'controller', 'action'));
        $this->set('_serialize', ['student', 'controller', 'action']);
	}
	public function reporteBecados()
	{
		$this->loadModel('Schools');
        $school = $this->Schools->get(2);
		$becados = $this->Students->find('all')
			->where(['balance >=' => $school->current_school_year, 'student_condition' => 'Regular', 'discount >' => 0])
			->order(['surname' => 'ASC', 'second_surname' => 'ASC', 'first_name' => 'ASC', 'second_name' => 'ASC']);
			
		$this->set(compact('becados'));
        $this->set('_serialize', ['becados']);
	}

	public function buscarBecadosAnoAnterior()
	{
		$codigoRetorno = 0;

		$transaccionesActualizadas = 0;

		$studentTransactions = new StudenttransactionsController();

		$becadosAnoAnterior = $this->Students->find('all')
			->where(['descuento_ano_anterior !=' => 0]);

		$contadorBusqueda = $becadosAnoAnterior->count();

		$this->Flash->success(__('Total becados año anterior: ' . $contadorBusqueda));	
		
		foreach ($becadosAnoAnterior as $becado)
		{
			$codigoRetorno = $studentTransactions->actualizarTransaccionBecado($becado->id, 2019);

			if ($codigoRetorno == 99)
			{
				break;
			}
			else
			{
				$transaccionesActualizadas += $codigoRetorno;
			} 
		}	
		
		$this->Flash->success(__('Total transacciones actualizadas ' . $transaccionesActualizadas));
	}

	public function buscarBecadosAnoActual()
	{
		$codigoRetorno = 0;

		$transaccionesActualizadas = 0;

		$studentTransactions = new StudenttransactionsController();

		$becadosAnoAnterior = $this->Students->find('all')
			->where(['discount !=' => 0]);

		$contadorBusqueda = $becadosAnoAnterior->count();

		$this->Flash->success(__('Total becados año anterior: ' . $contadorBusqueda));	
		
		foreach ($becadosAnoAnterior as $becado)
		{
			$codigoRetorno = $studentTransactions->actualizarTransaccionBecado($becado->id, 2020);

			if ($codigoRetorno == 99)
			{
				break;
			}
			else
			{
				$transaccionesActualizadas += $codigoRetorno;
			} 
		}	
		
		$this->Flash->success(__('Total transacciones actualizadas ' . $transaccionesActualizadas));
	}

	public function verificarDiferencia($studentTransaction = null)
	{
		$indicadorPagado = '*';

		$mesesTarifas = $this->mesesTarifas(0);

		$ano = $studentTransaction->payment_date->year;
								
		$mes = $studentTransaction->payment_date->month;
																						
		if ($mes < 10)
		{
			$mesCadena = '0' . $mes;
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

				if ($studentTransaction->porcentaje_descuento == 0)
				{
					$tarifaDolarConDescuento = $tarifaDolar;					
				}
				else
				{
					$montoDescuento = round(($tarifaDolar * $studentTransaction->porcentaje_descuento) / 100, 2);	
					$tarifaDolarConDescuento = round($tarifaDolar - $montoDescuento, 2);	
				}

				if ($studentTransaction->amount_dollar < $tarifaDolarConDescuento)
				{
					$indicadorPagado = 'A';
				}
				break;
			}
		}
		
		return $indicadorPagado;
	}
	// Todos los estudiantes egresados desde que se implementó el sistema
	public function estudiantesEgresados()
    {
		$contador_estudiantes_actualizados = 0;

		$egresados = $this->Students->find('all')
			->contain(['Parentsandguardians', 'Sections'])
			->where(['Students.id >' => 1, 'Students.student_condition' => 'Egresado', 'Students.balance >=' => 2016, 'Sections.orden >' => 41])
			->order(['Students.balance' => 'ASC', 'Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC']);

		$this->set(compact('egresados'));
	}
	
	/**
	 * Actualiza el campo 'servicio_educativo_exonerado' de un estudiante.
	 * Recibe el id_estudiante y valor_exoneracion vía petición PUT (JSON).
	 *
	 * @return \Cake\Http\Response|null Responde con JSON indicando éxito o error.
	 */
	public function actualizarExoneracionServicioEducativo()
	{
		// Esta acción solo debe responder a peticiones PUT
		if (!$this->request->is('put'))
		{
			return $this->response->withType('application/json')
				->withStatus(405) // Método no permitido
				->withStringBody(json_encode(['exito' => false, 'mensaje' => 'Método no permitido. Solo se aceptan peticiones PUT.']));
		}

		// Obtener los datos enviados en el cuerpo de la petición PUT (JSON)
		// RequestHandler component ya parsea el JSON a $this->request->getData()
		$datos_recibidos = $this->request->getData();

		$id_estudiante_recibido = null;
		$valor_exoneracion_recibido = null;

		// Validar que los datos esperados están presentes
		if (isset($datos_recibidos['id_estudiante']) && isset($datos_recibidos['valor_exoneracion']))
		{
			$id_estudiante_recibido = (int)$datos_recibidos['id_estudiante']; // Castear a entero
			$valor_exoneracion_recibido = (int)$datos_recibidos['valor_exoneracion']; // Castear a entero
		}
		else
		{
			// Faltan datos en la petición
			return $this->response->withType('application/json')
				->withStatus(400) // Bad Request
				->withStringBody(json_encode(['exito' => false, 'mensaje' => 'Datos incompletos. Se requieren id_estudiante y valor_exoneracion.']));
		}

		// Validar que el valor de exoneración sea 0 o 100
		if (!in_array($valor_exoneracion_recibido, [0, 100]))
		{
			return $this->response->withType('application/json')
				->withStatus(400) // Bad Request
				->withStringBody(json_encode(['exito' => false, 'mensaje' => 'Valor de exoneración inválido. Debe ser 0 o 100.']));
		}

		// Cargar la tabla de Estudiantes
		$tabla_estudiantes = TableRegistry::getTableLocator()->get('Students');

		// Buscar el registro del estudiante por ID
		$estudiante_entidad = $tabla_estudiantes->find()
			->where(['id' => $id_estudiante_recibido])
			->first();

		if (!$estudiante_entidad)
		{
			// Estudiante no encontrado
			return $this->response->withType('application/json')
				->withStatus(404) // Not Found
				->withStringBody(json_encode(['exito' => false, 'mensaje' => 'Estudiante no encontrado.']));
		}

		// Actualizar el campo 'servicio_educativo_exonerado'
		$estudiante_entidad->servicio_educativo_exonerado = $valor_exoneracion_recibido;

		// Intentar guardar el registro
		if ($tabla_estudiantes->save($estudiante_entidad))
		{
			// Guardado exitoso
			return $this->response->withType('application/json')
				->withStatus(200) // OK
				->withStringBody(json_encode(['exito' => true, 'mensaje' => 'Estado de exoneración actualizado exitosamente.']));
		}
		else
		{
			// Error al guardar
			$errores = $estudiante_entidad->getErrors(); // Obtener errores de validación si los hay
			$mensaje_error = 'Error al actualizar el estado de exoneración.';
			if (!empty($errores))
			{
				$mensaje_error .= ' Detalles: ' . json_encode($errores);
			}
			return $this->response->withType('application/json')
				->withStatus(500) // Internal Server Error
				->withStringBody(json_encode(['exito' => false, 'mensaje' => $mensaje_error]));
		}
	}
	public function cambiarEstatusRegistros()
    {
        $this->loadModel('Users');
        // Cargar el modelo Excels
        $this->loadModel('Excels');
        $binnacles = new BinnaclesController;
        $representantesActualizados = [];
        $estudiantesActualizados = [];

        // Buscar todos los registros de la tabla excels
        $excels = $this->Excels->find('all');

        // Recorrer todos los registros de la tabla excels
        foreach ($excels as $excel)
        {
			// si cédula del titular escolar está vacía, saltar al siguiente registro
			if (empty($excel->cedula_titular_escolar)) {
				continue;
			}			
            $estudiante = $this->Students->get($excel->cedula_titular_escolar, 
                ['contain' => []]);
            // $estudiante->student_condition = "Regular"; Descomentar cuando se deba hacer un cambio 
            if (!($this->Students->save($estudiante))) 
			{
				$binnacles->add('controller', 'Students', 'cambiarEstatusRegistro', 'No se pudo modificar el registro del estudiante con el ID: '.$estudiante->id);                    
			}
			else
			{
				$estudiantesActualizados[] = ['id_estudiante' => $estudiante->id, 'nombre_estudiante' => $estudiante->full_name, 'mensaje_actualizacion' => 'Registro del estudiante modificado exitosamente'];
			}
		}	
        // Pasar la variable representantesActualizados a la vista
        $this->set(compact('estudiantesActualizados'));
    }
}