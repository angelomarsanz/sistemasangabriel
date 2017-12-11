<div class="container">
    <div class="page-header">    
        <h1>Usuario:&nbsp;<?= h($user->username) ?></h1>
    </div>
    <div class="row">
        <div class="col col-sm-4">
            <?php if($current_user['role'] == 'Administrador'): ?>
                <?= $this->Html->image('../files/users/profile_photo/' . $current_user['profile_photo_dir'] . '/'. $current_user['profile_photo'], ['url' => ['controller' => 'users', 'action' => 'view', $current_user['id']], 'class' => 'img-thumbnail img-responsive']) ?>
            <?php elseif($current_user['role'] == 'Representante'): ?>
                <?= $this->Html->image('../files/parentsandguardians/profile_photo/' . $current_user['profile_photo_dir'] . '/'. $current_user['profile_photo'], ['url' => ['controller' => 'users', 'action' => 'view', $current_user['id']], 'class' => 'img-thumbnail img-responsive']) ?>
            <?php endif; ?>
        </div>
        <div class="col col-sm-8">    
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
        </div>
    </div>
</div>