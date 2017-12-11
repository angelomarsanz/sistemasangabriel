<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Miconcepts Model
 *
 * @method \App\Model\Entity\Miconcept get($primaryKey, $options = [])
 * @method \App\Model\Entity\Miconcept newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Miconcept[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Miconcept|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Miconcept patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Miconcept[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Miconcept findOrCreate($search, callable $callback = null)
 */
class MiconceptsTable extends Table
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

        $this->table('miconcepts');
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->integer('idd')
            ->allowEmpty('idd');

        $validator
            ->integer('codigo_art')
            ->allowEmpty('codigo_art');

        $validator
            ->allowEmpty('descripcion');

        $validator
            ->allowEmpty('total');

        return $validator;
    }
}
