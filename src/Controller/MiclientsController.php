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

        $this->parentsandguardian = $this->Parentsandguardians->newEntity();
            
        $this->parentsandguardian->user_id = 3;
        
        $this->parentsandguardian->first_name = "Representante";
        
        $this->parentsandguardian->second_name = "Colegio";

        $this->parentsandguardian->surname = "San";

        $this->parentsandguardian->second_surname = "Gabriel";

        $this->parentsandguardian->mi_id = 0;
        
        $this->parentsandguardian->guardian_migration = 0;

        if (!($this->Parentsandguardians->save($this->parentsandguardian))) 
        {
            $this->Flash->error(__('El padre o representante no fue guardado ' . $this->parentsandguardian->family . $this->parentsandguardian->mi_id));
        }
        else
        {
            $miClients = $this->Miclients->find('all');
            
            $results = $miClients->toArray();
            
            foreach ($results as $result) 
            {
                $this->parentsandguardian = $this->Parentsandguardians->newEntity();
                
                $this->parentsandguardian->user_id = 3;
                
                $this->parentsandguardian->family = $result->familia;
                
                if (substr($result->cimadre, 0, 2) == "V-" || substr($result->cimadre, 0, 2) == "v-")
                {
                    $this->parentsandguardian->type_of_identification_mother = "V";
                    $this->parentsandguardian->type_of_identification = "V";

                    $this->parentsandguardian->identidy_card_mother = substr($result->cimadre, 2);
                    $this->parentsandguardian->identidy_card = substr($result->cimadre, 2);
                }
                elseif (substr($result->cimadre, 0, 2) == "E-")
                {
                    $this->parentsandguardian->type_of_identification_mother = "E";
                    $this->parentsandguardian->type_of_identification = "E";

                    $this->parentsandguardian->identidy_card_mother = substr($result->cimadre, 2);
                    $this->parentsandguardian->identidy_card = substr($result->cimadre, 2);
                }
                else
                {
                    $this->parentsandguardian->identidy_card_mother = $result->cimadre;
                    $this->parentsandguardian->identidy_card = $result->cimadre;
                }
                
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
                
                $this->parentsandguardian->guardian_migration = 1;

                if (!($this->Parentsandguardians->save($this->parentsandguardian))) 
                {
                    $this->Flash->error(__('El padre o representante no fue guardado ' . $this->parentsandguardian->family . " " . $this->parentsandguardian->mi_id));
                }
            }
        }
    }
    
    public function separateNameMother($nomadre)
    {
        $this->parentsandguardian->first_name = $nomadre;
        $this->parentsandguardian->second_name = " ";
        $this->parentsandguardian->first_name_mother = $nomadre;
        $this->parentsandguardian->second_name_mother = " ";

/*
        $name = explode(" ", $nomadre);

        if (isset($name[3]))
        {
            $this->parentsandguardian->first_name = $name[0] . " " . $name[1];
            $this->parentsandguardian->second_name = $name[2] . " " . $name[3];
            
            $this->parentsandguardian->first_name_mother = $name[0] . " " . $name[1];
            $this->parentsandguardian->second_name_mother = $name[2] . " " . $name[3];
        }
        elseif (isset($name[2]))
        {
            $this->parentsandguardian->first_name = $name[0] . " " . $name[1];
            $this->parentsandguardian->second_name = $name[2];
            
            $this->parentsandguardian->first_name_mother = $name[0] . " " . $name[1];
            $this->parentsandguardian->second_name_mother = $name[2];
        }
        elseif (isset($name[1]))
        {
            $this->parentsandguardian->first_name = $name[0];
            $this->parentsandguardian->second_name = $name[1];
            
            $this->parentsandguardian->first_name_mother = $name[0];
            $this->parentsandguardian->second_name_mother = $name[1];
        }
        else
        {
            $this->parentsandguardian->first_name = $name[0];
            $this->parentsandguardian->first_name_mother = $name[0];
        }
*/
    }
    
    public function separateSurnameMother($apmadre)
    {
            $this->parentsandguardian->surname = $apmadre;
            $this->parentsandguardian->second_surname = " ";
            
            $this->parentsandguardian->surname_mother = $apmadre;
            $this->parentsandguardian->second_surname_mother = " ";
        
/*
        $surname = explode(" ", $apmadre);
        
        if (isset($surname[3]))
        {
            $this->parentsandguardian->surname = $surname[0] . " " . $surname[1];
            $this->parentsandguardian->second_surname = $surname[2] . " " . $surname[3];
            
            $this->parentsandguardian->surname_mother = $surname[0] . " " . $surname[1];
            $this->parentsandguardian->second_surname_mother = $surname[2] . " " . $surname[3];
        }
        elseif (isset($surname[2]))
        {
            $this->parentsandguardian->surname = $surname[0] . " " . $surname[1];
            $this->parentsandguardian->second_surname = $surname[2];
            
            $this->parentsandguardian->surname_mother = $surname[0] . " " . $surname[1];
            $this->parentsandguardian->second_surname_mother = $surname[2];
        }
        elseif (isset($surname[1]))
        {
            $this->parentsandguardian->surname = $surname[0];
            $this->parentsandguardian->second_surname = $surname[1];
            
            $this->parentsandguardian->surname_mother = $surname[0];
            $this->parentsandguardian->second_surname_mother = $surname[1];
        }
        else
        {
            $this->parentsandguardian->surname = $surname[0];
            $this->parentsandguardian->surname_mother = $surname[0];
        }
*/
    }

    public function separateNameFather($nopadre)
    {
            $this->parentsandguardian->first_name_father = $nopadre;
            $this->parentsandguardian->second_name_father = " ";

/*
        $name = explode(" ", $nopadre);
        
        if (isset($name[3]))
        {
            $this->parentsandguardian->first_name_father = $name[0] . " " . $name[1];
            $this->parentsandguardian->second_name_father = $name[2] . " " . $name[3];
        }
        elseif (isset($name[2]))
        {
            $this->parentsandguardian->first_name_father = $name[0] . " " . $name[1];
            $this->parentsandguardian->second_name_father = $name[2];
        }
        elseif (isset($name[1]))
        {
            $this->parentsandguardian->first_name_father = $name[0];
            $this->parentsandguardian->second_name_father = $name[1];
        }
        else
        {
            $this->parentsandguardian->first_name_father = $name[0];
        }
*/
    }
    
    public function separateSurnameFather($appadre)
    {
        $this->parentsandguardian->surname_father = $appadre;
        $this->parentsandguardian->second_surname_father = " ";
        
/*
        $surname = explode(" ", $appadre);
            
        if (isset($surname[3]))
        {
            $this->parentsandguardian->surname_father = $surname[0] . " " . $surname[1];
            $this->parentsandguardian->second_surname_father = $surname[2] . " " . $surname[3];
        }
        elseif (isset($surname[2]))
        {
            $this->parentsandguardian->surname_father = $surname[0] . " " . $surname[1];
            $this->parentsandguardian->second_surname_father = $surname[2];
        }
        elseif (isset($surname[1]))
        {
            $this->parentsandguardian->surname_father = $surname[0];
            $this->parentsandguardian->second_surname_father = $surname[1];
        }
        else
        {
            $this->parentsandguardian->surname_father = $surname[0];
        }
*/
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