<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Miparentsandguardian Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $code_for_user
 * @property string $first_name
 * @property string $second_name
 * @property string $surname
 * @property string $second_surname
 * @property string $family
 * @property string $sex
 * @property string $type_of_identification
 * @property string $identidy_card
 * @property bool $guardian
 * @property string $family_tie
 * @property string $profession
 * @property string $item
 * @property string $work_phone
 * @property string $workplace
 * @property string $professional_position
 * @property string $work_address
 * @property string $cell_phone
 * @property string $landline
 * @property string $email
 * @property string $address
 * @property string $first_name_father
 * @property string $second_name_father
 * @property string $surname_father
 * @property string $second_surname_father
 * @property string $type_of_identification_father
 * @property string $identidy_card_father
 * @property string $address_father
 * @property string $email_father
 * @property string $landline_father
 * @property string $cell_phone_father
 * @property string $first_name_mother
 * @property string $second_name_mother
 * @property string $surname_mother
 * @property string $second_surname_mother
 * @property string $type_of_identification_mother
 * @property string $identidy_card_mother
 * @property string $address_mother
 * @property string $email_mother
 * @property string $landline_mother
 * @property string $cell_phone_mother
 * @property string $client
 * @property string $type_of_identification_client
 * @property string $identification_number_client
 * @property string $fiscal_address
 * @property string $tax_phone
 * @property float $balance
 * @property string $creative_user
 * @property bool $guardian_migration
 * @property string $mi_id
 * @property int $mi_children
 * @property bool $new_guardian
 * @property string $profile_photo
 * @property string $profile_photo_dir
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Mi $mi
 */
class Miparentsandguardian extends Entity
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
