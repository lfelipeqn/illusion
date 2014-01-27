<?php

//session_start();
if(isset($_SESSION['usuario'])){

echo '
<div class="cuerpo">
		<h2><span>Salida a Evento</span> Registrada</h2>
		<p>Los Equipos y Proveedores registrados en el evento seleccionado han sido registrados correctamente. A partir de este momento, los Equipos <b>NO SE ENCUENTRAN DISPONIBLES</b> para ser utilizados en otro evento hasta tanto no registre la entrada al almacen al finalizar el evento actual.</p>
</div>';
}

?>