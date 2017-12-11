<div class="container">
    <div class="page-header">    
        <p><?= $this->Html->link(__('Lista de usuarios'), ['action' => 'index'], ['class' => 'btn btn-sm btn-default']) ?></p>
        <button type="button" class="btn btn-sm btn-danger">Prueba</button>
        <h1>Usuario:&nbsp;<?= h($user->username) ?></h1>
    </div>
    <div class="row">
        <div class="col col-sm-4">
            <?= $this->Html->image('../files/users/profile_photo/' . $user->get('profile_photo_dir') . '/'. $user->get('profile_photo'), ['class' => 'img-thumbnail img-responsive']) ?>
        </div>
        <div class="col col-sm-4">    
            <br />
                Rol:&nbsp;<?= h($user->role) ?>
            <br />
            <br />
                Nombre del usuario:&nbsp;<?= h($user->full_name) ?>
            <br />
            <br />
                Sexo:&nbsp;<?= h($user->sex) ?>
            <br />
            <br />
                Email:&nbsp;<?= h($user->email) ?>
            <br />
            <br />
                Número de teléfono celular:&nbsp;<?= h($user->cell_phone) ?>
            <br />
            <br />            
                Creado:&nbsp;<?= h($user->created) ?>
            <br />
            <br />
                Modificado:&nbsp;<?= h($user->modified) ?>
            <br />
            <br />
            <?= $this->Html->link(__('Exportar a PDF'), ['action' => 'viewpdf', $user->id, '_ext' => 'pdf'], ['target' => '_blank']); ?>
        </div>
    </div>
</div>