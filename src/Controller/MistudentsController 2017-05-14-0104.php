<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Mistudents Controller
 *
 * @property \App\Model\Table\MistudentsTable $Mistudents
 */
class MistudentsController extends AppController
{
    public $student = " ";
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $mistudents = $this->paginate($this->Mistudents);

        $this->set(compact('mistudents'));
        $this->set('_serialize', ['mistudents']);
    }

    /**
     * View method
     *
     * @param string|null $id Mistudent id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mistudent = $this->Mistudents->get($id, [
            'contain' => []
        ]);

        $this->set('mistudent', $mistudent);
        $this->set('_serialize', ['mistudent']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mistudent = $this->Mistudents->newEntity();
        if ($this->request->is('post')) {
            $mistudent = $this->Mistudents->patchEntity($mistudent, $this->request->data);
            if ($this->Mistudents->save($mistudent)) {
                $this->Flash->success(__('The mistudent has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The mistudent could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('mistudent'));
        $this->set('_serialize', ['mistudent']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Mistudent id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mistudent = $this->Mistudents->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mistudent = $this->Mistudents->patchEntity($mistudent, $this->request->data);
            if ($this->Mistudents->save($mistudent)) {
                $this->Flash->success(__('The mistudent has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The mistudent could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('mistudent'));
        $this->set('_serialize', ['mistudent']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Mistudent id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mistudent = $this->Mistudents->get($id);
        if ($this->Mistudents->delete($mistudent)) {
            $this->Flash->success(__('The mistudent has been deleted.'));
        } else {
            $this->Flash->error(__('The mistudent could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function migrateStudents()
    {
        $this->loadModel('Parentsandguardians');
        
        $this->loadModel('Students');
        
        $this->loadModel('Studenttransactions');
        
        $this->student = $this->Students->newEntity();

        $this->student->user_id = 3;

        $this->student->parentsandguardian_id = 1;
        
        $this->student->first_name = "Alumno";
        
        $this->student->second_name = "Colegio";

        $this->student->surname = "San";

        $this->student->second_surname = "Gabriel";
        
        $this->student->section_id = 1;
        
        $this->student->mi_id = 1;
        
        $this->student->student_migration = 0;
        
        if (!($this->Students->save($this->student))) 
        {
            $this->Flash->error(__('El alumno no fue guardado ' . $this->student->mi_id));
        }
        else
        {
            $miStudents = $this->Mistudents->find('all')->order(['Mistudents.familia' => 'ASC']);
            
            $results = $miStudents->toArray();
            
            $newFamily = " "; 
    
            foreach ($results as $result) 
            {
                if ($result->familia != $newFamily)
                {
                    $lastRecord = $this->Parentsandguardians->find('all', ['conditions' => ['mi_id' => $result->familia],
                    'order' => ['Parentsandguardians.created' => 'DESC'] ]);
    
                    $row = $lastRecord->first();
                    if (!(isset($row)))
                    {
                        echo "Familia no encontrada: " . $result->familia;
                    }
                    $newFamily = $result->familia;  
                }
    
                $this->student = $this->Students->newEntity();
    
                $this->student->user_id = 3;
    
                $this->student->parentsandguardian_id = $row->id;
                    
                $this->student->identity_card = $result->id;
    
                $this->separateNameStudent($result->nombres);
                
                $this->separateSurnameStudent($result->apellidos);
                
                $this->student->sex = $result->sexo;
                
                $birthdate = substr($result->nacimiento, 6, 4);
                
                $birthdate .= "-";
                
                $birthdate .= substr($result->nacimiento, 3, 2);
                
                $birthdate .= "-";
    
                $birthdate .= substr($result->nacimiento, 0, 2);
                            
                $this->student->birthdate = $birthdate;
                
                $this->student->address = $result->direccion;
                
                $levelSection = $result->grado . ' ' . $result->seccion;
                
                switch ($levelSection) 
                {
                    case "Kinder A":
                        $this->student->section_id = 2;
                        break;
                    case "Kinder B":
                        $this->student->section_id = 3;
                        break;
                    case "Kinder C":
                        $this->student->section_id = 4;
                        break;
                    case "Pre Kinder A":
                        $this->student->section_id = 5;
                        break;
                    case "Pre Kinder B":
                        $this->student->section_id = 6;
                        break;
                    case "Pre Kinder C":
                        $this->student->section_id = 7;
                        break;
                    case "Preparatorio A":
                        $this->student->section_id = 8;
                        break;
                    case "Preparatorio B":
                        $this->student->section_id = 9;
                        break;
                    case "Preparatorio C":
                        $this->student->section_id = 10;
                        break;
                    case "1er Grado A":
                        $this->student->section_id = 11;
                        break;
                    case "1er Grado B":
                        $this->student->section_id = 12;
                        break;
                    case "1er Grado C":
                        $this->student->section_id = 13;
                        break;
                    case "2do Grado A":
                        $this->student->section_id = 14;
                        break;
                    case "2do Grado B":
                        $this->student->section_id = 15;
                        break;
                    case "2do Grado C":
                        $this->student->section_id = 16;
                        break;
                    case "3er Grado A":
                        $this->student->section_id = 17;
                        break;
                    case "3er Grado B":
                        $this->student->section_id = 18;
                        break;
                    case "3er Grado C":
                        $this->student->section_id = 19;
                        break;
                    case "4to Grado A":
                        $this->student->section_id = 20;
                        break;
                    case "4to Grado B":
                        $this->student->section_id = 21;
                        break;
                    case "4to Grado C":
                        $this->student->section_id = 22;
                        break;
                    case "5to Grado A":
                        $this->student->section_id = 23;
                        break;
                    case "5to Grado B":
                        $this->student->section_id = 24;
                        break;
                    case "5to Grado C":
                        $this->student->section_id = 25;
                        break;
                    case "5DO GRADO A":
                        $this->student->section_id = 23;
                        break;
                    case "5DO GRADO B":
                        $this->student->section_id = 24;
                        break;
                    case "5DO GRADO C":
                        $this->student->section_id = 25;
                        break;
                    case "6to Grado A":
                        $this->student->section_id = 26;
                        break;
                    case "6to Grado B":
                        $this->student->section_id = 27;
                        break;
                    case "6to Grado C":
                        $this->student->section_id = 28;
                        break;
                    case "1er Año A":
                        $this->student->section_id = 29;
                        break;
                    case "1er Año B":
                        $this->student->section_id = 30;
                        break;
                    case "1er Año C":
                        $this->student->section_id = 31;
                        break;
                    case "2do Año A":
                        $this->student->section_id = 32;
                        break;
                    case "2do Año B":
                        $this->student->section_id = 33;
                        break;
                    case "2do Año C":
                        $this->student->section_id = 34;
                        break;
                    case "2TO AÑO A":
                        $this->student->section_id = 32;
                        break;
                    case "2TO AÑO B":
                        $this->student->section_id = 33;
                        break;
                    case "2TO AÑO C":
                        $this->student->section_id = 34;
                        break;
                    case "3er Año A":
                        $this->student->section_id = 35;
                        break;
                    case "3er Año B":
                        $this->student->section_id = 36;
                        break;
                    case "3er Año C":
                        $this->student->section_id = 37;
                        break;
                    case "4to Año A":
                        $this->student->section_id = 38;
                        break;
                    case "4to Año B":
                        $this->student->section_id = 39;
                        break;
                    case "4to Año C":
                        $this->student->section_id = 40;
                        break;
                    case "5to Año A":
                        $this->student->section_id = 41;
                        break;
                    case "5to Año B":
                        $this->student->section_id = 42;
                        break;
                    case "5to Año C":
                        $this->student->section_id = 43;
                        break;
                    default:
                        echo $levelSection;
                        break;
                }
                
                if ($result->condicion == "BACADO" || $result->condicion == "BECADA" || $result->condicion == "Becado")
                {
                    $this->student->scholarship = true;
                }
                
                $this->student->student_condition = $result->escolaridad;
                
                $this->student->first_name_father = $row->first_name_father;
                
                $this->student->second_name_father = $row->second_name_father;
    
                $this->student->surname_father = $row->surname_father;
                
                $this->student->second_surname_father = $row->second_surname_father;
    
                $this->student->first_name_mother = $row->first_name_mother;
                
                $this->student->second_name_mother = $row->second_name_mother;
    
                $this->student->surname_mother = $row->surname_mother;
                
                $this->student->second_surname_mother = $row->second_surname_mother;
    
                $this->student->profile_photo = "Sin foto";
                
                $this->student->profile_photo_dir = "Sin foto";
                
                $this->student->mi_id = $result->codigo;
                
                $this->student->balance = $result->mensualidad;
                    
                $this->student->new_student = $result->new_student;
                
                $this->student->student_migration = 1;
                
                if (!($this->Students->save($this->student))) 
                {
                    $this->Flash->error(__('El alumno no fue guardado ' . $this->student->mi_id));
                }
                else
                {
                    $lastStudent = $this->Students->find('all', ['conditions' => ['mi_id' => $result->codigo], 
                        'order' => ['Students.created' => 'DESC'] ]);
    
                    $rowStudent = $lastStudent->first();
    
                    if ($result->new_student == true)
                    {
                        $this->recordQuotas($rowStudent->id, "Matrícula", "Matrícula 2017", 30000, 30000);
        
                        $this->recordQuotas($rowStudent->id, "Servicio educativo", "Servicio educativo 2017", 240000, 240000);
    
                        $this->recordQuotas($rowStudent->id, "Mensualidad", "Ago 2018", 30000, 30000);
                    }
                    else
                    {
                        $this->recordQuotas($rowStudent->id, "Matrícula", "Matrícula 2016", $result->saldo, $result->mensualidad);

                        $this->recordQuotas($rowStudent->id, "Mensualidad", "Ago 2017", $result->ago, $result->mensualidad);

                        $this->recordQuotas($rowStudent->id, "Mensualidad", "Sep 2016", $result->sep, $result->mensualidad);
        
                        $this->recordQuotas($rowStudent->id, "Mensualidad", "Oct 2016", $result->oct, $result->mensualidad);
        
                        $this->recordQuotas($rowStudent->id, "Mensualidad", "Nov 2016", $result->nov, $result->mensualidad);
        
                        $this->recordQuotas($rowStudent->id, "Mensualidad", "Dic 2016", $result->dic, $result->mensualidad);
        
                        $this->recordQuotas($rowStudent->id, "Mensualidad", "Ene 2017", $result->ene, $result->mensualidad);
        
                        $this->recordQuotas($rowStudent->id, "Mensualidad", "Feb 2017", $result->feb, $result->mensualidad);
        
                        $this->recordQuotas($rowStudent->id, "Mensualidad", "Mar 2017", $result->mar, $result->mensualidad);
        
                        $this->recordQuotas($rowStudent->id, "Mensualidad", "Abr 2017", $result->abr, $result->mensualidad);
        
                        $this->recordQuotas($rowStudent->id, "Mensualidad", "May 2017", $result->may, $result->mensualidad);
        
                        $this->recordQuotas($rowStudent->id, "Mensualidad", "Jun 2017", $result->jun, $result->mensualidad);
        
                        $this->recordQuotas($rowStudent->id, "Mensualidad", "Jul 2017", $result->jul, $result->mensualidad);
                    }
                }
            }
        }
    }
    
    public function separateNameStudent($nombres)
    {

        $this->student->first_name = $nombres;
        $this->student->second_name = " ";

/*
        $name = explode(" ", $nombres);
 
        if (isset($name[3]))
        {
            $this->student->first_name = $name[0] . " " . $name[1];
            $this->student->second_name = $name[2] . " " . $name[3];
        }
        elseif (isset($name[2]))
        {
            $this->student->first_name = $name[0] . " " . $name[1];
            $this->student->second_name = $name[2];
        }
        elseif (isset($name[1]))
        {
            $this->student->first_name = $name[0];
            $this->student->second_name = $name[1];
        }
        else
        {
            $this->student->first_name = $name[0];
        }
*/
    }
    
    public function separateSurnameStudent($apellidos)
    {
        
        $this->student->surname = $apellidos;
        $this->student->second_surname = " ";

/*
        $surname = explode(" ", $apellidos);
            
        if (isset($surname[3]))
        {
            $this->student->surname = $surname[0] . " " . $surname[1];
            $this->student->second_surname = $surname[2] . " " . $surname[3];
        }
        elseif (isset($surname[2]))
        {
            $this->student->surname = $surname[0] . " " . $surname[1];
            $this->student->second_surname = $surname[2];
        }
        elseif (isset($surname[1]))
        {
            $this->student->surname = $surname[0];
            $this->student->second_surname = $surname[1];
        }
        else
        {
            $this->student->surname = $surname[0];
        }
*/
    }
    
    public function recordQuotas($idStudent = null, $transactionType = null, $transactionDescription = null, $amount = null, $originalAmount = null)
    {
        $studenttransaction = $this->Studenttransactions->newEntity();
        
        $studenttransaction->student_id = $idStudent;
        
        $studenttransaction->transaction_type = $transactionType;
        $studenttransaction->transaction_description = $transactionDescription;
        $studenttransaction->amount = $amount;
        $studenttransaction->original_amount = $originalAmount;
        $studenttransaction->invoiced = 0;
        $studenttransaction->partial_payment = 0;
        
        if ($amount == 0)
        {
            $studenttransaction->paid_out = 1;
        }
        else
        {
            $studenttransaction->paid_out = 0;
        }
        
        $studenttransaction->bill_number = 0;
        
        $studenttransaction->transaction_migration = true;
        
        if (!($this->Studenttransactions->save($studenttransaction)))  
        {
            $this->Flash->error(__('La cuota del estudiante no fue guardada'));
            break;
        }
    }
}