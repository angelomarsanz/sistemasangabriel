<br />
<br />
<?= $this->Html->link('Imprimir la factura', ['action' => 'invoicepdf', $billNumber, '_ext' => 'pdf'], ['class' => 'btn btn-success']); ?>
<br />
<br />
<?= $this->Html->link('Imprimir cartón de cuotas', ['controller' => 'Students', 'action' => 'indexCardboardInscription', $billNumber, $idParentsandguardian, $family], ['class' => 'btn btn-success']); ?>
<br />
<br />
<?= $this->Html->link('Factura inscripción alumnos regulares', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Factura inscripción regulares'], ['class' => 'btn btn-sm btn-primary']); ?>
<br />
<br />
<?= $this->Html->link('Factura inscripción alumnos nuevos', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Factura inscripción nuevos'], ['class' => 'btn btn-sm btn-primary']); ?>
<br />
<br />
<?= $this->Html->link('Recibo inscripción alumnos regulares', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Recibo inscripción regulares'], ['class' => 'btn btn-sm btn-primary']); ?>
<br />
<br />
<?= $this->Html->link('Recibo inscripción alumnos nuevos', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Recibo inscripción nuevos'], ['class' => 'btn btn-sm btn-primary']); ?>
<br />
<br />
<?= $this->Html->link('Mensualidades', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Mensualidades'], ['class' => 'btn btn-sm btn-primary']); ?>