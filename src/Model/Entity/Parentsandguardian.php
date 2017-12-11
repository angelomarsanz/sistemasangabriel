<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Parentsandguardian Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $code_for_user
 * @property string $first_name
 * @property string $second_name
 * @property string $surname
 * @property string $second_surname
 * @property string $sex
 * @property string $type_of_identification
 * @property string $identidy_card
 * @property bool $guardian
 * @property string $family_tie
 * @property string $profession
 * @property string $work_phone
 * @property string $workplace
 * @property string $professional_position
 * @property string $work_address
 * @property string $cell_phone
 * @property string $landline
 * @property string $email
 * @property string $address
 * @property float $balance
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Student[] $students
 */
class Parentsandguardian extends Entity
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
        'id' => false,
        'profile_photo' => true,
        'profile_photo_dir' => true

    ];
    
    protected function _getFullName()
    {
        return $this->_properties['surname'] . ' ' .
            $this->_properties['second_surname'] . ' ' .
            $this->_properties['first_name'] . ' ' .
            $this->_properties['second_name'];
    }
}