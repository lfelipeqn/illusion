<?php

//session_start();
if(isset($_SESSION['usuario'])){

echo '
<div class="cuerpo">
		<h2><span>Concepto Adicional</span> Creado</h2>
		<p>El nuevo concepto adicional ha sido creado y ahora se encuentra disponible para ser utilizado en las cotizaciones</p>
</div>';
}

?>