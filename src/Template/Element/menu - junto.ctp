<style>
    .iconoMenu
    {
        padding-left: 10px;
        color: #9494b8;
        font-size: 150%;
    }
    .logo
    {
        padding: 1px;
        margin: 1px;
        border: 0;
        background-color: #b3e0ff;
     }
</style>
<nav class="navbar navbar-default navbar-fixed-top" style="background-color: #b3e0ff;">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href='../users/home'><img src='../files/schools/profile_photo/f0c3559c-c419-42ee-b586-e16819cf7416/logo1.png' width = 50 height = 60 class="img-thumbnail img-responsive logo"/></a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php if(isset($current_user)): ?>
                <ul class="nav navbar-nav">
                    <li><?=  $this->Html->link('', ['controller' => 'Users', 'action' => 'home'], ['class' => "glyphicon glyphicon-home iconoMenu", 'title' => 'Inicio']) ?></li>
                    <?php if($current_user['role'] == 'Administrador'): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Administrativo <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><?= $this->Html->link('Abrir turno', ['controller' => 'Turns', 'action' => 'checkTurnOpen']) ?></li>
                                <li><?= $this->Html->link('Cerrar turno', ['controller' => 'Bills', 'action' => 'editControlTurn']) ?></li>
                                <li><?= $this->Html->link('Cobrar inscripción alumnos regulares 2017-2018', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Inscripción regulares']) ?></li> 
                                <li><?= $this->Html->link('Cobrar inscripción alumnos nuevos 2017-2018', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Inscripción nuevos']) ?></li> 
                                <li><?= $this->Html->link('Cobrar servicio educativo 2017', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Servicio educativo']) ?></li> 
                                <li><?= $this->Html->link('Cobrar mensualidades 2017-2018', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Mensualidades']) ?></li> 
                                <li><?= $this->Html->link('Imprimir cartón de cuotas', ['controller' => 'Parentsandguardians', 'action' => 'consultCardboard']) ?></li> 
                                <li><?= $this->Html->link('Datos de familia', ['controller' => 'Parentsandguardians', 'action' => 'consultFamily']) ?></li>
                                <li><?= $this->Html->link('Datos de alumnos', ['controller' => 'Students', 'action' => 'consultStudent']) ?></li>
                                <li><?= $this->Html->link('Anular factura', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Anular']) ?></li>
                                <li><?= $this->Html->link('Registro básico de nuevos alumnos', ['controller' => 'Students', 'action' => 'registerNewStudents']) ?></li>
                                <li><?= $this->Html->link('Modificar las cuotas del alumno', ['controller' => 'Students', 'action' => 'modifyTransactions']) ?></li>
                                <li><?= $this->Html->link('Relación de mensualidades', ['controller' => 'Students', 'action' => 'listMonthlyPayments']) ?></li>
                                <li><?= $this->Html->link('Reporte de pagos nuevos alumnos', ['controller' => 'Students', 'action' => 'newstudentpdf', "nuevos", '_ext' => 'pdf']) ?>
                                <li><?= $this->Html->link('Becar alumno', ['controller' => 'Students', 'action' => 'searchScholarship']) ?></li>
                                <li><?= $this->Html->link('Reporte de becados', ['controller' => 'Students', 'action' => 'scholarshipIndex']) ?></li>
                                <li><?= $this->Html->link('Asignar sección', ['controller' => 'Studenttransactions', 'action' => 'assignSection']) ?></li>
                                <li><?= $this->Html->link('Reporte de alumnos inscritos', ['controller' => 'Studenttransactions', 'action' => 'reportStudentGeneral']) ?></li>
                                <li><?= $this->Html->link('Reporte de alumnos egresados', ['controller' => 'Students', 'action' => 'reportGraduateStudents']) ?></li>
                                <li><?= $this->Html->link('Reporte de alumnos por familia', ['controller' => 'Studenttransactions', 'action' => 'reportFamilyStudents']) ?></li>
                                <li><?= $this->Html->link('Reporte de familias con tres hijos', ['controller' => 'Studenttransactions', 'action' => 'discountFamily80']) ?></li>
                                <li><?= $this->Html->link('Reporte de familias con cuatro o más hijos', ['controller' => 'Studenttransactions', 'action' => 'discountFamily50']) ?></li>
                                <li><?= $this->Html->link('Aplicar descuento a familias con tres hijos', ['controller' => 'Studenttransactions', 'action' => 'discountQuota80']) ?></li>
                                <li><?= $this->Html->link('Rubros padres y/o representantes', ['controller' => 'Parentsandguardians', 'action' => 'officeManager']) ?></li>
                                <li><?= $this->Html->link('Tarifas', ['controller' => 'Rates', 'action' => 'index']) ?></li>
                                <li><?= $this->Html->link('Agregar lote de facturas', ['controller' => 'Controlnumbers', 'action' => 'edit']) ?></li>
                                <li><?= $this->Html->link('Modificar el número control de facturas', ['controller' => 'Bills', 'action' => 'editControl']) ?></li>
                                <li><?= $this->Html->link('Libro de ventas', ['controller' => 'Salesbooks', 'action' => 'createBookPdf']) ?></li>
<!--
                                <li><?= $this->Html->link('Registro completo de nuevos alumnos', ['controller' => 'Students', 'action' => 'newRegistration']) ?></li>
                                <li><?= $this->Html->link('Libro de ventas', ['controller' => 'Salesbooks', 'action' => 'createBookExcel']) ?></li>
                                <li><?=  $this->Html->link('Matrícula', ['controller' => 'Students', 'action' => 'guardian']) ?></li> 
                                <li><?= $this->Html->link('Crear sección', ['controller' => 'Sections', 'action' => 'add']) ?></li>
                                <li><?= $this->Html->link('Padres o representante', ['controller' => 'Parentsandguardians', 'action' => 'index']) ?></li>
                                <li><?= $this->Html->link('Secciones', ['controller' => 'Sections', 'action' => 'index']) ?></li>
                                <li><?= $this->Html->link('Área de enseñanza', ['controller' => 'Teachingareas', 'action' => 'index']) ?></li>
                                <li><?= $this->Html->link('Reporte de alumnos inscritos', ['controller' => 'Studenttransactionss', 'action' => 'registrationReport']) ?></li>
                                <li><?= $this->Html->link('Reporte de secciones', ['controller' => 'Studenttransactions', 'action' => 'searchSections']) ?></li>
                                <li><?= $this->Html->link('Descuentos cuotas', ['controller' => 'Studenttransactions', 'action' => 'discountQuota80']) ?></li>
-->
                            </ul>
                        </li>
                        <?php if($current_user['username'] == 'angel2703'): ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Nómina <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><?= $this->Html->link('Puestos de trabajo', ['controller' => 'Positions', 'action' => 'index']) ?></li>
                                    <li><?= $this->Html->link('Secciones', ['controller' => 'Sections', 'action' => 'index']) ?></li>
                                    <li><?= $this->Html->link('Materias', ['controller' => 'Teachingareas', 'action' => 'index']) ?></li>
                                    <li><?= $this->Html->link('Empleados', ['controller' => 'Employees', 'action' => 'index']) ?></li>
                                    <li><?= $this->Html->link('Nómina', ['controller' => 'Paysheets', 'action' => 'edit']) ?></li>
<!--
                                    <li><?= $this->Html->link('Crear nómina', ['controller' => 'Paysheets', 'action' => 'createPayrollFortnight']) ?></li>
                                    <li><?= $this->Html->link('Ver datos nómina', ['controller' => 'Paysheets', 'action' => 'viewFortnight']) ?></li>
                                    <li><?= $this->Html->link('Imprimir nómina', ['controller' => 'Paysheets', 'action' => 'printFortnight']) ?></li>
-->
                                </ul>
                            </li>
                            <?php if (isset($currentView)): ?>
                                <?php if ($currentView == 'employeepaymentsCompleteData'): ?>
                                    <form class="navbar-form navbar-left" role="search">
                                        <div class="form-group">
                                            
                                            <select id='classification' class='form-control'>
                                                <option value='01'>Bachillerato y deporte</option>
                                                <option value='02'>Primaria</option>
                                                <option value='03'>Pre-escolar</option>
                                                <option value='04'>Administrativo y obrero</option>
                                                <option value='05'>Directivo</option>
                                            </select>
    
                                            <select id='fortnight' class='form-control'>
                            	                <option value='1'>1ra. Quincena</option>
                            	                <option value='2'>2da. Quincena</option>
                                            </select>
    
                                            <select id='month' class='form-control'>
                        	                    <option value='01'>Enero</option>
                        	                    <option value='02'>Febrero</option>
                        	                    <option value='03'>Marzo</option>
                        	                    <option value='04'>Abril</option>
                        	                    <option value='05'>Mayo</option>
                        	                    <option value='06'>Junio</option>
                        	                    <option value='07'>Julio</option>
                        	                    <option value='08'>Agosto</option>
                        	                    <option value='09'>Septiembre</option>
                        	                    <option value='10'>Octubre</option>
                        	                    <option value='11'>Noviembre</option>
                        	                    <option value='12'>Diciembre</option>
                                            </select>
    
                                            <select id='year' class='form-control'>
                        	                    <option value='2017'>2017</option>
                        	                    <option value='2018'>2018</option>
                        	                    <option value='2019'>2019</option>
                                            </select>
                                        </div>
                                        <button type="submit" id="search-fortnight" class="glyphicon glyphicon-search btn btn-default navbar-btn" style="margin: 4px;"></button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                            <!-- <li class="dropdown">
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
                            </li> -->
                        <?php endif; ?>
                        <?php if (isset($assign)): ?>
                            <form class="navbar-form navbar-left" role="search">
                                <div class="form-group">
                                    <select id="select-level" name="level_of_study" class="form-control">
                                        <option value=null>Seleccione el grado </option>
                                        <option value=''>Alumnos sin datos actualizados </option>
                                        <option value="Pre-escolar, pre-kinder">Pre-escolar, pre-kinder</option>                                
                                        <option value='Pre-escolar, kinder'>Pre-escolar, kinder</option>
                                        <option value='Pre-escolar, preparatorio'>Pre-escolar, preparatorio</option>
                                        <option value='Primaria, 1er. grado'>Primaria, 1er. grado</option>
                                        <option value='Primaria, 2do. grado'>Primaria, 2do. grado</option>
                                        <option value='Primaria, 3er. grado'>Primaria, 3er. grado</option>
                                        <option value='Primaria, 4to. grado'>Primaria, 4to. grado</option> 
                                        <option value='Primaria, 5to. grado'>Primaria, 5to. grado</option> 
                                        <option value='Primaria, 6to. grado'>Primaria, 6to. grado</option>
                                        <option value='Secundaria, 1er. año'>Secundaria, 1er. año</option>
                                        <option value='Secundaria, 2do. año'>Secundaria, 2do. año</option>
                                        <option value='Secundaria, 3er. año'>Secundaria, 3er. año</option>
                                        <option value='Secundaria, 4to. año'>Secundaria, 4to. año</option>
                                        <option value='Secundaria, 5to. año'>Secundaria, 5to. año</option>
                                    </select>
                                </div>
                            </form>
                        <?php endif; ?>
                    <?php elseif($current_user['role'] == 'Representante'): ?>
                        <li><?=  $this->Html->link('Actualizar datos', ['controller' => 'Guardiantransactions', 'action' => 'homeScreen']) ?></li>
                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?= $this->Html->link('', ['controller' => 'Users', 'action' => 'logout'], ['class' => "glyphicon glyphicon-log-out iconoMenu", 'title' => 'Salir del sistema']) ?>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>