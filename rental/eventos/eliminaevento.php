<?php
//session_start();
if(isset($_SESSION['usuario'])){	
	include ('../Connections/cnn.php');
	$connect=mysql_select_db($rental_cnn,$cnn);
    
    $evento=$_GET['codigo'];
    
    $libre="UPDATE inventario SET inventario.IdEstado=1 WHERE inventario.Codigo IN (SELECT eventos_detalle.Codigo FROM eventos_detalle WHERE eventos_detalle.IdEvento =".$evento.")";
    $cltlibre=mysql_query($libre,$cnn) or die(mysql_error());
    	
	$borra1 = "Delete from eventos where IdEvento=$evento";
	$borra2 = "Delete from eventos_detalle where IdEvento=$evento";
    $borra3 = "Delete from eventos_proveedores where IdEvento=$evento";
    $borra4 = "Delete from eventos_conceptos where IdEvento=$evento";
	$eborra1=mysql_query($borra1,$cnn) or die(mysql_error());
	$eborra2=mysql_query($borra2,$cnn) or die(mysql_error());
    $eborra3=mysql_query($borra3,$cnn) or die(mysql_error());    
    $eborra4=mysql_query($borra4,$cnn) or die(mysql_error());
	
    echo '
	<div class="cuerpo">
		<h3><span>Eliminaci&oacute;n de </span>Eventos</h3>
		<p>La Informaci&oacute;n Asociada al Evento seleccionado ha sido eliminada en su totalidad</p>
		<p>A partir del momento, los datos del evento seleccionado no estar&aacute;n disponibles para uso dentro del sistema. Si Lo Desea Puede crear nuevamente el Evento</p>
        <p>Los Equipos asociados al evento eliminado se han liberado y ahora se encuentran <b>DISPONIBLES</b></p>
</div>';
	mysql_close($cnn);
}

?>