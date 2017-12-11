<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Guardiantransactions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Parentsandguardians
 *
 * @method \App\Model\Entity\Guardiantransaction get($primaryKey, $options = [])
 * @method \App\Model\Entity\Guardiantransaction newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Guardiantransaction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Guardiantransaction|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Guardiantransaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Guardiantransaction[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Guardiantransaction findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GuardiantransactionsTable extends Table
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

        $this->table('guardiantransactions');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Parentsandguardians', [
            'foreignKey' => 'parentsandguardian_id',
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
            ->requirePresence('bank', 'create')
            ->notEmpty('bank');

        $validator
            ->date('date_transaction')
            ->requirePresence('date_transaction', 'create')
            ->notEmpty('date_transaction');

        $validator
            ->time('time_transaction')
            ->requirePresence('time_transaction', 'create')
            ->notEmpty('time_transaction');

        $validator
            ->requirePresence('serial', 'create')
            ->notEmpty('serial');

        $validator
            ->numeric('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->requirePresence('concept', 'create')
            ->notEmpty('concept');

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
        $rules->add($rules->existsIn(['parentsandguardian_id'], 'Parentsandguardians'));

        return $rules;
    }
}
