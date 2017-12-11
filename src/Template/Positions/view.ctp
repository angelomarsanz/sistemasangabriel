<div class="container">
    <div class="page-header">    
        <p><?= $this->Html->link(__('Lista de puestos de trabajo'), ['action' => 'index'], ['class' => 'btn btn-sm btn-default']) ?></li>
        <h1>Puesto de Trabajo:&nbsp;<?= h($position->position) ?></h1>
    </div>
    <div class="row">
        <div class="col col-sm-8">
            </br>
                Nombre corto:&nbsp;<?= h($position->short_name) ?>
            </br>
            </br>
                Tipo de sueldo:&nbsp;<?= h($position->type_of_salary) ?>
            </br>
            </br>
                Sueldo básico:&nbsp;<?= $this->Number->format($position->minimum_wage) ?>
            </br>
            </br>
                Motivo del aumento del sueldo:&nbsp;<?= h($position->reason_salary_increase) ?>
            </br>
            </br>
                Fecha de vigencia del aumento del sueldo:&nbsp;<?= h($position->effective_date_increase->format('d-m-Y')) ?>
            </br>
            </br>
        </div>   
    </div>
    <div class="related">
        <h4><?= __('Empleados relacionados') ?></h4>
        <?php if (!empty($position->employees)): ?>
        	<div class="table-responsive">
        		<table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('classification', ['Clasificación']) ?></th>
                            <th scope="col"><?= $this->Paginator->sort('full_name', ['Nombre']) ?></th>
                            <th scope="col" class="actions"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($position->employees as $employees): ?>
                        <tr>
                            <td><?= h($employees->classification) ?></td>
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