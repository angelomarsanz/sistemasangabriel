<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Monedas Model
 *
 * @property \Cake\ORM\Association\HasMany $Historicotasas
 *
 * @method \App\Model\Entity\Moneda get($primaryKey, $options = [])
 * @method \App\Model\Entity\Moneda newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Moneda[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Moneda|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Moneda patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Moneda[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Moneda findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MonedasTable extends Table
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

        $this->table('monedas');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Historicotasas', [
            'foreignKey' => 'moneda_id'
        ]);
		
        $this->hasMany('Bills', [
            'foreignKey' => 'moneda_id'
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
            ->allowEmpty('moneda');

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

	public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['moneda']));

        return $rules;
    }
}
