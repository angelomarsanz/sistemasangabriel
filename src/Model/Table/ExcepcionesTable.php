<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Excepciones Model
 *
 * @method \App\Model\Entity\Excepcion get($primaryKey, $options = [])
 * @method \App\Model\Entity\Excepcion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Excepcion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Excepcion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Excepcion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Excepcion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Excepcion findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ExcepcionesTable extends Table
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

        $this->table('excepciones');
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
            ->numeric('anio')
            ->allowEmpty('anio');

        $validator
            ->numeric('mes')
            ->allowEmpty('mes');

        $validator
            ->numeric('identificador_asociado')
            ->allowEmpty('identificador_asociado');

        $validator
            ->numeric('consecutivo_asociado')
            ->allowEmpty('consecutivo_identificador');

        $validator
            ->allowEmpty('accion');

        $validator
            ->allowEmpty('numero_control_secuencia');
            
        $validator
            ->allowEmpty('fecha');

        $validator
            ->allowEmpty('tipo_documento');

        $validator
            ->allowEmpty('cedula_rif');

        $validator
            ->allowEmpty('nombre_razon_social');

        $validator
            ->allowEmpty('numero_control');

        $validator
            ->allowEmpty('numero_factura');

        $validator
            ->allowEmpty('nota_debito');

        $validator
            ->allowEmpty('nota_credito');

        $validator
            ->allowEmpty('factura_afectada');

        $validator
            ->numeric('total_ventas_mas_impuesto')
            ->allowEmpty('total_ventas_mas_impuesto');

        $validator
            ->numeric('descuento_recargo')
            ->allowEmpty('descuento_recargo');

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
            ->numeric('igtf')
            ->allowEmpty('igtf');

        $validator
            ->numeric('tasa_cambio')
            ->allowEmpty('tasa_cambio');

        $validator
            ->numeric('monto_divisas')
            ->allowEmpty('monto_divisas');

        $validator
            ->numeric('monto_bolivares')
            ->allowEmpty('monto_bolivares');

        return $validator;
    }
}
