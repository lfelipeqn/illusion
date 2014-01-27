<?php
//session_start();
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
		<h2><span>Evento </span>Registrado</h2>
		<p>El Evento ha sido registrado exitosamente, Ahora es posible realizar el alistamiento de materiales para el despacho correspondiente</p>
</div>';
}
?>