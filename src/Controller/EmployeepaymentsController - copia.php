<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\EmployeesController;

use App\Controller\PaysheetsController;

use Cake\ORM\TableRegistry;

use Cake\I18n\Time;

/**
 * Employeepayments Controller
 *
 * @property \App\Model\Table\EmployeepaymentsTable $Employeepayments
 */
class EmployeepaymentsController extends AppController
{
    public function testFunction()
    {
		$employeepayment = $this->Employeepayments->get(273);
		
		$tableConfiguration = json_decode($employeepayment->table_configuration); 
		
		$arrayTableConfiguration = (array) $tableConfiguration;
		
		debug($tableConfiguration);
		debug($arrayTableConfiguration);
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($idPaysheet = null, $year = null, $month, $fortnight = null, $classification = null)
    {
        $employeepayments = TableRegistry::get('Employeepayments');

        $query = $employeepayments->find()
            ->contain(['Employees' => ['Positions']])
            ->where(['paysheet_id' => $idPaysheet, 'Employees.classification' => $classification])
            ->order(['Employees.surname' => 'ASC', 'Employees.first_name' => 'ASC']);

        $this->set('employeesFor', $this->paginate($query));

        $this->set(compact('employeesFor', 'year', 'month', 'fortnight', 'classification'));
        $this->set('_serialize', ['employeesFor', 'year', 'month', 'fortnight', 'classification']);
    }

    /**
     * View method
     *
     * @param string|null $id Employeepayment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employeepayment = $this->Employeepayments->get($id, [
            'contain' => []
        ]);

        $this->set('employeepayment', $employeepayment);
        $this->set('_serialize', ['employeepayment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($paysheet = null, $employeesPaysheets = null)
    {
        $this->autoRender = false;
        
        $result = 0;
    
        foreach ($employeesPaysheets as $employeesPaysheet) 
        {
            $result = $this->addRecord($paysheet, $employeesPaysheet);
            if ($result == 1)
            {
                break;
            }
        }
        return $result;
    }
    
    public function addRecord($paysheet = null, $employeesPaysheet = null)
    {
        $employeepayment = $this->Employeepayments->newEntity();
        
        $employeepayment->paysheet_id = $paysheet->id;
        
        $employeepayment->employee_id = $employeesPaysheet->id;
        
        $employeepayment->current_position = $employeesPaysheet->position->short_name;
    
        $employeepayment->current_basic_salary = $employeesPaysheet->position->minimum_wage;
        
        $employeepayment->current_monthly_hours = $employeesPaysheet->hours_month;

        if ($employeesPaysheet->position->type_of_salary == "Por horas")
        {
            $employeepayment->monthly_salary = $employeesPaysheet->position->minimum_wage * $employeesPaysheet->hours_month;
            
            $fortnight = $employeepayment->monthly_salary/2;
            
            $employeepayment->fortnight = round($fortnight, 2);
        }
        else
        {
            $employeepayment->monthly_salary = $employeesPaysheet->position->minimum_wage;
            
            $fortnight = $employeepayment->monthly_salary/2;

            $employeepayment->fortnight = round($fortnight, 2);
        }
        
        $employeepayment->percentage_imposed = $employeesPaysheet->percentage_imposed;
        
        $period = $this->calculatePeriod($employeesPaysheet->date_of_admission);
        
        $years = $period->format('%Y');
        
        $employeepayment->years_service = $years;
        
        if ((15 + ($years - 1)) > 30)
        {
            $employeepayment->bv = 30;
        }
        else if ((15 + ($years - 1)) <= 15)
        {
            $employeepayment->bv = 15;
        }
        else
        {
            $employeepayment->bv = 15 + ($years - 1);
        }
        
        $employeepayment->scale = floor($years / 5) * 0.05;
        
        $employeepayment->amount_escalation = $employeepayment->scale * $employeepayment->monthly_salary;

        $employeepayment->integral_salary = (($employeepayment->bv + 60)/360) * (($employeepayment->monthly_salary + $employeepayment->amount_escalation)/30) + (($employeepayment->monthly_salary + $employeepayment->amount_escalation)/30); 

        $employeepayment->trust_days = 5;

        $employeepayment->salary_advance = 0.00;

        $employeepayment->other_income = 0.00;
                
        $employeepayment->discount_repose = 0.00;
                
        $employeepayment->discount_loan = 0.00;
                
        $employeepayment->days_absence = 0;
                
        $employeepayment->discount_absences = $employeepayment->days_absence * (($employeepayment->monthly_salary + $employeepayment->amount_escalation)/30);
                
        $employeepayment->faov = ($employeepayment->fortnight + ($employeepayment->amount_escalation/2) +  $employeepayment->other_income -  $employeepayment->discount_absences) * 0.01;

		if ($paysheet->fortnight == '1ra. Quincena')
		{
			$employeepayment->ivss = 0;           
        
			$employeepayment->amount_imposed = 0;
		}
		else
		{
			$employeepayment->ivss = (((($employeepayment->monthly_salary + $employeepayment->amount_escalation) * 12) / 52) * 0.045 * $paysheet->weeks_social_security) / 2;           
        
			$employeepayment->amount_imposed = (($employeepayment->monthly_salary + $employeepayment->amount_escalation) * $employeepayment->percentage_imposed)/100;
		}
		
        $employeepayment->total_fortnight = $employeepayment->fortnight + ($employeepayment->amount_escalation/2) + $employeepayment->other_income - $employeepayment->faov - $employeepayment->ivss - $employeepayment->salary_advance - $employeepayment->discount_loan - $employeepayment->amount_imposed - $employeepayment->discount_absences; 

		$employeepayment->days_cesta_ticket = 30 - $employeepayment->days_absence;
		
		$employeepayment->amount_cesta_ticket = $employeepayment->days_cesta_ticket * ($paysheet->cesta_ticket_month/30);
		
		$employeepayment->loan_cesta_ticket = 0;
		
		$employeepayment->total_cesta_ticket = $employeepayment->amount_cesta_ticket - $employeepayment->loan_cesta_ticket;
		
        if ($this->Employeepayments->save($employeepayment)) 
        {
            $result = 0;
        } 
        else
        {
            $result = 1;
        }
        return $result;
    }

    public function completeData($idPaysheet = null, $weeksSocialSecurity = null, $year = null, $monthNumber = null, $month = null, $fortnight = null, $classification = null)
    {
        $employee = new EmployeesController();
		
		$paysheet = new PaysheetsController();
        
        if ($this->request->is('post')) 
        {
            $accountEmployee = 1;
            
            foreach ($_POST['employeepayment'] as $valor)
            {
                $employeepayment = $this->Employeepayments->get($valor['id'], ['contain' => ['Employees']]);
                
                if ($accountEmployee == 1)
                {
                    $classification = $employeepayment->employee->classification;
					
					$arrayResult = $paysheet->moveConfiguration($idPaysheet, $valor);
					
					if ($arrayResult['indicator'] == 0)
					{
						$previousSwCestaTicket = $arrayResult['previousSwCestaTicket']; 
					}
					else
					{
						$this->Flash->error(__('No se pudo actualizar la tabla de configuración de la nómina identificada con: ' . $idPaysheet));
						return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
					}					
                    $accountEmployee++;
                }
				
				if ($previousSwCestaTicket == 0)
				{				
					if (substr($valor['salary_advance'], -3, 1) == ',')
					{
						$replace1= str_replace('.', '', $valor['salary_advance']);
						$replace2 = str_replace(',', '.', $replace1);
						$employeepayment->salary_advance = $replace2;
					}
					else
					{
						$employeepayment->salary_advance = $valor['salary_advance'];
					}

					if (substr($valor['other_income'], -3, 1) == ',')
					{
						$replace1= str_replace('.', '', $valor['other_income']);
						$replace2 = str_replace(',', '.', $replace1);
						$employeepayment->other_income = $replace2;
					}
					else
					{
						$employeepayment->other_income = $valor['other_income'];
					}
				
					if ($valor['discount_repose'] > 0.00)
					{
						$employeepayment->repose = true;
					}

					if (substr($valor['discount_repose'], -3, 1) == ',')
					{
						$replace1= str_replace('.', '', $valor['discount_repose']);
						$replace2 = str_replace(',', '.', $replace1);
						$employeepayment->discount_repose = $replace2;
					}
					else
					{
						$employeepayment->discount_repose = $valor['discount_repose'];
					}
					
					if (substr($valor['discount_loan'], -3, 1) == ',')
					{
						$replace1= str_replace('.', '', $valor['discount_loan']);
						$replace2 = str_replace(',', '.', $replace1);
						$employeepayment->discount_loan = $replace2;
					}
					else
					{
						$employeepayment->discount_loan = $valor['discount_loan'];
					}
					
					if (substr($valor['days_absence'], -3, 1) == ',')
					{
						$replace1= str_replace('.', '', $valor['days_absence']);
						$replace2 = str_replace(',', '.', $replace1);
						$employeepayment->days_absence = $replace2;
					}
					else
					{
						$employeepayment->days_absence = $valor['days_absence'];
					}

					$employeepayment->discount_absences = $employeepayment->days_absence * (($employeepayment->monthly_salary + $employeepayment->amount_escalation)/30);
					
					$employeepayment->faov = ($employeepayment->fortnight + ($employeepayment->amount_escalation/2) +  $employeepayment->other_income -  $employeepayment->discount_absences) * 0.01;

					if ($fortnight == '1ra. Quincena')
					{				
						$employeepayment->ivss = 0;
					}
					else
					{
						$employeepayment->ivss = (((($employeepayment->monthly_salary + $employeepayment->amount_escalation) * 12) / 52) * 0.045 * $weeksSocialSecurity) / 2;	
					}           

					if (substr($valor['trust_days'], -3, 1) == ',')
					{
						$replace1= str_replace('.', '', $valor['trust_days']);
						$replace2 = str_replace(',', '.', $replace1);
						$employeepayment->trust_days = $replace2;
					}
					else
					{
						$employeepayment->trust_days = $valor['trust_days'];
					}

					if (substr($valor['percentage_imposed'], -3, 1) == ',')
					{
						$replace1= str_replace('.', '', $valor['percentage_imposed']);
						$replace2 = str_replace(',', '.', $replace1);
					}
					else
					{
						$replace2 = $valor['percentage_imposed'];
					}

					if ($employeepayment->percentage_imposed != $replace2)
					{
						 $result = $employee->editImposed($employeepayment->employee_id, $replace2);
						 
						 if ($result == 1)
						 {
							 $this->Flash->error(__('No se pudo actualizar el porcentaje de impuesto en la tabla empleado del empleado: ' . $employeepayment->employee_id));
						 }
						 else
						 {
							 $employeepayment->percentage_imposed = $replace2;
						 }
					}
					
					if ($fortnight == '1ra. Quincena')
					{
						$employeepayment->amount_imposed = 0;
					}
					else
					{
						$employeepayment->amount_imposed = (($employeepayment->monthly_salary + $employeepayment->amount_escalation + $employeepayment->salary_advance) * $employeepayment->percentage_imposed)/100;					
					}
				
					$employeepayment->total_fortnight = $employeepayment->fortnight + ($employeepayment->amount_escalation/2) + $employeepayment->other_income - $employeepayment->faov - $employeepayment->ivss - $employeepayment->salary_advance - $employeepayment->discount_loan - $employeepayment->amount_imposed - $employeepayment->discount_absences; 
				}
				
                if (!($this->Employeepayments->save($employeepayment)))
                {
                    $this->Flash->error(__('No pudo ser actualizado el pago identificado con el id: ' . $valor['id']));            
                }
            }
            return $this->redirect(['controller' => 'Paysheets', 'action' => 'edit', $idPaysheet, $classification]);
        }    

        $employeepayments = TableRegistry::get('Employeepayments');
        
        $arrayResult = $employeepayments->find('fortnight', ['idPaysheet' => $idPaysheet, 'classification' => $classification]);
        
        if ($arrayResult['indicator'] == 0)
        {
            $employeesFor = $arrayResult['searchRequired'];
			
			$paysheet = $this->Employeepayments->Paysheets->get($idPaysheet);
                				
			$tableConfiguration = json_decode($paysheet->table_configuration);
           
            $currentView = 'employeepaymentsCompleteData';
            
            if ($fortnight == '1ra. Quincena')
            {
                $fortnightNumber = 1;
            }
            else
            {
                $fortnightNumber = 2;
            }
    
            $classificationNumber = $this->classificationNumber($classification);
			           
            $this->set(compact('employeesFor', 'year', 'monthNumber', 'month', 'fortnightNumber', 'fortnight', 'classificationNumber', 'classification', 'currentView', 'idPaysheet', 'tableConfiguration', 'weeksSocialSecurity'));
            $this->set('_serialize', ['employeesFor', 'year', 'monthNumber', 'month', 'fortnightNumber', 'fortnight', 'classificationNumber', 'classification', 'currentView', 'idPaysheet', 'tableConfiguration', 'weeksSocialSecurity']);
        }
    }
    
    public function overPayment($idPaysheet = null, $year = null, $month = null, $fortnight = null, $classification = null, $monthNumber = null)
    {
		$paysheet = $this->Employeepayments->Paysheets->get($idPaysheet);
		
        $employeepayments = TableRegistry::get('Employeepayments');
        
        $arrayResult = $employeepayments->find('fortnight', ['idPaysheet' => $idPaysheet, 'classification' => $classification]);
        
        if ($arrayResult['indicator'] == 0)
        {
            $employeesFor = $arrayResult['searchRequired'];

            $currentView = 'overPayment';
            
            if ($fortnight == '1ra. Quincena')
            {
                $fortnightNumber = 1;
            }
            else
            {
                $fortnightNumber = 2;
            }
    
            $classificationNumber = $this->classificationNumber($classification);
            
            $this->set(compact('employeesFor', 'currentView', 'idPaysheet', 'year', 'month', 'fortnight', 'classification', 'fortnightNumber', 'monthNumber', 'paysheet'));
            $this->set('_serialize', ['employeesFor', 'currentView', 'idPaysheet', 'year', 'month', 'fortnight', 'classification', 'fortnightNumber', 'monthNumber', 'paysheet']);
        }        
    }

    public function overTax($idPaysheet = null, $year = null, $month = null, $fortnight = null, $classification = null, $monthNumber = null)
    {
		$paysheet = $this->Employeepayments->Paysheets->get($idPaysheet);
		
        $employeepayments = TableRegistry::get('Employeepayments');
        
        $arrayResult = $employeepayments->find('fortnight', ['idPaysheet' => $idPaysheet, 'classification' => $classification]);
        
        if ($arrayResult['indicator'] == 0)
        {
            $employeesFor = $arrayResult['searchRequired'];

            $currentView = 'overPayment';
            
            if ($fortnight == '1ra. Quincena')
            {
                $fortnightNumber = 1;
            }
            else
            {
                $fortnightNumber = 2;
            }
    
            $classificationNumber = $this->classificationNumber($classification);
            
            $this->set(compact('employeesFor', 'currentView', 'idPaysheet', 'year', 'month', 'fortnight', 'classification', 'fortnightNumber', 'monthNumber', 'paysheet'));
            $this->set('_serialize', ['employeesFor', 'currentView', 'idPaysheet', 'year', 'month', 'fortnight', 'classification', 'fortnightNumber', 'monthNumber', 'paysheet']);
        }        
    }
	
    /**
     * Edit method
     *
     * @param string|null $id Employeepayment id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $weeksSocialSecurity = null, $employeesPaysheet = null)
    {
        $employeepayment = $this->Employeepayments->get($id, [
            'contain' => []
        ]);

        $employeepayment->current_position = $employeesPaysheet->position->short_name;
    
        $employeepayment->current_basic_salary = $employeesPaysheet->position->minimum_wage;
        
        $employeepayment->current_monthly_hours = $employeesPaysheet->hours_month;

        if ($employeesPaysheet->position->type_of_salary == "Por horas")
        {
            $employeepayment->monthly_salary = $employeesPaysheet->position->minimum_wage * $employeesPaysheet->hours_month;
            
            $fortnight = $employeepayment->monthly_salary/2;
            
            $employeepayment->fortnight = round($fortnight, 2);
        }
        else
        {
            $employeepayment->monthly_salary = $employeesPaysheet->position->minimum_wage;
            
            $fortnight = $employeepayment->monthly_salary/2;

            $employeepayment->fortnight = round($fortnight, 2);
        }
        
        $employeepayment->percentage_imposed = $employeesPaysheet->percentage_imposed;
        
        $period = $this->calculatePeriod($employeesPaysheet->date_of_admission);
        
        $years = $period->format('%Y');
        
        $employeepayment->years_service = $years;
        
        if ((15 + ($years - 1)) > 30)
        {
            $employeepayment->bv = 30;
        }
        else if ((15 + ($years - 1)) <= 15)
        {
            $employeepayment->bv = 15;
        }
        else
        {
            $employeepayment->bv = 15 + ($years - 1);
        }
        
        $employeepayment->scale = floor($years / 5) * 0.05;
        
        $employeepayment->amount_escalation = $employeepayment->scale * $employeepayment->monthly_salary;

        $employeepayment->integral_salary = (($employeepayment->bv + 60)/360) * (($employeepayment->monthly_salary + $employeepayment->amount_escalation)/30) + (($employeepayment->monthly_salary + $employeepayment->amount_escalation)/30); 

        $employeepayment->discount_absences = $employeepayment->days_absence * (($employeepayment->monthly_salary + $employeepayment->amount_escalation)/30);
                
        $employeepayment->faov = ($employeepayment->fortnight + ($employeepayment->amount_escalation/2) +  $employeepayment->other_income -  $employeepayment->discount_absences) * 0.01;
      
        $employeepayment->ivss = (((($employeepayment->monthly_salary + $employeepayment->amount_escalation) * 12) / 52) * 0.045 * $weeksSocialSecurity) / 2;           
        
        $employeepayment->amount_imposed = (($employeepayment->monthly_salary + $employeepayment->amount_escalation + $employeepayment->salary_advance) * $employeepayment->percentage_imposed)/100;

        $employeepayment->total_fortnight = $employeepayment->fortnight + ($employeepayment->amount_escalation/2) + $employeepayment->salary_advance + $employeepayment->other_income - $employeepayment->faov - $employeepayment->ivss - $employeepayment->discount_loan - $employeepayment->amount_imposed - $employeepayment->discount_absences; 

        if ($this->Employeepayments->save($employeepayment)) 
        {
            $result = 0;
        } 
        else
        {
            $result = 1;
        }
        return $result;
    }

    /**
     * Delete method
     *
     * @param string|null $id Employeepayment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $employeepayment = $this->Employeepayments->get($id, [
            'contain' => []
        ]);

        $employeepayment->deleted_record = 1;
    
        $employeepayment->responsible_user = $this->Auth->user('username');
        
        if ($this->Employeepayments->save($employeepayment)) 
        {
            $result = 0;
        } 
        else
        {
            $result = 1;
        }
        return $result;
    }
    
    public function calculatePeriod($initialDate)
    {
        $dateFrom = new Time(date('Y/m/d',strtotime($initialDate)));

        $dateToday = Time::now();

        $period = date_diff($dateToday,$dateFrom); 
        
        return $period;
    }
    public function reportPrint($idPaysheet = null, $year = null, $month, $fortnight = null, $classification = null)
    {
        $employeepayments = TableRegistry::get('Employeepayments');

        $employeesFor = $employeepayments->find()
            ->contain(['Employees' => ['Positions']])
            ->where(['paysheet_id' => $idPaysheet, 'Employees.classification' => $classification])
            ->order(['Employees.surname' => 'ASC', 'Employees.first_name' => 'ASC']);
            
        $totalPages = ceil($employeesFor->count() / 10);

        $this->set(compact('employeesFor', 'year', 'month', 'fortnight', 'classification', 'totalPages'));
        $this->set('_serialize', ['employeesFor', 'year', 'month', 'fortnight', 'classification', 'totalPages']);        
    }
    public function classificationNumber($classification = null)
    {
        $nameClassification = ["Bachillerato y deporte", "Primaria", "Pre-escolar", "Administrativo y obrero", "Directivo"];
        $classificationNumbers = ["01", "02", "03", "04", "05"];
        $classificationNumber = str_replace($nameClassification, $classificationNumbers, $classification);
        return $classificationNumber;
    }
}