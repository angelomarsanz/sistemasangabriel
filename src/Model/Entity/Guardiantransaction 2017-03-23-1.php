<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Guardiantransaction Entity
 *
 * @property int $id
 * @property int $parentsandguardian_id
 * @property \Cake\I18n\Time $date_and_time
 * @property string $bill_number
 * @property string $identification
 * @property string $client
 * @property string $tax_phone
 * @property string $fiscal_address
 * @property float $cash
 * @property string $debit_card
 * @property string $bank_debit
 * @property string $serial_debit
 * @property float $debit_amount
 * @property string $credit_card
 * @property string $bank_credit
 * @property string $serial_credit
 * @property float $amount_credit
 * @property string $deposit_account
 * @property string $bank_deposit
 * @property string $serial_deposit
 * @property float $amount_deposit
 * @property string $transfer_account
 * @property string $bank_transfer
 * @property string $serial_transfer
 * @property float $amount_transfer
 * @property string $check_account
 * @property string $bank_check
 * @property string $serial_check
 * @property float $amount_check
 * @property float $amount
 * @property string $responsible_user
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Parentsandguardian $parentsandguardian
 * @property \App\Model\Entity\Bill[] $bills
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
