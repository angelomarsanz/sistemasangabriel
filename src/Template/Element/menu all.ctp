<nav class="navbar navbar-inverse nav-users">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= $this->Html->link('Sistema San Gabriel', ['controller' => 'Users', 'action' => 'home'], ['class' => 'navbar-brand']) ?>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
            <?php if(isset($current_user)): ?>
                <ul class="nav navbar-nav">
                    <li><?=  $this->Html->link('Inicio', ['controller' => 'Users', 'action' => 'home']) ?></li>
                    <?php if($current_user['role'] == 'Administrador'): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Turno <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><?=  $this->Html->link('Abrir', ['controller' => 'Turns', 'action' => 'checkTurnOpen']) ?></li>
                                <li><?=  $this->Html->link('Cerrar', ['controller' => 'Bills', 'action' => 'editControlTurn']) ?></li>
                           </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Administrativo <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><?= $this->Html->link('Agregar tarifa', ['controller' => 'Rates', 'action' => 'add']) ?></li>
                                <li><?= $this->Html->link('Becar alumno', ['controller' => 'Students', 'action' => 'searchScholarship']) ?></li>
                                <li><?= $this->Html->link('Crear área de enseñanza', ['controller' => 'Teachingareas', 'action' => 'add']) ?></li>
                                <li><?= $this->Html->link('Crear puesto de trabajo', ['controller' => 'Positions', 'action' => 'add']) ?></li>
                                <li><?= $this->Html->link('Crear sección', ['controller' => 'Sections', 'action' => 'add']) ?></li>
                                <li><?= $this->Html->link('Registro básico de nuevos alumnos', ['controller' => 'Students', 'action' => 'registerNewStudents']) ?></li>
<!--
                                <li><?= $this->Html->link('Registro completo de nuevos alumnos', ['controller' => 'Students', 'action' => 'newRegistration']) ?></li>
-->
                                <li><?= $this->Html->link('Agregar lote de facturas', ['controller' => 'Controlnumbers', 'action' => 'edit']) ?></li>
                                <li><?= $this->Html->link('Modificar el número control de facturas', ['controller' => 'Bills', 'action' => 'editControl']) ?></li>
                                <li><?= $this->Html->link('Modificar las cuotas del alumno', ['controller' => 'Students', 'action' => 'modifyTransactions']) ?></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Matrículas y mensualidades <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <!-- <li><?=  $this->Html->link('Matrícula', ['controller' => 'Students', 'action' => 'guardian']) ?></li> -->
                                <li><?= $this->Html->link('Anular factura', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Anular']) ?></li>
                                <li><?= $this->Html->link('Cobrar inscripción alumnos regulares 2017-2018', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Inscripción regulares']) ?></li> 
                                <li><?= $this->Html->link('Cobrar inscripción alumnos nuevos 2017-2018', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Inscripción nuevos']) ?></li> 
                                <li><?= $this->Html->link('Cobrar servicio educativo 2017', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Servicio educativo']) ?></li> 
                                <li><?= $this->Html->link('Cobrar mensualidades 2016-2017', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Mensualidades']) ?></li> 
                                <li><?= $this->Html->link('Imprimir cartón de cuotas', ['controller' => 'Parentsandguardians', 'action' => 'consultCardboard']) ?></li> 
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Consultas <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><?=  $this->Html->link('Datos de familia', ['controller' => 'Parentsandguardians', 'action' => 'consultFamily']) ?></li>
                                <li><?=  $this->Html->link('Datos de alumnos', ['controller' => 'Students', 'action' => 'consultStudent']) ?></li>
                                <li><?=  $this->Html->link('Área de enseñanza', ['controller' => 'Teachingareas', 'action' => 'index']) ?></li>
                                <li><?=  $this->Html->link('Becados', ['controller' => 'Students', 'action' => 'scholarshipIndex']) ?></li>
                                <li><?=  $this->Html->link('Padres o representante', ['controller' => 'Parentsandguardians', 'action' => 'index']) ?></li>
                                <li><?=  $this->Html->link('Puestos de trabajo', ['controller' => 'Positions', 'action' => 'index']) ?></li>
                                <li><?=  $this->Html->link('Rubros padres y/o representantes', ['controller' => 'Parentsandguardians', 'action' => 'officeManager']) ?></li>
                                <li><?=  $this->Html->link('Secciones', ['controller' => 'Sections', 'action' => 'index']) ?></li>
                                <li><?=  $this->Html->link('Tarifas', ['controller' => 'Rates', 'action' => 'index']) ?></li>
                                <li><?=  $this->Html->link('Usuarios', ['controller' => 'Users', 'action' => 'index']) ?></li>
                                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reportes <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><?=  $this->Html->link('Relación de mensualidades', ['controller' => 'Students', 'action' => 'listMonthlyPayments']) ?></li>
                                <li><?= $this->Html->link('Reporte de pagos nuevos alumnos', ['controller' => 'Students', 'action' => 'newstudentpdf', "nuevos", '_ext' => 'pdf']) ?>
                                <li><?= $this->Html->link('Libro de ventas', ['controller' => 'Salesbooks', 'action' => 'createBook']) ?></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Nómina <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><?=  $this->Html->link('Relación de mensualidades', ['controller' => 'Students', 'action' => 'listMonthlyPayments']) ?></li>
                                <li><?= $this->Html->link('Reporte de pagos nuevos alumnos', ['controller' => 'Students', 'action' => 'newstudentpdf', "nuevos", '_ext' => 'pdf']) ?>
                                <li><?= $this->Html->link('Libro de ventas', ['controller' => 'Salesbooks', 'action' => 'createBook']) ?></li>
                            </ul>
                        </li>
                        <?php if($current_user['username'] == 'angel2703'): ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Migración <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><?= $this->Html->link('Tabla parentsandguardians', ['controller' => 'Miclients', 'action' => 'migrateClients']) ?>
                                    <li><?= $this->Html->link('Tabla sections', ['controller' => 'Sections', 'action' => 'addLot']) ?>
                                    <li><?= $this->Html->link('Tabla students', ['controller' => 'Mistudents', 'action' => 'migrateStudents']) ?>
                                    <li><?= $this->Html->link('Tabla bills', ['controller' => 'Mibills', 'action' => 'migrateBills']) ?>
                                    <li><?= $this->Html->link('Tabla concepts', ['controller' => 'Miconcepts', 'action' => 'migrateConcepts']) ?>
                                    <li><?= $this->Html->link('Tabla users', ['controller' => 'Miparentsandguardians', 'action' => 'migrateParentsandguardians']) ?>
                                    <li><?= $this->Html->link('Tabla reversar users', ['controller' => 'Miparentsandguardians', 'action' => 'reverseMigrate']) ?>
                                    <li><?= $this->Html->link('Diferencia agosto', ['controller' => 'Studenttransactions', 'action' => 'differenceAugust']) ?>
                                    <li><?= $this->Html->link('Ajustar servicio educativo', ['controller' => 'Mistudents', 'action' => 'fixService']) ?>
                                    <li><?= $this->Html->link('Corregir mensualidades', ['controller' => 'Mistudents', 'action' => 'arregloMensualidades']) ?>
                                    <li><?= $this->Html->link('Corregir matrículas', ['controller' => 'Mistudents', 'action' => 'arregloMatricula']) ?>
                                    <li><?= $this->Html->link('Corregir mensualidades 2', ['controller' => 'Mistudents', 'action' => 'arregloMensualidades2']) ?>
                                </ul>
                            </li>
                        <?php endif; ?>

                    <?php elseif($current_user['role'] == 'Representante'): ?>

                        <li><?=  $this->Html->link('Actualizar datos', ['controller' => 'Guardiantransactions', 'action' => 'homeScreen']) ?></li>

                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                       <?= $this->Html->link('Salir', ['controller' => 'Users', 'action' => 'logout']) ?>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="nav navbar-nav">
                    <li><?=  $this->Html->link('Inicio', ['controller' => 'Users', 'action' => 'login']) ?></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>