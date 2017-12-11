<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Studenttransaction Entity
 *
 * @property int $id
 * @property int $student_id
 * @property \Cake\I18n\Time $payment_date
 * @property string $transaction_type
 * @property string $transaction_description
 * @property bool $paid_out
 * @property float $amount
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Student $student
 */
class Studenttransaction extends Entity
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
