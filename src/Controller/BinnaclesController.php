<?php
namespace App\Controller;

use App\Controller\AppController;

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
				
		$result = 0;
		
        if (!($this->Binnacles->save($binnacle)))
		{
			$result = 1;
		}
		
		return $result;
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
