<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Controlnumbers Model
 *
 * @method \App\Model\Entity\Controlnumber get($primaryKey, $options = [])
 * @method \App\Model\Entity\Controlnumber newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Controlnumber[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Controlnumber|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Controlnumber patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Controlnumber[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Controlnumber findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ControlnumbersTable extends Table
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

        $this->table('controlnumbers');
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
            ->allowEmpty('id', 'create');

        $validator
            ->integer('invoice_series')
            ->requirePresence('invoice_series', 'create')
            ->notEmpty('invoice_series');

        $validator
            ->integer('invoice_lot')
            ->requirePresence('invoice_lot', 'create')
            ->notEmpty('invoice_lot');

        return $validator;
    }
}
