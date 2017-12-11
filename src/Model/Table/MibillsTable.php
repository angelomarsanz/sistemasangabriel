<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Mibills Model
 *
 * @method \App\Model\Entity\Mibill get($primaryKey, $options = [])
 * @method \App\Model\Entity\Mibill newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Mibill[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Mibill|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mibill patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Mibill[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Mibill findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MibillsTable extends Table
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

        $this->table('mibills');
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
            ->integer('idd')
            ->allowEmpty('idd');

        $validator
            ->allowEmpty('ci');

        $validator
            ->allowEmpty('nombre');

        $validator
            ->allowEmpty('direccion');

        $validator
            ->allowEmpty('telefono');

        $validator
            ->allowEmpty('iva');

        $validator
            ->allowEmpty('total');

        $validator
            ->allowEmpty('sub');

        $validator
            ->allowEmpty('fecha');

        $validator
            ->allowEmpty('status');

        $validator
            ->integer('new_family')
            ->allowEmpty('new_family');

        return $validator;
    }
}
