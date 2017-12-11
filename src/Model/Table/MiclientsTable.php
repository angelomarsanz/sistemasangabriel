<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Miclients Model
 *
 * @method \App\Model\Entity\Miclient get($primaryKey, $options = [])
 * @method \App\Model\Entity\Miclient newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Miclient[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Miclient|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Miclient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Miclient[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Miclient findOrCreate($search, callable $callback = null)
 */
class MiclientsTable extends Table
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

        $this->table('miclients');
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
            ->allowEmpty('clave_familia');

        $validator
            ->allowEmpty('familia');

        $validator
            ->allowEmpty('cimadre');

        $validator
            ->allowEmpty('apmadre');

        $validator
            ->allowEmpty('nomadre');

        $validator
            ->allowEmpty('dirmadre');

        $validator
            ->allowEmpty('emailmadre');

        $validator
            ->allowEmpty('telfmadre');

        $validator
            ->allowEmpty('celmadre');

        $validator
            ->allowEmpty('cipadre');

        $validator
            ->allowEmpty('appadre');

        $validator
            ->allowEmpty('nopadre');

        $validator
            ->allowEmpty('dirpadre');

        $validator
            ->allowEmpty('emailpadre');

        $validator
            ->allowEmpty('telfpadre');

        $validator
            ->allowEmpty('celpadre');

        $validator
            ->allowEmpty('nombre');

        $validator
            ->allowEmpty('ci');

        $validator
            ->allowEmpty('direccion');

        $validator
            ->allowEmpty('telefono');

        $validator
            ->integer('hijos')
            ->allowEmpty('hijos');

        $validator
            ->integer('deuda')
            ->allowEmpty('deuda');

        return $validator;
    }
}
