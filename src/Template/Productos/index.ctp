<div id="indexProductos" class="productos index container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-header">
                <?= __('Productos') ?>
                <div class="pull-right">
                    <?= $this->Html->link('<i class="glyphicon glyphicon-plus"></i> ' . __('Nuevo'), ['action' => 'add'], ['escape' => false, 'class' => 'btn btn-primary btn-sm']) ?>
                </div>
            </h3>
        </div>
    </div>

    <div class="table-responsive">
        <table id="tabla-productos" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('nombre_producto', 'Producto') ?></th>
                    <th><?= $this->Paginator->sort('tipo_producto', 'Tipo') ?></th>
                    <th><?= $this->Paginator->sort('unidad_medida', 'U. Medida') ?></th>
                    <th><?= $this->Paginator->sort('existencia_actual', 'Existencia') ?></th>
                    <th class="actions text-center"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= $this->Number->format($producto->id) ?></td>
                    <td><?= h($producto->nombre_producto) ?></td>
                    <td><?= h($producto->tipo_producto) ?></td>
                    <td><?= h($producto->unidad_medida) ?></td>
                    <td>
                        <span class="label <?= $producto->existencia_actual > 0 ? 'label-success' : 'label-danger' ?>">
                            <?= $this->Number->format($producto->existencia_actual) ?>
                        </span>
                    </td>
                    <td class="actions text-center">
                        <?= $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', ['action' => 'view', $producto->id], ['escape' => false, 'class' => 'btn btn-info btn-xs', 'title' => 'Ver']) ?>
                        <?= $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', ['action' => 'edit', $producto->id], ['escape' => false, 'class' => 'btn btn-warning btn-xs', 'title' => 'Editar']) ?>
                        <?= $this->Form->postLink('<i class="glyphicon glyphicon-trash"></i>', ['action' => 'delete', $producto->id], ['confirm' => __('¿Eliminar el producto # {0}?', $producto->id), 'escape' => false, 'class' => 'btn btn-danger btn-xs', 'title' => 'Eliminar']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="paginator text-center">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Página {{page}} de {{pages}}, mostrando {{current}} registros')]) ?></p>
    </div>
</div>