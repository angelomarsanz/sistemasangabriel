<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Miclient Entity
 *
 * @property int $id
 * @property string $clave_familia
 * @property string $familia
 * @property string $cimadre
 * @property string $apmadre
 * @property string $nomadre
 * @property string $dirmadre
 * @property string $emailmadre
 * @property string $telfmadre
 * @property string $celmadre
 * @property string $cipadre
 * @property string $appadre
 * @property string $nopadre
 * @property string $dirpadre
 * @property string $emailpadre
 * @property string $telfpadre
 * @property string $celpadre
 * @property string $nombre
 * @property string $ci
 * @property string $direccion
 * @property string $telefono
 * @property int $hijos
 * @property int $deuda
 */
class Miclient extends Entity
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
