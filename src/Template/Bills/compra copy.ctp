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
		<?php
			echo '<div class="row">';
				echo '<div class="col-md-6">';
					echo $this->Form->input('concepto', ['id' => 'concepto', 'type' => 'text', 'label' => 'Concepto:', 'required' => 'required']);
					echo $this->Form->input('monto', ['id' => 'monto', 'type' => 'number', 'label' => 'Monto:', 'value' => 0, 'step' => 0.01,]);
					echo '<div id="mensaje_monto" class="nover alert alert-danger"></div>';
					echo $this->Form->input('moneda', ['label' => 'Moneda:', 'id' => 'moneda', 'options' => 
					[null => '',
					'1' => 'Bs.',
					'2' => '$',
					'3' => '€']]);
				echo '</div>';
			echo '</div>';
			/*
			echo '<div class="row">';
				echo '<div class="col-md-2">';
					echo $this->Form->input('monto_bolivar', ['id' => 'monto_bolivar', 'type' => 'number', 'label' => 'Bs:', 'value' => 0]);
					echo '<div id="mensaje_monto_bolivar" class="nover alert alert-danger"></div>';
				echo '</div>';
				echo '<div class="col-md-2">';
					echo $this->Form->input('monto_dolar', ['id' => 'monto_dolar', 'type' => 'number', 'label' => '$:', 'value' => 0]);
					echo '<div id="mensaje_monto_dolar" class="nover alert alert-danger"></div>';
				echo '</div>';
				echo '<div class="col-md-2">';
					echo $this->Form->input('monto_dolar', ['id' => 'monto_euro', 'type' => 'number', 'label' => 'euro:', 'value' => 0]);
					echo '<div id="mensaje_monto_euro" class="nover alert alert-danger"></div>';
				echo '</div>';
			echo '<div>';
			*/
		?>
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

	function validar_monto(e)
	{
		$("#guardar").attr('disabled', true);
		$("#mensaje_monto").html("");
		if ($("#mensaje_monto").hasClass("nover") == false)
		{
			$("#mensaje_monto").addClass("nover");
		}	
		if (parseFloat($("#monto").val()) == 0)
		{
			e.preventDefault();
			$("#mensaje_monto").html("Monto inválido");
			$("#mensaje_monto").removeClass("nover");
		}	
		else
		{
			$.each(vector_efectivos, function(indice, valor) 
			{
				if ($("#origen").val() == valor.origen && $("#moneda").val() == valor.orden && parseFloat($("#monto").val()) > valor.monto)
				{
					e.preventDefault();
					$("#mensaje_monto").html("Monto inválido");
					$("#mensaje_monto").removeClass("nover");
				}
			});
		}
		$("#guardar").attr('disabled', false);
	}

	function validar_montos(e)
	{
		$("#guardar").attr('disabled', true);
		$("#mensaje_monto_bolivar").html("");
		if ($("#mensaje_monto_bolivar").hasClass("nover") == false)
		{
			$("#mensaje_monto_bolivar").addClass("nover");
		}		
		$("#mensaje_monto_dolar").html("");
		if ($("#mensaje_monto_dolar").hasClass("nover") == false)
		{
			$("#mensaje_monto_dolar").addClass("nover");
		}
		$("#mensaje_monto_euro").html("");
		if ($("#mensaje_monto_euro").hasClass("nover") == false)
		{
			$("#mensaje_monto_euro").addClass("nover");
		}
		$.each(vector_efectivos, function(indice, valor) 
		{
			if ($("#origen").val() == valor.origen && valor.moneda == "bolivar" && parseFloat($("#monto_bolivar").val()) > valor.monto)
			{
				e.preventDefault();
				$("#mensaje_monto_bolivar").html("Monto inválido");
				$("#mensaje_monto_bolivar").removeClass("nover");
			}
		});
		$.each(vector_efectivos, function(indice, valor) 
		{
			if ($("#origen").val() == valor.origen && valor.moneda == "dolar" && parseFloat($("#monto_dolar").val()) > valor.monto)
			{
				e.preventDefault();
				$("#mensaje_monto_dolar").html("Monto inválido");
				$("#mensaje_monto_dolar").removeClass("nover");
			}
		});
		$.each(vector_efectivos, function(indice, valor) 
		{
			if ($("#origen").val() == valor.origen && valor.moneda == "euro" && parseFloat($("#monto_euro").val()) > valor.monto)
			{
				e.preventDefault();
				$("#mensaje_monto_euro").html("Monto inválido");
				$("#mensaje_monto_euro").removeClass("nover");
			}
		});
		let monto_recibo_dolar = dosDecimales((parseFloat($("#monto_bolivar").val()) / tasa_dolar_bolivar) + parseFloat($("#monto_dolar").val()) + (parseFloat($("#monto_euro").val()) / tasa_dolar_euro));
		$("#monto_recibo_dolar").val(monto_recibo_dolar);
		$("#guardar").attr('disabled', false);
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
			validar_monto(e);       
		});
		$("#concepto").keypress(function(e) 
		{
			if(e.which == 13) 
			{
				validar_monto(e);
			}
		});
		$("#moneda").keypress(function(e) 
		{
			if(e.which == 13) 
			{
				validar_monto(e);
			}
		});
		$("#monto").keypress(function(e) 
		{
			if(e.which == 13) 
			{
				validar_monto(e);
			}
		});
		/*
		$("#monto_bolivar").keypress(function(e) 
		{
			if(e.which == 13) 
			{
				validar_montos(e);
			}
		});
		$("#monto_dolar").keypress(function(e) 
		{
			if(e.which == 13) 
			{
				validar_montos(e);
			}
		});
		$("#monto_euro").keypress(function(e) 
		{
			if(e.which == 13) 
			{
				validar_montos(e);
			}
		});
		*/
	});
</script>