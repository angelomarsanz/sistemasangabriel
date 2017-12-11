<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\StudenttransactionsController;

/**
 * Rates Controller
 *
 * @property \App\Model\Table\RatesTable $Rates
 */
class RatesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $query = $this->Rates->find('all', ['order' => ['Rates.concept' => 'ASC', 'Rates.rate_year' => 'DESC', 'Rates.rate_month' => 'DESC']]);

        $this->set('rates', $this->paginate($query));

        $this->set(compact('rates'));
        $this->set('_serialize', ['rates']);
    }

    /**
     * View method
     *
     * @param string|null $id Rate id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rate = $this->Rates->get($id, [
            'contain' => []
        ]);

        $this->set('rate', $rate);
        $this->set('_serialize', ['rate']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $studentTransactions = new StudenttransactionsController();

        $rate = $this->Rates->newEntity();
        if ($this->request->is('post')) 
        {
            $rate = $this->Rates->patchEntity($rate, $this->request->data);
            if ($rate->concept == "Matrícula")
            {
                $studentTransactions->newRegistration($rate->amount, $rate->rate_year);   
            }
            elseif ($rate->concept == "Mensualidad")
            {
                $concept = 'Mensualidad';
                        
                $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
                   'order' => ['Rates.created' => 'DESC'] ]);

                $row = $lastRecord->first();
                
                $previousMonthlyPayment = $row->amount;

                $studentTransactions->newMonthlyPayment($row->amount, $rate->amount, $rate->rate_month, $rate->rate_year);   
            }
            if ($this->Rates->save($rate)) 
            {
                $this->Flash->success(__('La tarifa ha sido guardada'));

                return $this->redirect(['action' => 'index']);
            } 
            else 
            {
                $this->Flash->error(__('La tarifa no pudo ser guardada, intente de nuevo'));
            }
        }
        
        $this->set(compact('rate'));
        $this->set('_serialize', ['rate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rate id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rate = $this->Rates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rate = $this->Rates->patchEntity($rate, $this->request->data);
            if ($this->Rates->save($rate)) {
                $this->Flash->success(__('The rate has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rate could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('rate'));
        $this->set('_serialize', ['rate']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rate id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rate = $this->Rates->get($id);
        if ($this->Rates->delete($rate)) {
            $this->Flash->success(__('The rate has been deleted.'));
        } else {
            $this->Flash->error(__('The rate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}