<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Salesbooks Model
 *
 * @method \App\Model\Entity\Salesbook get($primaryKey, $options = [])
 * @method \App\Model\Entity\Salesbook newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Salesbook[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Salesbook|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Salesbook patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Salesbook[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Salesbook findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SalesbooksTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('salesbooks');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->date('fecha')
            ->allowEmpty('fecha');

        $validator
            ->allowEmpty('tipo_documento');

        $validator
            ->allowEmpty('cedula_rif');

        $validator
            ->allowEmpty('nombre_razon_social');

        $validator
            ->allowEmpty('numero_factura');

        $validator
            ->allowEmpty('numero_control');

        $validator
            ->allowEmpty('nota_debito');

        $validator
            ->allowEmpty('nota_credito');

        $validator
            ->allowEmpty('factura_afectada');

        $validator
            ->numeric('descuento_recargo')
            ->allowEmpty('descuento_recargo');

        $validator
            ->numeric('total_ventas_mas_impuesto')
            ->allowEmpty('total_ventas_mas_impuesto');

        $validator
            ->numeric('ventas_exoneradas')
            ->allowEmpty('ventas_exoneradas');

        $validator
            ->allowEmpty('base');

        $validator
            ->allowEmpty('alicuota');

        $validator
            ->numeric('iva')
            ->allowEmpty('iva');
            
        $validator
            ->allowEmpty('right_bill_number');

        $validator
            ->allowEmpty('previous_control_number');

        return $validator;
    }
}
