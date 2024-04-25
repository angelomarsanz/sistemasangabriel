<h3>Reporte de Familias Relacionadas</h3>
<?php
$familiasListadas = []; ?>
<div name="reporte_familias_relacionadas" id="familias_relacionadas" class="container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th><b>Familia</b></th>
                <th><b>Datos</b></th>
                <th><b>Familia relacionada</b></th>
                <th><b>Datos relacionados</b></th>
            </tr>
        </thead>
        <tbody>				
            <?php
            foreach ($familiasRelacionadasControl as $control)
            {
                if (!(in_array($control->id, $familiasListadas)))
                {
                    $vectorFamiliasRelacionadas = json_decode($control->familias_relacionadas);
                    foreach ($vectorFamiliasRelacionadas as $idFamilia)
                    {
                        foreach ($familiasRelacionadasBusqueda as $busqueda)
                        {
                            if ($busqueda->id == $idFamilia)
                            { ?>
                                <tr>
                                    <td><?= $control->family ?></td>
                                    <td></td> 
                                    <td><?= $busqueda->family ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?= $control->type_of_identification_father."-".trim($control->identidy_card_father); ?></td> 
                                    <td></td>
                                    <td><?= $busqueda->type_of_identification_father."-".trim($busqueda->identidy_card_father);  ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?= trim($control->first_name_father)." ".trim($control->second_name_father)." ".trim($control->surname_father)." ".trim($control->second_surname_father); ?></td> 
                                    <td></td>
                                    <td><?= trim($busqueda->first_name_father)." ".trim($busqueda->second_name_father)." ".trim($busqueda->surname_father)." ".trim($busqueda->second_surname_father); ?></td>
                                </tr>
                                    <td></td>
                                    <td><?= $control->type_of_identification_mother.trim($control->identidy_card_mother); ?></td> 
                                    <td></td>
                                    <td><?= $busqueda->type_of_identification_mother.trim($busqueda->identidy_card_mother); ?></td>
                                </tr>
                                </tr>
                                    <td></td>
                                    <td><?= trim($control->first_name_mother)." ".trim($control->second_name_mother)." ".trim($control->surname_mother)." ". trim($control->second_surname_mother); ?></td> 
                                    <td></td>
                                    <td><?= trim($busqueda->first_name_mother)." ".trim($busqueda->second_name_mother)." ".trim($busqueda->surname_mother)." ". trim($busqueda->second_surname_mother); ?></td>
                                </tr>
                                <?php
                                $familiasListadas[] = $idFamilia;
                            }
                        }
                    }
                }
            } ?>
        </tbody>
    </table>
</div>