<p>Pruebas Generales</p>
<?php
if ($recibosConsejoEducativo->count() == 0)
{ 
    echo '<p>No se encontró recibo</p>';
}
else
{
    foreach ($recibosConsejoEducativo as $recibo)
    {
        echo 'Id factura '.$recibo->bill_id;
    }
}
?>