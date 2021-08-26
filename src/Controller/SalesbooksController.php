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
        /* $month = "07";

        $englishMonth = $this->nameMonthEnglish($month);

        echo ' $englishMonth: ' . $englishMonth;
        
        $spanishMonth = $this->nameMonthSpanish($month);
        
        echo ' $spanishMonth: ' . $spanishMonth; */
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
			
			$facturaAnterior = 0;
			$contadorControlFacturas = 0;

			foreach ($invoicesBills as $invoicesBill)
			{
				if ($contador == 0)
				{
					$facturaAnterior = $invoicesBill->control_number;
                }
                $contadorControlFacturas = $invoicesBill->control_number - $facturaAnterior;
                if ($contadorControlFacturas > 1 && $facturaAnterior != 0)
                {						
                    while ($contadorControlFacturas > 1)
                    {
                        $facturaAnterior++;
                        $codigoRetorno = $this->crearRegistroLibro($invoicesBill, $facturaAnterior);
                        if ($codigoRetorno == 1)
                        {
                            $errorBill = 1;
                            break;
                        }
                        $contadorControlFacturas--;
                    }
                }
                $codigoRetorno = $this->crearRegistroLibro($invoicesBill, 0);
                if ($codigoRetorno == 1)
                {
                    $errorBill = 1;
                    break;
                }
                $facturaAnterior = $invoicesBill->control_number;				
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
	
	public function crearRegistroLibro($invoicesBill = null, $controlSinFactura = null)
	{
		$codigoRetorno = 0;
		
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
		
		$this->loadModel('Bills');
		
		if ($controlSinFactura > 0)
		{
			$salesbook->numero_factura = "Sin número";
			$salesbook->nota_debito = "";
			$salesbook->nota_credito = "";
			$salesbook->factura_afectada = "";
			$salesbook->numero_control = $controlSinFactura;			
        }
		elseif ($invoicesBill->control_number == 0)
		{
			$salesbook->numero_factura = $invoicesBill->bill_number;
			$salesbook->nota_debito = "";
			$salesbook->nota_credito = "";
			$salesbook->factura_afectada = "";
			$salesbook->numero_control = 'Sin control';			
        }
		elseif ($invoicesBill->tipo_documento == "Factura")
		{
			$salesbook->numero_factura = $invoicesBill->bill_number;
			$salesbook->nota_debito = "";
			$salesbook->nota_credito = "";
			$salesbook->factura_afectada = "";
			$salesbook->numero_control = $invoicesBill->control_number;
		}
		elseif ($invoicesBill->tipo_documento == "Nota de débito")
		{
			$salesbook->numero_factura = "";
			$salesbook->nota_debito = $invoicesBill->bill_number;
			$salesbook->nota_credito = "";
								
			$facturaAfectada = $this->Bills->get($invoicesBill->id_documento_padre);					
			$salesbook->factura_afectada = $facturaAfectada->bill_number;
			$salesbook->numero_control = $invoicesBill->control_number;
		}				
		else
		{
			$salesbook->numero_factura = "";
			$salesbook->nota_debito = "";
			$salesbook->nota_credito = $invoicesBill->bill_number;
								
			$facturaAfectada = $this->Bills->get($invoicesBill->id_documento_padre);					
			$salesbook->factura_afectada = $facturaAfectada->bill_number;
			$salesbook->numero_control = $invoicesBill->control_number;
		}		

		if ($controlSinFactura > 0)
		{
			$salesbook->cedula_rif = "";
			$salesbook->nombre_razon_social = "ANULADA";
			$salesbook->total_ventas_mas_impuesto = 0;
			$salesbook->ventas_exoneradas = 0;
		}        				
		elseif ($invoicesBill->control_number == 0)
		{
			$salesbook->cedula_rif = "";
			$salesbook->nombre_razon_social = "ANULADA";
			$salesbook->total_ventas_mas_impuesto = 0;
			$salesbook->ventas_exoneradas = 0;
		}        				
        elseif ($invoicesBill->annulled == false )
		{
			$salesbook->cedula_rif = $invoicesBill->identification;
			$salesbook->nombre_razon_social = $invoicesBill->client;
			
			if ($invoicesBill->tipo_documento == "Nota de crédito")
			{
				$salesbook->total_ventas_mas_impuesto = $invoicesBill->amount_paid * -1;
				$salesbook->ventas_exoneradas = $invoicesBill->amount_paid * -1;
			}
			else
			{
                if ($invoicesBill->amount != 0)
                {
                    $salesbook->descuento_recargo = $invoicesBill->amount;
				    $salesbook->total_ventas_mas_impuesto = $invoicesBill->amount_paid + $invoicesBill->amount;
				    $salesbook->ventas_exoneradas = $invoicesBill->amount_paid + $invoicesBill->amount;
                }
                else
                {
                    $salesbook->descuento_recargo = 0;
				    $salesbook->total_ventas_mas_impuesto = $invoicesBill->amount_paid;
				    $salesbook->ventas_exoneradas = $invoicesBill->amount_paid;
                }
			}
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

		if (!($this->Salesbooks->save($salesbook))) 
		{
			$this->Flash->error(__('La factura: ' . $invoicesBill->bill_number . ' no pudo ser grabada en el libro de ventas'));
			$codigoRetorno = 1;
		}
		return $codigoRetorno;
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
    public function crearLibroRecibos()
    {
        if ($this->request->is('post')) 
        {
			$errorBill = 0;
					
            $this->truncateTable();

            $bills = new BillsController();
        
            $invoicesBills = $bills->indiceRecibos($_POST['month'], $_POST['year']);
			
			$this->loadModel('Concepts');

			$servicioEducativo = $this->Concepts->find('all', ['conditions' => 
				['SUBSTR(concept, 1, 18) =' => 'Servicio educativo',
				'MONTH(created)' => $_POST['month'], 
				'YEAR(created)' => $_POST['year'],
				'annulled' => false],
				'order' => ['id' => 'ASC'] ]);
				
			$contadorServicioEducativo = $servicioEducativo->count();
		
            $contador = 0;

			foreach ($invoicesBills as $invoicesBill)
			{
				$montoServicioEducativo = 0;

				foreach ($servicioEducativo as $servicio)
				{					
					if ($servicio->bill_id == $invoicesBill->id)
					{
						$montoServicioEducativo += $servicio->amount;
					}
				}
								
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
				
				$salesbook->tipo_documento = "Recibo";
				
				$salesbook->numero_factura = $invoicesBill->bill_number;
							
				if ($invoicesBill->annulled == false )
				{
					$salesbook->cedula_rif = $invoicesBill->identification;
					$salesbook->nombre_razon_social = $invoicesBill->client;
					$salesbook->total_ventas_mas_impuesto = $invoicesBill->amount_paid - $montoServicioEducativo;
				}
				else
				{
					$salesbook->cedula_rif = "";
					$salesbook->nombre_razon_social = "ANULADA";
					$salesbook->total_ventas_mas_impuesto = 0;
				}        

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
}