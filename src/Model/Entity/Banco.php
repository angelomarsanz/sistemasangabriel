<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Banco Entity
 *
 * @property int $id
 * @property string $nombre_banco
 * @property string $tipo_banco
 * @property string $estatus_registro
 * @property string $usuario_creador
 * @property string $usuario_cambio_estatus
 * @property \Cake\I18n\Time $fecha_cambio_estatus
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Banco extends Entity
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
