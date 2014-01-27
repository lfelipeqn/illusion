<?php
    session_start();
    if(isset($_SESSION['usuario'])){
	   include ('../../Connections/cnn.php');
       include ('../../funciones.php');
	   $conexion=mysql_select_db($rental_cnn,$cnn);
       $evento=$_POST['nevento'];
       $femision=date('Y-m-d');
       $fvencimiento=date("Y-m-d",strtotime($_POST['fvencimiento']));
       $obs=strtoupper($_POST['observaciones']);
       $sqlfact="INSERT INTO facturas (IdEvento, FechaEmision, FechaVencimiento, Observaciones) VALUES ('$evento', '$femision', '$fvencimiento', '$obs')";
       $cltfact=mysql_query($sqlfact,$cnn) or die(mysql_error());
       $factura=mysql_insert_id();
       
       $sqlvalores="SELECT vw_eventos.IdEvento, vw_eventos.ValorEvento FROM vw_eventos WHERE vw_eventos.IdEvento=$evento";
       $cltvalores=mysql_query($sqlvalores,$cnn) or die(mysql_error());
       $rsvalores=mysql_fetch_assoc($cltvalores);
       
       $sqlactvalor="UPDATE facturas SET Subtotal='".$rsvalores['ValorEvento']."', Impuesto='".$rsvalores['ValorEvento']*0.16."', Total='".$rsvalores['ValorEvento']*1.16."' WHERE facturas.IdFactura=".$factura;
       $cltactvalor=mysql_query($sqlactvalor,$cnn) or die(mysql_error());
       
       if($cltactvalor){
            header("Location: ../rental.php?location=factcreada");
       }
       
    }   
?>