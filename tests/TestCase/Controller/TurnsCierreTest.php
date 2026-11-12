<?php
/**
 * Pruebas del cálculo de notas de débito y de la compatibilidad de cierres consolidados.
 */
namespace App\Test\TestCase\Controller;

use App\Controller\TurnsController;
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
     * @return mixed Resultado del método.
     */
    private function ejecutarMetodo($nombre, array $argumentos)
    {
        $clase = new \ReflectionClass(TurnsController::class);
        $controlador = $clase->newInstanceWithoutConstructor();
        $metodo = $clase->getMethod($nombre);
        $metodo->setAccessible(true);

        return $metodo->invokeArgs($controlador, $argumentos);
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
}
