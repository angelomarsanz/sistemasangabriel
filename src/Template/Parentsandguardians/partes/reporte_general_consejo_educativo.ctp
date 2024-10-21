<?php
$idRepresentantePagos = [];
$totalFamiliasExoneradas = 0;
$familiasRelacionadas;
$idFamiliasRelacionadas = [];
$totalFamiliasRelacionadas = 0;
$familiaAnterior = "";
$familiaActual = "";
$contadorFamilias = 0;
$contadorEstudiantes = 0;
$contadorEstudiantesNuevos = 0;
$contadorEstudiantesRegulares = 0;
$contadorEstudiantesBecasCompletas = 0;
$contadorEstudiantesBecasParciales = 0;
$proyeccionCobroFamilias = 0;
$pendientePorPagoFamilias = 0;
$cobradoFamilias = 0;

foreach ($recibosConsejoEducativo as $recibo)
{
    $idRepresentantePagos[$recibo->parentsandguardian_id] = $recibo->bill_number;
}
foreach ($familiasConsejoEducativo as $familia)
{
    if ($familia->parentsandguardian->familias_relacionadas !== null)
    {
        $familiasRelacionadas = json_decode($familia->parentsandguardian->familias_relacionadas);
        foreach ($familiasRelacionadas as $familiaRelacionada)
        {
            $idFamiliasRelacionadas[$familiaRelacionada] = $familiaRelacionada;
        }
    }
}
foreach ($familiasConsejoEducativo as $familia)
{
    $familiaActual = $familia->parentsandguardian->family.$familia->parentsandguardian->id;
    if ($familiaAnterior != $familiaActual): 
        $contadorFamilias++;
    endif;
    $familiaExoneradaVinculada = 0;
    $contadorEstudiantes++;
    if ($familiaAnterior != $familiaActual): 
        if ($familia->parentsandguardian->consejo_exonerado > 0): 
            $totalFamiliasExoneradas++;
            $familiaExoneradaVinculada = 1;
        elseif (isset($idFamiliasRelacionadas[$familia->parentsandguardian->id])): 
            $totalFamiliasRelacionadas++;
            $familiaExoneradaVinculada = 1;
        endif; 
        if ($familiaExoneradaVinculada == 0):
            $proyeccionCobroFamilias += $tarifaConsejoEducativo->amount;
            if (isset($idRepresentantePagos[$familia->parentsandguardian->id])): 
                $cobradoFamilias += $tarifaConsejoEducativo->amount;               
            else:
                $pendientePorPagoFamilias += $tarifaConsejoEducativo->amount;         
            endif;
        endif;
    endif;
    if ($familia->new_student == 0): 
        $contadorEstudiantesRegulares++;
    else: 
        $contadorEstudiantesNuevos++;        
    endif; 
    if ($familia->discount == 100):
        $contadorEstudiantesBecasCompletas++;
    elseif ($familia->discount > 0 && $familia->discount < 100):
        $contadorEstudiantesBecasParciales++;
    endif;
    $familiaAnterior = $familiaActual;
} ?>
<h3 style="text-align:center">Consejo Educativo</h3>
<h4 style="text-align:center">U.E. Colegio San Gabriel Arcángel, C.A.</h4>
<h5 style="text-align:center">Av. Río Orinoco, Urb. Valles del Camoruco, Valencia, Estado Carabobo</h5>
<h6 style="text-align:center">J-40490885-4</h6>
<p>Fecha de emisión del reporte: <?= $fechaActual->format('d-m-Y') ?></p>
<div name="reporteGeneralConsejoEducativo" id="reporteGeneralConsejoEducativo" class="container">
    <h3 style="text-align:center">Consejo Educativo Período <?= $anioEscolar ?></h3>
    <div class="table-responsive"> 
        <table class="table table-striped table-hover">
            <tr>
                <td><b>Familias: </b><?= $this->Number->format($contadorFamilias) ?></td>
                <td><b>Familias exoneradas: </b><?= $this->Number->format($totalFamiliasExoneradas) ?></td>
                <td><b>Familias relacionadas: </b><?= $this->Number->format($totalFamiliasRelacionadas) ?></td>
            </tr>
            <tr>
                <td><b>Estudiantes: </b><?= $this->Number->format($contadorEstudiantes) ?></td>
                <td><b>Estudiantes regulares: </b><?= $this->Number->format($contadorEstudiantesRegulares) ?></td>
                <td><b>Estudiantes nuevos: </b><?= $this->Number->format($contadorEstudiantesNuevos) ?></td>
            </tr>
            <tr>           
                <td><b>Estudiantes con becas completas: </b><?= $this->Number->format($contadorEstudiantesBecasCompletas) ?></td>
                <td><b>Estudiantes con becas parciales: </b><?= $this->Number->format($contadorEstudiantesBecasParciales) ?></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Proyección de cobro familias ($): </b><?= number_format($proyeccionCobroFamilias, 2, ",", ".") ?></td>
                <td><b>Pendiente por pago familias ($): </b><?= number_format($pendientePorPagoFamilias, 2, ",", ".") ?></td>
                <td><b>Cobrado familias ($): </b><?= number_format($cobradoFamilias, 2, ",", ".") ?></td>
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
                <tr>
                    <th style="text-align: center;"></b></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="text-align: right;"><b><?= number_format($proyeccionCobroFamilias, 2, ",", ".") ?></b></th>
                    <th style="text-align: right;"><b><?= number_format($pendientePorPagoFamilias, 2, ",", ".") ?></b></th>
                    <th style="text-align: right;"><b><?= number_format($cobradoFamilias, 2, ",", ".") ?></b></th>
                    <th></th>
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
                    <th style="text-align: right;"><b><?= number_format($proyeccionCobroFamilias, 2, ",", ".") ?></b></th>
                    <th style="text-align: right;"><b><?= number_format($pendientePorPagoFamilias, 2, ",", ".") ?></b></th>
                    <th style="text-align: right;"><b><?= number_format($cobradoFamilias, 2, ",", ".") ?></b></th>
                    <th></th>
				</tr>
			</tfoot>
            <tbody>				
                <?php
                $familiaAnterior = "";
                $familiaActual = "";
                $contadorFamilias = 0;
                $contadorEstudiantes = 0;
                foreach ($familiasConsejoEducativo as $familia): 
                    $familiaExoneradaVinculada = 0;
                    $familiaActual = $familia->parentsandguardian->family.$familia->parentsandguardian->id;
                    if ($familiaAnterior != $familiaActual): 
                        $contadorFamilias++;
                    endif;
                    $contadorEstudiantes++; ?>
                    <tr>
                        <?php
                        if ($familiaAnterior != $familiaActual): ?>
                            <td><?= $contadorFamilias ?></td>
                        <?php
                        else: ?>
                            <td></td>
                        <?php
                        endif; ?>
                        <td><?= $contadorEstudiantes; ?></td>
                        <?php
                        if ($familiaAnterior != $familiaActual): ?>
                            <td>
                                <?= $familia->parentsandguardian->family." (".$familia->parentsandguardian->surname." ".$familia->parentsandguardian->first_name.")" ?>
                            </td>
                        <?php
                        else: ?>
                            <td></td>
                        <?php
                        endif; ?>
                        <td><?= $familia->full_name; ?></td>     
                        <td><?= $familia->section->full_name ?></td>
                        <td>
                            <?php
                            if ($familia->new_student == 0): ?>
                                Regular
                            <?php
                            else: ?>
                                Nuevo
                            <?php
                            endif; ?>
                        </td>
                        <td style="text-align: center">
                            <?= $familia->discount."%" ?>
                        </td>
                        <td style="text-align: center;">
                            <?php 
                            if ($familiaAnterior != $familiaActual): 
                                if (isset($idFamiliasRelacionadas[$familia->parentsandguardian->id])): 
                                    $familiaExoneradaVinculada = 1; ?>
                                    Sí
                                <?php
                                elseif ($familia->parentsandguardian->consejo_exonerado > 0): 
                                    $familiaExoneradaVinculada = 1; ?>
                                    Sí
                                <?php
                                else: ?>
                                    No
                                <?php
                                endif; 
                            endif; ?>
                        </td>
                        <td style="text-align: right;">
                            <?php 
                            if ($familiaAnterior != $familiaActual): 
                                if ($familiaExoneradaVinculada == 0):
                                    echo number_format($tarifaConsejoEducativo->amount, 2, ",", ".");
                                else:
                                    echo '0,00';
                                endif;
                            endif; ?>
                        </td>
                        <td style="text-align: right;">
                            <?php 
                            if ($familiaAnterior != $familiaActual): 
                                if ($familiaExoneradaVinculada == 0):
                                    if (isset($idRepresentantePagos[$familia->parentsandguardian->id])): 
                                        echo "0,00";
                                    else:
                                        echo number_format($tarifaConsejoEducativo->amount, 2, ",", ".");
                                    endif;
                                else:
                                    echo '0,00';
                                endif;
                            endif; ?>
                        </td>
                        <td style="text-align: right;">
                            <?php 
                            if ($familiaAnterior != $familiaActual): 
                                if ($familiaExoneradaVinculada == 0):
                                    if (isset($idRepresentantePagos[$familia->parentsandguardian->id])): 
                                        echo number_format($tarifaConsejoEducativo->amount, 2, ",", ".");
                                    else:
                                        echo "0,00";
                                    endif;
                                else:
                                    echo '0,00';
                                endif;
                            endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php 
                            if ($familiaAnterior != $familiaActual): 
                                if ($familiaExoneradaVinculada == 0):
                                    if (isset($idRepresentantePagos[$familia->parentsandguardian->id])): 
                                        echo $idRepresentantePagos[$familia->parentsandguardian->id];
                                    endif;
                                else:
                                    echo '';
                                endif;
                            endif; ?>
                        </td>
                    </tr>
                    <?php 
                    $familiaAnterior = $familiaActual;
                    endforeach; ?>
            </tbody>
        </table>
    </div>
</div>