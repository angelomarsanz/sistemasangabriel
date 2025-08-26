<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\StudentsController;

use App\Controller\StudenttransactionsController;

use App\Controller\ConceptsController;

use App\Controller\PaymentsController;

use App\Controller\ConsecutiveinvoicesController;

use App\Controller\ConsecutivereceiptsController;

use App\Controller\RecibosController;

use App\Controller\NotasController;

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
        $facturas = $this->Bills->find('all')->where(['turn <' => 1756]);
		foreach ($facturas as $factura)
		{
			if ($factura->id_turno_anulacion > 0)
			{
				$factura->id_turno_anulacion = 0;
				if (!($this->Bills->save($factura))) 
				{
					$this->Flash->error(__('No se pudo actualizar la factura con el ID '.$factura->id));
				}
			}
		}
    }
	
	public function testFunction2()
	{

	}

    public function isAuthorized($user)
    {
		if(isset($user['role']))
		{
			if ($user['role'] === 'Representante')
			{
				if(in_array($this->request->action, ['pagoRealizado', 'comprobante']))
				{
					return true;
				}				
			}
			// Inicio cambios Seniat
			elseif ($user['role'] === 'Seniat')
			{
				if(in_array($this->request->action, ['createInvoice', 'recordInvoiceData', 'imprimirFactura', 'invoice', 'consultBill', 'actualizarIndicadorImpresion', 'verificarFacturas', 'retornoImpresion', 'consultarNotaCredito', 'consultarNotaDebito', 'notaContable', 'listaFacturasFamilia', 'conceptosNotaContable']))
				{
					return true;
				}				
			}
			// Fin cambios Seniat
		}
        return parent::isAuthorized($user);
    }        
	
    public function index($idFamily = null, $family = null)
    {
        $query = $this->Bills->find('all', ['conditions' => ['parentsandguardian_id' => $idFamily],
                'order' => ['Bills.created' => 'DESC'] ]);

        $this->set('bills', $this->paginate($query));

        $this->set(compact('idFamily', 'family'));
        $this->set('_serialize', ['bills', 'idFamily', 'family']);
    }
    
    public function indexBills($month = null, $year = null)
    {
        $this->autoRender = false;
        
        $invoicesBills = $this->Bills->find('all', ['conditions' => 
            [['MONTH(date_and_time)' => $month], 
            ['YEAR(date_and_time)' => $year],
            ['Bills.fiscal' => true]],
            'order' => ['Bills.control_number' => 'ASC'] ]);
            
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
    public function add($indicadorFacturaPendiente = null, $indicador_servicio_educativo = null, $indicador_seguro = null, $indicadorConsejoEducativo = null)
    {
        $consecutiveInvoice = new ConsecutiveinvoicesController();
		$recibos = new RecibosController();
		$seguros = new SegurosController();
		$consejos = new ConsejosController();
		$notas = new NotasController();
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		$fechaHoraActual = Time::now();
        		
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
					if ($indicador_servicio_educativo == 1)
					{
						$billNumber = $recibos->add();
					}
					elseif ($indicador_seguro == 1)
					{
						$billNumber = $seguros->add();
					}
					elseif ($indicadorConsejoEducativo == 1)
					{
						$billNumber = $consejos->add();
					}
					else
					{
						$billNumber = $notas->add();
					}
				}
				
				$bill = $this->Bills->newEntity();
				$bill->parentsandguardian_id = $this->headboard['idParentsandguardians'];
				$bill->user_id = $this->Auth->user('id');
				$bill->date_and_time = $fechaHoraActual;
				$bill->turn = $this->headboard['idTurn'];
				$bill->id_turno_anulacion = 0;
				
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
					if ($indicadorFacturaPendiente == 1)
					{
						$bill->tipo_documento = "Recibo de anticipo";
					}
					else
					{
						if ($indicador_servicio_educativo == 1)
						{
							$bill->tipo_documento = "Recibo de servicio educativo";
						}
						elseif ($indicador_seguro == 1)
						{
							$bill->tipo_documento = "Recibo de seguro";	
						}
						elseif ($indicadorConsejoEducativo == 1)
						{
							$bill->tipo_documento = "Recibo de Consejo Educativo";	
						}
						else
						{
							$bill->tipo_documento = "Pedido";
						}
					}
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
				$bill->moneda_id = 1;
				$bill->tasa_cambio = $this->headboard['tasaDolar'];
				$bill->tasa_euro = $this->headboard['tasaEuro'];
				$bill->tasa_dolar_euro = $this->headboard['tasaDolarEuro'];
				$bill->saldo_compensado_dolar = $this->headboard['saldoCompensado'];
				$bill->sobrante_dolar = $this->headboard['sobrante'];
				$bill->tasa_temporal_dolar = $this->headboard['tasaTemporalDolar'];
				$bill->tasa_temporal_euro = $this->headboard['tasaTemporalEuro'];
				$bill->cuotas_alumno_becado = $this->headboard['cuotasAlumnoBecado'];
				$bill->cambio_monto_cuota = $this->headboard['cambioMontoCuota'];
				$bill->monto_divisas = $this->headboard['monto_divisas'];
				$bill->monto_igtf = $this->headboard['monto_igtf'];
				
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
		if ($dateTurn->month < 10)
		{
			$mes_actual = "0".$dateTurn->month; 
		}
		else
		{
			$mes_actual = $dateTurn->month; 
		}

		$ano_mes_actual = $dateTurn->year.$mes_actual;

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
			
		$this->loadModel('Schools');
		$school = $this->Schools->get(2);	
		
		$anoEscolarActual = $school->current_school_year; 
		$anoEscolarInscripcion = $school->current_year_registration; 

		$this->loadModel('Rates');
		
		$this->loadModel('Monedas');	
		$moneda = $this->Monedas->get(2);
		$dollarExchangeRate = $moneda->tasa_cambio_dolar; 
		
		$moneda = $this->Monedas->get(3);
		$euro = $moneda->tasa_cambio_dolar; 
					
        $this->set(compact('menuOption', 'idTurn', 'turn', 'dateTurn', 'discounts', 'dollarExchangeRate', 'euro', 'bancosEmisor', 'bancosReceptor', 'anoEscolarActual', 'anoEscolarInscripcion', 'ano_mes_actual'));
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
			$indicador_servicio_educativo = 0;
			$indicador_seguro = 0;
			$indicadorConsejoEducativo = 0;

            $this->headboard = $_POST['headboard']; 
			$idParentsandguardian = $this->headboard['idParentsandguardians'];

			$transactions = json_decode($_POST['studentTransactions']);
            $payments = json_decode($_POST['paymentsMade']);
            $_POST = [];

			if ($this->headboard['fiscal'] == 0)
			{
				if ($this->headboard['indicadorConsejoEducativo'] == 1)
				{
					$indicadorConsejoEducativo = 1;
				}
				else
				{
					foreach ($transactions as $transaction) 
					{
						if (substr($transaction->monthlyPayment, 0, 10) == "Matrícula" || substr($transaction->monthlyPayment, 0, 3) == "Ago")
						{
							if ($this->headboard['indicador_pedido'] == 0)
							{
								$indicadorFacturaPendiente = 1;
							}
						} 
						if (substr($transaction->monthlyPayment, 0, 14) == "Seguro escolar")
						{
							$indicador_seguro = 1;
						}
						if (substr($transaction->monthlyPayment, 0, 18) == "Servicio educativo")
						{
							$indicador_servicio_educativo = 1;
						} 
					}
				}
			}
			
            $billNumber = $this->add($indicadorFacturaPendiente, $indicador_servicio_educativo, $indicador_seguro, $indicadorConsejoEducativo);

            if ($billNumber > 0)
            {
                $facturas = $this->Bills->find('all', ['conditions' => ['bill_number' => $billNumber, 'user_id' => $this->Auth->user('id')],
                        'order' => ['Bills.id' => 'DESC'] ]);

                if ($facturas)
                {
                    $nueva_factura = $facturas->first();
                    
                    $billId = $nueva_factura->id;

					foreach ($transactions as $transaction) 
					{
						if ($indicadorConsejoEducativo == 0)
						{
							$Studenttransactions->edit($transaction, $billNumber, $nueva_factura->tipo_documento);
						}
						$Concepts->add($billId, $transaction, $this->headboard['fiscal']);
					}

                    foreach ($payments as $payment) 
                    {
                        $Payments->add($billId, $billNumber, $payment, $this->headboard['fiscal']);
                    }			

					if ($nueva_factura->fiscal == 1 && $nueva_factura->amount < 0 )
					{ 
						$vector_retorno = $this->agregaNotaCreditoDescuentos($nueva_factura);
						if ($vector_retorno["codigo_retorno"] == 1)
						{
							$binnacles->add('controller', 'Bills', 'recordInvoiceData', 'No se pudo crear la nota de crédito del descuento correspondiente a la factura '.$billNumber);
						} 
					}
										
					if ($this->headboard['saldoCompensado'] > 0 || $this->headboard['sobrante'] > 0)
					{
						$parentsandguardian = $this->Bills->Parentsandguardians->get($idParentsandguardian);
						
						if ($this->headboard['imprimirReciboSobrante'] > 0)
						{
							if ($nueva_factura->fiscal == 1)
							{
								$tipo_recibo = "Recibo de sobrante";									
							}
							else
							{
								$tipo_recibo = "Recibo de sobrante de pedido";
							}
							$resultado = $this->reciboAdicional($idParentsandguardian, $parentsandguardian->family, $billId, $tipo_recibo, 2, "Sobrante", $this->headboard['sobrante']); 
														
							if ($resultado['codigoRetorno'] == 0)
							{
								$factura = $this->Bills->get($billId);
								$factura->id_recibo_sobrante = $resultado['idRecibo'];
														
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
							
							$parentsandguardian->balance += $this->headboard['sobrante']; 
						}
						else
						{							
							$parentsandguardian->balance -= $this->headboard['saldoCompensado'];
											
							$recibosSobrantesCompensados = $this->Bills->find('all', 
							['conditions' => 
								['tipo_documento' => 'Recibo de sobrante',
								'parentsandguardian_id' => $idParentsandguardian,
								'reintegro_sobrante < amount_paid',
								'compensacion_sobrante < amount_paid',
								'annulled' => 0],
							'order' => ['Bills.id' => 'DESC']]);
										
							$contadorRecibosSobrantesCompensados = $recibosSobrantesCompensados->count();
													
							if ($contadorRecibosSobrantesCompensados > 0)
							{
								$saldoCompensadoFactura = $this->headboard['saldoCompensado'];
								$vectorSobrantesCompensados = [];
								
								foreach ($recibosSobrantesCompensados as $recibo)
								{
									if ($saldoCompensadoFactura > 0)
									{
										$reciboSobranteCompensado = $this->Bills->get($recibo->id);
										
										$disponibleParaCompensar = $reciboSobranteCompensado->amount_paid - $reciboSobranteCompensado->reintegro_sobrante - $reciboSobranteCompensado->compensacion_sobrante;							
										
										if ($saldoCompensadoFactura > $disponibleParaCompensar)
										{
											$reciboSobranteCompensado->compensacion_sobrante += $disponibleParaCompensar;
											$saldoCompensadoFactura -= $disponibleParaCompensar;
											$vectorSobrantesCompensados[] = ['id' => $reciboSobranteCompensado->id, 'saldoCompensado' => $disponibleParaCompensar];
										}
										else
										{								
											$reciboSobranteCompensado->compensacion_sobrante += $saldoCompensadoFactura;
											$vectorSobrantesCompensados[] = ['id' => $reciboSobranteCompensado->id, 'saldoCompensado' => $saldoCompensadoFactura];	
											$saldoCompensadoFactura = 0;
										}
																					
										if (!($this->Bills->save($reciboSobranteCompensado)))
										{
											$this->Flash->error(__('No se pudo actualizar el recibo de sobrante con Id : ' . $reciboSobranteCompensado->id));
										}										
									}
									else
									{
										break;
									}
								}
															
								$facturaCompensada = $this->Bills->get($billId);
								$facturaCompensada->vector_sobrantes_compensados = json_encode($vectorSobrantesCompensados);
														
								if (!($this->Bills->save($facturaCompensada)))
								{
									 $this->Flash->error(__('La factura ' . $billNumber . ' No se pudo actualizar con el vector_sobrantes_compensados'));
									 $binnacles->add('controller', 'Bills', 'recordInvoiceData', 'La factura ' . $billNumber . ' No se pudo actualizar con el vector_sobrantes_compensados');
								}
							}
						}
						
						if (!($this->Bills->Parentsandguardians->save($parentsandguardian)))
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
        $parentsandguardian = $this->Bills->Parentsandguardians->get($idParentsandguardian);

        $family = $parentsandguardian->family;

        $this->Flash->success(__('Factura guardada con el número: ' . $billNumber));

        $this->set(compact('billNumber', 'idParentsandguardian', 'family', 'idFactura', 'mensaje'));
        $this->set('_serialize', ['billNumber', 'idParentsandguardian', 'family', 'idFactura', 'mensaje']);
    }

    public function invoice($idFactura = null, $reimpresion = null, $idParentsandguardian = null, $origen = null, $bill_number = null)
    {
        $this->loadModel('Controlnumbers');
		
		$this->loadModel('Users');
		
		$this->loadModel('Monedas');

		$this->loadModel('Schools');

		$school = $this->Schools->get(2);

		$actualAnoInscripcion = $school->current_year_registration;
		
		$anteriorAnoInscripcion = $school->previous_year_registration;

		$proximoAnoInscripcion = $school->next_year_registration;

		$proximoAnoInscripcion2 = $school->next_year_registration + 1;
		
		$mensajeUsuario = "";
		
		$facturaOtroCajero = 0;

		$montoReintegro = 0;

		$periodoEscolarFactura = '';

		$conceptoInscripcion = '';
		
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
						// Nota: El problema que se presenta cuando un usuario consulta una factura o va reimprimir y le aparece la factura de otro usuario es porque no se considera la posibilidad de que haya una factura con número de control mayor
						if ($factura->user_id != $this->Auth->user('id') && $factura->bill_number < $bill_number)
						{
							$facturaOtroCajero = 1;
							break;
						}						
					}
					
					if ($facturaOtroCajero == 1)
					{
						$mensajeUsuario = "Estimado usuario, otro cajero tiene una factura pendiente, espere a que la imprima y luego intente nuevamente imprimir su factura";
						return $this->redirect(['action' => 'imprimirFactura', $bill_number, $idParentsandguardian, $idFactura, $mensajeUsuario]);
					}
					else
					{		
						// Para solucionar el problema se debe usar un foreach e ir descartando si las facturas son de otro usuario. La que no sea de otro usuario se obliga a imprimir
						foreach ($facturas as $factura)
						{		
							if ($factura->user_id == $this->Auth->user('id') && $factura->id < $idFactura)
							{	
								$facturaAnterior = $factura;
							
								if ($facturaAnterior->tipo_documento == "Factura")
								{
									$documento = "esta factura";
								}
								elseif (substr($facturaAnterior->tipo_documento, 0, 6) == "Recibo")
								{
									$documento = "este recibo";
								}
								elseif ($facturaAnterior->tipo_documento == "Pedido")
								{
									$documento = "esta nota";
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
								break;
							}
						}
					}
				}				
			}
		}
		
        $lastRecord = $this->Bills->find('all', 
			[
				'contain' => ['Parentsandguardians'],
				'conditions' => ['Bills.id' => $idFactura],
				'order' => ['Bills.id' => 'DESC']
			]);
					    
        $bill = $lastRecord->first();

		$periodoEscolarFactura = substr($bill->school_year, 13);
		
		if (isset($origen))
		{
			if ($origen == 'verificarFacturas' && $mensajeUsuario == "")
			{				
				$mensajeUsuario = "Ahora por favor imprima esta factura con el Nro. " . $bill->bill_number;
			}
		}
	               
		$usuario = $this->Users->get($bill->user_id);

		$numeroFacturaAfectada = 0;
		$controlFacturaAfectada = 0;

		if ($bill->id_documento_padre > 0)
		{
			$facturaAfectada = $this->Bills->get($bill->id_documento_padre);
			if ($facturaAfectada->tipo_documento == "Factura")
			{
				$numeroFacturaAfectada = $facturaAfectada->bill_number;
				$controlFacturaAfectada = $facturaAfectada->control_number;	
			}
		}
		
		$usuarioResponsable = $usuario->first_name." ".$usuario->surname;
		$inicialesUsuarioResponsable = substr($usuario->first_name, 0, 1).".".substr($usuario->surname, 0, 1).".";
				
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
		$indicadorSobrante = 0;
		$montoSobrante = 0;
        $indicadorReintegro = 0;
		$montoReitegro = 0;
        $indicadorCompra = 0;
		$montoCompra = 0;
        $indicadorVueltoCompra = 0;
		$montoVueltoCompra = 0;		
        $previousAcccountingCode = " ";
		$indicadorAnticipo = 0;
		$conceptoInscripcion = '';
 
        $loadIndicator = 0;
		
		$registroMoneda = $this->Monedas->get($bill->moneda_id);
		$monedaDocumento = $registroMoneda->moneda;
		
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
					$loadIndicator = 1;
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
				elseif ($aConcept->observation == "(Exonerado)" && substr($aConcept->concept, 0, 18) != "Servicio educativo")
				{
					$invoiceLine = $aConcept->student_name . " " . $aConcept->concept . " - (Exonerado)";
					$amountConcept = $aConcept->amount;
					$this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
					$loadIndicator = 1;
					$firstMonthly= " ";
					$lastInstallment = " ";
					$amountConcept = 0;
				}
				elseif (substr($aConcept->concept, 0, 10) == "Matrícula")
				{	
					$invoiceLine = $this->generarConceptosInscripcion($periodoEscolarFactura, $aConcept, 'Matrícula');
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
					$invoiceLine = $this->generarConceptosInscripcion($periodoEscolarFactura, $aConcept, 'Agosto');
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
				elseif ($aConcept->concept == "Sobrante")
				{
					$indicadorSobrante = 1;
					$montoSobrante = $aConcept->amount;
				}
				elseif ($aConcept->concept == "Reintegro")
				{
					$indicadorReintegro = 1;
					$montoReintegro = $aConcept->amount;
				}
			    elseif (substr($aConcept->concept, 0, 10) == "Compra de:")
				{
					$indicadorCompra = 1;
					$montoCompra = $aConcept->amount;
					$invoiceLine = $aConcept->concept;
					$amountConcept = $aConcept->amount;
					$this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
				}
			    elseif (substr($aConcept->concept, 0, 20) == "Vuelto de compra de:")
				{
					$indicadorVueltoCompra = 1;
					$montoVueltoCompra = $aConcept->amount;
					$invoiceLine = $aConcept->concept;
					$amountConcept = $aConcept->amount;
					$this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
				}
				elseif (substr($aConcept->concept, 0, 14) == "Seguro escolar")
				{
					$invoiceLine = $aConcept->student_name." ".$aConcept->concept;
					$amountConcept = $aConcept->amount;
					$this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
					$loadIndicator = 1;
					$firstMonthly= " ";
					$lastInstallment = " ";
					$amountConcept = 0;
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
				elseif ($aConcept->concept == "Descuento por pronto pago")
				{
					$invoiceLine = $aConcept->concept;
					$amountConcept = $aConcept->amount;
					$this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
					$loadIndicator = 1;
					$firstMonthly= " ";
					$lastInstallment = " ";
					$amountConcept = 0;
				}
				elseif ($aConcept->concept == "IGTF")
				{
					$invoiceLine = $aConcept->concept;
					$amountConcept = $aConcept->amount;
					$this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
					$loadIndicator = 1;
					$firstMonthly= " ";
					$lastInstallment = " ";
					$amountConcept = 0;
				}
				elseif (substr($aConcept->concept, 0, 17) == "Consejo Educativo")
				{
					$invoiceLine = $aConcept->concept;
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
				elseif ($aConcept->observation == "(Exonerado)" && substr($aConcept->concept, 0, 18) != "Servicio educativo")
				{
					if ($lastInstallment != " ")
					{
						$invoiceLine .= $lastInstallment;
						$this->invoiceConcept($previousAcccountingCode, $invoiceLine, $amountConcept);
						$loadIndicator = 1;
					}
					$invoiceLine = $aConcept->student_name . " " . $aConcept->concept . " - (Exonerado)";
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
					$invoiceLine = $this->generarConceptosInscripcion($periodoEscolarFactura, $aConcept, 'Matrícula');
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
					$invoiceLine = $this->generarConceptosInscripcion($periodoEscolarFactura, $aConcept, 'Agosto');

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
				elseif ($aConcept->concept == "Sobrante")
				{
					$indicadorSobrante = 1;
					$montoSobrante = $aConcept->amount;
				}
				elseif ($aConcept->concept == "Reintegro")
				{
					$indicadorReintegro = 1;
					$montoReintegro = $aConcept->amount;
				}
			    elseif (substr($aConcept->concept, 0, 10) == "Compra de:")
				{
					$indicadorCompra = 1;
					$montoCompra = $aConcept->amount;
					$invoiceLine = $aConcept->concept;
					$amountConcept = $aConcept->amount;
					$this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
				}
				elseif (substr($aConcept->concept, 0, 14) == "Seguro escolar")
				{
					if ($lastInstallment != " ")
					{
						$invoiceLine .= $lastInstallment;
						$this->invoiceConcept($previousAcccountingCode, $invoiceLine, $amountConcept);
						$loadIndicator = 1;
					}
					$invoiceLine = $aConcept->student_name." ".$aConcept->concept;
					$amountConcept = $aConcept->amount;
					$this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
					$LoadIndicator = 1;
					$lastInstallment = " ";
					$amountConcept = 0;
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
				elseif ($aConcept->concept == "Descuento por pronto pago")
				{
					$invoiceLine = $aConcept->concept;
					$amountConcept = $aConcept->amount;
					$this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
					$loadIndicator = 1;
					$firstMonthly= " ";
					$lastInstallment = " ";
					$amountConcept = 0;
				}
				elseif ($aConcept->concept == "IGTF")
				{
					$invoiceLine = $aConcept->concept;
					$amountConcept = $aConcept->amount;
					$this->invoiceConcept($aConcept->accounting_code, $invoiceLine, $amountConcept);
					$loadIndicator = 1;
					$firstMonthly= " ";
					$lastInstallment = " ";
					$amountConcept = 0;
				}
				elseif (substr($aConcept->concept, 0, 17) == "Consejo Educativo")
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
							
        if ($loadIndicator == 0 && $lastInstallment != " ")
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
        }

        $payments = $this->Bills->Payments->find('all')->where(['bill_id' => $billId]);

        $aPayments = $payments->toArray();

        $vConcepts = $this->tbConcepts; 
		
		$vista = "invoice";
					
        $this->set(compact('bill', 'vConcepts', 'aPayments', 'studentReceipt', 'accountService', 'billId', 'vista', 'numeroControl', 'indicadorImpresa', 'usuarioResponsable', 'inicialesUsuarioResponsable', 'reimpresion', 'indicadorAnticipo', 'numeroFacturaAfectada', 'controlFacturaAfectada', 'idParentsandguardian', 'mensajeUsuario', 'indicadorSobrante', 'montoSobrante', 'indicadorReintegro', 'montoReintegro', 'indicadorCompra', 'montoCompra', 'indicadorVueltoCompra', 'montoVueltoCompra', 'monedaDocumento', 'school', 'periodoEscolarFactura'));

        $this->set('_serialize', ['bill', 'vConcepts', 'aPayments', 'invoiceLineReceipt', 'studentReceipt', 'accountService', 'billId', 'vista', 'numeroControl', 'indicadorImpresa', 'usuarioResponsable', 'inicialesUsuarioResponsable', 'reimpresion', 'indicadorAnticipo', 'numeroFacturaAfectada', 'controlFacturaAfectada', 'idParentsandguardian', 'mensajeUsuario', 'indicadorSobrante', 'montoSobrante', 'indicadorReintegro', 'montoReintegro', 'indicadorCompra', 'montoCompra', 'indicadorVueltoCompra', 'montoVueltoCompra', 'monedaDocumento', 'school', 'periodoEscolarFactura']);
	}
	
	public function invoicepdf()
	{
		$this->viewBuilder()
		->className('Dompdf.Pdf')
		->layout('default')
		->options(['config' => [
			'filename' => 'Factura',
			'render' => 'browser',
			'orientation' => 'landscape'
		]]);
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
		
		$sobrante = 0;
        
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
        
        $dateTurn = Time::now();
		
		$anoMesActual = $dateTurn->year . $dateTurn->month;
		        
        if ($this->request->is('post')) 
        {	
			$ultimoRegistro = $this->Bills->find('all', 
				[
					'conditions' => ['bill_number' => $_POST['bill_number'], 'tipo_documento' => $_POST['tipo_documento']], 
					'order' => ['Bills.created' => 'DESC']
				]); 
								
			$contadorRegistros = $ultimoRegistro->count();
			   
			if ($contadorRegistros > 0)
			{
				$factura = $ultimoRegistro->first();			

				if ($factura->annulled == 1)
				{
					$this->Flash->error(__('Esta factura ya está anulada, intente con otra factura'));
				}
				else
				{
					$idBill = $factura->id; 
					
					$anoMesFactura = $factura->date_and_time->year . $factura->date_and_time->month;
		
					if ($anoMesActual == $anoMesFactura || $factura->fiscal == 0)
					{
						if ($factura->tasa_cambio != 1)
						{
							$bill = $this->Bills->get($idBill);
							
							$bill->annulled = 1;

							setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
							date_default_timezone_set('America/Caracas');
							
							$bill->date_annulled = Time::now();
							$bill->id_turno_anulacion = $idTurn;
																			
							if (!($this->Bills->save($bill))) 
							{
								$this->Flash->error(__('La factura no pudo ser anulada'));
							}
							else 
							{
								$concepts->edit($idBill, $_POST['bill_number'], $factura->tasa_cambio, $factura->tipo_documento, "Anulación");
								
								$payments->edit($idBill);
																
								$eventos->add('controller', 'Bills', 'annulInvoice', 'Se anuló la factura o recibo Nro. ' . $bill->bill_number);

								if ($factura->amount != 0)
								{
									$notas_asociadas = $this->Bills->find('all', 
										[
											'conditions' => ['id_documento_padre' => $factura->id, 'SUBSTRING(tipo_documento, 1, 4) =' => 'Nota']
										]);

									if ($notas_asociadas->count() > 0)
									{
										foreach ($notas_asociadas as $nota)
										{
											$nota_para_anular = $this->Bills->get($nota->id);

											$nota_para_anular->annulled = 1;
									
											$nota_para_anular->date_annulled = Time::now();
																					
											if ($this->Bills->save($nota_para_anular))
											{
												$conceptos_nota = $this->Bills->Concepts->find('all', 
												[
													'conditions' => ['bill_id' => $nota->id]
												]);	

												if ($conceptos_nota->count() > 0)
												{
													foreach ($conceptos_nota as $concepto)
													{
														$concepto_para_anular = $this->Bills->Concepts->get($concepto->id);
			
														$concepto_para_anular->annulled = 1;
												
														if (!($this->Bills->Concepts->save($concepto_para_anular)))
														{		
															$this->Flash->error(__('El concepto de la nota de crédito con el Nro. '.$nota_para_anular->bill_number.' no pudo ser anulado'));
															$eventos->add('controller', 'Bills', 'recordInvoiceData', 'El concepto de la nota de crédito con el Nro. '. $nota_para_anular->bill_number.' no pudo ser anulado');
														}
													}
												}
											}
											else
											{
												$this->Flash->error(__('La nota con el número con el Nro. '.$nota_para_anular->bill_number.' no pudo ser anulada'));
												$eventos->add('controller', 'Bills', 'recordInvoiceData', 'La nota de crédito con el Nro. '. $nota_para_anular->bill_number.' no pudo ser anulada');
											}
										}
									}  	
								}
								if ($bill->id_recibo_sobrante > 0)
								{
									$reciboSobrante = $this->Bills->get($bill->id_recibo_sobrante);
									
									$sobrante = $reciboSobrante->amount_paid; 
									
									$reciboSobrante->annulled = 1;
							
									$reciboSobrante->date_annulled = Time::now();
																			
									if (!($this->Bills->save($reciboSobrante))) 
									{
										$this->Flash->error(__('El recibo del sobrante Nro. '  . $reciboSobrante->bill_number . ' no pudo ser anulado'));
										$binnacles->add('controller', 'Bills', 'recordInvoiceData', 'El recibo del sobrante Nro. ' . $reciboSobrante->bill_number . ' no pudo ser anulado');
									}
									else
									{
										$concepts->edit($reciboSobrante->id, $reciboSobrante->bill_number, $reciboSobrante->tasa_cambio, "Anulación");
																
										$eventos->add('controller', 'Bills', 'annulInvoice', 'Se anuló el recibo Nro. ' . $reciboSobrante->bill_number);
									}
								}

								if ($factura->saldo_compensado_dolar > 0 || $factura->tipo_documento == "Recibo de reintegro" || $sobrante > 0)
								{
									$parentsandguardian = $this->Bills->Parentsandguardians->get($factura->parentsandguardian_id);
																				
									if ($factura->saldo_compensado_dolar > 0)
									{
										$parentsandguardian->balance += $factura->saldo_compensado_dolar;
										
										if ($factura->vector_sobrantes_compensados != null)
										{
											$vectorSobrantesCompensados = json_decode($factura->vector_sobrantes_compensados, true);
											
											foreach ($vectorSobrantesCompensados as $sobranteCompensado)
											{
												$reciboSobranteCompensado = $this->Bills->get($sobranteCompensado['id']);
												
												$reciboSobranteCompensado->compensacion_sobrante -= $sobranteCompensado['saldoCompensado'];
												
												if (!($this->Bills->save($reciboSobranteCompensado)))
												{
													$this->Flash->error(__('No se pudo actualizar el recibo de sobrante con Id : ' . $reciboSobranteCompensado->id));
												}		
											}
										}					
									}
									
									if ($sobrante > 0)
									{
										$parentsandguardian->balance -= $reciboSobrante->amount_paid;
									}

									if ($factura->tipo_documento == "Recibo de reintegro")
									{
										if ($factura->moneda_id == 1)
										{
											$parentsandguardian->balance += round($factura->amount_paid / $factura->tasa_cambio, 2);
										}
										elseif ($factura->moneda_id == 2)
										{
											$parentsandguardian->balance += $factura->amount_paid;
										}
										else
										{
											$parentsandguardian->balance += round($factura->amount_paid * $factura->tasa_dolar_euro, 2);
										}
										
										if ($factura->vector_sobrantes_reintegros != null)
										{
											$vectorRecibosSobrantes = json_decode($factura->vector_sobrantes_reintegros, true);
											
											$saldoSobranteReintegro = round($factura->amount_paid / $factura->tasa_cambio, 2);
																						
											foreach ($vectorRecibosSobrantes as $sobrante)
											{
												if ($saldoSobranteReintegro > 0)
												{
													$reciboSobranteReintegro = $this->Bills->get($sobrante);
												
													if ($reciboSobranteReintegro->reintegro_sobrante >= $saldoSobranteReintegro)
													{													
														$reciboSobranteReintegro->reintegro_sobrante -= $saldoSobranteReintegro;
														$saldoSobranteReintegro = 0;
													}
													else
													{
														$saldoSobranteReintegro -= $reciboSobranteReintegro->reintegro_sobrante;
														$reciboSobranteReintegro->reintegro_sobrante = 0;
													}
												
													if (!($this->Bills->save($reciboSobranteReintegro)))
													{
														$this->Flash->error(__('No se pudo actualizar el recibo de sobrante con ID ' . $reciboSobranteReintegro->id));
														$binnacles->add('controller', 'Bills', 'annulInvoice', 'No se pudo actualizar el recibo de sobrante con ID ' . $reciboSobranteReintegro->id);
													}	
												}
												else
												{
													break;	
												}
											}
										}
									}
										
									if (!($this->Bills->Parentsandguardians->save($parentsandguardian)))
									{
										$this->Flash->error(__('No se pudo actualizar el saldo del representante con id ' . $idParentsandguardian));
										$binnacles->add('controller', 'Bills', 'annulInvoice', 'No se pudo actualizar el saldo del representante con id ' . $idParentsandguardian . ' en la factura ' . $billNumber);
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

        $this->set(compact('idFamilia', 'familia'));
        $this->set('_serialize', ['idFamilia', 'familia']);
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

		$codigoRetornoTransaccion = 0;
					
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
			
            $numeroNotaContable = $this->agregaNotaContable($facturaConceptos, $tipoNota, $acumuladoNota, $facturaConceptos->tasa_cambio, $facturaConceptos->tasa_euro);
			
            if ($numeroNotaContable > 0)
            {
                $documentosUsuario = $this->Bills->find('all', ['conditions' => ['bill_number' => $numeroNotaContable, 'user_id' => $this->Auth->user('id')],
                        'order' => ['Bills.created' => 'DESC'] ]);

				$contadorRegistros = $documentosUsuario->count();
						
                if ($contadorRegistros > 0)
                {
                    $notaContable = $documentosUsuario->first();
                    
                    $idNota = $notaContable->id;
					$conceptosFacturas = new ConceptsController();	

                    foreach ($montosNotaContable as $clave => $valor) 
                    {
						if ($valor > 0)
						{
							$this->loadModel('Concepts');
							$concepto = $this->Concepts->get($clave);
							
							$transaccionEstudiante = new StudenttransactionsController();
							
							if ($concepto->transaction_identifier > 0)
							{
								$codigoRetornoTransaccion = $transaccionEstudiante->notaTransaccion($concepto->transaction_identifier, $numeroNotaContable, $valor, $tipoNota, $facturaConceptos->tasa_cambio);
							}
							if ($codigoRetornoTransaccion == 0)
							{						
								$codigoRetornoConcepto = $conceptosFacturas->agregarConceptosNota($clave, $valor, $numeroNotaContable, $tipoNota, $idNota, $facturaConceptos->tasa_cambio);
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

					if ($facturaConceptos->monto_igtf > 0)
					{
						$codigoRetornoConceptoIgtf = $conceptosFacturas->agregarConceptoNotaIgtf($idNota, $facturaConceptos->monto_igtf, $facturaConceptos->tasa_cambio);

						// $codigo_retorno_concepto_pronto_pago = $conceptosFacturas->agregarConceptoNotaCreditoDescuento($notaContable); temporal

						// Aquí actualizo el nuevo campo saldo del IGTF en la factura original
					}

					$billNumber = $numeroNotaContable;

					$idParentsandguardian = $facturaConceptos->parentsandguardian_id;

					/*
					$parentsandguardian = $this->Bills->Parentsandguardians->get($idParentsandguardian);
					$parentsandguardian->balance = $parentsandguardian->balance + round($acumuladoNota / $facturaConceptos->tasa_cambio);
											
					if (!($this->Bills->Parentsandguardians->save($parentsandguardian)))
					{
						 $this->Flash->error(__('No se pudo actualizar el saldo del representante con id ' . $idParentsandguardian));
					}
					*/
					
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

		// Aquí debo preguntar primero por el saldo del IGTF en la factura original. Si es mayor a cero aplica y verificar el comportamiento cuando es nota de débito
		
		$monto_igtf_bolivares = round($facturaConceptos->monto_igtf * $tasaCambio, 2);			
		$notaContable->amount_paid = round($acumuladoNota + $monto_igtf_bolivares, 2);
		
		/*
		$monto_descuento_positivo = $facturaConceptos->amount * -1;
		$notaContable->amount_paid = round($acumuladoNota + $monto_descuento_positivo, 2);
		*/
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
		$notaContable->tasa_euro = $euro;
		$notaContable->tasa_dolar_euro = $euro / $tasaCambio;
		$notaContable->saldo_compensado = 0;
		
        if ($this->Bills->save($notaContable)) 
        {
            return $numeroNotaContable;
        }
        else    
        {
            $this->Flash->error(__('La nota de crédito no pudo ser grabada, intente nuevamente'));
        }
		$notaContable->monto_igtf = 0;
    }
    public function consultarRecibo()
    {
        if ($this->request->is('post')) 
        {
            if (isset($_POST['billNumber']))
            {
				$contadorRegistros = 0;
				
                $lastRecord = $this->Bills->find('all', ['conditions' => ['bill_number' => $_POST['billNumber'], 'tipo_documento' => $_POST['tipo_documento']], 'order' => ['Bills.created' => 'DESC']]);
					
				$contadorRegistros = $lastRecord->count();
				   
				if ($contadorRegistros > 0)
				{
					$row = $lastRecord->first();			
					return $this->redirect(['controller' => 'Bills', 'action' => 'invoice', $row->id, 1, $row->parentsandguardian_id, 'consultarRecibo']);
				}
				else
				{
					$this->Flash->error(__('El recibo o pedido Nro. ' . $_POST['billNumber'] . ' no está registrado en el sistema'));
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
		$bill->moneda_id = 1;
		$bill->tasa_cambio = $reciboPendiente->tasa_cambio;
		$bill->tasa_euro = $reciboPendiente->tasa_euro;
		$bill->tasa_dolar_euro = $reciboPendiente->tasa_dolar_euro;
		$bill->saldo_compensado_dolar = $reciboPendiente->saldo_compensado;
		$bill->sobrante_dolar = $reciboPendiente->saldo_compensado;
		$bill->tasa_temporal_dolar = $reciboPendiente->tasa_temporal_dolar;
		$bill->tasa_temporal_euro = $reciboPendiente->tasa_temporal_euro;
		$bill->cuotas_alumno_becado = $reciboPendiente->cuotas_alumno_becado;
		$bill->cambio_monto_cuota = $reciboPendiente->cambio_monto_cuota;
		
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
	
	public function reciboAdicional($idParentsandguardian = null, $familia = null, $idFactura = null, $tipoRecibo = null, $moneda = null, $concepto = null, $monto = null)
	{		
		$this->autoRender = false;
				
		$conceptos = new ConceptsController();

		$pagos = new PaymentsController();
				
		$resultado = ['codigoRetorno' => 0, 'idRecibo' => 0];
																
		$resultadoCrear = $this->crearReciboAdicional($idParentsandguardian, $idFactura, $tipoRecibo, $moneda, $monto);

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
									
				$codigoRetorno = $conceptos->conceptosReciboAdicional($recibo->id, $concepto, $monto);
				
				if ($codigoRetorno != 0)
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
	
    public function crearReciboAdicional($idParentsandguardian = null, $idDocumentoPadre = null, $tipoRecibo = null, $moneda = null, $monto = null)
    {       
		$this->autoRender = false;

		$recibos_de_pedidos =
			[
				"Recibo de compra de pedido",
				"Recibo de reintegro de pedido",
				"Recibo de sobrante de pedido",
				"Recibo de vuelto de compra de pedido"
			];

		$indicador_recibo_de_pedido = 0;

		$resultado = ['codigoRetorno' => 0, 'numeroRecibo' => 0];

		foreach ($recibos_de_pedidos as $recibo)
		{
			if ($recibo == $tipoRecibo)
			{
				$indicador_recibo_de_pedido = 1;
				break;
			}
		}

		if ($indicador_recibo_de_pedido == 1)
		{
        	$recibo_pedido = new RecibospedidosController();		
			$numeroRecibo = $recibo_pedido->add();
		}
		else
		{								               
        	$consecutiveReceipt = new ConsecutivereceiptsController();		
			$numeroRecibo = $consecutiveReceipt->add();
		}
		
		$bill = $this->Bills->newEntity();
		
		if (!(empty($this->headboard)))
		{
			$bill->parentsandguardian_id = $this->headboard['idParentsandguardians'];
			$bill->user_id = $this->Auth->user('id');
			$bill->date_and_time = $this->headboard['invoiceDate'];
			$bill->turn = $this->headboard['idTurn'];						
			$bill->school_year = $this->headboard['schoolYear'];
			$bill->identification = $this->headboard['typeOfIdentificationClient'] . ' - ' . $this->headboard['identificationNumberClient'];
			$bill->client = $this->headboard['client'];
			$bill->tax_phone = $this->headboard['taxPhone'];
			$bill->fiscal_address = $this->headboard['fiscalAddress'];
			$bill->tasa_cambio = $this->headboard['tasaDolar'];
			$bill->tasa_euro = $this->headboard['tasaEuro'];
			$bill->tasa_dolar_euro = $this->headboard['tasaDolarEuro'];
		}
		else
		{
			setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
			date_default_timezone_set('America/Caracas');

			$currentDate = Time::now();

			$this->loadModel('Turns');
			
			$turnos = $this->Turns->find('all')->where(['user_id' => $this->Auth->user('id'), 'status' => true])->order(['id' => 'DESC']);
						
			$contadorRegistros = $turnos->count();
				
			if ($contadorRegistros > 0)
			{
				$ultimoTurno = $turnos->first();
			}
			
			$this->loadModel('Schools');
			$school = $this->Schools->get(2);
			
			$this->loadModel('Monedas');	
			$registroMoneda = $this->Monedas->get(2);
			$tasaDolar = $registroMoneda->tasa_cambio_dolar; 
			
			$registroMoneda = $this->Monedas->get(3);
			$tasaEuro = $registroMoneda->tasa_cambio_dolar; 
								
			$bill->parentsandguardian_id = $idParentsandguardian;
			$bill->user_id = $this->Auth->user('id');
			$bill->date_and_time = $currentDate;
			$bill->turn = $ultimoTurno->id;
			$bill->school_year = $school->current_school_year;
		
			if ($tipoRecibo == "Recibo de compra" || $tipoRecibo == "Recibo de compra de pedido")
			{
				$bill->identification = "J - 075730844";
				$bill->client = "U.E. Colegio San Gabriel Arcángel";
				$bill->tax_phone = "";
				$bill->fiscal_address = "";				
			}
			else
			{
				$parentsandguardian = $this->Bills->Parentsandguardians->get($idParentsandguardian);
						
				$bill->identification = $parentsandguardian->type_of_identification_client . ' - ' . $parentsandguardian->identification_number_client;
				$bill->client = $parentsandguardian->client;
				$bill->tax_phone = $parentsandguardian->tax_phone;
				$bill->fiscal_address = $parentsandguardian->fiscal_address;
			}
			
			$bill->tasa_cambio = $tasaDolar;
			$bill->tasa_euro = $tasaEuro;
			$bill->tasa_dolar_euro = $tasaEuro / $tasaDolar;
		}
		
		$bill->bill_number = $numeroRecibo;
		$bill->fiscal = 0;
		$bill->control_number = $numeroRecibo;
		$bill->tipo_documento = $tipoRecibo;
		$bill->amount = 0;
		$bill->amount_paid = $monto;
		$bill->annulled = 0;
		$bill->date_annulled = 0;
		$bill->invoice_migration = 0;
		$bill->new_family = 0;
		$bill->impresa = 0;
		$bill->id_documento_padre = $idDocumentoPadre;
		$bill->id_anticipo = 0;
		$bill->factura_pendiente = 0;
		$bill->moneda_id = $moneda;				
		$bill->saldo_compensado_dolar = 0;
		$bill->sobrante_dolar = 0;		
		
		if (!($this->Bills->save($bill))) 
		{
			$resultado['codigoRetorno'] = 2;
			$this->Flash->error(__('El recibo no pudo ser guardado, intente nuevamente'));
		}
		else
		{
			$resultado['numeroRecibo'] = $numeroRecibo;
		}
		
		return $resultado;
    }
			
	public function establecerMontoReintegro($idRepresentante = null, $monto = null)
	{
		$contadorRecibosSobrantes = 0;

		$this->loadModel('Turns');

		$turnosAbiertos = $this->Turns->find('all')->where(['user_id' => $this->Auth->user('id'), 'status' => true])->order(['created' => 'DESC']);
        
        if ($turnosAbiertos->count() > 0)
        {
			$turnoAbierto = $turnosAbiertos->first();
			$vector_efectivos = $this->calcular_disponibilidad_efectivo($turnoAbierto->id);
		}
		else
		{
			$this->Flash->error(__('Estimado usuario primero debe abrir un turno antes de hacer un reintegro'));
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
		}
		
		if ($this->request->is(['patch', 'post', 'put']))
        {		
			if ($_POST["origen"] == "Facturas")
			{
				$tipo_recibo = "Recibo de reintegro";
			}
			else
			{
				$tipo_recibo = "Recibo de reintegro de pedido";
			}
							
			$resultado = $this->reciboAdicional($idRepresentante, "", 0, $tipo_recibo, 2, "Reintegro", $_POST['monto_reintegro']);
			
			if ($resultado['codigoRetorno'] == 0)
			{
				$this->loadModel('Turns');
				
				$turnos = $this->Turns->find('all')->where(['user_id' => $this->Auth->user('id'), 'status' => true])->order(['id' => 'DESC']);
							
				$contadorRegistros = $turnos->count();
				
				if ($contadorRegistros > 0)
				{
					$ultimoTurno = $turnos->first();
				}
				
				$recibosSobrantes = $this->Bills->find('all', 
					['conditions' => 
						['tipo_documento' => 'Recibo de sobrante',
						'parentsandguardian_id' => $idRepresentante,
						'reintegro_sobrante < amount_paid',
						'compensacion_sobrante < amount_paid',
						'annulled' => 0],
					'order' => ['Bills.id' => 'DESC']]);
										
				$contadorRecibosSobrantes = $recibosSobrantes->count();
												
				if ($contadorRecibosSobrantes > 0)
				{
					$saldoReintegro = $_POST['monto_reintegro'];
					$vectorRecibosSobrantes = [];
					
					foreach ($recibosSobrantes as $recibo)
					{
						if ($saldoReintegro > 0)
						{
							$reciboSobrante = $this->Bills->get($recibo->id);
							
							$disponibleParaReintegrar = $reciboSobrante->amount_paid - $reciboSobrante->reintegro_sobrante - $reciboSobrante->compensacion_sobrante;							
							
							if ($saldoReintegro > $disponibleParaReintegrar)
							{
								$reciboSobrante->reintegro_sobrante += $disponibleParaReintegrar;
								$saldoReintegro -= $disponibleParaReintegrar;
							}
							else
							{								
								$reciboSobrante->reintegro_sobrante += $saldoReintegro;
								$saldoReintegro = 0;
							}
							$vectorRecibosSobrantes[] = $recibo->id;
							
							if (!($this->Bills->save($reciboSobrante)))
							{
								$this->Flash->error(__('No se pudo actualizar el recibo de sobrante con Id : ' . $reciboSobrante->id));
							}							
						}
						else
						{
							break;
						}
					}
					
					$reciboReintegro = $this->Bills->get($resultado['idRecibo']);
					
					$reciboReintegro->vector_sobrantes_reintegros = json_encode($vectorRecibosSobrantes);
					if (!($this->Bills->save($reciboReintegro)))
					{
						$this->Flash->error(__('No se pudo actualizar el recibo de reintegro con el vector de sobrantes: ' . $reciboReintegro->id));
					}
				}

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
		$this->set(compact('monto', 'vector_efectivos'));
        $this->set('_serialize', ['monto', 'vector_efectivos']);
	}

	public function compra()
	{
		if ($this->request->is(['patch', 'post', 'put']))
        {
			if ($_POST["origen"] == "Facturas")
			{
				$tipo_recibo = "Recibo de compra";
			}
			else
			{
				$tipo_recibo = "Recibo de compra de pedido";
			}
			$resultado = $this->reciboAdicional(1, "", 0, $tipo_recibo, $_POST['moneda'], "Compra de: " . $_POST['concepto'], $_POST['monto']);
			if ($resultado['codigoRetorno'] == 0)
			{
				return $this->redirect(['controller' => 'Bills', 'action' => 'invoice', $resultado['idRecibo'], 0, 1, 'compra']);
			}
			else
			{
				$this->Flash->error(__('Estimado usuario no se pudo crear el recibo de compra'));
			}
		}
		$this->loadModel('Turns');

		$turnosAbiertos = $this->Turns->find('all')->where(['user_id' => $this->Auth->user('id'), 'status' => true])->order(['created' => 'DESC']);
        
        if ($turnosAbiertos->count() > 0)
        {
			$turnoAbierto = $turnosAbiertos->first();
			$vector_efectivos = $this->calcular_disponibilidad_efectivo($turnoAbierto->id);
		}
		else
		{
			$this->Flash->error(__('Estimado usuario primero debe abrir un turno antes de hacer una compra'));
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
		}
		$this->set(compact('vector_efectivos'));
        $this->set('_serialize', ['vector_efectivos']);
	}
	
	public function vueltoCompra()
	{
		$monedas = [1 => "Bs.", 2 => "$", 3 => "€"]; 

		$this->loadModel('Turns');
		$turnos = $this->Turns->find('all')->where(['user_id' => $this->Auth->user('id'), 'status' => true])->order(['created' => 'DESC']);
               
        if ($turnos->count() > 0)
        {
			$turno_abierto = $turnos->first();
		}
		else
		{
			$this->Flash->error(__('Estimado usuario usted no tiene un turno abierto'));
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);	
		}

		$recibos = $this->Bills->Concepts->find('all')
			->contain(['Bills'])
			->where(['Bills.turn' => $turno_abierto->id, 'Bills.annulled' => 0, 'SUBSTRING(Bills.tipo_documento, 1, 16) =' => 'Recibo de compra']);

		$opciones_recibos = [];
		$opciones_recibos[null] = "";

		foreach ($recibos as $recibo)
		{
			$moneda_recibo = "";
			foreach ($monedas as $indice => $valor)
			{
				if ($indice == $recibo->bill->moneda_id)
				{
					$moneda_recibo = $valor;
					break;
				}
			}
			$opciones_recibos[$recibo->bill->id] = "Nro. ".$recibo->bill->bill_number." - ".$recibo->concept." - ".$moneda_recibo." ".number_format($recibo->bill->amount_paid, 2, ",", ".");
		}


		if ($this->request->is(['patch', 'post', 'put']))
        {
			$tipo_recibo = "Recibo de vuelto de compra";
			foreach ($recibos as $recibo)
			{
				if ($_POST["id_recibo_original"] == $recibo->bill->id)
				{
					if ($recibo->bill->tipo_documento == "Recibo de compra")
					{
						$tipo_recibo = "Recibo de vuelto de compra";
					}
					else
					{
						$tipo_recibo = "Recibo de vuelto de compra de pedido";
					}
					break;
				}
			}

			$resultado = $this->reciboAdicional(1, "", 0, $tipo_recibo, $_POST['moneda'], "Vuelto de compra de: " . $_POST['concepto'], $_POST['monto']);
			
			if ($resultado['codigoRetorno'] == 0)
			{
				return $this->redirect(['controller' => 'Bills', 'action' => 'invoice', $resultado['idRecibo'], 0, 1, 'compra']);
			}
			else
			{
				$this->Flash->error(__('Estimado usuario no se pudo crear el recibo de compra'));
			}
		}
		$this->set(compact('opciones_recibos'));
        $this->set('_serialize', ['opciones_recibos']);
	}
	public function pagoRealizado()
	{
		
	}
	public function comprobante()
	{
		
	}
	public function pagosPendientesRevision()
	{
		
	}
	public function detallePagoRealizado()
	{
		
	}
	public function facturaPendienteImpresion()
	{
		
	}
	public function listadoFacturasPorImprimir()
	{
		
	}
	public function actualizarTasasDivisas()
	{
		
	}

    public function pedidoPorFactura()
    {        
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
		
        $concepts = new ConceptsController();       
        $payments = new PaymentsController();
		$binnacles = new BinnaclesController;
		$eventos = new EventosController;
		$consecutiveInvoice = new ConsecutiveinvoicesController();

		$this->loadModel('Turns');

		$turnosAbiertos = $this->Turns->find('all')->where(['user_id' => $this->Auth->user('id'), 'status' => true])->order(['created' => 'DESC']);
        
        $contadorTurnos = $turnosAbiertos->count(); 
        
        if ($contadorTurnos > 0)
        {
			$turnoActual = $turnosAbiertos->first();
            $fechaTurno = $turnoActual->start_date;
            $fechaTurnoInvertida = $fechaTurno->year . $fechaTurno->month . $fechaTurno->day;
            $fechaActual = Time::now();
            $fechaActualInvertida = $fechaActual->year . $fechaActual->month . $fechaActual->day;

            if ($fechaTurnoInvertida != $fechaActualInvertida)
            {
                $this->Flash->error(__('Por favor cierre el turno, porque no coincide con la fecha de hoy y luego abra un turno nuevo')); 
            }
        }
        else
        {
            $this->Flash->error(__('Usted no tiene un turno abierto, por favor abra un turno para poder sustituir el pedido por factura'));  
        }
        
		$this->loadModel('Bancos');

		if ($this->request->is('post')) 
        {
			$ultimoRegistro = $this->Bills->find('all', 
				[
					'conditions' => ['bill_number' => $_POST['numero_del_pedido'], 'tipo_documento' => "Pedido"], 
					'order' => ['Bills.created' => 'DESC']
				]); 
								
			$contadorRegistros = $ultimoRegistro->count();
				
			if ($contadorRegistros > 0)
			{
				$pedido = $ultimoRegistro->first();			

				if ($pedido->annulled == 1)
				{
					$ultimoRegistro = $this->Bills->find('all', 
					[
						'conditions' => ['id_documento_padre' => $pedido->id , 'tipo_documento' => "Factura"], 
						'order' => ['Bills.created' => 'DESC']
					]); 
									
					$contadorRegistros = $ultimoRegistro->count();
					
					if ($contadorRegistros > 0)
					{
						$factura_sustituta = $ultimoRegistro->first();

						if ($factura_sustituta->control_number === null || $factura_sustituta->impresa == 0)
						{
							$this->Flash->error(__('Este pedido fue anulado, pero no se ha impreso su correspondiente factura. Por favor imprima la factura '.$factura_sustituta->bill_number));
						}
						else
						{
							$this->Flash->error(__('Este pedido ya fue anulado anteriormente'));
						}
					}	
					else
					{
						$this->Flash->error(__('Este pedido ya fue anulado anteriormente'));
					}
				}
				else
				{						
					$pedido = $this->Bills->get($pedido->id);
					$idPedido = $pedido->id;
					
					$pedido->annulled = 1;	
					
					$pedido->date_annulled = Time::now();
					$pedido->id_turno_anulacion = $turnoActual->id;
																	
					if (!($this->Bills->save($pedido))) 
					{
						$this->Flash->error(__('El pedido no pudo ser anulado'));
					}
					else 
					{
						$concepts->edit($idPedido, $_POST['numero_del_pedido'], $pedido->tasa_cambio, $pedido->tipo_documento, "Sustitución");
						
						$payments->edit($idPedido);
														
						$eventos->add('controller', 'Bills', 'pedidoPorFactura', 'Se anuló la pedido Nro. '.$pedido->bill_number);

						$this->loadModel('Monedas');	
						$moneda = $this->Monedas->get(2);
						$tasa_dolar = $moneda->tasa_cambio_dolar; 
						$moneda = $this->Monedas->get(3);
						$tasa_euro = $moneda->tasa_cambio_dolar;
						$tasa_dolar_euro = round($tasa_euro/$tasa_dolar, 2);

						$nuevaFactura = $this->Bills->newEntity();

						$nuevaFactura->parentsandguardian_id = $pedido->parentsandguardian_id;
						$nuevaFactura->user_id = $pedido->user_id;
						$nuevaFactura->date_and_time = Time::now();;
						$nuevaFactura->turn = $turnoActual->id;
						$nuevaFactura->id_turno_anulacion = 0;						
						$nuevaFactura->bill_number = $consecutiveInvoice->add();
						$nuevaFactura->fiscal = 1;
						$nuevaFactura->tipo_documento = "Factura";
						$nuevaFactura->school_year = $pedido->school_year;
						$nuevaFactura->identification = $pedido->identification;
						$nuevaFactura->client = $pedido->client;
						$nuevaFactura->tax_phone = $pedido->tax_phone;
						$nuevaFactura->fiscal_address = $pedido->fiscal_address;
						
						$monto_dolar_descuento = round($pedido->amount/$pedido->tasa_cambio, 2);
						$nuevo_monto_bolivar_descuento = round($monto_dolar_descuento * $tasa_dolar, 2);

						$monto_dolar_pagado = round($pedido->amount_paid/$pedido->tasa_cambio, 2);
						$nuevo_monto_bolivar_pagado = round($monto_dolar_pagado * $tasa_dolar, 2);

						$nuevaFactura->amount = $nuevo_monto_bolivar_descuento;
						$nuevaFactura->amount_paid = $nuevo_monto_bolivar_pagado;
						$nuevaFactura->annulled = 0;
						$nuevaFactura->date_annulled = 0;
						$nuevaFactura->invoice_migration = 0;
						$nuevaFactura->new_family = 0;
						$nuevaFactura->impresa = 0;
						$nuevaFactura->id_documento_padre = $pedido->id;
						$nuevaFactura->id_anticipo = 0;
						$nuevaFactura->factura_pendiente = $pedido->factura_pendiente;
						$nuevaFactura->moneda_id = 1;
						$nuevaFactura->tasa_cambio = $tasa_dolar;
						$nuevaFactura->tasa_euro = $tasa_euro;
						$nuevaFactura->tasa_dolar_euro = $tasa_dolar_euro;
						$nuevaFactura->saldo_compensado_dolar = $pedido->saldo_compensado_dolar;
						$nuevaFactura->sobrante_dolar = $pedido->sobrante_dolar;
						$nuevaFactura->tasa_temporal_dolar = $pedido->tasa_temporal_dolar;
						$nuevaFactura->tasa_temporal_euro = $pedido->tasa_temporal_euro;
						$nuevaFactura->cuotas_alumno_becado = $pedido->cuotas_alumno_becado;
						$nuevaFactura->cambio_monto_cuota = $pedido->cambio_monto_cuota;
						$nuevaFactura->monto_divisas = $pedido->monto_divisas;
						$nuevaFactura->monto_igtf = $pedido->monto_igtf;
						if (!($this->Bills->save($nuevaFactura))) 
						{
							$this->Flash->error(__('La factura no pudo ser guardada'));
						}
						else
						{
							$ultimoRegistro = $this->Bills->find('all', 
							[
								'conditions' => ['bill_number' => $nuevaFactura->bill_number], 
								'order' => ['Bills.created' => 'DESC']
							]); 
											
							$factura = $ultimoRegistro->first();	
							$codigo_retorno_conceptos = $concepts->conceptosPedidoFactura($idPedido, $factura->id, $pedido->tasa_cambio, $tasa_dolar);

							if ($codigo_retorno_conceptos == 0)
							{
								$codigo_retorno_pagos = $payments->pagosPedidoFactura($idPedido, $factura->id, $factura->bill_number, $turnoActual->id, $_POST);
								if ($codigo_retorno_pagos == 0)
								{
									if ($factura->amount < 0)
									{
										$vector_retorno = $this->agregaNotaCreditoDescuentos($factura);
										if ($vector_retorno["codigo_retorno"] == 1)
										{
											$eventos->add('controller', 'Bills', 'pedidoPorFactura', 'No se pudo crear la nota de crédito correspondiente a la factura'.$factura->bill_number);
											return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
										}
									}
									return $this->redirect(['controller' => 'Bills', 'action' => 'invoice', $factura->id, 0, $factura->parentsandguardian_id, 'pedidoPorFactura', $factura->id]);
								}
								else
								{
									$eventos->add('controller', 'Bills', 'pedidoPorFactura', 'No se pudieron crear los pagos correspondientes a la factura'.$factura->bill_number);
									return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
								}
							}
							else
							{
								$eventos->add('controller', 'Bills', 'pedidoPorFactura', 'No se pudieron crear los conceptos correspondientes a la factura'.$factura->bill_number);
								return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
							}
						}
					}
				}
			}				
		}

		$banco_emisor = $this->Bancos->find('list', ['limit' => 200, 
			'conditions' => ['tipo_banco' => 'Emisor'],
			'order' => ['nombre_banco' => 'ASC'],
			'keyField' => 'nombre_banco']);
						
		$banco_receptor = $this->Bancos->find('list', ['limit' => 200, 
			'conditions' => ['tipo_banco' => 'Receptor'],
			'order' => ['nombre_banco' => 'ASC'],
			'keyField' => 'nombre_banco']);
						
        $this->set(compact('banco_emisor', 'banco_receptor'));
    }

    public function pedidoPorFacturaPlanificado()
    {        
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
		
        $concepts = new ConceptsController();       
        $payments = new PaymentsController();
		$binnacles = new BinnaclesController;
		$eventos = new EventosController;
		$consecutiveInvoice = new ConsecutiveinvoicesController();

		$this->loadModel('Turns');

		$turnosAbiertos = $this->Turns->find('all')->where(['user_id' => $this->Auth->user('id'), 'status' => true])->order(['created' => 'DESC']);
        
        $contadorTurnos = $turnosAbiertos->count(); 
        
        if ($contadorTurnos > 0)
        {
			$turnoActual = $turnosAbiertos->first();
            $fechaTurno = $turnoActual->start_date;
            $fechaTurnoInvertida = $fechaTurno->year . $fechaTurno->month . $fechaTurno->day;
            $fechaActual = Time::now();
            $fechaActualInvertida = $fechaActual->year . $fechaActual->month . $fechaActual->day;

            if ($fechaTurnoInvertida != $fechaActualInvertida)
            {
                $this->Flash->error(__('Por favor cierre el turno, porque no coincide con la fecha de hoy y luego abra un turno nuevo')); 
            }
        }
        else
        {
            $this->Flash->error(__('Usted no tiene un turno abierto, por favor abra un turno para poder sustituir el pedido por factura'));  
        }
        
		$this->loadModel('Bancos');

		if ($this->request->is('post')) 
        {
			$ultimoRegistro = $this->Bills->find('all', 
				[
					'conditions' => ['bill_number' => $_POST['numero_del_pedido'], 'tipo_documento' => "Pedido"], 
					'order' => ['Bills.created' => 'DESC']
				]); 
								
			$contadorRegistros = $ultimoRegistro->count();
				
			if ($contadorRegistros > 0)
			{
				$pedido = $ultimoRegistro->first();			

				if ($pedido->annulled == 1)
				{
					$ultimoRegistro = $this->Bills->find('all', 
					[
						'conditions' => ['id_documento_padre' => $pedido->id , 'tipo_documento' => "Factura"], 
						'order' => ['Bills.created' => 'DESC']
					]); 
									
					$contadorRegistros = $ultimoRegistro->count();
					
					if ($contadorRegistros > 0)
					{
						$factura_sustituta = $ultimoRegistro->first();

						if ($factura_sustituta->control_number === null || $factura_sustituta->impresa == 0)
						{
							$this->Flash->error(__('Este pedido fue anulado, pero no se ha impreso su correspondiente factura. Por favor imprima la factura '.$factura_sustituta->bill_number));
						}
						else
						{
							$this->Flash->error(__('Este pedido ya fue anulado anteriormente'));
						}
					}	
					else
					{
						$this->Flash->error(__('Este pedido ya fue anulado anteriormente'));
					}
				}
				elseif ($pedido->monto_divisas == 0)
				{
					$this->Flash->error(__('Este pedido no tiene pagos en divisas'));
				}
				else
				{						
					$pedido = $this->Bills->get($pedido->id);
					$idPedido = $pedido->id;
					
					$pedido->annulled = 1;	
					
					$pedido->date_annulled = Time::now();
					$pedido->id_turno_anulacion = $turnoActual->id;
																	
					if (!($this->Bills->save($pedido))) 
					{
						$this->Flash->error(__('El pedido no pudo ser anulado'));
					}
					else 
					{
						$concepts->edit($idPedido, $_POST['numero_del_pedido'], $pedido->tasa_cambio, $pedido->tipo_documento, "Sustitución");
						
						$payments->edit($idPedido);
														
						$eventos->add('controller', 'Bills', 'pedidoPorFactura', 'Se anuló la pedido Nro. '.$pedido->bill_number);

						$this->loadModel('Monedas');	
						$moneda = $this->Monedas->get(2);
						$tasa_dolar = $moneda->tasa_cambio_dolar; 
						$moneda = $this->Monedas->get(3);
						$tasa_euro = $moneda->tasa_cambio_dolar;
						$tasa_dolar_euro = round($tasa_euro/$tasa_dolar, 2);

						$nuevaFactura = $this->Bills->newEntity();

						$nuevaFactura->parentsandguardian_id = $pedido->parentsandguardian_id;
						$nuevaFactura->user_id = $pedido->user_id;
						$nuevaFactura->date_and_time = Time::now();;
						$nuevaFactura->turn = $turnoActual->id;
						$nuevaFactura->id_turno_anulacion = 0;						
						$nuevaFactura->bill_number = $consecutiveInvoice->add();
						$nuevaFactura->fiscal = 1;
						$nuevaFactura->tipo_documento = "Factura";
						$nuevaFactura->school_year = $pedido->school_year;
						$nuevaFactura->identification = $pedido->identification;
						$nuevaFactura->client = $pedido->client;
						$nuevaFactura->tax_phone = $pedido->tax_phone;
						$nuevaFactura->fiscal_address = $pedido->fiscal_address;
						
						$monto_dolar_descuento = round($pedido->amount/$pedido->tasa_cambio, 2);
						$nuevo_monto_bolivar_descuento = round($monto_dolar_descuento * $tasa_dolar, 2);

						$monto_dolar_pagado = round($pedido->amount_paid/$pedido->tasa_cambio, 2);
						$nuevo_monto_bolivar_pagado = round($monto_dolar_pagado * $tasa_dolar, 2);

						$nuevaFactura->amount = $nuevo_monto_bolivar_descuento;
						$nuevaFactura->amount_paid = $nuevo_monto_bolivar_pagado;
						$nuevaFactura->annulled = 0;
						$nuevaFactura->date_annulled = 0;
						$nuevaFactura->invoice_migration = 0;
						$nuevaFactura->new_family = 0;
						$nuevaFactura->impresa = 0;
						$nuevaFactura->id_documento_padre = $pedido->id;
						$nuevaFactura->id_anticipo = 0;
						$nuevaFactura->factura_pendiente = $pedido->factura_pendiente;
						$nuevaFactura->moneda_id = 1;
						$nuevaFactura->tasa_cambio = $tasa_dolar;
						$nuevaFactura->tasa_euro = $tasa_euro;
						$nuevaFactura->tasa_dolar_euro = $tasa_dolar_euro;
						$nuevaFactura->saldo_compensado_dolar = $pedido->saldo_compensado_dolar;
						$nuevaFactura->sobrante_dolar = $pedido->sobrante_dolar;
						$nuevaFactura->tasa_temporal_dolar = $pedido->tasa_temporal_dolar;
						$nuevaFactura->tasa_temporal_euro = $pedido->tasa_temporal_euro;
						$nuevaFactura->cuotas_alumno_becado = $pedido->cuotas_alumno_becado;
						$nuevaFactura->cambio_monto_cuota = $pedido->cambio_monto_cuota;
						$nuevaFactura->monto_divisas = $pedido->monto_divisas;
						$nuevaFactura->monto_igtf = $pedido->monto_igtf;
						if (!($this->Bills->save($nuevaFactura))) 
						{
							$this->Flash->error(__('La factura no pudo ser guardada'));
						}
						else
						{
							$ultimoRegistro = $this->Bills->find('all', 
							[
								'conditions' => ['bill_number' => $nuevaFactura->bill_number], 
								'order' => ['Bills.created' => 'DESC']
							]); 
											
							$factura = $ultimoRegistro->first();	
							$codigo_retorno_conceptos = $concepts->conceptosPedidoFactura($idPedido, $factura->id, $pedido->tasa_cambio, $tasa_dolar);

							if ($codigo_retorno_conceptos == 0)
							{
								$codigo_retorno_pagos = $payments->pagosPedidoFactura($idPedido, $factura->id, $factura->bill_number, $turnoActual->id, $_POST);
								if ($codigo_retorno_pagos == 0)
								{
									if ($factura->amount < 0)
									{
										$vector_retorno = $this->agregaNotaCreditoDescuentos($factura);
										if ($vector_retorno["codigo_retorno"] == 1)
										{
											$eventos->add('controller', 'Bills', 'pedidoPorFactura', 'No se pudo crear la nota de crédito correspondiente a la factura'.$factura->bill_number);
											return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
										}
									}
									return $this->redirect(['controller' => 'Bills', 'action' => 'invoice', $factura->id, 0, $factura->parentsandguardian_id, 'pedidoPorFactura', $factura->id]);
								}
								else
								{
									$eventos->add('controller', 'Bills', 'pedidoPorFactura', 'No se pudieron crear los pagos correspondientes a la factura'.$factura->bill_number);
									return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
								}
							}
							else
							{
								$eventos->add('controller', 'Bills', 'pedidoPorFactura', 'No se pudieron crear los conceptos correspondientes a la factura'.$factura->bill_number);
								return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
							}
						}
					}
				}
			}				
		}
    }

	public function verificarPedido()
    {
        $this->autoRender = false;
		
        if ($this->request->is('json'))
		{
			$jsondata = [];
			
			if ($_POST["numero_del_pedido"])
			{
				$numero_del_pedido = $_POST["numero_del_pedido"];
				$pedidos = $this->Bills->find('all')->where(['bill_number' => $numero_del_pedido, 'tipo_documento' => 'Pedido']);
				if ($pedidos)
				{
					$pedido = $pedidos->first();
					$jsondata["satisfactorio"] = true;
					$jsondata["mensaje"] = "Se encontró el pedido";
					$jsondata["monto_igtf_dolar"] = $pedido->monto_igtf;

					$this->loadModel('Monedas');	
					$moneda = $this->Monedas->get(2);
					$tasa_cambio_dolar = $moneda->tasa_cambio_dolar; 
					
					$moneda = $this->Monedas->get(3);
					$tasa_cambio_euro = round($moneda->tasa_cambio_dolar/$tasa_cambio_dolar, 2); 

					$jsondata["monto_igtf_euro"] = round($pedido->monto_igtf / $tasa_cambio_euro, 2 );
					$jsondata["monto_igtf_bolivar"] = round($pedido->monto_igtf * $tasa_cambio_dolar, 2);
				}
				else
				{
					$jsondata["success"] = false;
					$jsondata["mensaje"] = "No se encontró el pedido";
				}
			}
			else
			{
				$jsondata["success"] = false;
				$jsondata["mensaje"] = "Debe indicar el número del pedido";
			}
			exit(json_encode($jsondata, JSON_FORCE_OBJECT));
		}
	}
    public function agregaNotaCreditoDescuentos($facturaAfectada = null)
    {	
		$vector_retorno	 = [];
		$vector_retorno["codigo_retorno"] = 0;
		$vector_retorno["numero_nota_credito"] = 0;

		$consecutivoCredito = new ConsecutivocreditosController();
		$numeroNotaContable = $consecutivoCredito->add();
		          
        $notaContable = $this->Bills->newEntity();
		
        $notaContable->parentsandguardian_id = $facturaAfectada->parentsandguardian_id;
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

        $notaContable->school_year = $facturaAfectada->school_year;
        $notaContable->identification = $facturaAfectada->identification;
        $notaContable->client = $facturaAfectada->client;
        $notaContable->tax_phone = $facturaAfectada->tax_phone;
        $notaContable->fiscal_address = $facturaAfectada->fiscal_address;
		$notaContable->amount = 0;
				
		$notaContable->amount_paid = $facturaAfectada->amount * -1;
		$notaContable->annulled = 0;
		$notaContable->date_annulled = 0;
		$notaContable->invoice_migration = 0;
		$notaContable->new_family = 0;
		$notaContable->impresa = 0;	
		$notaContable->tipo_documento = "Nota de crédito";	
		$notaContable->id_documento_padre = $facturaAfectada->id;
		$notaContable->id_anticipo = 0;
		$notaContable->factura_pendiente = 0;
		$notaContable->moneda_id = $facturaAfectada->moneda_id;
		$notaContable->tasa_cambio = $facturaAfectada->tasa_cambio;
		$notaContable->tasa_euro = $facturaAfectada->tasa_euro;
		$notaContable->tasa_dolar_euro = $facturaAfectada->tasa_dolar_euro;
		$notaContable->saldo_compensado = 0;
		$notaContable->monto_divisas = 0;
		$notaContable->monto_igtf = 0;
		
        if ($this->Bills->save($notaContable)) 
        {
			$notas = $this->Bills->find('all', ['conditions' => ['bill_number' => $numeroNotaContable, 'user_id' => $this->Auth->user('id')],
			'order' => ['Bills.id' => 'DESC'] ]);

			if ($notas->count() > 0)
			{
				$nueva_nota = $notas->first();
				$conceptos = new ConceptsController();
				$codigo_retorno_concepto = $conceptos->agregarConceptoNotaCreditoDescuento($nueva_nota);
				if ($codigo_retorno_concepto > 0)
				{
					$vector_retorno["codigo_retorno"] = 1;
				}
			}
			else    
			{
				$vector_retorno["codigo_retorno"] = 1;
				$this->Flash->error(__('No se encontró el registro de la nota de crédito'));
			}
		}
		else
		{
			$vector_retorno["codigo_retorno"] = 1;
            $this->Flash->error(__('No se pudo registrar la nota de crédito correspondiente al descuento'));
        }
		return $vector_retorno;
    }
	public function calcular_disponibilidad_efectivo($idTurno = null)
	{
		$vector_retorno = [];

		$efectivo_bolivar_fiscal = 0;
		$efectivo_dolar_fiscal = 0;
		$efectivo_euro_fiscal = 0;

		$efectivo_bolivar_compra_fiscal = 0;
		$efectivo_dolar_compra_fiscal = 0;
		$efectivo_euro_compra_fiscal = 0;
		
		$efectivo_bolivar_vuelto_compra_fiscal = 0;
		$efectivo_dolar_vuelto_compra_fiscal = 0;
		$efectivo_euro_vuelto_compra_fiscal = 0;
		
		$efectivo_dolar_reintegro_fiscal = 0;

		$efectivo_bolivar_no_fiscal = 0;
		$efectivo_dolar_no_fiscal = 0;
		$efectivo_euro_no_fiscal = 0;
		
		$efectivo_bolivar_compra_no_fiscal = 0;
		$efectivo_dolar_compra_no_fiscal = 0;
		$efectivo_euro_compra_no_fiscal = 0;
		
		$efectivo_bolivar_vuelto_compra_no_fiscal = 0;
		$efectivo_dolar_vuelto_compra_no_fiscal = 0;
		$efectivo_euro_vuelto_compra_no_fiscal = 0;
		
		$efectivo_dolar_reintegro_no_fiscal = 0;

		$vector_efectivos = [];

		$pagos = $this->Bills->Payments->find('all')
			->contain(['Bills'])
			->where(['Payments.turn' => $idTurno, 'Payments.annulled' => 0, 'Payments.payment_type' => 'Efectivo', ['OR' => [['Bills.tipo_documento' => 'Pedido'], ['Bills.tipo_documento' => 'Recibo de anticipo'], ['Bills.tipo_documento' => 'Factura']]]]);

		if ($pagos->count() > 0)
		{
			foreach ($pagos as $pago)
			{
				if ($pago->fiscal == 1)
				{
					if ($pago->moneda == "Bs.")
					{
						$efectivo_bolivar_fiscal += $pago->amount;
					}
					elseif ($pago->moneda == '$')
					{
						$efectivo_dolar_fiscal += $pago->amount;
					}
					else
					{
						$efectivo_euro_fiscal += $pago->amount;
					}
				}
				else
				{
					if ($pago->moneda == "Bs.")
					{
						$efectivo_bolivar_no_fiscal += $pago->amount;
					}
					elseif ($pago->moneda == '$')
					{
						$efectivo_dolar_no_fiscal += $pago->amount;
					}
					else
					{
						$efectivo_euro_no_fiscal += $pago->amount;
					}
				}
			}
		}
		$recibos = $this->Bills->find('all')
			->where(['turn' => $idTurno, 'annulled' => 0, ['OR' => [['SUBSTRING(tipo_documento, 1, 16) =' => 'Recibo de compra'], ['SUBSTRING(tipo_documento, 1, 26) =' => 'Recibo de vuelto de compra'], ['SUBSTRING(tipo_documento, 1, 19) =' => 'Recibo de reintegro']]]]);

		if ($recibos->count() > 0)
		{
			foreach ($recibos as $recibo)
			{
				if ($recibo->tipo_documento == "Recibo de compra")
				{
					if ($recibo->moneda_id == 1)
					{
						$efectivo_bolivar_compra_fiscal += $recibo->amount_paid;
					}
					elseif ($recibo->moneda_id == 2)
					{
						$efectivo_dolar_compra_fiscal += $recibo->amount_paid;
					}
					else
					{
						$efectivo_euro_compra_fiscal += $recibo->amount_paid;
					}
				}
				elseif ($recibo->tipo_documento == "Recibo de vuelto de compra")
				{
					if ($recibo->moneda_id == 1)
					{
						$efectivo_bolivar_vuelto_compra_fiscal += $recibo->amount_paid;
					}
					elseif ($recibo->moneda_id == 2)
					{
						$efectivo_dolar_vuelto_compra_fiscal += $recibo->amount_paid;
					}
					else
					{
						$efectivo_euro_vuelto_compra_fiscal += $recibo->amount_paid;
					}
				}
				elseif ($recibo->tipo_documento == "Recibo de reintegro")
				{
					$efectivo_dolar_reintegro_fiscal += $recibo->amount_paid;
				}
				elseif ($recibo->tipo_documento == "Recibo de compra de pedido")
				{
					if ($recibo->moneda_id == 1)
					{
						$efectivo_bolivar_compra_no_fiscal += $recibo->amount_paid;
					}
					elseif ($recibo->moneda_id == 2)
					{
						$efectivo_dolar_compra_no_fiscal += $recibo->amount_paid;
					}
					else
					{
						$efectivo_euro_compra_no_fiscal += $recibo->amount_paid;
					}
				}
				elseif ($recibo->tipo_documento == "Recibo de vuelto de compra de pedido")
				{
					if ($recibo->moneda_id == 1)
					{
						$efectivo_bolivar_vuelto_compra_no_fiscal += $recibo->amount_paid;
					}
					elseif ($recibo->moneda_id == 2)
					{
						$efectivo_dolar_vuelto_compra_no_fiscal += $recibo->amount_paid;
					}
					else
					{
						$efectivo_euro_vuelto_compra_no_fiscal += $recibo->amount_paid;
					}
				}
				elseif ($recibo->tipo_documento == "Recibo de reintegro de pedido")
				{
					$efectivo_dolar_reintegro_no_fiscal += $recibo->amount_paid;
				}
			}
		}

		$disponible_bolivar_fiscal = $efectivo_bolivar_fiscal - $efectivo_bolivar_compra_fiscal + $efectivo_bolivar_vuelto_compra_fiscal; 
		$vector_efectivos[] = ["origen" => "Facturas", "moneda" => "bolivar", "orden" => "1", "monto" => $disponible_bolivar_fiscal];

		$disponible_bolivar_no_fiscal = $efectivo_bolivar_no_fiscal - $efectivo_bolivar_compra_no_fiscal + $efectivo_bolivar_vuelto_compra_no_fiscal;
		$vector_efectivos[] = ["origen" => "Pedidos", "moneda" => "bolivar", "orden" => "1", "monto" => $disponible_bolivar_no_fiscal];

		$disponible_dolar_fiscal = $efectivo_dolar_fiscal - $efectivo_dolar_compra_fiscal + $efectivo_dolar_vuelto_compra_fiscal - $efectivo_dolar_reintegro_fiscal; 
		$vector_efectivos[] = ["origen" => "Facturas", "moneda" => "dolar", "orden" => "2", "monto" => $disponible_dolar_fiscal];

		$disponible_dolar_no_fiscal = $efectivo_dolar_no_fiscal - $efectivo_dolar_compra_no_fiscal + $efectivo_dolar_vuelto_compra_no_fiscal  - $efectivo_dolar_reintegro_no_fiscal;
		$vector_efectivos[] = ["origen" => "Pedidos", "moneda" => "dolar", "orden" => "2", "monto" => $disponible_dolar_no_fiscal];

		$disponible_euro_fiscal = $efectivo_euro_fiscal - $efectivo_euro_compra_fiscal + $efectivo_euro_vuelto_compra_fiscal; 
		$vector_efectivos[] = ["origen" => "Facturas", "moneda" => "euro", "orden" => "3", "monto" => $disponible_euro_fiscal];

		$disponible_euro_no_fiscal = $efectivo_euro_no_fiscal - $efectivo_euro_compra_no_fiscal + $efectivo_euro_vuelto_compra_no_fiscal;
		$vector_efectivos[] = ["origen" => "Pedidos", "moneda" => "euro", "orden" => "3", "monto" => $disponible_euro_no_fiscal];

		return $vector_efectivos;
	}
	public function generarConceptosInscripcion($periodoEscolarFactura = null, $aConcept = null, $tipoConcepto = null)
	{
		$anioInicioPeriodoActualFactura = substr($periodoEscolarFactura, 0, 4);
		$anioInicioPeriodoAnteriorFactura = $anioInicioPeriodoActualFactura - 1;

		$anioFinPeriodoActualFactura = substr($periodoEscolarFactura, 5, 4);
		$anioFinPeriodoAnteriorFactura = $anioFinPeriodoActualFactura - 1;
		$conceptoInscripcion = '';
		
		if ($tipoConcepto == 'Matrícula')
		{
			if ($aConcept->concept == 'Matrícula '.$anioInicioPeriodoActualFactura)
			{
				if ($anioInicioPeriodoActualFactura >= 2024)
				{
					if ($aConcept->observation == 'Diferencia')
					{
						$conceptoInscripcion = $aConcept->student_name.' - Diferencia matrícula '.$periodoEscolarFactura;
					}
					else
					{
						$conceptoInscripcion = $aConcept->student_name.' - Anticipo matrícula '.$periodoEscolarFactura;
					} 
				}
				else
				{
					$conceptoInscripcion = $aConcept->student_name.' - Anticipo matrícula '.$periodoEscolarFactura;
				}
			}
			elseif ($aConcept->concept == 'Matrícula '.$anioInicioPeriodoAnteriorFactura)
			{	
				$conceptoInscripcion = $aConcept->student_name.' - Diferencia matrícula '.$anioInicioPeriodoAnteriorFactura.'-'.$anioFinPeriodoAnteriorFactura;
			}
		}
		elseif ($tipoConcepto == 'Agosto')
		{
			if ($aConcept->concept == 'Ago '.$anioFinPeriodoActualFactura)
			{
				if ($anioInicioPeriodoActualFactura >= 2024)
				{
					if ($aConcept->observation == 'Diferencia')
					{
						$conceptoInscripcion = $aConcept->student_name.' - Diferencia agosto '.$periodoEscolarFactura;
					}
					else
					{
						$conceptoInscripcion = $aConcept->student_name.' - Abono agosto '.$periodoEscolarFactura;
					} 
				}
				else
				{
					$conceptoInscripcion = $aConcept->student_name.' - Abono agosto '.$periodoEscolarFactura;
				}
			}
			elseif ($aConcept->concept == 'Ago '.$anioFinPeriodoAnteriorFactura)
			{	
				$conceptoInscripcion = $aConcept->student_name.' - Diferencia agosto '.$anioInicioPeriodoAnteriorFactura.'-'.$anioFinPeriodoAnteriorFactura;
			}
		}
		return $conceptoInscripcion;
	}
}