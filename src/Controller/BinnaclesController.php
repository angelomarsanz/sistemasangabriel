<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\StudenttransactionsController;

use Cake\ORM\TableRegistry;

/**
 * Binnacles Controller
 *
 * @property \App\Model\Table\BinnaclesTable $Binnacles
 */
class BinnaclesController extends AppController
{
    public function isAuthorized($user)
    {
		if(in_array($this->request->action, ['add']))
		{
			return true;
		}
        return parent::isAuthorized($user);
    }
	
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */

    public function testFunction()
    {
        $transacciones = TableRegistry::get('Studenttransactions');

        $transaccionesActualizadas = 0;

        $transaccionesDecimales = $this->Binnacles->find('all');

        foreach ($transaccionesDecimales as $decimales)
        {
            $transaccionModificar = $transacciones->get($decimales->extra_column6);

            $anoModificacion = $transaccionModificar->modified->year;

            if ($transaccionModificar->modified->month < 10)
            {
                $mesModificacion = '0' . $transaccionModificar->modified->month;
            }
            else
            {
                $mesModificacion = $transaccionModificar->modified->month;
            }
            
            if ($transaccionModificar->modified->day < 10)
            {			
                $diaModificacion = '0' . $transaccionModificar->modified->day;
            }
            else
            {
                $diaModificacion = $transaccionModificar->modified->day;
            }

            $fechaModificacion = $anoModificacion . $mesModificacion . $diaModificacion;

            if ($fechaModificacion > '20210428')
            {
                $this->Flash->success(__('ID Transacción fecha modificación mayor al 28/04/2021 ' . $transaccionModificar->id )); 
            }
            else
            {
                if ($decimales->extra_column7 > 0)
                {
                    $transaccionModificar->amount = $decimales->extra_column7;
                }

                if ($decimales->extra_column8 > 0)
                {
                    $transaccionModificar->original_amount = $decimales->extra_column8;
                }

                if ($decimales->extra_column9 > 0)
                {
                    $transaccionModificar->amount_dollar = $decimales->extra_column9;
                }

                if (!($transacciones->save($transaccionModificar)))				
                {
                    $this->Flash->error(__('No se pudo actualizar la transacción con el ID ' . $transaccionModificar->id));
                }
                else
                { 
                    $transaccionesActualizadas++;
                }               
            }
        }
        $this->Flash->success(__('Transacciones modificadas ' . $transaccionesActualizadas )); 
    }

    public function index()
    {
        $binnacles = $this->paginate($this->Binnacles);

        $this->set(compact('binnacles'));
        $this->set('_serialize', ['binnacles']);
    }

    /**
     * View method
     *
     * @param string|null $id Binnacle id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $binnacle = $this->Binnacles->get($id, [
            'contain' => []
        ]);

        $this->set('binnacle', $binnacle);
        $this->set('_serialize', ['binnacle']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($typeClass = null, $className = null, $methodName = null, $novelty = null, $arrayExtra = null)
    {
		$this->autoRender = false;
		
		$arrayResult = [];
		$arrayResult['indicator'] = 0;
		$arrayResult['message'] = "Registro grabado exitosamente";
		$arrayResult['id'] = 0;
		
        $binnacle = $this->Binnacles->newEntity();
		
		$binnacle->type_class = $typeClass;
		
		$binnacle->class_name = $className;
		
		$binnacle->method_name = $methodName;
		
		$binnacle->novelty = $novelty;
		
		if (isset($arrayExtra))
		{
			$accountArray = 1;
			
			foreach ($arrayExtra as $arrayExtras)
			{
				if ($accountArray == 1)
				{
					$binnacle->extra_column1 = $arrayExtras;
				}
				
				if ($accountArray == 2)
				{
					$binnacle->extra_column2 = $arrayExtras;
				}

				if ($accountArray == 3)
				{
					$binnacle->extra_column3 = $arrayExtras;
				}
				
				if ($accountArray == 4)
				{
					$binnacle->extra_column4 = $arrayExtras;
				}
				
				if ($accountArray == 5)
				{
					$binnacle->extra_column5 = $arrayExtras;
				}
				
				if ($accountArray == 6)
				{
					$binnacle->extra_column6 = $arrayExtras;
				}
				
				if ($accountArray == 7)
				{
					$binnacle->extra_column7 = $arrayExtras;
				}
				
				if ($accountArray == 8)
				{
					$binnacle->extra_column8 = $arrayExtras;
				}
				
				if ($accountArray == 9)
				{
					$binnacle->extra_column9 = $arrayExtras;
				}
				
				if ($accountArray == 10)
				{
					$binnacle->extra_column10 = $arrayExtras;
				}
				
				$accountArray++;
			}
		}
				
		$binnacle->responsible_user = $this->Auth->user('username');
				
        if ($this->Binnacles->save($binnacle))
		{
			$lastRecord = $this->Binnacles->find('all')
				->where(['responsible_user' => $this->Auth->user('username')])
				->order(['created' => 'DESC']);
				
			$row = $lastRecord->first();
			
			if ($row)
			{
				$arrayResult['id'] = $row->id;
			}
		}
		else
		{
			$arrayResult['indicator'] = 1;
			$arrayResult['message'] = "No se pudo grabar el registro";
		}
	
		return $arrayResult;
    }

    /**
     * Edit method
     *
     * @param string|null $id Binnacle id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $binnacle = $this->Binnacles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $binnacle = $this->Binnacles->patchEntity($binnacle, $this->request->data);
            if ($this->Binnacles->save($binnacle)) {
                $this->Flash->success(__('The binnacle has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The binnacle could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('binnacle'));
        $this->set('_serialize', ['binnacle']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Binnacle id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $binnacle = $this->Binnacles->get($id);
        if ($this->Binnacles->delete($binnacle)) {
            $this->Flash->success(__('The binnacle has been deleted.'));
        } else {
            $this->Flash->error(__('The binnacle could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
