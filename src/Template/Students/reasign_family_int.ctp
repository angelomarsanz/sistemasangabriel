<?php
	use Cake\Routing\Router;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h3><?= 'Reasignar familia a: ' . $student->full_name ?></h3>
        </div>
        <?= $this->Form->create($student) ?>
            <fieldset>
                <div class="row panel panel-default">
                    <div class="col-md-12">
                        <br />
                        <?php
							echo $this->Form->input('parentsandguardian_id', ['type' => 'text', 'value' => $parentsandguardian->family]);
						?>
					</div>
                </div>
            </fieldset>
        <?= $this->Form->button(__('Guardar'), ['class' =>'btn btn-success', 'id' => 'guardar']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
	idFamily = 0;
	function asignacion(id, value) 
	{
		idFamily = id;
	}
    $(document).ready(function() 
    {
        $('#parentsandguardian-id').autocomplete(
		{
			source:'<?php echo Router::url(array('controller' => 'Parentsandguardians', 'action' => 'findFamily')); ?>',
			minLength: 3,
			select: function( event, ui ) 
			{
				asignacion(ui.item.id, ui.item.value);
			}	
		});
		$('#guardar').click(function(e) 
        {
			$('#parentsandguardian-id').css('color', 'white');
			$("#parentsandguardian-id").val(idFamily);
		}); 
    });
</script>		