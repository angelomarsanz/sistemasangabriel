<h3>testFunction</h3>
<?php
/*
if ($transaccion->respaldo_registro === null)
{
    echo "<br />El campo tiene valor null";
}
else
{
    $transaccion_objeto = json_decode($transaccion, true);
    echo "<br />El campo tiene el valor<br />"; ?>
    <pre>
        <?php var_dump($transaccion_objeto) ?>
    </pre>
    <br />
} 
*/ 
echo "<br />Transacción encontrada<br />"; 
debug($transaccion);
$vector_transaccion = $transaccion->toArray();
echo "<br />vector_transaccion<br />"; 
debug($vector_transaccion);
$vector_respaldo = json_decode($transaccion->respaldo_registro, true); 
echo "<br />vector_respaldo<br />";
debug($vector_respaldo);
foreach ($vector_transaccion as $columna => $valor) 
{
    if (isset($vector_respaldo['transaccion'][$columna]))
    {
        $transaccion->$columna = $vector_respaldo['transaccion'][$columna];
    }
}
echo "<br />Transaccion restaurada<br />"; 
debug($transaccion);
?>