<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Student Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $parentsandguardian_id
 * @property string $code_for_user
 * @property string $first_name
 * @property string $second_name
 * @property string $surname
 * @property string $second_surname
 * @property string $sex
 * @property string $school_card
 * @property string $nationality
 * @property string $type_of_identification
 * @property string $identity_card
 * @property string $family_bond_guardian_student
 * @property string $first_name_father
 * @property string $surname_father
 * @property string $first_name_mother
 * @property string $surname_mother
 * @property string $profile_photo
 * @property string $profile_photo_dir
 * @property string $place_of_birth
 * @property string $country_of_birth
 * @property \Cake\I18n\Time $birthdate
 * @property string $address
 * @property string $cell_phone
 * @property string $email
 * @property string $level_of_study
 * @property int $section_id
 * @property bool $scholarship
 * @property bool $brothers_in_school
 * @property int $number_of_brothers
 * @property string $previous_school
 * @property string $student_illnesses
 * @property string $observations
 * @property float $balance
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Parentsandguardian $parentsandguardian
 * @property \App\Model\Entity\Section $section
 * @property \App\Model\Entity\Activitiesannex[] $activitiesannexes
 * @property \App\Model\Entity\Studentqualification[] $studentqualifications
 * @property \App\Model\Entity\Studenttransaction[] $studenttransactions
 */
class Student extends Entity
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
