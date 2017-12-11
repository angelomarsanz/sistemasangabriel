<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Consecutiveinvoices Model
 *
 * @method \App\Model\Entity\Consecutiveinvoice get($primaryKey, $options = [])
 * @method \App\Model\Entity\Consecutiveinvoice newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Consecutiveinvoice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Consecutiveinvoice|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Consecutiveinvoice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Consecutiveinvoice[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Consecutiveinvoice findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ConsecutiveinvoicesTable extends Table
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

        $this->table('consecutiveinvoices');
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
            ->requirePresence('requesting_user', 'create')
            ->notEmpty('requesting_user');

        return $validator;
    }
}
