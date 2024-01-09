<?php
    use Cake\I18n\Time;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    	<div class="page-header" style="text-align: center;">
    		<h3>REPÚBLICA BOLIVARIANA DE VENEZUELA MINISTERIO DEL PODER POPULAR PARA LA EDUCACION “U.E.C. SAN GABRIEL ARCÁNGEL” VALENCIA, ESTADO CARABOBO CONTRATO DE PRESTACIÓN DE SERVICIOS EDUCATIVOS</h3>
		</div>
		<div style="text-align: justify;">
			<p>Entre la “U.E.C. SAN GABRIEL ARCÁNGEL, C.A.”, Inscrita Legalmente en el Ministerio de Educación, Cultura y Deporte bajo el N° S.3157D0814, Valencia- Estado Carabobo, representada en este acto por LA DIRECTORA, el ciudadano: ANA MARIA PEREZ TORREIRO, mayor de edad, venezolano, titular de la cédula de identidad No. V -12.103.708 domiciliado en la ciudad de Valencia, estado Carabobo, quien en lo adelante y a los efectos del presente Contrato se denominará “U.E.C. SAN GABRIEL ARCÁNGEL, C.A.”, por una parte y por la otra el(la) ciudadano(a): <?= $representante->full_name ?>, portador de la Cédula de Identidad No. <?= $representante->	type_of_identification."-".$representante->identidy_card ?>, quien en lo adelante y a los efectos de este Contrato se denominará “EL REPRESENTANTE”, de (los) alumno(s): <?php foreach ($representante->students as $estudiante): ?><span><?= $estudiante->full_name.", "?></span><?php endforeach; ?>han convenido en celebrar el presente Contrato de Prestación de Servicios Educativos, el cual se regirá a tenor de las cláusulas siguientes:</p>
			<br />
			<p><b>CLAUSULA PRIMERA:</b>  Se denomina “U.E.C. SAN GABRIEL ARCÁNGEL, C.A.” a la Institución Educativa que presta servicios tales como instrucción, atención, educación integral y cuido en general a los sujetos (niños, niñas, adolescentes o mayores de edad) que así lo requieran. “EL REPRESENTANTE”, se entiende a la persona natural o jurídica que tiene bajo su representación a otra (padre, madre, representante y responsable), generalmente a un niño o adolescente que en la U.E.C. SAN GABRIEL ARCÁNGEL, C.A. le brinda los servicios. Forma parte integral del presente Contrato de Prestación de Servicios Educativos, el reglamento interno de la Unidad Educativa, las decisiones acordadas en Asambleas y Comité de Madres, Padres, Representantes y Responsables, el contenido en la legislación jurídica, especialmente referente a la Ley Orgánica de Educación, la Ley Orgánica para la Protección de Niños, Niñas y Adolescentes, Reglamentos de Ley, Resoluciones, Decretos y Circulares entre otros.</p>
			<br />
			<p><b>CLAUSULA SEGUNDA:</b> LA “U.E.C. SAN GABRIEL ARCÁNGEL, C.A.” se compromete a prestar sus servicios como empresa educativa para la instrucción, atención, educación integral y cuido en general durante los días hábiles de lunes a viernes, al alumno o alumnos, niños, niñas o adolescentes, indicados en las solicitudes debidamente firmada(s) por “EL REPRESENTANTE” correspondiente a el turno de la mañana del presente contrato. </p>
			<br />
			<p><b>CLAUSULA TERCERA:</b> La vigencia del presente Contrato es por el lapso de Un (01) año (año escolar), entendiéndose por tal el que se inicia en el mes de Septiembre del presente año y culmina en el mes de agosto del año siguiente, aunque la prestación real y efectiva de los servicios se limiten a los Ciento Ochenta (180) días hábiles que fija como mínimo el artículo 46 de la Ley Orgánica de Educación, quedando expresamente convenido que el presente Contrato quedará resuelto de pleno derecho, por vencimiento del plazo en el mes de Agosto del año siguiente a la inscripción, no siendo prorrogable bajo ninguna circunstancia.</p>
			<br />
			<p><b>CLAUSULA CUARTA:</b> Se considera perfeccionado el presente Contrato, en la oportunidad en que “EL REPRESENTANTE” firme la inscripción y declare conocer y estar conforme con el reglamento interno, así como pago total o parcialmente el monto de la matrícula (inscripción, seguro escolar y servicios educativos). </p>
			<br />
			<p><b>CLAUSULA QUINTA:</b> “EL REPRESENTANTE” se compromete a cancelar a “U.E.C. SAN GABRIEL ARCÁNGEL, C.A.”  por la prestación de los servicios educativos correspondientes al año escolar 2023-2024, el pago de trece (13) cuotas de la siguiente manera: Once (11) cuotas que deberán ser canceladas en mensualidades por adelantadas los primeros cinco (05) días de cada mes (desde Septiembre 2023 a Julio 2024), dos (02) cuotas restantes correspondientes la Inscripción (Anticipo de Matrícula año escolar 2023-2024 y Anticipo del mes Agosto del 2024), debido al aumento de las mensualidades dentro del año escolar 2022-2023 se debe cancelar la diferencia correspondiente a (diferencia de Matricula año escolar 2022-2023 y diferencia del mes Agosto 2023). </p>
			<br />
			<p><b>CLAUSULA SEXTA:</b> “EL REPRESENTANTE” deberá pagar las mensualidades en el mes en curso, correspondiente a la escolaridad de sus representados</p>
			<br />
			<p><b>CLAUSULA SÉPTIMA:</b> “EL REPRESENTANTE” declara expresamente la aceptación de los montos fijados como derecho de escolaridad para el año escolar 2023-2024, los cuales podrán ser objeto de ajuste, previa aprobación en Asambleas virtuales del Comité de Madres, Padres, Representantes y Responsables, a través de la plataforma de la institución, por variación de los costos, tales como los aumentos de sueldo decretados por el Ejecutivo Nacional, incremento de los servicios públicos, equipos, insumos, y otros. Queda entendido que en caso de ajuste de los derechos de escolaridad. “U.E.C. SAN GABRIEL ARCÁNGEL, C.A.” lo participará a “EL REPRESENTANTE” con treinta (30) días de anticipación a la toma de la medida. La notificación consistirá en una simple comunicación enviada a “EL REPRESENTANTE” a través de circular, donde brevemente se explique los motivos que dieron origen al ajuste en los derechos de escolaridad. Asimismo, “EL REPRESENTANTE” acepta que en caso de las mensualidades (cuotas) canceladas por adelantado, deberá pagar las diferencias respectivas.</p>
			<br />
			<p><b>CLAUSULA OCTAVA:</b> La falta de pago de una (01) mensualidad (cuota) por parte de “EL REPRESENTANTE”, la “U.E.C. SAN GABRIEL ARCÁNGEL, C.A.” no suspenderá los servicios educativos prestados a su(s) representado(s), durante el lapso que dure el atraso del pago, sin que por ello se suspenda o se extinga la obligación de cancelar las mensualidades (cuotas) causadas. Queda expresamente convenido que “U.E.C. SAN GABRIEL ARCÁNGEL, C.A.” accionará, en caso de no cumplir con el pago de tres (3) meses, ocasionará a “EL REPRESENTANTE”, procedimiento de cobro extrajudicial, y a su vez, en caso de incumplimiento, Procedimiento de Intimación ante el Tribunal correspondiente, así también como los daños y perjuicios que se pudieran ocasionar.</p>
			<br />
			<p><b>CLÁUSULA NOVENA:</b> En caso de resolución anticipada del presente contrato “EL REPRESENTANTE” no tendrá derecho a reembolso o reintegro de lo pagado por concepto de matrícula y mensualidades si así lo hubiere, queda entendido que las sumas pagadas a “EL REPRESENTANTE” bajo ningún concepto ni por ninguna causa.</p>
			<br />
			<p><b>CLÁUSULA DÉCIMA:</b> “EL REPRESENTANTE” acepta y reconoce que la “U.E.C. SAN GABRIEL ARCÁNGEL, C.A.”, involucra la fe católica a través de la instrucción, sus representados participaran en actividades, sacramentos, la iglesia y la moralidad.</p>
			<br />
			<p><b>CLÁUSULA DÉCIMA PRIMERA:</b> “U.E.C. SAN GABRIEL ARCÁNGEL, C.A.” podrá dar por terminado este contrato por las siguientes causas: 1) Por incumplimiento de “EL REPRESENTANTE”, de las obligaciones contenidas en presente contrato; 2) Por mantener “EL REPRESENTANTE” una actitud pasiva en la participación de las actividades escolares, comunicadas por escrito por “U.E.C. SAN GABRIEL ARCÁNGEL, C.A.”, pues queda entendido que tal inactividad perjudicaría la prestación de los servicios que se contrae con el presente contrato.</p>
			<br />
			<p><b>CLÁUSULA DÉCIMA SEGUNDA:</b> Tal como expresa el artículo 54 dela Ley Orgánica para la Protección del Niño Niña y Adolescente:  “Es obligación de los padres y representantes o responsables en materia educación los padres representantes o responsables tiene la obligación inmediata de garantizar la educación de los niños y adolescentes en consecuencia deben inscribir los oportunamente en una escuela plantel o institución de educación de conformidad con la ley así como exigirle su asistencia regular a clases y participar activamente en su proceso educativo”.</p>
			<br />
			<p><b>CLÁUSULA DÉCIMA TERCERA:</b>  Todos los gastos judiciales o extrajudiciales, incluyendo los gastos de árbitro que se ocasionan por el incumplimiento de “EL REPRESENTANTE”, correrán por su única y exclusiva cuenta de este.</p>
			<br />
			<p><b>CLÁUSULA DÉCIMA CUARTA:</b> Se elige como domicilio especial y único y excluyente de cualquier otro para el cumplimiento de las obligaciones contraídas en este contrato a la ciudad y municipio Valencia es del estado Carabobo a la jurisdicción de cuyos Tribunales nos sometemos.  Firma conforme:</p>
			<br />
			<div class="row">
    			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<p>EL REPRESENTANTE</p>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<p>U.E.C. SAN GABRIEL ARCÁNGEL, C.A.</p>
				</div>
			</div>
			<div class="row">
    			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
					<?= $this->Html->link('Rechazar', ['controller' => 'Users', 'action' => 'home'], ['class' => 'btn btn-default']); ?>
					<br />
				</div>
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
					<?= $this->Html->link('Proceder a la firma', ['controller' => 'Guardiantransactions', 'action' => 'firmaContratoRepresentante', $idRepresentante], ['class' => 'btn btn-success']); ?>
					<br />
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				</div>
			</div>
			<br /><br /><br />
		</div>
    </div>
</div>
