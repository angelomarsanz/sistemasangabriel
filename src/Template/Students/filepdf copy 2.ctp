<style>
@media screen
{
    .volver
    {
        display:scroll;
        position:fixed;
        top: 5%;
        left: 1%;
        opacity: 0.75;
        text-align: right;
    }
    .imprimir 
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.75;
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
    .noVerPantalla
    {
      display:none
    }
}
@media print
{
    .noVerImpreso
    {
      display:none
    }
    .saltopagina
    {
        display:block; 
        page-break-before:always;
    }
}
</style>
<div class="page-header volver noVerImpreso"> 
    <p><?= $this->Html->link(__('Volver'), ['controller' => $controlador, 'action' => $accion, $student->id], ['class' => 'btn btn-sm btn-primary']) ?></p>
</div>
<div class="noVerPantalla">
    <div style="width: 100%;">
        <div style="width: 80%; float: left;">
            <h3 style="text-align: center;">Unidad Educativa Colegio "San Gabriel Arcángel"</h3>
            <?php $currentYear = $ultimoAnoInscripcion; ?>
            <?php $nextYear = $currentYear + 1; ?>
            <?php if ($student->new_student == 0): ?>
                <p style="text-align: center;line-height: 5px;"><b>Ficha Renovación de Matrícula, Año Escolar <?= $currentYear . '-' . $nextYear ?></b></p>
            <?php else: ?>
                <p style="text-align: center;line-height: 5px;"><b>Ficha de inscripción, Año Escolar <?= $currentYear . '-' . $nextYear ?></b></p>
            <?php endif; ?>            
            <p style="text-align: center;line-height: 5px;"><b><?= $student->level_of_study ?></b></p>
            <p style="text-align: center;line-height: 5px;">Valencia, <?= $currentDate->format('d/m/Y'); ?></p>
            <p>&nbsp;</p>
        </div> 
        <div  style="width: 20%; float: left;">
            <?php if ($student->profile_photo != "" && $student->profile_photo != "Sin foto") : ?>
                <?= $this->Html->image('../files/students/profile_photo/' . $student->get('profile_photo_dir') . '/'. $student->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?>
            <?php else: ?>
                <div style="text-align: center; width: 200px; height: 200px; border: 3px solid #555;">
                    <p>Foto</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div style="clear:both; width: 100%;">
        <?php if ($student->new_student == 0): ?>
            <p style="line-height: 5px;">Conceptos de pagos:</p>
            <ul>
                <li>Diferencia de Matrícula 2020 - 2021 = 20 $ - Diferencia de Agosto 2020 - 2021 = 20 $</li>
                <li>Anticipo de Matrícula 2021 – 2022 = 65 $ - Abono a Agosto 2021 - 2022 = 65 $</li>
            </ul>
        <?php endif; ?>    
        <p><b>Alumno:&nbsp;<?= $student->full_name ?></b></p>
    </div>
    <div style="clear: both; width: 100%; border-top: 3px solid #555; line-height: 5px;">
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
    <div style="clear: both; width: 100%; border-top: 3px solid #555; line-height: 5px;">
        <br />
        <p><b>Hermanos en el colegio:</b></p>
    </div>
    <div style="clear: left; width: 100%; border-top: 3px solid #555; line-height: 5px; padding: 1%;">
        <table style="width:100%;">
            <thead>
                <tr style="line-height: 20px;">
                    <th style="width:55%; text-align:left;">Nombre:</th>
                    <th style="width:50%; text-align:left;">Grado:</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($brothersPdf as $brothersPdfs): ?>
                    <tr style="line-height: 20px;">
                        <td><?= $brothersPdfs['nameStudent'] ?></td>
                        <td><?= $brothersPdfs['gradeStudent'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div style="clear: left; width: 100%; border-top: 3px solid #555; line-height: 5px;">
        <br />
        <p><b>Datos de la madre:</b></p>
    </div>
    <div style="clear: left; width: 100%; border-top: 3px solid #555; line-height: 5px;">
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
    <div style="clear: left; width: 100%; border-top: 3px solid #555; line-height: 5px;">
        <br />
        <p><b>Datos del padre:</b></p>
    </div>
    <div style="clear: left; width: 100%; border-top: 3px solid #555; line-height: 5px;">
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
        <p style="text-align: center"><b>Recaudos para la renovación de la matricula:</b></p>
        <div style="border-style: solid; border-width: 1px; padding: 1%;">
            <p style="text-align: justify;">- Fotocopia de la partida de nacimiento.</p>
            <p style="text-align: justify;">- Fotocopia de la cédula de identidad (de 5to grado en adelante es indispensable por orden del M.P.P.E.).</p>
            <p style="text-align: justify;">- Fotografía tipo carnet reciente en digital, la misma debe adjuntarse en el formulario de actualización de datos. Al no registrar la fotografía en digital la planilla de actualización de datos no se puede imprimir.</p>
            <p style="text-align: justify;">- Traer 1 foto carnet actualizada en físico para anexarla en el historial académico</p>
            <p style="text-align: justify;">- Factura del mes de julio 2021.</p>
            <p style="text-align: justify;">- Recibo del Consejo Educativo 2020-2021 (En efectivo).</p>
        </div>
        <p>&nbsp;</p>
        <p>- <b>Horario de inscripción: 8:00 am - 12:00 m</b> de lunes a viernes.</p>
        <p>- Se formaliza la inscripción del alumno cuando:</p>
        <ul>
            <li>1. Al entregar esta ficha rellena con los datos actualizados.</li>
            <li>2. Con el pago del mes de Julio 2021.</li>
            <li>3. Con el pago del Consejo Educativo 2021.</li>            
        </ul>
        <p style="text-align: center"><b>Información:</b></p>
        <p><b>Actualización de datos para la renovación de la matricula:</b></p>
        <p>1. Somos una institución privada creada para brindar un servicio educativo, la cual depende del cumplimiento puntual y efectivo de sus mensualidades.</p>
        <p>2. Solicitamos que  actualice en la plataforma web del Colegio (www.colegiosangabrielarcángel.com) Los cambios de residencia o números telefónicos que pudieron haber ocurrido en el  año escolar. en la sección <b>"Actualización de Datos y Renovación de Matrícula"</b></p>
        <p>3. Al formar parte de nuestra comunidad Educativa, agradecemos esté en constante seguimiento del proceso académico (refuerzos diarios, etc.) y de los resultados (mediciones, cortes e informes periódicos) que se envían previo aviso por circulares electrónicas y comprometerse en asistir a reuniones y compromisos previa convocatoria con todo lo relacionado para el progreso de su hijo y representado en pro de una sana convivencia</p>
        <p>4. Si decide no continuar disfrutando de los servicios de nuestra institución a) Lo cancelado no se le podrá reintegrar b) El cupo concedido a su representado  no puede ser concedido a otro aspirante a ingresar sin cubrir los lineamientos indicados por nuestra institución.</p>
        <p>5. Cumpliendo con el compromiso del numeral (12)  relacionado con compromisos administrativos: que dice “Se acuerda que si durante el presente año escolar el Ministerio del Poder Popular para la Educación o el Ejecutivo Nacional a través de decreto, establece un aumento salarial que obligue al colegio ante su personal docente, administrativo y obrero, dicho aumento, será trasladado en forma directa a las mensualidades que cancele cada uno de sus representados”.</p>
        <p>6. En clases presenciales es obligatorio el Seguro Escolar por lo tanto como padre y representante debe cumplir con dicho requisito.</p>
        <p>7. Esta información debe ser impresa en el revés de la ficha de inscripción, la firmará el padre o representante y entregará en Administración.</p>
        <p>8. Esta información la encontrará siempre en nuestra página web del colegio SGA y familiarícese con nuestros Normativos de Sana Convivencia y Aspectos Administrativos.</p>
        <p>9. Manifiesto estar informado (a)  en conocimiento de lo expresado en el artículo 12 del  M.P.P.E.</p>
        <p>&nbsp;</p>
        <p></p>
        <div>
            <p>Ambos la <b>"U.E Colegio San Gabriel Arcángel"</b> y usted (s) como familia padres y Representantes de:</p>
            <p style="text-align: center;"><b><?= $student->full_name ?></b></p>
            <p>Adquirimos compromisos: a) La Institución de suministrar la educación correspondiente al currículo pautado por el M.P.P.E. b) La familia se compromete a cumplir con todas las normas señaladas y establecidas por la Institución en el presente compromiso.</p>
            <p>&nbsp;</p>
            <div style="width: 50%; float: left; padding: 1%; text-align: center;">
                <p>__________________________</p><br /><br /><p>Firma del representante</p>    
            </div>
            <div style="width: 50%; float: left; padding: 1%; text-align: center;">
                <p>__________________________</p><br /><br /><p>Firma del representado</p>    
            </div>
        </div>
    </div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class="noVerImpreso">
    <h3 style="text-align: center"><b>"Bienvenidos"</b></h3>
    <p style="text-align: center">Les invitamos a compartir y hacer suyos los compromisos siguientes en pro de una</p>
    <h3 style="text-align: center"><b>"Sana Convivencia"</b></h3>
    <ul>
        <li>Mantener en su rutina diaria normas de cortesía, respeto y buen trato.</li>
        <li>Asistir y participar en sus actividades académicas con regularidad y puntualidad (evitar retraso con ello evita  distracción e interrupción de clases).</li>
        <li>Informarse de las actividades culturales, extracurriculares y circulares enviadas de forma digital.</li>
        <li>En caso de inasistencia favor traer justificativo y entregar en (control de estudios para   bachillerato en enfermería para Preescolar y Primaria)</li>
        <li>Se recomienda enviar comida sana (buenas meriendas) y evitar chicles y golosinas.</li>
        <li>Nuestros alumnos de todos los niveles llegan en la mañana con todos sus útiles necesarios para el  desarrollo de la jornada académica y su respectiva alimentación, de esa manera se evita confusiones de loncheras e interrupciones en clase.</li>
        <li>Cumplir con el completo uniforme de Educación Física.</li>
        <li>Traer el Uniforme de diario completo: Camisa con la insignia respectiva, pantalón, correa, medias, zapatos color negro. Cabello de corte normal y No traer accesorios innecesarios como collares, pulseras y gorras </li>
        <li>Agradecemos esté en constante seguimiento del proceso académico y de los  resultados     (mediciones, cortes e informes periódicos) que se envían previo aviso por circulares electrónicas y comprometerse en asistir a reuniones y compromisos  previa convocatoria con todo lo relacionado para el progreso de su hijo y representado en pro de una sana convivencia.</li>
        <li>Cumplir con los refuerzos diarios asignados (en el día y hora).</li>
        <li>Asistir a clases con puntualidad y no salir de ella hasta su finalización, durante el desarrollo de las mismas deben tener una postura correcta y educada.</li>
    </ul>
</div>
<script>
	// Eventos
	
    $(document).ready(function()
    {							
		imprimirPantalla();					
	});
</script>     