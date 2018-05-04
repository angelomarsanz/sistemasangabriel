<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\BinnaclesController;

/**
 * Excels Controller
 *
 * @property \App\Model\Table\ExcelsTable $Excels
 */
class ExcelsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
        
        $this->Auth->allow(['reportNotAdjust']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $excels = $this->paginate($this->Excels);

        $this->set(compact('excels'));
        $this->set('_serialize', ['excels']);
    }

    /**
     * View method
     *
     * @param string|null $id Excel id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $excel = $this->Excels->get($id, [
            'contain' => []
        ]);

        $this->set('excel', $excel);
        $this->set('_serialize', ['excel']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($columns)
    {
		$this->autoRender = false;
		
		$binnacles = new BinnaclesController;
		
		$excel = $this->Excels->newEntity();
		
		if (isset($columns['report']))
		{
			$excel->report = $columns['report'];
		}

		if (isset($columns['start_end']))
		{		
			$excel->start_end = $columns['start_end'];
		}		

		if (isset($columns['number']))
		{
			$excel->number = $columns['number'];
		}
		
		if (isset($columns['col1']))
		{
			$excel->col1 = $columns['col1'];			
		}
		
		if (isset($columns['col2']))
		{
			$excel->col2 = $columns['col2'];
		}
		
		if (isset($columns['col3']))
		{
			$excel->col3 = $columns['col3'];
		}
		
		if (isset($columns['col4']))
		{
			$excel->col4 = $columns['col4'];
		}
		
		if (isset($columns['col5']))
		{		
			$excel->col5 = $columns['col5'];
		}
		
		if (isset($columns['col6']))
		{
			$excel->col6 = $columns['col6'];
		}

		if (isset($columns['col7']))
		{
			$excel->col7 = $columns['col7'];
		}

		if (isset($columns['col8']))
		{
			$excel->col8 = $columns['col8'];
		}
		
		if (isset($columns['col9']))
		{
			$excel->col9 = $columns['col9'];
		}
		
		if (isset($columns['col10']))
		{
			$excel->col10 = $columns['col10'];
		}

		if ($this->Excels->save($excel)) 
		{
			$swError = 0;
		} 
		else 
		{
			$binnacles->add('controller', 'Excels', 'add', 'No se pudo grabar el registro correspondiente al reporte ' . $excel->report);
			$swError = 1;
		}
		return $swError;
    }

    /**
     * Edit method
     *
     * @param string|null $id Excel id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $excel = $this->Excels->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $excel = $this->Excels->patchEntity($excel, $this->request->data);
            if ($this->Excels->save($excel)) {
                $this->Flash->success(__('The excel has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The excel could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('excel'));
        $this->set('_serialize', ['excel']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Excel id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $excel = $this->Excels->get($id);
        if ($this->Excels->delete($excel)) {
            $this->Flash->success(__('The excel has been deleted.'));
        } else {
            $this->Flash->error(__('The excel could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function truncateTable()
    {
        $this->autoRender = false;

        $this->Excels->connection()->transactional(function ($conn) {
            $sqls = $this->Excels->schema()->truncateSql($this->Excels->connection());
            foreach ($sqls as $sql) {
                $this->Excels->connection()->execute($sql)->execute();
            }
        });
        
        return;
    }
    public function reportNotAdjust()
    {
        $notAdjust = $this->Excels->find('all', ['order' => ['col2' => 'ASC']]);

        $this->set(compact('notAdjust'));
        $this->set('_serialize', ['notAdjust']);
    }
}