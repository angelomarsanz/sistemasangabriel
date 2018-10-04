<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DiscountsFixture
 *
 */
class DiscountsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Id', 'autoIncrement' => true, 'precision' => null],
        'description_discount' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => 'Descripción del descuento', 'precision' => null, 'fixed' => null],
        'discount_mode' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => 'Cantidad a descontar', 'precision' => null, 'fixed' => null],
        'discount_amount' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'whole_rounding' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => 'Redondeo a entero por encima o por debajo', 'precision' => null, 'fixed' => null],
        'date_from' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Fecha inicio promoción', 'precision' => null],
        'date_until' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Fecha culminación promoción', 'precision' => null],
        'extra_column1' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'extra_column2' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'extra_column3' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'extra_column4' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'extra_column5' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'extra_column6' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'extra_column7' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'extra_column8' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'extra_column9' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'extra_column10' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'registration_status' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => 'Estatus del registro', 'precision' => null, 'fixed' => null],
        'reason_status' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => 'Motivo por el cual se cambió el estatus', 'precision' => null, 'fixed' => null],
        'date_status' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Fecha en la que se cambió el estatus', 'precision' => null],
        'responsible_user' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'comment' => 'Usuario que cambió el estatus', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_spanish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'description_discount' => 'Lorem ipsum dolor sit amet',
            'discount_mode' => 'Lorem ipsum dolor sit amet',
            'discount_amount' => 1.5,
            'whole_rounding' => 'Lorem ipsum dolor sit amet',
            'date_from' => '2018-09-14 20:01:54',
            'date_until' => '2018-09-14 20:01:54',
            'extra_column1' => 'Lorem ipsum dolor sit amet',
            'extra_column2' => 'Lorem ipsum dolor sit amet',
            'extra_column3' => 'Lorem ipsum dolor sit amet',
            'extra_column4' => 'Lorem ipsum dolor sit amet',
            'extra_column5' => 'Lorem ipsum dolor sit amet',
            'extra_column6' => 'Lorem ipsum dolor sit amet',
            'extra_column7' => 'Lorem ipsum dolor sit amet',
            'extra_column8' => 'Lorem ipsum dolor sit amet',
            'extra_column9' => 'Lorem ipsum dolor sit amet',
            'extra_column10' => 'Lorem ipsum dolor sit amet',
            'registration_status' => 'Lorem ipsum dolor sit amet',
            'reason_status' => 'Lorem ipsum dolor sit amet',
            'date_status' => '2018-09-14 20:01:54',
            'responsible_user' => 'Lorem ipsum dolor sit amet',
            'created' => '2018-09-14 20:01:54',
            'modified' => '2018-09-14 20:01:54'
        ],
    ];
}
