<?php
    use Cake\I18n\Time;
?>
<style>
@media screen
{
    .noVerPantalla
    {
      display:none
    }
}
@media print
{
    .noVerImpreso
    {
      display:none
    }
}
</style>
<?php 
  if ($controlador == "Users" && $accion == "home"):
    include 'contrato_representante_'.$anioFirmarContrato.'.ctp';
  elseif ($controlador == null && $accion == null):
    include 'contrato_representante_'.$anioFirmarContrato.'.ctp';
  else:
    include 'contrato_representante_'.$anioContratoFirmado.'.ctp';
  endif;
?>