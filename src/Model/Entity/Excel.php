<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Excel Entity
 *
 * @property int $id
 * @property string $report
 * @property string $start-end
 * @property int $number
 * @property string $col1
 * @property string $col2
 * @property string $col3
 * @property string $col4
 * @property string $col5
 * @property string $col6
 * @property string $col7
 * @property string $col8
 * @property string $col9
 * @property string $col10
 * @property string $col11
 * @property string $col12
 * @property string $col13
 * @property string $col14
 * @property string $col15
 * @property string $col16
 * @property string $col17
 * @property string $col18
 * @property string $col19
 * @property string $col20
 * @property string $registration_status
 * @property string $reason_status
 * @property \Cake\I18n\Time $date_status
 * @property string $responsible_user
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Excel extends Entity
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
