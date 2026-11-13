<?php
/**
 * Pruebas de notas de débito, cierres consolidados y el detalle compartido
 * entre la vista previa y el reporte de cierre.
 */
namespace App\Test\TestCase\Controller;

use App\Controller\TurnsController;
use Cake\View\View;
use PHPUnit\Framework\TestCase;

class TurnsCierreTest extends TestCase
{
    /**
     * Comprueba la forma y el orden del vector que se guarda en cierres nuevos.
     *
     * @return void
     */
    public function testVectorFiscalIncluyeNotaDebito()
    {
        $clase = new \ReflectionClass(TurnsController::class);
        $controlador = $clase->newInstanceWithoutConstructor();
        $controlador->Auth = new class {
            /**
             * Devuelve los datos de prueba del cajero.
             *
             * @param string $campo Campo solicitado.
             * @return string Valor del campo.
             */
            public function user($campo)
            {
                return $campo === 'first_name' ? 'Ana' : 'Pérez';
            }
        };
        $vector = $controlador->vectorTotalesRecibidos();
        $filas = array_keys($vector);
        $subtotal = 'Total facturas - notas de crédito + notas de débito + anticipos de inscripción';
        $this->assertSame(array_search('Notas de crédito', $filas, true) + 1, array_search('Notas de débito', $filas, true));
        $this->assertArrayHasKey($subtotal, $vector);
        $this->assertArrayNotHasKey('Total facturas - notas de crédito + anticipos de inscripción', $vector);
        $this->assertSame($vector['Notas de crédito'], $vector['Notas de débito']);
        $this->assertArrayHasKey('Total a recibir de Ana Pérez', $vector);
    }

    /**
     * Ejecuta un método interno del controlador sin inicializar modelos ni conexiones.
     *
     * @param string $nombre Nombre del método.
     * @param array $argumentos Argumentos para el método.
     * @param \App\Controller\TurnsController|null $controlador Controlador de prueba opcional.
     * @return mixed Resultado del método.
     */
    private function ejecutarMetodo($nombre, array $argumentos, $controlador = null)
    {
        $clase = new \ReflectionClass(TurnsController::class);
        if ($controlador === null)
        {
            $controlador = $clase->newInstanceWithoutConstructor();
        }
        $metodo = $clase->getMethod($nombre);
        $metodo->setAccessible(true);

        return $metodo->invokeArgs($controlador, $argumentos);
    }

    /**
     * Construye un controlador con documentos simulados y registra los ID consultados.
     *
     * @param array $documentos Documentos indexados por ID.
     * @return \App\Controller\TurnsController Controlador preparado.
     */
    private function crearControladorConDocumentos(array $documentos)
    {
        $clase = new \ReflectionClass(TurnsController::class);
        $controlador = $clase->newInstanceWithoutConstructor();
        $controlador->Bills = new class($documentos) {
            public $consultados = [];
            private $documentos;

            /**
             * Inicializa los documentos simulados.
             *
             * @param array $documentos Documentos indexados por ID.
             */
            public function __construct(array $documentos)
            {
                $this->documentos = $documentos;
            }

            /**
             * Obtiene un documento simulado o informa que no existe.
             *
             * @param int $id Identificador consultado.
             * @return object Documento correspondiente.
             * @throws \Cake\Datasource\Exception\RecordNotFoundException Si no existe.
             */
            public function get($id)
            {
                $this->consultados[] = $id;
                if (!isset($this->documentos[$id]))
                {
                    throw new \Cake\Datasource\Exception\RecordNotFoundException('Documento inexistente.');
                }

                return $this->documentos[$id];
            }
        };

        return $controlador;
    }

    /**
     * Comprueba la referencia directa y la referencia por una nota de crédito.
     *
     * @return void
     */
    public function testBuscarFacturaOriginalNotaDebito()
    {
        $factura = (object)['id' => 100, 'tipo_documento' => 'Factura', 'tasa_cambio' => 40, 'tasa_dolar_euro' => 1.25];
        $credito = (object)['id' => 66296, 'tipo_documento' => 'Nota de crédito', 'id_documento_padre' => 100, 'tasa_cambio' => 100, 'tasa_dolar_euro' => 2];
        foreach ([
            [100, [100]],
            [66296, [66296, 100]],
        ] as $caso)
        {
            $controlador = $this->crearControladorConDocumentos([100 => $factura, 66296 => $credito]);
            $nota = (object)['id_documento_padre' => $caso[0], 'amount_paid' => 400, 'tasa_cambio' => 20, 'tasa_euro' => 50];
            $pagos = [
                (object)['payment_type' => 'Efectivo', 'moneda' => '$', 'amount' => 6],
                (object)['payment_type' => 'Transferencia', 'bank' => 'Banco', 'amount' => 400],
            ];
            $buscadorPagos = new class($pagos) {
                public $consultados = [];
                private $pagos;

                /**
                 * Inicializa los pagos simulados.
                 *
                 * @param array $pagos Pagos de la factura.
                 */
                public function __construct(array $pagos)
                {
                    $this->pagos = $pagos;
                }

                /**
                 * Registra el documento consultado y devuelve sus pagos.
                 *
                 * @param int $id Identificador del documento.
                 * @return array Resultado simulado.
                 */
                public function busquedaPagosFactura($id)
                {
                    $this->consultados[] = $id;

                    return ['codigoRetorno' => 0, 'pagosFactura' => $this->pagos];
                }
            };
            list($resultado, $pagosEncontrados) = $this->ejecutarMetodo('obtenerPagosNotaDebito', [$nota, $buscadorPagos], $controlador);
            $this->assertSame($factura, $resultado);
            $this->assertSame($caso[1], $controlador->Bills->consultados);
            $this->assertSame([100], $buscadorPagos->consultados);
            $convertidos = $this->ejecutarMetodo('convertirPagosDolar', [$pagosEncontrados['pagosFactura'], $resultado], $controlador);
            $subtotal = 'Total facturas - notas de crédito + notas de débito + anticipos de inscripción';
            $vector = ['Notas de débito' => ['Transferencia Bs.' => 0], $subtotal => ['Transferencia Bs.' => 5], 'Total a recibir de Cajero' => ['Transferencia Bs.' => 5]];
            $this->ejecutarMetodo('aplicarNotaDebito', [&$vector, $nota, $convertidos, 'Cajero'], $controlador);
            $this->assertEquals(400, $vector['Notas de débito']['Transferencia Bs.']);
            $this->assertEquals(405, $vector[$subtotal]['Transferencia Bs.']);
            $this->assertEquals(405, $vector['Total a recibir de Cajero']['Transferencia Bs.']);
        }
    }

    /**
     * Comprueba que las referencias rotas o que no conducen a una factura se rechacen.
     *
     * @return void
     */
    public function testReferenciasInvalidasNotaDebito()
    {
        $documentos = [
            1 => (object)['id' => 1, 'tipo_documento' => 'Nota de crédito', 'id_documento_padre' => 0],
            2 => (object)['id' => 2, 'tipo_documento' => 'Nota de crédito', 'id_documento_padre' => 99],
            3 => (object)['id' => 3, 'tipo_documento' => 'Nota de crédito', 'id_documento_padre' => 3],
        ];
        foreach ([0, 98, 1, 2, 3] as $id)
        {
            $controlador = $this->crearControladorConDocumentos($documentos);
            try
            {
                $this->ejecutarMetodo('obtenerDocumentoPagoNotaDebito', [(object)['id_documento_padre' => $id]], $controlador);
                $this->fail('Se esperaba un error de referencia.');
            }
            catch (\InvalidArgumentException $error)
            {
                $this->assertNotEmpty($error->getMessage());
            }
        }
    }

    /**
     * Comprueba selección por mayor pago, conversión con las tasas de la nota y suma.
     *
     * @return void
     */
    public function testAplicarNotaDebitoPorMoneda()
    {
        $subtotal = 'Total facturas - notas de crédito + notas de débito + anticipos de inscripción';
        foreach ([
            ['Efectivo $', 10.0],
            ['Zelle $', 10.0],
            ['Efectivo €', 8.0],
            ['Euros €', 8.0],
            ['Transferencia Bs.', 400.0],
        ] as $caso)
        {
            list($forma, $esperado) = $caso;
            $vector = [
                'Notas de débito' => [$forma => 0],
                $subtotal => [$forma => 20],
                'Total a recibir de Cajero' => [$forma => 15],
            ];
            $nota = (object)['amount_paid' => 400, 'tasa_cambio' => 40, 'tasa_euro' => 50];
            $pagos = ['Efectivo Bs.' => 2, $forma => 10];
            $this->ejecutarMetodo('aplicarNotaDebito', [&$vector, $nota, $pagos, 'Cajero']);
            $this->assertEquals($esperado, $vector['Notas de débito'][$forma]);
            $this->assertEquals(20 + $esperado, $vector[$subtotal][$forma]);
            $this->assertEquals(15 + $esperado, $vector['Total a recibir de Cajero'][$forma]);
        }
    }

    /**
     * Comprueba que pagos y tasas inválidos no alteren el vector contable.
     *
     * @return void
     */
    public function testDatosInvalidosNoAlteranTotales()
    {
        $subtotal = 'Total facturas - notas de crédito + notas de débito + anticipos de inscripción';
        foreach ([
            [(object)['amount_paid' => 100, 'tasa_cambio' => 0, 'tasa_euro' => 50], ['Efectivo $' => 1]],
            [(object)['amount_paid' => 100, 'tasa_cambio' => 40, 'tasa_euro' => 0], ['Euros €' => 1]],
            [(object)['amount_paid' => 100, 'tasa_cambio' => 40, 'tasa_euro' => 50], []],
            [(object)['amount_paid' => 100, 'tasa_cambio' => 40, 'tasa_euro' => 50], ['Efectivo $' => 0]],
        ] as $caso)
        {
            $vector = ['Notas de débito' => ['Efectivo $' => 0], $subtotal => ['Efectivo $' => 10], 'Total a recibir de Cajero' => ['Efectivo $' => 10]];
            $original = $vector;
            try
            {
                $this->ejecutarMetodo('aplicarNotaDebito', [&$vector, $caso[0], $caso[1], 'Cajero']);
                $this->fail('Se esperaba un error de cálculo.');
            }
            catch (\InvalidArgumentException $error)
            {
                $this->assertNotEmpty($error->getMessage());
            }
            $this->assertSame($original, $vector);
        }
    }

    /**
     * Comprueba cierres antiguos, nuevos y mixtos en ambos órdenes.
     *
     * @return void
     */
    public function testConsolidarSubtotalesHistoricosYActuales()
    {
        $antiguo = 'Total facturas - notas de crédito + anticipos de inscripción';
        $actual = 'Total facturas - notas de crédito + notas de débito + anticipos de inscripción';
        $vectorAntiguo = ['Facturas' => ['Efectivo $' => 10], 'Notas de crédito' => ['Efectivo $' => 2], $antiguo => ['Efectivo $' => 8]];
        $vectorNuevo = ['Facturas' => ['Efectivo $' => 20], 'Notas de crédito' => ['Efectivo $' => 3], 'Notas de débito' => ['Efectivo $' => 4], $actual => ['Efectivo $' => 21]];

        $soloAntiguo = $this->ejecutarMetodo('sumarVectorCierreConsolidado', [[], $vectorAntiguo]);
        $this->assertArrayHasKey($antiguo, $soloAntiguo);
        $this->assertArrayNotHasKey($actual, $soloAntiguo);
        foreach ([[$vectorAntiguo, $vectorNuevo], [$vectorNuevo, $vectorAntiguo]] as $orden)
        {
            $resultado = $this->ejecutarMetodo('sumarVectorCierreConsolidado', [[], $orden[0]]);
            $resultado = $this->ejecutarMetodo('sumarVectorCierreConsolidado', [$resultado, $orden[1]]);
            $this->assertArrayNotHasKey($antiguo, $resultado);
            $this->assertEquals(29, $resultado[$actual]['Efectivo $']);
            $this->assertEquals(4, $resultado['Notas de débito']['Efectivo $']);
            $filas = array_keys($resultado);
            $this->assertSame(array_search('Notas de crédito', $filas, true) + 1, array_search('Notas de débito', $filas, true));
        }
    }

    /**
     * Verifica la comparación de pagos mixtos con las tasas de la factura original.
     *
     * @return void
     */
    public function testConversionPagosFacturaOriginal()
    {
        $factura = (object)['tasa_cambio' => 40, 'tasa_dolar_euro' => 1.25];
        $pagos = [
            (object)['payment_type' => 'Efectivo', 'moneda' => '$', 'amount' => 5],
            (object)['payment_type' => 'Efectivo', 'moneda' => '€', 'amount' => 8],
            (object)['payment_type' => 'Transferencia', 'bank' => 'Banco', 'amount' => 200],
        ];
        $resultado = $this->ejecutarMetodo('convertirPagosDolar', [$pagos, $factura]);
        $this->assertEquals(5, $resultado['Efectivo $']);
        $this->assertEquals(10, $resultado['Efectivo €']);
        $this->assertEquals(5, $resultado['Transferencia Bs.']);
    }

    /**
     * Comprueba que previo y reporte rendericen el mismo detalle para ambos roles.
     *
     * @return void
     */
    public function testPrevioYReporteCompartenDetalle()
    {
        $clase = new \ReflectionClass(TurnsController::class);
        $controlador = $clase->newInstanceWithoutConstructor();
        $controlador->Auth = new class {
            /**
             * Devuelve los datos de prueba del cajero.
             *
             * @param string $campo Campo solicitado.
             * @return string Valor del campo.
             */
            public function user($campo)
            {
                return $campo === 'first_name' ? 'Cajero' : 'Prueba';
            }
        };
        $turno = (object)['id' => 5523, 'turn' => '1', 'status' => 1, 'start_date' => new \DateTimeImmutable('2026-11-04')];
        $datos = [
            'turn' => $turno, 'lastNumber' => 133368, 'lastControl' => 10,
            'cajero' => 'Cajero Prueba', 'consolidadoPeriodo' => false,
            'vectorTotalesRecibidos' => $controlador->vectorTotalesRecibidos(),
            'vectorTotalesRecibidosPedidos' => $controlador->vectorTotalesRecibidosPedidos(),
            'totalFormasPago' => ['Total general cobrado Bs.' => ['montoBs' => 0]],
            'vectorPagos' => [], 'facturas' => [], 'pagosFacturas' => [], 'facturasNotas' => [],
            'documentosAnulados' => [], 'conceptosSeguro' => [], 'conceptosServicioEducativo' => [],
            'conceptosConsejoEducativo' => [], 'tasaDolar' => 40, 'tasaEuro' => 50,
            'totalGeneralSobrantes' => 0, 'totalGeneralReintegrosSobrantes' => 0,
            'totalDescuentosRecargos' => 0, 'totalGeneralCompensado' => 0,
            'totalGeneralFacturado' => 0, 'totalFacturasRecibos' => 0
        ];
        foreach ([
            'indicadorFacturasAnticipos', 'indicadorServiciosEducativos', 'indicadorReintegros',
            'indicadorReintegrosPedidos', 'indicadorCompras', 'indicadorComprasPedidos',
            'indicadorVueltoCompra', 'indicadorNotasCredito', 'indicadorNotasDebito',
            'indicadorFacturasRecibos', 'indicadorSobrantes', 'indicadorSobrantesPedidos',
            'indicadorFacturasAnuladas', 'indicadorRecibosAnulados', 'indicadorPedidosAnulados',
            'indicadorRecibosAnuladosPedidos', 'indicadorRecibosSeguro', 'indicadorRecibosSeguroAnulados',
            'indicadorRecibosConsejoEducativo'
        ] as $indicador)
        {
            $datos[$indicador] = 0;
        }

        foreach (['Seniat', 'Ventas generales'] as $rol)
        {
            $datos['rolCajero'] = $rol;
            $previo = $this->renderizarVistaCierre('edit', $datos);
            $reporte = $this->renderizarVistaCierre('reporte_cierre', $datos);
            $patron = '/<div name="reporte_cierre" id="reporte-cierre".*?<\/script>/s';
            $this->assertSame(1, preg_match($patron, $previo, $detallePrevio));
            $this->assertSame(1, preg_match($patron, $reporte, $detalleReporte));
            $this->assertSame($detalleReporte[0], $detallePrevio[0]);
            $this->assertNotFalse(strpos($previo, 'id="factura-control"'));
            $this->assertNotFalse(strpos($previo, 'id="cerrar-turno"'));
            $this->assertFalse(strpos($reporte, 'id="cerrar-turno"'));
            $this->assertSame(1, $turno->status);
        }
    }

    /**
     * Renderiza una vista sin conexión ni escritura de datos.
     *
     * @param string $plantilla Nombre de la plantilla.
     * @param array $datos Variables del reporte.
     * @return string HTML generado.
     */
    private function renderizarVistaCierre($plantilla, array $datos)
    {
        $vista = new View();
        $vista->Form = new class {
            /**
             * Simula el campo del número de control.
             *
             * @param string $nombre Nombre del campo.
             * @param array $opciones Opciones del campo.
             * @return string HTML del campo.
             */
            public function input($nombre, $opciones) { return '<input id="control-number">'; }
            /**
             * Simula el inicio del formulario de cierre.
             *
             * @param object $entidad Turno.
             * @return string HTML del formulario.
             */
            public function create($entidad) { return '<form method="post">'; }
            /**
             * Simula el botón de cierre.
             *
             * @param string $nombre Texto del botón.
             * @param array $opciones Opciones del botón.
             * @return string HTML del botón.
             */
            public function button($nombre, $opciones) { return '<button id="' . $opciones['id'] . '">' . $nombre . '</button>'; }
            /**
             * Cierra el formulario simulado.
             *
             * @return string HTML de cierre.
             */
            public function end() { return '</form>'; }
        };
        $vista->autoLayout = false;
        $vista->setTemplatePath('Turns');
        $vista->set($datos);

        return $vista->render($plantilla);
    }
}
