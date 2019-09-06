<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Historicotasas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Monedas
 *
 * @method \App\Model\Entity\Historicotasa get($primaryKey, $options = [])
 * @method \App\Model\Entity\Historicotasa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Historicotasa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Historicotasa|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Historicotasa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Historicotasa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Historicotasa findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HistoricotasasTable extends Table
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

        $this->table('historicotasas');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Monedas', [
            'foreignKey' => 'moneda_id',
            'joinType' => 'INNER'
        ]);
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
            ->decimal('tasa_cambio_dolar')
            ->allowEmpty('tasa_cambio_dolar');

        $validator
            ->allowEmpty('columna_extra1');

        $validator
            ->allowEmpty('columna_extra2');

        $validator
            ->allowEmpty('columna_extra3');

        $validator
            ->allowEmpty('columna_extra4');

        $validator
            ->allowEmpty('columna_extra5');

        $validator
            ->allowEmpty('columna_extra6');

        $validator
            ->allowEmpty('columna_extra7');

        $validator
            ->allowEmpty('columna_extra8');

        $validator
            ->allowEmpty('columna_extra9');

        $validator
            ->allowEmpty('columna_extra10');

        $validator
            ->allowEmpty('estatus_registro');

        $validator
            ->allowEmpty('motivo_cambio_estatus');

        $validator
            ->dateTime('fecha_cambio_estatus')
            ->allowEmpty('fecha_cambio_estatus');

        $validator
            ->allowEmpty('usuario_responsable');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['moneda_id'], 'Monedas'));

        return $rules;
    }
}
