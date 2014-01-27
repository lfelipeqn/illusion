<?php
	//session_start();
if(isset($_SESSION['usuario'])){
echo'
<div class="cuerpo">
	<h3>Proveedor <span>Actualizado</span></h3>
	<p>Los Campos requeridos han sido actualizados con &eacute;xito</p>
	<p>Los datos del proveedor han cambiado por favor, verifique los resultados consultando los datos del proveedor</p>
</div>';
}
?>