<?php
	session_start();
	date_default_timezone_set('America/Bogota');
	include('../../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$conect=mysql_select_db($database_cnn,$cnn);	
	$fecha=date('Y-m-d');
	$proveedor=$_POST['proveedor'];
	$ntpersona=$_POST['ntpersona'];
	$nproveedor=$_POST['nproveedor'];
	$ncomercial=$_POST['ncomercial'];
	$tipoi=$_POST['tipoi'];
	$nnit=$_POST['nnit'];
	$nciudad=$_POST['nciudad'];
	$npais=$_POST['npais'];
	$ndir=$_POST['ndir'];
	$npfax=$_POST['npfax'];
	$ntel=$_POST['ntel'];
	$ncelu=$_POST['ncelu'];
	$ncorreo=$_POST['ncorreo'];
	$ncorreo2=$_POST['ncorreo2'];
	$nrepl=$_POST['nrepl'];
	$ncc=$_POST['ncc'];
	$tiporg=$_POST['ntiporg']; 
	$ntcontrib=$_POST['ntcontrib'];
	
	if(!empty($_POST['nresgran'])){
		$resgran=$_POST['nresgran'];
	}else{
		$resgran=0;
	}
	
	if(!empty($_POST['nfecgran'])){
		$fecgran=$_POST['nfecgran'];
	}else{
		$fecgran=0;
	}	
	
	$naret=$_POST['naret'];
	
	if(!empty($_POST['nresauto'])){
		$resauto=$_POST['nresauto'];
	}else{
		$resauto=0;
	}	
	
	if(!empty($_POST['nfecauto'])){
		$fecauto=$_POST['nfecauto'];
	}else{
		$fecauto=0;
	}
	
	$niva=$_POST['niva'];
	$nica=$_POST['nica'];
	$tiva=($_POST['tiva']/100);
	$trica=($_POST['trica']/100);
	$trfte=($_POST['trfte']/100);
	$ncodac=$_POST['ncodac'];
	
	if(!empty($_POST['ncodac2'])){
		$ncodac2=$_POST['ncodac2'];
	}else{
		$ncodac2=0;
	}
	
	if(!empty($_POST['ncodac3'])){
		$ncodac3=$_POST['ncodac3'];
	}else{
		$ncodac3=0;
	}
		
	$nciiu=$_POST['nciiu'];
	$ntipoc=$_POST['ntipoc'];
	$ncuenta=$_POST['ncuenta'];
	$nentidad=$_POST['nentidad'];
	$nmailcontacto=$_POST['nmailcontacto'];
	$npcontacto=utf8_decode($_POST['npcontacto']);
	/*$ntipop=$_POST['ntipop'];
	$nfpago=$_POST['nfpago'];
	$ndprontop=$_POST['ndprontop'];
	$npobservaciones=$_POST['npobservaciones'];*/
	
	$strprov="UPDATE proveedores SET NombreProveedor='".$nproveedor."', Fecha='".$fecha."', 
	TipoIdentificacion='".$tipoi."', NombreComercial='".$ncomercial."', TipoPersona='".$ntpersona."', 
	Ciudad='".$nciudad."', Pais='".$npais."', Direccion='".$ndir."', Fax='".$npfax."', 
	Telefono='".$ntel."', Correo='".$ncorreo."', Actividad='".$ncodac."', Representante='".$nrepl."', 
	IdentRep='".$ncc."', IVA='".$tiva."', ReteIca='".$trica."', ReteFte='".$trfte."', 
	Movil='".$ncelu."', CorreoAlterno='".$ncorreo2."' 
	WHERE Identificacion='".$proveedor."'";
			
	$cltprov=mysql_query($strprov,$cnn) or die(mysql_error());
	
	$strtributaria="UPDATE tributariaproveedores SET Contribuyente='".$ntcontrib."', IVA='".$niva."', Autoretenedor='".$naret."', ICA='".$nica."' , CodActividad='".$ncodac."', CIIU='".$nciiu."' , ResolucionGran='".$resgran."', FechaGran='".$fecgran."', ResolucionAuto='".$resauto."', FechaAuto='".$fecauto."', IdRegimen='".$tiporg."', CodActividad2='".$ncodac2."', CodActividad3='".$ncodac3."' WHERE IdProveedor='".$proveedor."'";	
	$clttrib=mysql_query($strtributaria,$cnn) or die(mysql_error());
	
	$strpagos="UPDATE pagosproveedores SET IdPago=1, Cuenta='".$ncuenta."', TipoCuenta='".$ntipoc."', Entidad='".$nentidad."', 
	Contacto='".$npcontacto."', EmailContacto='".$nmailcontacto."' 
	WHERE IdProveedor='".$proveedor."'";

	$cltpagos=mysql_query($strpagos,$cnn) or die(mysql_error());
	
	/*$strvinculo="UPDATE vinculoproveedor SET TipoProveedor='".$ntipop."', FormaPago='".$nfpago."', Descuento='".$ndprontop."', 
	Observaciones='".$npobservaciones."' WHERE IdProveedor='".$proveedor."'";
	$cltvinculo=mysql_query($strvinculo,$cnn) or die(mysql_error());*/
	
	mysql_close($cnn);
	//header("Location: ../inicio.php?location=confactprov");
	echo 'Actualización Exitosa';
}
?>