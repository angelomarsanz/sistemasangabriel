<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Filesystem\File; 

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
            /*
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
            */
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
                $parentsandguardian->estatus_registro = "Activo";

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

                    $user->estatus_registro = "Activo";

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
                'conditions' => [['family LIKE' => $name . '%'], ['guardian !=' => 1], ['estatus_registro' => 'Activo']]]);
            $resultsArr = [];
            foreach ($results as $result) {
				$resultsArr[] =['label' => $result['family'] . ' (' . $result['surname'] . ' ' . $result['first_name'] . ')', 'value' => $result['family'] . ' (' . $result['surname'] . ' ' . $result['first_name'] . ')', 'id' => $result['id']];
				}
			exit(json_encode($resultsArr, JSON_FORCE_OBJECT));
        }
    }

    public function findFamilyConsejoEducativo()
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $name = trim($this->request->query['term']);
            $results = $this->Parentsandguardians->find('all', [
                'conditions' => [['family LIKE' => $name . '%'], ['guardian !=' => 1], ['estatus_registro' => 'Activo'], ['consejo_educativo' => 'Sí']]]);
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

    // Esta función debe ejecutarse inmediatamente al inicio del año escolar 

    public function eliminarRepresentantesSinEstudiantesActivos()
    {
        $binnacles = new BinnaclesController;
        $controladorTransacciones = new StudenttransactionsController();
        $controladorTransacciones->verificarAnioUltimaInscripcion();

        $this->loadModel('Schools');
		$schools = $this->Schools->get(2);
        $anioEscolarActual = $schools->current_school_year;
        $anioEscolarAnterior = $anioEscolarActual - 1;

        $representantes_con_estudiantes_activos = [];
        $representantes_sin_estudiantes_activos = [];
        $estudiantes_eliminados = [];

        $representantes = $this->Parentsandguardians->find('all')->where(['Parentsandguardians.id >' => 1 , "Parentsandguardians.estatus_registro" => "Activo"]);
        
        $estudiantes = $this->Parentsandguardians->Students->find('all')->where(['Students.id >' => 1 , "Students.student_condition" => "Regular"])->order(['Students.parentsandguardian_id' => 'ASC', 'Students.id' => 'ASC']);

        foreach ($representantes as $representante)
        {
            $indicadorEstudiantes = 0;
            $texto_indicador_estudiantes = "Sin estudiantes asociados";
            $consejoEducativo = "No";

            foreach ($estudiantes as $estudiante)
            {
                if ($estudiante->parentsandguardian_id == $representante->id)
                {
                    if ($estudiante->balance == null || $estudiante->balance == 0)
                    {
                        if ($estudiante->created->year >= $anioEscolarActual)
                        {
                            $indicadorEstudiantes = 1;
                        } 
                    }
                    elseif ($estudiante->balance > $anioEscolarActual)
                    {
                        $indicadorEstudiantes = 1;
                    }
                    elseif ($estudiante->balance == $anioEscolarActual)
                    {
                        $indicadorEstudiantes = 1;
                        $consejoEducativo = "Sí";
                    }
                    elseif ($estudiante->balance == $anioEscolarAnterior)
                    {
                        $indicadorEstudiantes = 1;
                    }
                    else
                    {
                        $texto_indicador_estudiantes = "Con estudiantes inactivos";
                        $estudianteAEliminar = $this->Parentsandguardians->Students->get($estudiante->id);
                        $estudianteAEliminar->student_condition = "Eliminado";
                        /*
                        if (!($this->Parentsandguardians->Students->save($estudianteAEliminar))) 
                        {
                            $binnacles->add('controller', 'Parentsandguardians', 'eliminarRepresentantesEstudiantesInactivos', 'No se pudo eliminar el registro del estudiante con el ID: '.$student->id);
                        } 
                        else
                        {
                            $estudiantes_eliminados[] = ['estudiante' => $estudiante->full_name, 'familia' => $representante->family,'id_estudiante' => $estudiante->id];
                        }
                        */
                    }
                }              
            }
            if ($indicadorEstudiantes == 1)
            {
                $representantes_con_estudiantes_activos[] = ['familia' => $representante->family, 'nombre_representante' => $representante->full_name, 'id_representante' => $representante->id, 'id_usuario_representante' => $representante->user_id, 'consejoEducativo' => $consejoEducativo];
            }
            else
            {
                $representantes_sin_estudiantes_activos[] = ['familia' => $representante->family, 'nombre_representante' => $representante->full_name, 'id_representante' => $representante->id, 'id_usuario_representante' => $representante->user_id, 'motivo' => $texto_indicador_estudiantes];
            }
        }
        /*
        foreach ($representantes_con_estudiantes_activos as $representanteActivo)
        {
            $representanteAModificar = $this->Parentsandguardians->get($representanteActivo['id_representante']);
            $representanteAModificar->consejo_educativo = $representanteActivo['consejoEducativo'];
            if (!($this->Parentsandguardians->save($representanteAModificar))) 
            { 
                $binnacles->add('controller', 'Parentsandguardians', 'eliminarRepresentantesEstudiantesInactivos', 'No se pudo actualizar el campo consejo_educativo del representante con el ID: '.$representanteActivo['id_representante']);
            }
        }
        foreach ($representantes_sin_estudiantes_activos as $representanteInactivo)
        {
            $representanteAEliminar = $this->Parentsandguardians->get($representanteInactivo['id_representante']);
            $representanteAEliminar->estatus_registro = "Eliminado";
            if ($this->Parentsandguardians->save($representanteAEliminar)) 
            {
                $usuarioAEliminar = $this->Parentsandguardians->Users->get($representanteInactivo['id_usuario_representante']);
                $usuarioAEliminar->estatus_registro = "Eliminado";
                if (!($this->Parentsandguardians->Users->save($usuarioAEliminar))) 
                {
                    $binnacles->add('controller', 'Parentsandguardians', 'eliminarRepresentantesEstudiantesInactivos', 'No se pudo eliminar el registro del usuario con el ID: '.$representanteInactivo['id_usuario_representante']);
                }
            }
            else
            { 
                $binnacles->add('controller', 'Parentsandguardians', 'eliminarRepresentantesEstudiantesInactivos', 'No se pudo eliminar el registro del representante con el ID: '.$representanteInactivo['id_representante']);
            }
        }
        */
        $this->set(compact('representantes_con_estudiantes_activos', 'representantes_sin_estudiantes_activos', 'estudiantes_eliminados'));
    }

    // Esta función se creó como parte del procedimiento de eliminar lógicamente los registros de representantes que no tienen estudiantes asociados o solo tienen estudiantes inactivos. No se debe ejecutar nuevamente porque dañaría la data

    public function cambiarEstatusRegistros()
    {
        $this->loadModel('Users');
        $binnacles = new BinnaclesController;
        $representantes = $this->Parentsandguardians->find('all')->where(["Parentsandguardians.estatus_registro !=" => "Activo", "Parentsandguardians.id >" => 1]);

        $contador_registros_seleccionados = $representantes->count();
        $contador_registros_representantes_modificados = 0;
        $contador_registros_usuarios_modificados = 0;

        foreach ($representantes as $representante)
        {
            $representante_a_modificar = $this->Parentsandguardians->get($representante->id);
            $representante_a_modificar->estatus_registro = "Activo";
            /*
            if (!($this->Parentsandguardians->save($representante_a_modificar))) 
            {
                $binnacles->add('controller', 'Parentsandguardians', 'cambiarEstatusRegistro', 'No se pudo modificar el registro del representante con el ID: '.$representante->id);
            }
            else
            { 
                $contador_registros_representantes_modificados++;
                $usuario_a_modificar = $this->Users->get($representante->user_id);
                $usuario_a_modificar->estatus_registro = "Activo";
                
                if (!($this->Users->save($usuario_a_modificar))) 
                {
                    $binnacles->add('controller', 'Parentsandguardians', 'cambiarEstatusRegistro', 'No se pudo modificar el registro del usuario con el ID: '.$representante->user_id);
                }
                else
                { 
                    $contador_registros_usuarios_modificados++;
                }
            } 
            */                 
        }
        $this->set(compact('contador_registros_seleccionados', 'contador_registros_representantes_modificados', 'contador_registros_usuarios_modificados'));
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
    public function busquedaRecibosConsejoEducativo($conceptoConsejoEducativo = null, $idRepresentante = null)
    {
		$binnacles = new BinnaclesController;
        $this->loadModel('Concepts');
        
        $recibosConsejoEducativo = $this->Concepts->find()
            ->contain(['Bills'])
            ->where(['Bills.annulled' => false,
                'Concepts.concept' => $conceptoConsejoEducativo,
                'Bills.parentsandguardian_id' => $idRepresentante])
            ->order(['Concepts.id' => 'ASC']);
        if ($recibosConsejoEducativo->count() == 0)
        {
            return true;
        }
        else
        {
            return false;           
        }
    }

    public function consejoEducativo($reporte = null)
    {
        if (isset($reporte))
        {
            $fechaActual = Time::now();
            $this->loadModel('Schools');
            $schools = $this->Schools->get(2);
            $anioEscolarActual = $schools->current_school_year;
            $proximoAnioEscolar = $schools->current_school_year + 1;
            $periodoEscolarActual = "Año escolar ".$anioEscolarActual."-".$proximoAnioEscolar;
            $anioEscolar = $anioEscolarActual."-".$proximoAnioEscolar;

            if ($schools->current_year_registration == $schools->current_school_year)
            {
                $condicionBalance =  'Students.balance';
            }
            else
            {
                $condicionBalance = 'Students.balance >=';
            }

            if ($reporte == "familiasRelacionadas")
            {
                $this->busquedaFamiliasRelacionadas();
                $familiasRelacionadasControl = $this->Parentsandguardians->find('all', ['conditions' => 
                [
                    'familias_relacionadas is not null'
                ]]);
        
                $familiasRelacionadasBusqueda = $this->Parentsandguardians->find('all', ['conditions' => 
                [
                    'familias_relacionadas is null'
                ]]);
        
                $this->set(compact('fechaActual', 'anioEscolar', 'reporte', 'familiasRelacionadasControl', 'familiasRelacionadasBusqueda'));
            }
            else
            {
                $tarifaConsejoEducativo = 0;

                $transaccionesEstudiante = new StudenttransactionsController;

                $transaccionesEstudiante->verificarAnioUltimaInscripcion();

                if ($reporte == "familiasExoneradas")
                {
                    $familiasExoneradas = $this->Parentsandguardians->Students->find('all')
                    ->where(['Parentsandguardians.estatus_registro' => 'Activo', 'Parentsandguardians.consejo_exonerado >' => 0, 'Students.student_condition' => "Regular", $condicionBalance => $anioEscolarActual])
                    ->contain(['Parentsandguardians', 'Sections'])
                    ->order(
                        [
                            'Parentsandguardians.family' => 'ASC',
                            'Parentsandguardians.id' => 'ASC',
                            'Students.surname' => 'ASC',
                            'Students.second_surname' => 'ASC',
                            'Students.first_name' => 'ASC',
                            'Students.second_name' => 'ASC',
                        ]);
                    
                    $this->set(compact('fechaActual', 'anioEscolar', 'reporte', 'familiasExoneradas'));
                }
                elseif ($reporte == "reporteGeneralConsejoEducativo")
                {
                    $familiasConsejoEducativo = $this->Parentsandguardians->Students->find('all')
                        ->where(['Parentsandguardians.estatus_registro' => 'Activo', 'Students.student_condition' => "Regular", $condicionBalance => $anioEscolarActual])
                        ->contain(['Parentsandguardians', 'Sections'])
                        ->order(
                            [
                                'Parentsandguardians.family' => 'ASC',
                                'Parentsandguardians.id' => 'ASC',
                                'Students.surname' => 'ASC',
                                'Students.second_surname' => 'ASC',
                                'Students.first_name' => 'ASC',
                                'Students.second_name' => 'ASC',
                            ]);

                    $this->loadModel('Bills');

                    $recibosConsejoEducativo = $this->Bills->find('all')
                        ->where(["tipo_documento" => "Recibo de Consejo Educativo", "school_year" => $periodoEscolarActual, "annulled" => 0 ]);
                    
                    $this->loadModel('Rates');

                    $tarifas = $this->Rates->find('all')
                        ->where(["Concept" => "Consejo Educativo", "rate_year" => $anioEscolarActual]);

                    if ($tarifas->count() > 0)
                    {
                        $tarifaConsejoEducativo = $tarifas->first();
                    }
                    $this->set(compact('fechaActual', 'anioEscolar', 'reporte', 'familiasConsejoEducativo', 'recibosConsejoEducativo', 'tarifaConsejoEducativo'));
                }
            }
        }
        else
        {
            $reporte = "";
            $this->set(compact('reporte'));
        }
    }

    public function busquedaFamiliasRelacionadas()
    {
        $excepcionesNombre =
            [
                "NO   APLICA",
                "NO  APLICA",
                "NO APLICA",
                "NOAPLICA",
                "N/A",
                "N / A"
            ];

        $excepcionesCedula =
            [
                "0"
            ];

        $familiasRelacionadasBD = $this->Parentsandguardians->find('all', ['conditions' => 
            [
                'familias_relacionadas is not null'
            ]]);

        $familiasControl = $this->Parentsandguardians->find('all', ['conditions' => 
            [
                'id >' => 1,
                'estatus_registro' => "Activo",
                'family !='  => "",
                'type_of_identification_father !=' => "",
                'identidy_card_father !=' => "",
                'type_of_identification_mother !=' => "",
                'identidy_card_mother !=' => "",
            ]]);

        $familiasBusqueda = $this->Parentsandguardians->find('all', ['conditions' => 
            [
                'id >' => 1,
                'estatus_registro' => "Activo",
                'family !='  => "",
                'type_of_identification_father !=' => "",
                'identidy_card_father !=' => "",
                'type_of_identification_mother !=' => "",
                'identidy_card_mother !=' => "",
            ]]);

        $contadorFamiliasControlProcesadas = 0;
        $contadorFamiliasBusquedaProcesadas = 0;
        $indicadorConFamiliasRelacionadas = 0;
        $indicadorFamiliaRelacionada = 0;
        $vectorFamiliasRelacionadas = [];
        $contadorFamiliasRelacionadasActualizadas = 0;
        $contadorFamiliasNoRelacionadasActualizadas = 0;
        $indicadorExcepcionNombrePadre = 0;
        $indicadorExcepcionNombreMadre = 0;
        $familiasYaRelacionadas = [];

        $binnacles = new BinnaclesController;

        foreach ($familiasRelacionadasBD as $familia)
        {
            $representante = $this->Parentsandguardians->get($familia->id);
            $representante->familias_relacionadas = null;
            if (!($this->Parentsandguardians->save($representante))) 
            {
                $binnacles->add('controller', 'Parentsandguardians', 'busquedaFamiliasRelacionadas', 'No se pudo limpiar el campo familias_relacionadas en el registro con el ID '.$familia->id);
            }
        }

        foreach ($familiasControl as $control)
        {
            $indicadorConFamiliasRelacionadas = 0;
            $vectorFamiliasRelacionadas = [];

            $nombrePadreControl = 
                trim($control->first_name_father)." ".
                trim($control->second_name_father)." ".
                trim($control->surname_father)." ".
                trim($control->second_surname_father);

            $nombrePadreControl = $this->eliminarAcentos($nombrePadreControl);

            $identificacionPadreControl = $control->type_of_identification_father.trim($control->identidy_card_father);

            $nombreMadreControl = 
                trim($control->first_name_mother)." ".
                trim($control->second_name_mother)." ".
                trim($control->surname_mother)." ".
                trim($control->second_surname_mother);

            $nombreMadreControl = $this->eliminarAcentos($nombreMadreControl);

            $identificacionMadreControl = $control->type_of_identification_mother.trim($control->identidy_card_mother);

            $indicadorExcepcionNombrePadre = 0;
            $indicadorExcepcionNombreMadre = 0;
            foreach ($excepcionesNombre as $excepcion)
            {
                $posicionCadena = strpos($nombrePadreControl, $excepcion);
                if ($posicionCadena !== false)
                {
                    $indicadorExcepcionNombrePadre = 1;
                }
                $posicionCadena = strpos($nombreMadreControl, $excepcion);
                if ($posicionCadena !== false)
                {
                    $indicadorExcepcionNombreMadre = 1;
                }
            }

            if ($nombrePadreControl != "" && $nombreMadreControl != "")
            {
                $contadorFamiliasControlProcesadas++;
                foreach ($familiasBusqueda as $busqueda)
                {
                    $indicadorMarcado = 0;
                    $indicadorFamiliaRelacionada = 0;
                    if ($control->id != $busqueda->id)
                    {
                        if (!(in_array($busqueda->id, $familiasYaRelacionadas)))
                        {           
                            $nombrePadreBusqueda = 
                                trim($busqueda->first_name_father)." ".
                                trim($busqueda->second_name_father)." ".
                                trim($busqueda->surname_father)." ".
                                trim($busqueda->second_surname_father);

                            $nombrePadreBusqueda = $this->eliminarAcentos($nombrePadreBusqueda);

                            $identificacionPadreBusqueda = $busqueda->type_of_identification_father.trim($busqueda->identidy_card_father);

                            $nombreMadreBusqueda = 
                                trim($busqueda->first_name_mother)." ".
                                trim($busqueda->second_name_mother)." ".
                                trim($busqueda->surname_mother)." ".
                                trim($busqueda->second_surname_mother);

                            $nombreMadreBusqueda = $this->eliminarAcentos($nombreMadreBusqueda);

                            $identificacionMadreBusqueda = $busqueda->type_of_identification_mother.trim($busqueda->identidy_card_mother);

                            if ($nombrePadreBusqueda != "" && $nombreMadreBusqueda != "")
                            {
                                $contadorFamiliasBusquedaProcesadas++;

                                if (!(in_array(trim($control->identidy_card_father), $excepcionesCedula)))
                                {
                                    if ($identificacionPadreControl == $identificacionPadreBusqueda)
                                    {
                                        $indicadorFamiliaRelacionada = 1;
                                    }
                                }
                                if ($indicadorFamiliaRelacionada == 0)
                                {
                                    if (!(in_array(trim($control->identidy_card_mother), $excepcionesCedula)))
                                    {
                                        if ($identificacionMadreControl == $identificacionMadreBusqueda)
                                        {
                                            $indicadorFamiliaRelacionada = 1;
                                        }
                                    }
                                }
                                if ($indicadorFamiliaRelacionada == 0)
                                { 
                                    if ($indicadorExcepcionNombrePadre == 0)
                                    {
                                        if ($nombrePadreControl == $nombrePadreBusqueda)
                                        {
                                            $indicadorFamiliaRelacionada = 1;
                                        }
                                    }
                                }
                                if ($indicadorFamiliaRelacionada == 0)
                                {
                                    if ($indicadorExcepcionNombreMadre == 0)
                                    {
                                        if ($nombreMadreControl == $nombreMadreBusqueda)
                                        {
                                            $indicadorFamiliaRelacionada = 1;
                                        }
                                    }
                                }
                                if ($indicadorFamiliaRelacionada == 1)
                                {
                                    $indicadorConFamiliasRelacionadas = 1;
                                    $vectorFamiliasRelacionadas[] = $busqueda->id;
                                }
                            }
                        }
                    }  
                }  
                if ($indicadorConFamiliasRelacionadas == 1)
                {
                    $representante = $this->Parentsandguardians->get($control->id);
                    $representante->familias_relacionadas = json_encode($vectorFamiliasRelacionadas);
                    if ($this->Parentsandguardians->save($representante)) 
                    {
                        $contadorFamiliasRelacionadasActualizadas++;
                        $familiasYaRelacionadas[] = $control->id;
                    }
                    else
                    {
                        $binnacles->add('controller', 'Parentsandguardians', 'busquedaFamiliasRelacionadas', 'No se pudo actualizar el representante con familias relacionadas con el ID '.$control->id);
                    }
                }
            }
        }
        $binnacles->add('controller', 'Parentsandguardians', 'busquedaFamiliasRelacionadas', 'contadorFamiliasControlProcesadas '.$contadorFamiliasControlProcesadas.' contadorFamiliasBusquedaProcesadas '.$contadorFamiliasBusquedaProcesadas.' contadorFamiliasRelacionadasActualizadas '.$contadorFamiliasRelacionadasActualizadas.' contadorFamiliasNoRelacionadasActualizadas '.$contadorFamiliasNoRelacionadasActualizadas);
        return;    
    }
    
    public function eliminarAcentos($cadena)
    {
        $letrasConTilde = 
            [
                'Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª',
                'É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê',
                'Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î',
                'Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô',
                'Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'
            ];

        $letrasSinTilde =
            [
                'A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a',
                'E', 'E', 'E', 'E', 'e', 'e', 'e', 'e',
                'I', 'I', 'I', 'I', 'i', 'i', 'i', 'i',
                'O', 'O', 'O', 'O', 'o', 'o', 'o', 'o',
                'U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'              
            ];
 
        $cadena = str_replace($letrasConTilde, $letrasSinTilde, $cadena);

        return $cadena;
    }

    public function datosFamilia()
    {    
        $this->autoRender = false;
        if ($this->request->is('ajax')) 
        {
            if (isset($_POST['idFamilia']))
            {
                $idFamilia = $_POST['idFamilia'];
                $respuesta = [];
                $contadorEstudiantes = 0;
                $consejoExonerado = 0;

                $estudiantes = $this->Parentsandguardians->Students->find('all')
                ->where(['Parentsandguardians.id' => $idFamilia , 'Students.student_condition' => "Regular"])
                ->contain(['Parentsandguardians']);

                if ($estudiantes->count() > 0)
                {
                    $respuesta["satisfactorio"] = true;
                    foreach ($estudiantes as $estudiante)
                    {
                        if ($contadorEstudiantes == 0)
                        {
                            $consejoExonerado = $estudiante->parentsandguardian->consejo_exonerado; 
                            $respuesta['html'] =
                                "<br />".
                                "<h4>Familia: ".$estudiante->parentsandguardian->family." (".$estudiante->parentsandguardian->surname." ".$estudiante->parentsandguardian->first_name.")</h3>".
                                "<div name='estudiantesFamilia' id='estudianteFamilia' class='container'>".
                                "<table class='table table-striped table-hover'>".
                                    "<thead>".
                                        "<tr>".
                                            "<th><b>Estudiante(s)</b></th>".
                                        "</tr>".
                                    "</thead>".
                                    "<tbody>";
                        }
                        $respuesta['html'] .=
                                "<tr>".
                                    "<td>".$estudiante->full_name."</td>".
                                "<tr>";
                        $contadorEstudiantes++;
                    }
                    if ($contadorEstudiantes > 0)
                    {
                        $respuesta['html'] .=
                                    "</tbody>".
                                "</table>".
                            "</div>";	
                        if ($consejoExonerado > 0)
                        {
                            $respuesta['html'] .= "<button type='button' class='exoneracion eliminarExoneracion btn btn-primary'>Eliminar exoneración</button>";
                        }	
                        else
                        {
                            $respuesta['html'] .= "<button type='button' class='exoneracion exonerarFamilia btn btn-primary'>Exonerar</button>";
                        }
                    }
                }
                else
                {
                    $respuesta["satisfactorio"] = false;
                    $respuesta["mensajeDeError"] = "La familia no tiene estudiantes asociados";
                }
                exit(json_encode($respuesta, JSON_FORCE_OBJECT));
            }
        }
    }
    public function editarExoneracion()
    {    
        $this->autoRender = false;
        if ($this->request->is('ajax')) 
        {
            if (isset($_POST['idFamilia']))
            {
                $idFamilia = $_POST['idFamilia'];
                $accion = $_POST['accion'];
                $respuesta = [];

                $representante = $this->Parentsandguardians->get($idFamilia);

                if ($accion == "exonerarFamilia")
                {
                    $representante->consejo_exonerado = 100;
                }
                else
                {
                    $representante->consejo_exonerado = 0;
                }

                if ($this->Parentsandguardians->save($representante)) 
                {
                    $respuesta["satisfactorio"] = true;
                    if ($accion == "exonerarFamilia")
                    {
                        $respuesta["mensaje"] = "Se exoneró el consejo educativo exitosamente";
                    }
                    else
                    {
                        $respuesta["mensaje"] = "Se eliminó la exoneración del Consejo Educativo exitosamente";
                    }
                }
                else
                {
                    $respuesta["satisfactorio"] = false;
                    $respuesta["mensaje"] = "No se pudieron hacer los cambios en la base de datos";
                }
                exit(json_encode($respuesta, JSON_FORCE_OBJECT));
            }
        }
    }

    public function activarRegistroRepresentante($idRepresentante = null)
    {
        $representante = $this->Parentsandguardians->get(1059);
        $representante->estatus_registro = 'Activo';
        if ($this->Parentsandguardians->save($representante)) 
        {
            $usuario = $this->Parentsandguardians->Users->get($representante->user_id);
            $usuario->estatus_registro = 'Activo';
            if ($this->Parentsandguardians->Users->save($usuario))
            {
                $this->Flash->success(__('Los registros del representante y el usuario se activaron exitosamente'));
            }
            else
            {
                $this->Flash->error(__('No se pudo activar el registro del usuario'));
            }
        }
        else
        {
            $this->Flash->error(__('No se pudo activar el registro del representante'));
        }
    }

    public function reactBoton()
    {
        $filePath = WWW_ROOT . 'componentes_react/boton/build/asset-manifest.json';
        $file = new File($filePath);
 
        $manifest = json_decode($file->read());
        $file->close();
 
        $maincss = 'main.css';
        $mainjs = 'main.js';
 
        $css = '/componentes_react/boton/build' . $manifest->files->$maincss;
        $js = '/componentes_react/boton/build' . $manifest->files->$mainjs;
        $this->set(compact('css', 'js'));
    }
}