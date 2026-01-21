<br />
<?= $this->Html->link('Imprimir la factura', ['action' => 'invoice', $idFactura, 0, $idParentsandguardian, 'imprimirFactura', $billNumber], ['class' => 'btn btn-success']); ?>
<br />
<br />
<script>
	var mensaje = "<?= $mensaje ?>";
    $(document).ready(function() 
    {
		if (mensaje != "")
		{
			alert(mensaje);
		}
	});
</script>