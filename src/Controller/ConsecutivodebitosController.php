<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Consecutivodebitos Controller
 *
 * @property \App\Model\Table\ConsecutivodebitosTable $Consecutivodebitos
 */
class ConsecutivodebitosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $consecutivodebitos = $this->paginate($this->Consecutivodebitos);

        $this->set(compact('consecutivodebitos'));
        $this->set('_serialize', ['consecutivodebitos']);
    }

    /**
     * View method
     *
     * @param string|null $id Consecutivodebito id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $consecutivodebito = $this->Consecutivodebitos->get($id, [
            'contain' => []
        ]);

        $this->set('consecutivodebito', $consecutivodebito);
        $this->set('_serialize', ['consecutivodebito']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;

        $consecutivoDebito = $this->Consecutivodebitos->newEntity();
		
        $consecutivoDebito->usuario_solicitante = $this->Auth->user('username');
        
        if ($this->Consecutivodebitos->save($consecutivoDebito)) 
        {
            $numerosNota = $this->Consecutivodebitos->find('all', ['conditions' => ['usuario_solicitante' => $this->Auth->user('username')],
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
     * @param string|null $id Consecutivodebito id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $consecutivodebito = $this->Consecutivodebitos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consecutivodebito = $this->Consecutivodebitos->patchEntity($consecutivodebito, $this->request->data);
            if ($this->Consecutivodebitos->save($consecutivodebito)) {
                $this->Flash->success(__('The consecutivodebito has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The consecutivodebito could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('consecutivodebito'));
        $this->set('_serialize', ['consecutivodebito']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Consecutivodebito id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consecutivodebito = $this->Consecutivodebitos->get($id);
        if ($this->Consecutivodebitos->delete($consecutivodebito)) {
            $this->Flash->success(__('The consecutivodebito has been deleted.'));
        } else {
            $this->Flash->error(__('The consecutivodebito could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
