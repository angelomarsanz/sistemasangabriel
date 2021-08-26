<style>
@media screen
{
    .noverScreen
    {
      display:none
    }
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
			<p>
				<?php 
					if ($idFamilia != null):
						$this->Html->link(__('Volver'), ['controller' => $retornoControlador, 'action' => $retornoAccion, $idFamilia, $familia], ['class' => 'btn btn-sm btn-default']);
					else:
						$this->Html->link(__('Volver'), ['controller' => $retornoControlador, 'action' => $retornoAccion], ['class' => 'btn btn-sm btn-default']);
					endif;
				?>
			</p>
			<h3>Crear nota contable</h3>
			<table style="width:100%">
				<tbody>
					<tr>
						<td style='width:80%;'>Cliente: <?= $facturaConceptos->client ?></td>
						<td style="width:20%; text-align: right;"><b>Factura Nro. <?= $facturaConceptos->bill_number ?></b></td>
					</tr>
					<tr>
						<td style='width:80%;'>C.I./RIF: <?= $facturaConceptos->identification ?></td>
						<td style="width:20%; text-align: right;">Fecha: <?= $facturaConceptos->date_and_time->format('d-m-Y') ?></td>
					</tr>
					<tr>
						<td style='width:80%;'>Teléfono: <?= $facturaConceptos->tax_phone ?></td>
						<td style="width:20%; text-align: right;"><?= $facturaConceptos->school_year ?></td>
					</tr>
					<tr>
						<td style='width:80%;'>Dirección: <spam style="font-size: 9px; line-height: 11px;"><?= $facturaConceptos->fiscal_address ?></spam></td>
						<td style='width:20%;'></td>
					</tr>
				</tbody>
			</table>	
		<div>
		<br />
		<?= $this->Form->create() ?>
			<fieldset>
				<div class="row">
					<div class="col-md-4">
						<?php
							echo $this->Form->input('tipo_nota', ['required' => 'required', 'label' => 'Tipo de nota', 'options' => 
								[null => '',
								'Crédito' => 'Crédito',
								'Débito' => 'Débito']]);
						?>
					</div>
					<div class="col-md-4">
						<?= 'Tasa de cambio factura original: <b>' . number_format($facturaConceptos->tasa_cambio, 2, ",", ".") . '</b>'?>
					</div>
					<div class="col-md-4">
						<?= 'Tasa de cambio actual: <b>' . number_format($dollarExchangeRate, 2, ",", ".") . '</b>'?>
					</div>									
				</div>
				<div class="row">
					<div class="col-md-12">								
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th style="width: 20%;">Alumno</th>
										<th style="width: 10%;">Concepto</th>
										<th style="width: 10%;">Mto. Fact($)</th>
										<th style="width: 10%;">Mto. Fact(Bs.)</th>
										<th style="width: 10%;">Saldo($)</th>
										<th style="width: 10%;">Monto nota($)</th>
										<th style="width: 10%;">Monto nota(Bs.)</th>
										<th style="width: 0%;" class="noverScreen">Monto oculto(Bs.)</th>
										<th style="width: 20%;"></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($facturaConceptos->concepts as $concepto): ?>
										<tr>
											<td style="width: 20%;"><input disabled='true' class='form-control' value="<?= $concepto->student_name ?>"></td>
											<td style="width: 10%;"><input disabled='true' class='form-control' value="<?= $concepto->concept ?>"></td>
											<td style="width: 10%;"><input id=<?= "MD-" . $concepto->id ?> name="montosConcepto[<?= $concepto->id ?>]" class='form-control' disabled='true' value=<?= number_format(round($concepto->amount/$facturaConceptos->tasa_cambio), 2, ",", ".") ?>></td>
											<td style="width: 10%;"><input id=<?= "MF-" . $concepto->id ?> name="montosConcepto[<?= $concepto->id ?>]" class='form-control' disabled='true' value=<?= number_format($concepto->amount, 2, ",", ".") ?>></td>
											<td style="width: 10%;"><input id=<?= "SC-" . $concepto->id ?> name="montosConcepto[<?= $concepto->id ?>]" class='form-control' disabled='true' value=<?= number_format($concepto->saldo, 2, ",", ".") ?>></td>
											<td style="width: 10%;"><input id=<?= "ND-" . $concepto->id ?> name="montosNotaDolar[<?= $concepto->id ?>]" class='form-control alternative-decimal-separator monto-nota' value=0></td>
											<td style="width: 10%;"><input id=<?= "NV-" . $concepto->id ?> name="montosNotaVisible[<?= $concepto->id ?>]" class='form-control alternative-decimal-separator' value=0 disabled='true'></td>
											<td style="width: 10%;"><input id=<?= "MN-" . $concepto->id ?> name="montosNotaContable[<?= $concepto->id ?>]" class='form-control alternative-decimal-separator noverScreen' value=0></td>
											<td style="width: 20%;" id=<?= "MENSAJE-" . $concepto->id ?> class="mensajes-usuario"></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>	
			</fieldset>
			<?= $this->Form->button(__('Crear nota contable'), ['id' => 'crear-nota', 'class' =>'btn btn-success']) ?>
		<?= $this->Form->end() ?>
		<div class="row">
			<div class="col-md-12">
				<h3>Notas creadas anteriormente para esta factura</h3>			
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Nro.</th>
								<th>Control</th>
								<th>Tipo</th>
								<th>Monto</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($notasAnteriores as $anterior): ?>
								<tr>
									<td><?= $anterior->date_and_time->format('d-m-Y') ?></td>
									<td><?= $anterior->bill_number ?></td>
									<td><?= $anterior->control_number ?></td>
									<td><?= $anterior->tipo_documento ?></td>
									<td><?= number_format($anterior->amount_paid, 2, ",", ".") ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
    </div>
</div>
<script>
	var tasaCambio = <?= $dollarExchangeRate; ?>;

	function dosDecimales(numero)
	{
		var original = parseFloat(numero);
		var result = Math.round(original * 100) / 100 ;
		return result;
	}
	
	function formatoNumero(num) 
	{
		if (!num || num == 'NaN') return '0,00';
		if (num == 'Infinity') return '&#x221e;';
		num = num.toString().replace(/\$|\,/g, '');
		if (isNaN(num))
			num = "0";
		sign = (num == (num = Math.abs(num)));
		num = Math.floor(num * 100 + 0.50000000001);
		cents = num % 100;
		num = Math.floor(num / 100).toString();
		if (cents < 10)
			cents = "0" + cents;
		for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3) ; i++)
			num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
		return (((sign) ? '' : '-') + num + ',' + cents);
	}
	
    $(document).ready(function()
    {
    	$(".alternative-decimal-separator").numeric({ altDecimal: "," });
		
		mesActual = <?= $mesActual ?>;
		mesFactura = <?= $mesFactura ?>;
		
		$('.monto-nota').change(function(e)
		{
			$(".monto-nota").each(function (index) 
			{			
				montoNotaCadena = $(this).val();
				
				if (montoNotaCadena.substr(-3, 1) == ',')
				{
					montoNotaSinPuntos = montoNotaCadena.replace(".", "");
					montoNotaSinComa = montoNotaSinPuntos.replace(",", ".");
					montoNotaNumerico = parseFloat(montoNotaSinComa);
				}
				else
				{
					montoNotaNumerico = parseFloat(montoNotaCadena);			
				}
				
				$('#NV-' + $(this).attr('id').substring(3)).val(formatoNumero(dosDecimales(montoNotaNumerico * tasaCambio)));
				$('#MN-' + $(this).attr('id').substring(3)).val(formatoNumero(dosDecimales(montoNotaNumerico * tasaCambio)));
			});
		});
				
		$('#crear-nota').click(function(e) 
        {
			acumuladoFactura = 0;
			acumuladoNota = 0;
			indicadorError = 0;
				
			$('.mensajes-usuario').html("");
			
			$(".monto-nota").each(function (index) 
			{			
				montoFacturaCadena = $('#SC-' + $(this).attr('id').substring(3)).val();
				montoFacturaSinPuntos = montoFacturaCadena.replace(".", "");
				montoFacturaSinComa = montoFacturaSinPuntos.replace(",", ".");
				montoFacturaNumerico = parseFloat(montoFacturaSinComa);
				acumuladoFactura += montoFacturaNumerico;
				
				montoNotaCadena = $(this).val();
				
				if (montoNotaCadena.substr(-3, 1) == ',')
				{
					montoNotaSinPuntos = montoNotaCadena.replace(".", "");
					montoNotaSinComa = montoNotaSinPuntos.replace(",", ".");
					montoNotaNumerico = parseFloat(montoNotaSinComa);
				}
				else
				{
					montoNotaNumerico = parseFloat(montoNotaCadena);			
				}
						
				acumuladoNota += montoNotaNumerico;
								
				if (montoNotaNumerico > montoFacturaNumerico)
				{
					if ($("#tipo-nota").val() == "Crédito")
					{
						indicadorError = 1;					
						$(this).css('background-color', "#ffffe6");
						$("#MENSAJE-" + $(this).attr('id').substring(3)).html("El monto del concepto de la nota contable no puede ser mayor al saldo").css('color', 'red');

					}
				}
			});
					
			if (indicadorError > 0)
			{
				alert("Estimado usuario uno o más datos contienen errores, por favor verifique");
				e.preventDefault();
			}
			/* else if (acumuladoNota == acumuladoFactura)
			{
				if (mesActual == mesFactura)
				{
					alert('No se puede hacer una nota contable "TOTAL", porque la factura es de este mes');
					e.preventDefault();
				}
			} */
			else if (acumuladoNota == 0)
			{
				alert('No se puede emitir una nota contable con monto igual a cero');
				e.preventDefault();
			}	
		});
		
		$('.monto-nota').keypress(function(e) 
        {
            if (e.which == 13)
            {
				e.preventDefault();
            }
        });    
	});
</script>