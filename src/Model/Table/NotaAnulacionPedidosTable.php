<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotaAnulacionPedidos Model
 *
 * @method \App\Model\Entity\NotaAnulacionPedido get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotaAnulacionPedido newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NotaAnulacionPedido[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotaAnulacionPedido|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotaAnulacionPedido patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotaAnulacionPedido[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotaAnulacionPedido findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NotaAnulacionPedidosTable extends Table
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

        $this->table('nota_anulacion_pedidos');
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
            ->allowEmpty('usuario_solicitante');

        return $validator;
    }
}
