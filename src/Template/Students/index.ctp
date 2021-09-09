<?php
    use Cake\I18n\Time;
?>
<div class="row">
    <div class="col-md-12">
        <?php if ($family != ''): ?>
            <div class="page-header">
                <h4>Familia: <?= $family ?></h4>
                <p style="color: #004d99;">Por favor actualice los datos de su(s) hijo(s) o representado(s) y luego imprima la ficha de inscripción</p>
            </div>
        <?php else: ?>
            <br />
            <h4>Listado de alumnos</h4>
        <?php endif; ?>
        <?php
        $updateIndicator = 0;
        foreach ($students as $student): ?>
            <?php 
            if ($student->id > 1 && $student->section_id < 41):  
                if ($student->level_of_study == " " || $student->level_of_study == "" || 
                    $student->nationality == " " || $student->nationality == "" ||
                    $student->place_of_birth == " " || $student->place_of_birth == "" ):
                    $updateIndicator = 1;
                endif;
            endif; 
        endforeach; 
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('full_name', ['Alumno']) ?></th>
                        <?php if($current_user['role'] == 'Representante'): ?>
                            <th scope="col" class="actions"><?= __('Acciones') ?></th>
                        <?php else: ?>
                            <th scope="col" class="actions"></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <?php if ($student->id > 1): ?> 
                            <tr>
                                <td><?= h($student->full_name) ?></td>
                                <td class="actions">
                                    <?php if($current_user['role'] == 'Representante'): ?>
                                        <?= $this->Html->link('Actualizar datos', ['controller' => 'Students', 'action' => 'edit', $student->id], ['class' => 'btn btn-sm btn-primary']) ?>
                                        <?= $this->Html->link('Agregar foto', ['action' => 'editPhoto', $student->id], ['class' => 'btn btn-sm btn-primary']) ?>
                                        <?= $this->Html->link('Ver datos', ['controller' => 'Students', 'action' => 'view', $student->id], ['class' => 'btn btn-sm btn-primary']) ?>
                                        <?php
                                            setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
                                            date_default_timezone_set('America/Caracas');
                                
                                            $dateStudent = $student->modified;
                                            $dateStudentI = $dateStudent->year . $dateStudent->month . $dateStudent->day;
                                            $currentDate = Time::now();
                                            $currentDatei = $currentDate->year . $currentDate->month . $currentDate->day;
                                            
                                            if ($updateIndicator == 0):
                                                echo $this->Html->link('Imprimir ficha de inscripción', ['action' => 'filepdf', $student->id, 'Students', 'index'], ['class' => 'btn btn-sm btn-info']);
                                            endif;
                                        ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
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