<?php

//session_start();
if(isset($_SESSION['usuario'])){

echo '
<div class="cuerpo">
		<h2><span>Reingreso de </span> Equipos</h2>
		<p>Los Equipos registrados han sido registrados correctamente. A partir de este momento, los Equipos <b>SE ENCUENTRAN DISPONIBLES</b> para ser utilizados en otro evento.</p>
</div>';
}

?>