<br />
<br />
<?= $this->Html->link(__('Descargar libro de ventas'), ['controller' => 'Salesbooks', 'action' => 'indexexcel', '_ext'=>'xlsx'], ['id' => 'download_book', 'class' => 'btn btn-success']); ?>
<br />
<br />
<p id="messages"></p>
<script>
    $(document).ready(function() 
    {
        $('#download_book').click(function(e) 
        {
            $("#messages").html("Por favor espere...");
        });
    });
</script>
