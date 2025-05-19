<style>
    .nover 
    {
      display:none
    }
</style>
<div class="row">
    <div class="col-md-6">
		<div class="page-header">
	        <h3>Recibo de compra</h3>
	    </div>
	</div>
</div>
<?= $this->Form->create() ?>
	<fieldset>
		<input type="hidden" name="origen" id="origen" value="Facturas">
		<input type="hidden" name="monto_recibo_dolar" id="monto_recibo_dolar">
		<?php
			echo "<strong>Efectivo disponible de facturas:</strong>";
			echo "<div class='row'>";
			foreach ($vector_efectivos as $efectivo)
			{
				if ($efectivo["origen"] == "Facturas")
				{
					$monto = number_format($efectivo["monto"], 2, ",", ".");
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
					echo "<div class='col-md-2'>";
					echo $this->Form->input('facturas_'.$efectivo["moneda"], ['type' => 'text', 'label' => $moneda, 'value' => $monto, 'disabled' => 'disabled']);
					echo "</div>";
				}
			}
			echo "</div>";
			echo "<strong>Efectivo disponible de Pedidos:</strong>";
			echo "<div class='row'>";
			foreach ($vector_efectivos as $efectivo)
			{
				if ($efectivo["origen"] == "Pedidos")
				{
					$monto = number_format($efectivo["monto"], 2, ",", ".");
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
					echo "<div class='col-md-2'>";
					echo $this->Form->input('pedidos_'.$efectivo["moneda"], ['type' => 'text', 'label' => $moneda, 'value' => $monto, 'disabled' => 'disabled']);
					echo "</div>";
				}
			}
			echo "</div>";
		?>
		<div class="row">
		    <div class="col-md-6">
				<div class="radio">
					<label><input type="radio" name="origen" id="origen_facturas" value="Facturas" checked>Facturas</label>
				</div>
				<div class="radio">
					<label><input type="radio" name="origen" id="origen_pedidos" value="Pedidos">Pedidos</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<?php
					echo $this->Form->input('concepto', ['id' => 'concepto', 'type' => 'text', 'label' => 'Concepto:']);
					echo '<div id="mensaje_concepto" class="nover alert alert-danger"></div>';
					echo $this->Form->input('monto', ['id' => 'monto', 'type' => 'number', 'label' => 'Monto:', 'value' => 0, 'step' => 0.01,]);
					echo '<div id="mensaje_monto" class="nover alert alert-danger"></div>';
					echo $this->Form->input('moneda', ['label' => 'Moneda:', 'id' => 'moneda', 'options' => 
					[null => '',
					'1' => 'Bs.',
					'2' => '$',
					'3' => '€']]);
					echo '<div id="mensaje_moneda" class="nover alert alert-danger"></div>';
				?>
			</div>
		</div>
	</fieldset>
	<div class="row">
		<div class="col-md-4">
			<?= $this->Form->button(__('Guardar'), ['id' => 'guardar', 'class' =>'btn btn-success']) ?>
		</div>
	</div>
<?= $this->Form->end() ?>
<script>
	var vector_efectivos = <?= json_encode($vector_efectivos, JSON_FORCE_OBJECT) ?>;

	function dosDecimales(numero)
	{
		return Number(Math.round(numero+'e'+2)+'e-'+2);
	}

	function validar_campos(e)
	{
		let indicadorError = 0;
		$("#guardar").addClass("nover");
		$("#mensaje_concepto").html("");
		$("#mensaje_monto").html("");
		$("#mensaje_moneda").html("");
		if ($("#mensaje_concepto").hasClass("nover") == false)
		{
			$("#mensaje_concepto").addClass("nover");
		}	
		if ($("#mensaje_monto").hasClass("nover") == false)
		{
			$("#mensaje_monto").addClass("nover");
		}
		if ($("#mensaje_moneda").hasClass("nover") == false)
		{
			$("#mensaje_moneda").addClass("nover");
		}
		if ($("#concepto").val()) == null || ($("#concepto").val()) == '')
		{
			e.preventDefault()
			$("#mensaje_concepto").html("Debe indicar un concepto");
			$("#mensaje_concepto").removeClass("nover");
			$("#guardar").removeClass("nover");
			indicadorError = 1;
		}	
		if (parseFloat($("#monto").val()) == 0)
		{
			e.preventDefault()
			$("#mensaje_monto").html("Monto inválido");
			$("#mensaje_monto").removeClass("nover");
			$("#guardar").removeClass("nover");
			indicadorError = 1;		
		}	
		$.each(vector_efectivos, function(indice, valor) 
		{
			if ($("#origen").val() == valor.origen && $("#moneda").val() == valor.orden && parseFloat($("#monto").val()) > valor.monto)
			{
				e.preventDefault()
				$("#mensaje_monto").html("Monto inválido");
				$("#mensaje_monto").removeClass("nover");
				$("#guardar").removeClass("nover");
				indicadorError = 1;
				break;
			}
		});
		
		if (indicadorError == 1)
		{
			e.preventDefault()
			$("#guardar").removeClass("nover");
		}
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
        $('#guardar').on("click", function(e) 
		{  
			validar_campos(e);       
		});
		$("#concepto").keypress(function(e) 
		{
			if(e.which == 13) 
			{
				validar_campos(e);
			}
		});
		$("#moneda").keypress(function(e) 
		{
			if(e.which == 13) 
			{
				validar_campos(e);
			}
		});
		$("#monto").keypress(function(e) 
		{
			if(e.which == 13) 
			{
				validar_campos(e);
			}
		});
	});
</script>