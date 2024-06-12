<h3>Reporte de Familias Exoneradas Correspondiente al Período Escolar <?= $anioEscolar ?></h3>
<p>Fecha de emisión del reporte: <?= $fechaActual->format('d-m-Y') ?></p>
<div name="reporteFamiliasExoneradas" id="reporteFamiliasExoneradas" class="container">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th><b>Nro. Familia</b></th>
                    <th><b>Nro. Estudiante</b></th>
                    <th><b>Familia</b></th>
                    <th><b>Estudiante</b></th>
                    <th><b>Grado</b></th>
                    <th><b>Beca (%)</b></th>
                </tr>
            </thead>
            <tbody>				
                <?php
                $familiaAnterior = "";
                $familiaActual = "";
                $contadorFamilias = 0;
                $contadorEstudiantes = 0;
                foreach ($familiasExoneradas as $familia): 
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
                        <td><?= $familia->discount ?></td>
                    </tr>
                    <?php 
                    $familiaAnterior = $familiaActual;
                    endforeach; ?>
            </tbody>
        </table>
    </div>
</div>