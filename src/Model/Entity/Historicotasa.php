<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Historicotasa Entity
 *
 * @property int $id
 * @property int $moneda_id
 * @property float $tasa_cambio_dolar
 * @property string $columna_extra1
 * @property string $columna_extra2
 * @property string $columna_extra3
 * @property string $columna_extra4
 * @property string $columna_extra5
 * @property string $columna_extra6
 * @property string $columna_extra7
 * @property string $columna_extra8
 * @property string $columna_extra9
 * @property string $columna_extra10
 * @property string $estatus_registro
 * @property string $motivo_cambio_estatus
 * @property \Cake\I18n\Time $fecha_cambio_estatus
 * @property string $usuario_responsable
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Moneda $moneda
 */
class Historicotasa extends Entity
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
