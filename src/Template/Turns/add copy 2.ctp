<?php
if (isset($turn)): ?>
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
<?php endif; ?>
<script>
    function pad(numero) 
    {
        if (numero < 10) 
        {
            return '0' + numero;
        }
        return numero;
    }
    function fecha_hora_iso_local()
    {
        let fecha_hora_actual = new Date();
        console.log("fecha_hora_actual", fecha_hora_actual);
        return fecha_hora_actual.getFullYear() +
        '-' + pad(fecha_hora_actual.getMonth() + 1) +
        '-' + pad(fecha_hora_actual.getDate()) +
        'T' + pad(fecha_hora_actual.getHours()) +
        ':' + pad(fecha_hora_actual.getMinutes()) +
        ':' + pad(fecha_hora_actual.getSeconds()) +
        '.' + (fecha_hora_actual.getMilliseconds() / 1000).toFixed(3).slice(2, 5) +
        'Z';
    }

    $(document).ready(function() 
    {
        $('#turn').change(function(e) 
        {
            e.preventDefault()
            var r = confirm("Las facturas se emitirán con fecha: " + $("#start-date").val());
            if (r == false)
                {
                    e.preventDefault();
                    alert("Por favor informe al personal de computación que verifiquen la fecha del servidor");
                    $("#turn").attr('disabled', true);
                    $("#abrir").attr('disabled', true);
                }
        });
        /*
        let fecha_hora_arbitraria = new Date(2023, 01, 21, 17, 01, 00);
        console.log("fecha_hora_arbitraria", fecha_hora_arbitraria);
       
        let fecha_hora_actual_utc= new Date().toUTCString();
        console.log("fecha_hora_actual_utc", fecha_hora_actual_utc);

        let fecha_hora_actual = new Date();
        console.log("fecha_hora_actual", fecha_hora_actual);
        */

        let fecha_hora_actual_iso = new Date().toISOString();
        console.log("fecha_hora_actual_iso", fecha_hora_actual_iso); 
        
        fecha_hora_iso_local = fecha_hora_iso_local();
        console.log("fecha_hora_iso_local", fecha_hora_iso_local);

    });
</script>