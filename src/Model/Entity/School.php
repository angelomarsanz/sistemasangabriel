<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * School Entity
 *
 * @property int $id
 * @property string $name
 * @property string $rif
 * @property string $fiscal_address
 * @property string $tax_phone
 * @property string $profile_photo
 * @property string $profile_photo_dir
 * @property string $responsible_user
 * @property bool $deleted_record
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class School extends Entity
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
