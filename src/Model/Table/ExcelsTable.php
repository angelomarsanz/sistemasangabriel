<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Excels Model
 *
 * @method \App\Model\Entity\Excel get($primaryKey, $options = [])
 * @method \App\Model\Entity\Excel newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Excel[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Excel|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Excel patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Excel[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Excel findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ExcelsTable extends Table
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

        $this->table('excels');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->allowEmpty('report');

        $validator
            ->allowEmpty('start_end');

        $validator
            ->integer('number')
            ->allowEmpty('number');
			
        $validator
            ->numeric('col1')
            ->requirePresence('col1', 'create')
            ->allowEmpty('col1');
		
        $validator
            ->allowEmpty('col2');

        $validator
            ->allowEmpty('col3');

        $validator
            ->allowEmpty('col4');

        $validator
            ->allowEmpty('col5');

        $validator
            ->allowEmpty('col6');

        $validator
            ->allowEmpty('col7');

        $validator
            ->allowEmpty('col8');

        $validator
            ->allowEmpty('col9');

        $validator
            ->allowEmpty('col10');

        $validator
            ->allowEmpty('col11');

        $validator
            ->allowEmpty('col12');

        $validator
            ->allowEmpty('col13');

        $validator
            ->allowEmpty('col14');

        $validator
            ->allowEmpty('col15');

        $validator
            ->allowEmpty('col16');

        $validator
            ->allowEmpty('col17');

        $validator
            ->allowEmpty('col18');

        $validator
            ->allowEmpty('col19');

        $validator
            ->allowEmpty('col20');

        $validator
            ->allowEmpty('registration_status');

        $validator
            ->allowEmpty('reason_status');

        $validator
            ->dateTime('date_status')
            ->allowEmpty('date_status');

        $validator
            ->allowEmpty('responsible_user');

        return $validator;
    }
}
