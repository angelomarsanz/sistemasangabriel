<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Salesbook Entity
 *
 * @property int $id
 * @property int $anio
 * @property int $mes
 * @property int $identificador_asociado
 * @property int $consecutivo_identificador
 * @property int $accion
 * @property string $numero_control_secuencia
 * @property \Cake\I18n\Time $fecha
 * @property string $tipo_documento
 * @property string $cedula_rif
 * @property string $nombre_razon_social
 * @property string $numero_control
 * @property string $numero_factura
 * @property string $nota_debito
 * @property string $nota_credito
 * @property string $factura_afectada
 * @property float $total_ventas_mas_impuesto
 * @property float $descuento_recargo
 * @property float $ventas_exoneradas
 * @property string $base
 * @property string $alicuota
 * @property float $iva
 * @property float $igft
 * @property float $tasa_cambio
 * @property float $monto_divisas
 * @property float $monto_bolivares
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Salesbook extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
