<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Mistudent Entity
 *
 * @property int $id
 * @property string $codigo
 * @property string $familia
 * @property int $idd
 * @property string $apellidos
 * @property string $nombres
 * @property string $sexo
 * @property string $nacimiento
 * @property string $direccion
 * @property string $grado
 * @property string $seccion
 * @property string $condicion
 * @property string $escolaridad
 * @property int $cuota
 * @property float $saldo
 * @property int $sep
 * @property int $oct
 * @property int $nov
 * @property int $dic
 * @property int $ene
 * @property string $feb
 * @property string $mar
 * @property int $abr
 * @property string $may
 * @property int $jun
 * @property int $jul
 * @property int $ago
 * @property int $mensualidad
 */
class Mistudent extends Entity
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
