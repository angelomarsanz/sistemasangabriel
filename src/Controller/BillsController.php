<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\StudenttransactionsController;

use App\Controller\ConceptsController;

use App\Controller\PaymentsController;

use App\Controller\ConsecutiveinvoicesController;

use App\Controller\ConsecutivereceiptsController;

use App\Controller\BinnaclesController;

use Cake\I18n\Time;

class BillsController extends AppController
{
    public $headboard = [];
    public $tbConcepts = [];
    public $conceptCounter = 0;

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
    public function add()
    {
        $consecutiveInvoice = new ConsecutiveinvoicesController();
        
        $consecutiveReceipt = new ConsecutivereceiptsController();
        
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
            }
            else
            {
                $bill->fiscal = 0;
				$bill->control_number = $billNumber;
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

            if ($this->Bills->save($bill)) 
            {
                return $billNumber;
            }
            else    
            {
                $this->Flash->error(__('La factura no pudo ser grabada, intente nuevamente (add-save).'));
            }
        }
        else
        {
            $this->Flash->error(__('La factura no pudo ser grabada, intente nuevamente (add-headboard).'));            
        }
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
		
		$discounts = $this->Discounts->find('list', ['limit' => 200, 
			'order' => ["description_discount" => "ASC"],
			'keyField' => 'id', 
			'valueField' => function ($discount) 
				{
					return $discount->get('label');
				}]);
				
		$this->loadModel('Rates');
		
		$rate = $this->Rates->get(58);
		
		$dollarExchangeRate = $rate->amount; 
				
        $this->set(compact('menuOption', 'idTurn', 'turn', 'dateTurn', 'discounts', 'dollarExchangeRate', 'amountMonthly'));
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
		
		$this->loadModel('Rates');
		
		$rate = $this->Rates->get(58);
		
		$dollarExchangeRate = $rate->amount; 
		
        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => 'Mensualidad'],
            'order' => ['Rates.created' => 'DESC'] ]);
			
		$row = $lastRecord->first();
			
		if ($row)
		{
			$amountMonthly = round($row->amount * $dollarExchangeRate);			
		}
		else
		{
			$amountMonthly = 0;
		}

        if ($this->request->is('post')) 
        {
            $this->headboard = $_POST['headboard']; 
            $transactions = json_decode($_POST['studentTransactions']);
            $payments = json_decode($_POST['paymentsMade']);
            $_POST = [];

            $billNumber = $this->add();

            if ($billNumber)
            {
                $lastRecord = $this->Bills->find('all', ['conditions' => ['bill_number' => $billNumber, 'user_id' => $this->Auth->user('id')],
                        'order' => ['Bills.created' => 'DESC'] ]);

                if ($lastRecord)
                {
                    $row = $lastRecord->first();
                    
                    $billId = $row->id;

                    foreach ($transactions as $transaction) 
                    {
                        $Studenttransactions->edit($transaction->transactionIdentifier, $billNumber, $transaction->originalAmount, $transaction->amountPayable);

                        $Concepts->add($billId, $transaction->studentName, $transaction->transactionIdentifier, 
                            $transaction->monthlyPayment, $transaction->amountPayable, $transaction->observation);
                    }

                    foreach ($payments as $payment) 
                    {
                        $Payments->add($billId, $billNumber, $payment->paymentType, $payment->amountPaid, $payment->bank,
                            $payment->accountOrCard, $payment->serial, $payment->idTurn, $payment->family, $this->headboard['fiscal']);
                    }
                    
                    $idParentsandguardian = $this->headboard['idParentsandguardians'];

                    return $this->redirect(['action' => 'printInvoice', $billNumber, $idParentsandguardian]);
                }
            }
        }
        else
        {
            $this->Flash->error(__('La factura no pudo ser grabada, intente nuevamente (recordInvoiceData)'));            
        }
    }

    public function printInvoice($billNumber = null, $idParentsandguardian = null)
    {
        $parentandguardian = $this->Bills->Parentsandguardians->get($idParentsandguardian);

        $family = $parentandguardian->family;

        $this->Flash->success(__('Factura guardada con el número: ' . $billNumber));

        $this->set(compact('billNumber', 'idParentsandguardian', 'family'));
        $this->set('_serialize', ['billNumber', 'idParentsandguardian', 'family']);
    }

    public function invoicepdf($billNumber = null)
    {
        $this->loadModel('Controlnumbers');

        $lastRecord = $this->Bills->find('all', ['conditions' => ['bill_number' => $billNumber],
            'order' => ['Bills.created' => 'DESC']]);
    
        $bill = $lastRecord->first();
                
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
                
                    if (!($this->Bills->save($billGet)))
                    {
                        $this->Flash->error(__('No se pudo actualizar la factura con el número de control, por favor cuando cierre el turno verifique
                        los números de control de las facturas que aparecen en el reporte'));
                    }
                }
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
        $previousAcccountingCode = " ";
 
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
                }
                elseif (substr($aConcept->concept, 0, 18) == "Servicio educativo")
                {
                    $studentReceipt[$accountReceipt]['studentName'] = $aConcept->student_name;
                    $accountService = $accountService + $aConcept->amount;
                    $accountReceipt++;
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
                }
                elseif (substr($aConcept->concept, 0, 18) == "Servicio educativo")
                {
                    $studentReceipt[$accountReceipt]['studentName'] = $aConcept->student_name;
                    $accountService = $accountService + $aConcept->amount;
                    $accountReceipt++;
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

        $this->viewBuilder()
            ->className('Dompdf.Pdf')
            ->layout('default')
            ->options(['config' => [
                'filename' => $billId,
                'render' => 'browser',
            ]]); 

        $vConcepts = $this->tbConcepts; 

        $this->set(compact('bill', 'vConcepts', 'aPayments', 'studentReceipt', 'accountService'));
        $this->set('_serialize', ['bill', 'vConcepts', 'aPayments', 'invoiceLineReceipt', 'studentReceipt', 'accountService']);
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
        
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
        
        $dateTurn = Time::now();
        
        if ($this->request->is('post')) 
        {
            $bill = $this->Bills->find('all', ['conditions' => ['bill_number' => $_POST['bill_number']]]);

            $aBill = $bill->toArray();
            
            if ($aBill[0]['annulled'])
            {
                $this->Flash->error(__('Esta factura ya está anulada, intente con otra factura'));
            }
            else
            {
                $idBill = $aBill[0]['id']; 
    
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
                    $concepts->edit($idBill, $_POST['bill_number']);
                    
                    $payments->edit($idBill);
                    
                    return $this->redirect(['action' => 'annulledInvoice', $idBill]);
                }
            }
        }
//                return $this->redirect(['action' => 'annulledpdf', $_POST['bill_number'], '_ext' => 'pdf']);
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
                $lastRecord = $this->Bills->find('all', ['conditions' => [['bill_number' => $_POST['billNumber']],['fiscal' => 1]],
                    'order' => ['Bills.created' => 'DESC'] ]);
    
                $row = $lastRecord->first();
            
                if ($row)
                {
                    return $this->redirect(['controller' => 'Bills', 'action' => 'invoicepdf', $_POST['billNumber'], '_ext' => 'pdf']);
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
}