<?php
//session_start();
if(isset($_SESSION['usuario'])){
	$prod=$_GET['seguimiento'];
	$fecha=date("Y-m-d");
	$hora=date("H:i:s");
	include ('Connections/cnn.php');
	$connect=mysql_select_db($database_cnn,$cnn);
	
    $sqlvalida="SELECT orden_compra.IdEstadoOrden, orden_compra.IdProduccion, orden_compra.IdProveedor 
                                            FROM orden_compra 
                                            WHERE ((orden_compra.IdEstadoOrden = 2 OR orden_compra.IdEstadoOrden = 3) 
                                            AND orden_compra.IdProduccion='$prod')";
                                            $cltvalida=mysql_query($sqlvalida, $cnn) or die(mysql_error());
                                            $total=mysql_num_rows($cltvalida);
    if($total<1){
    
    $sqlactualiza="UPDATE produccion SET Finalizada=0, Aprobada=0, ValidaC=0, ValidaP=0 WHERE produccion.IdProduccion='".$prod."'";
	$cltact=mysql_query($sqlactualiza,$cnn) or die(mysql_error());
	if($cltact){
		$sqlaudita="INSERT INTO levantamiento_produccion(IdProduccion, FechaLevanta, HoraLevanta, UsuarioLevanta) VALUES ('$prod', '$fecha', '$hora', '".$_SESSION['usuario']."')";
		$auditar=mysql_query($sqlaudita,$cnn) or die(mysql_error());
		$sqldetalle="UPDATE orden_compra SET IdEstadoOrden=4 WHERE orden_compra.IdProduccion='".$prod."'";
		$cltcompra=mysql_query($sqldetalle,$cnn) or die(mysql_error());
		/*while($rscompra=mysql_fetch_assoc($cltcompra)){
			$borra2 = "Delete from detalle_compra where IdOrden='".$rscompra['IdOrden']."'";
			$eborra2=mysql_query($borra2,$cnn) or die(mysql_error());
		}
		$borra1 = "Delete from orden_compra where IdProduccion='".$prod."'";
		$eborra1=mysql_query($borra1,$cnn) or die(mysql_error());*/	
	}
    	echo '
        <div class="cuerpo">
    		<h3>Levantamiento de Cierre Hoja<span>de Producci&oacute;n</span></h3>
    		<p>La Hoja de Producci&oacute;n seleccionada ha sido desbloqueada y ahora se encuentra disponible para modificaciones.</p>
    		<p><b>Por Razones de Seguridad, todas las Ordenes de compra asociadas a la hoja de producci&oacute;n han sido Anuladas y deben ser creadas de nuevo<b></p>
    	</div>';
    }else{
        echo '
        <div class="cuerpo">
		  <h3>Levantamiento <span>NO REALIZADO</span></h3>
		  <p>La Hoja de Producci&oacute;n <b>NO HA SIDO LEVANTADA</b></p>
		  <p><b>Se identificaron Ordenes de Compra Radicadas y/o Pagadas, proceda a solucionar esta situaci&oacute;n e intente nuevamente.<b></p>
	    </div>';
    }
	mysql_close($cnn);
}
?>