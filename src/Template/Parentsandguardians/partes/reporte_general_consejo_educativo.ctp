<div name="reporteGeneralConsejoEducativo" id="reporteGeneralConsejoEducativo" class="container">
    <h3 style="text-align:center">Consejo Educativo Período <?= $anioEscolar ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <tr>
                <td><b>Familias: </b><?= $this->Number->format($resumen['contadorFamilias']) ?></td>
                <td><b>Familias exoneradas: </b><?= $this->Number->format($resumen['totalFamiliasExoneradas']) ?></td>
                <td><b>Familias relacionadas: </b><?= $this->Number->format($resumen['totalFamiliasRelacionadas']) ?></td>
            </tr>
            <tr>
                <td><b>Estudiantes: </b><?= $this->Number->format($resumen['contadorEstudiantes']) ?></td>
                <td><b>Estudiantes regulares: </b><?= $this->Number->format($resumen['contadorEstudiantesRegulares']) ?></td>
                <td><b>Estudiantes nuevos (<?= $anioEscolar ?>): </b><?= $this->Number->format($resumen['contadorEstudiantesNuevos']) ?></td>
            </tr>
            <tr>
                <td><b>Estudiantes egresados, retirados, etc: </b><?= $this->Number->format($resumen['contadorOtrosEstudiantes']) ?></td>
                <td><b>Estudiantes con becas completas: </b><?= $this->Number->format($resumen['contadorEstudiantesBecasCompletas']) ?></td>
                <td><b>Estudiantes con becas parciales: </b><?= $this->Number->format($resumen['contadorEstudiantesBecasParciales']) ?></td>
            </tr>
            <tr>
                <td><b>Proyección de cobro familias ($): </b><?= number_format($resumen['proyeccionCobroFamilias'], 2, ",", ".") ?></td>
                <td><b>Pendiente por pago familias ($): </b><?= number_format($resumen['pendientePorPagoFamilias'], 2, ",", ".") ?></td>
                <td><b>Cobrado familias ($): </b><?= number_format($resumen['cobradoFamilias'], 2, ",", ".") ?></td>
            </tr>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th style="text-align: center;"><b>Nro. Flia</b></th>
                    <th style="text-align: center;"><b>Nro. Estud.</b></th>
                    <th style="text-align: center;"><b>Familia</b></th>
                    <th style="text-align: center;"><b>Estudiante</b></th>
                    <th style="text-align: center;"><b>Grado</b></th>
                    <th style="text-align: center;"><b>Estatus</b></th>
                    <th style="text-align: center;"><b>Beca</b></th>
                    <th style="text-align: center;"><b>Flia Exon. + Relac.</b></th>
                    <th style="text-align: center;"><b>Cuota Única ($)</b></th>
                    <th style="text-align: center;"><b>Pend. por Cobrar ($)</b></th>
                    <th style="text-align: center;"><b>Cobrado ($)</b></th>
                    <th style="text-align: center;"><b>Nro. Recibo</b></th>
                </tr>
            </thead>
            <tfoot>
				<tr>
                    <th style="text-align: center;"><b>Totales</b></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="text-align: right;"><b><?= number_format($resumen['proyeccionCobroFamilias'], 2, ",", ".") ?></b></th>
                    <th style="text-align: right;"><b><?= number_format($resumen['pendientePorPagoFamilias'], 2, ",", ".") ?></b></th>
                    <th style="text-align: right;"><b><?= number_format($resumen['cobradoFamilias'], 2, ",", ".") ?></b></th>
                    <th></th>
				</tr>
			</tfoot>
            <tbody>
                <?php
                $familiaAnteriorId = "";
                $contadorFamiliasRel = 0;
                $contadorEstudiantesRel = 0;
                foreach ($listaEstudiantes as $item):
                    $estudiante = $item['student'];
                    $representante = $item['representative'];
                    $section = $item['section'];
                    $familiaCE = $item['familiaCE'];

                    if ($familiaAnteriorId != $representante->id):
                        $contadorFamiliasRel++;
                    endif;
                    $contadorEstudiantesRel++; ?>
                    <tr>
                        <td style="text-align: center;"><?= ($familiaAnteriorId != $representante->id) ? $contadorFamiliasRel : "" ?></td>
                        <td style="text-align: center;"><?= $contadorEstudiantesRel; ?></td>
                        <td>
                            <?= ($familiaAnteriorId != $representante->id) ? $representante->family . " (" . $representante->surname . " " . $representante->first_name . ")" : "" ?>
                        </td>
                        <td><?= $estudiante->full_name; ?></td>
                        <td><?= $section->full_name ?></td>
                        <td style="text-align: center;">
                            <?= ($estudiante->number_of_brothers == $anioEscolarRequerido) ? "Nuevo" : $estudiante->student_condition ?>
                        </td>
                        <td style="text-align: center">
                            <?= $estudiante->discount."%" ?>
                        </td>
                        <td style="text-align: center;">
                            <?= ($familiaAnteriorId != $representante->id) ? ($familiaCE['exoneradaORelacionada'] ? "Sí" : "No") : "" ?>
                        </td>
                        <td style="text-align: right;">
                            <?= ($familiaAnteriorId != $representante->id) ? number_format($resumen['tarifaConsejo'], 2, ",", ".") : "" ?>
                        </td>
                        <td style="text-align: right;">
                            <?= ($familiaAnteriorId != $representante->id) ? number_format($familiaCE['saldo'], 2, ",", ".") : "" ?>
                        </td>
                        <td style="text-align: right;">
                            <?= ($familiaAnteriorId != $representante->id) ? number_format($familiaCE['pagado'], 2, ",", ".") : "" ?>
                        </td>
                        <td style="text-align: center;">
                            <?= ($familiaAnteriorId != $representante->id) ? (is_array($familiaCE['nroRecibo']) ? implode(", ", $familiaCE['nroRecibo']) : $familiaCE['nroRecibo']) : "" ?>
                        </td>
                    </tr>
                    <?php
                    $familiaAnteriorId = $representante->id;
                    endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
