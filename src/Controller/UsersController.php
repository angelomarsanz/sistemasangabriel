<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function initialize()
    {
    	parent::initialize();
    	$this->loadComponent('RequestHandler');
    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['add']);
    }

    public function isAuthorized($user)
    {
        if(isset($user['role']))
		{
			if ($user['role'] === 'Representante' || $user['role'] === 'Jefe de nómina' || $user['role'] === 'Control de estudios')
			{
				if(in_array($this->request->action, ['home', 'view', 'edit', 'logout']))
				{
					return true;
				}
			}
		}

        return parent::isAuthorized($user);
    }        

    public function testFunction()
    {
        phpinfo();
    }

    public function login()
    {
        if($this->request->is('post'))
        {
            $user = $this->Auth->identify();
            if($user)
            {
                $this->Auth->setUser($user); 
                if($this->Auth->user('role') == 'Representante')
                {
                    $parentsandguardians = $this->Users->Parentsandguardians->find('all')
                    ->where(['Parentsandguardians.user_id =' => $this->Auth->user('id')]);

                    $resultParentsandguardians = $parentsandguardians->toArray();    

                    if(!$resultParentsandguardians)
                    {   
                        $this->Flash->error(__('Por favor complete los datos de su perfil antes de continuar'));
                        return $this->redirect(['controller' => 'Parentsandguardians', 'action' => 'add']);    
                    }
                }
                return $this->redirect($this->Auth->redirectUrl());
            }
            else
            {
                $this->Flash->error('Datos son invalidos, por favor intente nuevamente', ['key' => 'auth']);
            }
        }
    }

    public function home()
    {
        $this->render();
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    public function viewpdf($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->viewBuilder()
            ->className('Dompdf.Pdf')
            ->layout('default')
            ->options(['config' => [
                'filename' => $id,
                'render' => 'browser',
            ]]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }



    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) 
            {
            $userName = $this->request->data['username'];

            $user = $this->Users->patchEntity($user, $this->request->data);
            
            if ($user->role == "Representante" || $user->role == "Alumno")
            {
                $user->password = "sga40"; 
            }

            if ($this->Users->save($user)) 
                {
                if ($this->request->data['role'] == 'Alumno') 
                    {
                    $this->Flash->success(__('Por favor complete los siguientes datos de su hijo o representado'));
                    return $this->redirect(['controller' => 'Students', 'action' => 'add', $userName]);
                    }
                else  
                    {   
                    $this->Flash->success(__('Los datos se guardaron correctamente, por favor escriba su usuario, la contraseña y pulsa el botón ACCEDER'));
                    return $this->redirect(['action' => 'login']);  
                    }
                }
            else 
                {
                $this->Flash->error(__('El usuario no pudo ser guardado, por favor intente nuevamente'));
                }
            }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Parentsandguardians', 'Students']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) 
            {
                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user)) 
                {
                    if ($user->role == 'Representante') 
                    {
                        
                        $parentsandguardians = $this->Users->Parentsandguardians->find('all')
                        ->where(['Parentsandguardians.user_id =' => $this->Auth->user('id')]);
    
                        $resultParentsandguardians = $parentsandguardians->toArray();
    
                            if (!$resultParentsandguardians)     
                            {
                                $this->Flash->error(__('Por favor primero complete el perfil del representante'));
                                return $this->redirect(['controller' => 'Parentsandguardians', 'action' => 'add']);
                            }                        
                            else  
                            {
                                $id = $resultParentsandguardians[0]['id'];
                                $this->Flash->success(__('Por favor complete los siguientes datos'));
                                return $this->redirect(['controller' => 'Parentsandguardians', 'action' => 'edit', $id]);
                            }
                    }
                    elseif ($user->role == 'Alumno')
                    {
                        $students = $this->Users->Students->find('all')
                        ->where(['Students.user_id =' => $id]);

                        $resultStudents = $students->toArray();
  
                        if (!$resultStudents)     
                        {
                            $this->Flash->error(__('Por favor primero complete los datos del alumno'));
                                
                            return $this->redirect(['controller' => 'Students', 'action' => 'add']);
                        }                        
                        else  
                        {
                            $id = $resultStudents[0]['id'];
                            $this->Flash->success(__('Por favor complete los siguientes datos'));
                            return $this->redirect(['controller' => 'Students', 'action' => 'edit', $id]);
                        }
                    }
                    else  
                    {   
                        $this->Flash->success(__('Los datos del usuario se guardaron correctamente'));
                        return $this->redirect(['action' => 'home']);  
                    }
                }
                else 
                {
                    $this->Flash->error(__('El usuario no pudo ser guardado, por favor verifique los datos'));
                }
            }
            
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('El usuario fue borrado'));
        } else {
            $this->Flash->error(__('El usuario no pudo ser eliminado, por favor intente nuevamente'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function search()
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $name = $this->request->query['term'];
            $results = $this->Users->find('all', [
                'conditions' => [ 'OR' => [
                    'first_name LIKE' => $name . '%',
                    'second_name LIKE' => $name . '%',
                ]]
            ]);
            $resultsArr = [];
            foreach ($results as $result) {
                 $resultsArr[] =['label' => $result['full_name'], 'value' => $result['full_name']];
            }
            echo json_encode($resultsArr);
        }
    }
    
    public function wait()
    {
        
    }
    public function inactiveSystem()
    {
        
    }
	public function redetronic()
	{
		
	}
	public function updateUsername()
	{
        $this->autoRender = false;
         
        if ($this->request->is('json'))
        {
            $jsondata = [];

            if (isset($_POST['username']))
            {               
                $username = trim($_POST['username']);
		                
                $lastRecord = $this->Users->find('all', ['conditions' => [['Users.username' => $username]], 
                    'order' => ['Users.created' => 'DESC']]);
            
                $row = $lastRecord->first();
                
                if (!($row))
                {        
					$user = $this->Users->get($_POST['idUser']);
					
					$user->username = $username;
					
		            if ($this->Users->save($user)) 
					{
						$jsondata["success"] = true;
						$jsondata["message"] = "El usuario se modificó exitosamente";
					}
					else
					{
						$jsondata["success"] = false;
						$jsondata["message"] = "No se pudo actualizar el usuario";
					}
				}
				else
				{
					$jsondata["success"] = false;
					$jsondata["message"] = "Ya existe otro representante con el mismo usuario, por favor intente nuevamente";
				}
                exit(json_encode($jsondata, JSON_FORCE_OBJECT));
			}
        }
	}
}