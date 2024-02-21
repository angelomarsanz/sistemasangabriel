<div class="row">
    <div class="col-md-8">
    	<div class="page-header">
    	    <h3><?= __('Tarifas') ?></h3>
     	    <p><?= $this->Html->link(__(''), ['action' => 'addDollar'], ['class' => 'glyphicon glyphicon-plus btn btn-sm btn-default', 'title' => 'Agregar tarifa']) ?></p>
    	</div>
    	<div class="table-responsive">
    		<table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('Tarifa') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Monto') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Año') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Mes') ?></th>
                        <th scope="col" class="actions"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rates as $rate): ?>
                        <tr>
                            <td><?= h($rate->concept) ?></td>
                            <td><?= number_format($rate->amount, 2, ",", ".") ?></td>
                            <td><?= $rate->rate_year ?></td>
                            <td><?= $rate->rate_month ?></td>
                            <td class="actions">
                                <?= $this->Html->link('', ['action' => 'view', $rate->id], ['class' => 'glyphicon glyphicon-eye-open btn btn-sm btn-info', 'title' => 'ver']) ?>
                                <?= $this->Html->link('', ['action' => 'edit', $rate->id], ['class' => 'glyphicon glyphicon-edit btn btn-sm btn-primary', 'title' => 'Modificar']) ?>
                                <?= $this->Form->postLink('', ['action' => 'delete', $rate->id], ['confirm' => 'Eliminar?', 'class' => 'glyphicon glyphicon-trash btn btn-sm btn-danger', 'title' => 'Eliminar']) ?>
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