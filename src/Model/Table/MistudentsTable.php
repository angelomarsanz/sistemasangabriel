<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Mistudents Model
 *
 * @method \App\Model\Entity\Mistudent get($primaryKey, $options = [])
 * @method \App\Model\Entity\Mistudent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Mistudent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Mistudent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mistudent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Mistudent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Mistudent findOrCreate($search, callable $callback = null)
 */
class MistudentsTable extends Table
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

        $this->table('mistudents');
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
            ->allowEmpty('codigo');

        $validator
            ->allowEmpty('familia');

        $validator
            ->allowEmpty('idd');

        $validator
            ->allowEmpty('apellidos');

        $validator
            ->allowEmpty('nombres');

        $validator
            ->allowEmpty('sexo');

        $validator
            ->allowEmpty('nacimiento');

        $validator
            ->allowEmpty('direccion');

        $validator
            ->allowEmpty('grado');

        $validator
            ->allowEmpty('seccion');

        $validator
            ->allowEmpty('condicion');

        $validator
            ->allowEmpty('escolaridad');

        $validator
            ->integer('cuota')
            ->allowEmpty('cuota');

        $validator
            ->decimal('saldo')
            ->allowEmpty('saldo');

        $validator
            ->integer('sep')
            ->allowEmpty('sep');

        $validator
            ->integer('oct')
            ->allowEmpty('oct');

        $validator
            ->integer('nov')
            ->allowEmpty('nov');

        $validator
            ->integer('dic')
            ->allowEmpty('dic');

        $validator
            ->integer('ene')
            ->allowEmpty('ene');

        $validator
            ->allowEmpty('feb');

        $validator
            ->allowEmpty('mar');

        $validator
            ->integer('abr')
            ->allowEmpty('abr');

        $validator
            ->allowEmpty('may');

        $validator
            ->integer('jun')
            ->allowEmpty('jun');

        $validator
            ->integer('jul')
            ->allowEmpty('jul');

        $validator
            ->integer('ago')
            ->allowEmpty('ago');

        $validator
            ->integer('mensualidad')
            ->allowEmpty('mensualidad');

        return $validator;
    }
}
