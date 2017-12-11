<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Turn Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $turn
 * @property \Cake\I18n\Time $start_date
 * @property \Cake\I18n\Time $end_date
 * @property bool $status
 * @property float $initial_cash
 * @property float $cash_received
 * @property float $cash_paid
 * @property int $real_cash
 * @property float $debit_card_amount
 * @property float $real_debit_card_amount
 * @property float $credit_card_amount
 * @property float $real_credit_amount
 * @property float $transfer_amount
 * @property float $real_transfer_amount
 * @property float $deposit_amount
 * @property float $real_deposit_amount
 * @property float $check_amount
 * @property float $real_check_amount
 * @property float $retention_amount
 * @property float $real_retention_amount
 * @property int $opening_supervisor
 * @property int $supervisor_close
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\User $user
 */
class Turn extends Entity
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
