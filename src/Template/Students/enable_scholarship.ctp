<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h3>Becar Alumnos (Beca Completa del 100%)</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Alumno</th>
                        <th scope="col">Tipo Beca Actual</th>
                        <th scope="col">Porcentaje Beca Actual</th>
                        <th scope="col" class="actions"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): 
                        if ($student->tipo_descuento == null || $student->tipo_descuento == '' || $student->tipo_descuento == ' '):
                            $tipoDescuento = 'Ninguna';
                        elseif ($student->tipo_descuento == 'Becado'):
                            $tipoDescuento = "Completa";
                        else:
                            $tipoDescuento = $student->tipo_descuento;
                        endif; ?>
                        <tr>
                            <td><?= h($student->full_name) ?></td>
                            <td>
                                <?= $tipoDescuento ?>
                            </td>
                            <td style='text-align: center;'><?= h($student->discount).'%' ?></td>
                            <td class="actions">
                                <?php 
                                if ($student->scholarship == 1 || $student->tipo_descuento > 0)
                                {
                                    echo $this->Html->link('Eliminar beca', ['action' => 'deleteScholarship', $student->id, $student->parentsandguardian_id], ['class' => 'btn btn-sm btn-info']);
                                }
                                else
                                {
                                    echo $this->Html->link('Becar', ['action' => 'studentScholarship', $student->id, $student->parentsandguardian_id], ['class' => 'btn btn-sm btn-info']);
                                }
                                ?>
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