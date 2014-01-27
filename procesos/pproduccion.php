<?php
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
	<h3>Proceso <span>Producci&oacute;n</span></h3>
	<p>Diagrama de Flujo del Proceso de Creaci&oacute;n de Hoja de Producci&oacute;n de Illusion</p>
	<p class="p0"></p>
	</br>
	<div align="center"><img src="Procesos/images/ProcesoProduccion.png" alt="" /></div>
	<div><a href="inicio.php?location=procesos">Regresar</a></div>
</div>';
}
?>