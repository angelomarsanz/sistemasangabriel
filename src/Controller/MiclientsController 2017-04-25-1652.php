<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Miclients Controller
 *
 * @property \App\Model\Table\MiclientsTable $Miclients
 */
class MiclientsController extends AppController
{
    public $parentsandguardian = " ";
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $miclients = $this->paginate($this->Miclients);

        $this->set(compact('miclients'));
        $this->set('_serialize', ['miclients']);
    }

    /**
     * View method
     *
     * @param string|null $id Miclient id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $miclient = $this->Miclients->get($id, [
            'contain' => []
        ]);

        $this->set('miclient', $miclient);
        $this->set('_serialize', ['miclient']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $miclient = $this->Miclients->newEntity();
        if ($this->request->is('post')) {
            $miclient = $this->Miclients->patchEntity($miclient, $this->request->data);
            if ($this->Miclients->save($miclient)) {
                $this->Flash->success(__('The miclient has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The miclient could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('miclient'));
        $this->set('_serialize', ['miclient']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Miclient id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $miclient = $this->Miclients->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $miclient = $this->Miclients->patchEntity($miclient, $this->request->data);
            if ($this->Miclients->save($miclient)) {
                $this->Flash->success(__('The miclient has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The miclient could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('miclient'));
        $this->set('_serialize', ['miclient']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Miclient id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $miclient = $this->Miclients->get($id);
        if ($this->Miclients->delete($miclient)) {
            $this->Flash->success(__('The miclient has been deleted.'));
        } else {
            $this->Flash->error(__('The miclient could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function migrateClients()
    {
        $this->loadModel('Parentsandguardians');
        
        $miClients = $this->Miclients->find('all');
        
        $results = $miClients->toArray();
        
        foreach ($results as $result) 
        {
            $this->parentsandguardian = $this->Parentsandguardians->newEntity();
            
            $this->parentsandguardian->user_id = 2;
            
            $this->parentsandguardian->family = $result->familia;
            
            $this->parentsandguardian->identidy_card_mother = $result->cimadre;

            $this->parentsandguardian->identidy_card = $result->cimadre;

            $this->separateNameMother($result->nomadre);
            
            $this->separateSurnameMother($result->apmadre);
            
            $this->parentsandguardian->sex = "F";

            $this->parentsandguardian->address_mother = $result->dirmadre;
            
            $this->parentsandguardian->address = $result->dirmadre;

            $this->checkEmailMother($result->emailmadre);

            $this->parentsandguardian->landline_mother = $result->telfmadre;
            
            $this->parentsandguardian->landline = $result->telfmadre;
            
            $this->parentsandguardian->cell_phone_mother = $result->celmadre;
            
            $this->parentsandguardian->cell_phone = $result->celmadre;
            
            $this->parentsandguardian->identidy_card_father = $result->cipadre;
            
            $this->separateNameFather($result->nopadre);
            
            $this->separateSurnameFather($result->appadre);
            
            $this->parentsandguardian->address_father = $result->dirpadre;
            
            $this->checkEmailFather($result->emailpadre);

            $this->parentsandguardian->landline_father = $result->telfpadre;

            $this->parentsandguardian->cell_phone_father = $result->celpadre;
            
            $this->parentsandguardian->client = $result->nombre;
            
            $this->parentsandguardian->identification_number_client = $result->ci;
            
            $this->parentsandguardian->fiscal_address = $result->direccion;
            
            $this->parentsandguardian->tax_phone = $result->telefono;
            
            $this->parentsandguardian->mi_id = $result->clave_familia;

            $this->parentsandguardian->mi_children = $result->hijos;

            $this->parentsandguardian->balance = $result->deuda;
            
            $this->parentsandguardian->new_guardian = $result->new_client;
            
            if (!($this->Parentsandguardians->save($this->parentsandguardian))) 
            {
                $this->Flash->error(__('El padre o representante no fue guardado ' . $this->parentsandguardian->family . $this->parentsandguardian->mi_id));
            }
        }
    }
    
    public function separateNameMother($nomadre)
    {
        $name = explode(" ", $nomadre);
            
        if (isset($name[0]))
        {
            $this->parentsandguardian->first_name = $name[0];
            $this->parentsandguardian->first_name_mother = $name[0];

        }
        if (isset($name[1]))
        {
            $this->parentsandguardian->second_name = $name[1];
            $this->parentsandguardian->second_name_mother = $name[1];
        }
        if (isset($name[2]))
        {
            $this->parentsandguardian->second_name .= " " . $name[2];
            $this->parentsandguardian->second_name_mother .= " " . $name[2];
        }
        if (isset($name[3]))
        {
            $this->parentsandguardian->second_name .= " " . $name[3];
            $this->parentsandguardian->second_name_mother .= " " . $name[3];
        }
    }
    
    public function separateSurnameMother($apmadre)
    {
        $surname = explode(" ", $apmadre);
            
        if (isset($surname[0]))
        {
            $this->parentsandguardian->surname = $surname[0];
            $this->parentsandguardian->surname_mother = $surname[0];
        }
        if (isset($surname[1]))
        {
            $this->parentsandguardian->second_surname = $surname[1];
            $this->parentsandguardian->second_surname_mother = $surname[1];
        }
        if (isset($surname[2]))
        {
            $this->parentsandguardian->second_surname .= " " . $surname[2];
            $this->parentsandguardian->second_surname_mother .= " " . $surname[2];
        }
        if (isset($surname[3]))
        {
            $this->parentsandguardian->second_surname .= " " . $surname[3];
            $this->parentsandguardian->second_surname_mother .= " " . $surname[3];
        }
    }

    public function separateNameFather($nopadre)
    {
        $name = explode(" ", $nopadre);
            
        if (isset($name[0]))
        {
            $this->parentsandguardian->first_name_father = $name[0];
        }
        if (isset($name[1]))
        {
            $this->parentsandguardian->second_name_father = $name[1];
        }
        if (isset($name[2]))
        {
            $this->parentsandguardian->second_name_father .= " " . $name[2];
        }
        if (isset($name[3]))
        {
            $this->parentsandguardian->second_name_father .= " " . $name[3];
        }
    }
    
    public function separateSurnameFather($appadre)
    {
        $surname = explode(" ", $appadre);
            
        if (isset($surname[0]))
        {
            $this->parentsandguardian->surname_father = $surname[0];
        }
        if (isset($surname[1]))
        {
            $this->parentsandguardian->second_surname_father = $surname[1];
        }
        if (isset($surname[2]))
        {
            $this->parentsandguardian->second_surname_father .= " " . $surname[2];
        }
        if (isset($surname[3]))
        {
            $this->parentsandguardian->second_surname_father .= " " . $surname[3];
        }
    }

    public function checkEmailMother($emailMother = null)
    {
        $at   = '@';
        
        $pos = strpos($emailMother, $at);

        if ($pos !== false) 
        {
            $this->parentsandguardian->email_mother = $emailMother;
            $this->parentsandguardian->email = $emailMother;
        }
    }

    public function checkEmailFather($emailFather = null)
    {
        $at   = '@';
        
        $pos = strpos($emailFather, $at);

        if ($pos !== false) 
        {
            $this->parentsandguardian->email_father = $emailFather;
        }
    }
}