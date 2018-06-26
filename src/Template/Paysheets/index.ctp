<style>
@media screen
{
    .menumenos
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .menumas 
    {
        display:scroll;
        position:fixed;
        bottom: 5%;
        right: 1%;
        opacity: 0.5;
        text-align: right;
    }
    .noverScreen
    {
      display:none
    }
}
@media print 
{
    .nover 
    {
      display:none
    }
    .saltopagina
    {
        display:block; 
        page-break-before:always;
    }
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
			<h2>Nóminas encontradas</h2>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Categoría</th>
						<th scope="col">Nombre</th>
						<th scope="col">Desde</th>
						<th scope="col">Hasta</th>
                        <th scope="col" class="actions"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($paysheets as $paysheet): ?>
                    <tr>
                        <td><?= h($paysheet->positioncategory->description_category) ?></td>
						<td><?= h($paysheet->payroll_name) ?></td>
						<td><?= $paysheet->date_from->format('d-m-Y') ?></td>
						<td><?= $paysheet->date_until->format('d-m-Y') ?></td>
                        <td class="actions">
                            <?= $this->Html->link('', ['controller' => 'Paysheets', 'action' => 'editPayrollFortnight', $paysheet->id], ['class' => 'glyphicon glyphicon-eye-open btn btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ver nómina']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="menumenos nover menu-menos">
	<p>
	<a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
	</p>
</div>
<div style="display:none;" class="menumas nover menu-mas">
	<p>
		<?= $this->Html->link(__(''), ['controller' => 'Paysheets', 'action' => 'edit'], ['id' => 'volver', 'class' => 'glyphicon glyphicon-chevron-left btn btn-danger', 'title' => 'Volver']) ?>
		<?= $this->Html->link(__(''), ['controller' => 'Users', 'action' => 'wait'], ['id' => 'cerrar', 'class' => 'glyphicon glyphicon-remove btn btn-danger', 'title' => 'cerrar vista']) ?>
		<a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
	</p>
</div> 
<script>
    $(document).ready(function()
    { 		
		$('[data-toggle="tooltip"]').tooltip();
        
		$('#mas').on('click',function()
        {
            $('.menu-menos').hide();
            $('.menu-mas').show();
        });
        
        $('#menos').on('click',function()
        {
            $('.menu-mas').hide();
            $('.menu-menos').show();
        });
	});
</script>