<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\EmployeesController;

use App\Controller\EmployeepaymentsController;

use App\Controller\BinnaclesController;

use Cake\I18n\Time;

/**
 * Paysheets Controller
 *
 * @property \App\Model\Table\PaysheetsTable $Paysheets
 */
class PaysheetsController extends AppController
{
	public function testFunction()
	{
		$this->loadModel('Positioncategories');
		
		$positionCategories = $this->Positioncategories->find('all', 
			['conditions' => ['id >' => 1],
            'order' => ['Positioncategories.description_category' => 'ASC']]);
					
		$paysheet = $this->Paysheets->get(2);
		
		$objectArrayCategories = json_decode($paysheet->table_categories);
				
		$tableCategories = (array) $objectArrayCategories;
		
		print "<br />";
		print "<br />";

		debug($objectArrayCategories);		
		debug($tableCategories);

		foreach ($positionCategories as $positionCategorie)
		{
			if (isset($tableCategories[$positionCategorie->description_category]))
			{
				print "<p>" . $positionCategorie->description_category . " checked</p>";
			}
			else
			{
				print "<p>" . $positionCategorie->description_category . " unchecked</p>";
			}
		}
	}

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
				
		if ($this->request->is('post')) 
        {			
			$this->loadModel('Schools');

			$school = $this->Schools->get(2);
			
			$this->loadModel('Positioncategories');

			$positionCategories = $this->Positioncategories->find('list', ['limit' => 200, "order" => ["description_category" => "ASC"]]);
			
			$dateFrom = new Time();
			
			$dateFrom
				->year($_POST['yyFrom'])
				->month($_POST['mmFrom'])
				->day($_POST['ddFrom'])
				->hour(00)
				->minute(00)
				->second(00);
							
			$dateUntil = new Time();
						
			$dateUntil
				->year($_POST['yyUntil'])
				->month($_POST['mmUntil'])
				->day($_POST['ddUntil'])
				->hour(00)
				->minute(00)
				->second(00);
													
			if ($_POST['positionCategories'] == 1)
			{				
				$paysheets = $this->Paysheets->find('all', 
					['contain' => ['Positioncategories'],
					'conditions' => [['Paysheets.id >' => 1], ['date_from >=' => $dateFrom], ['date_until <=' => $dateUntil]],
					'order' => ['date_from' => 'ASC']]);
			}
			else
			{			
				$paysheets = $this->Paysheets->find('all', 
					['contain' => ['Positioncategories'],
					'conditions' => [['Paysheets.id >' => 1], ['Paysheets.date_from >=' => $dateFrom], ['Paysheets.date_until <=' => $dateUntil], ['Paysheets.positioncategory_id' => $_POST['positionCategories']]],
					'order' => ['date_from' => 'ASC']]);
			}
						
			$accountRecords = $paysheets->count();
						
			if ($accountRecords > 0)
			{				
				$this->set(compact('paysheets', 'school', 'positionCategories'));
				$this->set('_serialize', ['paysheets', 'school', 'positionCategories']);
			}
			else
			{
				$this->Flash->error(__("No se encontraron nóminas en ese período, por favor intente nuevamente"));
				return $this->redirect(['controller' => 'Paysheets', 'action' => 'searchPayroll']);				
			}
		}
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
    public function add($noPayroll = null)
    {
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
				
		$binnacles = new BinnaclesController;
				
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
		
		$positionCategories = $this->Positioncategories->find('list', ['limit' => 200, "order" => ["description_category" => "ASC"]]);
					        		
        $paysheet = $this->Paysheets->newEntity();
		
        if ($this->request->is('post')) 
        {
			$paysheet = $this->Paysheets->patchEntity($paysheet, $this->request->data);
									
			if ($paysheet->date_until->month < 10 )
			{
				$month = "0" . $paysheet->date_until->month;
			}
			else
			{
				$month = $paysheet->date_until->month;
			}
			
			$firstDay = $paysheet->date_until->year . '-' . $month . '-01';
			
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
						                			
			$tableConfigurationJson = $this->initialConfiguration();
		
			$paysheet->table_configuration = $tableConfigurationJson;
			
			$paysheet->registration_status = "Abierta"; 
			
			$paysheet->responsible_user = $this->Auth->user('username'); 
			
			if ($this->Paysheets->save($paysheet))
			{
				$arrayResult = $employees->searchEmployees($paysheet->positioncategory_id);
				
				if ($arrayResult["indicator"] == 0)
				{
					$lastRecord = $this->Paysheets->find('all', ['conditions' => ['responsible_user' => $this->Auth->user('username')],
                    'order' => ['Paysheets.created' => 'DESC'] ]);
    
                    $row = $lastRecord->first();
					
					$result = $employeepayments->add($row, $arrayResult["employees"]);
					
					if ($result == 0)
					{
						$this->Flash->success(__('Por favor complete los datos de La nómina'));
						return $this->redirect(['controller' => 'Paysheets', 'action' => 'directPayroll']);
					}
					else
					{
						$this->Flash->error(__('La nómina no se registró correctamente'));
					}
				}
				else
				{
					$this->Flash->error(__('No se encontraron empleados activos en esa categoría'));
				}
			}
			else 
			{				
				if($paysheet->errors())
				{
					$error_msg = $this->arrayErrors($paysheet->errors());
				}
				else
				{
					$error_msg = ['Error desconocido'];
				}
				foreach($error_msg as $noveltys)
				{
					$result = $binnacles->add('controller', 'Paysheet', 'add', $noveltys);
				}
				$this->Flash->error(__('No se pudo crear la nómina debido a: ' . implode(" - ", $error_msg)));				
			}
		}
		else
		{
			if (!isset($noPayroll))
			{				
				$lastRecord = $this->Paysheets->find('all', 
					['conditions' => 
					['OR' => [['registration_status IS NULL'], ['registration_status !=' => "Eliminada"]]], 'order' => ['Paysheets.created' => 'DESC']]);
				
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
		}
		
		$controller = "Paysheets";
		$action = "edit";
		
        $this->set(compact('paysheet', 'payrollParameters', 'controller', 'action', 'positionCategories'));
        $this->set('_serialize', ['paysheet', 'payrollParameters', 'controller', 'action', 'positionCategories']); 
	}
				    
    public function edit($id = null, $controller = null, $action = null)
    {
		$this->loadModel('Positioncategories');
		
        $employees = new EmployeesController();
        
        $employeepayments = new EmployeepaymentsController();
				
		$positionCategories = $this->Positioncategories->find('list', ['limit' => 200, "order" => ["description_category" => "ASC"]]);
			
		$paysheet = $this->Paysheets->get($id);
				
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
			$paysheet = $this->Paysheets->patchEntity($paysheet, $this->request->data);
						
			$paysheet->responsible_user = $this->Auth->user('username'); 
															
			if ($this->Paysheets->save($paysheet))
			{
				$lastRecord = $this->Paysheets->find('all', ['conditions' => ['id' => $paysheet->id],
                    'order' => ['Paysheets.created' => 'DESC'] ]);
    
                $row = $lastRecord->first();
				
				if ($row)
				{
					$arrayResult = $employeepayments->updatePayments($row);
					
					if ($arrayResult['indicator'] == 0)
					{
						$this->Flash->success(__('Por favor complete los datos de La nómina'));
						return $this->redirect(['controller' => 'Paysheets', 'action' => 'directPayroll', $paysheet->id]);
					}
					else
					{
						$this->Flash->error(__('No se pudieron actualizar los pagos correspondientes a la nòmina'));
					}
				}
				else
				{
					$this->Flash->error(__('No se encontró el registro de nómina con id: ' . $paysheet->id));
				}
			}
			else 
			{
				$this->Flash->error(__('Los datos de la nómina no pudieron ser actualizados, intente nuevamente'));                				
			}
		}
				
        $this->set(compact('paysheet', 'controller', 'action', 'positionCategories', 'tableCategories'));
        $this->set('_serialize', ['paysheet', 'controller', 'action', 'positionCategories', 'tableCategories']); 
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

    public function directPayroll($id = null)
    {
        $this->autoRender = false;
        
		if (isset($id))
		{
			return $this->redirect(['controller' => 'Employeepayments', 'action' => 'edit', $id]);
		}
		else
		{
			$lastRecord = $this->Paysheets->find('all', 
				['conditions' => ['id >' => 1, 'OR' => [['registration_status IS NULL'], ['registration_status !=' => "Eliminada"]]], 
				'order' => ['Paysheets.created' => 'DESC']]);
			
			$row = $lastRecord->first();   
					
			if ($row)
			{
				return $this->redirect(['controller' => 'Employeepayments', 'action' => 'edit', $row->id]);
			}
			else
			{
				$this->Flash->error(__('No se encontraron nóminas'));
				return $this->redirect(['controller' => 'Paysheets', 'action' => 'add', 1]);
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
    public function delete($id = null, $controller = null, $action = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		
		if (isset($_POST['idPaysheet']))
		{
			$id = $_POST['idPaysheet'];
			$controller = $_POST['controller'];
			$action = $_POST['action'];
		}
		
        $paysheet = $this->Paysheets->get($id);
        
        $paysheet->registration_status = "Eliminada";
        
        $paysheet->responsible_user	= $this->Auth->user('username');
        
        if ($this->Paysheets->save($paysheet)) 
        {
            $this->Flash->success(__('La nómina fue eliminada exitosamente'));
        }
        else 
        {
            $this->Flash->error(__('No se pudo eliminar la nómina'));
        }

        return $this->redirect(['controller' => $controller, 'action' => $action]);
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
        
        $tableConfiguration['identidy'] = 'allColumns identificacion';

        $tableConfiguration['position'] = 'allColumns cargo';
		
        $tableConfiguration['date_of_admission'] = 'allColumns fecha-ingreso';

        $tableConfiguration['monthly_salary'] = 'allColumns sueldo-mensual';

        $tableConfiguration['payment_period'] = 'allColumns pago-periodo';

        $tableConfiguration['amount_escalation'] = 'allColumns escalafon';

        $tableConfiguration['other_income'] = 'allColumns otros-ingresos';
		
        $tableConfiguration['faov'] = 'allColumns faov';

        $tableConfiguration['ivss'] = 'allColumns ivss';

        $tableConfiguration['trust_days'] = 'allColumns dias-fideicomiso';

        $tableConfiguration['escrow'] = 'allColumns fideicomiso';

        $tableConfiguration['discount_repose'] = 'allColumns reposo';
		
        $tableConfiguration['salary_advance'] = 'allColumns adelanto-sueldo';

        $tableConfiguration['discount_loan'] = 'allColumns prestamos';

        $tableConfiguration['percentage_imposed'] = 'allColumns porcentaje-impuesto';

        $tableConfiguration['amount_imposed'] = 'allColumns monto-impuesto';

        $tableConfiguration['days_absence'] = 'allColumns dias-inasistencias';                                         
        
        $tableConfiguration['discount_absences'] = 'allColumns inasistencias';

        $tableConfiguration['total_payment'] = 'allColumns total-pago';
		
		$tableConfiguration['days_cesta_ticket'] = 'allColumns dias-cesta-ticket';
		
		$tableConfiguration['amount_cesta_ticket'] = 'allColumns monto-cesta-ticket';
		
		$tableConfiguration['loan_cesta_ticket'] = 'allColumns prestamos-cesta-ticket';
		
		$tableConfiguration['total_cesta_ticket'] = 'allColumns total-cesta-ticket';
		
        $tableConfigurationJson = json_encode($tableConfiguration, JSON_FORCE_OBJECT);
 
        return $tableConfigurationJson;       
    }

    public function moveConfiguration($idPaysheet = null, $columnsReport = null)
    {		
		$paysheet = $this->Paysheets->get($idPaysheet);
                				
		$objectTableConfiguration = json_decode($paysheet->table_configuration);
				
		$tableConfiguration = (array) $objectTableConfiguration;

		isset($columnsReport['identidy']) ? $tableConfiguration['identidy'] = 'allColumns identificacion' : $tableConfiguration['identidy'] = 'allColumns identificacion noverScreen';

		isset($columnsReport['position']) ? $tableConfiguration['position'] = 'allColumns cargo' : $tableConfiguration['position'] = 'allColumns cargo noverScreen';		

		isset($columnsReport['date_of_admission']) ? $tableConfiguration['date_of_admission'] = 'allColumns fecha-ingreso' : $tableConfiguration['date_of_admission'] = 'allColumns fecha-ingreso noverScreen';
		
		isset($columnsReport['monthly_salary']) ? $tableConfiguration['monthly_salary'] = 'allColumns sueldo-mensual' : $tableConfiguration['monthly_salary'] = 'allColumns sueldo-mensual noverScreen';
		
		isset($columnsReport['payment_period']) ? $tableConfiguration['payment_period'] = 'allColumns pago-periodo' : $tableConfiguration['payment_period'] = 'allColumns pago-periodo noverScreen';
		
		isset($columnsReport['amount_escalation']) ? $tableConfiguration['amount_escalation'] = 'allColumns escalafon' : $tableConfiguration['amount_escalation'] = 'allColumns escalafon noverScreen';
		
		isset($columnsReport['other_income']) ? $tableConfiguration['other_income'] = 'allColumns otros-ingresos' : $tableConfiguration['other_income'] = 'allColumns otros-ingresos noverScreen';		

		isset($columnsReport['faov']) ? $tableConfiguration['faov'] = 'allColumns faov' : $tableConfiguration['faov'] = 'allColumns faov noverScreen';
		
		isset($columnsReport['ivss']) ? $tableConfiguration['ivss'] = 'allColumns ivss' : $tableConfiguration['ivss'] = 'allColumns ivss noverScreen';
		
		isset($columnsReport['trust_days']) ? $tableConfiguration['trust_days'] = 'allColumns dias-fideicomiso' : $tableConfiguration['trust_days'] = 'allColumns dias-fideicomiso noverScreen';
		
		isset($columnsReport['escrow']) ? $tableConfiguration['escrow'] = 'allColumns fideicomiso' : $tableConfiguration['escrow'] = 'allColumns fideicomiso noverScreen';

		isset($columnsReport['discount_repose']) ? $tableConfiguration['discount_repose'] = 'allColumns reposo' : $tableConfiguration['discount_repose'] = 'allColumns reposo noverScreen';		

		isset($columnsReport['salary_advance']) ? $tableConfiguration['salary_advance'] = 'allColumns adelanto-sueldo' : $tableConfiguration['salary_advance'] = 'allColumns adelanto-sueldo noverScreen';
		
		isset($columnsReport['discount_loan']) ? $tableConfiguration['discount_loan'] = 'allColumns prestamos' : $tableConfiguration['discount_loan'] = 'allColumns prestamos noverScreen';
		
		isset($columnsReport['percentage_imposed']) ? $tableConfiguration['percentage_imposed'] = 'allColumns porcentaje-impuesto' : $tableConfiguration['percentage_imposed'] = 'allColumns porcentaje-impuesto noverScreen';
		
		isset($columnsReport['amount_imposed']) ? $tableConfiguration['amount_imposed'] = 'allColumns monto-impuesto' : $tableConfiguration['amount_imposed'] = 'allColumns monto-impuesto noverScreen';

		isset($columnsReport['days_absence']) ? $tableConfiguration['days_absence'] = 'allColumns dias-inasistencias' : $tableConfiguration['days_absence'] = 'allColumns dias-inasistencias noverScreen';		

		isset($columnsReport['discount_absences']) ? $tableConfiguration['discount_absences'] = 'allColumns inasistencias' : $tableConfiguration['discount_absences'] = 'allColumns inasistencias noverScreen';
		
		isset($columnsReport['total_payment']) ? $tableConfiguration['total_payment'] = 'allColumns total-pago' : $tableConfiguration['total_payment'] = 'allColumns total-pago noverScreen';
		
		isset($columnsReport['days_cesta_ticket']) ? $tableConfiguration['days_cesta_ticket'] = 'allColumns dias-cesta-ticket' : $tableConfiguration['days_cesta_ticket'] = 'allColumns dias-cesta-ticket noverScreen';
		
		isset($columnsReport['amount_cesta_ticket']) ? $tableConfiguration['amount_cesta_ticket'] = 'allColumns monto-cesta-ticket' : $tableConfiguration['amount_cesta_ticket'] = 'allColumns monto-cesta-ticket noverScreen';

		isset($columnsReport['loan_cesta_ticket']) ? $tableConfiguration['loan_cesta_ticket'] = 'allColumns prestamos-cesta-ticket' : $tableConfiguration['loan_cesta_ticket'] = 'allColumns prestamos-cesta-ticket noverScreen';		

		isset($columnsReport['total_cesta_ticket']) ? $tableConfiguration['total_cesta_ticket'] = 'allColumns total-cesta-ticket' : $tableConfiguration['total_cesta_ticket'] = 'allColumns total-cesta-ticket noverScreen';
				
        $tableConfigurationJson = json_encode($tableConfiguration, JSON_FORCE_OBJECT);
		
        $paysheet->table_configuration = $tableConfigurationJson;	

        $arrayResult = [];
        		
        if ($this->Paysheets->save($paysheet)) 
        {
			$arrayResult['indicator'] = 0;
			$arrayResult['cesta_ticket_month'] = $paysheet->cesta_ticket_month;
        } 
        else
        {
            $arrayResult['indicator'] = 1;
        } 
        return $arrayResult;       
    }
	
	public function searchPayroll()
	{
		$this->loadModel('Schools');

        $school = $this->Schools->get(2);
		
		$this->loadModel('Positioncategories');

        $positionCategories = $this->Positioncategories->find('list', ['limit' => 200, "order" => ["description_category" => "ASC"]]);	

        $this->set(compact('school', 'positionCategories'));
        $this->set('_serialize', ['school', 'positionCategories']);
	}
	public function arrayErrors($arrayCake = null)
	{
		$error_msg = [];
		
		foreach($arrayCake as $errors)
		{
			if(is_array($errors))
			{
				foreach($errors as $error)
				{
					
					$error_msg[] = $error;
				}
			}
			else
			{
				$error_msg[] = $errors;
			}
		}
		
		return $error_msg;
	}
}