<style>
    .saltopagina
    {
        display:block; 
        page-break-before:always;
    }
</style>
<div style="width: 100%;">
    <div style="width: 80%; float: left;">
        <h3 style="text-align: center;">Unidad Educativa Colegio "San Gabriel Arcángel"</h3>
        <p style="text-align: center;line-height: 5px;">Valencia, <?= $currentDate->format('d/m/Y'); ?></p>
		<?php if ($student->number_of_brothers > $currentYearRegistration): ?>
			<?php $currentYear = $student->number_of_brothers; ?>
		<?php else: ?>
			<?php $currentYear = $currentYearRegistration; ?>
		<?php endif; ?>
		<?php $nextYear = $currentYear + 1; ?>
        <?php if ($student->new_student == 0): ?>
            <p style="text-align: center;line-height: 5px;"><b>Ficha Renovación de Matrícula, Año Escolar <?= $currentYear . '-' . $nextYear ?></b></p>
        <?php else: ?>
            <p style="text-align: center;line-height: 5px;"><b>Ficha de inscripción, Año Escolar <?= $currentYear . '-' . $nextYear ?></b></p>
        <?php endif; ?>            
        <p style="text-align: center;line-height: 5px;"><?= $student->level_of_study ?></p>
    </div> 
    <div  style="width: 20%; float: left;">
        <?php if ($student->profile_photo != "" && $student->profile_photo != "Sin foto") : ?>
            <?= $this->Dompdf->image('../files/students/profile_photo/' . $student->get('profile_photo_dir') . '/'. $student->get('profile_photo'), ['width' => 250, 'height' => 250, 'class' => 'img-thumbnail img-responsive']) ?>
        <?php else: ?>
            <div style="text-align: center; width: 200px; height: 200px; border: 3px solid #555;">
                <p>Foto</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<div style="clear:both; width: 100%;">
    <?php if ($student->new_student == 0): ?>
        <p style="font-size: 25px;">Conceptos de pagos: Anticipo de matrícula 2020 y abono a agosto 2021.</p>
    <?php endif; ?>    
    <p><b>Alumno:&nbsp;<?= $student->full_name ?></b></p>
</div>
<div style="clear: both; width: 100%; border-top: 3px solid #555; font-size: 25px; line-height: 5px;">
    <div style="width: 50%; float: left; padding: 1%; text-align: left;">
        <p><b>Sexo:&nbsp;</b><?= h($student->sex) ?></p>
        <p><b>Nacionalidad:&nbsp;</b><?= h($student->nationality) ?></p>
        <p><b>Tipo de identificación:&nbsp;</b><?= h($student->type_of_identification) ?></p>
        <p><b>Número de cédula o pasaporte:&nbsp;</b><?= h($student->identity_card) ?></p>
        <p><b>Fecha de nacimiento:&nbsp;</b><?= h($student->birthdate->format('d-m-Y')) ?></p>
        <p><b>Lugar de nacimiento:&nbsp;</b></p><p><?= h($student->place_of_birth) ?></p>
        <p><b>País de nacimiento:&nbsp;</b><?= h($student->country_of_birth) ?></p>
    </div>
    <div style="width: 50%; float: left; padding: 1%; text-align: left;">
        <p><b>Teléfono de habitación:&nbsp;</b><?= h($parentsandguardian->landline) ?></p>
        <p><b>Dirección de habitación:&nbsp;</b></p><p><?= substr($student->address,0,40) ?></p><p><?= substr($student->address,40,40) ?></p>
        <p><b>Enfermedades del alumno:&nbsp;</b></p><p><?= h($student->student_illnesses) ?></p>
        <p><b>Observaciones:&nbsp;</b></p><p><?= h($student->observations) ?></p>
    </div>
</div>
<div style="clear: both; width: 100%; border-top: 3px solid #555; font-size: 25px; line-height: 5px;">
    <br />
    <p><b>Hermanos en el colegio:</b></p>
</div>
<div style="clear: left; width: 100%; border-top: 3px solid #555; font-size: 25px; padding: 1%;">
    <table style="width:100%;">
        <thead>
            <tr>
                <th style="width:55%; text-align:left;">Nombre:</th>
                <th style="width:50%; text-align:left;">Grado:</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($brothersPdf as $brothersPdfs): ?>
                <tr>
                    <td><?= $brothersPdfs['nameStudent'] ?></td>
                    <td><?= $brothersPdfs['gradeStudent'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div style="clear: left; width: 100%; border-top: 3px solid #555; font-size: 25px; line-height: 5px;">
    <br />
    <p><b>Datos de la madre:</b></p>
</div>
<div style="clear: left; width: 100%; border-top: 3px solid #555; font-size: 25px;">
    <div style="width: 50%; float: left; padding: 1%; text-align: left;">
        <p><b>Nombre:&nbsp;</b><?= h($parentsandguardian->surname_mother) . ' ' . h($parentsandguardian->first_name_mother) ?></p>
        <p><b>C.I.:&nbsp;</b><?= h($parentsandguardian->type_of_identification_mother) . ' ' . h($parentsandguardian->identidy_card_mother) ?></p>
        <p><b>Profesión:&nbsp;</b><?= h($parentsandguardian->profession_mother) ?></p>
    </div>
    <div style="width: 50%; float: left; padding: 1%; text-align: left;">
        <p><b>Teléfono trabajo:&nbsp;</b><?= h($parentsandguardian->work_phone_mother) ?></p>
        <p><b>Teléfono celular:&nbsp;</b><?= h($parentsandguardian->cell_phone_mother) ?></p>
        <p><b>Email:&nbsp;</b><?= h($parentsandguardian->email_mother) ?></p>
    </div>
</div>
<div style="clear: left; width: 100%; border-top: 3px solid #555; font-size: 25px; line-height: 5px;">
    <br />
    <p><b>Datos del padre:</b></p>
</div>
<div style="clear: left; width: 100%; border-top: 3px solid #555; font-size: 25px;">
    <div style="width: 50%; float: left; padding: 1%; text-align: left;">
        <p><b>Nombre:&nbsp;</b><?= h($parentsandguardian->surname_father) . ' ' . h($parentsandguardian->first_name_father) ?></p>
        <p><b>C.I.:&nbsp;</b><?= h($parentsandguardian->type_of_identification_father) . ' ' . h($parentsandguardian->identidy_card_father) ?></p>
        <p><b>Profesión:&nbsp;</b><?= h($parentsandguardian->profession_father) ?></p>
    </div>
    <div style="width: 50%; float: left; padding: 1%; text-align: left;">
        <p><b>Teléfono trabajo:&nbsp;</b><?= h($parentsandguardian->work_phone_father) ?></p>
        <p><b>Teléfono celular:&nbsp;</b><?= h($parentsandguardian->cell_phone_father) ?></p>
        <p><b>Email:&nbsp;</b><?= h($parentsandguardian->email_father) ?></p>
    </div>
</div>
<br />
<br />
<div style="clear:both; width: 100%;">
    <br />
    <br />
    <div style="width: 50%; float: left; padding: 1%; text-align: center;">
        <p>__________________________</p><p>Firma del representante</p>    
    </div>
    <div style="width: 50%; float: left; padding: 1%; text-align: center;">
        <p>__________________________</p><p>Firma autorizada</p>    
    </div>
</div>
<div class="saltopagina">
    <p><b>Sr. Representante es importante que lea, recuerde y practique el siguiente compromiso:</b></p>
    <div style="border-style: solid; border-width: 1px; padding: 1%;">
        <p style="text-align: justify;">1. Cumplir con las <b>Normas de Educación, Cortesía y Respeto</b> con los docentes y compañeros.</p>
        <p style="text-align: justify;">2. Cumplir con los refuerzos diarios asignados (en el día y hora).</p>
        <p style="text-align: justify;">3. Traer el <b>el justificativo</b> respectivo en caso de <b>inasistencia</b> en su diario escolar agenda para 
        poder entrar a clases al día siguiente.</p>
        <p style="text-align: justify;">4. Recoger las <b>Boletas</b> y entregarlas en los días señalados.</p>
        <p style="text-align: justify;">5. <b>Esperar</b> al representante o medio de transporte <b>dentro del plantel</b> y en el lugar asignado sin 
        excepción.</p>
        <p style="text-align: justify;">6. Asistir a clases con <b>puntualidad</b> y no salir de ella hasta su finalización, durante el desarrollo de las mismas
        deben tener una postura correcta.</p>
        <p style="text-align: justify;">7. Por normas de higiene y de conservación no se permite traer <b>chicles</b>, pero si una buena <b>merienda.</b></p>
        <p style="text-align: justify;">8. Todo equipo electrónico utilizado dentro del colegio en su horario escolar, su finalidad debe ser educativa. El colegio no se hará responsable
        por su pérdida o desaparición.</p>
        <p style="text-align: justify;">9. <b>Traer el uniforme completo:</b> Camisa con la insignia respectiva (con franelilla blanca debajo de la misma),
        pantalón, correa, medias, zapatos color negro. Cabello de corte normal y NO traer accesorios inncesarios como collares, pulseras y gorras.</p>
        <p style="text-align: justify;">10. Cumplir con el uniforme de Educación Física.</p>
        <p  style="text-align: justify;"> 11. Una vez que usted representante, realice el proceso de Matriculación de su representado, 
        está haciendo uso del cupo que le corresponde, por lo cual este cupo no puede ser concedido a otro aspirante a ingresar. Así que una vez
        efectuado este proceso y posteriormente usted decide <b>no continuar</b> en el colegio <b>no tendrá derecho a que se le reintegre lo cancelado</b> por 
        este concepto.</p>
        <p style="text-align: justify;">12. <b>Se acuerda que si durante el presente año escolar el Ministerio del Poder Popular Para la Educación o el 
        Ejecutivo Nacional a través de decreto, establezca un aumento salarial que obligue al colegio ante su personal docente, administrativo y obrero, dicho 
        aumento será trasladado en forma directa a las mensualidades que cancela cada uno por sus representados.</b></p>
		<p style="text-align: justify;">13. Informarse de las actividades y circulares de forma digital.</p>
    </div>
    <br />
    <div style="font-size: 25px;">
        <p style="text-align: justify;"><b> Yo, ___________________________________, C.I. __________________________ estoy de acuerdo y me comprometo
        a cumplir con todas las normas señaladas y establecidas por la institución en presente compromiso.</b></p>
        <br />
        <br />
        <br />
        <div style="width: 50%; float: left; padding: 1%; text-align: center;">
            <p>__________________________</p><p>Representante</p><p>C.I. _________________</p>    
        </div>
        <div style="width: 50%; float: left; padding: 1%; text-align: center;">
            <p>__________________________</p><p>Representado</p>    
        </div>
    </div>
</div>
<?php if ($student->new_student == 0): ?>
    <div class="saltopagina">
        <p><b>Nota importante:</b></p>
        <p>Para garantizar la excelencia educativa y el servicio académico que caracteriza a nuestra institución, 
		acepta estar de acuerdo con nuestros términos, especialmente en la parte correspondiente al compromiso del alumno y 
		del representante, en su numeral doce (12), que textualmente dice: "Se acuerda que si durante el presente año 
		escolar el Ministerio del Poder Popular para la Educación o el Ejecutivo Nacional a través de decreto, establezca un 
		aumento salarial que obligue al colegio ante su personal docente, administrativo y obrero, dicho aumento será 
		trasladado en forma directa a las mensualidades que cancele cada uno de sus representados".</p>
        <p><b>Recaudos para la renovación de la matrícula:</b></p>
        <?php if (substr($student->level_of_study, 0, 11) == "Pre-escolar"): ?>
            <p>a) Fotocopia de la partida de nacimiento.</p>
            <p>b) Fotografía tipo carnet reciente en digital, la misma debe adjuntarse en el formulario de actualización de datos. 
			Tenga en cuenta que si no registra la fotografía en digital deberá entregar dos (2) fotos tipo carnet en físico y 
			recientes del alumno, una deberá estar pegada en esta ficha de inscripción.</p>
			<p>c) Factura del mes de julio 2020</p>
        <?php elseif (substr($student->level_of_study, 0, 8) == "Primaria"): ?>
            <p>a) Fotocopia de la partida de nacimiento.</p>
            <p>b) Fotocopia de la cédula de identidad (de 5to. grado en adelante es indispensable por orden del M.P.P.E.).</p>
            <p>c) Fotografía tipo carnet reciente en digital, la misma debe adjuntarse en el formulario de actualización de datos. 
			Tenga en cuenta que si no registra la fotografía en digital deberá entregar dos (2) fotos tipo carnet en físico y 
			recientes del alumno, una deberá estar pegada en esta ficha de inscripción.</p>
			<p>d) Factura del mes de julio 2020</p>
        <?php else: ?>
            <p>a) Fotocopia de la cédula de identidad del alumno vigente.</p>
            <p>b) Fotografía tipo carnet reciente en digital, la misma debe adjuntarse en el formulario de actualización de datos. 
			Tenga en cuenta que si no registra la fotografía en digital deberá entregar dos (2) fotos tipo carnet en físico y 
			recientes del alumno, una deberá estar pegada en esta ficha de inscripción.</p>
			<p>c) Factura del mes de julio 2020</p>
        <?php endif; ?>
		
		<div style="color: red; text-align: center;">
			<h3>* Atención *</h3>
			<p><b>Para contribuir con las medidas preventivas del COVID-19, los recaudos para la renovación de matrícula no serán 
			obligatorios para formalizar el proceso de inscripción (temporalmente).</b></p> 
        </div>
		<p>Es importante que cumpla con el pago por concepto de Consejo Educativo (10 $ en efectivo).</p>
		<p><b>Horario de inscripción:</b></p>
        <p>8:00 am - 12:00 m</p>
        <p>El alumno estará formalmente inscrito al completar el registro (o actualización de datos) y cumplir con el pago 
		de los anticipos indicados, por tanto debe:</p>
        <p>- Actualizar en la plataforma web del Colegio (www.colegiosangabrielarcangel.com) en la sección "Actualización de datos y 
		renovación de matrícula",  los cambios de residencia o números telefónicos durante el año escolar de ser necesario.</p>
        <p>- Tenga en cuenta que si decide no continuar disfrutando de los servicios de nuestra institución, no se le podrá conceder 
		el reintegro de los pagos realizados.</p>
    </div>
<?php endif; ?>