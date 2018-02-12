<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Employees
 * @property \Cake\ORM\Association\HasMany $Owners
 * @property \Cake\ORM\Association\HasMany $Parentsandguardians
 * @property \Cake\ORM\Association\HasMany $Students
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('id');
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

        $this->hasMany('Employees', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Owners', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Parentsandguardians', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Students', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Messages', [
            'foreignKey' => 'user_id'
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
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->requirePresence('role', 'create')
            ->notEmpty('role');

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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
    
    public function findAuth(\Cake\ORM\Query $query, array $options)
    {
        $query
            ->select(['id', 'username', 'password', 'role', 'first_name', 'second_name', 'surname', 'second_surname', 'sex', 'email', 'cell_phone', 
                'profile_photo', 'profile_photo_dir', 'created', 'modified']);
        
        return $query;
    }
}