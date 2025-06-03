<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Colaborador extends Entity
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
            $this->_properties['primer_nombre'].' '.
            $this->_properties['segundo_nombre'].' '.
            $this->_properties['primer_apellido'].' '.
            $this->_properties['segundo_apellido'];
    }
}