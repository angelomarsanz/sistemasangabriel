<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\BillsController;

/**
 * Salesbooks Controller
 *
 * @property \App\Model\Table\SalesbooksTable $Salesbooks
 */
class SalesbooksController extends AppController
{
    public function testFunction()
    {
        $month = "07";

        $englishMonth = $this->nameMonthEnglish($month);

        echo ' $englishMonth: ' . $englishMonth;
        
        $spanishMonth = $this->nameMonthSpanish($month);
        
        echo ' $spanishMonth: ' . $spanishMonth;
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $salesbooks = $this->paginate($this->Salesbooks);

        $this->set(compact('salesbooks'));
        $this->set('_serialize', ['salesbooks']);
    }

    /**
     * View method
     *
     * @param string|null $id Salesbook id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $salesbook = $this->Salesbooks->get($id, [
            'contain' => []
        ]);

        $this->set('salesbook', $salesbook);
        $this->set('_serialize', ['salesbook']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $salesbook = $this->Salesbooks->newEntity();
        if ($this->request->is('post')) {
            $salesbook = $this->Salesbooks->patchEntity($salesbook, $this->request->data);
            if ($this->Salesbooks->save($salesbook)) {
                $this->Flash->success(__('The salesbook has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The salesbook could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('salesbook'));
        $this->set('_serialize', ['salesbook']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Salesbook id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $salesbook = $this->Salesbooks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $salesbook = $this->Salesbooks->patchEntity($salesbook, $this->request->data);
            if ($this->Salesbooks->save($salesbook)) {
                $this->Flash->success(__('The salesbook has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The salesbook could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('salesbook'));
        $this->set('_serialize', ['salesbook']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Salesbook id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $salesbook = $this->Salesbooks->get($id);
        if ($this->Salesbooks->delete($salesbook)) {
            $this->Flash->success(__('The salesbook has been deleted.'));
        } else {
            $this->Flash->error(__('The salesbook could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function deleteAll()
    {
        $this->autoRender = false;

        $this->Salesbooks->deleteAll(['id >' => 0]);
        
        return $this->redirect(['controller' => 'users', 'action' => 'wait']);
    }

    public function truncateTable()
    {
        $this->autoRender = false;

        $this->Salesbooks->connection()->transactional(function ($conn) {
            $sqls = $this->Salesbooks->schema()->truncateSql($this->Salesbooks->connection());
            foreach ($sqls as $sql) {
                $this->Salesbooks->connection()->execute($sql)->execute();
            }
        });
        
        return;
    }

    public function createBookExcel()
    {
        if ($this->request->is('post')) 
        {
			$errorBill = 0;
			
            $this->truncateTable();

            $bills = new BillsController();
        
            $invoicesBills = $bills->indexBills($_POST['month'], $_POST['year']);

            $contador = 0;

			foreach ($invoicesBills as $invoicesBill)
			{
				$salesbook = $this->Salesbooks->newEntity();
				
				if ($invoicesBill->date_and_time->day < 10)
				{
					$dia = "0" . $invoicesBill->date_and_time->day;
				}
				else
				{
					$dia = $invoicesBill->date_and_time->day;
				}
						
				if ($invoicesBill->date_and_time->month < 10)
				{
					$mes = "0" . $invoicesBill->date_and_time->month;
				}
				else
				{
					$mes = $invoicesBill->date_and_time->month;
				}		
						
				$salesbook->fecha = $dia . '/' . $mes . '/' . $invoicesBill->date_and_time->year . ' ';
				
				$salesbook->tipo_documento = "Fact";
				
				$salesbook->numero_factura = $invoicesBill->bill_number;
				
				$salesbook->numero_control = $invoicesBill->control_number;
				
				$salesbook->nota_debito = "";
				
				$salesbook->nota_credito = "";
				
				$salesbook->factura_afectada = "";
				
				if ($invoicesBill->annulled == false )
				{
					$salesbook->cedula_rif = $invoicesBill->identification;
					$salesbook->nombre_razon_social = $invoicesBill->client;
					$salesbook->total_ventas_mas_impuesto = $invoicesBill->amount_paid;
					$salesbook->ventas_exoneradas = $invoicesBill->amount_paid;
				}
				else
				{
					$salesbook->cedula_rif = "";
					$salesbook->nombre_razon_social = "ANULADA";
					$salesbook->total_ventas_mas_impuesto = 0;
					$salesbook->ventas_exoneradas = 0;
				}        
				$salesbook->base = "";
				$salesbook->alicuota = "16%";
				$salesbook->iva = 0;
				$salesbook->right_bill_number = $invoicesBill->right_bill_number;
				$salesbook->previous_control_number = $invoicesBill->previous_control_number;

				if (!($this->Salesbooks->save($salesbook))) 
				{
					$this->Flash->error(__('La factura: ' . $invoicesBill->bill_number . ' no pudo ser grabada en el libro de ventas'));
					$errorBill = 1;
					break;
				}
							
				$contador++;
			}

            if ($errorBill == 0)  
            {
                $this->Flash->success(__('La tabla salesbooks se creo exitosamente'));
                return $this->redirect(['controller' => 'Salesbooks', 'action' => 'downloadBook']);
            }
            else
            {
                $this->Flash->error(__('La tabla salesbook no se pudo crear exitosamente'));
                return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
            }
		}
    }
    
    public function downloadBook()
    {

    }

    public function indexexcel()
    {
        $invoicesMonth = $this->Salesbooks->find('all');

        $this->set(compact('invoicesMonth'));
        $this->set('_serialize', ['invoicesMonth']);
    }

    public function createBookPdf()
    {
        if ($this->request->is('post')) 
        {
			$errorBill = 0;
		
            $bills = new BillsController();

            $this->truncateTable();
			
            $invoicesBills = $bills->indexBills($_POST['month'], $_POST['year']);

			foreach ($invoicesBills as $invoicesBill)
			{
				$salesbook = $this->Salesbooks->newEntity();
				
				$salesbook->fecha = $invoicesBill->date_and_time;
				
				$salesbook->tipo_documento = "Fact";
				
				$salesbook->cedula_rif = $invoicesBill->identification;
				
				$salesbook->nombre_razon_social = $invoicesBill->client;

				$salesbook->numero_factura = $invoicesBill->bill_number;
				
				$salesbook->numero_control = $invoicesBill->control_number;
				
				$salesbook->nota_debito = "";
				
				$salesbook->nota_credito = "";
				
				$salesbook->factura_afectada = "";
				
				if ($invoicesBill->annulled == false )
				{
					$salesbook->total_ventas_mas_impuesto = $invoicesBill->amount_paid;
					$salesbook->ventas_exoneradas = $invoicesBill->amount_paid;
				}
				else
				{
					$salesbook->total_ventas_mas_impuesto = 0;
					$salesbook->ventas_exoneradas = 0;
				}        
				$salesbook->base = "";
				$salesbook->alicuota = "9%";
				$salesbook->iva = 0;
				$salesbook->right_bill_number = $invoicesBill->right_bill_number;
				$salesbook->previous_control_number = $invoicesBill->previous_control_number;

				if (!($this->Salesbooks->save($salesbook))) 
				{
					$this->Flash->error(__('La factura: ' . $invoicesBill->bill_number . ' no pudo ser grabada en el libro de ventas'));
					$errorBill = 1;
					break;
				}
			}
            $yearMonth = $_POST['year'] . $_POST['month'];

            if ($errorBill == 0)  
            {
                $this->Flash->success(__('La tabla salesbooks se creo exitosamente'));
                return $this->redirect(['action' => 'salespdf', $_POST['month'], $_POST['year'], $yearMonth, '_ext' => 'pdf']);
            }
            else
            {
                $this->Flash->error(__('La tabla salesbook no se pudo crear exitosamente'));
                return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
            }
        }
    }
    public function salespdf($month = null, $year = null, $yearMonth = null)
    {
        $this->loadModel('Schools');
        
        $school = $this->Schools->get(2);
    
        $sales = $this->Salesbooks->find('all')->where([['Salesbooks.numero_control IS NOT NULL'], ['Salesbooks.numero_control >' => 0]]);
        
        $nameFile = $yearMonth . '.pdf';

        $this->viewBuilder()
            ->className('Dompdf.Pdf')
            ->layout('default')
            ->options(['config' => [
                'upload_filename' => WWW_ROOT.'pdf/' . $nameFile,
                'render' => 'upload',
                'size' => 'Legal',
                'orientation' => 'landscape',
                'paginate' => [
                    'x' => 900,
                    'y' => 5,
                    'text' => "Página: {PAGE_NUM} / {PAGE_COUNT}"]
                    ]]);

        if ($year == "2020" || 
            $year == "2024" ||
            $year == "2028" ||
            $year == "2032" )
        {
            $lastDay = $this->lastDayMonthLeap($month);
        }
        else
        {
            $lastDay = $this->lastDayMonth($month);
        }

        $firstDayMonth = "01/" . $month . "/" . $year;
        
        $lastDayMonth = $lastDay . "/" . $month . "/" . $year;
        
        $spanishMonth = $this->nameMonthSpanish($month);
        
        $this->set(compact('sales', 'school', 'firstDayMonth', 'lastDayMonth', 'spanishMonth', 'year'));
    }

	public function viewDir()
	{
		
	}
	
    public function lastDayMonth($month = null)
    {
        $monthNumbers = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $lastDay = ["31", "28", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31"];
        $englishMonth = str_replace($monthNumbers, $lastDay, $month);
        return $englishMonth;
    }
    public function lastDayMonthLeap($month = null)
    {
        $monthNumbers = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $lastDay = ["31", "29", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31"];
        $englishMonth = str_replace($monthNumbers, $lastDay, $month);
        return $englishMonth;
    }

    public function nameMonthEnglish($monthNumber = null)
    {
        $englishMonth=strftime("%B",mktime(0, 0, 0, $monthNumber, 1, 2000)); 
        return $englishMonth;
    }

    public function nameMonthSpanish($month = null)
    {
        $monthNumbers = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $nameMonths = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $spanishMonth = str_replace($monthNumbers, $nameMonths, $month);
        return $spanishMonth;
    }
	
}