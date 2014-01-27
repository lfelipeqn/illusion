<?php

//session_start();
if(isset($_SESSION['usuario'])){

echo '
<div class="cuerpo">
		<h2><span>Salida a Mantenimiento</span> Registrada</h2>
		<p>El equipo seleccionado ha sido habilitado para mantenimiento, mientras se encuentre en este estado no podr&aacute; ser registrado en eventos. Para habilitar nuevamente el equipo, una vez finalizado el mantenimiento vaya a la opci&oacute;n de <b>Consulta de inventarios -> Entrada de Mantenimiento</b></p>
</div>';
}

?>