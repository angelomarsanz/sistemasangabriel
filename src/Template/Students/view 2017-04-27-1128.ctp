<div class="container">
    <div class="page-header">    
        <p><?= $this->Html->link(__('Lista de alumnos'), ['action' => 'index'], ['class' => 'btn btn-sm btn-default']) ?></li>
        <h1>Alumno:&nbsp;<?= h($student->full_name) ?></h1>
    </div>
    <div class="row">
        <div class="col col-sm-4">
            <?= $this->Html->image('../files/users/profile_photo/' . $student->get('profile_photo_dir') . '/'. $student->get('profile_photo'), ['class' => 'img-thumbnail img-responsive']) ?>
        </div>
        <div class="col col-sm-4">    
            <br />
                Sexo:&nbsp;<?= h($student->sex) ?>
            <br />
            <br />
                Nacionalidad:&nbsp;<?= h($student->nationality) ?>
            <br />
            <br />
                Tipo de identificación:&nbsp;<?= h($student->type_of_identification) ?>
            <br />
            <br />
                Número de cédula o pasaporte:&nbsp;<?= h($student->identity_card) ?>
            <br />
            <br />
                Vínculo familiar del representante con el alumno:&nbsp;<?= h($student->family_bond_guardian_student) ?>
            <br />
            <br />
                Nombre del padre:&nbsp;<?= h($student->first_name_father) ?>
            <br />
            <br />
                Apellido del padre:&nbsp;<?= h($student->surname_father) ?>
            <br />
            <br />
                Nombre de la madre:&nbsp;<?= h($student->first_name_mother) ?>
            <br />
            <br />
                Apellido de la madre:&nbsp;<?= h($student->surname_mother) ?>
            <br />
            <br />
                Fecha de nacimiento:&nbsp;<?= h($student->birthdate) ?>
            <br />
            <br />
                Lugar de nacimiento:&nbsp;<?= h($student->place_of_birth) ?>
            <br />
            <br />
                País de nacimiento:&nbsp;<?= h($student->country_of_birth) ?>
            <br />
            <br />
                Dirección de habitación:&nbsp;<?= h($student->address) ?>
            <br />
            <br />
                Número de teléfono celular:&nbsp;<?= h($student->cell_phone) ?>
            <br />
            <br />
                Email:&nbsp;<?= h($student->email) ?>
            <br />
            <br />
                Nivel de estudio:&nbsp;<?= h($student->level_of_study) ?>
            <br />
            <br />
                Sección a la que está asignado:&nbsp;<?= $student->has('section') ? $this->Html->link($student->section->id, ['controller' => 'Sections', 'action' => 'view', $student->section->id]) : '' ?>
            <br />
            <br />
                Colegio de donde proviene:&nbsp;<?= h($student->previous_school) ?>
            <br />
            <br />
                ¿Tiene hermanos en el colegio:&nbsp;<?= $student->brothers_in_school ? __('Sí') : __('No'); ?>
            <br />
            <br />
                Número de hermanos en el colegio:&nbsp;<?= $this->Number->format($student->number_of_brothers) ?>
            <br />
            <br />
                ¿Es becado?:&nbsp;<?= $student->scholarship ? __('Sí') : __('No'); ?>
            <br />
            <br />
                Saldo administrativo:&nbsp;<?= $this->Number->format($student->balance) ?>
            <br />
            <br />
                Enfermedades del alumno:&nbsp;<?= h($student->student_illnesses) ?>
            <br />
            <br />
                Observaciones:&nbsp;<?= h($student->observations) ?>
            <br />
            <br />
            <?= $this->Html->link('Ver los datos de usuario del alumno', ['controller' => 'Users', 'action' => 'view', $student->user->id], ['class' => 'btn btn-sm btn-info']) ?>
            <br />
            <br />
            <?= $this->Html->link('Ver el representante del alumno', ['controller' => 'Parentsandguardians', 'action' => 'view', $student->parentsandguardian->id], ['class' => 'btn btn-sm btn-info']) ?>
            <br />
            <br />
         </div>
    </div>
    <div class="related">
        <h4><?= __('Anexos de tareas asignadas al alumno') ?></h4>
        <?php if (!empty($student->activitiesannexes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Student Id') ?></th>
                <th scope="col"><?= __('Student Activitie Id') ?></th>
                <th scope="col"><?= __('Link') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($student->activitiesannexes as $activitiesannexes): ?>
            <tr>
                <td><?= h($activitiesannexes->id) ?></td>
                <td><?= h($activitiesannexes->student_id) ?></td>
                <td><?= h($activitiesannexes->student_activitie_id) ?></td>
                <td><?= h($activitiesannexes->link) ?></td>
                <td><?= h($activitiesannexes->created) ?></td>
                <td><?= h($activitiesannexes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Activitiesannexes', 'action' => 'view', $activitiesannexes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Activitiesannexes', 'action' => 'edit', $activitiesannexes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Activitiesannexes', 'action' => 'delete', $activitiesannexes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activitiesannexes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Calificaciones del alumno') ?></h4>
        <?php if (!empty($student->studentqualifications)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Student Id') ?></th>
                <th scope="col"><?= __('Student Activitie Id') ?></th>
                <th scope="col"><?= __('Qualification') ?></th>
                <th scope="col"><?= __('Numerical Rating') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($student->studentqualifications as $studentqualifications): ?>
            <tr>
                <td><?= h($studentqualifications->id) ?></td>
                <td><?= h($studentqualifications->student_id) ?></td>
                <td><?= h($studentqualifications->student_activitie_id) ?></td>
                <td><?= h($studentqualifications->qualification) ?></td>
                <td><?= h($studentqualifications->numerical_rating) ?></td>
                <td><?= h($studentqualifications->created) ?></td>
                <td><?= h($studentqualifications->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Studentqualifications', 'action' => 'view', $studentqualifications->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Studentqualifications', 'action' => 'edit', $studentqualifications->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Studentqualifications', 'action' => 'delete', $studentqualifications->id], ['confirm' => __('Are you sure you want to delete # {0}?', $studentqualifications->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Cuotas de pago del alumno') ?></h4>
        <?php if (!empty($student->studenttransactions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Student Id') ?></th>
                <th scope="col"><?= __('Payment Date') ?></th>
                <th scope="col"><?= __('Transaction Type') ?></th>
                <th scope="col"><?= __('Transaction Description') ?></th>
                <th scope="col"><?= __('Paid Out') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($student->studenttransactions as $studenttransactions): ?>
            <tr>
                <td><?= h($studenttransactions->id) ?></td>
                <td><?= h($studenttransactions->student_id) ?></td>
                <td><?= h($studenttransactions->payment_date) ?></td>
                <td><?= h($studenttransactions->transaction_type) ?></td>
                <td><?= h($studenttransactions->transaction_description) ?></td>
                <td><?= h($studenttransactions->paid_out) ?></td>
                <td><?= h($studenttransactions->amount) ?></td>
                <td><?= h($studenttransactions->created) ?></td>
                <td><?= h($studenttransactions->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Studenttransactions', 'action' => 'view', $studenttransactions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Studenttransactions', 'action' => 'edit', $studenttransactions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Studenttransactions', 'action' => 'delete', $studenttransactions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $studenttransactions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>