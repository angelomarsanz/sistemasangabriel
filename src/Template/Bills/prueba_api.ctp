<style>
    .nover 
    {
      display:none
    }
</style>
<div class="row">
    <div class="col-md-6">
		<div class="page-header">
	        <h3>Prueba API</h3>
	    </div>
	</div>
</div>
<?= $this->Form->create() ?>
	<fieldset>
		<?php
			echo '<div class="row">';
				echo '<div class="col-md-6">';
					echo $this->Form->input('concepto', ['id' => 'concepto', 'type' => 'text', 'label' => 'Concepto:']);
				echo '</div>';
			echo '</div>';
		?>
	</fieldset>
	<div class="row">
		<div class="col-md-4">
			<?= $this->Form->button(__('Guardar'), ['id' => 'guardar', 'class' =>'btn btn-success']) ?>
		</div>
	</div>
<?= $this->Form->end() ?>
<script>
    $(document).ready(function() 
    {

	});
</script>