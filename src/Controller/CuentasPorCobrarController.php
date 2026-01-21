<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CuentasPorCobrar Controller
 *
 * @property \App\Model\Table\CuentasPorCobrarTable $CuentasPorCobrar
 */
class CuentasPorCobrarController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $cuentasPorCobrar = $this->paginate($this->CuentasPorCobrar);

        $this->set(compact('cuentasPorCobrar'));
        $this->set('_serialize', ['cuentasPorCobrar']);
    }

    /**
     * View method
     *
     * @param string|null $id CuentaPorCobrar id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cuentaPorCobrar = $this->CuentasPorCobrar->get($id, [
            'contain' => []
        ]);

        $this->set('cuentaPorCobrar', $cuentaPorCobrar);
        $this->set('_serialize', ['cuentaPorCobrar']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;

        $cuentaPorCobrar = $this->CuentasPorCobrar->newEntity();
        $cuentaPorCobrar->requesting_user = $this->Auth->user('username');
        
        if ($this->CuentasPorCobrar->save($cuentaPorCobrar)) 
        {
            $lastRecord = $this->CuentasPorCobrar->find('all', ['conditions' => ['requesting_user' => $this->Auth->user('username')],
                'order' => ['CuentasPorCobrar.created' => 'DESC'] ]);

            $row = $lastRecord->first();
                
            $billId = $row['id'];

            return $billId;
        }
        else
        {
            $this->Flash->error(__('No se creó el registro de cuentas por cobrar, intente de nuevo'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id CuentaPorCobrar id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cuentaPorCobrar = $this->CuentasPorCobrar->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cuentaPorCobrar = $this->CuentasPorCobrar->patchEntity($cuentaPorCobrar, $this->request->data);
            if ($this->CuentasPorCobrar->save($cuentaPorCobrar)) {
                $this->Flash->success(__('The cuentaPorCobrar has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cuentaPorCobrar could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('cuentaPorCobrar'));
        $this->set('_serialize', ['cuentaPorCobrar']);
    }

    /**
     * Delete method
     *
     * @param string|null $id CuentaPorCobrar id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cuentaPorCobrar = $this->CuentasPorCobrar->get($id);
        if ($this->CuentasPorCobrar->delete($cuentaPorCobrar)) {
            $this->Flash->success(__('The cuentaPorCobrar has been deleted.'));
        } else {
            $this->Flash->error(__('The cuentaPorCobrar could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
