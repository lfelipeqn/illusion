<?php
	session_start();
	include('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$conect=mysql_select_db($database_cnn,$cnn);
	$proveedor=$_POST['idproveedor'];

	for($i=1;$i<=36;$i++){
		switch($i){
			case 1:
				$str="Update proveedores set NombreProveedor='".strtoupper($_POST['nproveedor'])."' where (Identificacion='".$proveedor."')";
				break;
			case 2:
				$str="Update proveedores set TipoIdentificacion='".$_POST['tipoi']."' where (Identificacion='".$proveedor."')";
				break;
			case 3:
				$str="Update proveedores set Identificacion='".$_POST['nnit']."' where (Identificacion='".$proveedor."')";
				break;
			case 4:
				$str="Update proveedores set DV='".$_POST['ndv']."' where (Identificacion='".$proveedor."')";
				break;
			case 5:
				$str="Update proveedores set NombreComercial='".$_POST['ncomercial']."' where (Identificacion='".$proveedor."')";
				break;
			case 6:
				$str="Update proveedores set TipoPersona='".$_POST['ntpersona']."' where (Identificacion='".$proveedor."')";
				break;
			case 7:
				$str="Update proveedores set Ciudad='".$_POST['nciudad']."' where (Identificacion='".$proveedor."')";
				break;
			case 8:
				$str="Update proveedores set Pais='".$_POST['npais']."' where (Identificacion='".$proveedor."')";
				break;
			case 9:
				$str="Update proveedores set Direccion='".$_POST['ndir']."' where (Identificacion='".$proveedor."')";
				break;
			case 10:
				$str="Update proveedores set Fax='".$_POST['npfax']."' where (Identificacion='".$proveedor."')";
				break;
			case 11:
				$str="Update proveedores set Telefono='".$_POST['ntel']."' where (Identificacion='".$proveedor."')";
				break;
			case 12:
				$str="Update proveedores set Correo='".$_POST['ncorreo']."' where (Identificacion='".$proveedor."')";
				break;
			case 13:
				$str="Update proveedores set Actividad='".$_POST['nactiv']."' where (Identificacion='".$proveedor."')";
				break;
			case 14:
				$str="Update proveedores set Representante='".$_POST['nrepl']."' where (Identificacion='".$proveedor."')";
				break;
			case 15:
				$str="Update proveedores set IdentRep='".$_POST['ncc']."' where (Identificacion='".$proveedor."')";
				break;
			case 16:
				$str="Update proveedores set IdTipoP='".$_POST['ntipop']."' where (Identificacion='".$proveedor."')";
				break;
			case 17:
				$str="Update proveedores set IVA='".($_POST['tiva']/100)."' where (Identificacion='".$proveedor."')";
				break;
			case 18:
				$str="Update proveedores set ReteIva='".($_POST['triva']/100)."' where (Identificacion='".$proveedor."')";
				break;
			case 19:
				$str="Update proveedores set ReteIca='".($_POST['trica']/100)."' where (Identificacion='".$proveedor."')";
				break;
			case 20:
				$str="Update proveedores set ReteFte='".($_POST['trfte']/100)."' where (Identificacion='".$proveedor."')";
				break;
			case 21:
				$sqlvalida="SELECT tributariaproveedores.IdProveedor, tributariaproveedores.Contribuyente, tributariaproveedores.IVA, tributariaproveedores.Autoretenedor, tributariaproveedores.ICA, tributariaproveedores.CodActividad, tributariaproveedores.CIIU, tributariaproveedores.AutoretenedorICA, tributariaproveedores.Tarifa FROM tributariaproveedores where IdProveedor='".$proveedor."'";
				
				$cltvalida=mysql_query($sqlvalida,$cnn);
				$total=mysql_num_rows($cltvalida);
				if($total<1){
					$sqlinsert="INSERT INTO tributariaproveedores(IdProveedor, Contribuyente, IVA, Autoretenedor, ICA) VALUES ('".$proveedor."','0','0','0','0')";
					$insertar=mysql_query($sqlinsert,$cnn) or die(mysql_error());
				}
				$str="Update tributariaproveedores set Contribuyente='".$_POST['ntcontrib']."' where (IdProveedor='".$proveedor."')";
				break;
			case 22:
				$str="Update tributariaproveedores set IVA='".$_POST['niva']."' where (IdProveedor='".$proveedor."')";
				break;
			case 23:
				$str="Update tributariaproveedores set Autoretenedor='".$_POST['naret']."' where (IdProveedor='".$proveedor."')";
				break;
			case 24:
				$str="Update tributariaproveedores set ICA='".$_POST['nica']."' where (IdProveedor='".$proveedor."')";
				break;
			case 25:
				$str="Update tributariaproveedores set CodActividad='".$_POST['ncodac']."' where (IdProveedor='".$proveedor."')";
				break;
			case 26:
				$str="Update tributariaproveedores set CIIU='".$_POST['nciiu']."' where (IdProveedor='".$proveedor."')";
				break;
			case 27:
				$str="Update tributariaproveedores set Tarifa='".$_POST['ntarifa']."' where (IdProveedor='".$proveedor."')";
				break;
			case 28:
				$sqlvalida="SELECT * FROM pagosproveedores where IdProveedor='".$proveedor."'";
				
				$cltvalida=mysql_query($sqlvalida,$cnn);
				$total=mysql_num_rows($cltvalida);
				if($total<1){
					$sqlinsert="INSERT INTO pagosproveedores(IdProveedor, Cuenta, TipoCuenta, Entidad, Contacto) VALUES ('".$proveedor."','0','0','0','0')";
					$insertar=mysql_query($sqlinsert,$cnn) or die(mysql_error());
				}
			
			
				$str="Update pagosproveedores set NombreCheque='".$_POST['ncheque']."' where (IdProveedor='".$proveedor."')";
				break;
			case 29:
				$str="Update pagosproveedores set IdPago='".$_POST['nmedio']."' where (IdProveedor='".$proveedor."')";
				break;
			case 30:
				$str="Update pagosproveedores set Cuenta='".$_POST['ncuenta']."' where (IdProveedor='".$proveedor."')";
				break;
			case 31:
				$str="Update pagosproveedores set TipoCuenta='".$_POST['ntipoc']."' where (IdProveedor='".$proveedor."')";
				break;
			case 32:
				$str="Update pagosproveedores set Entidad='".$_POST['nentidad']."' where (IdProveedor='".$proveedor."')";
				break;
			case 33:
				$str="Update pagosproveedores set Contacto='".$_POST['npcontacto']."' where (IdProveedor='".$proveedor."')";
				break;
			case 34:
				$sqlvalida="SELECT * FROM vinculoproveedor where IdProveedor='".$proveedor."'";
				$cltvalida=mysql_query($sqlvalida,$cnn);
				$total=mysql_num_rows($cltvalida);
				if($total<1){
					$sqlinsert="INSERT INTO vinculoproveedor(IdProveedor, FormaPago, Descuento, Observaciones) VALUES ('".$proveedor."','0','0','0')";
					$insertar=mysql_query($sqlinsert,$cnn) or die(mysql_error());
				}
				$str="Update vinculoproveedor set FormaPago='".$_POST['nfpago']."' where (IdProveedor='".$proveedor."')";
				break;
			case 35:
				$str="Update vinculoproveedor set Descuento='".$_POST['ndprontop']."' where (IdProveedor='".$proveedor."')";		
				break;
			case 36:
				$str="Update vinculoproveedor set Observaciones='".strtoupper($_POST['npobservaciones'])."' where (IdProveedor='".$proveedor."')";
				break;
		}
		$actual=mysql_query($str,$cnn) or die (mysql_error());
	}
	
	mysql_close($cnn);
	header("Location: ../inicio.php?location=confactprov");
}
?>