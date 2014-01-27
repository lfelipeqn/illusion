<?php
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
	<h3>Proceso <span>Comercial</span></h3>
	<p>Diagrama de Flujo del Proceso comercial de Illusion</p>
	</br>
	<div align="center"><img src="procesos/images/ProcesoComercial.png"/></div>
	<div><a href="inicio.php?location=procesos">Regresar</a></div>
</div>';
}
?>