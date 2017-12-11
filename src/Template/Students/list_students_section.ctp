<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h3>Asignar Alumno a Sección</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('level_of_study', ['Nivel de estudio']) ?></th>
                        <th scope="col"><?= $this->Paginator->sort('full_name', ['Alumno']) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= h($student->level_of_study) ?></td>
                        <td><?= h($student->full_name) ?></td>
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