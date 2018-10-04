<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Discount Entity
 *
 * @property int $id
 * @property string $description_discount
 * @property string $discount_mode
 * @property float $discount_amount
 * @property string $whole_rounding
 * @property \Cake\I18n\Time $date_from
 * @property \Cake\I18n\Time $date_until
 * @property string $extra_column1
 * @property string $extra_column2
 * @property string $extra_column3
 * @property string $extra_column4
 * @property string $extra_column5
 * @property string $extra_column6
 * @property string $extra_column7
 * @property string $extra_column8
 * @property string $extra_column9
 * @property string $extra_column10
 * @property string $registration_status
 * @property string $reason_status
 * @property \Cake\I18n\Time $date_status
 * @property string $responsible_user
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Discount extends Entity
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
	protected function _getLabel()
	{
		return $this->_properties['description_discount'] . ' (' . $this->_properties['discount_amount'] . ')';
	}
}