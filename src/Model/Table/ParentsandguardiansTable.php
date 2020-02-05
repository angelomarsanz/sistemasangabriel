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
            ->requirePresence('code_for_user', 'create')
            ->notEmpty('code_for_user');

        $validator
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->requirePresence('surname', 'create')
            ->notEmpty('surname');

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
            ->allowEmpty('guardian');

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
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');
        
        $validator
            ->requirePresence('first_name_father', 'create')
            ->notEmpty('first_name_father');
        
        $validator
            ->requirePresence('surname_father', 'create')
            ->notEmpty('surname_father');
        
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
            ->requirePresence('work_phone_father', 'create')
            ->notEmpty('work_phone_father');

        $validator
            ->requirePresence('profession_father', 'create')
            ->notEmpty('profession_father');

        $validator
            ->requirePresence('first_name_mother', 'create')
            ->notEmpty('first_name_mother');
        
        $validator
            ->requirePresence('surname_mother', 'create')
            ->notEmpty('surname_mother');
        
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
            ->requirePresence('work_phone_mother', 'create')
            ->notEmpty('work_phone_mother');

        $validator
            ->requirePresence('profession_mother', 'create')
            ->notEmpty('profession_mother');

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
            ->requirePresence('guardian_migration', 'create')
            ->notEmpty('guardian_migration');
        
        $validator
            ->requirePresence('mi_id', 'create')
            ->notEmpty('mi_id');
        
        $validator
            ->requirePresence('mi_children', 'create')
            ->notEmpty('mi_children');
            
        $validator
            ->requirePresence('new_guardian', 'create')
            ->notEmpty('new_guardian');
			
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