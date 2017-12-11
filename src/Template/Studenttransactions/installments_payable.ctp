<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h3><?= 'Cuotas a Pagar del alumno: ' . $studentName ?></h3>
            <h4><?= __('Saldo factura Bs. ' . number_format($balance, 2, ",", ".")) ?></h4>
            <p><?= $this->Html->link(__('Pagar el saldo de la factura'), ['controller' => 'Guardiantransactions', 'action' => 'add', $parentId, $balance], ['class' => 'btn btn-sm btn-default']) ?></p>
            <p><?= $this->Html->link(__('Facturar cuotas de otro alumno'), ['controller' => 'Students', 'action' => 'payments', $parentId, $description], ['class' => 'btn btn-sm btn-default']) ?></p>

        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('transaction_description', ['Cuota']) ?></th>
                        <th scope="col"><?= $this->Paginator->sort('amount', ['Monto']) ?></th>
                        <th scope="col" class="actions"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($studenttransactions as $studenttransaction): ?>
                    <tr>
                        <td><?= h($studenttransaction->transaction_description) ?></td>
                        <td><?= $this->Number->format($studenttransaction->amount, 
                        ['places' => 2, 'decimals' => ',', 'thousands' => '.']) ?></td>
                        <td class="actions">
                            <?php 
                            if($studenttransaction->invoiced == 0)
                                echo $this->Html->link(__('Facturar'), ['action' => 'checkIn', $parentId, $studenttransaction->id, $studentName, $description], ['class' => 'btn btn-sm btn-info']);
                            else
                                echo 'Facturada'; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->prev('< Anterior') ?>
                <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
                <?= $this->Paginator->next('Siguiente >') ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    </div>
</div>