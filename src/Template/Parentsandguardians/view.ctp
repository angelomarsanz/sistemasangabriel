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
		<?php if (isset($controller) && isset($action)): ?>
            <p><?= $this->Html->link(__('Volver'), ['controller' => $controller, 'action' => $action], ['class' => 'btn btn-sm btn-default']) ?></p>
        <?php elseif ($parentsandguardian->family != " "): ?>
            <p><?= $this->Html->link(__('Volver'), ['action' => 'viewData', $parentsandguardian->id, $parentsandguardian->family ], ['class' => 'btn btn-sm btn-default']) ?></li>
        <?php else: ?>
            <p><?= $this->Html->link(__('Volver'), ['action' => 'viewData', $parentsandguardian->id, $parentsandguardian->surname . ' ' . $parentsandguardian->first_name], ['class' => 'btn btn-sm btn-default']) ?></li>    
        <?php endif; ?>       
        <h2>Familia:&nbsp;<?= h($parentsandguardian->family) ?></h2>
    </div>
    <div class="row">
        <div class="col col-sm-4">
            <?= $this->Html->image('../files/parentsandguardians/profile_photo/' . $parentsandguardian->get('profile_photo_dir') . '/'. $parentsandguardian->get('profile_photo'), ['class' => 'img-thumbnail img-responsive']) ?>
        </div>
        <div class="col col-sm-8">  
            <h3>Datos del representante:</h3>
            <hr size="3" />
            <?php if ((isset($current_user)) && ($current_user['role'] != 'Representante')): ?> 
                <br />
                <b>Eliminado? &nbsp;</b><?= $parentsandguardian->guardian ? __('Sí') : __('No'); ?>
                <br />
                <br />
            <?php endif; ?>
                <b>Nombre:&nbsp;</b><?= h($parentsandguardian->full_name) ?>
            <br />
            <br />
                <b>Sexo:&nbsp;</b><?= h($parentsandguardian->sex) ?>
            <br />
            <br />
                <b>Tipo de identificación:&nbsp;</b><?= h($parentsandguardian->type_of_identification) ?>
            <br />
            <br />
                <b>Número de cédula o pasaporte:&nbsp;</b><?= h($parentsandguardian->identidy_card) ?>
            <br />
            <br />
                <b>Profesión:&nbsp;</b><?= h($parentsandguardian->profession) ?>
            <br />
            <br />
            <?php
            if ($parentsandguardian->item != "Otro, no especificado en esta lista"): ?>
                <b>Oficio o rubro:&nbsp;</b><?= h($parentsandguardian->item) ?>
            <?php else: ?>
                <b>Oficio o rubro:&nbsp;</b><?= h($parentsandguardian->item_not_specified) ?>
            <?php endif; ?>
            <br />
            <br />
                <b>Teléfono del trabajo:&nbsp;</b><?= h($parentsandguardian->work_phone) ?>
            <br />
            <br />
                <b>Empresa o institución donde labora:&nbsp;</b><?= h($parentsandguardian->workplace) ?>
            <br />
            <br />
                <b>Puesto que ocupa:&nbsp;</b><?= h($parentsandguardian->professional_position) ?>
            <br />
            <br />
                <b>Dirección del trabajo:&nbsp;</b><?= h($parentsandguardian->work_address) ?>
            <br />
            <br />
                <b>Teléfono celular:&nbsp;</b><?= h($parentsandguardian->cell_phone) ?>
            <br />
            <br />
                <b>Teléfono fijo:&nbsp;</b><?= h($parentsandguardian->landline) ?>
            <br />
            <br />
                <b>Email:&nbsp;</b><?= h($parentsandguardian->email) ?>
            <br />
            <br />
                <b>Dirección de habitación:&nbsp;</b><?= h($parentsandguardian->address) ?>
            <br />
            <br />
            <h3>Datos del padre:</h3>
            <hr size="3" />
                <b>Nombre:&nbsp;</b><?= h($parentsandguardian->surname_father . ' ' . $parentsandguardian->second_surname_father . ' ' . $parentsandguardian->first_name_father . ' ' . $parentsandguardian->second_name_father) ?>
            <br />
            <br />
                <b>Tipo de identificación:&nbsp;</b><?= h($parentsandguardian->type_of_identification_father) ?>
            <br />
            <br />
                <b>Número de cédula o pasaporte:&nbsp;</b><?= h($parentsandguardian->identidy_card_father) ?>
            <br />
            <br />
                <b>Dirección de habitación:&nbsp;</b><?= h($parentsandguardian->address_father) ?>
            <br />
            <br />
                <b>Email:&nbsp;</b><?= h($parentsandguardian->email_father) ?>
            <br />
            <br />
                <b>Teléfono habitación:&nbsp;</b><?= h($parentsandguardian->landline_father) ?>
            <br />
            <br />
                <b>Teléfono celular:&nbsp;</b><?= h($parentsandguardian->cell_phone_father) ?>
            <br />
            <br />
                <b>Teléfono trabajo:&nbsp;</b><?= h($parentsandguardian->work_phone_father) ?>
            <br />
            <br />
                <b>Profesión:&nbsp;</b><?= h($parentsandguardian->profession_father) ?>
            <br />
            <br />
            <h3>Datos de la madre:</h3>
            <hr size="3" />
                <b>Nombre de la madre:&nbsp;</b><?= h($parentsandguardian->surname_mother . ' ' . $parentsandguardian->second_surname_mother . ' ' . $parentsandguardian->first_name_mother . ' ' . $parentsandguardian->second_name_mother) ?>
            <br />
            <br />
                <b>Tipo de identificación:&nbsp;</b><?= h($parentsandguardian->type_of_identification_mother) ?>
            <br />
            <br />
                <b>Número de cédula o pasaporte:&nbsp;</b><?= h($parentsandguardian->identidy_card_mother) ?>
            <br />
            <br />
                <b>Dirección de habitación:&nbsp;</b><?= h($parentsandguardian->address_mother) ?>
            <br />
            <br />
                <b>Email:&nbsp;</b><?= h($parentsandguardian->email_mother) ?>
            <br />
            <br />
                <b>Teléfono habitación:&nbsp;</b><?= h($parentsandguardian->landline_mother) ?>
            <br />
            <br />
                <b>Teléfono celular:&nbsp;</b><?= h($parentsandguardian->cell_phone_mother) ?>
            <br />
            <br />
                <b>Teléfono trabajo:&nbsp;</b><?= h($parentsandguardian->work_phone_mother) ?>
            <br />
            <br />
                <b>Profesión:&nbsp;</b><?= h($parentsandguardian->profession_mother) ?>
            <br />
            <br />
            <h3>Datos para la factura:</h3>
            <hr size="3" />
                <b>Nombre o razón social:&nbsp;</b><?= h($parentsandguardian->client) ?>
            <br />
            <br />
                <b>Tipo de identificación:&nbsp;</b><?= h($parentsandguardian->type_of_identification_client) ?>
            <br />
            <br />
                <b>Número de cédula, pasaporte o RIF:&nbsp;</b><?= h($parentsandguardian->identification_number_client) ?>
            <br />
            <br />
                <b>Dirección fiscal:&nbsp;</b><?= h($parentsandguardian->fiscal_address) ?>
            <br />
            <br />
                <b>Teléfono:&nbsp;</b><?= h($parentsandguardian->tax_phone) ?>
            <br />
            <br />
        </div>
    </div>    
</div>
<div id="menu-menos-alumno" class="menumenos">
    <p>
    <a href="#" id="menu-mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger' style='padding: 4px 9px;'></a>
    </p>
</div>
<div id="menu-mas-alumno" style="display:none;" class="menumas">
    <p>
    <?= $this->Html->link(__(''), ['controller' => 'Parentsandguardians', 'action' => 'edit', $parentsandguardian->id, 'Parentsandguardians', 'view'], ['class' => 'glyphicon glyphicon-edit btn btn-sm btn-danger', 'title' => 'Actualizar datos']) ?>
    <a href="#" id="menu-menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger' style='padding: 4px 9px;'></a>
    </p>
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