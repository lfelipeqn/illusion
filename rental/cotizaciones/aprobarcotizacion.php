<?php
	//session_start();
	include '../Connections/cnn.php';
    
if(isset($_SESSION['usuario'])){	
 $conect=mysql_select_db($rental_cnn,$cnn);
 $idproyecto=$_GET['seguimiento'];
 $idcotizacion=$_GET['cotizacion'];
 
 $sqlvalida="SELECT cotizacion.IdCotizacion, cotizacion.IdProyecto, cotizacion.estado 
 FROM cotizacion 
 WHERE cotizacion.IdProyecto =$idproyecto AND cotizacion.estado = 1";
 
 $cltvalida=mysql_query($sqlvalida,$cnn) or die(mysql_error());
 $total=mysql_num_rows($cltvalida);
 
 if($total>=1){
    echo '
        <div class="cuerpo">
            <h2><span>Cotizaci&oacute;n</span><b> NO APROBADA<b></h2>
            <p>El Proyecto seleccionado ya cuenta con una cotizacion aprobada</p>
            <p><b>No puede Continuar.</b> Solo puede haber 1 cotización aprobada para cada proyecto.</p>
        </div>';
 }else{
    $sqlaprueba="UPDATE cotizacion SET estado=1 WHERE cotizacion.IdCotizacion=".$idcotizacion;
    $cltaprueba=mysql_query($sqlaprueba,$cnn) or die(mysql_error());      
    mysql_close($cnn);
    echo '
        <div class="cuerpo">
		  <h2><span>Cotizaci&oacute;n</span> Aprobada</h2>
		  <p>Se ha aprobado la cotizaci&oacute;n n&uacute;mero: <b>'.$idcotizacion.'</b></p>
            <p>Por Favor, proceda con la asignaci&oacute;n del evento y registro de personal y detalles del Evento</p>
        </div>';   
 }
}
?>