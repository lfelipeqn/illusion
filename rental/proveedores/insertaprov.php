<?php
	session_start();
if(isset($_SESSION['usuario'])){
	include('../../Connections/cnn.php');
	include('../../funciones.php');
	$idproveedor=$_POST['nnit'];
	$fecha=date('Y-m-d');
	$conect=mysql_select_db($rental_cnn,$cnn);

	$str="INSERT INTO proveedores (Identificacion, DV, Fecha, TipoIdentificacion, NombreComercial, NombreProveedor, Ciudad, Pais, Direccion, Fax, Telefono, Correo, Actividad, Representante, IdentRep, IdTipoProveedor, IdPago, IVA, ReteIva, ReteIca, ReteFte, NombreCheque, Cuenta, TipoCuenta, Entidad, Contacto, IdPlazo, Descuento, Observaciones) VALUES ('".$idproveedor."','".$_POST['ndv']."','".$fecha."','".$_POST['tipoi']."','".strtoupper($_POST['ncomercial'])."','".strtoupper($_POST['nproveedor'])."','".strtoupper($_POST['nciudad'])."','".strtoupper($_POST['npais'])."','".$_POST['ndir']."','".$_POST['npfax']."','".$_POST['ntel']."','".$_POST['ncorreo']."','".strtoupper($_POST['nactiv'])."','".strtoupper($_POST['nrepl'])."','".$_POST['ncc']."','".$_POST['ntipop']."','".$_POST['nmedio']."','".($_POST['tiva']/100)."','".($_POST['triva']/100)."','".($_POST['trica']/100)."','".($_POST['trfte']/100)."','".strtoupper($_POST['ncheque'])."','".$_POST['ncuenta']."','".$_POST['ntipoc']."','".$_POST['nentidad']."','".$_POST['npcontacto']."','".$_POST['nfpago']."','".$_POST['ndprontop']."','".strtoupper($_POST['npobservaciones'])."')";

	$insert=mysql_query($str,$cnn) or die (mysql_error());

	$strtrib="INSERT INTO tributariaproveedores(Identificacion, Contribuyente, IVA, Autoretenedor, ICA, CodActividad, CIIU, AutoretenedorICA, Tarifa) VALUES('".$idproveedor."', '".$_POST['ntcontrib']."', '".$_POST['niva']."', '".$_POST['naret']."', '".$_POST['nica']."', '".$_POST['ncodac']."', '".$_POST['nciiu']."', '".$_POST['naret']."', '".$_POST['ntarifa']."')";

	$insert=mysql_query($strtrib,$cnn) or die(mysql_error());
	mysql_close($cnn);
	header("Location: ../rental.php?location=confirmaprov");
}
?>