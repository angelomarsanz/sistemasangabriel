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
}
@media print
{
    .saltopagina
    {
        display:block; 
        page-break-before:always;
    }
}
</style>
<div class="container noVerImpreso">
    <div class="page-header volver"> 
        <p><?= $this->Html->link(__('Volver'), ['controller' => $controlador, 'action' => $accion, $student->id], ['class' => 'btn btn-sm btn-primary']) ?></p>
    </div>
    <br />
    <br />
    <div class="row">
        <div class="col-sm-10">
            <h3 style="text-align: center;">Unidad Educativa Colegio "San Gabriel Arcángel"</h3>
            <?php $currentYear = $ultimoAnoInscripcion; ?>
            <?php $nextYear = $currentYear + 1; ?>
            <?php if ($student->new_student == 0): ?>
                <p style="text-align: center;"><b>Ficha Renovación de Matrícula, Año Escolar <?= $currentYear . '-' . $nextYear ?></b></p>
            <?php else: ?>
                <p style="text-align: center;"><b>Ficha de inscripción, Año Escolar <?= $currentYear . '-' . $nextYear ?></b></p>
            <?php endif; ?>            
            <p style="text-align: center;"><b><?= $student->level_of_study ?></b></p>
            <p style="text-align: center;">Valencia, <?= $currentDate->format('d/m/Y'); ?></p>
            <h3 style="text-align: center;"><b>Alumno:&nbsp;<?= $student->full_name ?></b></h3>
        </div> 
        <div class="col-sm-2">
            <?php if ($student->profile_photo != "" && $student->profile_photo != "Sin foto") : ?>
                <?= $this->Html->image('../files/students/profile_photo/' . $student->get('profile_photo_dir') . '/'. $student->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?>
            <?php else: ?>
                <div style="text-align: center; width: 200px; height: 200px; border: 3px solid #555;">
                    <p>Foto</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php if ($student->new_student == 0): ?>
                <p><b>Conceptos de pagos:</b></p>
                <p>Diferencia de Matrícula 2023 - 2024 = 70$ - Diferencia de Agosto 2023 - 2024 =  70$ - Anticipo de Matrícula 2024 - 2025 =  190$</p>
                <p>Abono a Agosto 2024 - 2025 =  190$ - Seguro Escolar 2024 - 2025 = 20 $ (Pago único en dólares en efectivo) - <b>TOTAL A CANCELAR 540 $</b></p>
            <?php endif; ?>    
            <br />
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <p><b>Sexo:&nbsp;</b><?= h($student->sex) ?></p>
            <p><b>Nacionalidad:&nbsp;</b><?= h($student->nationality) ?></p>
            <p><b>Tipo de identificación:&nbsp;</b><?= h($student->type_of_identification) ?></p>
            <p><b>Número de cédula o pasaporte:&nbsp;</b><?= h($student->identity_card) ?></p>
            <p><b>Fecha de nacimiento:&nbsp;</b><?= h($student->birthdate->format('d-m-Y')) ?></p>
            <p><b>Lugar de nacimiento:&nbsp;</b></p><p><?= h($student->place_of_birth) ?></p>
            <p><b>País de nacimiento:&nbsp;</b><?= h($student->country_of_birth) ?></p>
        </div>
        <div class="col-sm-6">
            <p><b>Teléfono de habitación:&nbsp;</b><?= h($parentsandguardian->landline) ?></p>
            <p><b>Dirección de habitación:&nbsp;</b></p><p><?= substr($student->address,0,40) ?></p><p><?= substr($student->address,40,40) ?></p>
            <p><b>Enfermedades del alumno:&nbsp;</b></p><p><?= h($student->student_illnesses) ?></p>
            <p><b>Observaciones:&nbsp;</b></p><p><?= h($student->observations) ?></p>
        </div>
    </div>
    <br />
    <br />
    <div class="row">
        <div class="col-sm-12">
            <p><b>Hermanos en el colegio:</b></p>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
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
    <br />
    <div class="row">
        <div class="col-sm-12">
            <p><b>Datos de la madre:</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <p><b>Nombre:&nbsp;</b><?= h($parentsandguardian->surname_mother) . ' ' . h($parentsandguardian->first_name_mother) ?></p>
            <p><b>C.I.:&nbsp;</b><?= h($parentsandguardian->type_of_identification_mother) . ' ' . h($parentsandguardian->identidy_card_mother) ?></p>
            <p><b>Profesión:&nbsp;</b><?= h($parentsandguardian->profession_mother) ?></p>
        </div>
        <div class="col-sm-6">
            <p><b>Teléfono trabajo:&nbsp;</b><?= h($parentsandguardian->work_phone_mother) ?></p>
            <p><b>Teléfono celular:&nbsp;</b><?= h($parentsandguardian->cell_phone_mother) ?></p>
            <p><b>Email:&nbsp;</b><?= h($parentsandguardian->email_mother) ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <p><b>Datos del padre:</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <p><b>Nombre:&nbsp;</b><?= h($parentsandguardian->surname_father) . ' ' . h($parentsandguardian->first_name_father) ?></p>
            <p><b>C.I.:&nbsp;</b><?= h($parentsandguardian->type_of_identification_father) . ' ' . h($parentsandguardian->identidy_card_father) ?></p>
            <p><b>Profesión:&nbsp;</b><?= h($parentsandguardian->profession_father) ?></p>
        </div>
        <div class="col-sm-6">
            <p><b>Teléfono trabajo:&nbsp;</b><?= h($parentsandguardian->work_phone_father) ?></p>
            <p><b>Teléfono celular:&nbsp;</b><?= h($parentsandguardian->cell_phone_father) ?></p>
            <p><b>Email:&nbsp;</b><?= h($parentsandguardian->email_father) ?></p>
        </div>
    </div>
    <br />
    <br />
    <div class="row">
        <div class="col-sm-6">
            <p>__________________________</p>
            <p>Firma del representante</p>  
        </div>  
        <div class="col-sm-6">
            <p>__________________________</p>
            <p>Firma autorizada</p>    
        </div>
    </div>
    <br />
    <br />
    <div class="row">
        <div class="col-sm-12">
            <p style="text-align: center"><b>Recaudos para la renovación de la matricula:</b></p>
            <div style="border-style: solid; border-width: 1px; padding: 1%;">
                <p style="text-align: justify;">1. Fotocopia de la cedula de identidad (de 4to grado hasta 2do año es indispensable por orden del M.P.P.E).</p>
                <p style="text-align: justify;">2. Fotografía tipo carnet reciente en digital, la misma debe adjuntarse en el formulario de actualización de datos. Al no registrar la fotografía en digital la planilla de actualización de datos no se puede imprimir.</p>
                <p style="text-align: justify;">3. Traer 1 foto carnet actualizada en físico para anexarla en el historial académico </p>
                <p style="text-align: justify;">4. Factura del mes de julio 2024.</p>
                <p style="text-align: justify;">5. Recibo del Consejo educativo 2023-2024 (pago único en efectivo).</p>
                <p style="text-align: justify;">6. Horario de inscripción: 8:00 am - 12:30 m de lunes a viernes.</p>
            </div>
            <p>&nbsp;</p>
            <p style="text-align: center;"><b>Se formaliza la inscripción del alumno cuando:</b></p>
            <p>1. Se entrega esta ficha rellena con los datos actualizados.</p>
            <p>2. Con el pago del mes de Julio 2024.</p>
            <p>3. Con el pago del Consejo Educativo 2023-2024.</p>   
            <p style="text-align: center"><b>INFORMACIÓN:</b></p>
            <p><b>Actualización de datos para la renovación de la matricula:</b></p>
            <p>1. Somos una institución privada creada para brindar un servicio educativo, la cual depende del cumplimiento puntual y efectivo de sus mensualidades.</p>
            <p>2. Al formar parte de nuestra Comunidad Educativa, agradecemos esté en constante seguimiento del proceso académico (refuerzos diarios, etc.) y de los resultados (mediciones, cortes e informes periódicos) que se envían previo aviso por circulares electrónicas y comprometerse en asistir a reuniones y compromisos previa convocatoria con todo relacionado para el progreso de su hijo y representado en pro de una sana convivencia.</p>
            <p>3. Si decide no continuar disfrutando de los servicios de nuestra institución: a) Lo cancelado no se le podrá reintegrar b) El cupo concedido a su representado es único e intransferible a otro aspirante a ingresar sin cubrir los lineamientos indicados por nuestra institución.</p>
            <p>4. Cumpliendo con el compromiso del numeral (12) del manual de convivencia relacionado con compromisos administrativos que dice: “Se acuerda que si durante el presente año escolar el Ministerio del Poder Popular para la Educación o el Ejecutivo Nacional a través de decreto, establece un aumento salarial que obligue al colegio ante su personal docente, administrativo y obrero, dicho aumento, será trasladado en forma directa a las mensualidades que cancele cada uno de sus representados”.</p>
            <p>5. El monto de las cuotas atrasadas se calculará a la cuota vigente en el día del pago respectivo.</p>
            <p>6. Los pagos realizados en bolívares deben ser a la tasa referencial del Banco Central de Venezuela del día a transferir, solo para la mensualidad (es) pendiente(s), de esta manera no se aceptará el pago de mensualidades adelantadas al mes en curso.</p>
            <p>7. En clases presenciales es obligatorio según resolución 38160 el Seguro Escolar por lo tanto como padre y representante debe cumplir con dicho requisito </p>
            <p>8. Las mensualidades se vencen los primeros 5 días de cada mes</p>
            <p>9. Esta información debe ser impresa en el revés de la ficha de inscripción, la firmará el padre o representante y entregará en Administración.</p>
            <p>10. Esta información la encontrará siempre en la página web del colegio SGA y familiarícese con nuestros “Normativos de Sana Convivencia” y “Aspectos Administrativos”.</p>
            <p>11. Manifiesto estar informado (a) en conocimiento de lo expresado en el artículo 12 del M.P.P.E.</p>
            <p>12. Todos los niños, niñas y adolescentes tienen derecho al buen trato. Este derecho comprende una educación no violenta o inadecuadas con respeto y comprensión mutua. Por ello si en caso de que su hijo (a) presente conductas violentas dentro del aula que limiten la fluidez y la sana convivencia tiene la obligación de cumplir con asesorías psicológicas de equipos multidisciplinarios cumpliendo con terapias necesarias para que la clase se desarrolle de forma armoniosa y así mantener la sana convivencia.</p>
            <p>13. Luego de haber leído el manual de convivencia en la página web del Colegio manifiesto cumplirlo y firmo conforme.</p>
        </div>
    </div>
    <br />
    <br />
    <div class="row">
        <div class="col-sm-12">
            <p>Ambos la <b>"U.E Colegio San Gabriel Arcángel"</b> y usted (s) como familia padres y Representantes de:</p>
            <h3 style="text-align: center;"><b><?= $student->full_name ?></b></h3>
            <p>Adquirimos compromisos: a) La Institución de suministrar la educación correspondiente al currículo pautado por el M.P.P.E. b) La familia se compromete a cumplir con todas las normas señaladas y establecidas por la Institución en el presente compromiso.</p>
        </div>
    </div>
    <br />
    <br />
    <div class="row">
        <div class="col-sm-6">
            <p>__________________________</p>
            <p>Firma del representante</p>    
        </div>
        <div class="col-sm-6">
            <p>__________________________</p>
            <p>Firma del representado</p>    
        </div>
    </div>
    <br />
    <br />
    <div class="row">
        <div class="col-sm-12">
            <p>(Esta información no requiere ser impresa son aspectos de rutina diaria necesarias para una buena armonía.)</p>
            <br />
            <p style="text-align: center">Compromisos adquiridos al formar parte de la familia Gabrielana</b> 
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
    </div>
    <br />
    <br />
    <div class="row">
        <div class="col-md-12">
            <button id="imprimir-planilla" type="button" class="btn btn-success">Imprimir</button>
        </div>
    </div>
</div>
<div class="noVerEnPantalla">
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
                <li>Diferencia de Matrícula 2023 - 2024 = 70$ - Diferencia de Agosto 2023 - 2024 = 70$</li>
                <li>Anticipo de Matrícula 2024 - 2025 =  190$ - Abono a Agosto 2024 - 2025 =  190$</li>
                <li>Seguro Escolar 2024 - 2025 = 20 $ (Pago único en dólares en efectivo) - <b>TOTAL A CANCELAR 540 $</b></li>
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
    <div class="saltopagina" style="font-size: 10px;">
        <p style="text-align: center"><b>Recaudos para la renovación de la matricula:</b></p>
        <div style="border-style: solid; border-width: 1px; padding: 1%;">
            <p style="text-align: justify;">1. Fotocopia de la cedula de identidad (de 4to grado hasta 2do año es indispensable por orden del M.P.P.E).</p>
            <p style="text-align: justify;">2. Fotografía tipo carnet reciente en digital, la misma debe adjuntarse en el formulario de actualización de datos. Al no registrar la fotografía en digital la planilla de actualización de datos no se puede imprimir.</p>
            <p style="text-align: justify;">3. Traer 1 foto carnet actualizada en físico para anexarla en el historial académico </p>
            <p style="text-align: justify;">4. Factura del mes de julio 2024.</p>
            <p style="text-align: justify;">5. Recibo del Consejo educativo 2023-2024 (pago único en efectivo).</p>
            <p style="text-align: justify;">6. Horario de inscripción: 8:00 am - 12:30 m de lunes a viernes.</p>
        </div>
        <p>&nbsp;</p>
        <p style="text-align: center;"><b>Se formaliza la inscripción del alumno cuando:</b></p>
        <p>1. Se entrega esta ficha rellena con los datos actualizados.</p>
        <p>2. Con el pago del mes de Julio 2024.</p>
        <p>3. Con el pago del Consejo Educativo 2023-2024.</p>            
        <p style="text-align: center"><b>INFORMACIÓN:</b></p>
        <p><b>Actualización de datos para la renovación de la matricula:</b></p>
        <p>1. Somos una institución privada creada para brindar un servicio educativo, la cual depende del cumplimiento puntual y efectivo de sus mensualidades.</p>
        <p>2. Al formar parte de nuestra Comunidad Educativa, agradecemos esté en constante seguimiento del proceso académico (refuerzos diarios, etc.) y de los resultados (mediciones, cortes e informes periódicos) que se envían previo aviso por circulares electrónicas y comprometerse en asistir a reuniones y compromisos previa convocatoria con todo relacionado para el progreso de su hijo y representado en pro de una sana convivencia.</p>
        <p>3. Si decide no continuar disfrutando de los servicios de nuestra institución: a) Lo cancelado no se le podrá reintegrar b) El cupo concedido a su representado es único e intransferible a otro aspirante a ingresar sin cubrir los lineamientos indicados por nuestra institución.</p>
        <p>4. Cumpliendo con el compromiso del numeral (12) del manual de convivencia relacionado con compromisos administrativos que dice: “Se acuerda que si durante el presente año escolar el Ministerio del Poder Popular para la Educación o el Ejecutivo Nacional a través de decreto, establece un aumento salarial que obligue al colegio ante su personal docente, administrativo y obrero, dicho aumento, será trasladado en forma directa a las mensualidades que cancele cada uno de sus representados”.</p>
        <p>5. El monto de las cuotas atrasadas se calculará a la cuota vigente en el día del pago respectivo.</p>
        <p>6. Los pagos realizados en bolívares deben ser a la tasa referencial del Banco Central de Venezuela del día a transferir, solo para la mensualidad (es) pendiente(s), de esta manera no se aceptará el pago de mensualidades adelantadas al mes en curso.</p>
        <p>7. En clases presenciales es obligatorio según resolución 38160 el Seguro Escolar por lo tanto como padre y representante debe cumplir con dicho requisito </p>
        <p>8. Las mensualidades se vencen los primeros 5 días de cada mes</p>
        <p>9. Esta información debe ser impresa en el revés de la ficha de inscripción, la firmará el padre o representante y entregará en Administración.</p>
        <p>10. Esta información la encontrará siempre en la página web del colegio SGA y familiarícese con nuestros “Normativos de Sana Convivencia” y “Aspectos Administrativos”.</p>
        <p>11. Manifiesto estar informado (a) en conocimiento de lo expresado en el artículo 12 del M.P.P.E.</p>
        <p>12. Todos los niños, niñas y adolescentes tienen derecho al buen trato. Este derecho comprende una educación no violenta o inadecuadas con respeto y comprensión mutua. Por ello si en caso de que su hijo (a) presente conductas violentas dentro del aula que limiten la fluidez y la sana convivencia tiene la obligación de cumplir con asesorías psicológicas de equipos multidisciplinarios cumpliendo con terapias necesarias para que la clase se desarrolle de forma armoniosa y así mantener la sana convivencia.</p>
        <p>13. Luego de haber leído el manual de convivencia en la página web del Colegio manifiesto cumplirlo y firmo conforme.</p>
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
<br />
<br />
<script>
	// Eventos
	
    $(document).ready(function()
    {
        $("#imprimir-planilla").click(function()
        {							
		    imprimirPantalla();
        });					
	});
</script>     