<?php

//session_start();
if(isset($_SESSION['usuario'])){

echo '
<div class="cuerpo">
		<h2><span>Finalizaci&oacute;n de </span> Evento</h2>
		<p>El Evento seleccionado ha sido finalizado correctamente, a partir de este momento, puede proceder con la generaci&oacute;n de la factura correspondiente.</p>
</div>';
}

?>