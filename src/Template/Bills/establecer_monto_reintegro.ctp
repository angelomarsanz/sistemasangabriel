<style>
    .nover 
    {
      display:none
    }
</style>
<div class="row">
    <div class="col-md-4">
		<div class="page-header">
	        <h3>Establecer el monto a reintegrar al representante</h3>
	    </div>
	</div>
</div>
<?= $this->Form->create() ?>
	<fieldset>
		<input type="hidden" name="origen" id="origen" value="Facturas">
		<?php
			echo "<div class='row'>";
			foreach ($vector_efectivos as $efectivo)
			{
				if ($efectivo["origen"] == "Facturas" && $efectivo["moneda"] == "dolar")
				{
					$monto_efectivo = number_format($efectivo["monto"], 2, ",", ".");
					if ($efectivo["moneda"] == "bolivar")
					{
						$moneda = "Bs.";
					}
					elseif ($efectivo["moneda"] == "dolar")
					{
						$moneda = "$";
					}
					else
					{
						$moneda = "€";
					}
					echo "<div class='col-md-4'>";
					echo $this->Form->input('facturas_'.$efectivo["moneda"], ['type' => 'text', 'label' => 'Efectivo disponible de facturas ($)', 'value' => $monto_efectivo, 'disabled' => 'disabled']);
					echo "</div>";
				}
			}
			echo "</div>";
			echo "<div class='row'>";
			foreach ($vector_efectivos as $efectivo)
			{
				if ($efectivo["origen"] == "Pedidos" && $efectivo["moneda"] == "dolar")
				{
					$monto_efectivo = number_format($efectivo["monto"], 2, ",", ".");
					if ($efectivo["moneda"] == "bolivar")
					{
						$moneda = "Bs.";
					}
					elseif ($efectivo["moneda"] == "dolar")
					{
						$moneda = "$";
					}
					else
					{
						$moneda = "€";
					}
					echo "<div class='col-md-4'>";
					echo $this->Form->input('pedidos_'.$efectivo["moneda"], ['type' => 'text', 'label' => 'Efectivo disponible de pedidos ($)', 'value' => $monto_efectivo, 'disabled' => 'disabled']);
					echo "</div>";
				}
			}
			echo "</div>";
		?>
		<div class="row">
			<div class="col-md-4">
				<div class="radio">
					<label><input type="radio" name="origen" id="origen_facturas" value="Facturas" checked>Facturas</label>
				</div>
				<div class="radio">
					<label><input type="radio" name="origen" id="origen_pedidos" value="Pedidos">Pedidos</label>
				</div>
			</div>
		</div>
		<div class="row">
    		<div class="col-md-4">
				<?php
					echo $this->Form->input('monto_reintegro', ['type' => 'number', 'label' => 'Por favor indique el monto en dólares a reintegrar', 'value' => $monto, 'step' => 0.01]);
					echo '<div id="mensaje_monto" class="nover alert alert-danger"></div>';
				?>
			</div>
		</div>
	</fieldset>
	<?= $this->Form->button(__('Reintegrar'), ['id' => 'reintegrar', 'class' =>'btn btn-success']) ?>
<?= $this->Form->end() ?>
<br />
<script>
	var	montoMaximoReintegro = <?= $monto ?>;
	var vector_efectivos = <?= json_encode($vector_efectivos, JSON_FORCE_OBJECT) ?>;
	function validar_monto(e)
	{
		$("#reintegrar").attr('disabled', true);
		$("#mensaje_monto").html("");
		if ($("#mensaje_monto").hasClass("nover") == false)
		{
			$("#mensaje_monto").addClass("nover");
		}	

		if (parseFloat($("#monto-reintegro").val()) <= 0)
		{
			e.preventDefault();
			$("#mensaje_monto").html("Monto inválido");
			$("#mensaje_monto").removeClass("nover");
		}	
		else if ($("#monto-reintegro").val() > montoMaximoReintegro)
		{    
			e.preventDefault();
			$("#mensaje_monto").html("Monto inválido");
			$("#mensaje_monto").removeClass("nover");
		}
		else
		{
			$.each(vector_efectivos, function(indice, valor) 
			{
				if ($("#origen").val() == valor.origen && valor.orden == 2 && parseFloat($("#monto-reintegro").val()) > valor.monto)
				{
					e.preventDefault();
					$("#mensaje_monto").html("Monto inválido");
					$("#mensaje_monto").removeClass("nover");
				}
			});
		}

		$("#reintegrar").attr('disabled', false);
	}
    $(document).ready(function() 
    {
		$('#origen_facturas').on("click", function(e) 
		{  
			$("#origen").val('Facturas');
		});
		$('#origen_pedidos').on("click", function(e) 
		{  
			$("#origen").val('Pedidos');
		});	
        $('#reintegrar').click(function(e) 
		{            
			validar_monto(e);			
		});
	});
</script>