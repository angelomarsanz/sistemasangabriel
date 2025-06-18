<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NotaAnulacionPedidos Controller
 *
 * @property \App\Model\Table\NotaAnulacionPedidosTable $NotaAnulacionPedidos
 */
class NotaAnulacionPedidosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $notaAnulacionPedidos = $this->paginate($this->NotaAnulacionPedidos);

        $this->set(compact('notaAnulacionPedidos'));
        $this->set('_serialize', ['notaAnulacionPedidos']);
    }

    /**
     * View method
     *
     * @param string|null $id notaAnulacionPedido id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notaAnulacionPedido = $this->NotaAnulacionPedidos->get($id, [
            'contain' => []
        ]);

        $this->set('notaAnulacionPedido', $notaAnulacionPedido);
        $this->set('_serialize', ['notaAnulacionPedido']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;

        $notaAnulacionPedido = $this->NotaAnulacionPedidos->newEntity();
		
        $notaAnulacionPedido->usuario_solicitante = $this->Auth->user('username');
        
        if ($this->NotaAnulacionPedidos->save($notaAnulacionPedido)) 
        {
            $numerosNota = $this->NotaAnulacionPedidos->find('all', ['conditions' => ['usuario_solicitante' => $this->Auth->user('username')],
                'order' => ['created' => 'DESC'] ]);
				
			$contadorRegistros = $numerosNota->count();
			
			if ($contadorRegistros > 0)
			{
				$ultimoNumero = $numerosNota->first();
                			
				$numeroNota = $ultimoNumero->id;

				return $numeroNota;
			}
			else
			{
				$this->Flash->error(__('No se encontraron números de nota de débito para este usuario'));
			}
        }
        else
        {
            $this->Flash->error(__('No se generó el número consecutivo de la nota. Por favor intente de nuevo'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id notaAnulacionPedido id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notaAnulacionPedido = $this->NotaAnulacionPedidos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notaAnulacionPedido = $this->NotaAnulacionPedidos->patchEntity($notaAnulacionPedido, $this->request->data);
            if ($this->NotaAnulacionPedidos->save($notaAnulacionPedido)) {
                $this->Flash->success(__('The notaAnulacionPedido has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The notaAnulacionPedido could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('notaAnulacionPedido'));
        $this->set('_serialize', ['notaAnulacionPedido']);
    }

    /**
     * Delete method
     *
     * @param string|null $id notaAnulacionPedido id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notaAnulacionPedido = $this->NotaAnulacionPedidos->get($id);
        if ($this->NotaAnulacionPedidos->delete($notaAnulacionPedido)) {
            $this->Flash->success(__('The notaAnulacionPedido has been deleted.'));
        } else {
            $this->Flash->error(__('The notaAnulacionPedido could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
