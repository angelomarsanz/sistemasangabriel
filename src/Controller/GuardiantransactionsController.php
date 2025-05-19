<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\BinnaclesController;

use Cake\I18n\Time;

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
            if(in_array($this->request->action, ['index', 'view', 'add', 'edit', 'delete', 'homeScreen', 'previoContratoRepresentante', 'firmaContratoRepresentante']))
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

    public function previoContratoRepresentante($idRepresentante = null, $controlador = null, $accion = null, $anioFirmarContrato = null)
    {
        $this->loadModel('Parentsandguardians');

        $representante = $this->Parentsandguardians->get($idRepresentante, [
            'contain' => ['Students']
        ]);

        $indicadorFirmarContrato = 0;
        $indicadorContratoFirmado = 0;
        $anioContratoFirmado = 0;
        $imagenFirma = '';

        if ($controlador == "Users" && $accion == "home")
        {
            $this->Flash->success(__('Por favor lea detenidamente el presente contrato y si está de acuerdo proceda a firmarlo'));
        }
        else
        {
            $verificacionFirmarContrato = $this->verificacionFirmarContrato($idRepresentante);
            $indicadorFirmarContrato = $verificacionFirmarContrato['indicadorFirmarContrato'];
            $anioFirmarContrato = $verificacionFirmarContrato['anioFirmarContrato'];

            if ($representante->vector_contratos != null)
            {
                $verificacionContratoFirmado = $this->verificacionContratoFirmado($representante);
                $indicadorContratoFirmado = $verificacionContratoFirmado['indicadorContratoFirmado'];
                $anioContratoFirmado = $verificacionContratoFirmado['anioContratoFirmado'];
                $imagenFirma = $verificacionContratoFirmado['imagenFirma'];
            }

            if ($controlador == null && $accion == null)
            {
                if ($anioFirmarContrato > $anioContratoFirmado)
                {
                    $this->Flash->success(__('Por favor lea detenidamente el presente contrato y si está de acuerdo proceda a firmarlo'));
                }
                else
                {
                    return $this->redirect(['controller' => 'Students', 'action' => 'index']);
                } 
            }
            else
            {
                if ($indicadorContratoFirmado == 0)
                {
                    $this->Flash->error(__('El contrato no ha sido firmado aún'));
                    return $this->redirect(['controller' => $controlador, 'action' => $accion]);
                }            
            }
        }
        $this->set(compact('representante', 'controlador', 'accion', 'indicadorFirmarContrato', 'anioFirmarContrato', 'indicadorContratoFirmado', 'anioContratoFirmado', 'imagenFirma'));
    }

    public function firmaContratoRepresentante($idRepresentante = null, $anioFirmarContrato = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
				
        $fecha_hora_actual = Time::now();
        
        $this->loadModel('Parentsandguardians');

        $representante = $this->Parentsandguardians->get($idRepresentante, [
            'contain' => ['Students']
        ]);

        $vector_contratos = [];

		if ($this->request->is('post')) 
        {
            $anioFirmarContrato = $_POST['anio_firmar_contrato'];
            $img = $_POST['base64'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $fileData = base64_decode($img);
            $fileName = uniqid().'.png';

            file_put_contents(WWW_ROOT."files/contratos/".$anioFirmarContrato.'/'.$fileName, $fileData);

            if ($representante->vector_contratos != null)
            {
                $vector_contratos = json_decode($representante->vector_contratos, true);
            }
            
            $vector_contratos[$anioFirmarContrato] = 
                [
                    "imagen_firma" => $fileName,
                    "usuario" => $this->Auth->user('username'),
                    "ip" => $_POST["ip_cliente"],
                    "fecha_hora" => $fecha_hora_actual
                ];            

		    $representante->vector_contratos = json_encode($vector_contratos);

            if ($this->Parentsandguardians->save($representante)) 
            {
                return $this->redirect(['controller' => 'Students', 'action' => 'index']);
            } 
            else 
            {
                $this->Flash->error(__('Firma no guardada'));
            }
        }

        $this->set(compact('representante', 'idRepresentante', 'anioFirmarContrato'));
    }
    
    public function verificacionFirmarContrato($idRepresentante = null)
    {
        $indicadorFirmarContrato = 0;
        $anioFirmarContrato = 0;
        $verificacionFirmarContrato = [];
        $this->loadModel('Schools');
        $schools = $this->Schools->get(2);
        $this->loadModel('Studenttransactions');

        $matriculas = $this->Studenttransactions->find('all', 
            [
                'contain' => ['Students'],
                'conditions' => [['Studenttransactions.ano_escolar >=' => $schools->previous_year_registration, 'Studenttransactions.transaction_type' => 'Matrícula', 'Students.parentsandguardian_id' => $idRepresentante, 'Students.student_condition' => 'Regular']], 
                'order' => ['Students.id' => 'ASC']
            ]);
        
        foreach ($matriculas as $matricula)
        {
            if ($matricula->ano_escolar >= $schools->previous_year_registration)
            {
                if ($matricula->ano_escolar > $anioFirmarContrato)
                {
                    $indicadorFirmarContrato = 1;
                    $anioFirmarContrato = $matricula->ano_escolar;
                }
            }
        }
        $verificacionFirmarContrato = 
            [
                'indicadorFirmarContrato' => $indicadorFirmarContrato,
                'anioFirmarContrato' => $anioFirmarContrato
            ]; 
        return $verificacionFirmarContrato;
    }
    public function verificacionContratoFirmado($representante = null) 
    {
        $indicadorContratoFirmado = 0;
        $anioContratoFirmado = 0;
        $imagenFirma = '';
        $verificacionContratoFirmado = [];

        $this->loadModel('Schools');

        $schools = $this->Schools->get(2);

        $anioActualInscripción = $schools->current_year_registration;

        $vectorContratos = json_decode($representante->vector_contratos); 
        foreach ($vectorContratos as $indice => $vector)
        {
            if ($indice >= $anioActualInscripción)
            {
                $indicadorContratoFirmado = 1;
                $anioContratoFirmado = $indice;
                $imagenFirma = $vector->imagen_firma;
            }
        }

        $verificacionContratoFirmado['indicadorContratoFirmado'] = $indicadorContratoFirmado;
        $verificacionContratoFirmado['anioContratoFirmado'] = $anioContratoFirmado;
        $verificacionContratoFirmado['imagenFirma'] = $imagenFirma;
        
        return $verificacionContratoFirmado;
    }
}
