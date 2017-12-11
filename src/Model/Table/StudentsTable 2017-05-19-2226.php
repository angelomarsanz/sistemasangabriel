<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\Event\Event;
use ArrayObject;
use Cake\ORM\TableRegistry;

/**
 * Students Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Parentsandguardians
 * @property \Cake\ORM\Association\BelongsTo $Sections
 * @property \Cake\ORM\Association\HasMany $Activitiesannexes
 * @property \Cake\ORM\Association\HasMany $Studentqualifications
 * @property \Cake\ORM\Association\HasMany $Studenttransactions
 *
 * @method \App\Model\Entity\Student get($primaryKey, $options = [])
 * @method \App\Model\Entity\Student newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Student[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Student|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Student patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Student[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Student findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StudentsTable extends Table
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

        $this->table('students');
        $this->displayField('full_name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Parentsandguardians', [
            'foreignKey' => 'parentsandguardian_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sections', [
            'foreignKey' => 'section_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Activitiesannexes', [
            'foreignKey' => 'student_id'
        ]);
        $this->hasMany('Studentqualifications', [
            'foreignKey' => 'student_id'
        ]);
        $this->hasMany('Studenttransactions', [
            'foreignKey' => 'student_id'
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
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->requirePresence('surname', 'create')
            ->notEmpty('surname');

        $validator
            ->requirePresence('sex', 'create')
            ->notEmpty('sex');

        $validator
            ->requirePresence('nationality', 'create')
            ->notEmpty('nationality');

        $validator
            ->requirePresence('family_bond_guardian_student', 'create')
            ->notEmpty('family_bond_guardian_student');

        $validator
            ->requirePresence('first_name_father', 'create')
            ->notEmpty('first_name_father');

        $validator
            ->requirePresence('surname_father', 'create')
            ->notEmpty('surname_father');

        $validator
            ->requirePresence('first_name_mother', 'create')
            ->notEmpty('first_name_mother');

        $validator
            ->requirePresence('surname_mother', 'create')
            ->notEmpty('surname_mother');

        $validator
            ->requirePresence('place_of_birth', 'create')
            ->notEmpty('place_of_birth');

        $validator
            ->requirePresence('country_of_birth', 'create')
            ->notEmpty('country_of_birth');

        $validator
            ->date('birthdate')
            ->requirePresence('birthdate', 'create')
            ->notEmpty('birthdate');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->requirePresence('cell_phone', 'create')
            ->notEmpty('cell_phone');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->requirePresence('level_of_study', 'create')
            ->notEmpty('level_of_study');

        $validator
            ->boolean('brothers_in_school')
            ->requirePresence('brothers_in_school', 'create')
            ->notEmpty('brothers_in_school');

        $validator
            ->integer('number_of_brothers')
            ->requirePresence('number_of_brothers', 'create')
            ->notEmpty('number_of_brothers');

        $validator
            ->requirePresence('previous_school', 'create')
            ->notEmpty('previous_school');

        $validator
            ->requirePresence('student_illnesses', 'create')
            ->notEmpty('student_illnesses');

        $validator
            ->requirePresence('observations', 'create')
            ->notEmpty('observations');
            
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
        $rules->add($rules->existsIn(['parentsandguardian_id'], 'Parentsandguardians'));
        $rules->add($rules->existsIn(['section_id'], 'Sections'));

        return $rules;
    }
    
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if (isset($data['parentsandguardian_id'])) {
            $family = explode(" ", $data['parentsandguardian_id']);
            $parentsandguardians = TableRegistry::get('Parentsandguardians');
            $query = $parentsandguardians->find()
                ->select(['id'])
                ->where(['family' => $family[0] . ' ' . $family[1]])
                ->first();
            if (isset($query['id']))
                $data['parentsandguardian_id'] = $query['id']; 
        }
    }    

}