<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\EmployeesController;

use App\Controller\EmployeepaymentsController;

use Cake\I18n\Time;

/**
 * Paysheets Controller
 *
 * @property \App\Model\Table\PaysheetsTable $Paysheets
 */
class PaysheetsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $paysheets = $this->paginate($this->Paysheets);

        $this->set(compact('paysheets'));
        $this->set('_serialize', ['paysheets']);
    }

    /**
     * View method
     *
     * @param string|null $id Paysheet id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $paysheet = $this->Paysheets->get($id, [
            'contain' => []
        ]);

        $this->set('paysheet', $paysheet);
        $this->set('_serialize', ['paysheet']);
    }
    
    public function viewFortnight()
    {
        $employeepayments = new EmployeepaymentsController();

        if ($this->request->is('post')) 
        {
            $lastRecord = $this->Paysheets->find('all', ['conditions' => 
                ['year_paysheet' => $_POST['year_paysheet'],
                'month_paysheet' => $_POST['month_paysheet'],
                'fortnight' => $_POST['fortnight']],
                'order' => ['Paysheets.created' => 'DESC'] ]);
                
            if ($lastRecord)
            {
                $row = $lastRecord->first();   
                
                $month = $this->nameMonthSpanish($_POST['month_paysheet']);
                
                return $this->redirect(['controller' => 'Employeepayments', 'action' => 'index', $row->id, $_POST['year_paysheet'], $month, $_POST['fortnight'], $_POST['classification']]);
            }
            else
            {
                $this->Flash->error(__('No se han encontrado registros'));
            }
        }
    }

    public function printFortnight()
    {
        $employeepayments = new EmployeepaymentsController();

        if ($this->request->is('post')) 
        {
            $lastRecord = $this->Paysheets->find('all', ['conditions' => 
                ['year_paysheet' => $_POST['year_paysheet'],
                'month_paysheet' => $_POST['month_paysheet'],
                'fortnight' => $_POST['fortnight']],
                'order' => ['Paysheets.created' => 'DESC'] ]);
                
            if ($lastRecord)
            {
                $row = $lastRecord->first();   
                
                $month = $this->nameMonthSpanish($_POST['month_paysheet']);
                
                return $this->redirect(['controller' => 'Employeepayments', 'action' => 'reportPrint', $row->id, $_POST['year_paysheet'], $month, $_POST['fortnight'], $_POST['classification']]);
            }
            else
            {
                $this->Flash->error(__('No se han encontrado registros'));
            }
        }
    }

    
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $paysheet = $this->Paysheets->newEntity();
        if ($this->request->is('post')) {
            $paysheet = $this->Paysheets->patchEntity($paysheet, $this->request->data);
            if ($this->Paysheets->save($paysheet)) {
                $this->Flash->success(__('The paysheet has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The paysheet could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('paysheet'));
        $this->set('_serialize', ['paysheet']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Paysheet id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $classificationC = null, $employeePayments = null)
    {
        $this->autoRender = false;
        
        $employeepayments = new EmployeepaymentsController();

        if ($this->request->is('post')) 
        {
            if ($_POST['fortnight'] == 1)
            {
                $fortnight = '1ra. Quincena';
            }
            else
            {
                $fortnight = '2da. Quincena';
            }
            
            $lastRecord = $this->Paysheets->find('all', ['conditions' => 
                [['year_paysheet' => $_POST['yearPaysheet']],
                ['month_paysheet' => $_POST['monthPaysheet']],
                ['fortnight' => $fortnight],
                ['OR' => [['deleted_record IS NULL'], ['deleted_record' => 0]]]],
                'order' => ['Paysheets.created' => 'DESC'] ]);
                
                $classification = $this->classificationName($_POST['classification']);
        }
        else
        {
            if (isset($id))
            {
                $lastRecord = $this->Paysheets->find('all', ['conditions' => 
                    [['id' => $id], ['OR' => [['deleted_record IS NULL'], ['deleted_record' => 0]]]]]);
            }
            else
            {
                $lastRecord = $this->Paysheets->find('all', 
                ['conditions' => 
                    ['id >' => 1, 'OR' => [['deleted_record IS NULL'], ['deleted_record' => 0]]], 'order' => ['Paysheets.created' => 'DESC']]);
            }
            
            if (isset($classificationC))
            {
                $classification = $classificationC; 
            }
            else
            {
                $classification = 'Bachillerato y deporte';
            }
        }
        $row = $lastRecord->first();   
                
        if ($row)
        {
            $month = $this->nameMonthSpanish($row->month_paysheet);               
            return $this->redirect(['controller' => 'Employeepayments', 'action' => 'completeData', $row->id, $row->weeks_social_security, $row->year_paysheet, $row->month_paysheet, $month, $row->fortnight, $classification]);
        }
        else
        {
			if (isset($id))
			{
				$this->Flash->error(__('No se encontró la nómina'));
				return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
			}
			else
			{
				$this->Flash->error(__('No se encontraron nóminas'));
				return $this->redirect(['controller' => 'Paysheets', 'action' => 'createPayrollFortnight']);
			}
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Paysheet id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		
		if (isset($_POST['idPaysheet']))
		{
			$id = $_POST['idPaysheet'];
		}
		
        $paysheet = $this->Paysheets->get($id);
        
        $paysheet->deleted_record = 1;
        
        $paysheet->responsible_user	= $this->Auth->user('username');
        
        if ($this->Paysheets->save($paysheet)) 
        {
            $this->Flash->success(__('La nómina fue eliminada exitosamente'));
        }
        else 
        {
            $this->Flash->error(__('No se pudo eliminar la nómina'));
        }

        return $this->redirect(['controller' => 'Paysheets', 'action' => 'edit']);
    }
    public function createPayrollFortnight()
    {
		$this->loadModel('Positioncategories');

		$payrollParameters = [];
		$payrollParameters['salaryDays'] = 0;
		$payrollParameters['cestaTicketMonth'] = 0;
		$payrollParameters['daysCestaTicket'] = 0;
		$payrollParameters['daysUtilities'] = 0;
		$payrollParameters['collectiveHolidays'] = 0;
		$payrollParameters['collectiveVacationBonusDays'] = 0;
		$arrayCategories = [];
		
        $employees = new EmployeesController();
        
        $employeepayments = new EmployeepaymentsController();
		
		$positionCategories = $this->Positioncategories->find('all', 
			['conditions' => ['id >' => 1],
            'order' => ['Positioncategories.description_category' => 'ASC']]);
			
		foreach ($positionCategories as $positionCategorie)
		{
			$arrayCategories[$positionCategorie->description_category] = 0;
		}
        		
        $paysheet = $this->Paysheets->newEntity();
		
        if ($this->request->is('post')) 
        {
			$paysheet = $this->Paysheets->patchEntity($paysheet, $this->request->data);
			
			$arrayResult = $this->moveColumns($paysheet, $payrollParameters);
			
			$paysheet = $arrayResult['paysheet'];
			
			$paysheet->responsible_user = $this->Auth->user('username'); 
			
			$tableConfigurationJson = $this->initialConfiguration();
		
			$paysheet->table_configuration = $tableConfigurationJson;
											
			$tableCategoriesJson = json_encode($_POST['arrayCategories'], JSON_FORCE_OBJECT);
					
			$paysheet->table_categories = $tableCategoriesJson;
			
			if (!($this->Paysheets->save($paysheet)))
			{
				$this->Flash->error(__('Los datos de la quincena no pudieron ser grabados, intente nuevamente'));                
			}
			else 
			{
				$this->Flash->success(__('Por favor complete los datos de La nómina'));
			}
		}
		else
		{
           $lastRecord = $this->Paysheets->find('all', 
                ['conditions' => 
                ['OR' => [['deleted_record IS NULL'], ['deleted_record' => 0]]], 'order' => ['Paysheets.created' => 'DESC']]);
			
			$row = $lastRecord->first();   
                
			if ($row)
			{				
				!(isset($row->salary_days)) ? : $payrollParameters['salaryDays'] = $row->salary_days;
				
				!(isset($row->cesta_ticket_month)) ? : $payrollParameters['cestaTicketMonth'] = $row->cesta_ticket_month;

				!(isset($row->days_cesta_ticket)) ? : $payrollParameters['daysCestaTicket'] = $row->days_cesta_ticket;
			
				!(isset($row->days_utilities)) ? : $payrollParameters['daysUtilities'] = $row->days_utilities;
				
				!(isset($row->collective_holidays)) ? : $payrollParameters['collectiveHolidays'] = $row->collective_holidays;
				
				!(isset($row->collective_vacation_bonus_days)) ? : $payrollParameters['collectiveVacationBonusDays'] = $row->collective_vacation_bonus_days;
			}
		}
		
		$controller = "Paysheets";
		$action = "edit";
		
        $this->set(compact('paysheet', 'payrollParameters', 'controller', 'action', 'positionCategories', 'arrayCategories'));
        $this->set('_serialize', ['paysheet', 'payrollParameters', 'controller', 'action', 'positionCategories', 'arrayCategories']); 
	}
				
            /* $paysheet = $this->Paysheets->patchEntity($paysheet, $this->request->data);
						
			
            
            $lastRecord = $this->Paysheets->find('all', ['conditions' => 
                [['year_paysheet' => $paysheet->year_paysheet],
                ['month_paysheet' => $paysheet->month_paysheet],
                ['fortnight' => $paysheet->fortnight],
                ['OR' => [['deleted_record IS NULL'], ['deleted_record' => 0]]]],
                'order' => ['Paysheets.created' => 'DESC']]);
    
            $row = $lastRecord->first(); 
                
            if ($row)
            {
                $this->Flash->error(__('Esta nómina ya existe'));
            }
            else
            {
                setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
                date_default_timezone_set('America/Caracas');
    
                if ($paysheet->fortnight == "1ra. Quincena")
                {
                    $paysheet->date_from = $paysheet->year_paysheet . '-' . $paysheet->month_paysheet . '-1';
                    $paysheet->date_until = $paysheet->year_paysheet . '-' . $paysheet->month_paysheet . '-15';
                }
                else
                {
                    $paysheet->date_from = $paysheet->year_paysheet . '-' . $paysheet->month_paysheet . '-16';

					if ($paysheet->year_paysheet == "2020" || 
						$paysheet->year_paysheet == "2024" ||
						$paysheet->year_paysheet == "2028" ||
						$paysheet->year_paysheet == "2032" )
					{
						$lastDay = $this->lastDayMonthLeap($paysheet->month_paysheet);
					}
					else
					{
						$lastDay = $this->lastDayMonth($paysheet->month_paysheet);
					}					
                    $paysheet->date_until = $paysheet->year_paysheet . '-' . $paysheet->month_paysheet . '-' . $lastDay;
                }
                
                $firstDay = $paysheet->year_paysheet . '-' . $paysheet->month_paysheet . '-01';
    
                $firstDayMonth = strtotime($firstDay);  
    
                switch (date('w', $firstDayMonth))
                { 
                    case 0: $nameDay = "Domingo"; break; 
                    case 1: $nameDay = "Lunes"; break;
                    case 2: $nameDay = "Martes"; break;
                    case 3: $nameDay = "Miércoles"; break; 
                    case 4: $nameDay = "Jueves"; break; 
                    case 5: $nameDay = "Viernes"; break;
                    case 6: $nameDay = "Sábado"; break;
                }  
    
                if ($nameDay == "Lunes")
                {
                    $paysheet->weeks_social_security = 5;
                }
                else
                {
                    $paysheet->weeks_social_security = 4;
                }
				                
                $paysheet->responsible_user = $this->Auth->user('username'); 
				
				$tableConfigurationJson = $this->initialConfiguration();
            
				$paysheet->table_configuration = $tableConfigurationJson;
												
				$tableCategoriesJson = json_encode($_POST['arrayCategories'], JSON_FORCE_OBJECT);
						
				$paysheet->table_categories = $tableCategoriesJson;
                
                if (!($this->Paysheets->save($paysheet)))
                {
                    $this->Flash->error(__('Los datos de la quincena no pudieron ser grabados, intente nuevamente'));                
                }
                else 
                {
                    $lastRecord = $this->Paysheets->find('all', ['conditions' => ['responsible_user' => $this->Auth->user('username')],
                    'order' => ['Paysheets.created' => 'DESC'] ]);
    
                    $row = $lastRecord->first();  

					if ($row)
					{
                    
						$employeesPaysheets = $employees->searchEmployees();
						
						if ($employeesPaysheets)
						{
							$result = $employeepayments->add($row, $employeesPaysheets);
							
							if ($result == 0)
							{
								$this->Flash->success(__('Por favor complete los datos de La nómina'));
								return $this->redirect(['action' => 'edit']);
							}
							else
							{
								$this->Flash->error(__('La nómina no se registró correctamente'));
							}
						}
						else
						{
							$this->Flash->error(__('No se encontraron registros de empleados'));
						}
					}
                }
            } 
        }
		else
		{			
            $lastRecord = $this->Paysheets->find('all', 
                ['conditions' => 
                ['OR' => [['deleted_record IS NULL'], ['deleted_record' => 0]]], 'order' => ['Paysheets.created' => 'DESC']]);
			
			$row = $lastRecord->first();   
                
			if ($row)
			{				
				!(isset($row->salary_days)) ? : $payrollParameters['salaryDays'] = $row->salary_days;
				
				!(isset($row->cesta_ticket_month)) ? : $payrollParameters['cestaTicketMonth'] = $row->cesta_ticket_month;

				!(isset($row->days_cesta_ticket)) ? : $payrollParameters['daysCestaTicket'] = $row->days_cesta_ticket;
			
				!(isset($row->days_utilities)) ? : $payrollParameters['daysUtilities'] = $row->days_utilities;
				
				!(isset($row->collective_holidays)) ? : $payrollParameters['collectiveHolidays'] = $row->collective_holidays;
				
				!(isset($row->collective_vacation_bonus_days)) ? : $payrollParameters['collectiveVacationBonusDays'] = $row->collective_vacation_bonus_days;
			}
		}
		
		$controller = "Paysheets";
		$action = "edit";
		
        $this->set(compact('paysheet', 'payrollParameters', 'controller', 'action', 'positionCategories', 'arrayCategories'));
        $this->set('_serialize', ['paysheet', 'payrollParameters', 'controller', 'action', 'positionCategories', 'arrayCategories']); */
    
    public function editPayrollFortnight($id = null, $controller = null, $action = null)
    {
		$this->loadModel('Positioncategories');

		$payrollParameters = [];
		$payrollParameters['salaryDays'] = 0;
		$payrollParameters['cestaTicketMonth'] = 0;
		$payrollParameters['daysCestaTicket'] = 0;
		$payrollParameters['daysUtilities'] = 0;
		$payrollParameters['collectiveHolidays'] = 0;
		$payrollParameters['collectiveVacationBonusDays'] = 0;
		$arrayCategories = [];
		
        $employees = new EmployeesController();
        
        $employeepayments = new EmployeepaymentsController();
		
		$positionCategories = $this->Positioncategories->find('all', 
			['conditions' => ['id >' => 1],
            'order' => ['Positioncategories.description_category' => 'ASC']]);
			
		foreach ($positionCategories as $positionCategorie)
		{
			$arrayCategories[$positionCategorie->description_category] = 0;
		}
        		
        $paysheet = $this->Paysheets->get($id, [
            'contain' => []
        ]);
			
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
			$paysheet = $this->Paysheets->patchEntity($paysheet, $this->request->data);
			
			$arrayResult = $this->moveColumns($paysheet, $payrollParameters);
			
			$paysheet = $arrayResult['paysheet'];
			
			$paysheet->responsible_user = $this->Auth->user('username'); 
			
			$tableConfigurationJson = $this->initialConfiguration();
		
			$paysheet->table_configuration = $tableConfigurationJson;
											
			$tableCategoriesJson = json_encode($_POST['arrayCategories'], JSON_FORCE_OBJECT);
					
			$paysheet->table_categories = $tableCategoriesJson;
			
			if (!($this->Paysheets->save($paysheet)))
			{
				$this->Flash->error(__('Los datos de la quincena no pudieron ser grabados, intente nuevamente'));                
			}
			else 
			{
				$this->Flash->success(__('Por favor complete los datos de La nómina'));
			}
		}
				
        $this->set(compact('paysheet', 'controller', 'action', 'positionCategories', 'arrayCategories'));
        $this->set('_serialize', ['paysheet', 'controller', 'action', 'positionCategories', 'arrayCategories']); 
	}
	
    public function nameMonthSpanish($month = null)
    {
        $monthNumbers = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $nameMonths = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $spanishMonth = str_replace($monthNumbers, $nameMonths, $month);
        return $spanishMonth;
    }
    public function classificationName($classification = null)
    {
        $classificationNumbers = ["01", "02", "03", "04", "05"];
        $namesClassification = ["Bachillerato y deporte", "Primaria", "Pre-escolar", "Administrativo y obrero", "Directivo"];
        $nameClassification = str_replace($classificationNumbers, $namesClassification, $classification);
        return $nameClassification;
    }
    public function lastDayMonth($month = null)
    {
        $monthNumbers = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $lastDay = ["31", "28", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31"];
        $englishMonth = str_replace($monthNumbers, $lastDay, $month);
        return $englishMonth;
    }
    public function lastDayMonthLeap($month = null)
    {
        $monthNumbers = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $lastDay = ["31", "29", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31"];
        $englishMonth = str_replace($monthNumbers, $lastDay, $month);
        return $englishMonth;
    }
    public function initialConfiguration()
    {
        $tableConfiguration = [];
        
        $tableConfiguration['identidy'] = '1';

        $tableConfiguration['position'] = '1';
		
		$tableConfiguration['sw_cesta_ticket'] = '0';

        $tableConfiguration['date_of_admission'] = '1';

        $tableConfiguration['monthly_salary'] = '1';

        $tableConfiguration['fortnight'] = '1';

        $tableConfiguration['amount_escalation_fortnight'] = '1';

        $tableConfiguration['salary_advance'] = '1';

        $tableConfiguration['other_income'] = '1';

        $tableConfiguration['faov'] = '1';

        $tableConfiguration['ivss'] = '1';

        $tableConfiguration['trust_days'] = '1';

        $tableConfiguration['escrow'] = '1';

        $tableConfiguration['discount_repose'] = '1';

        $tableConfiguration['discount_loan'] = '1';

        $tableConfiguration['percentage_imposed'] = '1';

        $tableConfiguration['amount_imposed'] = '1';

        $tableConfiguration['days_absence'] = '1';                                         
        
        $tableConfiguration['discount_absences'] = '1';

        $tableConfiguration['total_fortnight'] = '1';
		
		$tableConfiguration['days_cesta_ticket'] = '1';
		
		$tableConfiguration['amount_cesta_ticket'] = '1';
		
		$tableConfiguration['loan_cesta_ticket'] = '1';
		
		$tableConfiguration['total_cesta_ticket'] = '1';
		
        $tableConfigurationJson = json_encode($tableConfiguration, JSON_FORCE_OBJECT);
 
        return $tableConfigurationJson;       
    }

    public function moveConfiguration($idPaysheet = null, $valor = null)
    {		
		$paysheet = $this->Paysheets->get($idPaysheet);
                				
		$objectTableConfiguration = json_decode($paysheet->table_configuration);
				
		$tableConfiguration = (array) $objectTableConfiguration;
						
		if ($tableConfiguration['sw_cesta_ticket'] == 0)
        {
			$tableConfiguration['date_of_admission'] = $valor['view_date_of_admission'];

			$tableConfiguration['monthly_salary'] = $valor['view_monthly_salary'];

			$tableConfiguration['fortnight'] = $valor['view_fortnight'];

			$tableConfiguration['amount_escalation_fortnight'] = $valor['view_amount_escalation_fortnight'];

			$tableConfiguration['salary_advance'] = $valor['view_salary_advance'];

			$tableConfiguration['other_income'] = $valor['view_other_income'];

			$tableConfiguration['faov'] = $valor['view_faov'];

			$tableConfiguration['ivss'] = $valor['view_ivss'];

			$tableConfiguration['trust_days'] = $valor['view_trust_days'];

			$tableConfiguration['escrow'] = $valor['view_escrow'];

			$tableConfiguration['discount_repose'] = $valor['view_discount_repose'];

			$tableConfiguration['discount_loan'] = $valor['view_discount_loan'];

			$tableConfiguration['percentage_imposed'] = $valor['view_percentage_imposed'];

			$tableConfiguration['amount_imposed'] = $valor['view_amount_imposed'];

			$tableConfiguration['days_absence'] = $valor['view_days_absence'];                                         
			
			$tableConfiguration['discount_absences'] = $valor['view_discount_absences'];

			$tableConfiguration['total_fortnight'] = $valor['view_total_fortnight'];
		}
		else
		{
			$tableConfiguration['days_cesta_ticket'] = $valor['view_days_cesta_ticket'];
			
			$tableConfiguration['amount_cesta_ticket'] = $valor['view_amount_cesta_ticket'];
			
			$tableConfiguration['loan_cesta_ticket'] = $valor['view_loan_cesta_ticket'];
			
			$tableConfiguration['total_cesta_ticket'] = $valor['view_total_cesta_ticket'];
		}
		
		$previousSwCestaTicket = $tableConfiguration['sw_cesta_ticket'];
		
		$tableConfiguration['sw_cesta_ticket'] = $valor['view_sw_cesta_ticket'];
		
		$tableConfiguration['identidy'] = $valor['view_identidy'];

		$tableConfiguration['position'] = $valor['view_position'];
			
        $tableConfigurationJson = json_encode($tableConfiguration, JSON_FORCE_OBJECT);
		
        $paysheet->table_configuration = $tableConfigurationJson;	

        $arrayResult = [];
        		
        if ($this->Paysheets->save($paysheet)) 
        {
			$arrayResult['indicator'] = 0;
            $arrayResult['previousSwCestaTicket'] = $previousSwCestaTicket;
			$arrayResult['cesta_ticket_month'] = $paysheet->cesta_ticket_month;
        } 
        else
        {
            $arrayResult['indicator'] = 1;
        } 
        return $arrayResult;       
    }
	public function moveColumns($paysheet = null, $payrollParameters = null)
	{		
		$arrayResult = [];
		
		if (substr($_POST['salary_days'], -3, 1) == ',')
		{
			$replace1= str_replace('.', '', $_POST['salary_days']);
			$replace2 = str_replace(',', '.', $replace1);
			$paysheet->salary_days = $replace2;
			$payrollParameters['salaryDays'] = $replace2;
		}
		else
		{
			$payrollParameters['salaryDays'] = $_POST['salary_days'];
		}
	
		if (substr($_POST['cesta_ticket_month'], -3, 1) == ',')
		{
			$replace1= str_replace('.', '', $_POST['cesta_ticket_month']);
			$replace2 = str_replace(',', '.', $replace1);
			$paysheet->cesta_ticket_month = $replace2;
			$payrollParameters['cestaTicketMonth'] = $replace2;
		}
		else
		{
			$payrollParameters['cestaTicketMonth'] = $_POST['cesta_ticket_month'];
		}	
		
		if (substr($_POST['days_cesta_ticket'], -3, 1) == ',')
		{
			$replace1= str_replace('.', '', $_POST['days_cesta_ticket']);
			$replace2 = str_replace(',', '.', $replace1);
			$paysheet->days_cesta_ticket = $replace2;
			$payrollParameters['daysCestaTicket'] = $replace2;
		}
		else
		{
			$payrollParameters['daysCestaTicket'] = $_POST['days_cesta_ticket'];
		}	
		
		if (substr($_POST['days_utilities'], -3, 1) == ',')
		{
			$replace1= str_replace('.', '', $_POST['days_utilities']);
			$replace2 = str_replace(',', '.', $replace1);
			$paysheet->days_utilities = $replace2;
			$payrollParameters['daysUtilities'] = $replace2;
		}
		else
		{
			$payrollParameters['daysUtilities'] = $_POST['days_utilities'];
		}
		
		if (substr($_POST['collective_holidays'], -3, 1) == ',')
		{
			$replace1= str_replace('.', '', $_POST['collective_holidays']);
			$replace2 = str_replace(',', '.', $replace1);
			$paysheet->collective_holidays = $replace2;
			$payrollParameters['collectiveHolidays'] = $replace2;
		}
		else
		{
			$payrollParameters['collectiveHolidays'] = $_POST['collective_holidays'];
		}
		
		if (substr($_POST['collective_vacation_bonus_days'], -3, 1) == ',')
		{
			$replace1= str_replace('.', '', $_POST['collective_vacation_bonus_days']);
			$replace2 = str_replace(',', '.', $replace1);
			$paysheet->collective_vacation_bonus_days = $replace2;
			$payrollParameters['collectiveVacationBonusDays'] = $replace2;
		}
		else
		{
			$payrollParameters['collectiveVacationBonusDays'] = $_POST['collective_vacation_bonus_days'];
		}		

		$arrayResult['indicator'] = 0;
		$arrayResult['paysheet'] = $paysheet;
		$arrayResult['payrollParameters'] = $payrollParameters;
		
		return $arrayResult;
	}
}