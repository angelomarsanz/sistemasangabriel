<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class CuentaPorCobrar extends Entity
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
    
    protected function _getFullName()
    {
        return 
            $this->_properties['id_cliente'].' '.
            $this->_properties['tipo_cliente'].' '.
            $this->_properties['tipo_operacion'].' ';
    }
}