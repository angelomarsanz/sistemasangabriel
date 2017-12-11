<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bill Entity
 *
 * @property int $id
 * @property int $parentsandguardian_id
 * @property int $user_id
 * @property \Cake\I18n\Time $date_and_time
 * @property string $bill_number
 * @property string $identification
 * @property string $client
 * @property string $tax_phone
 * @property string $fiscal_address
 * @property float $amount
 * @property float $amount_paid
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Parentsandguardian $parentsandguardian
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Concept[] $concepts
 * @property \App\Model\Entity\Payment[] $payments
 */
class Bill extends Entity
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
