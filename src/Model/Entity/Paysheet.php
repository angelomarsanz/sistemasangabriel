<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Paysheet Entity
 *
 * @property int $id
 * @property string $year_paysheet
 * @property string $month_paysheet
 * @property string $fortnight
 * @property \Cake\I18n\Time $date_from
 * @property \Cake\I18n\Time $date_until
 * @property int $weeks_social_security
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Employeepayment[] $employeepayments
 */
class Paysheet extends Entity
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
