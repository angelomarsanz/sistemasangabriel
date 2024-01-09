<div class="row">
    <div class="col-md-12">
    	<div class="page-header">
            <h3><?= $titulo_reporte ?></h3>
            <p><?= $titulo_total.": ".$contador_seleccionados ?></p>
            <p><?= $titulo_reporte.": ".$contador_impresion ?></p>
            <p><?php echo "Porcentaje: ".number_format(round(($contador_impresion/$contador_seleccionados)*100, 2), 2, ",", ".")."%"; ?></p>
        </div>
        <div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="text-align:left;">Nro.</th>
                        <th style="text-align:left;">Familia</th>
                        <th style="text-align:left;">Representante</th>
                        <th style="text-align:left;">ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador_linea = 1;
                    foreach ($vector_representantes as $indice => $valor): 
                        if ($valor["impresion"] == 1): ?>
                            <tr>
                                <td style="text-align:left;"><?= $contador_linea ?></td>
                                <td style="text-align:left;"><?= $valor["familia"] ?></td>
                                <td style="text-align:left;"><?= $valor["representante"] ?></td>
                                <td style="text-align:left;"><?= $indice ?></td>
                            </tr>
                            <?php
                            $contador_linea++;
                        endif;
                    endforeach; ?>
                </tbody>
			<table>
        <div>
    </div>
</div>