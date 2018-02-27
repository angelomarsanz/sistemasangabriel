<br />
<br />
<?= $this->Html->link('Imprimir la factura', ['action' => 'invoicepdf', $billNumber, '_ext' => 'pdf'], ['class' => 'btn btn-success']); ?>
<br />
<br />
<?= $this->Html->link('Imprimir cartón de cuotas', ['controller' => 'Students', 'action' => 'indexCardboardInscription', $billNumber, $idParentsandguardian, $family], ['class' => 'btn btn-success']); ?>
<br />
<br />
<?= $this->Html->link('Inscripción alumnos regulares', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Inscripción regulares'], ['class' => 'btn btn-sm btn-primary']); ?>
<br />
<br />
<?= $this->Html->link('Inscripción alumnos nuevos', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Inscripción nuevos'], ['class' => 'btn btn-sm btn-primary']); ?>
<br />
<br />
<?= $this->Html->link('Servicio educativo', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Servicio educativo'], ['class' => 'btn btn-sm btn-primary']); ?>
<br />
<br />
<?= $this->Html->link('Mensualidades', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Mensualidades'], ['class' => 'btn btn-sm btn-primary']); ?>