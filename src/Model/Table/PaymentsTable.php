<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Payments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Bills
 *
 * @method \App\Model\Entity\Payment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Payment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Payment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Payment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Payment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Payment findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaymentsTable extends Table
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

        $this->table('payments');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Bills', [
            'foreignKey' => 'bill_id',
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
            ->notEmpty('id', 'create');
			
        $validator
            ->integer('bill_id')
            ->notEmpty('bill_id');

        $validator
            ->requirePresence('payment_type', 'create')
            ->notEmpty('payment_type');

        $validator
            ->numeric('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->requirePresence('bank', 'create')
            ->notEmpty('bank');

        $validator
            ->requirePresence('account_or_card', 'create')
            ->notEmpty('account_or_card');

        $validator
            ->notEmpty('serial');
						
        $validator
            ->allowEmpty('bill_number');
			
        $validator
            ->integer('responsible_user')
            ->allowEmpty('responsible_user');
			
        $validator
            ->integer('turn')
            ->allowEmpty('turn');

        $validator
            ->allowEmpty('annulled');	

        $validator
            ->allowEmpty('name_family');	

        $validator
            ->allowEmpty('fiscal');	

        $validator
            ->allowEmpty('moneda');	

        $validator
            ->allowEmpty('banco_receptor');	

        $validator
            ->allowEmpty('comentario');	

       $validator
            ->integer('orden_moneda')
            ->allowEmpty('orden_moneda');			

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
        $rules->add($rules->existsIn(['bill_id'], 'Bills'));

        return $rules;
    }
}
