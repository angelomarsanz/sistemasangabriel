<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bills Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Parentsandguardians
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $Concepts
 * @property \Cake\ORM\Association\HasMany $Payments
 *
 * @method \App\Model\Entity\Bill get($primaryKey, $options = [])
 * @method \App\Model\Entity\Bill newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Bill[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Bill|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bill patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Bill[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Bill findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillsTable extends Table
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

        $this->table('bills');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Parentsandguardians', [
            'foreignKey' => 'parentsandguardian_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Concepts', [
            'foreignKey' => 'bill_id'
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'bill_id'
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
            ->dateTime('date_and_time')
            ->requirePresence('date_and_time', 'create')
            ->notEmpty('date_and_time');

        $validator
            ->requirePresence('bill_number', 'create')
            ->notEmpty('bill_number');

        $validator
            ->requirePresence('identification', 'create')
            ->notEmpty('identification');

        $validator
            ->requirePresence('client', 'create')
            ->notEmpty('client');

        $validator
            ->requirePresence('tax_phone', 'create')
            ->notEmpty('tax_phone');

        $validator
            ->requirePresence('fiscal_address', 'create')
            ->notEmpty('fiscal_address');

        $validator
            ->numeric('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->numeric('amount_paid')
            ->requirePresence('amount_paid', 'create')
            ->notEmpty('amount_paid');
        
        $validator
            ->numeric('control_number')
            ->requirePresence('control_number', 'create')
            ->notEmpty('control_number');
            
        $validator
            ->allowEmpty('right_bill_number');

        $validator
            ->allowEmpty('previous_control_number');
			
        $validator
            ->allowEmpty('impresa');

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
        $rules->add($rules->isUnique(['bill_number']));
        $rules->add($rules->existsIn(['parentsandguardian_id'], 'Parentsandguardians'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
