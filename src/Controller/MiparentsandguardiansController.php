<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Miparentsandguardians Controller
 *
 * @property \App\Model\Table\MiparentsandguardiansTable $Miparentsandguardians
 */
class MiparentsandguardiansController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $miparentsandguardians = $this->paginate($this->Miparentsandguardians);

        $this->set(compact('miparentsandguardians'));
        $this->set('_serialize', ['miparentsandguardians']);
    }

    /**
     * View method
     *
     * @param string|null $id Miparentsandguardian id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $miparentsandguardian = $this->Miparentsandguardians->get($id, [
            'contain' => []
        ]);

        $this->set('miparentsandguardian', $miparentsandguardian);
        $this->set('_serialize', ['miparentsandguardian']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $miparentsandguardian = $this->Miparentsandguardians->newEntity();
        if ($this->request->is('post')) {
            $miparentsandguardian = $this->Miparentsandguardians->patchEntity($miparentsandguardian, $this->request->data);
            if ($this->Miparentsandguardians->save($miparentsandguardian)) {
                $this->Flash->success(__('The miparentsandguardian has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The miparentsandguardian could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('miparentsandguardian'));
        $this->set('_serialize', ['miparentsandguardian']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Miparentsandguardian id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $miparentsandguardian = $this->Miparentsandguardians->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $miparentsandguardian = $this->Miparentsandguardians->patchEntity($miparentsandguardian, $this->request->data);
            if ($this->Miparentsandguardians->save($miparentsandguardian)) {
                $this->Flash->success(__('The miparentsandguardian has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The miparentsandguardian could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('miparentsandguardian'));
        $this->set('_serialize', ['miparentsandguardian']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Miparentsandguardian id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $miparentsandguardian = $this->Miparentsandguardians->get($id);
        if ($this->Miparentsandguardians->delete($miparentsandguardian)) {
            $this->Flash->success(__('The miparentsandguardian has been deleted.'));
        } else {
            $this->Flash->error(__('The miparentsandguardian could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function migrateParentsandguardians()
    {
        $this->loadModel('Users');

        $this->loadModel('Parentsandguardians');

        $miParentsAndGuardians = $this->Miparentsandguardians->find('all');
            
        $results = $miParentsAndGuardians->toArray();

        $accountantRecords1 = 0; 
        $accountantRecords2 = 0; 
        
        foreach ($results as $result) 
        {
            $noRecord = 0;
            $identidyCard = 0; 

            if ($result->id != 1)
            {
                if ($result->identidy_card == "0")
                {
                    $noRecord = 1;
                    $accountantRecords1++;
                }
                elseif ($result->identidy_card == "11" || $result->identidy_card == "102299713" || 
                    $result->identidy_card == "130034666" || $result->identidy_card == "150000084" ||
                    $result->identidy_card == "D" || $result->identidy_card == "Desconocido" ||
                    $result->identidy_card == "desconocido" || $result->identidy_card == "V-000000" ||
                    $result->identidy_card == "V-1128416656" || $result->identidy_card == "V-151898887" || 
                    $result->identidy_card == "V-151898887" || $result->identidy_card == "V-D" ||
                    $result->identidy_card == "V-135026288")
                {
                    $noRecord = 1;
                    $accountantRecords2++;
                }
                elseif ($result->identidy_card == "19.523.434")
                {
                    $identidyCard = 19523434;
                }
                elseif ($result->identidy_card == "V-11.754.211")
                {
                    $identidyCard = 11754211;
                }
                elseif (substr($result->identidy_card, 0, 2) == "V-" || substr($result->identidy_card, 0, 2) == "v-")
                {
                    $identidyCard = substr($result->identidy_card, 2);
                }
                elseif (substr($result->identidy_card, 0, 2) == "E-")
                {
                    $identidyCard = substr($result->identidy_card, 2);
                }
                else
                {
                    $identidyCard = $result->identidy_card;
                }

                if ($noRecord == 0)
                {
                    $user = $this->Users->newEntity();
                
                    $user->username = $identidyCard;
                    
                    $user->password = "sga40";
    
                    $user->role = "Representante";
    
                    $user->first_name = $result->first_name;
    
                    $user->second_name = " ";
                    
                    $user->surname = $result->surname;
                    
                    $user->second_surname = " ";
                    
                    $user->sex = $result->sex;
                    
                    $user->email = $identidyCard . "@correo";
                    
                    $user->cell_phone = $result->cell_phone;
                
                    if (!($this->Users->save($user))) 
                    {
                        $this->Flash->error(__('El usuario no fue guardado ' . $user->username));
                    }
                    else
                    {
                        $lastRecord = $this->Users->find('all', ['conditions' => ['username' => $user->username], 'order' => ['Users.created' => 'DESC'] ]);
                
                        $row = $lastRecord->first();
                        
                        $parentsandguardian = $this->Parentsandguardians->get($result->id);
                        
                        $parentsandguardian->user_id = $row['id'];
                        
                        if (!($this->Parentsandguardians->save($parentsandguardian))) 
                        {
                            $this->Flash->error(__('El padre o representante no pudo ser actualizado: ' . $parentsandguardian->first_name . ' ' . $parentsandguardian->surname));
                        }
                    }
                }
            }
/*
            if ($result->id == 5)
            {
                break;
            }
*/
        }
        echo "Total registros no grabados cédula 0: " . $accountantRecords1;
        echo "Total registros no grabados otros casos: " . $accountantRecords2;
    }
    public function reverseMigrate()
    {
        $this->loadModel('Users');

        $this->loadModel('Parentsandguardians');

        $miParentsAndGuardians = $this->Miparentsandguardians->find('all');
            
        $results = $miParentsAndGuardians->toArray();

        $accountantRecords1 = 0; 
        $accountantRecords2 = 0; 

        foreach ($results as $result) 
        {
            $noRecord = 0;
            $identidyCard = 0; 

            if ($result->id != 1)
            {
                if ($result->identidy_card == "0")
                {
                    $noRecord = 1;
                    $accountantRecords1++;
                }
                elseif ($result->identidy_card == "11" || $result->identidy_card == "102299713" || 
                    $result->identidy_card == "130034666" || $result->identidy_card == "150000084" ||
                    $result->identidy_card == "D" || $result->identidy_card == "Desconocido" ||
                    $result->identidy_card == "desconocido" || $result->identidy_card == "V-000000" ||
                    $result->identidy_card == "V-1128416656" || $result->identidy_card == "V-151898887" || 
                    $result->identidy_card == "V-151898887" || $result->identidy_card == "V-D" ||
                    $result->identidy_card == "V-135026288")
                {
                    $noRecord = 1;
                    $accountantRecords2++;
                }
                elseif ($result->identidy_card == "19.523.434")
                {
                    $identidyCard = 19523434;
                }
                elseif ($result->identidy_card == "V-11.754.211")
                {
                    $identidyCard = 11754211;
                }
                elseif (substr($result->identidy_card, 0, 2) == "V-" || substr($result->identidy_card, 0, 2) == "v-")
                {
                    $identidyCard = substr($result->identidy_card, 2);
                }
                else
                {
                    $identidyCard = $result->identidy_card;
                }
                
                if ($noRecord == 0)
                {
                    $parentsandguardian = $this->Parentsandguardians->get($result->id);
                        
                    $idUser = $parentsandguardian->user_id;
                    
                    $parentsandguardian->user_id = 2;
                        
                    if (!($this->Parentsandguardians->save($parentsandguardian))) 
                    {
                        $this->Flash->error(__('El padre o representante no pudo ser actualizado: ' . $parentsandguardian->first_name . ' ' . $parentsandguardian->surname));
                    }
                    else
                    {
                        if ($idUser != 2)
                        {
                            $user = $this->Users->get($idUser);
                            if (!($this->Users->delete($user))) 
                            {
                                $this->Flash->error(__('El usuario no pudo ser eliminado'));
                            }
                        }
                    }
                }
            }
/*
            if ($result->id == 5)
            {
                break;
            }
*/
        }
        echo "Total registros no grabados cédula 0: " . $accountantRecords1;
        echo "Total registros no grabados otros casos: " . $accountantRecords2;
    }
}