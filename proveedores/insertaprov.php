<?php
	session_start();
if(isset($_SESSION['usuario'])){
	include('../Connections/cnn.php');
	include('../funciones.php');

	$fecha=date('Y-m-d');
	$str="INSERT INTO proveedores(NombreProveedor, Fecha, TipoIdentificacion, Identificacion, DV, NombreComercial, TipoPersona, Ciudad, Pais, Direccion, Fax, Telefono, Correo, Actividad, Representante, IdentRep, IdTipoP, IVA, ReteIva, ReteIca, ReteFte) VALUES('".strtoupper($_POST['nproveedor'])."', '$fecha','".$_POST['tipoi']."','".$_POST['nnit']."', '".$_POST['ndv']."', '".strtoupper($_POST['ncomercial'])."', '".$_POST['ntpersona']."', '".$_POST['nciudad']."', '".$_POST['npais']."', '".$_POST['ndir']."', '".$_POST['npfax']."', '".$_POST['ntel']."', '".$_POST['ncorreo']."', '".$_POST['nactiv']."', '".strtoupper($_POST['nrepl'])."', '".$_POST['ncc']."', '".$_POST['ntipop']."', '".($_POST['tiva']/100)."', '".($_POST['triva']/100)."', '".($_POST['trica']/100)."', '".($_POST['trfte']/100)."')";

	$conect=mysql_select_db($database_cnn,$cnn);
	$insert=mysql_query($str,$cnn) or die (mysql_error());

	$filtro= "SELECT * FROM proveedores Where NombreProveedor='".$_POST['nproveedor']."' AND  Fecha='$fecha' AND Identificacion=".$_POST['nnit'];
	$select=mysql_query($filtro,$cnn) or die (mysql_error());
	$rs=mysql_fetch_assoc($select);
	
    $strtrib="INSERT INTO tributariaproveedores(IdProveedor, Contribuyente, IVA, Autoretenedor, ICA, CodActividad, CIIU, AutoretenedorICA, Tarifa) VALUES('".$rs['Identificacion']."', '".$_POST['ntcontrib']."', '".$_POST['niva']."', '".$_POST['naret']."', '".$_POST['nica']."', '".$_POST['ncodac']."', '".$_POST['nciiu']."', '".$_POST['naret']."', '".$_POST['ntarifa']."')";
	$insert=mysql_query($strtrib,$cnn) or die(mysql_error());
	
    $spagos="INSERT INTO pagosproveedores(IdProveedor, IdPago, NombreCheque, Cuenta, TipoCuenta, Entidad, Contacto) VALUES('".$rs['Identificacion']."', '".$_POST['nmedio']."', '".$_POST['ncheque']."', '".$_POST['ncuenta']."', '".$_POST['ntipoc']."', '".$_POST['nentidad']."', '".$_POST['npcontacto']."')";
	$insert=mysql_query($spagos,$cnn) or die(mysql_error());

	$compania="INSERT INTO vinculoproveedor(IdProveedor, TipoProveedor, FormaPago, Descuento, Observaciones) VALUES('".$rs['Identificacion']."', '".$_POST['ntipop']."', '".$_POST['nfpago']."', '".$_POST['ndprontop']."', '".$_POST['npobservaciones']."')";
	$insert=mysql_query($compania,$cnn) or die(mysql_error());

	mysql_close($cnn);

	header("Location: ../inicio.php?location=confirmaprov");
}

?>