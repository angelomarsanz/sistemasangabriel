<div class="container">
    <div class="page-header">    
        <p><?= $this->Html->link(__('Lista de materias'), ['action' => 'index'], ['class' => 'btn btn-sm btn-default']) ?></li>
        <h1>Materia:&nbsp;<?= h($teachingarea->description_teaching_area) ?></h1>
    </div>
    <div class="related">
        <h4><?= __('Docentes asignados a esta materia') ?></h4>
        <?php if (!empty($teachingarea->employees)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('full_name', ['Nombre']) ?></th>
                            <th scope="col" class="actions"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teachingarea->employees as $employees): ?>
                        <tr>
                            <td><?= h($employees->full_name) ?></td>
                            <td class="actions">
                                <?= $this->Html->link('Ver', ['controller' => 'Employees', 'action' => 'view', $employees->id], ['class' => 'btn btn-sm btn-info']) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>