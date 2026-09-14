<?php
/**
 * Modelo ListaAseguradosTable
 *
 * Este archivo define la clase de tabla para interactuar con la tabla lista_asegurados
 * en la base de datos. Incluye la inicialización y las reglas de validación.
 *
 * @package App\Model\Table
 */

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ListaAsegurados Model
 *
 * @method \App\Model\Entity\ListaAsegurado get($primaryKey, $options = [])
 * @method \App\Model\Entity\ListaAsegurado newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ListaAsegurado[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ListaAsegurado|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ListaAsegurado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ListaAsegurado[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ListaAsegurado findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ListaAseguradosTable extends Table
{

    /**
     * Método de inicialización
     *
     * Configura el nombre de la tabla, el campo de visualización y la clave primaria.
     * También activa el comportamiento de Timestamp para gestionar created y modified.
     *
     * @param array $config Configuración para la tabla.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('lista_asegurados');
        $this->displayField('asegurado');
        $this->primaryKey('certificado');

        $this->addBehavior('Timestamp');
    }

    /**
     * Reglas de validación por defecto.
     *
     * Define las validaciones para cada campo de la tabla asegurando que los datos
     * mantengan su integridad antes de ser guardados.
     *
     * @param \Cake\Validation\Validator $validator Instancia de Validator.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('certificado')
            ->allowEmpty('certificado', 'create');

        $validator
            ->allowEmpty('poliza');

        $validator
            ->allowEmpty('cedu_rif');

        $validator
            ->allowEmpty('asegurado');

        $validator
            ->allowEmpty('fecha_nacimiento');

        $validator
            ->allowEmpty('parentesco');

        $validator
            ->allowEmpty('sexo');

        $validator
            ->allowEmpty('instruccion');

        $validator
            ->allowEmpty('ejecucion_reporte_seguro');

        return $validator;
    }
}
