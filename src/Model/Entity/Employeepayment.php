<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Employeepayment Entity
 *
 * @property int $id
 * @property int $paysheet_id
 * @property int $employee_id
 * @property float $fortnight
 * @property float $scale
 * @property int $overtime
 * @property float $amount_overtime
 * @property int $night_overtime
 * @property float $amount_night_overtime
 * @property string $worked_holidays
 * @property float $amount_worked_holidays
 * @property string $worked_breaks
 * @property float $amount_worked_break
 * @property float $other_income
 * @property int $days_escrow
 * @property float $amount_escrow
 * @property float $faov
 * @property float $ivss
 * @property float $percentage_imposed
 * @property float $amount_imposed
 * @property bool $repose
 * @property float $discount_repose
 * @property float $discount_loan
 * @property int $days_absence
 * @property float $discount_absences
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Paysheet $paysheet
 * @property \App\Model\Entity\Employee $employee
 */
class Employeepayment extends Entity
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
