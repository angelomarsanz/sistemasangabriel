<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sections Model
 *
 * @property \Cake\ORM\Association\HasMany $Studentactivities
 * @property \Cake\ORM\Association\HasMany $Students
 * @property \Cake\ORM\Association\BelongsToMany $Employees
 *
 * @method \App\Model\Entity\Section get($primaryKey, $options = [])
 * @method \App\Model\Entity\Section newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Section[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Section|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Section patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Section[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Section findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SectionsTable extends Table
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

        $this->table('sections');
        $this->displayField('full_name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Studentactivities', [
            'foreignKey' => 'section_id'
        ]);
        $this->hasMany('Students', [
            'foreignKey' => 'section_id'
        ]);
        $this->belongsToMany('Employees', [
            'foreignKey' => 'section_id',
            'targetForeignKey' => 'employee_id',
            'joinTable' => 'employees_sections'
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
            ->requirePresence('level', 'create')
            ->notEmpty('level');

        $validator
            ->requirePresence('sublevel', 'create')
            ->notEmpty('sublevel');

        $validator
            ->requirePresence('section', 'create')
            ->notEmpty('section');

        $validator
            ->integer('maximum_amount')
            ->requirePresence('maximum_amount', 'create')
            ->notEmpty('maximum_amount');

        $validator
            ->integer('registered_students')
            ->requirePresence('registered_students', 'create')
            ->notEmpty('registered_students');

        return $validator;
    }
}
