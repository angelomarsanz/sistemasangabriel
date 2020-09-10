<style>
@media screen
{
    .menumenos
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .menumas 
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .botonMenu
    {
        margin-bottom: 5 px;
    }
    .ui-autocomplete 
    {
        z-index: 2000;
    }
}
</style>
<div class="container">
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
    <div id="menu-menos-alumno" class="menumenos">
        <p>
        <a href="#" id="menu-mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger' style='padding: 4px 9px;'></a>
        </p>
    </div>
	<?php if(isset($current_user['role'])): ?>
		<?php if($current_user['role'] == 'Administrador'): ?>
			<div id="menu-mas-alumno" style="display:none;" class="menumas">
				<p>
				<?= $this->Html->link(__(''), ['controller' => 'Students', 'action' => 'edit', $student->id, 'Students', 'viewStudent'], ['class' => 'glyphicon glyphicon-edit btn btn-sm btn-danger', 'title' => 'Modificar alumno']) ?>
				<?= $this->Html->link(__(''), ['controller' => 'Students', 'action' => 'editStatus', $student->id, 'Students', 'viewStudent'], ['class' => 'glyphicon glyphicon-pencil btn btn-sm btn-danger', 'title' => 'Cambiar condición del alumno']) ?>
				<?= $this->Html->link(__(''), ['controller' => 'Students', 'action' => 'editSection', $student->id, 'Students', 'viewStudent'], ['class' => 'glyphicon glyphicon-font btn btn-sm btn-danger', 'title' => 'Asignar sección']) ?>
				<?= $this->Html->link(__(''), ['controller' => 'Students', 'action' => 'reasignFamilyInt', $student->id, 'Students', 'viewStudent'], ['class' => 'glyphicon glyphicon-user btn btn-sm btn-danger', 'title' => 'Reasignar familia']) ?>
				<?= $this->Html->link(__(''), ['controller' => 'Students', 'action' => 'filepdf', $student->id, 'viewStudent', '_ext' => 'pdf'], ['class' => 'glyphicon glyphicon-download-alt btn btn-sm btn-danger', 'title' => 'Descargar ficha de inscripción']) ?>
				<a href="#" id="menu-menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger' style='padding: 4px 9px;'></a>
				</p>
			</div>
		<?php elseif ($current_user['role'] == 'Control de estudios'): ?>
			<div id="menu-mas-alumno" style="display:none;" class="menumas">
				<p>
				<?= $this->Html->link(__(''), ['controller' => 'Students', 'action' => 'edit', $student->id, 'Students', 'viewStudent'], ['class' => 'glyphicon glyphicon-edit btn btn-sm btn-danger', 'title' => 'Modificar alumno']) ?>
				<?= $this->Html->link(__(''), ['controller' => 'Students', 'action' => 'editStatus', $student->id, 'Students', 'viewStudent'], ['class' => 'glyphicon glyphicon-pencil btn btn-sm btn-danger', 'title' => 'Cambiar condición del alumno']) ?>
				<?= $this->Html->link(__(''), ['controller' => 'Students', 'action' => 'filepdf', $student->id, 'viewStudent', '_ext' => 'pdf'], ['class' => 'glyphicon glyphicon-download-alt btn btn-sm btn-danger', 'title' => 'Descargar ficha de inscripción']) ?>
				<a href="#" id="menu-menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger' style='padding: 4px 9px;'></a>
				</p>
			</div>
		<?php endif; ?>
	<?php endif; ?>
</div>
<script>
$(document).ready(function(){ 
    $('#menu-mas').on('click',function()
    {
        $('#menu-menos-alumno').hide();
        $('#menu-mas-alumno').show();
    });
    $('#menu-menos').on('click',function()
    {
        $('#menu-mas-alumno').hide();
        $('#menu-menos-alumno').show();
    });
});
</script>