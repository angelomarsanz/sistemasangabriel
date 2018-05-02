<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Binnacles Model
 *
 * @method \App\Model\Entity\Binnacle get($primaryKey, $options = [])
 * @method \App\Model\Entity\Binnacle newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Binnacle[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Binnacle|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Binnacle patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Binnacle[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Binnacle findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BinnaclesTable extends Table
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

        $this->table('binnacles');
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
            ->allowEmpty('novelty');

        $validator
            ->allowEmpty('type_class');

        $validator
            ->allowEmpty('class_name');

        $validator
            ->allowEmpty('method_name');

        $validator
            ->allowEmpty('extra_column1');

        $validator
            ->allowEmpty('extra_column2');

        $validator
            ->allowEmpty('extra_column3');

        $validator
            ->allowEmpty('extra_column4');

        $validator
            ->allowEmpty('extra_column5');

        $validator
            ->allowEmpty('extra_column6');

        $validator
            ->allowEmpty('extra_column7');

        $validator
            ->allowEmpty('extra_column8');

        $validator
            ->allowEmpty('extra_column9');

        $validator
            ->allowEmpty('extra_column10');

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
