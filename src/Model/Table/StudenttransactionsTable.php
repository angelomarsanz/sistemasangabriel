<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Studenttransactions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Students
 *
 * @method \App\Model\Entity\Studenttransaction get($primaryKey, $options = [])
 * @method \App\Model\Entity\Studenttransaction newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Studenttransaction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Studenttransaction|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Studenttransaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Studenttransaction[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Studenttransaction findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StudenttransactionsTable extends Table
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

        $this->table('studenttransactions');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Students', [
            'foreignKey' => 'student_id',
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
            ->dateTime('payment_date')
            ->requirePresence('payment_date', 'create')
            ->notEmpty('payment_date');
			
        $validator
            ->allowEmpty('ano_escolar');

        $validator
            ->requirePresence('transaction_type', 'create')
            ->notEmpty('transaction_type');

        $validator
            ->requirePresence('way_to_pay', 'create')
            ->notEmpty('way_to_pay');

        $validator
            ->requirePresence('transaction_description', 'create')
            ->notEmpty('transaction_description');

        $validator
            ->boolean('paid_out')
            ->requirePresence('paid_out', 'create')
            ->notEmpty('paid_out');

        $validator
            ->numeric('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');
			
        $validator
            ->numeric('amount_dollar')
            ->allowEmpty('amount_dollar', 'create');

        $validator
            ->numeric('porcentaje_descuento')
            ->allowEmpty('porcentaje_descuento', 'create');            

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
        $rules->add($rules->existsIn(['student_id'], 'Students'));

        return $rules;
    }
}
