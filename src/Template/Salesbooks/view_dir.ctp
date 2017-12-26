<div class="row">
    <div class="col-md-12">
    	<div class="page-header">
     	    <h2>Listado de libros de ventas en PDF</h2>
    	</div>
		<?php

		$path = WWW_ROOT.'pdf';

		$directorio = dir($path);

		while ($archivo = $directorio->read())
		{
			if ($archivo != '' || $archivo != '..')
			{
				if (strtolower(substr($archivo, -3) == 'pdf'))
				{
					echo $this->Html->link(__($archivo), '/pdf/' . $archivo, ['title' => 'Ver libro', 'target' => '_blank']);
					echo '<br />';

					}
			}
		}
		$directorio->close();

		?>
	</div>
</div>