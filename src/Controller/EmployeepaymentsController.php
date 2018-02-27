<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\EmployeesController;

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
        $tableConfiguration = [];
        
        $tableConfiguration['cedula'] = 0;
        
        $tableConfiguration['cargo'] = 1;
        
        $tableConfigurationJson = json_encode($tableConfiguration, JSON_FORCE_OBJECT);
        
        $paysheet = $this->Employeepayments->Paysheets->get(2);
        
        $paysheet->table_configuration = $tableConfigurationJson;
        
        if (!($this->Employeepayments->Paysheets->save($paysheet))) 
        {
            $this->Flash->error(__('No se pudo grabar el registro'));
        }
        else
        {
            $paysheet = $this->Employeepayments->Paysheets->get(2);
            
            $tableConfiguration = json_decode($paysheet->table_configuration); 
            
            debug($tableConfiguration);
        }
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
		
        $tableConfigurationJson = $this->initialConfiguration();
            
        $employeepayment->table_configuration = $tableConfigurationJson;

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
        
        if ($this->request->is('post')) 
        {
            $accountEmployee = 1;
            
            foreach ($_POST['employeepayment'] as $valor)
            {
                $employeepayment = $this->Employeepayments->get($valor['id'], ['contain' => ['Employees']]);
                
                if ($accountEmployee == 1)
                {
                    $classification = $employeepayment->employee->classification;
                    $accountEmployee++;
                }

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

                $tableConfigurationJson = $this->moveConfiguration($valor);
                
                $employeepayment->table_configuration = $tableConfigurationJson;

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

            $accountFor = 0;    
    
            foreach ($employeesFor as $employeesFors)
            {
                if ($accountFor == 0)
                {    
                    $tableConfiguration = json_decode($employeesFors->table_configuration);
                    $accountFor++;
                }
                else
                {
                    break;
                }
            }
            
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
			
			$swCestaTicket = 1;
            
            $this->set(compact('employeesFor', 'year', 'monthNumber', 'month', 'fortnightNumber', 'fortnight', 'classificationNumber', 'classification', 'currentView', 'idPaysheet', 'tableConfiguration', 'weeksSocialSecurity', 'swCestaTicket'));
            $this->set('_serialize', ['employeesFor', 'year', 'monthNumber', 'month', 'fortnightNumber', 'fortnight', 'classificationNumber', 'classification', 'currentView', 'idPaysheet', 'tableConfiguration', 'weeksSocialSecurity', 'swCestaTicket']);
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
    public function initialConfiguration()
    {
        $tableConfiguration = [];
        
        $tableConfiguration['identidy'] = '1';

        $tableConfiguration['position'] = '1';

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


    public function moveConfiguration($valor = null)
    {
        $tableConfiguration = [];
        
        $tableConfiguration['identidy'] = $valor['view_identidy'];

        $tableConfiguration['position'] = $valor['view_position'];

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
		
		$tableConfiguration['days_cesta_ticket'] = $valor['view_days_cesta_ticket'];
		
		$tableConfiguration['amount_cesta_ticket'] = $valor['view_amount_cesta_ticket'];
		
		$tableConfiguration['loan_cesta_ticket'] = $valor['view_loan_cesta_ticket'];
		
		$tableConfiguration['total_cesta_ticket'] = $valor['view_total_cesta_ticket'];
		
        $tableConfigurationJson = json_encode($tableConfiguration, JSON_FORCE_OBJECT);
 
        return $tableConfigurationJson;       
    }
}