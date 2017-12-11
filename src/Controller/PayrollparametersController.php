<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Payrollparameters Controller
 *
 * @property \App\Model\Table\PayrollparametersTable $Payrollparameters
 */
class PayrollparametersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $payrollparameters = $this->paginate($this->Payrollparameters);

        $this->set(compact('payrollparameters'));
        $this->set('_serialize', ['payrollparameters']);
    }

    /**
     * View method
     *
     * @param string|null $id Payrollparameter id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payrollparameter = $this->Payrollparameters->get($id, [
            'contain' => []
        ]);

        $this->set('payrollparameter', $payrollparameter);
        $this->set('_serialize', ['payrollparameter']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payrollparameter = $this->Payrollparameters->newEntity();
        if ($this->request->is('post')) {
            $payrollparameter = $this->Payrollparameters->patchEntity($payrollparameter, $this->request->data);
            if ($this->Payrollparameters->save($payrollparameter)) {
                $this->Flash->success(__('The payrollparameter has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The payrollparameter could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('payrollparameter'));
        $this->set('_serialize', ['payrollparameter']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Payrollparameter id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payrollparameter = $this->Payrollparameters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payrollparameter = $this->Payrollparameters->patchEntity($payrollparameter, $this->request->data);
            if ($this->Payrollparameters->save($payrollparameter)) {
                $this->Flash->success(__('The payrollparameter has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The payrollparameter could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('payrollparameter'));
        $this->set('_serialize', ['payrollparameter']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Payrollparameter id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payrollparameter = $this->Payrollparameters->get($id);
        if ($this->Payrollparameters->delete($payrollparameter)) {
            $this->Flash->success(__('The payrollparameter has been deleted.'));
        } else {
            $this->Flash->error(__('The payrollparameter could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
