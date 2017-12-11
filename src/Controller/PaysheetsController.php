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
    public function edit($id = null, $classificationC = null)
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
                    ['OR' => [['deleted_record IS NULL'], ['deleted_record' => 0]]], 'order' => ['Paysheets.created' => 'DESC']]);
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
            $this->Flash->error(__('No se encontró la nómina'));
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
        $employees = new EmployeesController();
        
        $employeepayments = new EmployeepaymentsController();
        
        $paysheet = $this->Paysheets->newEntity();
        if ($this->request->is('post')) 
        {
            $paysheet = $this->Paysheets->patchEntity($paysheet, $this->request->data);
            
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
                    $paysheet->date_from = $paysheet->year_paysheet . '-' . $paysheet->month_paysheet . '-10';
                    $paysheet->date_until = $paysheet->year_paysheet . '-' . $paysheet->month_paysheet . '-24';
                }
                else
                {
                    $nextMonth = $paysheet->month_paysheet + 1;
                    $paysheet->date_from = $paysheet->year_paysheet . '-' . $paysheet->month_paysheet . '-25';
                    $paysheet->date_until = $paysheet->year_paysheet . '-' . $nextMonth . '-09';
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
                
                if (!($this->Paysheets->save($paysheet)))
                {
                    $this->Flash->error(__('Los datos de la quincena no pudieron ser grabados, intente nuevamente'));                
                }
                else 
                {
                    $lastRecord = $this->Paysheets->find('all', ['conditions' => ['responsible_user' => $this->Auth->user('username')],
                    'order' => ['Paysheets.created' => 'DESC'] ]);
    
                    $row = $lastRecord->first();                
                    
                    $employeesPaysheets = $employees->searchEmployees();
                    
                    if ($employeesPaysheets)
                    {
                        $result = $employeepayments->add($row->id, $row->weeks_social_security, $employeesPaysheets);
                        
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
                        $this->Flash->error(__('No se consiguieron registros de empleados'));
                    }
                }
            }
        }
        $this->set(compact('paysheet'));
        $this->set('_serialize', ['paysheet']);
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
}