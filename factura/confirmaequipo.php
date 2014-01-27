<?php
//session_start();
if(isset($_SESSION['usuario'])){
	$codigo=$_GET['seguimiento'];
echo '
<div class="cuerpo">
	<h3>Registro de <span>Equipos y Materiales</span></h3>
	<p>El Equipo ha sido ingresado al inventario de forma exitosa. 
	Para el seguimiento de este elemento se ha asignado el codigo: <b>'.$codigo.'</b> que puede ser consultado en la opci&oacute;n de consulta de inventarios.</p>
</div>';
}
?>