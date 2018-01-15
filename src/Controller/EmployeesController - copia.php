<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\EmployeepaymentsController;

use Cake\ORM\TableRegistry;

/**
 * Employees Controller
 *
 * @property \App\Model\Table\EmployeesTable $Employees
 */
class EmployeesController extends AppController
{
    public function testFunction()
    {
        $employees = TableRegistry::get('Employees');
        
        $employeesList = $employees->find()
            ->select(
            ['Employees.id',
            'Employees.reason_withdrawal']);

        if ($employeesList)
        {
            $account = 0;
            
            foreach ($employeesList as $employeesLists)
            {
                $employee = $this->Employees->get($employeesLists->id);
                
                $employee->reason_withdrawal = 'Activo';
                
                if (!($this->Employees->save($employee)))
                {
                    $this->Flash->error(__('No se pudo actualizar el empleado con id: ' . $employee->id));    
                }
                else
                {
                    $account++;
                }
            }
            $this->Flash->success(__('Total registros actualizados: ' . $account));
        }
    }

    public function changeValues()
    {
        $employees = TableRegistry::get('Employees');
        
        $employeesList = $employees->find()
            ->select(
            ['Employees.id',
            'Employees.position_id'])
            ->where(['Employees.position_id' => 1]);
        
        if ($employeesList)
        {
            $account = 0;
            
            foreach ($employeesList as $employeesLists)
            {
                $employee = $this->Employees->get($employeesLists->id);
                
                $employee->position_id = 24;
                
                if (!($this->Employees->save($employee)))
                {
                    $this->Flash->error(__('No se pudo actualizar el empleado con id: ' . $employee->id));    
                }
                else
                {
                    $account++;
                }
            }
            $this->Flash->success(__('Total registros actualizados: ' . $account));
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {

        $employeesTable = TableRegistry::get('Employees');

        $query = $employeesTable->find('all', ['contain' => ['Positions']])->order(['Employees.classification' => 'ASC', 'Positions.position' => 'ASC']);
        $this->set('employees', $this->paginate($query));

        $this->set(compact('employees'));
        $this->set('_serialize', ['employees']);
    }

    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null, $controller = null, $action = null, $idPaysheet = null, $classification = null, $idEmployeepayments = null, $weeksSocialSecurity = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => ['Positions', 'Sections', 'Teachingareas', 'Employeepayments']
        ]);
		
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);

        $this->set('employee', $employee);
		$this->set('school', $school);
        $this->set(compact('controller', 'action', 'idPaysheet', 'classification', 'idEmployeepayments', 'weeksSocialSecurity'));
        $this->set('_serialize', ['employee', 'school']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($idPaysheet = null, $weeksSocialSecurity = null, $classification = null)
    {
        $employee = $this->Employees->newEntity();
        if ($this->request->is('post')) 
        {
            $employee = $this->Employees->patchEntity($employee, $this->request->data);
            
            $employee->user_id = 945;
            
            $employee->responsible_user = $this->Auth->user('username'); 
            
            if ($this->Employees->save($employee)) 
            {
                if (isset($idPaysheet))
                {
                    $employees = TableRegistry::get('Employees');
        
                    $arrayResult = $employees->find('only', ['responsible_user' => $this->Auth->user('username')]);
        
                    if ($arrayResult['indicator'] == 0)
                    {
                        $row = $arrayResult['searchRequired'];
                        
                        $employeepayments = new EmployeepaymentsController();
                        
                        $result = $employeepayments->addRecord($idPaysheet, $weeksSocialSecurity, $row);
                        
                        if ($result == 1)
                        {
                            $this->Flash->error(__('No se pudo crear el registro de nómina'));
                        }
                    }
                    else
                    {
                        $this->Flash->error(__('No se pudo crear el registro de nómina'));
                    }
                    return $this->redirect(['controller' => 'Paysheets', 'action' => 'edit', $idPaysheet, $classification]);
                }
                else
                {
                    $this->Flash->success(__('El empleado ha sido grabado exitosamente'));
                    return $this->redirect(['action' => 'index']);
                }
            } 
            else 
            {
                $this->Flash->error(__('El empleado no pudo ser grabado, por favor intente de nuevo'));
            }
        }
        
        $positions = $this->Employees->Positions->find('list', ['limit' => 200])->where(['OR' => ['Positions.record_deleted IS NULL', 'Positions.record_deleted' => false]])->order(['Positions.position' => 'ASC']);
        $sections = $this->Employees->Sections->find('list', ['limit' => 200]);
        $teachingareas = $this->Employees->Teachingareas->find('list', ['limit' => 200])->order(['Teachingareas.description_teaching_area' => 'ASC']);

        $this->set(compact('employee', 'positions', 'sections', 'teachingareas', 'idPaysheet', 'classification'));
        $this->set('_serialize', ['employee', 'idPaysheet', 'classification']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $controller = null, $action = null, $idPaysheet = null, $weeksSocialSecurity = null, $classification = null, $idEmployeepayments = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => []
        ]);
        
        $positions = $this->Employees->Positions->find('list', ['limit' => 200])->where(['OR' => ['Positions.record_deleted IS NULL', 'Positions.record_deleted' => false]])->order(['Positions.position' => 'ASC']);
        $sections = $this->Employees->Sections->find('list', ['limit' => 200]);
        $teachingareas = $this->Employees->Teachingareas->find('list', ['limit' => 200])->order(['Teachingareas.description_teaching_area' => 'ASC']);

        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $employee = $this->Employees->patchEntity($employee, $this->request->data);
            
            $employee->hours_month = $employee->weekly_hours * 4; 
            
            if ($this->Employees->save($employee)) 
            {
                if (isset($idPaysheet))
                {
                    $employees = TableRegistry::get('Employees');
        
                    $arrayResult = $employees->find('onlyId', ['id' => $id]);
        
                    if ($arrayResult['indicator'] == 0)
                    {
                        $row = $arrayResult['searchRequired'];
                        
                        $employeepayments = new EmployeepaymentsController();
                        
                        $result = $employeepayments->edit($idEmployeepayments, $weeksSocialSecurity, $row);
                        
                        if ($result == 0)
                        {
							$this->Flash->success(__('Los datos del empleado se guardaron exitosamente'));
						}
						else
						{
                            $this->Flash->error(__('No se pudo modificar el registro de nómina'));
                        }
                    }
                    else
                    {
                        $this->Flash->error(__('No se pudo modificar el registro de nómina'));
                    }
					if (isset($controller)): 
						if ($controller == 'Paysheets' && $action == 'edit'):   
							return $this->redirect(['controller' => $controller, 'action' => $action, $idPaysheet, $classification]);
						elseif ($controller == 'Employees' && $action == 'view'): 
							return $this->redirect(['controller' => $controller, 'action' => $action, $employee->id, 'Paysheets', 'edit', $idPaysheet, $classification]);
						endif;
					endif;					
                }
                else
                {
                    $this->Flash->success(__('Los datos del empleado se guardaron exitosamente'));
					if (isset($controller)): 
						if ($controller == 'Employees' && $action == 'view'): 
							return $this->redirect(['controller' => $controller, 'action' => $action, $employee->id]);
						else:
							return $this->redirect(['controller' => 'Employees', 'action' => 'index']);
						endif;
					endif;					
                }
            } 
            else 
            {
                $this->Flash->error(__('Los datos del empleado no pudieron ser guardados'));
            }
        }
        
        $this->set(compact('employee', 'positions', 'sections', 'teachingareas', 'controller', 'action', 'idPaysheet', 'classification'));
        $this->set('_serialize', ['employee', 'controller', 'action', 'idPaysheet', 'classification']);
    }

    public function editImposed($idEmployee = null, $percentageImposed = null)
    {
        $this->autoRender = false;
        
        $employee = $this->Employees->get($idEmployee, [
            'contain' => []
        ]);
        
        $employee->percentage_imposed = $percentageImposed;
        
        if ($this->Employees->save($employee)) 
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
     * @param string|null $id Employee id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function changeState($id = null, $idPaysheet = null, $classification = null, $idEmployeepayments = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => []
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $employee = $this->Employees->patchEntity($employee, $this->request->data);
            
            $employee->responsible_user = $this->Auth->user('username');
            
            if ($this->Employees->save($employee)) 
            {
                if (isset($idPaysheet))
                {
                    $employees = TableRegistry::get('Employees');
        
                    $arrayResult = $employees->find('onlyId', ['id' => $id]);
        
                    if ($arrayResult['indicator'] == 0)
                    {
                        $row = $arrayResult['searchRequired'];
                        
                        if ($row->reason_withdrawal != 'Activo')
                        {
                            $employeepayments = new EmployeepaymentsController();
                            
                            $result = $employeepayments->delete($idEmployeepayments);
                            
                            if ($result == 1)
                            {
                                $this->Flash->error(__('No se pudo eliminar el registro de nómina'));
                            }
                        }
                    }
                    else
                    {
                        $this->Flash->error(__('No se pudo eliminar el registro de nómina'));
                    }
                    return $this->redirect(['controller' => 'Paysheets', 'action' => 'edit', $idPaysheet, $classification]);
                }
                else
                {
                    $this->Flash->success(__('Los datos del empleado se eliminaron exitosamente'));
                    return $this->redirect(['action' => 'index']);
                }
            } 
            else 
            {
                $this->Flash->error(__('Los datos del empleado no pudieron ser eliminado'));
            }
        }
        
        $this->set(compact('employee', 'idPaysheet', 'classification'));
        $this->set('_serialize', ['employee', 'idPaysheet', 'classification']);
    }


    public function searchEmployees()
    {
        $this->autoRender = false;

        $employees = TableRegistry::get('Employees');
        
        $employeesPaysheets = $employees->find()
            ->select(
            ['Employees.id',
            'Employees.date_of_admission', 
            'Employees.hours_month',
            'Employees.percentage_imposed',
            'Positions.position',
            'Positions.short_name',
            'Positions.type_of_salary', 
            'Positions.minimum_wage'])
            ->contain(['Positions'])
            ->where(['Employees.reason_withdrawal' => 'Activo']);
        
        return $employeesPaysheets;
    }
}