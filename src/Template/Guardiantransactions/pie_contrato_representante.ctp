<div class="noVerImpreso">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<p>EL REPRESENTANTE</p>
			<?php
			if ($indicadorContratoFirmado == 1):
				echo $this->Html->image('../files/contratos/'.$anioContratoFirmado.'/'.$imagenFirma, ['width' => "70%"]);
			endif; ?>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<p>U.E.C. SAN GABRIEL ARCÁNGEL, C.A.</p>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<?php
			if ($controlador == null && $accion == null)
			{ 
				echo $this->Html->link('Proceder a la firma', ['controller' => 'Guardiantransactions', 'action' => 'firmaContratoRepresentante', $representante->id, $anioFirmarContrato], ['class' => 'btn btn-success']); 
			}
			elseif ($controlador == "Users" && $accion == "home")
			{
				echo $this->Html->link('Proceder a la firma', ['controller' => 'Guardiantransactions', 'action' => 'firmaContratoRepresentante', $representante->id, $anioFirmarContrato], ['class' => 'btn btn-success']); 
			}
			else
			{
				echo $this->Html->link('Regresar', ['controller' => $controlador, 'action' => $accion], ['class' => 'btn btn-success']); 
			} ?>
			<br />
		</div>
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
		</div>
	</div>
</div>
<div class="noVerPantalla">
	<div style="width: 100%;">
		<div style="width: 50%; float: left;">
			<p>EL REPRESENTANTE</p>
			<?php
			if ($representante->datos_contrato != null):
				$datos_contrato = json_decode($representante->datos_contrato, true); 
				echo $this->Html->image('../files/contratos/'.$datos_contrato['imagen_firma'], ['width' => '70%']);
			endif; ?>
		</div>
		<div style="width: 50%; float: left;">
			<p>U.E.C. SAN GABRIEL ARCÁNGEL, C.A.</p>
		</div>
	</div>
</div>