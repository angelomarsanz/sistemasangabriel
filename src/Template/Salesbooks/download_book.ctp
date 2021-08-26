<br />
<br />
<?= $this->Html->link(__('Vista previa libro de ventas'), ['controller' => 'Salesbooks', 'action' => 'indexexcel'], ['id' => 'download_book', 'class' => 'btn btn-success']); ?>
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
