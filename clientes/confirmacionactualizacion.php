<?php
	session_start();
if(isset($_SESSION['usuario'])){
echo'
<div class="cuerpo">
	<h3>Cliente <span>Actualizado</span></h3>
	<p>Los Campos requeridos han sido actualizados con &eacute;xito</p>
	<p class="p0">Los datos del cliente han cambiado por favor, verifique los resultados consultando los datos del cliente</p>
</div>';
}
?>