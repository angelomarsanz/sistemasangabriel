<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Mibill Entity
 *
 * @property int $id
 * @property int $idd
 * @property string $ci
 * @property string $nombre
 * @property string $direccion
 * @property string $telefono
 * @property string $iva
 * @property string $total
 * @property string $sub
 * @property string $fecha
 * @property string $status
 * @property int $new_family
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Mibill extends Entity
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
