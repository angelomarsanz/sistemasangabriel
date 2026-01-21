<br />
<br />
<?php
if ($current_user['role'] == 'Seniat' ): ?>
    <?= $this->Html->link('Factura inscripción estudiantes regulares', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Factura inscripción regulares'], ['class' => 'btn btn-sm btn-primary']) ?> 
    <br />
    <br />
    <?= $this->Html->link('Factura inscripción estudiantes nuevos', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Factura inscripción nuevos'], ['class' => 'btn btn-sm btn-primary']) ?>
    <br />
    <br />
	<?= $this->Html->link('Factura mensualidades', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Factura mensualidades'], ['class' => 'btn btn-sm btn-primary']) ?> 
    <br />
    <br />
<?php
elseif ($current_user['role'] == 'Ventas generales' || $current_user['role'] == 'Contabilidad general' ): ?>
    <?= $this->Html->link('Pedido inscripción estudiantes regulares', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Pedido inscripción regulares'], ['class' => 'btn btn-sm btn-primary']) ?>
    <br />
    <br />
    <?= $this->Html->link('Pedido inscripción estudiantes nuevos', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Pedido inscripción nuevos'], ['class' => 'btn btn-sm btn-primary']) ?>
    <br />
    <br />
    <?= $this->Html->link('Pedido mensualidades', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Pedido mensualidades'], ['class' => 'btn btn-sm btn-primary']) ?> 															
    <br />
    <br />
    <?= $this->Html->link('Recibo servicio educativo', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Recibo servicio educativo'], ['class' => 'btn btn-sm btn-primary']) ?>		
    <br />
    <br />
    <?= $this->Html->link('Recibo de seguro', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Recibo de seguro'], ['class' => 'btn btn-sm btn-primary']) ?> 
    <br />
    <br />
    <?= $this->Html->link('Recibo Consejo Educativo', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Recibo Consejo Educativo'], ['class' => 'btn btn-sm btn-primary']) ?>		 								
    <br />
    <br />
<?php
else: ?>
    <?= $this->Html->link('Factura inscripción estudiantes regulares', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Factura inscripción regulares'], ['class' => 'btn btn-sm btn-primary']) ?> 
    <br />
    <br />
    <?= $this->Html->link('Factura inscripción estudiantes nuevos', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Factura inscripción nuevos'], ['class' => 'btn btn-sm btn-primary']) ?>
    <br />
    <br />
	<?= $this->Html->link('Factura mensualidades', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Factura mensualidades'], ['class' => 'btn btn-sm btn-primary']) ?> 
    <br />
    <br />
    <?= $this->Html->link('Pedido inscripción estudiantes regulares', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Pedido inscripción regulares'], ['class' => 'btn btn-sm btn-primary']) ?>
    <br />
    <br />
    <?= $this->Html->link('Pedido inscripción estudiantes nuevos', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Pedido inscripción nuevos'], ['class' => 'btn btn-sm btn-primary']) ?>
    <br />
    <br />
    <?= $this->Html->link('Pedido mensualidades', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Pedido mensualidades'], ['class' => 'btn btn-sm btn-primary']) ?> 															
    <br />
    <br />
    <?= $this->Html->link('Recibo servicio educativo', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Recibo servicio educativo'], ['class' => 'btn btn-sm btn-primary']) ?>		
    <br />
    <br />
    <?= $this->Html->link('Recibo de seguro', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Recibo de seguro'], ['class' => 'btn btn-sm btn-primary']) ?> 
    <br />
    <br />
    <?= $this->Html->link('Recibo Consejo Educativo', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Recibo Consejo Educativo'], ['class' => 'btn btn-sm btn-primary']) ?>		 								
    <br />
    <br />
<?php
endif; ?>