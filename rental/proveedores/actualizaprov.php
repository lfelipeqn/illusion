<?php
	session_start();
	include('../../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$conect=mysql_select_db($rental_cnn,$cnn);
	$proveedor=$_POST['ident'];
	$str="UPDATE proveedores SET DV='".$_POST['ndv']."', TipoIdentificacion='".$_POST['tipoi']."', NombreComercial='".strtoupper($_POST['ncomercial'])."', NombreProveedor='".strtoupper($_POST['nproveedor'])."', Ciudad='".strtoupper($_POST['nciudad'])."', Pais='".strtoupper($_POST['npais'])."', Direccion='".$_POST['ndir']."', Fax='".$_POST['npfax']."', Telefono='".$_POST['ntel']."', Correo='".$_POST['ncorreo']."', Actividad='".strtoupper($_POST['nactiv'])."', Representante='".$_POST['nrepl']."', IdentRep='".$_POST['ncc']."', IdTipoProveedor='".$_POST['ntipop']."', IdPago='".$_POST['nmedio']."', IVA='".($_POST['tiva']/100)."', ReteIva='".($_POST['triva']/100)."', ReteIca='".($_POST['trica']/100)."', ReteFte='".($_POST['trfte']/100)."', NombreCheque='".strtoupper($_POST['ncheque'])."', Cuenta='".$_POST['ncuenta']."', TipoCuenta='".$_POST['ntipoc']."', Entidad='".$_POST['nentidad']."', Contacto='".$_POST['npcontacto']."', IdPlazo='".$_POST['nfpago']."', Descuento='".$_POST['ndprontop']."', Observaciones='".strtoupper($_POST['npobservaciones'])."' WHERE Identificacion='".$proveedor."'";
	$cltprov=mysql_query($str,$cnn) or die(mysql_error());
	$trib="UPDATE tributariaproveedores SET Contribuyente='".$_POST['ntcontrib']."', IVA='".$_POST['niva']."', Autoretenedor='".$_POST['naret']."', ICA='".$_POST['nica']."', CodActividad='".$_POST['ncodac']."', CIIU='".$_POST['nciiu']."', AutoretenedorICA='".$_POST['naret']."', Tarifa='".$_POST['ntarifa']."' WHERE Identificacion='".$proveedor."'";
	$clttrib=mysql_query($trib,$cnn) or die(mysql_error());
    
	mysql_close($cnn);
	header("Location: ../rental.php?location=confactprov");
}
?>