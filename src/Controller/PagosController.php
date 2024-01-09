<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\HistoricotasasController;

use Cake\I18n\Time;

/**
 * Pagos Controller
 *
 * @property \App\Model\Table\PagosTable $Pagos
 */
class PagosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $pagos = $this->paginate($this->Pagos);

        $this->set(compact('pagos'));
        $this->set('_serialize', ['pagos']);
    }

    /**
     * View method
     *
     * @param string|null $id Pago id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pago = $this->Pagos->get($id, [
            'contain' => []
        ]);

        $this->set('pago', $pago);
        $this->set('_serialize', ['pago']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pago = $this->Pagos->newEntity();
        if ($this->request->is('post')) {
            $pago = $this->Pagos->patchEntity($pago, $this->request->data);
            if ($this->Pagos->save($pago)) {
                $this->Flash->success(__('El pago ha sido registrado.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('El pago no pudo ser registrado. Por favor intente otra vez'));
            }
        }
        $this->set(compact('pago'));
        $this->set('_serialize', ['pago']);
    }

    public function agregarPago($idTurno = null, $identificadorFactura = null, $vectorPago = null)
    {
        $codigoRetorno = 0;
        $pagos = $this->Pagos->find('all', ['conditions' => ['identificador_factura' => $identificadorFactura]]);
        if ($pagos->count() > 0)
        {
            $pago = $pagos->first();
        }
        else
        {
            $pago = $this->Pagos->newEntity();
        }
        $pago->turn_id = $idTurno;
        $pago->identificador_factura = $identificadorFactura;
        $pago->vector_pago = json_encode($vectorPago);   
        if (!($this->Pagos->save($pago))) 
        {
            $codigoRetorno = 1;
        }
        return $codigoRetorno;
    }

    /**
     * Edit method
     *
     * @param string|null $id Pago id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pago = $this->Pagos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pago = $this->Pagos->patchEntity($pago, $this->request->data);
            if ($this->Pagos->save($pago)) {
                $this->Flash->success(__('El pago fue actualizado.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('El pago no pudo ser actualizado, por favor, intente otra vez.'));
            }
        }
        $this->set(compact('pago'));
        $this->set('_serialize', ['pago']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Pago id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pago = $this->Pagos->get($id);
        if ($this->Pagos->delete($pago)) {
            $this->Flash->success(__('El pago no pudo ser eliminado'));
        } else {
            $this->Flash->error(__('El pago no pudo ser eliminado'));
        }

        return $this->redirect(['action' => 'index']);
    }	
}