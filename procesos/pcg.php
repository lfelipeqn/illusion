<?php
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
	<h3>Proceso Orden de Compra y <span>Gastos Internos</span></h3>
	<p>Diagrama de Flujo del Proceso de Compra y Gastos Internos de Illusion</p>
	</br>
	<div align="center"><img src="procesos/images/ProcesoCG.png" heigth="490px"/></div>
	<div><a href="inicio.php?location=procesos">Regresar</a></div>
</div>';
}
?>