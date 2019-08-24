<?php 
    use Cake\Routing\Router;

	if (!(isset($billId))):
		$billId = "";
	endif;
	
	if (!(isset($vista))):
		$vista = "";
	endif;

	if (!(isset($numeroControl))):
		$numeroControl = "";
	endif;
	
	if (!(isset($indicadorImpresa))):
		$indicadorImpresa = 0;
	endif;
	
	if (!(isset($reimpresion))):
		$reimpresion = 0;
	endif;
	
?>
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
            <a href='/sistemasangabriel/users/home'><img src='/sistemasangabriel/files/schools/profile_photo/f0c3559c-c419-42ee-b586-e16819cf7416/logo1.png' width = 50 height = 60 class="img-thumbnail img-responsive logo"/></a>
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
                    <li><a href="#" id="imprimir-pantalla" class="glyphicon glyphicon-print iconoMenu" title="Imprimir pantalla"></a></li>
					<li><?=  $this->Html->link('', ['controller' => 'Users', 'action' => 'edit', $current_user['id']], ['class' => "glyphicon glyphicon-user iconoMenu", 'title' => 'Modificar mi perfil']) ?></li>
					<?php if($current_user['role'] == 'Administrador'): ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Administrativo <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><?= $this->Html->link('Abrir turno', ['controller' => 'Turns', 'action' => 'checkTurnOpen']) ?></li>
								<li><?= $this->Html->link('Cerrar turno', ['controller' => 'Turns', 'action' => 'checkTurnClose']) ?></li>
								<li><?= $this->Html->link('Histórico de turnos', ['controller' => 'Turns', 'action' => 'index']) ?></li>
								<li><?= $this->Html->link('Factura inscripción alumnos regulares', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Factura inscripción regulares']) ?></li> 
								<li><?= $this->Html->link('Factura inscripción alumnos nuevos', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Factura inscripción nuevos']) ?></li> 
								<li><?= $this->Html->link('Recibo inscripción alumnos regulares', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Recibo inscripción regulares']) ?></li>
								<li><?= $this->Html->link('Recibo inscripción alumnos nuevos', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Recibo inscripción nuevos']) ?></li>									
								<li><?= $this->Html->link('Cobrar mensualidades', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Mensualidades']) ?></li> 
								<li><?= $this->Html->link('Cartón de cuotas', ['controller' => 'Parentsandguardians', 'action' => 'consultCardboard']) ?></li> 
								<li><?= $this->Html->link('Tarifas', ['controller' => 'Rates', 'action' => 'index']) ?></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Representantes <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">    
								<li><?= $this->Html->link('Datos de familia', ['controller' => 'Parentsandguardians', 'action' => 'consultFamily']) ?></li>
								<li><?= $this->Html->link('Familias - alumnos', ['controller' => 'Students', 'action' => 'familyStudents']) ?></li>
								<li><?= $this->Html->link('Familias con tres hijos', ['controller' => 'Students', 'action' => 'familiasDescuento20']) ?></li>
								<li><?= $this->Html->link('Familias con cuatro o más hijos', ['controller' => 'Students', 'action' => 'familiasDescuento50']) ?></li> 
								<!-- <li><?= $this->Html->link('Resumen de alumnos por familia', ['controller' => 'Studenttransactions', 'action' => 'reportFamilyStudents']) ?></li> -->
								<li><?= $this->Html->link('Rubros padres y/o representantes', ['controller' => 'Parentsandguardians', 'action' => 'officeManager']) ?></li>	
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Alumnos <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">    
								<li><?= $this->Html->link('Registro básico de nuevos alumnos', ['controller' => 'Students', 'action' => 'registerNewStudents']) ?></li>
								<li><?= $this->Html->link('Datos de alumnos', ['controller' => 'Students', 'action' => 'consultStudent']) ?></li>
								<li><?= $this->Html->link('Alumnos con condición distinta a regular', ['controller' => 'Students', 'action' => 'consultStudentDelete']) ?></li>
								<li><?= $this->Html->link('Asignar sección', ['controller' => 'Studenttransactions', 'action' => 'assignSection']) ?></li>
								<li><?= $this->Html->link('Modificar las cuotas del alumno', ['controller' => 'Students', 'action' => 'modifyTransactions']) ?></li> 
								<li><?= $this->Html->link('Relación de mensualidades', ['controller' => 'Students', 'action' => 'listMonthlyPayments']) ?></li> 
								<li><?= $this->Html->link('Alumnos con mensualidades pendientes', ['controller' => 'Students', 'action' => 'defaulters']) ?></li> 
								<!-- <li><?= $this->Html->link('Pagos de nuevos alumnos', ['controller' => 'Students', 'action' => 'newstudentpdf', "nuevos", '_ext' => 'pdf']) ?></li> --> 
								<!-- <li><?= $this->Html->link('Alumnos inscritos', ['controller' => 'Studenttransactions', 'action' => 'reportStudentGeneral']) ?></li> -->            
								<li><?= $this->Html->link('Alumnos que no completaron en el proceso de inscripción', ['controller' => 'Students', 'action' => 'reportGraduateStudents']) ?></li>
								<li><?= $this->Html->link('Aplicar descuento a alumnos (familias con tres hijos)', ['controller' => 'Studenttransactions', 'action' => 'discountQuota20']) ?></li>
								<li><?= $this->Html->link('Aplicar descuento a alumnos (familias con cuatro o más hijos)', ['controller' => 'Studenttransactions', 'action' => 'discountQuota50']) ?></li>
								<li><?= $this->Html->link('Becar alumno', ['controller' => 'Students', 'action' => 'searchScholarship']) ?></li>
								<li><?= $this->Html->link('Alumnos Becados', ['controller' => 'Studenttransactions', 'action' => 'scholarshipIndex']) ?></li>
								<!-- <li><?= $this->Html->link('Reporte contacto alumnos', ['controller' => 'Students', 'action' => 'reportStudentsGeneral']) ?></li> -->
							</ul>
						</li>
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Contabilidad <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">    
								<li><?= $this->Html->link('Consultar factura', ['controller' => 'Bills', 'action' => 'consultBill']) ?></li>
								<li><?= $this->Html->link('Consultar de recibo', ['controller' => 'Bills', 'action' => 'consultarRecibo']) ?></li>
								<li><?= $this->Html->link('Consultar nota de crédito', ['controller' => 'Bills', 'action' => 'consultarNotaCredito']) ?></li>
								<li><?= $this->Html->link('Consultar nota de débito', ['controller' => 'Bills', 'action' => 'consultarNotaDebito']) ?></li>
								<li><?= $this->Html->link('Anular factura', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'Anular']) ?></li>
								<li><?= $this->Html->link('Crear nota contable', ['controller' => 'Turns', 'action' => 'checkTurnInvoice', 'NC']) ?></li>
								<li><?= $this->Html->link('Modificar lote de facturas', ['controller' => 'Controlnumbers', 'action' => 'edit']) ?></li>
								<li><?= $this->Html->link('Modificar el número control de facturas', ['controller' => 'Bills', 'action' => 'editControl']) ?></li>
								<li><?= $this->Html->link('Reporte de pagos', ['controller' => 'Studenttransactions', 'action' => 'reportePagos']) ?></li>
								<li><?= $this->Html->link('Reporte de Morosidad', ['controller' => 'Students', 'action' => 'morosidad']) ?></li>								
								<li><?= $this->Html->link('Crear libro de ventas EXCEL', ['controller' => 'Salesbooks', 'action' => 'createBookExcel']) ?></li>
								<li><?= $this->Html->link('Crear libro de recibos EXCEL', ['controller' => 'Salesbooks', 'action' => 'crearLibroRecibos']) ?></li>
							</ul>
						</li>
    
                        <!-- <?php if ($current_user['username'] == 'angel2703'): ?>
						
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Docentes <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">    
                                        <li><?= $this->Html->link('Secciones', ['controller' => 'Sections', 'action' => 'index']) ?></li>
                                        <li><?= $this->Html->link('Materias', ['controller' => 'Teachingareas', 'action' => 'index']) ?></li>
                                </ul>
                            </li>
						
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Nómina <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><?= $this->Html->link('Puestos de trabajo', ['controller' => 'Positions', 'action' => 'index']) ?></li>
                                    <li><?= $this->Html->link('Empleados', ['controller' => 'Employees', 'action' => 'index']) ?></li>
                                    <li><?= $this->Html->link('Nómina', ['controller' => 'Paysheets', 'action' => 'directPayroll']) ?></li>
                                </ul>
                            </li>

						<?php endif; ?> -->
						
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
<script>
	// Variables globales
	gVista = "<?= $vista ?>";
	gIdFactura = "<?= $billId ?>";
	gNumeroControl = "<?= $numeroControl ?>";
	gIndicadorImpresa = "<?= $indicadorImpresa ?>";
	gReimpresion = "<?= $reimpresion ?>";
	
	// Funciones
	
	function actualizarIndicadorImpresion(idFactura)
	{
		$.post("<?php echo Router::url(["controller" => "Bills", "action" => "actualizarIndicadorImpresion"]); ?>", 
			{ "idFactura" : gIdFactura }, null, "json")          
		.done(function(response) 
		{
			if (response.satisfactorio) 
			{
				window.location="<?php echo Router::url(["controller" => "Bills", "action" => "verificarFacturas"]); ?>";
			} 
			else 
			{
				alert("Estimado usuario no se pudo actualizar el indicador de impresión. Por favor verifique que esta factura se imprimió en el papel fiscal con número de control *** " + gNumeroControl + " ***");
				window.location="<?php echo Router::url(["controller" => "Bills", "action" => "retornoImpresion"]); ?>";
			}
		})
		.fail(function(jqXHR, textStatus, errorThrown) 
		{
				alert("Estimado usuario el servidor tardó en responder y posiblemente no se actualizó el indicador de impresión. Por favor verifique que esta factura se imprimió en el papel fiscal con número de control *** " + gNumeroControl + " ***");
				window.location="<?php echo Router::url(["controller" => "Bills", "action" => "retornoImpresion"]); ?>";
		});      
	}
	
	function imprimir() 
	{
		if (gVista == "invoice")
		{
			actualizarIndicadorImpresion(gIdFactura);
		}
	}

	// Eventos
	
    $(document).ready(function()
    {							
		$('#imprimir-pantalla').click(function(e){
			
			e.preventDefault();
					
			if (gVista == "invoice")
			{
				if (gIndicadorImpresa == 1)
				{
					if (gReimpresion == 1)
					{
						var r = confirm("Estimado usuario esta factura ya está impresa en papel fiscal con el Nro. de control *** " + gNumeroControl + " ***. Por favor verifique antes de continuar. Si está seguro de reimprimir pulse el botón ACEPTAR de lo contrario CANCELAR");
						if (r == false)
						{
							window.location="<?php echo Router::url(["controller" => "Bills", "action" => "retornoImpresion"]); ?>";
							return false;
						}
					}
					else
					{
						alert("Estimado usuario esta factura ya está impresa en papel fiscal con el Nro. de control *** " + gNumeroControl + " ***.");
						window.location="<?php echo Router::url(["controller" => "Bills", "action" => "retornoImpresion"]); ?>";
						return false;
					}
				}
				var r = confirm("Estimado usuario por favor coloque en la impresora el papel fiscal con el Nro. de control *** " + gNumeroControl + " ***.");
				if (r == false)
				{
					return false;
				}
			}
			window.print();
			return false;
		});
	});
</script>     