<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Concept Entity
 *
 * @property int $id
 * @property int $bill_id
 * @property int $quantity
 * @property string $accounting_code
 * @property string $concept
 * @property float $amount
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Bill $bill
 */
class Concept extends Entity
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
