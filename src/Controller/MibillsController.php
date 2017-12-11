<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Mibills Controller
 *
 * @property \App\Model\Table\MibillsTable $Mibills
 */
class MibillsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $mibills = $this->paginate($this->Mibills);

        $this->set(compact('mibills'));
        $this->set('_serialize', ['mibills']);
    }

    /**
     * View method
     *
     * @param string|null $id Mibill id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mibill = $this->Mibills->get($id, [
            'contain' => []
        ]);

        $this->set('mibill', $mibill);
        $this->set('_serialize', ['mibill']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mibill = $this->Mibills->newEntity();
        if ($this->request->is('post')) {
            $mibill = $this->Mibills->patchEntity($mibill, $this->request->data);
            if ($this->Mibills->save($mibill)) {
                $this->Flash->success(__('The mibill has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The mibill could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('mibill'));
        $this->set('_serialize', ['mibill']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Mibill id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mibill = $this->Mibills->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mibill = $this->Mibills->patchEntity($mibill, $this->request->data);
            if ($this->Mibills->save($mibill)) {
                $this->Flash->success(__('The mibill has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The mibill could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('mibill'));
        $this->set('_serialize', ['mibill']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Mibill id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mibill = $this->Mibills->get($id);
        if ($this->Mibills->delete($mibill)) {
            $this->Flash->success(__('The mibill has been deleted.'));
        } else {
            $this->Flash->error(__('The mibill could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function migrateBills()
    {
        $this->loadModel('Bills');
        
        $miBills = $this->Mibills->find('all');
        
        $results = $miBills->toArray();

        foreach ($results as $result) 
        {
            $bill = $this->Bills->newEntity();
                
            $bill->parentsandguardian_id = 1;
                
            $bill->user_id = 1;
            
            $dateBill = substr($result->fecha, 6, 4);
                
            $dateBill .= "-";
                
            $dateBill .= substr($result->fecha, 3, 2);
                
            $dateBill .= "-";
    
            $dateBill .= substr($result->fecha, 0, 2);
            
            $bill->date_and_time = $dateBill;
                
            $bill->turn = 1;
                
            $bill->bill_number = $result->idd;
                
            $bill->identification = $result->ci;
                
            $bill->client = $result->nombre;
        
            $bill->tax_phone = $result->telefono;
                
            $bill->fiscal_address = $result->direccion; 
                
            $bill->amount = $result->total;
        
            $bill->amount_paid = $result->total;
        
            if ($result->status == "Ok")
            {
                $bill->annulled = 0;
            }
            else
            {
                $bill->annulled = 1;
            }

            $bill->date_annulled = 0;
                
            $bill->new_family = $result->new_family;
            
            $bill->invoice_migration = true;
        
            if (!($this->Bills->save($bill))) 
            {
                $this->Flash->error(__('La factura no pudo ser grabada: ' . $bill->bill_number));
            }
        }
    }
}