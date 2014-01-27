<?php
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
	<h3>Proceso <span>Hoja de negocios</span></h3>
	<p>Diagrama de Flujo del Proceso de creaaci&oacute;n de Hoja de Negocios de Illusion</p>
	<p class="p0"></p>
	</br>
	<div align="center"><img src="Procesos/images/procesoNegocios.png" alt="" /></div>
	<div><a href="inicio.php?location=procesos">Regresar</a></div>
</div>';
}
?>