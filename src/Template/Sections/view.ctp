<div class="container">
    <div class="page-header">    
        <p><?= $this->Html->link(__('Lista de secciones'), ['action' => 'index'], ['class' => 'btn btn-sm btn-default']) ?></li>
        <h1>Área de enseñanza:&nbsp;<?= h($section->full_name) ?></h1>
    </div>
    <div class="row">
        <div class="col col-sm-8">
            <br />
                Nivel de estudio:&nbsp;<?= h($section->full_name) ?>
            <br />
            <br />
                Cantidad máxima de alumnos:&nbsp;<?= $this->Number->format($section->maximum_amount) ?>
            <br />
            <br />
                Cantidad de alumnos registrados:&nbsp;<?= $this->Number->format($section->registered_students) ?>
            <br />
            <br />
        </div>
    </div>
    <div class="related">
        <h4><?= __('Docentes asignados a esta sección') ?></h4>
        <?php if (!empty($section->employees)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('full_name', ['Nombre']) ?></th>
                            <th scope="col" class="actions"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($section->employees as $employees): ?>
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
    <div class="related">
        <h4><?= __('Alumnos asignados a esta sección') ?></h4>
        <?php if (!empty($section->students)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('full_name', ['Nombre']) ?></th>
                            <th scope="col" class="actions"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($section->students as $students): ?>
                        <tr>
                            <td><?= h($students->full_name) ?></td>
                            <td class="actions">
                                <?= $this->Html->link('Ver', ['controller' => 'Students', 'action' => 'view', $students->id], ['class' => 'btn btn-sm btn-info']) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>