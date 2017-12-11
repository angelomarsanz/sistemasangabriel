<div class="row">
    <div class="col-md-6 col-md-offset-3">
    	<div class="page-header">
    		<h2>Abrir turno</h2>
    	</div>
        <?= $this->Form->create($turn) ?>
            <fieldset>
                <?php
                    echo $this->Form->input('start_date', ['type' => 'hidden', 'id' => 'start-date', 'value' => $startDate]);
                    echo $this->Form->input('turn', ['label' => 'Turno:', 'options' => [null => ' ', '1' => '1', '2' => '2']]);
                ?>
            </fieldset>
        <?= $this->Form->button(__('Abrir'), ['id' => 'abrir', 'class' => 'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    $(document).ready(function() 
    {
        $('#turn').focusout(function(e) 
        {
            var r = confirm("Las facturas se emitirán con fecha: " + $("#start-date").val());
            if (r == false)
                {
                    e.preventDefault();
                    alert("Por favor informe al personal de computación que verifiquen la fecha del servidor");
                    $("#turn").attr('disabled', true);
                    $("#abrir").attr('disabled', true);
                }
        });
    });
</script>