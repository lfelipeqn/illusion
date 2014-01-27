<?php

//session_start();
if(isset($_SESSION['usuario'])){

echo '
<div class="cuerpo">
		<h2><span>Faltan </span> Equipos</h2>
		<p>Los Equipos registrados <b>NO COINCIDEN CON LOS EQUIPOS QUE SALIERON AL EVENTO</b>. Al Parecer, faltan equipos con respecto a los que se registraron en el Momento de la Salida al Evento. Para continuar, debe registrar <b>TODOS</b> los equipos que fueron retirados. <b>Se ha Enviado una Notificaci&oacute;n con los Equipos Faltantes a la Gerencia</b></p>
</div>';
}

?>