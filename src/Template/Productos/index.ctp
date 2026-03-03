<div id="indexProductos" class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">📦 Inventario de Productos</h1>
        </div>
    </div>

    <div class="row flex-container">
        <?php foreach ($productos as $producto): ?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <strong>#<?= h($producto->id) ?></strong> - <?= h($producto->nombre_producto) ?>
                        </h3>
                    </div>
                    <div class="panel-body text-left">
                        <p><strong>Tipo:</strong> <?= h($producto->tipo_producto) ?></p>
                        <p><strong>U. Medida:</strong> <?= h($producto->unidad_medida) ?></p>
                        <p><strong>Existencia:</strong> 
                            <span class="label <?= $producto->existencia_actual > 0 ? 'label-success' : 'label-danger' ?>">
                                <?= $this->Number->format($producto->existencia_actual) ?>
                            </span>
                        </p>
                    </div>
                    <div class="panel-footer text-center">
                        <?= $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', ['action' => 'view', $producto->id], ['escape' => false, 'class' => 'btn btn-info btn-sm', 'title' => 'Ver']) ?>
                        <?= $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', ['action' => 'edit', $producto->id], ['escape' => false, 'class' => 'btn btn-warning btn-sm', 'title' => 'Editar']) ?>
                        <?= $this->Form->postLink('<i class="glyphicon glyphicon-trash"></i>', ['action' => 'delete', $producto->id], ['confirm' => __('¿Eliminar el producto # {0}?', $producto->id), 'escape' => false, 'class' => 'btn btn-danger btn-sm', 'title' => 'Eliminar']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="paginator text-center">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de {{count}} total')]) ?></p>
    </div>
</div>