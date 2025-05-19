<!-- Inicio cambios Seniat -->
<div class="container">
    <h2>Bienvenido(a) <?= $this->Html->link($current_user['first_name'] . ' ' . $current_user['surname'], ['controller' => 'Users', 'action' => 'view', $current_user['id']]) ?> ! </h2>
    <div class="row">
        <div class="col col-sm-4">

        </div>
    </div>
</div>
<!-- Fin cambios Seniat -->