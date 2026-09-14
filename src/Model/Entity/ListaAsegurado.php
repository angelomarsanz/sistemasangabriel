<?php
/**
 * Entidad ListaAsegurado
 *
 * Este archivo define la entidad para los registros de la tabla lista_asegurados.
 * Maneja la lógica de negocio a nivel de registro individual.
 *
 * @package App\Model\Entity
 */

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ListaAsegurado Entity
 *
 * @property string $poliza
 * @property int $certificado
 * @property string $cedu_rif
 * @property string $asegurado
 * @property string $fecha_nacimiento
 * @property string $parentesco
 * @property string $sexo
 * @property string $instruccion
 * @property string $ejecucion_reporte_seguro
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class ListaAsegurado extends Entity
{

    /**
     * Campos que pueden ser asignados masivamente usando newEntity() o patchEntity().
     *
     * Nota: El campo 'certificado' es la clave primaria autoincremental, por lo que
     * se marca como no accesible masivamente para mayor seguridad.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'certificado' => false
    ];
}
