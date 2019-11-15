<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bancos Model
 *
 * @method \App\Model\Entity\Banco get($primaryKey, $options = [])
 * @method \App\Model\Entity\Banco newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Banco[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Banco|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Banco patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Banco[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Banco findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BancosTable extends Table
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

        $this->table('bancos');
        $this->displayField('nombre_banco');
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
            ->allowEmpty('nombre_banco');

        $validator
            ->allowEmpty('tipo_banco');

        $validator
            ->allowEmpty('estatus_registro');

        $validator
            ->allowEmpty('usuario_creador');

        $validator
            ->allowEmpty('usuario_cambio_estatus');

        $validator
            ->dateTime('fecha_cambio_estatus')
            ->allowEmpty('fecha_cambio_estatus');

        return $validator;
    }
}
