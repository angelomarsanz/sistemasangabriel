<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\StudentsController;

use App\Controller\StudenttransactionsController;

use App\Controller\ConceptsController;

use App\Controller\PaymentsController;

use App\Controller\ConsecutiveinvoicesController;

use App\Controller\ConsecutivereceiptsController;

use App\Controller\ConsecutivocreditosController;

use App\Controller\ConsecutivodebitosController;

use App\Controller\BinnaclesController;

use App\Controller\EventosController;

use Cake\I18n\Time;

class BillsController extends AppController
{
    public $headboard = [];
    public $tbConcepts = [];
    public $conceptCounter = 0;

    public function testFunction()
    {
        /* $recibos = $this->Bills->find('all')
			->contain(['Parentsandguardians'])
			->where(['factura_pendiente' => 1, 'annulled' => 0])
			->order(['Bills.id' => 'ASC']);
		
        $this->set(compact('recibos'));
        $this->set('_serialize', ['recibos']); */
    }
	
    public function index($idFamily = null, $family = null)
    {
        $query = $this->Bills->find('all', ['conditions' => ['parentsandguardian_id' => $idFamily],
                'order' => ['Bills.created' => 'DESC'] ]);

        $this->set('bills', $this->paginate($query));

        $this->set(compact('bills', 'idFamily', 'family'));
        $this->set('_serialize', ['bills', 'idFamily', 'family']);
    }
    
    public function indexBills($month = null, $year = null)
    {
        $this->autoRender = false;
        
        $invoicesBills = $this->Bills->find('all', ['conditions' => 
            [['MONTH(date_and_time)' => $month], 
            ['YEAR(date_and_time)' => $year],
            ['Bills.fiscal' => true]],
            'order' => ['Bills.created' => 'ASC'] ]);
            
        return $invoicesBills;
    }
    
    public function verifyInvoices($firstBillMonth = null, $firstControlMonth = null, $invoices = null)
    {
        $returnSwitch = 0;
        $accountantBill = 0;
        $accountantControl = 0;
        
        foreach ($invoices as $invoice)
        {
            $switchModify = 0;
            $switchBill = 0;
            $switchControl = 0;

            if ($invoice->bill_number != $firstBillMonth)
            {
                $switchModify = 1;
                $switchBill = 1;
            }
            if ($invoice->control_number != $firstControlMonth)
            {
                $switchModify = 1;
                $switchControl = 1;
            }
            if ($switchModify == 1)
            {
                $bill = $this->Bills->get($invoice->id);
                if ($switchBill == 1)
                {
                    $bill->right_bill_number = $firstBillMonth;
                    $accountantBill++;
                }
                if ($switchControl == 1)
                {
                    $bill->previous_control_number = $bill->control_number;
                    $bill->control_number = $firstControlMonth;
                    $accountantControl++;
                }
                if (!($this->Bills->save($bill))) 
                {
                    $this->Flash->error(__('No se pudo grabar el número correcto de la factura id : ' . $invoice->id));
                    $returnSwitch = 1; 
                    break;
                }
                else
                {
                    $returnSwitch = 2;
                }
            }
        $firstBillMonth++;
        $firstControlMonth++;
        }
        if ($accountantBill > 0 || $accountantControl > 0)
        {
            $this->Flash->success(__(' Facturas con diferente número: ' . $accountantBill . '. Facturas a las que se modificó número de control: ' . $accountantControl));
        }
        return $returnSwitch; 
    }

    public function view($id = null)
    {
        $bill = $this->Bills->get($id, [
            'contain' => []
        ]);

        $this->set('bill', $bill);
        $this->set('_serialize', ['bill']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($indicadorFacturaPendiente = null)
    {
        $consecutiveInvoice = new ConsecutiveinvoicesController();
        
        $consecutiveReceipt = new ConsecutivereceiptsController();
		
		$billNumber = 0;
			
		$codigoRetorno = $this->reciboFactura($this->headboard['idParentsandguardians']);
      	  
		if ($codigoRetorno == 0)
		{
			if ($this->headboard)
			{
				if ($this->headboard['fiscal'] == 1)
				{
					$billNumber = $consecutiveInvoice->add();
				}
				else
				{
					$billNumber = $consecutiveReceipt->add();
				}
				
				$bill = $this->Bills->newEntity();
				$bill->parentsandguardian_id = $this->headboard['idParentsandguardians'];
				$bill->user_id = $this->Auth->user('id');
				$bill->date_and_time = $this->headboard['invoiceDate'];
				$bill->turn = $this->headboard['idTurn'];
				
				$bill->bill_number = $billNumber;
				if ($this->headboard['fiscal'] == 1)
				{
					$bill->fiscal = 1;
					$bill->tipo_documento = "Factura";
				}
				else
				{
					$bill->fiscal = 0;
					$bill->control_number = $billNumber;
					$bill->tipo_documento = "Recibo";
				}
				$bill->school_year = $this->headboard['schoolYear'];
				$bill->identification = $this->headboard['typeOfIdentificationClient'] . ' - ' . $this->headboard['identificationNumberClient'];
				$bill->client = $this->headboard['client'];
				$bill->tax_phone = $this->headboard['taxPhone'];
				$bill->fiscal_address = $this->headboard['fiscalAddress'];
				
				if (isset($this->headboard['discount']))
				{
					$bill->amount = $this->headboard['discount'];
				}
				else
				{
					$bill->amount = 0;
				}
				$bill->amount_paid = $this->headboard['invoiceAmount'];
				$bill->annulled = 0;
				$bill->date_annulled = 0;
				$bill->invoice_migration = 0;
				$bill->new_family = 0;
				$bill->impresa = 0;
				$bill->id_documento_padre = 0;
				$bill->id_anticipo = 0;
				$bill->factura_pendiente = $indicadorFacturaPendiente;
				$bill->moneda_id = 2;
				$bill->tasa_cambio = $this->headboard['tasaDolar'];
				$bill->tasa_euro = $this->headboard['tasaEuro'];
				$bill->tasa_dolar_euro = $this->headboard['tasaDolarEuro'];
				$bill->saldo_compensado = $this->headboard['saldoCompensado'];
				
				if (!($this->Bills->save($bill))) 
				{
					$this->Flash->error(__('La factura no pudo ser guardada, intente nuevamente'));
				}
			}
			else
			{
				$this->Flash->error(__('La factura no pudo ser guardada. No existe el encabezado de la factura'));            
			}
		}
		return $billNumber;
    }

    public function edit($id = null)
    {
        $bill = $this->Bills->get($id, [
            'contain' => []
        ]);
        $bill->bill_number = $id;

        if (!($this->Bills->save($bill))) 
        {
            $this->Flash->error(__('The bill could not be saved. Please, try again.'));
        }
        return;
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bill = $this->Bills->get($id);
        if ($this->Bills->delete($bill)) {
            $this->Flash->success(__('The bill has been deleted.'));
        } else {
            $this->Flash->error(__('The bill could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function createInvoice($menuOption = null, $idTurn = null, $turn = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
        
        $dateTurn = Time::now();
		
		$this->loadModel('Discounts');
		$this->loadModel('Bancos');
		
		$discounts = $this->Discounts->find('list', ['limit' => 200, 
			'order' => ["description_discount" => "ASC"],
			'keyField' => 'id']);
				
		$bancosEmisor = $this->Bancos->find('list', ['limit' => 200, 
			'conditions' => ['tipo_banco' => 'Emisor'],
			'order' => ['nombre_banco' => 'ASC'],
			'keyField' => 'nombre_banco']);
						
		$bancosReceptor = $this->Bancos->find('list', ['limit' => 200, 
			'conditions' => ['tipo_banco' => 'Receptor'],
			'order' => ['nombre_banco' => 'ASC'],
			'keyField' => 'nombre_banco']);
				
		$this->loadModel('Rates');
		
		$this->loadModel('Monedas');	
		$moneda = $this->Monedas->get(2);
		$dollarExchangeRate = $moneda->tasa_cambio_dolar; 
		
		$moneda = $this->Monedas->get(3);
		$euro = $moneda->tasa_cambio_dolar; 
				
        $this->set(compact('menuOption', 'idTurn', 'turn', 'dateTurn', 'discounts', 'dollarExchangeRate', 'euro', 'amountMonthly', 'bancosEmisor', 'bancosReceptor'));
    }
    
    public function createInvoiceRegistration($idTurn = null, $turn = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
        
        $dateTurn = Time::now();
        
        $this->set(compact('idTurn', 'turn', 'dateTurn'));
    }
    
    public function createInvoiceRegistrationNew($idTurn = null, $turn = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
        
        $dateTurn = Time::now();
        
        $this->set(compact('idTurn', 'turn', 'dateTurn'));
    }
    
    public function createInvoiceReceipt($idTurn = null, $turn = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
        
        $dateTurn = Time::now();
        
        $this->set(compact('idTurn', 'turn', 'dateTurn'));
    }

    public function recordInvoiceData()
    {
        $this->autoRender = false;
		
        $Studenttransactions = new StudenttransactionsController();

        $Concepts = new ConceptsController();

        $Payments = new PaymentsController();
		
		$binnacles = new BinnaclesController;
		
		$codigoRetorno = 0;
		
        if ($this->request->is('post')) 
        {
			$indicadorFacturaPendiente = 0;
			
            $this->headboard = $_POST['headboard']; 
            $transactions = json_decode($_POST['studentTransactions']);
            $payments = json_decode($_POST['paymentsMade']);
            $_POST = [];
			
			if ($this->headboard['fiscal'] == 0)
			{
				foreach ($transactions as $transaction) 
				{
					if (substr($transaction->monthlyPayment, 0, 10) == "Matrícula" || substr($transaction->monthlyPayment, 0, 14) == "Seguro escolar" || substr($transaction->monthlyPayment, 0, 3) == "Ago")
					{
						$indicadorFacturaPendiente = 1;
						break;
					} 
				}
			}
			
            $billNumber = $this->add($indicadorFacturaPendiente);

            if ($billNumber > 0)
            {
                $lastRecord = $this->Bills->find('all', ['conditions' => ['bill_number' => $billNumber, 'user_id' => $this->Auth->user('id')],
                        'order' => ['Bills.id' => 'DESC'] ]);

                if ($lastRecord)
                {
                    $row = $lastRecord->first();
                    
                    $billId = $row->id;

                    foreach ($transactions as $transaction) 
                    {
                        $Studenttransactions->edit($transaction, $billNumber);

                        $Concepts->add($billId, $transaction, $this->headboard['fiscal']);
                    }

                    foreach ($payments as $payment) 
                    {
                        $Payments->add($billId, $billNumber, $payment, $this->headboard['fiscal']);
                    }
                    
                    $idParentsandguardian = $this->headboard['idParentsandguardians'];
										
					if ($this->headboard['saldoCompensado'] > 0 || $this->headboard['sobrante'] > 0)
					{
						$parentandguardian = $this->Bills->Parentsandguardians->get($idParentsandguardian);
						
						if ($this->headboard['sobrante'] > 0)
						{
							$resultado = this->reciboCredito($idParentsandguardian, $parentandguardian->family, $billId, $this->headboard['sobrante'] > 0); 
							if ($resultado['codigoRetorno'] == 0)
							{
								$factura = $this->Bills->get($billId);
								$factura->id_Recibo_sobrante = $resultado['idRecibo'];
														
								if (!($this->Bills->save($factura)))
								{
									 $this->Flash->error(__('La factura no se pudo actualizar con el id del recibo del sobrante'));
									 $binnacles->add('controller', 'Bills', 'recordInvoiceData', 'La factura ' . $billNumber . ' no se pudo actualizar con el id del recibo del sobrante');
								}
							}
							else
							{
								$this->Flash->error(__('No se pudo guardar correctamente el recibo del sobrante'));
								$binnacles->add('controller', 'Bills', 'recordInvoiceData', 'No se pudo crear correctamente el recibo del sobrante para la factura ' . $billNumber);
							}
						}
						
						$parentandguardian->balance = $parentandguardian->balance - $this->headboard['saldoCompensado'] + $this->headboard['sobrante'];
						
						if (!($this->Bills->Parentsandguardians->save($parentandguardian)))
						{
							$this->Flash->error(__('No se pudo actualizar el saldo del representante con id ' . $idParentsandguardian));
							$binnacles->add('controller', 'Bills', 'recordInvoiceData', 'No se pudo actualizar el saldo del representante con id ' . $idParentsandguardian . ' en la factura ' . $billNumber);
						}
					}

                    return $this->redirect(['action' => 'imprimirFactura', $billNumber, $idParentsandguardian, $billId, ""]);
                }
            }
        }
        else
        {
            $this->Flash->error(__('La factura no pudo ser guardada, intente nuevamente'));            
        }
    }
	
    public function imprimirFactura($billNumber = null, $idParentsandguardian = null, $idFactura = null, $mensaje = null)
    {
        $parentandguardian = $this->Bills->Parentsandguardians->get($idParentsandguardian);

        $family = $parentandguardian->family;

        $this->Flash->success(__('Factura guardada con el número: ' . $billNumber));

        $this->set(compact('billNumber', 'idParentsandguardian', 'family', 'idFactura', 'mensaje'));
        $this->set('_serialize', ['billNumber', 'idParentsandguardian', 'family', 'idFactura', 'mensaje']);
    }

    public function invoice($idFactura = null, $reimpresion = null, $idParentsandguardian = null, $origen = null, $bill_number = null)
    {
        $this->loadModel('Controlnumbers');
		
		$this->loadModel('Users');
		
		$mensajeUsuario = "";
		
		$facturaOtroCajero = 0;
		
		if (isset($origen))
		{
			if ($origen != 'verificarFacturas')
			{				
				$facturas = $this->Bills->find('all', ['conditions' => ['impresa' => 0, 'id !=' => $idFactura],
					'order' => ['Bills.id' => 'ASC']]);
					
				$contadorRegistros = $facturas->count();
								
				if ($contadorRegistros > 0)
				{
					foreach ($facturas as $factura)
					{
						if ($factura->user_id != $this->Auth->user('id') && $factura->bill_number < $bill_number)
						{
							$facturaOtroCajero = 1;
							break;
						}						
					}
					
					if ($facturaOtroCajero == 1)
					{
						$mensajeUsuario = "Estimado usuario, otro cajero tiene una factura pendiente, espere a que la imprima y luego intente nuevamente imprimir su factura";
						return $this->redirect(['action' => 'imprimirFactura', $bill_number, $idParentsandguardian, $idFactura, $mensaje]);
					}
					else
					{					
						$facturaAnterior = $facturas->first();
						
						if ($facturaAnterior->tipo_documento == "Factura")
						{
							$documento = "esta factura";
						}
						elseif ($facturaAnterior->tipo_documento == "Recibo" || $facturaAnterior->tipo_documento == "Recibo crédito")
						{
							$documento = "este recibo";
						}
						elseif ($facturaAnterior->tipo_documento == "Nota de crédito")
						{
							$documento = "esta nota de crédito";
						}
						else
						{
							$documento = "esta nota de débito";
						}
						
						$mensajeUsuario = "Estimado usuario " . $documento . " con el Nro. " . $facturaAnterior->bill_number . " se debe imprimir primero y luego podrá continuar con la cobranza";	
						
						$idFactura = $facturaAnterior->id;
						$reimpresion = 0;
						$idParentsandguardian = $facturaAnterior->parentsandguardian_id;
					}
				}				
			}
		}
		
        $lastRecord = $this->Bills->find('all', ['conditions' => ['id' => $idFactura],
            'order' => ['Bills.id' => 'DESC']]);
					    
        $bill = $lastRecord->first();
		
		if (isset($origen))
		{
			if ($origen == 'verificarFacturas' && $mensajeUsuario == "")
			{				
				$mensajeUsuario = "Ahora por favor imprima esta factura con el Nro. " . $bill->bill_number;
			}
		}
	               
		$usuario = $this->Users->get($bill->user_id);
		
		if ($bill->id_documento_padre > 0)
		{
			$facturaAfectada = $this->Bills->get($bill->id_documento_padre);
			$numeroFacturaAfectada = $facturaAfectada->bill_number;
			$controlFacturaAfectada = $facturaAfectada->control_number;
		}
		else
		{
			$numeroFacturaAfectada = 0;
			$controlFacturaAfectada = 0;
		}
		
		$usuarioResponsable = $usuario->first_name . " " . $usuario->surname;
				
        $billId = $bill->id;
								        
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $dateBill = $bill->created;
        $dateBilli = $dateBill->year . $dateBill->month . $dateBill->day;
        $currentDate = Time::now();
        $currentDatei = $currentDate->year . $currentDate->month . $currentDate->day;
		
		$nextYear = $currentDate->year + 1;
		$lastYear = $currentDate->year - 1;
		$yearAncestor = $currentDate->year - 2;
		
		$numeroControl = "";
		$indicadorImpresa = 0;
				
        if ($bill->control_number == null && $dateBilli == $currentDatei)
        {
            $lastRecord = $this->Controlnumbers->find('all', ['conditions' => ['username' => 'adminsg'],
                'order' => ['Controlnumbers.created' => 'DESC'] ]);

            $row = $lastRecord->first();
        
            if ($row->invoice_lot == 0)
            {
                $this->Flash->error(__('Se agotó el lote de factura, por favor registre otro'));

                return $this->redirect(['controller' => 'Controlnumbers', 'action' => 'edit']);
            }                
            else
            {
                $invoiceSeries = $row->invoice_series;
                
                $controlnumber = $this->Controlnumbers->get($row->id);

                $controlnumber->invoice_series++;   
            
                $controlnumber->invoice_lot--;

                if (!($this->Controlnumbers->save($controlnumber)))
                {
                    $this->Flash->error(__('No se pudo actualizar el número de control de la factura, por favor verifique si coincide el número de control
                    con el de la primera factura en blanco del lote que se encuentra en la impresora y actualice si es necesario'));
                    
                    return $this->redirect(['controller' => 'Controlnumbers', 'action' => 'edit']);
                }
                else
                {
                    $billGet = $this->Bills->get($billId);

                    $billGet->control_number = $invoiceSeries;
					
					$numeroControl = $invoiceSeries;
                
                    if (!($this->Bills->save($billGet)))
                    {
                        $this->Flash->error(__('No se pudo actualizar la factura con el número de control, por favor cuando cierre el turno verifique
                        los números de control de las facturas que aparecen en el reporte'));
                    }
                }
            }
        }
		elseif ($bill->control_number != null)
		{
			$numeroControl = $bill->control_number;
			if ($bill->impresa == 1)
			{
				$indicadorImpresa = 1;
			}
		}
						
        $previousStudentName = " ";
        $firstMonthly= " ";
        $lastInstallment = " ";
        $invoiceLine = " ";
        $studentReceipt = [];
        $accountReceipt = 0;
        $accountService = 0;
        $amountConcept = 0;
		$montoCredito = 0;
        $contadorCreditos = 0;
        $previousAcccountingCode = " ";
		$indicadorAnticipo = 0;
 
        $loadIndicator = 0;

        $concepts = $this->Bills->Concepts->find('all')->where(['bill_id' => $billId]);

        $aConcepts = $concepts->toArray();

        foreach ($aConcepts as $aConcept) 
        {                  
            if ($previousStudentName != $aConcept->student_name)
            {				
                if ($lastInstallment != " ")
                {
                    if ($firstMonthly == $lastInstallment)
                    {
                        $invoiceLine .= substr($firstMonthly, 4, 4);
                    }
                    else
                    {
                        $invoiceLine .= $lastInstallment;
                    }
                    $this->invoiceConcept($previousAcccountingCode, $invoiceLine, $amountConcept);
                    $locLoadIndicator = 1;
                }
                if ($aConcept->observation == "Abono" && substr($aConcept->concept, 0, 18) != "Servicio educativo")
                {
                    $invoiceLine = $aConcept->student_name . " - Abono: " . $aConcept->concept;
                    $amountConcept = $aConcept->amount;
                    $this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
                    $loadIndicator = 1;
                    $firstMonthly= " ";
                    $lastInstallment = " ";
                    $amountConcept = 0;
                }
                elseif (substr($aConcept->concept, 0, 10) == "Matrícula")
                {				
					$invoiceLine = $aConcept->student_name . " - Inscripción / Dif de Inscripción";
                    $amountConcept = $aConcept->amount;
                    $this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
                    $loadIndicator = 1;
                    $firstMonthly= " ";
                    $lastInstallment = " ";
                    $amountConcept = 0;
					$indicadorAnticipo = 1;
                }
                elseif (substr($aConcept->concept, 0, 3) == "Ago")
                {	
					if ($aConcept->concept == "Ago " . $currentDate->year)
					{
						$invoiceLine = $aConcept->student_name . " - Diferencia " . $aConcept->concept;
					}
					else
					{
						$invoiceLine = $aConcept->student_name . " - Abono " . $aConcept->concept;
					}
                    $amountConcept = $aConcept->amount;
                    $this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
                    $loadIndicator = 1;
                    $firstMonthly= " ";
                    $lastInstallment = " ";
                    $amountConcept = 0;
					$indicadorAnticipo = 1;
                }
                elseif (substr($aConcept->concept, 0, 18) == "Servicio educativo")
                {
                    $studentReceipt[$accountReceipt]['studentName'] = $aConcept->student_name;
                    $accountService = $accountService + $aConcept->amount;
                    $accountReceipt++;
                }
                elseif (substr($aConcept->concept) == "Saldo a favor")
                {
                    $montoCredito = $aConcept->amount;
                    $contadorCreditos++;
                }
                elseif (substr($aConcept->concept, 0, 14) == "Seguro escolar")
                {
                    $invoiceLine = $aConcept->student_name . " - Abono " . $aConcept->concept;
                    $amountConcept = $aConcept->amount;
                    $this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
                    $loadIndicator = 1;
                    $firstMonthly= " ";
                    $lastInstallment = " ";
                    $amountConcept = 0;
					$indicadorAnticipo = 1;
                }
                elseif (substr($aConcept->concept, 0, 6) == "Thales")
                {
                    $invoiceLine = $aConcept->student_name . " - " . $aConcept->concept;
                    $amountConcept = $aConcept->amount;
                    $this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
                    $loadIndicator = 1;
                    $firstMonthly= " ";
                    $lastInstallment = " ";
                    $amountConcept = 0;
                }
                else    
                {
                    $invoiceLine = $aConcept->student_name . " - " . "Mensualidad: " . substr($aConcept->concept, 0, 3) . " - ";
                    $amountConcept = $aConcept->amount;
                    $firstMonthly = $aConcept->concept;
                    $lastInstallment = $aConcept->concept;
                    $loadIndicator = 0;
                }
                $previousStudentName = $aConcept->student_name;
                $previousAcccountingCode = $aConcept->accounting_code;
            }
            else
            {
                if ($aConcept->observation == "Migración")
                {
                    if ($lastInstallment != " ")
                    {
                        $invoiceLine .= $lastInstallment;
                        $this->invoiceConcept($previousAcccountingCode, $invoiceLine, $amountConcept);
                        $loadIndicator = 1;
                    }
                    $invoiceLine = $aConcept->concept;
                    $amountConcept = $aConcept->amount;
                    $this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
                    $LoadIndicator = 1;
                    $lastInstallment = " ";
                    $amountConcept = 0;
                }
                elseif ($aConcept->observation == "Abono" && substr($aConcept->concept, 0, 18) != "Servicio educativo")
                {
                    if ($lastInstallment != " ")
                    {
                        $invoiceLine .= $lastInstallment;
                        $this->invoiceConcept($previousAcccountingCode, $invoiceLine, $amountConcept);
                        $loadIndicator = 1;
                    }
                    $invoiceLine = $aConcept->student_name . " - Abono: " . $aConcept->concept;
                    $amountConcept = $aConcept->amount;
                    $this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
                    $LoadIndicator = 1;
                    $lastInstallment = " ";
                    $amountConcept = 0;
                }
                elseif (substr($aConcept->concept, 0, 10) == "Matrícula")
                {
                    if ($lastInstallment != " ")
                    {
                        $invoiceLine .= $lastInstallment;
                        $this->invoiceConcept($previousAcccountingCode, $invoiceLine, $amountConcept);
                        $loadIndicator = 1;
                    }
					$invoiceLine = $aConcept->student_name . " - Inscripción / Dif de Inscripción";
                    $amountConcept = $aConcept->amount;
                    $this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
                    $LoadIndicator = 1;
                    $lastInstallment = " ";
                    $amountConcept = 0;
					$indicadorAnticipo = 1;
                }							
                elseif (substr($aConcept->concept, 0, 3) == "Ago")
                {	
                    if ($lastInstallment != " ")
                    {
                        $invoiceLine .= $lastInstallment;
                        $this->invoiceConcept($previousAcccountingCode, $invoiceLine, $amountConcept);
                        $loadIndicator = 1;
                    }
					if ($aConcept->concept == "Ago " . $currentDate->year)
					{
						$invoiceLine = $aConcept->student_name . " - Diferencia " . $aConcept->concept;
					}
					else
					{
						$invoiceLine = $aConcept->student_name . " - Abono " . $aConcept->concept;
					}
                    $amountConcept = $aConcept->amount;
                    $this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
                    $LoadIndicator = 1;
                    $lastInstallment = " ";
                    $amountConcept = 0;
					$indicadorAnticipo = 1;
                }
                elseif (substr($aConcept->concept, 0, 18) == "Servicio educativo")
                {
                    $studentReceipt[$accountReceipt]['studentName'] = $aConcept->student_name;
                    $accountService = $accountService + $aConcept->amount;
                    $accountReceipt++;
                }
                elseif (substr($aConcept->concept) == "Saldo a favor")
                {
                    $montoCredito = $aConcept->amount;
                    $contadorCreditos++;
                }
                elseif (substr($aConcept->concept, 0, 14) == "Seguro escolar")
                {
                    if ($lastInstallment != " ")
                    {
                        $invoiceLine .= $lastInstallment;
                        $this->invoiceConcept($previousAcccountingCode, $invoiceLine, $amountConcept);
                        $loadIndicator = 1;
                    }
                    $invoiceLine = $aConcept->student_name . " - Abono " . $aConcept->concept;
                    $amountConcept = $aConcept->amount;
                    $this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
                    $LoadIndicator = 1;
                    $lastInstallment = " ";
                    $amountConcept = 0;
					$indicadorAnticipo = 1;
                }
                elseif (substr($aConcept->concept, 0, 6) == "Thales")
                {
                    if ($lastInstallment != " ")
                    {
                        $invoiceLine .= $lastInstallment;
                        $this->invoiceConcept($previousAcccountingCode, $invoiceLine, $amountConcept);
                        $loadIndicator = 1;
                    }
                    $invoiceLine = $aConcept->student_name . " - " . $aConcept->concept;
                    $amountConcept = $aConcept->amount;
                    $this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
                    $LoadIndicator = 1;
                    $lastInstallment = " ";
                    $amountConcept = 0;
                }
                elseif ($lastInstallment == " ")
                {
                    $invoiceLine = $aConcept->student_name . " - " . "Mensualidad: " . substr($aConcept->concept, 0, 3) . " - ";
                    $amountConcept = $aConcept->amount;
                    $firstMonthly = $aConcept->concept;
                    $lastInstallment = $aConcept->concept;
                    $loadIndicator = 0;
                }
                else                
                {
                    $amountConcept = $amountConcept + $aConcept->amount;
                    $lastInstallment = $aConcept->concept;
                }
            }
        }

        if ($loadIndicator == 0 and $lastInstallment != " ")
        {
            if ($firstMonthly== $lastInstallment)
            {
                $invoiceLine .= substr($firstMonthly, 4, 4);
            }
            else
            {
                $invoiceLine .= $lastInstallment;
            }

            $this->invoiceConcept($previousAcccountingCode, $invoiceLine, $amountConcept);
        }

        $payments = $this->Bills->Payments->find('all')->where(['bill_id' => $billId]);

        $aPayments = $payments->toArray();

        $vConcepts = $this->tbConcepts; 
		
		$vista = "invoice";
					
        $this->set(compact('bill', 'vConcepts', 'aPayments', 'studentReceipt', 'accountService', 'billId', 'vista', 'numeroControl', 'indicadorImpresa', 'usuarioResponsable', 'reimpresion', 'indicadorAnticipo', 'numeroFacturaAfectada', 'controlFacturaAfectada', 'idParentsandguardian', 'mensajeUsuario', 'montoCredito', 'contadorCreditos'));
        $this->set('_serialize', ['bill', 'vConcepts', 'aPayments', 'invoiceLineReceipt', 'studentReceipt', 'accountService', 'billId', 'vista', 'numeroControl', 'indicadorImpresa', 'usuarioResponsable', 'reimpresion', 'indicadorAnticipo', 'numeroFacturaAfectada', 'controlFacturaAfectada', 'idParentsandguardian', 'mensajeUsuario', 'montoCredito', 'contadorCreditos']);
    }
	
    public function invoiceConcept($accountingCode, $invoiceLine = null, $amountConcept = null)
    {
        $this->tbConcepts[$this->conceptCounter] = [];
        $this->tbConcepts[$this->conceptCounter]['accountingCode'] = $accountingCode;
        $this->tbConcepts[$this->conceptCounter]['invoiceLine'] = $invoiceLine;
        $this->tbConcepts[$this->conceptCounter]['amountConcept'] = $amountConcept;
        $this->conceptCounter++;
    }
    
    public function salesBook()
    {
        if ($this->request->is('post')) 
        {
            $monthYear = $_POST['month'] . $_POST['year'];

            return $this->redirect(['action' => 'salespdf', $_POST['month'], $_POST['year'], $monthYear, '_ext' => 'pdf']);
        }
    }

    public function salespdf($month = null, $year = null, $monthYear = null)
    {
        $ventas = $this->Bills->find('all', ['conditions' => ['MONTH(date_and_time)' => $month, 'YEAR(date_and_time)' => $year]]);

        $totalAmount = 0;
        $amountCanceled = 0;
        $effectiveAmount = 0;

        foreach ($ventas as $venta) 
        {
            $totalAmount = $totalAmount + $venta->amount;
            if ($venta->annulled == true)
            {
                $amountCanceled = $amountCanceled + $venta->amount;
            }
            else
            {
                $effectiveAmount = $effectiveAmount + $venta->amount;
            }
        }

        $this->viewBuilder()
            ->className('Dompdf.Pdf')
            ->layout('default')
            ->options(['config' => [
                'filename' => $monthYear,
                'render' => 'browser',
                'orientation' => 'landscape'
            ]]);

        $nameOfTheMonth = $this->nameMonth($month);

        $this->set(compact('nameOfTheMonth', 'year', 'ventas', 'totalAmount', 'amountCanceled', 'effectiveAmount'));
    }

    function nameMonth($monthNumber = null)
    {
        $englishMonth=strftime("%B",mktime(0, 0, 0, $monthNumber, 1, 2000)); 
        $monthsSpanish = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $monthsEnglish = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $spanishMonth = str_replace($monthsEnglish, $monthsSpanish, $englishMonth);
        return $spanishMonth;
    }

    public function annulInvoice($idTurn = null, $turn = null)
    {
        $concepts = new ConceptsController();
        
        $payments = new PaymentsController();
		
		$binnacles = new BinnaclesController;
		
		$eventos = new EventosController;
        
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
        
        $dateTurn = Time::now();
		
		$anoMesActual = $dateTurn->year . $dateTurn->month;
		        
        if ($this->request->is('post')) 
        {	
			$ultimoRegistro = $this->Bills->find('all', ['conditions' => ['bill_number' => $_POST['bill_number'], 'OR' => [['tipo_documento' => 'Factura'], ['tipo_documento' => 'Recibo']]], 
				'order' => ['Bills.created' => 'DESC']]); 
								
			$contadorRegistros = $ultimoRegistro->count();
			   
			if ($contadorRegistros > 0)
			{
				$factura = $ultimoRegistro->first();			

				if ($factura->annulled == 1)
				{
					$this->Flash->error(__('Esta factura ya está anulada, intente con otra factura'));
				}
				elseif ($factura->tipo_documento == "Recibo crédito"
				{
					$facturaSobrante = $this->Bills->get($factura->id_documento_padre);
					
					$this->Flash->error(__('Estimado usuario, para anular este recibo debe anular la factura ' . $facturaSobrante->bill_number . ' que originó el sobrante de caja');
				)
				else
				{
					$idBill = $factura->id; 
					
					$anoMesFactura = $factura->date_and_time->year . $factura->date_and_time->month;
		
					if ($anoMesActual == $anoMesFactura || $factura->fiscal == 0)
					{
						if ($factura->moneda_id > 1 && $factura->tasa_cambio != 1)
						{
							$bill = $this->Bills->get($idBill);
							
							$bill->annulled = 1;

							setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
							date_default_timezone_set('America/Caracas');
							
							$bill->date_annulled = Time::now();
																			
							if (!($this->Bills->save($bill))) 
							{
								$this->Flash->error(__('La factura no pudo ser anulada'));
							}
							else 
							{
								$concepts->edit($idBill, $_POST['bill_number'], $factura->tasa_cambio, 0);
								
								$payments->edit($idBill);
																
								$eventos->add('controller', 'Bills', 'annulInvoice', 'Se anuló la factura Nro. ' . $bill->bill_number);
								
								if ($bill->id_recibo_sobrante > 0)
								{
									$reciboSobrante = $this->Bills->get($bill->id_recibo_sobrante);
									$reciboSobrante->annulled = 1;
							
									$reciboSobrante->date_annulled = Time::now();
																			
									if (!($this->Bills->save($reciboSobrante))) 
									{
										$this->Flash->error(__('El recibo del sobrante Nro. '  . $reciboSobrante->bill_number . ' no pudo ser anulado'));
										$binnacles->add('controller', 'Bills', 'recordInvoiceData', 'El recibo del sobrante Nro. ' . $reciboSobrante->bill_number . ' no pudo ser anulado');
									}
									else
									{
										$concepts->edit($reciboSobrante->id, $reciboSobrante->bill_number, $reciboSobrante->tasa_cambio, 1);
								
										$payments->edit($reciboSobrante->id);
								
										$eventos->add('controller', 'Bills', 'annulInvoice', 'Se anuló el recibo Nro. ' . $reciboSobrante->bill_number);
									}
								}			
			
								return $this->redirect(['action' => 'annulledInvoice', $idBill]);
							}
						}
						else
						{
							$this->Flash->error(__('Esta factura no tiene una tarifa de dolar registrada. Por favor contacte al Administrador del sistema'));
						}
					}
					else
					{ 
						$this->Flash->error(__('La factura Nro. ' . $_POST['bill_number'] . ' no es de este mes'));
					}
				}
			}
			else
			{
				$this->Flash->error(__('No se encontró la factura o recibo'));
			}
        }
        $this->set(compact('idTurn', 'turn', 'dateTurn'));
    }
    
    public function annulledInvoice($billId = null)
    {
        $previousStudentName = " ";
        $lastInstallment = " ";
        $invoiceLine = " ";
        $amountConcept = 0;
        $previousAcccountingCode = " ";
 
        $loadIndicator = 0;

        $bill = $this->Bills->get($billId);

        $concepts = $this->Bills->Concepts->find('all')->where(['bill_id' => $billId]);

        $aConcepts = $concepts->toArray();

        foreach ($aConcepts as $aConcept) 
        {                  
            if ($previousStudentName != $aConcept->student_name)
            {
                if ($lastInstallment != " ")
                {
                    $invoiceLine .= $lastInstallment . " - " . $previousStudentName;
                    $this->invoiceConcept($previousAcccountingCode, $invoiceLine, $amountConcept);
                    $locLoadIndicator = 1;
                }
                if ($aConcept->observation == "Abono")
                {
                    $invoiceLine = "Abono: " . $aConcept->concept . " - " . $aConcept->student_name;
                    $amountConcept = $aConcept->amount;
                    $this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
                    $loadIndicator = 1;
                    $lastInstallment = " ";
                }
                else
                {
                    $invoiceLine = "Mensualidad: " . $aConcept->concept . " - ";
                    $amountConcept = $aConcept->amount;
                    $lastInstallment = $aConcept->concept;
                }
                $previousStudentName = $aConcept->student_name;
                $previousAcccountingCode = $aConcept->accounting_code;
            }
            else
            {
                if ($aConcept->observation == "Abono")
                {
                    if ($lastInstallment != " ")
                    {
                        $invoiceLine .= $lastInstallment . " - " . $previousStudentName;
                        $this->invoiceConcept($previousAcccountingCode, $invoiceLine, $amountConcept);
                        $loadIndicator = 1;
                    }
                    $invoiceLine = "Abono: " . $aConcept->concept . " - " . $aConcept->student_name;
                    $amountConcept = $aConcept->amount;
                    $this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
                    $LoadIndicator = 1;
                    $lastInstallment = " ";
                }
                else
                {
                    $amountConcept = $amountConcept + $aConcept->amount;
                    $lastInstallment = $aConcept->concept;
                }
            }
        }
        if ($loadIndicator == 0 and $lastInstallment != " ")
        {
            $invoiceLine .= $lastInstallment . " - " . $previousStudentName;
            $this->invoiceConcept($previousAcccountingCode, $invoiceLine, $amountConcept);
        }

        $payments = $this->Bills->Payments->find('all')->where(['bill_id' => $billId]);

        $aPayments = $payments->toArray();

        $vConcepts = $this->tbConcepts; 

        $this->set(compact('bill', 'vConcepts', 'aPayments'));
        $this->set('_serialize', ['bill', 'vConcepts', 'aPayments']);
    }

    public function editControl()
    {
		$billNumber = 0;
		
        if ($this->request->is('post')) 
        {
			if (isset($_POST['turn']))
			{
				$firstRecord = $this->Bills->find('all', ['conditions' => ['turn' => $_POST['turn']],
                'order' => ['created' => 'ASC'] ]);

				$row = $firstRecord->first();	

				$billNumber = $row->bill_number;
				
				$this->Flash->error(__('Estimado usuario, se saltó uno o más números de control en las facturas. Por favor compare las facturas contra las impresas en papel fiscal, identifique en cual de ellas se saltó el número y haga los correctivos necesarios'));
			}
		}
        $this->set(compact('billNumber'));
        $this->set('_serialize', ['billNumber']);
    }
    
    public function editControlTurn()
    {
        
    }
    
    public function searchInvoice()
    {
        $this->autoRender = false;

        if ($this->request->is('json')) 
        {
            if (!(isset($_POST['invoiceFrom'])))
            {
                die("Solicitud no válida");    
            }
            
            $query = $this->Bills->find('all', ['conditions' => [['bill_number >=' => $_POST['invoiceFrom']], ['fiscal' => 1]],
                'order' => ['Bills.created' => 'ASC']]);

            $bills = $query->toArray();

            $jsondata = [];

            if ($bills)
            {
                $jsondata["success"] = true;
                $jsondata["data"]["message"] = "Se encontraron las facturas";
            
                $jsondata["data"]["invoices"] = [];

                foreach ($bills as $bill)
                {
                    $jsondata["data"]["invoices"][]['id'] = $bill->id;
        
                    $jsondata["data"]["invoices"][]['bill_number'] = $bill->bill_number;
                    
                    $jsondata["data"]["invoices"][]['control_number'] = $bill->control_number;
                    
                    $dateBill = $bill->date_and_time;
                    
                    $dateBillC = $dateBill->day . '-' . $dateBill->month . '-' . $dateBill->year;

                    $jsondata["data"]["invoices"][]['date_and_time'] = $dateBillC;
                    
                    $jsondata["data"]["invoices"][]['client'] = $bill->client;
                            
                    $jsondata["data"]["invoices"][]['amount_paid'] = $bill->amount_paid;
                }
            }
            else
            {
                $jsondata["success"] = false;
                $jsondata["data"]["message"] = "No se encontraron las facturas";
            
                $jsondata["data"]["invoices"] = [];
            }
            exit(json_encode($jsondata, JSON_FORCE_OBJECT));
        }
    }

    public function adjustInvoice()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) 
        {
            $controlNumbers = json_decode($_POST['controlNumber']);
            $_POST = [];
    
            $invoiceIndicator = 0;
			$accountControl = 1;
			$newControl = 0;
    
            foreach ($controlNumbers as $controlNumber) 
            {
				if ($accountControl == 1)
				{
					$newControl = $controlNumber->controlNumber;
				}
    
                $bill = $this->Bills->get($controlNumber->idBill);
                
                $bill->control_number = $newControl;
                
                if (!($this->Bills->save($bill))) 
                {                   
                    $invoiceIndicator = 1; 
                }
				if ($newControl == 0)
				{
					break;
				}
				else
				{
					$accountControl++;
					$newControl++;					
				}
            }        
    
            if ($invoiceIndicator == 0)
            {
                $this->Flash->success(__('Las facturas fueron actualizadas correctamente'));
                
                return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
            }
            else
            {
                $this->Flash->error(__('Alguna factura no fue actualizada, por favor revise e intente nuevamente'));

                return $this->redirect(['controller' => 'Bills', 'action' => 'editControl']);
            }
        }
        else
        {
            $this->Flash->error(__('Por motivos de seguridad se cerró la sesión. Por favor actualice 
                nuevamente los números de control de las facturas'));

            return $this->redirect(['controller' => 'Bills', 'action' => 'editControl']);
        }
    }

    public function adjustInvoiceTurn()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) 
        {
            $controlNumbers = json_decode($_POST['controlNumber']);
            $_POST = [];
    
            $invoiceIndicator = 0;
    
            foreach ($controlNumbers as $controlNumber) 
            {
    
                $bill = $this->Bills->get($controlNumber->idBill);
                
                $bill->control_number = $controlNumber->controlNumber;
                
                if (!($this->Bills->save($bill))) 
                {
                    $this->Flash->error(__('No se pudo actualizar la factura Nro. ' . $bill->bill_number));
                    
                    $invoiceIndicator = 1; 
                }
            }        
    
            if ($invoiceIndicator == 0)
            {
                $this->Flash->success(__('Las facturas fueron actualizadas correctamente'));
                
                return $this->redirect(['controller' => 'Turns', 'action' => 'checkTurnClose']);
            }
            else
            {
                $this->Flash->error(__('Alguna factura no fue actualizada, por favor revise e intente nuevamente'));

                return $this->redirect(['controller' => 'Bills', 'action' => 'editControl']);
            }
        }
        else
        {
            $this->Flash->error(__('Por motivos de seguridad se cerró la sesión. Por favor verifique 
                nuevamente los números de control de las facturas'));

            return $this->redirect(['controller' => 'Bills', 'action' => 'editControl']);
        }

    }
    
    public function consultBill()
    {
        if ($this->request->is('post')) 
        {
            if (isset($_POST['billNumber']))
            {
				$contadorRegistros = 0;
				
                $lastRecord = $this->Bills->find('all', ['conditions' => ['bill_number' => $_POST['billNumber'], 'tipo_documento' => 'Factura'],
                    'order' => ['Bills.created' => 'DESC']]);
					
				$contadorRegistros = $lastRecord->count();
				   
				if ($contadorRegistros > 0)
				{
					$row = $lastRecord->first();			
					return $this->redirect(['controller' => 'Bills', 'action' => 'invoice', $row->id, 1, $row->parentsandguardian_id, 'consultBill']);
				}
				else
				{
					$this->Flash->error(__('La factura Nro. ' . $_POST['billNumber'] . ' no está registrada en el sistema'));
				}
            }
        }
    }

    public function pruebaSqlite()
    {
        
    }

    public function pruebaIntercambioDatos()
    {

    }
    public function monetaryReconversion()
    {				
		$binnacles = new BinnaclesController;
	
		$bills = $this->Bills->find('all', ['conditions' => ['id >' => 0]]);
	
		$account1 = $bills->count();
			
		$account2 = 0;
		
		foreach ($bills as $bill)
        {		
			$billGet = $this->Bills->get($bill->id);
			
			$previousAmount = $billGet->amount;
										
			$billGet->amount = $previousAmount / 100000;
			
			$previousAmount = $billGet->amount_paid;
										
			$billGet->amount_paid = $previousAmount / 100000;
			
			if ($this->Bills->save($billGet))
			{
				$account2++;
			}
			else
			{
				$binnacles->add('controller', 'Bills', 'monetaryReconversion', 'No se actualizó registro con id: ' . $billGet->id);
			}
		}

		$binnacles->add('controller', 'Bills', 'monetaryReconversion', 'Total registros seleccionados: ' . $account1);
		$binnacles->add('controller', 'Bills', 'monetaryReconversion', 'Total registros actualizados: ' . $account2);

		return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
	}	
    public function retornoImpresion()
    {

    }
	
    public function actualizarIndicadorImpresion()
    {
        $this->autoRender = false;
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
        
        $fechaHoy = Time::now();

        if ($this->request->is('json')) 
        {
            $jsondata = [];
			
			$bill = $this->Bills->get($_POST['idFactura']);

			$bill->impresa = true;
			
			if (isset($_POST['reimpresion']))
			{
				if ($_POST['reimpresion'] == 1)
				{
					$bill->fecha_reimpresion = $fechaHoy;
					
					$eventos = new EventosController;
							
					$eventos->add('controller', 'Bills', 'actualizarIndicadorImpresion', 'Se reimprimió la factura Nro. ' . $bill->bill_number);
					
				}
			}
			
			if ($this->Bills->save($bill))
			{
				$jsondata["satisfactorio"] = true;
			}
			else
			{
				$jsondata["satisfactorio"] = false;
			}
            exit(json_encode($jsondata, JSON_FORCE_OBJECT));
        }
    }
    public function indiceRecibos($month = null, $year = null)
    {
        $this->autoRender = false;
        
        $invoicesBills = $this->Bills->find('all', ['conditions' => 
            [['MONTH(date_and_time)' => $month], 
            ['YEAR(date_and_time)' => $year],
            ['Bills.fiscal' => false]],
            'order' => ['Bills.created' => 'ASC'] ]);
            
        return $invoicesBills;
    }
	
	public function notaContable()
	{
	    if ($this->request->is('post')) 
        {
			if (isset($_POST['factura']))
			{
				$facturas = $this->Bills->find('all', ['conditions' => ['bill_number' => $_POST['factura']],
                        'order' => ['created' => 'DESC'] ]);

				$contadorRegistros = $facturas->count();
						
                if ($contadorRegistros > 0)
                {
                    $facturaSolicitada = $facturas->first();
					
					if ($facturaSolicitada->moneda_id > 1 && $facturaSolicitada->tasa_cambio != 1)
					{
						if ($facturaSolicitada->fiscal == 0)
						{
							$this->Flash->error(__('La factura Nro. ' . $_POST['factura'] . ' no es fiscal. Por favor intente con otra factura'));
						}
						elseif ($facturaSolicitada->annulled == 1)
						{
							$this->Flash->error(__('La factura Nro. ' . $_POST['factura'] . ' ya está anulada. Por favor intente con otra factura'));
						}
						else
						{
							return $this->redirect(['controller' => 'Bills', 
													'action' => 'conceptosNotaContable', 
													'Bills',
													'notaContable',
													$facturaSolicitada->id]);
						}
					}
					else
					{
						$this->Flash->error(__('Esta factura no tiene una tarifa de dolar registrada. Por favor contacte al Administrador del sistema'));
					}
				}
				else
				{
					$this->Flash->error(__('No se encontró la factura Nro. ' . $_POST['factura'], ' Por favor intente con otro número'));
				}
			}
		}
	}
	
	public function listaFacturasFamilia($idFamilia = null, $familia = null)
    {	
		$busqueda = $this->Bills->find('all', ['conditions' => ['parentsandguardian_id' => $idFamilia, 'annulled' => 0, 'fiscal' => 1],
            'order' => ['Bills.created' => 'DESC'] ]);				

        $this->set('facturasFamilia', $this->paginate($busqueda));

        $this->set(compact('facturas', 'idFamilia', 'familia'));
        $this->set('_serialize', ['bills', 'idFamilia', 'familia']);
    }
	
	public function conceptosNotaContable($retornoControlador = null, $retornoAccion = null, $idFactura = null, $idFamilia = null, $familia = null)
	{	
	    setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
        
        $fechaHoy = Time::now();
		$mesActual = $fechaHoy->month;
			
		$facturaConceptos = $this->Bills->get($idFactura, ['contain' => ['Concepts']]);
		
		$notasAnteriores = $this->Bills->find('all', ['conditions' => ['id_documento_padre' => $idFactura],
			'order' => ['created' => 'ASC'] ]);
		
		$mesFactura = $facturaConceptos->date_and_time->month;
		
		$this->loadModel('Monedas');	
		
		$moneda = $this->Monedas->get(2);
		$dollarExchangeRate = $moneda->tasa_cambio_dolar;
		
		$moneda = $this->Monedas->get(3);
		$euro = $moneda->tasa_cambio_dolar;
					
		if ($this->request->is('post')) 
        {	
			$tipoNota = $_POST['tipo_nota'];
			
			$montosNotaContable = $_POST['montosNotaContable'];
			
			$_POST = [];
			$acumuladoNota = 0;
			
			foreach ($montosNotaContable as $clave => $valor)
			{				
				if (substr($valor, -3, 1) == ',')
				{
					$valorTemporal= str_replace('.', '', $valor);
					$montosNotaContable[$clave] = str_replace(',', '.', $valorTemporal);
				}
				$acumuladoNota += $montosNotaContable[$clave];
			}
			
            $numeroNotaContable = $this->agregaNotaContable($facturaConceptos, $tipoNota, $acumuladoNota, $dollarExchangeRate, $euro);
			
            if ($numeroNotaContable > 0)
            {
                $documentosUsuario = $this->Bills->find('all', ['conditions' => ['bill_number' => $numeroNotaContable, 'user_id' => $this->Auth->user('id')],
                        'order' => ['Bills.created' => 'DESC'] ]);

				$contadorRegistros = $documentosUsuario->count();
						
                if ($contadorRegistros > 0)
                {
                    $notaContable = $documentosUsuario->first();
                    
                    $idNota = $notaContable->id;

                    foreach ($montosNotaContable as $clave => $valor) 
                    {
						if ($valor > 0)
						{
							$this->loadModel('Concepts');
							$concepto = $this->Concepts->get($clave);
							
							$transaccionEstudiante = new StudenttransactionsController();
							
							$codigoRetornoTransaccion = $transaccionEstudiante->notaTransaccion($concepto->transaction_identifier, $numeroNotaContable, $valor, $tipoNota, $dollarExchangeRate);

							if ($codigoRetornoTransaccion == 0)
							{
								$conceptosFacturas = new ConceptsController();							
								$codigoRetornoConcepto = $conceptosFacturas->agregarConceptosNota($clave, $valor, $numeroNotaContable, $tipoNota, $idNota, $dollarExchangeRate);
								if ($codigoRetornoConcepto > 0)
								{
									break;
								}
							}
							else
							{
								break;
							}
						}
                    }
					$billNumber = $numeroNotaContable;
                    $idParentsandguardian = $facturaConceptos->parentsandguardian_id;
					
					$parentandguardian = $this->Bills->Parentsandguardians->get($idParentsandguardian);
											
					$parentandguardian->balance = $parentandguardian->balance + $acumuladoNota];
						
					if (!($this->Bills->Parentsandguardians->save($parentandguardian)))
					{
						 $this->Flash->error(__('No se pudo actualizar el saldo del representante con id ' . $idParentsandguardian));
					}
					
                    return $this->redirect(['action' => 'imprimirFactura', $billNumber, $idParentsandguardian, $idNota]);
                }
            }
		}		
		
		$this->set(compact('facturaConceptos', 'retornoControlador', 'retornoAccion', 'idFamilia', 'familia', 'mesActual', 'mesFactura', 'notasAnteriores', 'dollarExchangeRate'));
		$this->set('_serialize', ['facturaConceptos', 'retornoControlador', 'retornoAccion', 'idFamilia', 'familia', 'mesActual', 'mesFactura', 'notasAnteriores', 'dollarExchangeRate']);
	}
	
    public function agregaNotaContable($facturaConceptos = null, $tipoNota = null, $acumuladoNota = null, $tasaCambio = null, $euro)
    {			
		if ($tipoNota == "Crédito")
		{
			$consecutivoCredito = new ConsecutivocreditosController();
			$numeroNotaContable = $consecutivoCredito->add();
		}
		else
		{
			$consecutivoDebito = new ConsecutivodebitosController();
			$numeroNotaContable = $consecutivoDebito->add();			
		}
		          
        $notaContable = $this->Bills->newEntity();
		
        $notaContable->parentsandguardian_id = $facturaConceptos->parentsandguardian_id;
		$notaContable->user_id = $this->Auth->user('id');
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
        
        $fechaHoy = Time::now();
		
        $notaContable->date_and_time = date_format($fechaHoy, "Y-m-d");
		
		$this->loadModel('Turns');
		
		$turnos = $this->Turns->find('all')->where(['user_id' => $this->Auth->user('id'), 'status' => true])->order(['created' => 'DESC']);
					
		$contadorRegistros = $turnos->count();
			
		if ($contadorRegistros > 0)
		{
			$ultimoTurno = $turnos->first();
		}
		
        $notaContable->turn = $ultimoTurno->id;
            
        $notaContable->bill_number = $numeroNotaContable;
		
        $notaContable->fiscal = 1;

        $notaContable->school_year = $facturaConceptos->school_year;
        $notaContable->identification = $facturaConceptos->identification;
        $notaContable->client = $facturaConceptos->client;
        $notaContable->tax_phone = $facturaConceptos->tax_phone;
        $notaContable->fiscal_address = $facturaConceptos->fiscal_address;
		$notaContable->amount = 0;
				
		$notaContable->amount_paid = $acumuladoNota;
		$notaContable->annulled = 0;
		$notaContable->date_annulled = 0;
		$notaContable->invoice_migration = 0;
		$notaContable->new_family = 0;
		$notaContable->impresa = 0;
		
		if ($tipoNota == "Crédito")
		{
			$notaContable->tipo_documento = "Nota de crédito";
		}
		else
		{
			$notaContable->tipo_documento = "Nota de débito";
		}
				
		$notaContable->id_documento_padre = $facturaConceptos->id;
		$notaContable->id_anticipo = 0;
		$notaContable->factura_pendiente = 0;
		$notaContable->moneda_id = $facturaConceptos->moneda_id;
		$notaContable->tasa_cambio = $tasaCambio;
		$bill->tasa_euro = $euro;
		$bill->tasa_dolar_euro = $euro / $tasaCambio;
		$bill->saldo_compensado = 0;
		
        if ($this->Bills->save($notaContable)) 
        {
            return $numeroNotaContable;
        }
        else    
        {
            $this->Flash->error(__('La nota de crédito no pudo ser grabada, intente nuevamente'));
        }
    }
    public function consultarRecibo()
    {
        if ($this->request->is('post')) 
        {
            if (isset($_POST['billNumber']))
            {
				$contadorRegistros = 0;
				
                $lastRecord = $this->Bills->find('all', ['conditions' => ['bill_number' => $_POST['billNumber'], 'tipo_documento' => 'Recibo'],
                    'order' => ['Bills.created' => 'DESC']]);
					
				$contadorRegistros = $lastRecord->count();
				   
				if ($contadorRegistros > 0)
				{
					$row = $lastRecord->first();			
					return $this->redirect(['controller' => 'Bills', 'action' => 'invoice', $row->id, 1, $row->parentsandguardian_id, 'consultarRecibo']);
				}
				else
				{
					$this->Flash->error(__('El recibo Nro. ' . $_POST['billNumber'] . ' no está registrado en el sistema'));
				}
            }
        }
    }
    public function consultarNotaCredito()
    {
        if ($this->request->is('post')) 
        {
            if (isset($_POST['billNumber']))
            {
				$contadorRegistros = 0;
				
                $lastRecord = $this->Bills->find('all', ['conditions' => ['bill_number' => $_POST['billNumber'], 'tipo_documento' => 'Nota de crédito'],
                    'order' => ['Bills.created' => 'DESC']]);
					
				$contadorRegistros = $lastRecord->count();
				   
				if ($contadorRegistros > 0)
				{
					$row = $lastRecord->first();			
					return $this->redirect(['controller' => 'Bills', 'action' => 'invoice', $row->id, 1, $row->parentsandguardian_id, 'consultarNotaCredito']);
				}
				else
				{
					$this->Flash->error(__('La nota de crédito Nro. ' . $_POST['billNumber'] . ' no está registrada en el sistema'));
				}
            }
        }
    }
	
    public function consultarNotaDebito()
    {
        if ($this->request->is('post')) 
        {
            if (isset($_POST['billNumber']))
            {
				$contadorRegistros = 0;
				
                $lastRecord = $this->Bills->find('all', ['conditions' => ['bill_number' => $_POST['billNumber'], 'tipo_documento' => 'Nota de débito'],
                    'order' => ['Bills.created' => 'DESC']]);
					
				$contadorRegistros = $lastRecord->count();
				   
				if ($contadorRegistros > 0)
				{
					$row = $lastRecord->first();			
					return $this->redirect(['controller' => 'Bills', 'action' => 'invoice', $row->id, 1, $row->parentsandguardian_id, 'consultarNotaDebito']);
				}
				else
				{
					$this->Flash->error(__('La nota de débito Nro. ' . $_POST['billNumber'] . ' no está registrada en el sistema'));
				}
            }
        }
    }
			
	public function verificarFacturas()
	{
		$this->autoRender = false;
				
		$facturas = $this->Bills->find('all', ['conditions' => ['user_id' => $this->Auth->user('id'), 'impresa' => 0],
            'order' => ['Bills.id' => 'ASC']]);
			
		$contadorRegistros = $facturas->count();
				
		if ($contadorRegistros > 0)
		{
			$facturaSinImprimir = $facturas->first();			
			return $this->redirect(['controller' => 'Bills', 'action' => 'invoice', $facturaSinImprimir->id, 0, $facturaSinImprimir->parentsandguardian_id, 'verificarFacturas']);	
		}	
		else
		{
			return $this->redirect(['controller' => 'Bills', 'action' => 'retornoImpresion']);
		}
	}
	
	public function reciboFactura($idParentsandguardian = null)
	{
		$this->autoRender = false;
		
		$conceptos = new ConceptsController();

		$pagos = new PaymentsController();
		
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
							
		$codigoRetorno = 0;
							
		$recibos = $this->Bills->find('all', ['conditions' => ['annulled' => 0, 'parentsandguardian_id' => $idParentsandguardian, 'fiscal' => 0, 'factura_pendiente' => 1],
            'order' => ['Bills.id' => 'ASC']]);
			
		$contadorRegistros = $recibos->count();
				
		if ($contadorRegistros > 0)
		{
			foreach ($recibos as $recibo)
			{							
				if ($school->current_school_year == substr($recibo->school_year, 13, 4))
				{										
					$resultado = $this->crearFacturaRecibo($recibo);

					if ($resultado['codigoRetorno'] == 0)
					{
						$numeroNuevaFactura = $resultado['numeroNuevaFactura'];
						
						$facturas = $this->Bills->find('all', ['conditions' => ['bill_number' => $numeroNuevaFactura, 'user_id' => $this->Auth->user('id')],
								'order' => ['Bills.id' => 'DESC'] ]);

						$contadorRegistros = $facturas->count();
								
						if ($contadorRegistros > 0)
						{
							$facturaNueva = $facturas->first();
												
							$codigoRetorno = $conceptos->conceptosReciboFactura($recibo->id, $facturaNueva->id);
							
							if ($codigoRetorno == 0)
							{
								$codigoRetorno = $pagos->pagosReciboFactura($recibo->id, $facturaNueva->id, $numeroNuevaFactura);
							}
							else
							{
								break;
							}
						}
						else
						{
							$this->Flash->error(__('No se encontró la nueva factura ' . $numeroNuevaFactura));
							$codigoRetorno = 1;
							break;
						}
					}
					else
					{
						$codigoRetorno = 1;
						break;
					}
				}
			}
		}
		return $codigoRetorno;
	}
	
    public function crearFacturaRecibo($reciboPendiente = null)
    {
		$this->autoRender = false;
		
		$acumuladoServicios = 0;
		
		$binnacles = new BinnaclesController;
		
		$resultado = ['codigoRetorno' => 0, 'numeroNuevaFactura' => 0];
							
        $consecutiveInvoice = new ConsecutiveinvoicesController();
      
		$billNumber = $consecutiveInvoice->add();
				
		$bill = $this->Bills->newEntity();
		$bill->parentsandguardian_id = $reciboPendiente->parentsandguardian_id;
		$bill->user_id = $this->Auth->user('id');
		$bill->date_and_time = $this->headboard['invoiceDate'];
		$bill->turn = $this->headboard['idTurn'];
		
		$bill->bill_number = $billNumber;

		$bill->fiscal = 1;
		$bill->tipo_documento = "Factura";

		$bill->school_year = $reciboPendiente->school_year;
		$bill->identification = $this->headboard['typeOfIdentificationClient'] . ' - ' . $this->headboard['identificationNumberClient'];
		$bill->client = $this->headboard['client'];
		$bill->tax_phone = $this->headboard['taxPhone'];
		$bill->fiscal_address = $this->headboard['fiscalAddress'];
	
		$conceptos = $this->Bills->Concepts->find('all', ['conditions' => ['bill_id' => $reciboPendiente->id, 'SUBSTRING(concept, 1, 18) =' => 'Servicio educativo']]);
		
		$contadorServicios = $conceptos->count();
				
		if ($contadorServicios > 0)
		{
			foreach ($conceptos as $concepto)
			{
				$acumuladoServicios += $concepto->amount;
			}
		}
		
		$bill->amount = $reciboPendiente->amount;
		$bill->amount_paid = $reciboPendiente->amount_paid - $acumuladoServicios;

		$bill->annulled = 0;
		$bill->date_annulled = 0;
		$bill->invoice_migration = 0;
		$bill->new_family = 0;
		$bill->impresa = 0;
		$bill->id_documento_padre = 0;
		$bill->id_anticipo = $reciboPendiente->id;
		$bill->factura_pendiente = 0;
		$bill->moneda_id = 2;
		$bill->tasa_cambio = $reciboPendiente->tasa_cambio;
		$bill->tasa_euro = $reciboPendiente->tasa_euro;
		$bill->tasa_dolar_euro = $reciboPendiente->tasa_dolar_euro;
		$bill->saldo_compensado = $reciboPendiente->saldo_compensado;
		
		if ($this->Bills->save($bill)) 
		{
			$recibo = $this->Bills->get($reciboPendiente->id);
			$recibo->factura_pendiente = 0;
			if ($this->Bills->save($recibo)) 
			{
				$resultado['numeroNuevaFactura'] = $billNumber;
			}
			else
			{
				$binnacles->add('controller', 'Bills', 'crearFacturaRecibo', 'No se pudo actualizar el recibo con ID ' . $reciboPendiente->id);			
				$this->Flash->error(__('No se pudo actualizar el recibo con ID ' . $reciboPendiente->id));
				$resultado['codigoRetorno'] = 1;	
			}
		}
		else    
		{				
			$binnacles->add('controller', 'Bills', 'crearFacturaRecibo', 'No se pudo crear el registro para la factura ' . $billNumber);
			$this->Flash->error(__('No se pudo crear el registro para la factura ' . $billNumber));
			$resultado['codigoRetorno'] = 1;
		}
		return $resultado;
    }
	
	public function reciboCredito($idParentsandguardian = null, $familia = null, $idFactura = null, $monto = null)
	{
		$this->autoRender = false;
		
		$conceptos = new ConceptsController();

		$pagos = new PaymentsController();
				
		$resultado = ['codigoRetorno' => 0, 'idRecibo' => 0];
		
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
														
		$resultadoCrear = $this->crearReciboCredito($idFactura = null);

		if ($resultadoCrear['codigoRetorno'] == 0)
		{
			$numeroRecibo = $resultadoCrear['numeroRecibo'];
						
			$recibos = $this->Bills->find('all', ['conditions' => ['bill_number' => $numeroRecibo, 'user_id' => $this->Auth->user('id')],
					'order' => ['Bills.id' => 'DESC'] ]);

			$contadorRegistros = $recibos->count();
					
			if ($contadorRegistros > 0)
			{
				$recibo = $recibos->first();
				
				$resultado['idRecibo'] = $recibo->id;
									
				$codigoRetorno = $conceptos->conceptosReciboCredito($recibo->id, $monto = null);
				
				if ($codigoRetorno == 0)
				{
					$codigoRetorno = $pagos->pagosReciboCredito($recibo->id, $numeroRecibo, $monto, $this->headboard['idTurn'], $familia);
				}
				else
				{
					$resultado['codigoRetorno'] = 1;
				}
			}
			else
			{
				$this->Flash->error(__('No se encontró el nuevo recibo ' . $numeroRecibo));
				$resultado['codigoRetorno'] = 1;
			}
		}
		else
		{
			$resultado['codigoRetorno'] = 1;
		}	
		return $resultado;
	}
	
    public function crearReciboCredito($billNumber = null, $idDocumentoPadre = null)
    {
        $consecutiveInvoice = new ConsecutiveinvoicesController();
        
        $consecutiveReceipt = new ConsecutivereceiptsController();
		
		$resultado = ['codigoRetorno' => 0, 'numeroRecibo' => 0];

		if ($this->headboard)
		{
			$numeroRecibo = $consecutiveReceipt->add();
			
			$bill = $this->Bills->newEntity();
			$bill->parentsandguardian_id = $this->headboard['idParentsandguardians'];
			$bill->user_id = $this->Auth->user('id');
			$bill->date_and_time = $this->headboard['invoiceDate'];
			$bill->turn = $this->headboard['idTurn'];
			
			$bill->bill_number = $numeroRecibo;
			$bill->fiscal = 0;
			$bill->control_number = $numeroRecibo;
			$bill->tipo_documento = "Recibo crédito";
			
			$bill->school_year = $this->headboard['schoolYear'];
			$bill->identification = $this->headboard['typeOfIdentificationClient'] . ' - ' . $this->headboard['identificationNumberClient'];
			$bill->client = $this->headboard['client'];
			$bill->tax_phone = $this->headboard['taxPhone'];
			$bill->fiscal_address = $this->headboard['fiscalAddress'];
			$bill->amount = 0;
			$bill->amount_paid = $this->headboard['sobrante'];
			$bill->annulled = 0;
			$bill->date_annulled = 0;
			$bill->invoice_migration = 0;
			$bill->new_family = 0;
			$bill->impresa = 0;
			$bill->id_documento_padre = $idDocumentoPadre;
			$bill->id_anticipo = 0;
			$bill->factura_pendiente = 0;
			$bill->moneda_id = 2;
			$bill->tasa_cambio = $this->headboard['tasaDolar'];
			$bill->tasa_euro = $this->headboard['tasaEuro'];
			$bill->tasa_dolar_euro = $this->headboard['tasaDolarEuro'];
			$bill->saldo_compensado = 0;
			
			if (!($this->Bills->save($bill))) 
			{
				$resultado['codigoRetorno'] = 2;
				$this->Flash->error(__('El recibo no pudo ser guardado, intente nuevamente'));
			}
			else
			{
				$resultado['numeroRecibo'] = $numeroRecibo;
			}
		}
		else
		{
			$this->Flash->error(__('La factura no pudo ser guardada. No existe el encabezado de la factura'));
			$resultado['codigoRetorno'] = 1;            
		}

		return $resultado;
    }
	public function reciboReintegro($idParentsandguardian = null, $familia = null, $monto = null)
	{
		$this->autoRender = false;
		
		$conceptos = new ConceptsController();

		$pagos = new PaymentsController();
				
		$resultado = ['codigoRetorno' => 0, 'idRecibo' => 0, 'numeroRecibo' => 0];
		
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
														
		$resultadoCrear = $this->crearReciboReintegro($idParentsandguardian);

		if ($resultadoCrear['codigoRetorno'] == 0)
		{
			$numeroRecibo = $resultadoCrear['numeroRecibo'];
			
			$resultado['numeroRecibo'] = $numeroRecibo;
			
			$recibos = $this->Bills->find('all', ['conditions' => ['bill_number' => $numeroRecibo, 'user_id' => $this->Auth->user('id')],
					'order' => ['Bills.id' => 'DESC'] ]);

			$contadorRegistros = $recibos->count();
					
			if ($contadorRegistros > 0)
			{
				$recibo = $recibos->first();
				
				$resultado['idRecibo'] = $recibo->id;
									
				$codigoRetorno = $conceptos->conceptosReciboReintegro($recibo->id, $monto = null);
			else
			{
				$this->Flash->error(__('No se encontró el nuevo recibo ' . $numeroRecibo));
				$resultado['codigoRetorno'] = 2;
			}
		}
		else
		{
			$resultado['codigoRetorno'] = 1;
		}	
		return $resultado;
	}
	
    public function crearReciboReintegro($idParentsandguardian = null)
    {
        $consecutiveInvoice = new ConsecutiveinvoicesController();
        
        $consecutiveReceipt = new ConsecutivereceiptsController();
		
		$resultado = ['codigoRetorno' => 0, 'numeroRecibo' => 0];
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $currentDate = Time::now();

		if ($this->headboard)
		{
			$numeroRecibo = $consecutiveReceipt->add();
			
			$bill = $this->Bills->newEntity();
			$bill->parentsandguardian_id = $idParentsandguardian;
			$bill->user_id = $this->Auth->user('id');
			$bill->date_and_time = $currentDate;
			
			$this->loadModel('Turns');
			
			$turnos = $this->Turns->find('all')->where(['user_id' => $this->Auth->user('id'), 'status' => true])->order(['id' => 'DESC']);
						
			$contadorRegistros = $turnos->count();
				
			if ($contadorRegistros > 0)
			{
				$ultimoTurno = $turnos->first();
			}
			
			$bill->turn = $ultimoTurno->id;
			
			$bill->bill_number = $numeroRecibo;
			$bill->fiscal = 0;
			$bill->control_number = $numeroRecibo;
			$bill->tipo_documento = "Recibo reintegro";

			$this->loadModel('Schools');
			$school = $this->Schools->get(2);
							
			$bill->school_year = $school->current_school_year
			
			$parentandguardian = $this->Bills->Parentsandguardians->get($idParentsandguardian);
							
			$bill->identification = $parentsandguardian->type_of_identification_client . ' - ' . $parentsandguardian->identification_number_client;
			$bill->client = $parentsandguardian->client;
			$bill->tax_phone = $parentsandguardian->tax_phone;
			$bill->fiscal_address = $parentsandguardian->fiscal_address;
			$bill->amount = 0;
			$bill->amount_paid = $monto;
			$bill->annulled = 0;
			$bill->date_annulled = 0;
			$bill->invoice_migration = 0;
			$bill->new_family = 0;
			$bill->impresa = 0;
			$bill->id_documento_padre = 0;
			$bill->id_anticipo = 0;
			$bill->factura_pendiente = 0;
			$bill->moneda_id = 2;
			
			$this->loadModel('Monedas');	
			$moneda = $this->Monedas->get(2);
			$tasaDolar = $moneda->tasa_cambio_dolar; 
			
			$moneda = $this->Monedas->get(3);
			$tasaEuro = $moneda->tasa_cambio_dolar; 
						
			$bill->tasa_cambio = $tasaDolar;
			$bill->tasa_euro = $tasaEuro;
			$bill->tasa_dolar_euro = $tasaEuro / $tasaDolar;
			$bill->saldo_compensado = 0;
			
			if (!($this->Bills->save($bill))) 
			{
				$resultado['codigoRetorno'] = 2;
				$this->Flash->error(__('El recibo no pudo ser guardado, intente nuevamente'));
			}
			else
			{
				$resultado['numeroRecibo'] = $numeroRecibo;
			}
		}
		else
		{
			$this->Flash->error(__('La factura no pudo ser guardada. No existe el encabezado de la factura'));
			$resultado['codigoRetorno'] = 1;            
		}
		return $resultado;
    }
	
	public function establecerMontoReintegro($idRepresentante = null, $monto = null)
	{
		if ($this->request->is('post')) 
        {
			$resultado = reciboReintegro($idRepresentante, $_POST['monto_reintegro']);
			if ($resultado['codigoRetorno'] == 0)
			{
				$representante = $this->Bills->Parentsandguardians->get($idRepresentante);
				
				$representante->balance = $representante->balance - $_POST['monto_reintegro'];
				
				if (!($this->Bills->Parentsandguardians->save($representante)))
				{
					$this->Flash->error(__('No se pudo actualizar el saldo del representante'));
				}
				else
				{
					return $this->redirect(['controller' => 'Bills', 'action' => 'invoice', $resultado['idRecibo'], 0, $idRepresentante, 'establecerMontoReintegro']);
				}
			}
			else
			{
				$this->Flash->error(__('Estimado usuario no se pudo crear el registro del recibo de reintegro'));
			}
		}
		$this->set(compact('monto'));
        $this->set('_serialize', ['monto']);
	}
}