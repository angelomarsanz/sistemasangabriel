<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Discounts Controller
 *
 * @property \App\Model\Table\DiscountsTable $Discounts
 */
class DiscountsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $discounts = $this->paginate($this->Discounts);

        $this->set(compact('discounts'));
        $this->set('_serialize', ['discounts']);
    }

    /**
     * View method
     *
     * @param string|null $id Discount id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $discount = $this->Discounts->get($id, [
            'contain' => []
        ]);

        $this->set('discount', $discount);
        $this->set('_serialize', ['discount']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $discount = $this->Discounts->newEntity();
        if ($this->request->is('post')) {
            $discount = $this->Discounts->patchEntity($discount, $this->request->data);
            if ($this->Discounts->save($discount)) {
                $this->Flash->success(__('The discount has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The discount could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('discount'));
        $this->set('_serialize', ['discount']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Discount id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $discount = $this->Discounts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $discount = $this->Discounts->patchEntity($discount, $this->request->data);
            if ($this->Discounts->save($discount)) {
                $this->Flash->success(__('The discount has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The discount could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('discount'));
        $this->set('_serialize', ['discount']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Discount id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $discount = $this->Discounts->get($id);
        if ($this->Discounts->delete($discount)) {
            $this->Flash->success(__('The discount has been deleted.'));
        } else {
            $this->Flash->error(__('The discount could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function searchDiscount()
    {
        $this->autoRender = false;

        if ($this->request->is('json')) 
        {
            if (!(isset($_POST['id'])))
            {
                die("Solicitud no válida");    
            }
			
            $discount = $this->Discounts->get($_POST['id']);

            $jsondata["success"] = true;
			$jsondata["data"]['mode'] = $discount->discount_mode;
            $jsondata["data"]['amount'] = $discount->discount_amount;

            exit(json_encode($jsondata, JSON_FORCE_OBJECT));
        }
	}
}