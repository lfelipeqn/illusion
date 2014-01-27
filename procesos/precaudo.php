<?php
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
	<h3>Proceso de <span>Recaudo</span></h3>
	<p>Diagrama de Flujo del Proceso de Recaudo de Illusion</p>
	<p class="p0"></p>
	</br>
	<div align="center"><img src="Procesos/images/procesoRecaudo.png" alt="" /></div>
	<div><a href="inicio.php?location=procesos">Regresar</a></div>
</div>';
}
?>