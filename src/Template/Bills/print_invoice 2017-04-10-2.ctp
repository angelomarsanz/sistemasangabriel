<br />
<br />
<?= $this->Html->link('Imprimir la factura', ['action' => 'invoicepdf', $billId, '_ext' => 'pdf'], ['target' => '_blank', 'class' => 'btn btn-sm btn-primary']); ?>

<?= $this->Html->link('Facturar cuotas para otra familia', ['action' => 'createInvoice'], ['class' => 'btn btn-sm btn-primary']); ?>