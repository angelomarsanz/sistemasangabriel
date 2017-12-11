<?php
    use Cake\Routing\Router; 
?>
<p>Factura:</p>
<p><?= $charge['nameParent'] ?></p>
<p><?= $charge['totalBalance'] ?></p>
<p><?= $charge['students'][0]['nameStudent'] ?></p>
<p><?= $charge['students'][1]['studentBalance'] ?></p>

<?php
// $obj = new stdClass();
// $obj = (object) ['pepito' => "Hijo de Pedro"];
$arreglo = ['pepito' => "Hijo de Jesús", "pepitona" => "Hija de María"];
$obj = (object) $arreglo;
echo $obj->pepito;
echo $obj->pepitona;
?>