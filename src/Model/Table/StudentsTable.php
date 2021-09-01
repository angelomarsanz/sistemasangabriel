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
            ->requirePresence('code_for_user', 'create')
            ->notEmpty('code_for_user');

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
            ->requirePresence('school_card', 'create')
            ->notEmpty('school_card');

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
            ->requirePresence('level_of_study', 'create')
            ->notEmpty('level_of_study');

        $validator
            ->requirePresence('section_id', 'create')
            ->notEmpty('section_id');

        $validator
            ->requirePresence('student_condition', 'create')
            ->notEmpty('student_condition');

        $validator
            ->requirePresence('scholarship', 'create')
            ->notEmpty('scholarship');

        $validator
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
        
        $validator
            ->numeric('balance')
            ->requirePresence('balance', 'create')
            ->notEmpty('balance');
        
        $validator
            ->requirePresence('creative_user', 'create')
            ->notEmpty('creative_user');
        
        $validator
            ->requirePresence('student_migration', 'create')
            ->notEmpty('student_migration');
        
        $validator
            ->requirePresence('mi_id', 'create')
            ->notEmpty('mi_id');

        $validator
            ->requirePresence('new_student', 'create')
            ->notEmpty('new_student');
			
        $validator
            ->allowEmpty('becado_ano_anterior');
			
        $validator
            ->allowEmpty('tipo_descuento_ano_anterior');
			
        $validator
            ->allowEmpty('descuento_ano_anterior');
			
        $validator
            ->allowEmpty('tipo_descuento');
			
        $validator
            ->allowEmpty('discount');
			
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
        if (isset($data['parentsandguardian_id'])) 
		{
			if (!(is_numeric($data['parentsandguardian_id']))) 
			{
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

    public function findRegular(Query $query, array $options)
    {
        $query->where([['id >' => 1], ['student_condition' => 'Regular']])
			->order(['section_id' => 'ASC', 'surname' => 'ASC', 'second_surname' => 'ASC', 'first_name' => 'ASC', 'second_name' => 'ASC']); 
		
        $arrayResult = [];
        
        if ($query)
        {
            $arrayResult['indicator'] = 0;
            $arrayResult['searchRequired'] = $query;
        }
        else
        {
            $arrayResult['indicator'] = 1;
        }
        
        return $arrayResult;
    }
    public function findFamily(Query $query, array $options)
    {
		if ($options['filtersReport'] == 'Nuevos')
		{
			$conditionQuery = [['Students.id >' => 1], ['Students.student_condition' => 'Regular'], ['Students.new_student' => 1], ['Students.balance' => $options['anoEscolarActual']]];
		}
		if ($options['filtersReport'] == 'Nuevos próximo año escolar')
		{
			$conditionQuery = [['Students.id >' => 1], ['Students.student_condition' => 'Regular'], ['Students.new_student' => 1], ['Students.balance' => $options['proximoAnoEscolar']]];
		}
        elseif ($options['filtersReport'] == 'Regulares') 
		{
			$conditionQuery = [['Students.id >' => 1], ['Students.student_condition' => 'Regular'], ['Students.new_student' => 0], ['Students.balance' => $options['anoEscolarActual']]];
		}
        elseif ($options['filtersReport'] == 'Regulares próximo año escolar') 
		{
			$conditionQuery = [['Students.id >' => 1], ['Students.student_condition' => 'Regular'], ['Students.new_student' => 0], ['Students.balance' => $options['proximoAnoEscolar']]];
		}
        elseif ($options['filtersReport'] == 'Nuevos y regulares')
		{
			$conditionQuery = [['Students.id >' => 1], ['Students.student_condition' => 'Regular'], ['Students.balance' => $options['anoEscolarActual']]];
		}
		elseif ($options['filtersReport'] == 'Todos')
		{
			$conditionQuery = [['Students.id >' => 1], ['Students.student_condition !=' => 'Eliminado'], ['Students.balance' => $options['anoEscolarActual']]];
		}
		
		if ($options['orderReport'] == 'Familia') 
		{
			$orderQuery = ['Parentsandguardians.family' => 'ASC',
				'Parentsandguardians.surname' => 'ASC',
				'Parentsandguardians.second_surname' => 'ASC',
				'Parentsandguardians.first_name' => 'ASC',
				'Parentsandguardians.second_name' => 'ASC',
				'Students.surname' => 'ASC',
				'Students.second_surname' => 'ASC',
				'Students.first_name' => 'ASC',
				'Students.second_name' => 'ASC'];
		}
		else
		{
			$orderQuery = ['Students.surname' => 'ASC',
				'Students.second_surname' => 'ASC',
				'Students.first_name' => 'ASC',
				'Students.second_name' => 'ASC'];	
		}
		
        $query->where($conditionQuery)
			->contain(['Parentsandguardians', 'Sections'])
			->order($orderQuery); 
		
        $arrayResult = [];
        
        if ($query)
        {
            $arrayResult['indicator'] = 0;
            $arrayResult['searchRequired'] = $query;
        }
        else
        {
            $arrayResult['indicator'] = 1;
        }
		        
        return $arrayResult;
    }
}