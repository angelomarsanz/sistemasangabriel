<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Miparentsandguardians Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Mis
 *
 * @method \App\Model\Entity\Miparentsandguardian get($primaryKey, $options = [])
 * @method \App\Model\Entity\Miparentsandguardian newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Miparentsandguardian[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Miparentsandguardian|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Miparentsandguardian patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Miparentsandguardian[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Miparentsandguardian findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MiparentsandguardiansTable extends Table
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

        $this->table('miparentsandguardians');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Mis', [
            'foreignKey' => 'mi_id',
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
            ->requirePresence('code_for_user', 'create')
            ->notEmpty('code_for_user');

        $validator
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->requirePresence('second_name', 'create')
            ->notEmpty('second_name');

        $validator
            ->requirePresence('surname', 'create')
            ->notEmpty('surname');

        $validator
            ->requirePresence('second_surname', 'create')
            ->notEmpty('second_surname');

        $validator
            ->requirePresence('family', 'create')
            ->notEmpty('family');

        $validator
            ->requirePresence('sex', 'create')
            ->notEmpty('sex');

        $validator
            ->requirePresence('type_of_identification', 'create')
            ->notEmpty('type_of_identification');

        $validator
            ->requirePresence('identidy_card', 'create')
            ->notEmpty('identidy_card');

        $validator
            ->boolean('guardian')
            ->requirePresence('guardian', 'create')
            ->notEmpty('guardian');

        $validator
            ->requirePresence('family_tie', 'create')
            ->notEmpty('family_tie');

        $validator
            ->requirePresence('profession', 'create')
            ->notEmpty('profession');

        $validator
            ->requirePresence('item', 'create')
            ->notEmpty('item');

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
            ->requirePresence('cell_phone', 'create')
            ->notEmpty('cell_phone');

        $validator
            ->requirePresence('landline', 'create')
            ->notEmpty('landline');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->requirePresence('first_name_father', 'create')
            ->notEmpty('first_name_father');

        $validator
            ->requirePresence('second_name_father', 'create')
            ->notEmpty('second_name_father');

        $validator
            ->requirePresence('surname_father', 'create')
            ->notEmpty('surname_father');

        $validator
            ->requirePresence('second_surname_father', 'create')
            ->notEmpty('second_surname_father');

        $validator
            ->requirePresence('type_of_identification_father', 'create')
            ->notEmpty('type_of_identification_father');

        $validator
            ->requirePresence('identidy_card_father', 'create')
            ->notEmpty('identidy_card_father');

        $validator
            ->requirePresence('address_father', 'create')
            ->notEmpty('address_father');

        $validator
            ->requirePresence('email_father', 'create')
            ->notEmpty('email_father');

        $validator
            ->requirePresence('landline_father', 'create')
            ->notEmpty('landline_father');

        $validator
            ->requirePresence('cell_phone_father', 'create')
            ->notEmpty('cell_phone_father');

        $validator
            ->requirePresence('first_name_mother', 'create')
            ->notEmpty('first_name_mother');

        $validator
            ->requirePresence('second_name_mother', 'create')
            ->notEmpty('second_name_mother');

        $validator
            ->requirePresence('surname_mother', 'create')
            ->notEmpty('surname_mother');

        $validator
            ->requirePresence('second_surname_mother', 'create')
            ->notEmpty('second_surname_mother');

        $validator
            ->requirePresence('type_of_identification_mother', 'create')
            ->notEmpty('type_of_identification_mother');

        $validator
            ->requirePresence('identidy_card_mother', 'create')
            ->notEmpty('identidy_card_mother');

        $validator
            ->requirePresence('address_mother', 'create')
            ->notEmpty('address_mother');

        $validator
            ->requirePresence('email_mother', 'create')
            ->notEmpty('email_mother');

        $validator
            ->requirePresence('landline_mother', 'create')
            ->notEmpty('landline_mother');

        $validator
            ->requirePresence('cell_phone_mother', 'create')
            ->notEmpty('cell_phone_mother');

        $validator
            ->requirePresence('client', 'create')
            ->notEmpty('client');

        $validator
            ->requirePresence('type_of_identification_client', 'create')
            ->notEmpty('type_of_identification_client');

        $validator
            ->requirePresence('identification_number_client', 'create')
            ->notEmpty('identification_number_client');

        $validator
            ->requirePresence('fiscal_address', 'create')
            ->notEmpty('fiscal_address');

        $validator
            ->requirePresence('tax_phone', 'create')
            ->notEmpty('tax_phone');

        $validator
            ->numeric('balance')
            ->requirePresence('balance', 'create')
            ->notEmpty('balance');

        $validator
            ->requirePresence('creative_user', 'create')
            ->notEmpty('creative_user');

        $validator
            ->boolean('guardian_migration')
            ->requirePresence('guardian_migration', 'create')
            ->notEmpty('guardian_migration');

        $validator
            ->integer('mi_children')
            ->requirePresence('mi_children', 'create')
            ->notEmpty('mi_children');

        $validator
            ->boolean('new_guardian')
            ->requirePresence('new_guardian', 'create')
            ->notEmpty('new_guardian');

        $validator
            ->allowEmpty('profile_photo');

        $validator
            ->allowEmpty('profile_photo_dir');

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
        $rules->add($rules->existsIn(['mi_id'], 'Mis'));

        return $rules;
    }
}
