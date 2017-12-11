<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Mistudent'), ['action' => 'edit', $mistudent->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Mistudent'), ['action' => 'delete', $mistudent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $mistudent->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Mistudents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Mistudent'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="mistudents view large-9 medium-8 columns content">
    <h3><?= h($mistudent->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Codigo') ?></th>
            <td><?= h($mistudent->codigo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Familia') ?></th>
            <td><?= h($mistudent->familia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Apellidos') ?></th>
            <td><?= h($mistudent->apellidos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombres') ?></th>
            <td><?= h($mistudent->nombres) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sexo') ?></th>
            <td><?= h($mistudent->sexo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nacimiento') ?></th>
            <td><?= h($mistudent->nacimiento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Direccion') ?></th>
            <td><?= h($mistudent->direccion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Grado') ?></th>
            <td><?= h($mistudent->grado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Seccion') ?></th>
            <td><?= h($mistudent->seccion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Condicion') ?></th>
            <td><?= h($mistudent->condicion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Escolaridad') ?></th>
            <td><?= h($mistudent->escolaridad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Feb') ?></th>
            <td><?= h($mistudent->feb) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mar') ?></th>
            <td><?= h($mistudent->mar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('May') ?></th>
            <td><?= h($mistudent->may) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($mistudent->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Idd') ?></th>
            <td><?= $this->Number->format($mistudent->idd) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cuota') ?></th>
            <td><?= $this->Number->format($mistudent->cuota) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Saldo') ?></th>
            <td><?= $this->Number->format($mistudent->saldo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sep') ?></th>
            <td><?= $this->Number->format($mistudent->sep) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Oct') ?></th>
            <td><?= $this->Number->format($mistudent->oct) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nov') ?></th>
            <td><?= $this->Number->format($mistudent->nov) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dic') ?></th>
            <td><?= $this->Number->format($mistudent->dic) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ene') ?></th>
            <td><?= $this->Number->format($mistudent->ene) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Abr') ?></th>
            <td><?= $this->Number->format($mistudent->abr) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Jun') ?></th>
            <td><?= $this->Number->format($mistudent->jun) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Jul') ?></th>
            <td><?= $this->Number->format($mistudent->jul) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ago') ?></th>
            <td><?= $this->Number->format($mistudent->ago) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mensualidad') ?></th>
            <td><?= $this->Number->format($mistudent->mensualidad) ?></td>
        </tr>
    </table>
</div>
