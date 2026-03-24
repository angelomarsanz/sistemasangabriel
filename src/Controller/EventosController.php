<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Eventos Controller
 *
 * @property \App\Model\Table\EventosTable $Eventos
 */
class EventosController extends AppController
{
	public function isAuthorized($user)
    {
		if(in_array($this->request->action, ['add']))
		{
			return true;
		}
        if ($user['role'] === 'Facturas')
        {
            if (in_array($this->request->action, ['index']))
            {
                return true;
            }				
        }
        return parent::isAuthorized($user);
    }
    
    public function index()
    {
        // Cadenas de texto a omitir en la descripción
        $cadenas_omitir = [
            'anuló',
            'modificó',
            'cambió',
            'ajustó',
            'recibo',
            'pedido',
        ];
    
        // Construir la condición 'NOT LIKE' para cada cadena
        // En lugar de un AND implícito, construimos un OR de negaciones
        $condiciones_negacion_descripcion = [];
        foreach ($cadenas_omitir as $cadena) {
            $condiciones_negacion_descripcion[] = ['Eventos.descripcion LIKE' => '%' . $cadena . '%'];
        }
    
        $this->paginate = [
            'contain' => ['Users'],
            // Usamos 'NOT' y un array de condiciones unidas por 'OR'
            'conditions' => [
                'NOT' => [
                    'OR' => $condiciones_negacion_descripcion
                ]
            ],
            'order' => ['Eventos.created' => 'DESC'] // Ordenamos por 'created' de forma descendente
        ];
    
        $eventos = $this->paginate($this->Eventos);
    
        $this->set(compact('eventos'));
        $this->set('_serialize', ['eventos']);
    }
    
    /**
     * View method
     *
     * @param string|null $id Evento id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $evento = $this->Eventos->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('evento', $evento);
        $this->set('_serialize', ['evento']);
    }
	
    public function add($tipoModulo = null, $nombreModulo = null, $nombreMetodo = null, $descripcion = null, $vectorExtra = null)
    {
		$this->autoRender = false;
		
		$vectorResultado = [];
		$vectorResultado['indicador'] = 0;
		$vectorResultado['mensaje'] = "Registro grabado exitosamente";
		$vectorResultado['id'] = 0;
		
        $evento = $this->Eventos->newEntity();
		
		$evento->user_id = $this->Auth->user('id');
		
		$evento->tipo_modulo = $tipoModulo;
		
		$evento->nombre_modulo = $nombreModulo;
		
		$evento->nombre_metodo = $nombreMetodo;
		
		$evento->descripcion = $descripcion;
				
		if (isset($vectorExtra))
		{
			$contadorVector = 1;
			
			foreach ($vectorExtra as $vectorExtras)
			{
				if ($contadorVector == 1)
				{
					$evento->columna_extra1 = $vectorExtras;
				}
				
				if ($contadorVector == 2)
				{
					$evento->columna_extra2 = $vectorExtras;
				}

				if ($contadorVector == 3)
				{
					$evento->columna_extra3 = $vectorExtras;
				}
				
				if ($contadorVector == 4)
				{
					$evento->columna_extra4 = $vectorExtras;
				}
				
				if ($contadorVector == 5)
				{
					$evento->columna_extra5 = $vectorExtras;
				}
				
				if ($contadorVector == 6)
				{
					$evento->columna_extra6 = $vectorExtras;
				}
				
				if ($contadorVector == 7)
				{
					$evento->columna_extra7 = $vectorExtras;
				}
				
				if ($contadorVector == 8)
				{
					$evento->columna_extra8 = $vectorExtras;
				}
				
				if ($contadorVector == 9)
				{
					$evento->columna_extra9 = $vectorExtras;
				}
				
				if ($contadorVector == 10)
				{
					$evento->columna_extra10 = $vectorExtras;
				}
				
				$contadorVector++;
			}
		}
				
		$evento->usuario_responsable = $this->Auth->user('username');
				
        if ($this->Eventos->save($evento))
		{
			$ultimoRegistro = $this->Eventos->find('all')
				->where(['usuario_responsable' => $this->Auth->user('username')])
				->order(['created' => 'DESC']);
				
			$contadorRegistros = $ultimoRegistro->count();
			
			if ($contadorRegistros > 0)
			{
				$nuevoEvento = $ultimoRegistro->first();
			
				if ($nuevoEvento)
				{
					$vectorResultado['id'] = $nuevoEvento->id;
				}
			}
			else
			{
				$nuevoEvento['indicador'] = 1;
				$arrayResult['mensaje'] = "No se encontró el registro del evento";				
			}
		}
		else
		{
			$nuevoEvento['indicador'] = 1;
			$arrayResult['mensaje'] = "No se pudo grabar el registro";
		}
	
		return $vectorResultado;
    }

    /**
     * Edit method
     *
     * @param string|null $id Evento id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $evento = $this->Eventos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $evento = $this->Eventos->patchEntity($evento, $this->request->data);
            if ($this->Eventos->save($evento)) {
                $this->Flash->success(__('The evento has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The evento could not be saved. Please, try again.'));
            }
        }
        $users = $this->Eventos->Users->find('list', ['limit' => 200]);
        $this->set(compact('evento', 'users'));
        $this->set('_serialize', ['evento']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Evento id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $evento = $this->Eventos->get($id);
        if ($this->Eventos->delete($evento)) {
            $this->Flash->success(__('The evento has been deleted.'));
        } else {
            $this->Flash->error(__('The evento could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
