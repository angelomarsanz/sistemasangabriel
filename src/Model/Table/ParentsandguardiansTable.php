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
            ->allowEmpty('id', 'always');

        $validator
            ->requirePresence('code_for_user', 'always')
            ->notEmpty('code_for_user', 'Este campo es obligatorio');

        $validator
            ->requirePresence('first_name', 'always')
            ->notEmpty('first_name', 'Este campo es obligatorio');

        $validator
            ->requirePresence('surname', 'always')
            ->notEmpty('surname', 'Este campo es obligatorio');

        $validator
            ->requirePresence('family', 'always')
            ->notEmpty('family', 'Este campo es obligatorio');

        $validator
            ->requirePresence('sex', 'always')
            ->notEmpty('sex', 'Este campo es obligatorio');

        $validator
            ->requirePresence('type_of_identification', 'always')
            ->notEmpty('type_of_identification', 'Este campo es obligatorio');

        $validator
            ->requirePresence('identidy_card', 'always')
            ->notEmpty('identidy_card', 'Este campo es obligatorio');

        $validator
            ->allowEmpty('guardian');

        $validator
            ->requirePresence('family_tie', 'always')
            ->notEmpty('family_tie', 'Este campo es obligatorio');

        $validator
            ->requirePresence('profession', 'always')
            ->notEmpty('profession', 'Este campo es obligatorio');

        $validator
            ->requirePresence('item', 'always')
            ->notEmpty('item', 'Este campo es obligatorio');

        $validator
            ->allowEmpty('item_not_specified')
            ->add('item_not_specified', 'requiredIfOther', [
                'rule' => function ($value, $context) {
                    if (isset($context['data']['item']) && $context['data']['item'] === 'Otro, no especificado en esta lista') {
                        return !empty(trim($value));
                    }
                    return true;
                },
                'message' => 'Por favor especifique el rubro del representante.'
            ]);

        $validator
            ->requirePresence('work_phone', 'always')
            ->notEmpty('work_phone', 'Este campo es obligatorio');

        $validator
            ->requirePresence('workplace', 'always')
            ->notEmpty('workplace', 'Este campo es obligatorio');

        $validator
            ->requirePresence('professional_position', 'always')
            ->notEmpty('professional_position', 'Este campo es obligatorio');

        $validator
            ->requirePresence('work_address', 'always')
            ->notEmpty('work_address', 'Este campo es obligatorio');

        $validator
            ->requirePresence('cell_phone', 'always')
            ->notEmpty('cell_phone', 'Este campo es obligatorio');

        $validator
            ->requirePresence('landline', 'always')
            ->notEmpty('landline', 'Este campo es obligatorio');

        $validator
            ->requirePresence('email', 'always')
            ->notEmpty('email', 'Este campo es obligatorio');

        $validator
            ->requirePresence('address', 'always')
            ->notEmpty('address', 'Este campo es obligatorio');

        $validator
            ->requirePresence('first_name_father', 'always')
            ->notEmpty('first_name_father', 'Este campo es obligatorio');

        $validator
            ->requirePresence('surname_father', 'always')
            ->notEmpty('surname_father', 'Este campo es obligatorio');

        $validator
            ->requirePresence('type_of_identification_father', 'always')
            ->notEmpty('type_of_identification_father', 'Este campo es obligatorio');

        $validator
            ->requirePresence('identidy_card_father', 'always')
            ->notEmpty('identidy_card_father', 'Este campo es obligatorio');

        $validator
            ->requirePresence('address_father', 'always')
            ->notEmpty('address_father', 'Este campo es obligatorio');

        $validator
            ->requirePresence('email_father', 'always')
            ->notEmpty('email_father', 'Este campo es obligatorio');

        $validator
            ->requirePresence('landline_father', 'always')
            ->notEmpty('landline_father', 'Este campo es obligatorio');

        $validator
            ->requirePresence('cell_phone_father', 'always')
            ->notEmpty('cell_phone_father', 'Este campo es obligatorio');

        $validator
            ->requirePresence('profession_father', 'always')
            ->notEmpty('profession_father', 'Este campo es obligatorio');

        $validator
            ->requirePresence('rubro_trabajo_padre', 'always')
            ->notEmpty('rubro_trabajo_padre', 'Este campo es obligatorio');

        $validator
            ->allowEmpty('rubro_trabajo_padre_no_especificado')
            ->add('rubro_trabajo_padre_no_especificado', 'requiredIfOther', [
                'rule' => function ($value, $context) {
                    if (isset($context['data']['rubro_trabajo_padre']) && $context['data']['rubro_trabajo_padre'] === 'Otro, no especificado en esta lista') {
                        return !empty(trim($value));
                    }
                    return true;
                },
                'message' => 'Por favor especifique el rubro del padre.'
            ]);

        $validator
            ->requirePresence('lugar_trabajo_padre', 'always')
            ->notEmpty('lugar_trabajo_padre', 'Este campo es obligatorio');

        $validator
            ->requirePresence('direccion_trabajo_padre', 'always')
            ->notEmpty('direccion_trabajo_padre', 'Este campo es obligatorio');

        $validator
            ->requirePresence('work_phone_father', 'always')
            ->notEmpty('work_phone_father', 'Este campo es obligatorio');

        $validator
            ->requirePresence('puesto_trabajo_padre', 'always')
            ->notEmpty('puesto_trabajo_padre', 'Este campo es obligatorio');

        $validator
            ->requirePresence('first_name_mother', 'always')
            ->notEmpty('first_name_mother', 'Este campo es obligatorio');

        $validator
            ->requirePresence('surname_mother', 'always')
            ->notEmpty('surname_mother', 'Este campo es obligatorio');

        $validator
            ->requirePresence('type_of_identification_mother', 'always')
            ->notEmpty('type_of_identification_mother', 'Este campo es obligatorio');

        $validator
            ->requirePresence('identidy_card_mother', 'always')
            ->notEmpty('identidy_card_mother', 'Este campo es obligatorio');

        $validator
            ->requirePresence('address_mother', 'always')
            ->notEmpty('address_mother', 'Este campo es obligatorio');

        $validator
            ->requirePresence('email_mother', 'always')
            ->notEmpty('email_mother', 'Este campo es obligatorio');

        $validator
            ->requirePresence('landline_mother', 'always')
            ->notEmpty('landline_mother', 'Este campo es obligatorio');

        $validator
            ->requirePresence('cell_phone_mother', 'always')
            ->notEmpty('cell_phone_mother', 'Este campo es obligatorio');

        $validator
            ->requirePresence('profession_mother', 'always')
            ->notEmpty('profession_mother', 'Este campo es obligatorio');

        $validator
            ->requirePresence('rubro_trabajo_madre', 'always')
            ->notEmpty('rubro_trabajo_madre', 'Este campo es obligatorio');

        $validator
            ->allowEmpty('rubro_trabajo_madre_no_especificado')
            ->add('rubro_trabajo_madre_no_especificado', 'requiredIfOther', [
                'rule' => function ($value, $context) {
                    if (isset($context['data']['rubro_trabajo_madre']) && $context['data']['rubro_trabajo_madre'] === 'Otro, no especificado en esta lista') {
                        return !empty(trim($value));
                    }
                    return true;
                },
                'message' => 'Por favor especifique el rubro de la madre.'
            ]);

        $validator
            ->requirePresence('lugar_trabajo_madre', 'always')
            ->notEmpty('lugar_trabajo_madre', 'Este campo es obligatorio');

        $validator
            ->requirePresence('direccion_trabajo_madre', 'always')
            ->notEmpty('direccion_trabajo_madre', 'Este campo es obligatorio');

        $validator
            ->requirePresence('work_phone_mother', 'always')
            ->notEmpty('work_phone_mother', 'Este campo es obligatorio');

        $validator
            ->requirePresence('puesto_trabajo_madre', 'always')
            ->notEmpty('puesto_trabajo_madre', 'Este campo es obligatorio');

        $validator
            ->requirePresence('client', 'always')
            ->notEmpty('client', 'Este campo es obligatorio');

        $validator
            ->requirePresence('type_of_identification_client', 'always')
            ->notEmpty('type_of_identification_client', 'Este campo es obligatorio');

        $validator
            ->requirePresence('identification_number_client', 'always')
            ->notEmpty('identification_number_client', 'Este campo es obligatorio');

        $validator
            ->requirePresence('fiscal_address', 'always')
            ->notEmpty('fiscal_address', 'Este campo es obligatorio');

        $validator
            ->requirePresence('tax_phone', 'always')
            ->notEmpty('tax_phone', 'Este campo es obligatorio');

        $validator
            ->numeric('balance')
            ->requirePresence('balance', 'always')
            ->notEmpty('balance', 'Este campo es obligatorio');

        $validator
            ->requirePresence('creative_user', 'always')
            ->notEmpty('creative_user', 'Este campo es obligatorio');

        $validator
            ->requirePresence('guardian_migration', 'always')
            ->notEmpty('guardian_migration', 'Este campo es obligatorio');

        $validator
            ->requirePresence('mi_id', 'always')
            ->notEmpty('mi_id', 'Este campo es obligatorio');

        $validator
            ->requirePresence('mi_children', 'always')
            ->notEmpty('mi_children', 'Este campo es obligatorio');

        $validator
            ->requirePresence('new_guardian', 'always')
            ->notEmpty('new_guardian', 'Este campo es obligatorio');

        $validator
            ->integer('id_familia_pagadora_consejo')
            ->allowEmpty('id_familia_pagadora_consejo', 'always');

        $validator
            ->allowEmpty('vector_contratos');

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
