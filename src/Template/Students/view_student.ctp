<?php
    /**
     * Vista de datos detallados del alumno, menú adaptable y exoneraciones por período escolar.
     */
    use Cake\Routing\Router;
?>
<style>
.ui-autocomplete {
    z-index: 2000;
}
</style>
<div class="container">
    <br />
    <div class="page-header">    
        <p><?= $this->Html->link(__('Volver'), ['controller' => 'Students', 'action' => 'consultStudent'], ['class' => 'btn btn-sm btn-default']) ?></p>
        <h1>Alumno:&nbsp;<?= h($student->full_name) ?></h1>
    </div>
    <div class="row">
        <div class="col col-sm-4">
            <?= $this->Html->image('../files/students/profile_photo/' . $student->get('profile_photo_dir') . '/'. $student->get('profile_photo'), ['class' => 'img-thumbnail img-responsive']) ?>
        </div>
        <div class="col col-sm-8">    
            <br />
                <b>Sexo:&nbsp;</b><?= h($student->sex) ?>
            <br />
            <br />
                <b>Nacionalidad:&nbsp;</b><?= h($student->nationality) ?>
            <br />
            <br />
                <b>Tipo de identificación:&nbsp;</b><?= h($student->type_of_identification) ?>
            <br />
            <br />
                <b>Número de cédula o pasaporte:&nbsp;</b><?= h($student->identity_card) ?>
            <br />
            <br />
                <b>Condición del alumno:&nbsp;</b><?= h($student->student_condition) ?>
            <br />
            <br />
                <b>Vínculo familiar del representante con el alumno:&nbsp;</b><?= h($student->family_bond_guardian_student) ?>
            <br />
            <br />
                <b>Nombre del padre:&nbsp;</b><?= h($student->surname_father . ' ' . $student->second_surname_father . ' ' . $student->first_name_father . ' ' . $student->second_name_father) ?>
            <br />
            <br />
                <b>Nombre de la madre:&nbsp;</b><?= h($student->surname_mother . ' ' . $student->second_surname_mother . ' ' . $student->first_name_mother . ' ' . $student->second_name_mother) ?>
            <br />
            <br />
                <b>Fecha de nacimiento:&nbsp;</b><?= h($student->birthdate->format('d-m-Y')) ?>
            <br />
            <br />
                <b>Lugar de nacimiento:&nbsp;</b><?= h($student->place_of_birth) ?>
            <br />
            <br />
                <b>País de nacimiento:&nbsp;</b><?= h($student->country_of_birth) ?>
            <br />
            <br />
                <b>Dirección de habitación:&nbsp;</b><?= h($student->address) ?>
            <br />
            <br />
                <b>Número de teléfono celular:&nbsp;</b><?= h($student->cell_phone) ?>
            <br />
            <br />
                <b>Email:&nbsp;</b><?= h($student->email) ?>
            <br />
            <br />
                <b>Sección a la que está asignado actualmente:&nbsp;</b><?= $assignedSection ?>
            <br />
            <br />
                <b>Nivel de estudio que cursará el próximo año escolar:&nbsp;</b><?= h($student->level_of_study) ?>
            <br />
            <br />
                <b>¿Es becado?:&nbsp;</b><?= $student->scholarship ? __('Sí') : __('No'); ?>
            <br />
            <br />
                <b>Colegio de donde proviene:&nbsp;</b><?= h($student->previous_school) ?>
            <br />
            <br />
                <b>Enfermedades del alumno:&nbsp;</b><?= h($student->student_illnesses) ?>
            <br />
            <br />
                <b>Observaciones:&nbsp;</b><?= h($student->observations) ?>
            <br />
            <br />
         </div>
    </div>
    <div id="alumno-menu-acciones" class="familia-menu-acciones">
        <div id="alumno-menu-opciones" class="familia-menu-panel" hidden>
            <p class="familia-menu-titulo">Acciones del alumno</p>
            <nav aria-label="Opciones del alumno">
                <ul class="familia-menu-lista">
                    <?php if (isset($current_user['role']) && in_array($current_user['role'], ['Administrador', 'Ventas generales'])): ?>
                        <li>
                            <?= $this->Html->link(
                                '<svg class="familia-menu-icono" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 20h4l11-11a2.1 2.1 0 0 0-4-4L4 16z"/><path d="m13.5 6.5 4 4M4 20h16"/></svg><span>Modificar alumno</span>',
                                ['controller' => 'Students', 'action' => 'edit', $student->id, 'Students', 'viewStudent'],
                                ['class' => 'familia-menu-item', 'escape' => false]
                            ) ?>
                        </li>
                        <li>
                            <?= $this->Html->link(
                                '<svg class="familia-menu-icono" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 3v18M5 8h10a3 3 0 0 1 0 6H8a3 3 0 0 0 0 6h11"/></svg><span>Cambiar condición</span>',
                                ['controller' => 'Students', 'action' => 'editStatus', $student->id, 'Students', 'viewStudent'],
                                ['class' => 'familia-menu-item', 'escape' => false]
                            ) ?>
                        </li>
                        <li>
                            <?= $this->Html->link(
                                '<svg class="familia-menu-icono" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 5h16M6 5v15h12V5M9 9v7M15 9v7M9 3h6"/></svg><span>Asignar sección</span>',
                                ['controller' => 'Students', 'action' => 'editSection', $student->id, 'Students', 'viewStudent'],
                                ['class' => 'familia-menu-item', 'escape' => false]
                            ) ?>
                        </li>
                        <li>
                            <?= $this->Html->link(
                                '<svg class="familia-menu-icono" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="9" cy="8" r="3"/><path d="M3.5 20v-1.5A5.5 5.5 0 0 1 9 13h.5a5.5 5.5 0 0 1 5.5 5.5V20z"/><path d="M16 11a3 3 0 1 0 0-6M17 13.3a5.5 5.5 0 0 1 4 5.2V20h-3"/></svg><span>Reasignar familia</span>',
                                ['controller' => 'Students', 'action' => 'reasignFamilyInt', $student->id, 'Students', 'viewStudent'],
                                ['class' => 'familia-menu-item', 'escape' => false]
                            ) ?>
                        </li>
                        <li>
                            <?= $this->Html->link(
                                '<svg class="familia-menu-icono" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6 3h9l5 5v13H6z"/><path d="M15 3v6h5M12.5 12v6M10 15.5l2.5 2.5 2.5-2.5"/></svg><span>Descargar ficha de inscripción</span>',
                                ['controller' => 'Students', 'action' => 'filepdf', $student->id, 'Students', 'viewStudent'],
                                ['class' => 'familia-menu-item', 'escape' => false]
                            ) ?>
                        </li>
                    <?php elseif (isset($current_user['role']) && $current_user['role'] === 'Control de estudios'): ?>
                        <li>
                            <?= $this->Html->link(
                                '<svg class="familia-menu-icono" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 20h4l11-11a2.1 2.1 0 0 0-4-4L4 16z"/><path d="m13.5 6.5 4 4M4 20h16"/></svg><span>Modificar alumno</span>',
                                ['controller' => 'Students', 'action' => 'edit', $student->id, 'Students', 'viewStudent'],
                                ['class' => 'familia-menu-item', 'escape' => false]
                            ) ?>
                        </li>
                        <li>
                            <?= $this->Html->link(
                                '<svg class="familia-menu-icono" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 3v18M5 8h10a3 3 0 0 1 0 6H8a3 3 0 0 0 0 6h11"/></svg><span>Cambiar condición</span>',
                                ['controller' => 'Students', 'action' => 'editStatus', $student->id, 'Students', 'viewStudent'],
                                ['class' => 'familia-menu-item', 'escape' => false]
                            ) ?>
                        </li>
                        <li>
                            <?= $this->Html->link(
                                '<svg class="familia-menu-icono" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6 3h9l5 5v13H6z"/><path d="M15 3v6h5M12.5 12v6M10 15.5l2.5 2.5 2.5-2.5"/></svg><span>Descargar ficha de inscripción</span>',
                                ['controller' => 'Students', 'action' => 'filepdf', $student->id, 'Students', 'viewStudent'],
                                ['class' => 'familia-menu-item', 'escape' => false]
                            ) ?>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($current_user['role']) && in_array($current_user['role'], ['Administrador', 'Ventas generales', 'Control de estudios'])): ?>
                        <li>
                            <button
                                type="button"
                                class="familia-menu-item"
                                data-toggle="modal"
                                data-target="#modal-exoneraciones-alumno"
                                aria-haspopup="dialog"
                            >
                                <svg class="familia-menu-icono" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M5 3.5h9l5 5V20a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1z"/><path d="M14 3.5V9h5M8 13h8M8 17h3"/><circle cx="16.5" cy="16.5" r="3.5"/><path d="M16.5 14.8v3.4M17.7 15.5c-.3-.5-.7-.7-1.2-.7-.7 0-1.2.4-1.2.9 0 1.3 2.4.5 2.4 1.8 0 .5-.5 1-1.2 1-.6 0-1.1-.3-1.3-.8"/></svg>
                                <span>Exoneraciones</span>
                            </button>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <button
            type="button"
            id="alumno-menu-toggle"
            class="familia-menu-toggle"
            aria-controls="alumno-menu-opciones"
            aria-expanded="false"
            aria-label="Mostrar opciones del alumno"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            <span>Opciones</span>
        </button>
    </div>
</div>
<div
    class="modal fade"
    id="modal-exoneraciones-alumno"
    data-url="<?= h(Router::url(['controller' => 'Students', 'action' => 'actualizarExoneracionDiferencia'])) ?>"
    data-student-id="<?= h($student->id) ?>"
    tabindex="-1"
    role="dialog"
    aria-labelledby="titulo-modal-exoneraciones-alumno"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo-modal-exoneraciones-alumno">Exoneraciones del alumno</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <section class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Diferencia de matrícula</h4>
                            </div>
                            <div class="panel-body">
                                <label for="periodo-diferencia-matricula">Período escolar</label>
                                <select id="periodo-diferencia-matricula" name="periodoDiferenciaMatricula" class="form-control">
                                    <?php foreach ($periodosEscolares as $periodoEscolar): ?>
                                        <?php list($anioInicioPeriodo) = explode('-', $periodoEscolar); ?>
                                        <option
                                            value="<?= h($periodoEscolar) ?>"
                                            data-monto-formateado="<?= h(number_format($montosDiferenciaMatricula[$periodoEscolar], 2, ',', '.')) ?>"
                                            data-exonerado="<?= isset($exoneracionesPorAnio[$periodoEscolar]['Diferencia matrícula ' . $anioInicioPeriodo]) ? 'true' : 'false' ?>"
                                            <?= $periodoEscolar === $periodoEscolarActual ? 'selected' : '' ?>
                                        >
                                            <?= h($periodoEscolar) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="help-block">
                                    Monto de la diferencia: <strong>US$ <span id="monto-diferencia-matricula" aria-live="polite"><?= number_format($montosDiferenciaMatricula[$periodoEscolarActual], 2, ',', '.') ?></span></strong>
                                </p>
                                <br />
                                <button
                                    type="button"
                                    class="btn btn-primary btn-block boton-exoneracion"
                                    data-tipo-exoneracion="matricula"
                                    data-texto-exonerar="Exonerar"
                                    data-texto-eliminar="Eliminar exoneración"
                                >Exonerar</button>
                                <p class="mensaje-exoneracion" role="status" aria-live="polite"></p>
                            </div>
                        </section>
                    </div>
                    <div class="col-sm-6">
                        <section class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Diferencia de agosto</h4>
                            </div>
                            <div class="panel-body">
                                <label for="periodo-diferencia-agosto">Período escolar</label>
                                <select id="periodo-diferencia-agosto" name="periodoDiferenciaAgosto" class="form-control">
                                    <?php foreach ($periodosEscolares as $periodoEscolar): ?>
                                        <?php list($anioInicioPeriodo) = explode('-', $periodoEscolar); ?>
                                        <option
                                            value="<?= h($periodoEscolar) ?>"
                                            data-monto-formateado="<?= h(number_format($montosDiferenciaAgosto[$periodoEscolar], 2, ',', '.')) ?>"
                                            data-exonerado="<?= isset($exoneracionesPorAnio[$periodoEscolar]['Diferencia agosto ' . $anioInicioPeriodo]) ? 'true' : 'false' ?>"
                                            <?= $periodoEscolar === $periodoEscolarActual ? 'selected' : '' ?>
                                        >
                                            <?= h($periodoEscolar) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="help-block">
                                    Monto de la diferencia: <strong>US$ <span id="monto-diferencia-agosto" aria-live="polite"><?= number_format($montosDiferenciaAgosto[$periodoEscolarActual], 2, ',', '.') ?></span></strong>
                                </p>
                                <br />
                                <button
                                    type="button"
                                    class="btn btn-primary btn-block boton-exoneracion"
                                    data-tipo-exoneracion="agosto"
                                    data-texto-exonerar="Exonerar"
                                    data-texto-eliminar="Eliminar exoneración"
                                >Exonerar</button>
                                <p class="mensaje-exoneracion" role="status" aria-live="polite"></p>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
/**
 * Inicializa el menú de acciones del alumno y sus interacciones accesibles.
 */
$(document).ready(function()
{
    /**
     * Abre o cierra el panel de opciones del alumno y actualiza sus atributos accesibles.
     *
     * @param {boolean} abrir Indica si el panel debe permanecer abierto.
     */
    const alternarMenuAlumno = function(abrir)
    {
        $('#alumno-menu-opciones').prop('hidden', !abrir);
        $('#alumno-menu-toggle')
            .attr('aria-expanded', abrir ? 'true' : 'false')
            .attr('aria-label', abrir ? 'Ocultar opciones del alumno' : 'Mostrar opciones del alumno');
    };

    $('#alumno-menu-toggle').on('click', function()
    {
        alternarMenuAlumno($('#alumno-menu-toggle').attr('aria-expanded') !== 'true');
    });

    $('#alumno-menu-opciones').on('click', '[data-target="#modal-exoneraciones-alumno"]', function()
    {
        alternarMenuAlumno(false);
    });

    $('#periodo-diferencia-matricula').on('change', function()
    {
        const montoSeleccionado = $(this).find(':selected').data('monto-formateado');
        $('#monto-diferencia-matricula').text(montoSeleccionado);
    });

    $('#periodo-diferencia-agosto').on('change', function()
    {
        const montoSeleccionado = $(this).find(':selected').data('monto-formateado');
        $('#monto-diferencia-agosto').text(montoSeleccionado);
    });

    /**
     * Sincroniza el texto y el estado de la acción de exoneración.
     *
     * @param {jQuery} $boton Botón de exoneración del concepto.
     * @param {boolean} exonerado Indica si el concepto está exonerado.
     */
    const actualizarBotonExoneracion = function($boton, exonerado)
    {
        $boton
            .data('exonerado', exonerado)
            .text(exonerado ? $boton.data('texto-eliminar') : $boton.data('texto-exonerar'));
    };

    $('.boton-exoneracion').each(function()
    {
        const $boton = $(this);
        const $selector = $boton.closest('.panel-body').find('select');
        actualizarBotonExoneracion($boton, $selector.find(':selected').attr('data-exonerado') === 'true');
    });

    $('#periodo-diferencia-matricula, #periodo-diferencia-agosto').on('change', function()
    {
        const $selector = $(this);
        const $boton = $selector.closest('.panel-body').find('.boton-exoneracion');
        actualizarBotonExoneracion($boton, $selector.find(':selected').attr('data-exonerado') === 'true');
        $selector.closest('.panel-body').find('.mensaje-exoneracion').text('');
    });

    $('.boton-exoneracion').on('click', function()
    {
        const $boton = $(this);
        const $panel = $boton.closest('.panel-body');
        const $selector = $panel.find('select');
        const exonerado = $boton.data('exonerado') === true;
        const accion = exonerado ? 'eliminar' : 'exonerar';
        const $mensaje = $panel.find('.mensaje-exoneracion');
        const $modal = $('#modal-exoneraciones-alumno');

        $boton.prop('disabled', true);
        $mensaje.removeClass('text-danger').text('');

        $.ajax({
            url: $modal.data('url'),
            method: 'PUT',
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify({
                id_estudiante: Number($modal.data('student-id')),
                periodo_escolar: $selector.val(),
                tipo_exoneracion: $boton.data('tipo-exoneracion'),
                accion: accion
            })
        })
            .done(function(respuesta)
            {
                actualizarBotonExoneracion($boton, accion === 'exonerar');
                $selector.find(':selected').attr('data-exonerado', accion === 'exonerar' ? 'true' : 'false');
                $mensaje.text(accion === 'exonerar' ? 'Exoneración registrada.' : 'Exoneración eliminada.');
            })
            .fail(function(respuesta)
            {
                const mensaje = respuesta.responseJSON && respuesta.responseJSON.mensaje
                    ? respuesta.responseJSON.mensaje
                    : 'No se pudo actualizar la exoneración. Intente nuevamente.';
                $mensaje.addClass('text-danger').text(mensaje);
            })
            .always(function()
            {
                $boton.prop('disabled', false);
            });
    });

    $(document).on('click', function(evento)
    {
        if (!$(evento.target).closest('#alumno-menu-acciones').length)
        {
            alternarMenuAlumno(false);
        }
    });

    $(document).on('keydown', function(evento)
    {
        if (evento.key === 'Escape')
        {
            alternarMenuAlumno(false);
            $('#alumno-menu-toggle').trigger('focus');
        }
    });
});
</script>