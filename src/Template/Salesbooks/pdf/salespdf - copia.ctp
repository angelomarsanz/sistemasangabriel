<?= $this->Dompdf->css('bootstrap.min') ?>
<div class="header" style="top: -40px; width: 100%;">
    <div style="float: left; width:10%;">
        <p><?= $this->Dompdf->image('../files/schools/profile_photo/' . $school->get('profile_photo_dir') . '/'. $school->get('profile_photo'), ['width' => 200, 'height' => 200, 'class' => 'img-thumbnail img-responsive']) ?></p>
    </div>
    <div style="float: left; width: 90%;">
        <h1><?= $school->name ?></h1>
        <h2>RIF <?= $school->rif ?></h2>
        <h2><?= "Período: Desde el: " . $firstDayMonth . " Hasta el: " . $lastDayMonth ?></h2>
        <h1 style="text-align: center;"><b>LIBRO DE VENTAS <?= strtoupper($spanishMonth) . ' ' . $year ?></b></h1>
    </div>
</div>
<div style="clear: both; width: 100%;">
	<table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Tipo de Doc.</th>
                <th scope="col">Cédula/Rif</th>
                <th scope="col">Nombre y Apellido, y/o Razón o Denominación Social</th>
                <th scope="col">Nro. Factura</th>
                <th scope="col">Nro. Control</th>
                <th scope="col">Nro. Nota Débito</th>
                <th scope="col">Nro. Nota Crédito</th>
                <th scope="col">Nro. Factura Afectada</th>
                <th scope="col" style="text-align: right;">Total Ventas Más Inpuesto</th>
                <th scope="col" style="text-align: right;">Ventas Exoneradas o no Sujetas</th>
                <th scope="col" style="text-align: right;">Base</th>
                <th scope="col" style="text-align: right;">Alic. 12%</th>
                <th scope="col" style="text-align: right;">IVA</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $accountantRecords = 0; 
                $lineCounter = 0;
                $totalVentasMasImpuestoVan = 0;
                $ventasExoneradasVan = 0;
                $totalVentasMasImpuestoYesterday = 0;
                $ventasExoneradasYesterday = 0;
            ?>
            <?php foreach ($sales as $sale): ?>
                <?php if ($accountantRecords < 10000): ?>
                    <?php 
                        if ($accountantRecords == 0): 
                            $yesterdaySales = $sale->fecha;
                        endif; 
                    ?>
                    <?php if ($accountantRecords > 0 && $lineCounter == 31): ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Van...</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right;"><?= h(number_format($totalVentasMasImpuestoVan, 2, ",", ".")) ?></td>
                            <td style="text-align: right;"><?= h(number_format($ventasExoneradasVan, 2, ",", ".")) ?></td>
                            <td style="text-align: right;">0,00</td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;">0,00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Vienen...</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right;"><?= h(number_format($totalVentasMasImpuestoVan, 2, ",", ".")) ?></td>
                            <td style="text-align: right;"><?= h(number_format($ventasExoneradasVan, 2, ",", ".")) ?></td>
                            <td style="text-align: right;">0,00</td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;">0,00</td>
                        </tr>
                        <?php $lineCounter = 1; ?>
                    <?php endif; ?>
                    
                    <?php if ($sale->fecha > $yesterdaySales): ?>
                        <tr>
                            <td><b><?= $yesterdaySales->format('d-m-Y') ?></b></td>
                            <td></td>
                            <td></td>
                            <td><b>Total ventas del día <?= $yesterdaySales->format('d-m-Y') ?></b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right;"><?= h(number_format($totalVentasMasImpuestoYesterday, 2, ",", ".")) ?></td>
                            <td style="text-align: right;"><?= h(number_format($ventasExoneradasYesterday, 2, ",", ".")) ?></td>
                            <td style="text-align: right;">0,00</td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;">0,00</td>
                        </tr>
                        <?php
                            $yesterdaySales = $sale->fecha;
                            $totalVentasMasImpuestoYesterday = 0;
                            $ventasExoneradasYesterday = 0;  
                            $lineCounter++;                           
                        ?>
                    <?php endif; ?>
                    
                    <?php if ($accountantRecords > 0 && $lineCounter == 31): ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Van...</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right;"><?= h(number_format($totalVentasMasImpuestoVan, 2, ",", ".")) ?></td>
                            <td style="text-align: right;"><?= h(number_format($ventasExoneradasVan, 2, ",", ".")) ?></td>
                            <td style="text-align: right;">0,00</td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;">0,00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Vienen...</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right;"><?= h(number_format($totalVentasMasImpuestoVan, 2, ",", ".")) ?></td>
                            <td style="text-align: right;"><?= h(number_format($ventasExoneradasVan, 2, ",", ".")) ?></td>
                            <td style="text-align: right;">0,00</td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;">0,00</td>
                        </tr>
                        <?php $lineCounter = 1; ?>
                    <?php endif; ?>

                    <tr>
                        <td><?= h($sale->fecha->format('d-m-Y')) ?></td>
                        <td><?= h($sale->tipo_documento) ?></td>
                        <td><?= h($sale->cedula_rif) ?></td>
                        <td><?= h($sale->nombre_razon_social) ?></td>
                        <td><?= h($sale->numero_factura) ?></td>
                        <td><?= h($sale->numero_control) ?></td>
                        <td><?= h($sale->nota_debito) ?></td>
                        <td><?= h($sale->nota_credito) ?></td>
                        <td><?= h($sale->factura_afectada) ?></td>
                        <td style="text-align: right;"><?= h(number_format($sale->total_ventas_mas_impuesto, 2, ",", ".")) ?></td>
                        <td style="text-align: right;"><?= h(number_format($sale->ventas_exoneradas, 2, ",", ".")) ?></td>
                        <td style="text-align: right;"><?= h($sale->base) ?></td>
                        <td style="text-align: right;"><?= h($sale->alicuota) ?></td>
                        <td style="text-align: right;"><?= h($sale->iva) ?></td>
                    </tr>
                    <?php 
                        $accountantRecords++; 
                        $lineCounter++;
                        $totalVentasMasImpuestoVan += $sale->total_ventas_mas_impuesto;
                        $ventasExoneradasVan += $sale->ventas_exoneradas;
                        $totalVentasMasImpuestoYesterday += $sale->total_ventas_mas_impuesto;
                        $ventasExoneradasYesterday += $sale->ventas_exoneradas;
                    ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <tr>
                <td><b><?= $yesterdaySales->format('d-m-Y') ?></b></td>
                <td></td>
                <td></td>
                <td><b>Total ventas del día <?= $yesterdaySales->format('d-m-Y') ?></b></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right;"><?= h(number_format($totalVentasMasImpuestoYesterday, 2, ",", ".")) ?></td>
                <td style="text-align: right;"><?= h(number_format($ventasExoneradasYesterday, 2, ",", ".")) ?></td>
                <td style="text-align: right;">0,00</td>
                <td style="text-align: right;"></td>
                <td style="text-align: right;">0,00</td>
            </tr>
            <?php $lineCounter++; ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><b>Total...</b></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right;"><b><?= h(number_format($totalVentasMasImpuestoVan, 2, ",", ".")) ?></b></td>
                <td style="text-align: right;"><b><?= h(number_format($ventasExoneradasVan, 2, ",", ".")) ?></b></td>
                <td style="text-align: right;"><b>0,00</b></td>
                <td style="text-align: right;"></td>
                <td style="text-align: right;"><b>0,00</b></td>
            </tr>
            <?php $lineCounter++; ?>
        </tbody>
    </table>
</div>
<?php if ($lineCounter > 20): ?>
    <?= $this->Dompdf->page_break() ?>
<?php endif; ?>
<div style="clear: both; width: 100%;">
    <table class="table table-striped table-hover" style="width: 50%">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col" style="text-align: right;"></th>
                <th scope="col" style="text-align: right;">Base Imponible</th>
                <th scope="col" style="text-align: right;"></th>
                <th scope="col" style="text-align: right;">Débito Fiscal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Ventas Internas No Grabadas</td>
                <td style="text-align: right;">40</td>
                <td style="text-align: right;"><?= h(number_format($ventasExoneradasVan, 2, ",", ".")) ?></td>
                <td style="text-align: right;"></td>
                <td style="text-align: right;"></td>
            </tr>
            <tr>
                <td>Ventas de Exportación</td>
                <td style="text-align: right;">41</td>
                <td style="text-align: right;"></td>
                <td style="text-align: right;"></td>
                <td style="text-align: right;"></td>
            </tr>
            <tr>
                <td>Ventas Internas Grabadas por Alicuota General</td>
                <td style="text-align: right;">42</td>
                <td style="text-align: right;">0,00</td>
                <td style="text-align: right;">43</td>
                <td style="text-align: right;">0,00</td>
            </tr>
            <tr>
                <td>Ventas Internas Grabadas por Alicuota General Más Alicuota Adicional</td>
                <td style="text-align: right;">442</td>
                <td style="text-align: right;"></td>
                <td style="text-align: right;">452</td>
                <td style="text-align: right;"></td>
            </tr>
            <tr>
                <td>Ventas Internas Grabadas por Alicuota Reducida</td>
                <td style="text-align: right;">443</td>
                <td style="text-align: right;"></td>
                <td style="text-align: right;">453</td>
                <td style="text-align: right;"></td>
            </tr>
            <tr>
                <td>Total Ventas y Débitos Fiscales de Determinación</td>
                <td style="text-align: right;">46</td>
                <td style="text-align: right;"><?= h(number_format($ventasExoneradasVan, 2, ",", ".")) ?></td>
                <td style="text-align: right;"></td>
                <td style="text-align: right;">0,00</td>
            </tr>
        </tbody>
    </table>
</div>