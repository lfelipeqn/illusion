<?php
session_start();
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
	<h3>Hoja de Producci&oacute;n <span>NO VALIDADA</span></h3>
	<p>La Hoja de producci&oacute;n seleccionada <b>NO HA SIDO VALIDADA</b>.</p>
	<p class="p0">Alguno de los usuarios utilizados para la validaci&oacute;n no est&aacute; involucrado en el proceso. Antes de validar, por favor verifique que el usuario comercial es <b>quien dise&ntilde;&oacute; el presupuesto</b>, as&iacute; mismo, verifique que el usuario del Productor corresponda al responsable del proceso de producci&oacute;n de este negocio o <b>productor Asignado</b>.</p>
</div>';
}
?>