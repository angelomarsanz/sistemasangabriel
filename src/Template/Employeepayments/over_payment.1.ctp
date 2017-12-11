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
<div>
	<?php $accountBlock = 0; ?>

    <?php foreach ($employeesFor as $employeesFors): ?>
    
        <?php if ($accountBlock == 2): ?>
        
            <div class='saltopagina' style='clear:both; width: 100%;'>

                <div style='width: 50%; float:left;'>
                    <p>Unidad Educativa San Gabriel Arcangel</p>
                    <p>Nómina: <?= $classification . ' ' . $fortnight . ' de ' . $month . ' ' . $year ?></p>

                </div>
                <div style='width: 50%; float:left;'>
                    <p>Unidad Educativa San Gabriel Arcangel</p>
                    <p>Nómina: <?= $classification . ' ' . $fortnight . ' de ' . $month . ' ' . $year ?></p>

                </div>
            </div>  
            <?php $accountBlock = 1; ?>

        <?php else: ?>
            
            <div style='clear:both; width: 100%;'>
                <div style='width: 50%; float:left;'>
                    <p>Unidad Educativa San Gabriel Arcangel</p>
                    <p>Nómina: <?= $classification . ' ' . $fortnight . ' de ' . $month . ' ' . $year ?></p>

                </div>
                <div style='width: 50%; float:left;'>
                    <p>Unidad Educativa San Gabriel Arcangel</p>
                    <p>Nómina: <?= $classification . ' ' . $fortnight . ' de ' . $month . ' ' . $year ?></p>

                </div>
            </div>
        
            <?php $accountBlock++; ?>

        <?php endif; ?>
    
    <?php endforeach; ?>
            
</div>
<div class="menumenos nover menu-menos">
    <p>
    <a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
    </p>
</div>
<div style="display:none;" class="menumas nover menu-mas">
    <p>
        <?= $this->Html->link(__(''), ['controller' => 'Paysheets', 'action' => 'edit', $idPaysheet, $classification], ['id' => 'volver', 'class' => 'glyphicon glyphicon-chevron-left btn btn-danger', 'title' => 'Volver']) ?>
        <?= $this->Html->link(__(''), ['controller' => 'Users', 'action' => 'wait'], ['id' => 'cerrar', 'class' => 'glyphicon glyphicon-remove btn btn-danger', 'title' => 'cerrar vista']) ?>
        <a href='#' onclick='myFunction()' id="imprimir" title="Imprimir" class='glyphicon glyphicon-print btn btn-danger'></a>
        <a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
    </p>
</div>
<script>
    function myFunction() 
    {
        window.print();
    }
    
    $(document).ready(function()
    {
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