<?php
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
	<h3>Proceso <span>CRM</span></h3>
	<p>Diagrama de Flujo del Proceso de CRM de Illusion</p>
	<p class="p0"></p>
	</br>
	<div align="center"><img src="procesos/images/ProcesoCRM.png" alt="" /></div>
	<div><a href="inicio.php?location=procesos">Regresar</a></div>
</div>';
}
?>