<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Section Entity
 *
 * @property int $id
 * @property string $level
 * @property string $sublevel
 * @property string $section
 * @property string $other
 * @property int $maximum_amount
 * @property int $registered_students
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Studentactivity[] $studentactivities
 * @property \App\Model\Entity\Student[] $students
 * @property \App\Model\Entity\Employee[] $employees
 */
class Section extends Entity
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
        return $this->_properties['level'] . '  ' .
            $this->_properties['sublevel'] . '  ' .
            $this->_properties['section'] . '  ' .
            $this->_properties['other'];
    }
}
