<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Parentsandguardians Controller
 *
 * @property \App\Model\Table\ParentsandguardiansTable $Parentsandguardians
 */
class ParentsandguardiansController extends AppController
{
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
				if(in_array($this->request->action, ['view', 'add', 'edit', 'profilePhoto', 'editPhoto']))
				{
					return true;
				}
			}
			if ($user['role'] === 'Control de estudios')
			{
				if(in_array($this->request->action, ['consultFamily', 'viewData', 'view', 'edit', 'findFamily', 'findMother', 'findGuardian']))
				{
					return true;
				}				
			}
		}

        return parent::isAuthorized($user);
    }        

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $parentsandguardians = $this->paginate($this->Parentsandguardians);

        $this->set(compact('parentsandguardians'));
        $this->set('_serialize', ['parentsandguardians']);
    }

    /**
     * View method
     *
     * @param string|null $id Parentsandguardian id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null, $controller = null, $action = null)
    {
        $parentsandguardian = $this->Parentsandguardians->get($id, [
            'contain' => ['Users', 'Students']
        ]);

        $this->set(compact('parentsandguardian', 'controller', 'action'));
        $this->set('_serialize', ['parentsandguardian', 'controller', 'action']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $parentsandguardian = $this->Parentsandguardians->newEntity();
        if ($this->request->is('post')) {
            $parentsandguardian = $this->Parentsandguardians->patchEntity($parentsandguardian, $this->request->data);

            if ($this->Auth->user('role') == "Representante")
            {
                $parentsandguardian->user_id = $this->Auth->user('id');
                $parentsandguardian->code_for_user = '';
                $parentsandguardian->first_name = $this->Auth->user('first_name');
                $parentsandguardian->second_name = $this->Auth->user('second_name');
                $parentsandguardian->surname = $this->Auth->user('surname');
                $parentsandguardian->second_surname = $this->Auth->user('second_surname');
                $parentsandguardian->sex = $this->Auth->user('sex');
                $parentsandguardian->guardian = 0;
                $parentsandguardian->family_tie = '';
                $parentsandguardian->cell_phone = $this->Auth->user('cell_phone');
                $parentsandguardian->email = $this->Auth->user('email');
                $parentsandguardian->balance = 0;
                $parentsandguardian->guardian_migration = 0;
                $parentsandguardian->mi_id = 0;
                $parentsandguardian->mi_children = 0;
                $parentsandguardian->new_guardian = true;
                $parentsandguardian->creative_user = $this->Auth->user('username');
            }
            else
            {
                $parentsandguardian->user_id = 2;
                $parentsandguardian->code_for_user = '';
                $parentsandguardian->guardian = 0;
                $parentsandguardian->family_tie = " ";
                $parentsandguardian->balance = 0;
                $parentsandguardian->guardian_migration = 0;
                $parentsandguardian->mi_id = 0;
                $parentsandguardian->mi_children = 0;
                $parentsandguardian->new_guardian = true;
                $parentsandguardian->creative_user = $this->Auth->user('username');
            }
            if ($this->Parentsandguardians->save($parentsandguardian)) 
            {
                if ($this->Auth->user('role') == "Representante")
                {
                    $this->Flash->success(__('Sus datos fueron guardados, ahora necesitamos crear un usuario para su hijo o representado. Por favor ingrese los datos que se indican a continuación:'));
                    
                    return $this->redirect(['controller' => 'Users', 'action' => 'add']);
                }
                else
                {
                    $this->Flash->success(__('El padre o Representante fue guardado'));

                    $lastRecord = $this->Parentsandguardians->find('all', ['conditions' => ['creative_user' => $this->Auth->user('username')],
                        'order' => ['Parentsandguardians.created' => 'DESC'] ]);
        
                    $row = $lastRecord->first();

                    return $this->redirect(['controller' => 'Students', 'action' => 'addAdmin', $row->id]);
                }
            } 
            else 
            {
                $this->Flash->error(__('El padre o representante no fue guardado, por favor verifique los datos e intente nuevamente'));
            }
        }
        
        $this->set(compact('parentsandguardian'));
        $this->set('_serialize', ['parentsandguardian']);
    }
    public function addb()
    {       
        $parentsandguardian = $this->Parentsandguardians->newEntity();

        if ($this->request->is('post')) 
        {
            $this->loadModel('Users');

            $parentsandguardian = $this->Parentsandguardians->patchEntity($parentsandguardian, $this->request->data);

            $lastRecord = $this->Users->find('all', ['conditions' => ['username' => $parentsandguardian->identidy_card], 'order' => ['Users.created' => 'DESC'] ]);
                    
            $row = $lastRecord->first();

            if ($row)
            {
                $this->Flash->error(__('El usuario ' . $parentsandguardian->identidy_card . ' ya está registrado en la base de datos con el nombre de: ' . $row->surname . ' ' . $row->first_name));
            }
            else
            {
                $parentsandguardian->user_id = 3;
                $parentsandguardian->second_surname = "";
                $parentsandguardian->second_name = "";
                $parentsandguardian->sex = "";
                $parentsandguardian->email = $parentsandguardian->identidy_card . "@correo"; 
                $parentsandguardian->cell_phone = "";
                $parentsandguardian->landline = "";
                $parentsandguardian->address = "";
                $parentsandguardian->profession = "";
                $parentsandguardian->item = "";
                $parentsandguardian->item_not_specified = "";
                $parentsandguardian->workplace = "";
                $parentsandguardian->professional_position = "";
                $parentsandguardian->work_phone = "";
                $parentsandguardian->work_address = "";
                $parentsandguardian->family = "";
                $parentsandguardian->surname_father = "";
                $parentsandguardian->second_surname_father = "";
                $parentsandguardian->first_name_father = "";
                $parentsandguardian->second_name_father = "";
                $parentsandguardian->type_of_identification_father = "";
                $parentsandguardian->identidy_card_father = "";
                $parentsandguardian->email_father = "";
                $parentsandguardian->cell_phone_father = "";
                $parentsandguardian->landline_father = "";
                $parentsandguardian->work_phone_father = "";
                $parentsandguardian->profession_father = "";
                $parentsandguardian->address_father = "";
                $parentsandguardian->surname_mother = "";
                $parentsandguardian->second_surname_mother = "";
                $parentsandguardian->first_name_mother = "";
                $parentsandguardian->second_name_mother = "";
                $parentsandguardian->type_of_identification_mother = ""; 
                $parentsandguardian->identidy_card_mother = "";
                $parentsandguardian->email_mother = "";
                $parentsandguardian->cell_phone_mother = "";
                $parentsandguardian->landline_mother = "";
                $parentsandguardian->work_phone_mother = "";
                $parentsandguardian->profession_mother = "";
                $parentsandguardian->address_mother = "";
                $parentsandguardian->client = "";
                $parentsandguardian->type_of_identification_client = "";
                $parentsandguardian->identification_number_client = "";
                $parentsandguardian->fiscal_address = "";
                $parentsandguardian->tax_phone = "";
                $parentsandguardian->code_for_user = "";
                $parentsandguardian->guardian = 0;
                $parentsandguardian->family_tie = "";
                $parentsandguardian->balance = 0;
                $parentsandguardian->guardian_migration = 0;
                $parentsandguardian->mi_id = 0;
                $parentsandguardian->mi_children = 0;
                $parentsandguardian->new_guardian = true;
                $parentsandguardian->creative_user = $this->Auth->user('username');
                $parentsandguardian->profile_photo = "";
                $parentsandguardian->profile_photo_dir = "";

                if ($this->Parentsandguardians->save($parentsandguardian)) 
                {
                    $user = $this->Users->newEntity();
                    
                    $user->username = $parentsandguardian->identidy_card;
                        
                    $user->password = "sga40";
        
                    $user->role = "Representante";
        
                    $user->first_name = $parentsandguardian->first_name;
        
                    $user->second_name = " ";
                        
                    $user->surname = $parentsandguardian->surname;
                        
                    $user->second_surname = " ";
                        
                    $user->sex = " ";
                        
                    $user->email = $parentsandguardian->email;
                        
                    $user->cell_phone = " ";
                    
                    $user->profile_photo = " ";
                        
                    $user->profile_photo_dir = " ";

                    if (!($this->Users->save($user))) 
                    {
                        $this->Flash->error(__('El usuario no fue guardado ' . $user->username));
                    }
                    else
                    {
                        $lastRecord = $this->Users->find('all', ['conditions' => ['username' => $user->username], 'order' => ['Users.created' => 'DESC'] ]);
                    
                        $row = $lastRecord->first();
                            
                        $lastRecordParent = $this->Parentsandguardians->find('all', ['conditions' => ['identidy_card' => $parentsandguardian->identidy_card], 'order' => ['Parentsandguardians.created' => 'DESC'] ]);
                    
                        $rowParent = $lastRecordParent->first();
                        
                        $parentsandguardian = $this->Parentsandguardians->get($rowParent['id']);

                        $parentsandguardian->user_id = $row['id'];
                        
                        if (!($this->Parentsandguardians->save($parentsandguardian)))
                        {
                            $this->Flash->error(__('El padre o representante no pudo ser actualizado ' . $user->username));
                        }
                        $this->Flash->success(__('Por favor registre los datos del nuevo alumno'));

                        return $this->redirect(['controller' => 'Students', 'action' => 'addAdminb', $rowParent['id']]);
                    }
                }
                else
                {
                    $this->Flash->error(__('El padre o representante no pudo ser guardado ' . $parentsandguardian->first_name . ' ' . $parentsandguardian->surname));
                }
            }
        }
     
        $this->set(compact('parentsandguardian'));
        $this->set('_serialize', ['parentsandguardian']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Parentsandguardian id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $controller = null, $action = null)
    {
        $parentsandguardian = $this->Parentsandguardians->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $parentsandguardian = $this->Parentsandguardians->patchEntity($parentsandguardian, $this->request->data);
    
            if ($this->Parentsandguardians->save($parentsandguardian)) 
            {
                $user = $this->Parentsandguardians->Users->get($parentsandguardian->user_id);
                
                $user->first_name = $parentsandguardian->first_name;
                $user->second_name = $parentsandguardian->second_name;
                $user->surname = $parentsandguardian->surname;
                $user->second_surname = $parentsandguardian->second_surname;
                $user->sex = $parentsandguardian->sex;
                $user->email = $parentsandguardian->email;
                $user->cell_phone = $parentsandguardian->cell_phone;
    
                if ($this->Parentsandguardians->Users->save($user))
                {
                    $this->Flash->success(__('Los datos se guardaron exitosamente'));
                    
                    return $this->redirect(['controller' => $controller, 'action' => $action, $id]);
                }
                else
                {
                    $this->Flash->success(__('Los datos se guardaron exitosamente, correo electrónico duplicado, por favor revise'));
                }
            }
            else 
            {
                $this->Flash->error(__('El padre o representante no fue guardado, por favor verifique los datos e intente nuevamente'));
            }
        }
        $this->set(compact('parentsandguardian', 'controller', 'action'));
        $this->set('_serialize', ['parentsandguardian', 'controller', 'action']);
    }

    public function editPhoto($id = null)
    {
        $parentsandguardian = $this->Parentsandguardians->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $parentsandguardian = $this->Parentsandguardians->patchEntity($parentsandguardian, $this->request->data);
    
            if ($this->Parentsandguardians->save($parentsandguardian)) 
            {
                $user = $this->Parentsandguardians->Users->get($parentsandguardian->user_id);
        
                $user->profile_photo = $parentsandguardian->profile_photo;
                $user->profile_photo_dir = $parentsandguardian->profile_photo_dir;

                if ($this->Parentsandguardians->Users->save($user))
                {
                    $this->Flash->success(__('La foto se agregó exitosamente'));
                    
                    return $this->redirect(['controller' => 'Guardiantransactions', 'action' => 'previoContratoRepresentante', $id]);
                }
            }
            else 
            {
                $this->Flash->error(__('El padre o representante no fue guardado, por favor verifique los datos e intente nuevamente'));
            }
        }
        $this->set(compact('parentsandguardian'));
        $this->set('_serialize', ['parentsandguardian']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Parentsandguardian id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $parentsandguardian = $this->Parentsandguardians->get($id);
        if ($this->Parentsandguardians->delete($parentsandguardian)) {
            $this->Flash->success(__('El padre o representante fue borrado'));
        } else {
            $this->Flash->error(__('El padre o representante, no fue borrado, por favor intente nuevamente'));
        }

        return $this->redirect(['action' => 'index']);
    }
 
    public function search()
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $name = $this->request->query['term'];
            $results = $this->Parentsandguardians->find('all', [
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
    
    public function findFamily()
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $name = trim($this->request->query['term']);
            $results = $this->Parentsandguardians->find('all', [
                'conditions' => [['family LIKE' => $name . '%'], ['guardian !=' => 1]]]);
            $resultsArr = [];
            foreach ($results as $result) {
				$resultsArr[] =['label' => $result['family'] . ' (' . $result['surname'] . ' ' . $result['first_name'] . ')', 'value' => $result['family'] . ' (' . $result['surname'] . ' ' . $result['first_name'] . ')', 'id' => $result['id']];
				}
			exit(json_encode($resultsArr, JSON_FORCE_OBJECT));
        }
    }

    public function findMother()
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $name = trim($this->request->query['term']);
            $results = $this->Parentsandguardians->find('all', [
                'conditions' => [['surname_mother LIKE' => $name . '%'], ['guardian !=' => 1]]]);
            $resultsArr = [];
            foreach ($results as $result) {
                 $resultsArr[] =['label' => $result['surname_mother'] . ' ' . $result['first_name_mother'] . ' (Familia ' . $result['family'] . ')', 'value' => $result['surname_mother'] . ' ' . $result['first_name_mother'] . ' (Familia ' . $result['family'] . ')', 'id' => $result['id']];
            }
            echo json_encode($resultsArr);
        }
    }

    public function findGuardian()
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $name = trim($this->request->query['term']);
            $results = $this->Parentsandguardians->find('all', [
                'conditions' => [['surname LIKE' => $name . '%'], ['guardian !=' => 1]]]);
            $resultsArr = [];
            foreach ($results as $result) {
                 $resultsArr[] =['label' => $result['surname'] . ' ' . $result['first_name'] . ' (Familia ' . $result['family'] . ')', 'value' => $result['surname'] . ' ' . $result['first_name'] . ' (Familia ' . $result['family'] . ')', 'id' => $result['id']];
            }
            echo json_encode($resultsArr);
        }
    }

    public function findInvoice()
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $name = trim($this->request->query['term']);
            $results = $this->Parentsandguardians->find('all', [
                'conditions' => [['client LIKE' => $name . '%'], ['guardian !=' => 1]]]);
            $resultsArr = [];
            foreach ($results as $result) {
                 $resultsArr[] =['label' => $result['client'] . ' (Familia ' . $result['family'] . ')', 'value' => $result['client'] . ' (Familia ' . $result['family'] . ')', 'id' => $result['id']];
            }
            echo json_encode($resultsArr);
        }
    }


    public function updateClientData()
    {
        $this->autoRender = false;

        if ($this->request->is('json')) 
        {

            if (!(isset($_POST['id'])))
            {
                die("Solicitud no válida");    
            }

            $parentsandguardian = $this->Parentsandguardians->get($_POST['id'], 
                ['contain' => []]);

            $parentsandguardian->client = $_POST['client'];
            $parentsandguardian->type_of_identification_client = $_POST['typeOfIdentificationClient'];
            $parentsandguardian->identification_number_client = $_POST['identificationNumberClient'];
            $parentsandguardian->fiscal_address = $_POST['fiscalAddress'];
            $parentsandguardian->tax_phone = $_POST['taxPhone'];
            $jsondata = [];

            if ($this->Parentsandguardians->save($parentsandguardian))
            {
                $jsondata["success"] = true;
                $jsondata["message"] = "Se actualizaron los datos fiscales";
            }   
            else
            {
                $jsondata["success"] = false;
                $jsondata["message"] = "Se actualizaron los datos fiscales";
            }

            exit(json_encode($jsondata, JSON_FORCE_OBJECT));
        }
    }
    public function officeManager()
    {
        if ($this->request->is('post')) 
        {
            return $this->redirect(['action' => 'ListOffices', $_POST['item']]);
        }        
    }
    public function ListOffices($office = null)
    {
        $officesParents = $this->Parentsandguardians->find('all')->where(['item' => $office]);

        $officeP = $this->paginate($officesParents);

        $this->set(compact('office', 'officeP'));
    }
    public function profilePhoto($id = null)
    {
        $this->set(compact('id'));
    }
    public function consultFamily()
    {
        
    }
    public function viewData($idFamily = null, $family = null)
    {
		$this->loadModel('Schools');

		$schools = $this->Schools->get(2);
		
        if ($this->request->is('post')) 
        {
            $idFamily = $_POST['idFamily'];
            $family = $_POST['family'];
        }
		
        $lastRecord = $this->Parentsandguardians->find('all', ['conditions' => [['id' => $idFamily]], 
            'order' => ['Parentsandguardians.created' => 'DESC']]);
            
        $row = $lastRecord->first();
                
        if ($row)
        {        				
			$user = $this->Parentsandguardians->Users->get($row->user_id);			
		}

        $this->set(compact('idFamily', 'family', 'schools', 'user'));
		$this->set('_serialize', ['schools', 'user']);
    }
    public function consultCardboard()
    {
        
    }
	public function repairColumn()
	{
		$accountRecords = 0;
		
		$query = $this->Parentsandguardians->find('all')->where(['id >' => 1]);
		
		foreach ($query as $querys)
		{
			$parentsandguardian = $this->Parentsandguardians->get($querys->id);
			
			$parentsandguardian->surname = trim($parentsandguardian->surname);
			$parentsandguardian->second_surname = trim($parentsandguardian->second_surname);
            $parentsandguardian->first_name = trim($parentsandguardian->first_name);
			$parentsandguardian->second_name = trim($parentsandguardian->second_name);
			$parentsandguardian->email = trim($parentsandguardian->email);
			$parentsandguardian->address = trim($parentsandguardian->address);
			$parentsandguardian->profession = trim($parentsandguardian->profession);
			$parentsandguardian->workplace = trim($parentsandguardian->workplace);
			$parentsandguardian->professional_position = trim($parentsandguardian->professional_position);
			$parentsandguardian->work_phone = trim($parentsandguardian->work_phone);	
			$parentsandguardian->work_address = trim($parentsandguardian->work_address);
		
			$parentsandguardian->family = trim($parentsandguardian->family);
						
			$parentsandguardian->surname_father = trim($parentsandguardian->surname_father);
			$parentsandguardian->second_surname_father = trim($parentsandguardian->second_surname_father);
			$parentsandguardian->first_name_father = trim($parentsandguardian->first_name_father);
			$parentsandguardian->second_surname_father = trim($parentsandguardian->second_surname_father);
			$parentsandguardian->email_father = trim($parentsandguardian->email_father);
			$parentsandguardian->address_father = trim($parentsandguardian->address_father);
			$parentsandguardian->profession_father = trim($parentsandguardian->profession_father);
			
			$parentsandguardian->surname_mother = trim($parentsandguardian->surname_mother);
			$parentsandguardian->second_surname_mother = trim($parentsandguardian->second_surname_mother);
			$parentsandguardian->first_name_mother = trim($parentsandguardian->first_name_mother);
			$parentsandguardian->second_name_mother = trim($parentsandguardian->second_name_mother);
			$parentsandguardian->email_mother = trim($parentsandguardian->email_mother);
			$parentsandguardian->address_mother = trim($parentsandguardian->address_mother);			
			$parentsandguardian->profession_mother = trim($parentsandguardian->profession_mother);
			
			$parentsandguardian->client = trim($parentsandguardian->client);
			$parentsandguardian->fiscal_address = trim($parentsandguardian->fiscal_address);
						
            if (!($this->Parentsandguardians->save($parentsandguardian))) 
            {
                $this->Flash->error(__('No pudo ser actualizado el registro Nro. ' . $parentsandguardian->id. ' first_name: ' . $parentsandguardian->first_name));
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
        
		$jsondata = [];

        if ($this->request->is('json')) 
        {
            if (isset($_POST['surname']) && isset($_POST['firstName']))
            {
				$surname = $_POST['surname'];
				$firstName = $_POST['firstName']; 
								
				$sameParents = $this->Parentsandguardians->find('all')->where([['surname' => $surname], ['first_name' => $firstName]])
					->order(['surname' => 'ASC', 'second_surname' => 'ASC', 'first_name' => 'ASC', 'second_name' => 'ASC']);

				$count = $sameParents->count();
				
				if ($count > 0)
				{
					$jsondata['success'] = true;
					$jsondata['data']['message'] = 'Se encontraron representantes con nombres similares';
					$jsondata['data']['parents'] = [];
					
					foreach ($sameParents as $sameParent)
					{
						$jsondata['data']['parents'][]['parent'] = $sameParent->full_name;
						$jsondata['data']['parents'][]['family'] = $sameParent->family;
						$jsondata['data']['parents'][]['id'] = $sameParent->id;
					}
				}
				else
				{
					$jsondata["success"] = false;
					$jsondata["data"]["message"] = 'No se encontraron familias';
				}
				exit(json_encode($jsondata, JSON_FORCE_OBJECT));
            }
            else 
            {
                die("Solicitud no válida.");
            }           
        } 
    }
	public function busquedaReciboReintegro()
	{
		
	}
	
    public function previoReciboReintegro($idRepresentante = null)
    {	
        if ($this->request->is('post')) 
        {
            $idRepresentante = $_POST['idRepresentante'];
        }
		
		$representante = $this->Parentsandguardians->get($idRepresentante);
		
		if ($representante->balance > 0)
		{
			return $this->redirect(['controller' => 'Bills', 'action' => 'establecerMontoReintegro', $idRepresentante, $representante->balance]);
		}
		else
		{
			$this->Flash->error(__('Estimado usuario este representante no tiene saldo para reintegrar'));
		}
	}

    // Esta función debe ejecutarse inmediatamente después que cambia el valor de la columna "current_year_registration" de la tabla "Schools" en el mes de junio de cada año cuando comienza el proceso de re-inscripción

    public function eliminarRepresentantesEstudiantesInactivos()
    {
        $this->loadModel('Schools');
		$schools = $this->Schools->get(2);
        $actual_anio_inscripcion = $schools->current_year_registration;
        $anterior_anio_inscripcion = $actual_anio_inscripcion - 1;

        $representantes_inactivos = [];
        $representantes = $this->Parentsandguardians->find('all')->where(['Parentsandguardians.id >' => 1 , "Parentsandguardians.estatus_registro" => "Activo"]);
        $estudiantes = $this->Parentsandguardians->Students->find('all')->where(['Students.id >' => 1 , "Students.student_condition" => "Regular"])->order(['Students.parentsandguardian_id' => 'ASC']);

        foreach ($representantes as $representante)
        {
            $indicador_estudiantes_activos = 0;
            $texto_indicador_estudiantes = "Sin estudiantes asociados";
            foreach ($estudiantes as $estudiante)
            {
                if ($estudiante->parentsandguardian_id == $representante->id)
                {
                    if ($estudiante->balance == null || $estudiante->balance == 0)
                    {
                        if ($estudiante->created->year >= $actual_anio_inscripcion)
                        {
                            $indicador_estudiantes_activos = 1;
                            break;
                        } 
                    }
                    elseif ($estudiante->balance >= $anterior_anio_inscripcion)
                    {
                        $indicador_estudiantes_activos = 1;
                        break;
                    }
                    $texto_indicador_estudiantes = "Con estudiantes inactivos";
                    // Marcar como "Eliminado" la columna "student_condition" de la tabla "students"
                }              
            }
            if ($indicador_estudiantes_activos == 0)
            {
                $representantes_sin_estudiantes[] = ['familia' => $representante->family, 'nombre_representante' => $representante->full_name, 'id_representante' => $representante->id, 'motivo' => $texto_indicador_estudiantes];
            }
        }
        foreach ($representantes_sin_estudiantes as $representante)
        {
            // Marcar como "Eliminado" la columna "estatus_registro" en las tablas "users" y "parentsandguardians"
        }
        $this->set(compact('representantes_sin_estudiantes'));
        $this->set('_serialize', ['representantes_sin_estudiantes']);
    }

    public function cambiarEstatusRegistro()
    {
        $representantes = $this->Parentsandguardians->find('all')->where(["Parentsandguardians.estatus_registro !=" => "Activo"]);

        $contador_registros_seleccionados = $representantes->count();
        $contador_registros_modificados = 0;

        foreach ($representantes as $representante)
        {
            $representante_a_modificar = $this->Parentsandguardians->get($representante->id);
            $representante_a_modificar->estatus_registro = "Activo";
            if (!($this->Parentsandguardians->save($representante_a_modificar))) 
            {
                $this->Flash->error(__('El registro con el ID '.$representante_a_modificar->id.' no pudo ser modificado'));
            }
            else
            {
                $contador_registros_modificados++;
            } 
                     
        }
        $this->set(compact('contador_registros_seleccionados', 'contador_registros_modificados'));
    }

    public function consultaContratoRepresentante()
    {
        
    }
    public function reportesContratoServicio($tipo_reporte = null, $controlador = null, $accion = null)
    {
        $this->loadModel('Schools');

		$schools = $this->Schools->get(2);

        $actual_anio_escolar = $schools->current_school_year;
        $actual_anio_inscripcion = $schools->current_year_registration;

        $vector_representantes = [];
        $seleccionado = 0;
        $contador_seleccionados = 0;
        $impresion = 0;
        $contador_impresion = 0;
        /* 
        Para seleccionar los alumnos regulares chequeo que el campo "balance" sea igual o mayor al valor del campo "current_school_year" de la tabla schools
        Para seleccionar los alumnos nuevos cheque que el campo "balance" sea igual al valor del campo "current_year_registration" de la tabla schools
         */

        $estudiantes = $this->Parentsandguardians->Students->find('all', ['contain' => 'Parentsandguardians', 'order' => ['Parentsandguardians.family' => "ASC"], 'conditions' => ['Students.student_condition' => 'Regular', 'Students.balance >=' => $actual_anio_escolar]]);

        foreach ($estudiantes as $estudiante)
        {
            $seleccionado = 0;
            $impresion = 0;

            switch ($tipo_reporte) 
            {
                case 1:
                    $titulo_reporte = "Representantes de estudiantes regulares que han firmado el contrato";
                    $titulo_total = "Total representantes de estudiantes regulares";
                    if ($estudiante->new_student == 0)
                    {
                        $seleccionado = 1;
                        if ($estudiante->parentsandguardian->datos_contrato != null)
                        {
                            $impresion = 1;
                        }    
                    }
                    break;
                case 2:
                    $titulo_reporte = "Representantes de estudiantes regulares que no han firmado el contrato";   
                    $titulo_total = "Total representantes de estudiantes regulares";
                    if ($estudiante->new_student == 0)
                    {
                        $seleccionado = 1;
                        if ($estudiante->parentsandguardian->datos_contrato == null)
                        {
                            $impresion = 1;
                        }   
                    }          
                    break;
                case 3:
                    $titulo_reporte = "Representantes de estudiantes nuevos que han firmado el contrato";
                    $titulo_total = "Total representantes de estudiantes nuevos";
                    if ($estudiante->new_student == 1 && $estudiante->balance == $actual_anio_inscripcion)
                    {
                        $seleccionado = 1;
                        if ($estudiante->parentsandguardian->datos_contrato != null)
                        {
                            $impresion = 1;
                        } 
                    }     
                    break;
                case 4:
                    $titulo_reporte = "Representantes de estudiantes nuevos que no han firmado el contrato";
                    $titulo_total = "Total representantes de estudiantes nuevos";
                    if ($estudiante->new_student == 1 && $estudiante->balance == $actual_anio_inscripcion)
                    {
                        $seleccionado = 1;
                        if ($estudiante->parentsandguardian->datos_contrato == null)
                        {
                            $impresion = 1;
                        } 
                    }     
                    break;
            } 
            if ($seleccionado == 1)
            {
                if (!(isset($vector_representantes[$estudiante->parentsandguardian->id])))
                {
                    $contador_seleccionados++;
                    $contador_impresion = $contador_impresion + $impresion;
                    $vector_representantes[$estudiante->parentsandguardian->id] = ["familia" => $estudiante->parentsandguardian->family, "representante" => $estudiante->parentsandguardian->full_name, "impresion" => $impresion];
                }
            }
        }

        $this->set(compact('tipo_reporte', 'titulo_reporte', 'titulo_total', 'vector_representantes', 'contador_seleccionados', 'contador_impresion'));
    }
}