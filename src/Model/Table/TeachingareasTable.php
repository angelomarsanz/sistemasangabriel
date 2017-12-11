<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Teachingareas Model
 *
 * @property \Cake\ORM\Association\HasMany $Studentactivities
 * @property \Cake\ORM\Association\BelongsToMany $Employees
 *
 * @method \App\Model\Entity\Teachingarea get($primaryKey, $options = [])
 * @method \App\Model\Entity\Teachingarea newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Teachingarea[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Teachingarea|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Teachingarea patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Teachingarea[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Teachingarea findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TeachingareasTable extends Table
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

        $this->table('teachingareas');
        $this->displayField('description_teaching_area');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Studentactivities', [
            'foreignKey' => 'teachingarea_id'
        ]);
        $this->belongsToMany('Employees', [
            'foreignKey' => 'teachingarea_id',
            'targetForeignKey' => 'employee_id',
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
            ->requirePresence('description_teaching_area', 'create')
            ->notEmpty('description_teaching_area');

        return $validator;
    }
}
