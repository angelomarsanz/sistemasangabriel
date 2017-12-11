<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Employees Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Positions
 * @property \Cake\ORM\Association\HasMany $Employeepayments
 * @property \Cake\ORM\Association\HasMany $Studentactivities
 * @property \Cake\ORM\Association\BelongsToMany $Sections
 * @property \Cake\ORM\Association\BelongsToMany $Teachingareas
 *
 * @method \App\Model\Entity\Employee get($primaryKey, $options = [])
 * @method \App\Model\Entity\Employee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Employee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Employee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Employee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Employee findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeesTable extends Table
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

        $this->table('employees');
        $this->displayField('full_name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Proffer.Proffer', [
            'profile_photo' => [    // The name of your upload field
                'root' => WWW_ROOT . 'files', // Customise the root upload folder here, or omit to use the default
                'dir' => 'profile_photo_dir',   // The name of the field to store the folder
                'thumbnailSizes' => [ // Declare your thumbnails
                    'thumb' => [   // Define the prefix of your thumbnail
                        'w' => 500, // Width
                        'h' => 500, // Height
                        'crop' => true,  // Crop will crop the image as well as resize it
                        'jpeg_quality'  => 100,
                        'png_compression_level' => 9
                    ],
                ],
                'thumbnailMethod' => 'php'  // Options are Imagick, Gd or Gmagick
            ]
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Positions', [
            'foreignKey' => 'position_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Employeepayments', [
            'foreignKey' => 'employee_id'
        ]);
        $this->hasMany('Studentactivities', [
            'foreignKey' => 'employee_id'
        ]);
        $this->belongsToMany('Sections', [
            'foreignKey' => 'employee_id',
            'targetForeignKey' => 'section_id',
            'joinTable' => 'employees_sections'
        ]);
        $this->belongsToMany('Teachingareas', [
            'foreignKey' => 'employee_id',
            'targetForeignKey' => 'teachingarea_id',
            'joinTable' => 'employees_teachingareas'
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
            ->allowEmpty('code_for_user');
            
        $validator
            ->requirePresence('first_name', 'create')
            ->allowEmpty('first_name');

        $validator
            ->allowEmpty('second_name');

        $validator
            ->requirePresence('surname', 'create')
            ->notEmpty('surname');

        $validator
            ->allowEmpty('second_surname');

        $validator
            ->requirePresence('sex', 'create')
            ->notEmpty('sex');

        $validator
            ->requirePresence('nationality', 'create')
            ->notEmpty('nationality');

        $validator
            ->requirePresence('type_of_identification', 'create')
            ->notEmpty('type_of_identification');

        $validator
            ->requirePresence('identity_card', 'create')
            ->notEmpty('identity_card');

        $validator
            ->allowEmpty('rif');

        $validator
            ->allowEmpty('profile_photo');

        $validator
            ->allowEmpty('profile_photo_dir');

        $validator
            ->allowEmpty('place_of_birth');

        $validator
            ->allowEmpty('country_of_birth');

        $validator
            ->date('birthdate')
            ->requirePresence('birthdate', 'create')
            ->notEmpty('birthdate');

        $validator
            ->allowEmpty('cell_phone');

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
            ->allowEmpty('degree_instruction');

        $validator
            ->date('date_of_admission')
            ->requirePresence('date_of_admission', 'create')
            ->notEmpty('date_of_admission');

        $validator
            ->date('retirement_date')
            ->allowEmpty('retirement_date');

        $validator
            ->allowEmpty('reason_withdrawal');

        $validator
            ->requirePresence('classification', 'create')
            ->notEmpty('classification');

        $validator
            ->allowEmpty('working_agreement');

        $validator
            ->integer('daily_hours')
            ->allowEmpty('daily_hours');

        $validator
            ->integer('weekly_hours')
            ->allowEmpty('weekly_hours');

        $validator
            ->integer('hours_month')
            ->allowEmpty('hours_month');

        $validator
            ->integer('maximum_number_sections')
            ->allowEmpty('maximum_number_sections');

        $validator
            ->integer('number_assigned_sections')
            ->allowEmpty('number_assigned_sections');

        $validator
            ->numeric('percentage_imposed')
            ->allowEmpty('percentage_imposed');

        $validator
            ->allowEmpty('record_deleted');

        $validator
            ->allowEmpty('responsible_user');

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
        $rules->add($rules->existsIn(['position_id'], 'Positions'));

        return $rules;
    }
}
