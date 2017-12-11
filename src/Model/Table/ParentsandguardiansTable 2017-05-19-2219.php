<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Parentsandguardians Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $Students
 *
 * @method \App\Model\Entity\Parentsandguardian get($primaryKey, $options = [])
 * @method \App\Model\Entity\Parentsandguardian newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Parentsandguardian[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Parentsandguardian|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Parentsandguardian patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Parentsandguardian[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Parentsandguardian findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ParentsandguardiansTable extends Table
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

        $this->table('parentsandguardians');
        $this->displayField('full_name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Students', [
            'foreignKey' => 'parentsandguardian_id'
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
            ->requirePresence('type_of_identification', 'create')
            ->notEmpty('type_of_identification');

        $validator
            ->requirePresence('identidy_card', 'create')
            ->notEmpty('identidy_card');

        $validator
            ->requirePresence('profession', 'create')
            ->notEmpty('profession');

        $validator
            ->requirePresence('work_phone', 'create')
            ->notEmpty('work_phone');

        $validator
            ->requirePresence('workplace', 'create')
            ->notEmpty('workplace');

        $validator
            ->requirePresence('professional_position', 'create')
            ->notEmpty('professional_position');

        $validator
            ->requirePresence('work_address', 'create')
            ->notEmpty('work_address');

        $validator
            ->requirePresence('landline', 'create')
            ->notEmpty('landline');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');
        
        $validator
            ->requirePresence('item', 'create')
            ->notEmpty('item');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}