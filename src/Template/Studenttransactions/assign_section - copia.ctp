<?php
    use Cake\Routing\Router;
?>
<style>
@media screen
{
    .volver 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 50px;
        opacity: 0.5;
    }
    .cerrar 
    {
        display:scroll;
        position:fixed;
        top: 15%;
        left: 95px;
        opacity: 0.5;
    }
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
    <div class="col-md-8">
    	<div class="page-header">
	        <h3>Asignar sección</h3>
        </div>
        <?php if (isset($studentsLevel)): ?>
        	<div>
        		<h4>Grado: <?= $level ?> </h4>
                <?= $this->Form->create() ?>
                    <fieldset>
                    	<div class="table-responsive">
                    		<table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Nro.</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Abono a matrícula</th>
                                        <th scope="col">Sección</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $accountArray = 0; ?>
                                    <?php $accountStudent = 1; ?>
                                    <?php foreach ($studentsLevel as $studentsLevels): ?>
                                        <tr>
                                            <td><input type="hidden" name="student[<?= $accountArray ?>][id]" value=<?= $studentsLevels->student->id ?>></td>
                                            <td><?= $accountStudent ?></td>
                                            <td><?= $studentsLevels->student->full_name ?></td>
                                            <td style="text-align: center;"><?= number_format(($studentsLevels->amount - $studentsLevels->amount), 2, ",", ".") ?></td>
                                            <td><select name="student[<?= $accountArray ?>][section]" class="section">
                                                <?php if ($studentsLevels->student->section->section == 'A'): ?>
                                                    <option value="A" selected>A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                <?php elseif ($studentsLevels->student->section->section == 'B'): ?>
                                                    <option value="A">A</option>
                                                    <option value="B" selected>B</option>
                                                    <option value="C">C</option>
                                                <?php elseif ($studentsLevels->student->section->section == 'C'): ?>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C" selected>C</option>
                                                <?php else: ?>
                                                    <option value="A" selected>A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                <?php endif; ?> 
                                                </select>
                                            </td>
                                        </tr>
                                    <?php $accountArray++; ?> 
                                    <?php $accountStudent++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>   
                    <p>Alumnos asignados a la sección A: <spam id="A"><?= $sectionA ?></spam></p>
                    <p>Alumnos asignados a la sección B: <spam id="B"><?= $sectionB ?></spam></p>
                    <p>Alumnos asignados a la sección C: <spam id="C"><?= $sectionC ?></spam></p>
                    <p>Total alumnos inscritos en <?= $level ?>: <?= $totalLevel ?></p>
                    <p>Total general alumnos inscritos para este año escolar: <?= $totalEnrolled ?></p>
                    <div class="menumenos nover menu-menos">
                        <p>
                        <a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
                        </p>
                    </div>
                    <div style="display:none;" class="menumas nover menu-mas">
                        <p>
                            <a href="../users/wait" id="volver" title="Volver" class='glyphicon glyphicon-chevron-left btn btn-danger'></a>
                            <a href="../users/wait" id="cerrar" title="Cerrar vista" class='glyphicon glyphicon-remove btn btn-danger'></a>
                            <a href='#' id="guardar" title="Guardar" onclick="$(this).closest('form').submit()" class='glyphicon glyphicon-floppy-disk btn btn-danger'></a>
                            <a href='#' id="initialize" title="Asignar alumnos a sección" class='glyphicon glyphicon-font btn btn-danger'></a>
                            <a href=<?= '../studenttransactions/reportLevel/' . $levelChat ?> id="printer-section" title="Imprimir" class='glyphicon glyphicon-print btn btn-danger'></a>
                            <a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
                        </p>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        <?php else: ?>
            <div class="menumenos nover menu-menos">
                <p>
                <a href="#" id="mas" title="Más opciones" class='glyphicon glyphicon-plus btn btn-danger'></a>
                </p>
            </div>
            <div style="display:none;" class="menumas nover menu-mas">
                <p>
                    <a href="../users/wait" id="volver" title="Volver" class='glyphicon glyphicon-chevron-left btn btn-danger'></a>
                    <a href="../users/wait" id="cerrar" title="Cerrar vista" class='glyphicon glyphicon-remove btn btn-danger'></a>
                    <a href='#' id="menos" title="Menos opciones" class='glyphicon glyphicon-minus btn btn-danger'></a>
                </p>
            </div>
        <?php endif; ?>   
    </div>
</div>
<script>
    function changeSection()
    {
        var sectionA = 0;
        var sectionB = 0;
        var sectionC = 0;
        
        $('#printer-section').attr('href', "#");        

        $('.section').each(function()
        {
            if ($(this).val() == "A")
            {
                sectionA++;
            }
            else if ($(this).val() == "B")
            {
                sectionB++;                
            }
            else 
            {
                sectionC++;                
            }
        });
        $("#A").html(sectionA);
        $("#B").html(sectionB);
        $("#C").html(sectionC);
    }
    function redirectAction()
    {
		$.redirect('<?php echo Router::url(["controller" => "studenttransactions", "action" => "assignSection"]); ?>', { level : $("#select-level").val() }); 
    }

    $(document).ready(function() 
    {
        $(".section").change(changeSection);
        $('#initialize').click(function(e) 
        {
            e.preventDefault();
            $(".section").html("<option value='A' selected>A</option><option value='B'>B</option><option value='C'>C</option>");
            changeSection();
        });
        $("#select-level").change(redirectAction());
        $("#printer-section").click(function(e)
        {
            if ($("#printer-section").attr("href") == "#")
            {
                alert("Por favor primero guarde los cambios y después pulse nuevamente imprimir");
            }
        });
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