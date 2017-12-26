<br />
<br />
<br />

<?php

$path = WWW_ROOT.'pdf';

$directorio = dir($path);

while ($archivo = $directorio->read())
{
	if ($archivo != '' || $archivo != '..')
	{
		if (strtolower(substr($archivo, -3) == 'pdf'))
		{
//			echo $archivo;

			echo $this->Html->link(__($archivo), $path, ['title' => 'Ver libro', 'target' => '_blank']);

			}
	}
}
$directorio->close();

?>
<?php

/*

$d = dir(WWW_ROOT.'pdf');
echo "Handle: " . $d->handle . "\n";
echo "Path: " . $d->path . "\n";

while (false !== ($entry = $d->read())) {
   echo $entry."\n";
}

$d->close();

*/

?>