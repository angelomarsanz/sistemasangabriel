<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Turns Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Turn get($primaryKey, $options = [])
 * @method \App\Model\Entity\Turn newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Turn[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Turn|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Turn patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Turn[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Turn findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TurnsTable extends Table
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

        $this->table('turns');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->requirePresence('turn', 'create')
            ->notEmpty('turn');

        $validator
            ->dateTime('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmpty('start_date');

        $validator
            ->dateTime('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmpty('end_date');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->numeric('initial_cash')
            ->requirePresence('initial_cash', 'create')
            ->notEmpty('initial_cash');

        $validator
            ->numeric('cash_received')
            ->requirePresence('cash_received', 'create')
            ->notEmpty('cash_received');

        $validator
            ->numeric('cash_paid')
            ->requirePresence('cash_paid', 'create')
            ->notEmpty('cash_paid');

        $validator
            ->integer('real_cash')
            ->requirePresence('real_cash', 'create')
            ->notEmpty('real_cash');

        $validator
            ->numeric('debit_card_amount')
            ->requirePresence('debit_card_amount', 'create')
            ->notEmpty('debit_card_amount');

        $validator
            ->numeric('real_debit_card_amount')
            ->requirePresence('real_debit_card_amount', 'create')
            ->notEmpty('real_debit_card_amount');

        $validator
            ->numeric('credit_card_amount')
            ->requirePresence('credit_card_amount', 'create')
            ->notEmpty('credit_card_amount');

        $validator
            ->numeric('real_credit_amount')
            ->requirePresence('real_credit_amount', 'create')
            ->notEmpty('real_credit_amount');

        $validator
            ->numeric('transfer_amount')
            ->requirePresence('transfer_amount', 'create')
            ->notEmpty('transfer_amount');

        $validator
            ->numeric('real_transfer_amount')
            ->requirePresence('real_transfer_amount', 'create')
            ->notEmpty('real_transfer_amount');

        $validator
            ->numeric('deposit_amount')
            ->requirePresence('deposit_amount', 'create')
            ->notEmpty('deposit_amount');

        $validator
            ->numeric('real_deposit_amount')
            ->requirePresence('real_deposit_amount', 'create')
            ->notEmpty('real_deposit_amount');

        $validator
            ->numeric('check_amount')
            ->requirePresence('check_amount', 'create')
            ->notEmpty('check_amount');

        $validator
            ->numeric('real_check_amount')
            ->requirePresence('real_check_amount', 'create')
            ->notEmpty('real_check_amount');

        $validator
            ->numeric('retention_amount')
            ->requirePresence('retention_amount', 'create')
            ->notEmpty('retention_amount');

        $validator
            ->numeric('real_retention_amount')
            ->requirePresence('real_retention_amount', 'create')
            ->notEmpty('real_retention_amount');

        $validator
            ->integer('opening_supervisor')
            ->requirePresence('opening_supervisor', 'create')
            ->notEmpty('opening_supervisor');

        $validator
            ->integer('supervisor_close')
            ->requirePresence('supervisor_close', 'create')
            ->notEmpty('supervisor_close');
			
        $validator
            ->allowEmpty('vector_pagos');
			
        $validator
            ->allowEmpty('vector_totales_recibidos');

        $validator
            ->allowEmpty('total_formas_pago');
			
        $validator
            ->allowEmpty('total_descuentos_recargos');
			
        $validator
            ->allowEmpty('total_general_sobrantes');
			
        $validator
            ->allowEmpty('total_general_compensado');
			
        $validator
            ->allowEmpty('total_general_facturado');
			
        $validator
            ->allowEmpty('tasa_dolar');
			
        $validator
            ->allowEmpty('tasa_euro');
			
        $validator
            ->allowEmpty('tasa_dolar_euro');
			
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
