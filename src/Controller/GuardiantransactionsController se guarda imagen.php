<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\BinnaclesController;

/**
 * Guardiantransactions Controller
 *
 * @property \App\Model\Table\GuardiantransactionsTable $Guardiantransactions
 */
class GuardiantransactionsController extends AppController
{
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
    }

    public function isAuthorized($user)
    {
        if(isset($user['role']) and $user['role'] === 'Representante')
        {
            if(in_array($this->request->action, ['index', 'view', 'add', 'edit', 'delete', 'homeScreen', 'contratoRepresentante']))
            {
                return true;
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
        $guardiantransactions = $this->paginate($this->Guardiantransactions);

        $this->set(compact('guardiantransactions'));
        $this->set('_serialize', ['guardiantransactions']);
    }

    /**
     * View method
     *
     * @param string|null $id Guardiantransaction id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $guardiantransaction = $this->Guardiantransactions->get($id, [
            'contain' => []
        ]);

        $this->set('guardiantransaction', $guardiantransaction);
        $this->set('_serialize', ['guardiantransaction']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $lastRecord = $this->Guardiantransactions->Parentsandguardians->find('all', ['conditions' => ['user_id' => $this->Auth->user('id')], 'order' => ['Parentsandguardians.created' => 'DESC'] ]);
                
        $row = $lastRecord->first();

        $idParentsAndGuardian = $row['id'];
        
        $payment = $this->Guardiantransactions->find('all', ['conditions' => ['parentsandguardian_id' => $idParentsAndGuardian], 'order' => ['Guardiantransactions.created' => 'DESC'] ]);
                
        $lastPayment = $payment->first();

        if (!($lastPayment))
        {
            $guardiantransaction = $this->Guardiantransactions->newEntity();
            if ($this->request->is('post')) 
            {
                $guardiantransaction = $this->Guardiantransactions->patchEntity($guardiantransaction, $this->request->data);
                if ($this->Guardiantransactions->save($guardiantransaction)) 
                {
                    $this->Flash->success(__('La Transferencia fue guardada exitosamente'));
    
                    return $this->redirect(['controller' => 'Parentsandguardians', 'action' => 'edit', $idParentsAndGuardian, 'Parentsandguardians', 'profilePhoto']);
                } 
                else 
                {
                    $this->Flash->error(__('La Transferencia no pudo ser guardada'));
                }
            }
        }
        else
        {
            return $this->redirect(['controller' => 'Parentsandguardians', 'action' => 'edit', $idParentsAndGuardian, 'Parentsandguardians', 'profilePhoto']);
        }

        $this->set(compact('guardiantransaction', 'idParentsAndGuardian'));
        $this->set('_serialize', ['guardiantransaction', 'idParentsAndGuardian']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Guardiantransaction id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $guardiantransaction = $this->Guardiantransactions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $guardiantransaction = $this->Guardiantransactions->patchEntity($guardiantransaction, $this->request->data);
            if ($this->Guardiantransactions->save($guardiantransaction)) {
                $this->Flash->success(__('The guardiantransaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The guardiantransaction could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('guardiantransaction'));
        $this->set('_serialize', ['guardiantransaction']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Guardiantransaction id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $guardiantransaction = $this->Guardiantransactions->get($id);
        if ($this->Guardiantransactions->delete($guardiantransaction)) {
            $this->Flash->success(__('The guardiantransaction has been deleted.'));
        } else {
            $this->Flash->error(__('The guardiantransaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function homeScreen()
    {
        $lastRecord = $this->Guardiantransactions->Parentsandguardians->find('all', ['conditions' => ['user_id' => $this->Auth->user('id')], 'order' => ['Parentsandguardians.created' => 'DESC'] ]);
                
        $row = $lastRecord->first();

        $idParentsAndGuardian = $row['id'];
        /* Activar esta línea cuando se desea ocultar temporalmente al representante la información de los conceptos de inscripción
        return $this->redirect(['controller' => 'Parentsandguardians', 'action' => 'edit', $idParentsAndGuardian, 'Parentsandguardi
        ans', 'profilePhoto']);
        */
        $this->set(compact('idParentsAndGuardian'));
        $this->set('_serialize', ['idParentsAndGuardian']);
    }
    public function monetaryReconversion()
    {				
		$binnacles = new BinnaclesController;
	
		$guardiantransactions = $this->Guardiantransactions->find('all', ['conditions' => ['id >' => 0]]);
	
		$account1 = $guardiantransactions->count();
			
		$account2 = 0;
		
		foreach ($guardiantransactions as $guardiantransaction)
        {		
			$guardiantransactionGet = $this->Guardiantransactions->get($guardiantransaction->id);
			
			$previousAmount = $guardiantransactionGet->amount;
										
			$guardiantransactionGet->amount = $previousAmount / 100000;
					
			if ($this->Guardiantransactions->save($guardiantransactionGet))
			{
				$account2++;
			}
			else
			{
				$binnacles->add('controller', 'Guardiantransactions', 'monetaryReconversion', 'No se actualizó registro con id: ' . $guardiantransactionGet->id);
			}
		}

		$binnacles->add('controller', 'Guardiantransactions', 'monetaryReconversion', 'Total registros seleccionados: ' . $account1);
		$binnacles->add('controller', 'Guardiantransactions', 'monetaryReconversion', 'Total registros actualizados: ' . $account2);

		return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
	}

    public function contratoRepresentante($idRepresentante = null)
    {
        $this->loadModel('Parentsandguardians');

        $representante = $this->Parentsandguardians->get($idRepresentante, [
            'contain' => ['Students']
        ]);

		if ($this->request->is('post')) 
        {
            $img = $_POST['base64'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $fileData = base64_decode($img);
            $fileName = uniqid().'.png';

            file_put_contents(WWW_ROOT."files/contratos/".$fileName, $fileData);

            $datos_contrato = 
			[
				"imagen_firma" => $fileName,
				"usuario" => "usuario",
				"ip" => "123",
                "fecha" => "23-01-2023",
                "hora" => "23:23"
			];



		    $representante->datos_contrato = json_encode($datos_contrato);

            if ($this->Parentsandguardians->save($representante)) 
            {
                return $this->redirect(['controller' => 'Parentsandguardians', 'action' => 'edit',  $idRepresentante, 'Parentsandguardians', 'profilePhoto']);
            } 
            else 
            {
                $this->Flash->error(__('Firma no guardada'));
            }
        }

        $this->set(compact('representante', 'idRepresentante'));
    }
    public function guardarFirma()
    {
        $this->autoRender = false;

        if ($this->request->is('json')) 
        {
            $this->loadModel('Parentsandguardians');

            $representante = $this->Parentsandguardians->get(750);

            $representante->first_name = "Pepito";
            if ($this->Parenstandguardians->save($representante)) 
            {
                $respuesta = ["resultado" => true];
            } 
            else 
            {
                $respuesta = ["resultado" => false];
            }
            exit(json_encode($respuesta, JSON_FORCE_OBJECT));
        }
    }
}
