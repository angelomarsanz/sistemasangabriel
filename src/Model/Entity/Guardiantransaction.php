<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Guardiantransaction Entity
 *
 * @property int $id
 * @property int $parentsandguardian_id
 * @property string $bank
 * @property \Cake\I18n\Time $date_and_time
 * @property string $serial
 * @property float $amount
 * @property string $concept
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Parentsandguardian $parentsandguardian
 */
class Guardiantransaction extends Entity
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
