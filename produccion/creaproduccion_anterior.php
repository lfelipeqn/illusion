<?php
	session_start();
	include '../Connections/cnn.php';
	include '../funciones.php';

if(isset($_SESSION['usuario'])){	
	$valorprod=aNumero($_POST['resvt']);
	$conect=mysql_select_db($database_cnn,$cnn);

	if ($_GET['esnego']=='S'){
		$tipo=$_GET['tipo'];
		$valorpres=aNumero($_GET['totpres']);
		$conspres="SELECT presupuestos.IdPresupuesto, presupuestos.Presupuesto, presupuestos.Version, presupuestos.IdCliente, presupuestos.IdProyecto, presupuestos.FechaPresentacion, presupuestos.Presentadopor, usuarios.Nombre, presupuestos.Aprobabo, presupuestos.FechaAprobacion, usuarios.Correo FROM presupuestos INNER JOIN usuarios ON presupuestos.Presentadopor = usuarios.Usuario where ((presupuestos.IdProyecto=".$_GET['pproy'].") AND (presupuestos.Aprobabo='1'))";
	}else{
		$tipo=$_POST['tipo'];
		$valorpres=aNumero($_POST['totpres']);
		$conspres="select presupuestos.IdPresupuesto, presupuestos.Presupuesto, presupuestos.Version, presupuestos.IdCliente, presupuestos.IdProyecto, presupuestos.FechaPresentacion, presupuestos.Presentadopor, usuarios.Nombre, presupuestos.Aprobabo, presupuestos.FechaAprobacion, usuarios.Correo FROM presupuestos INNER JOIN usuarios ON presupuestos.Presentadopor = usuarios.Usuario where ((presupuestos.IdProyecto=".$_POST['pproy'].") AND (presupuestos.Aprobabo='1'))";
	}

	$cltpres=mysql_query($conspres,$cnn) or die(mysql_error());
	$rspresup=mysql_fetch_assoc($cltpres);
	$idpres=$rspresup['IdPresupuesto'];

	if($tipo=='N'){
		if($_GET['esnego']=='S'){
			$cadproduccion="insert into produccion(IdCliente, IdProyecto, IdPresupuesto, ProductorEjecutivo, ProductorCampo, ESLGEspectaculos, ESLGEventoCorporativo, ESLGNuevasTec, ESLGProduccion, ESLGImprevistos, ESLGPersonal, TotalESL, GranTotal, IdUnidad, FechaCreacion) VALUES ('".$_GET['ncliente']."','".$_GET['pproy']."','$idpres','".$_GET['prodej']."','".$_GET['sprod']."','".aNumero($_GET['resge'])."','".aNumero($_GET['resec'])."','".aNumero($_GET['resnt'])."','".aNumero($_GET['respd'])."','".aNumero($_GET['resgi'])."','".aNumero($_GET['respr'])."','".aNumero($_GET['resvt'])."','$valorprod','".$_SESSION['unidad']."', '".date("Y-m-d H:i:s")."')";
			$creaprod=mysql_query($cadproduccion,$cnn) or die(mysql_error());
			$numeroprod=mysql_insert_id();

			$idnegocio=$_GET['nego'];
			$sqlproductor="SELECT usuarios.IdUsuario, usuarios.Usuario FROM usuarios WHERE usuarios.Usuario='".$_GET['sprod']."'";
			$cltprod=mysql_query($sqlproductor,$cnn) or die(mysql_error());
			$rsprod=mysql_fetch_assoc($cltprod);

			$sqlpcampo="UPDATE produccion SET ProductorCampo=".$rsprod['IdUsuario']." WHERE IdProduccion='$numeroprod'";
			$cltpcampo=mysql_query($sqlpcampo,$cnn) or die(mysql_error());

			$sqlasigna="UPDATE negocios SET Productor='".$_GET['sprod']."' WHERE IdNegocio='$idnegocio'";
			$cltasigna=mysql_query($sqlasigna,$cnn) or die(mysql_error());
			$productorcampo=$_GET['sprod'];
		}

		$sqlconf="SELECT usuarios.Usuario, usuarios.Nombre, usuarios.Correo FROM usuarios WHERE usuarios.Usuario = '".$rspresup['Presentadopor']."' OR usuarios.Usuario='".$productorcampo."' OR usuarios.IdPerfil=1";

		$sqlprod="SELECT usuarios.Usuario, usuarios.Nombre, usuarios.Correo FROM usuarios WHERE usuarios.Usuario = '".$productorcampo."'";
		$cltprod=mysql_query($sqlprod,$cnn) or die(mysql_error());
		$rsprod=mysql_fetch_assoc($cltprod);
        
		$sqlpr="SELECT proyectos.IdProyecto, proyectos.IdCliente, proyectos.NombreProyecto, proyectos.Ciudades, proyectos.TelefonoContacto, proyectos.NombreContacto, proyectos.EmailContacto, proyectos.FechaEvento, proyectos.LugarEvento, proyectos.FechaMontaje, proyectos.FechaDesmontaje, proyectos.Observaciones, proyectos.IdUnidad FROM proyectos WHERE proyectos.IdProyecto =".$rspresup['IdProyecto'];
		$cltpr=mysql_query($sqlpr,$cnn) or die(mysql_error());
		$rspr=mysql_fetch_assoc($cltpr);

		$sqlclie="SELECT clientes.IdCliente, clientes.NombreCliente FROM clientes WHERE clientes.IdCliente=".$rspr['IdCliente'];
		$cltclie=mysql_query($sqlclie,$cnn) or die(mysql_error());
		$rsclie=mysql_fetch_assoc($cltclie);

		$mensaje='
		<html>
		<head>
		  <title>Productor Asignado a Nuevo Negocio '.$rspr['IdProyecto'].'</title>
		</head>
		<body>
		  <p>El Presente a fin de notificarle la Asignaci&oacute;n del Productor '.$rsprod['Nombre'].' al proyecto No.'.$rspr['IdProyecto'].': '.$rspr['NombreProyecto'].' del cliente '.$rsclie['NombreCliente'].' Correspondiente al Comercial '.$rspresup['Nombre'].'</p>
		  <br />
		  <br /
		  <p>Cordial Saludo,</p>
		  <p>Administrador ESL</p>
		  <p>Por Favor <b>NO</b> responda este Mensaje</p>
		  <img src="http://www.entretenimientosinlimites.co/images/esl.jpg" align="left" width="20%" height="20%">
		</body>
		</html>';

		Alerta('ConfirmaProduccion','Productor Asignado a Proyecto '.$rspr['IdProyecto'],$mensaje,$_SESSION['unidad']);

	}else{

		$nprod=$_POST['seguimiento'];
		$cadactualiza="UPDATE produccion SET IdCliente='".$_POST['ncliente']."', IdProyecto='".$_POST['pproy']."', ProductorEjecutivo='".$_POST['prodej']."', ProductorCampo='".$_POST['prodcampo']."', ESLGEspectaculos='".aNumero($_POST['resge'])."', ESLGEventoCorporativo='".aNumero($_POST['resec'])."', ESLGNuevasTec='".aNumero($_POST['resnt'])."', ESLGProduccion='".aNumero($_POST['respd'])."', ESLGImprevistos='".aNumero($_POST['resgi'])."', ESLGPersonal='".aNumero($_POST['respr'])."', TotalESL='".aNumero($_POST['resvt'])."', GranTotal='".$valorprod."' WHERE produccion.IdProduccion='".$nprod."'";
		$cltactualiza=mysql_query($cadactualiza,$cnn) or die(mysql_error());


		$sqlborra1="DELETE FROM produccion_ec WHERE produccion_ec.IdProduccion='".$nprod."'";
		$sqlborra2="DELETE FROM produccion_esl WHERE produccion_esl.IdProduccion='".$nprod."'";
		$sqlborra3="DELETE FROM produccion_gp WHERE produccion_gp.IdProduccion='".$nprod."'";
		$sqlborra4="DELETE FROM produccion_im WHERE produccion_im.IdProduccion='".$nprod."'";
		$sqlborra5="DELETE FROM produccion_nt WHERE produccion_nt.IdProduccion='".$nprod."'";
		$sqlborra6="DELETE FROM produccion_pr WHERE produccion_pr.IdProduccion='".$nprod."'";


		$cltborra1=mysql_query($sqlborra1,$cnn);
		$cltborra2=mysql_query($sqlborra2,$cnn);
		$cltborra3=mysql_query($sqlborra3,$cnn);
		$cltborra4=mysql_query($sqlborra4,$cnn);
		$cltborra5=mysql_query($sqlborra5,$cnn);
		$cltborra6=mysql_query($sqlborra6,$cnn);

		$numeroprod=$nprod;
	}

	$sqlcategoria="SELECT produccion_categoria.IdCategoria, produccion_categoria.Proveedor, produccion_categoria.Categoria, produccion_categoria.TablaHtml, produccion_categoria.NombreTabla, produccion_categoria.sigla FROM produccion_categoria ORDER BY produccion_categoria.IdCategoria ASC";
	$cltcategoria=mysql_query($sqlcategoria,$cnn) or die(mysql_error());

	while($rscategoria=mysql_fetch_assoc($cltcategoria)){
		$filas=$_POST['tt'.$rscategoria['TablaHtml']];
		$ctabla=$rscategoria['sigla'];
		$nomtabla=$rscategoria['NombreTabla'];
		$categoria=$rscategoria['IdCategoria'];

		for($j=1;$j<=$filas;$j++){
			$proveedor1=$ctabla.'pv'.$j;
			$detalle1=$ctabla.'ds'.$j;
			$cantidad1=$ctabla.'cn'.$j;
			$dias1=$ctabla.'dd'.$j;
			$valoru1=$ctabla.'vu'.$j;
			$valort1=$ctabla.'vt'.$j;

			$proveedor=$_POST[$proveedor1];
			$detalle=strtoupper($_POST[$detalle1]);
			$cantidad=aNumero($_POST[$cantidad1]);
			$dias=aNumero($_POST[$dias1]);
			$valoru=aNumero($_POST[$valoru1]);
			$valort=aNumero($_POST[$valort1]);

			if($categoria==6){
				$sqldet="insert into ".$nomtabla."(IdProduccion, IdPersona, Categoria, Detalle, Cantidad, Dias, VrUnitario, VrTotal) values('$numeroprod','$proveedor', '$categoria', '$detalle','$cantidad','$dias','$valoru','$valort')";		
			}else{
				$sqldet="insert into ".$nomtabla."(IdProduccion, IdProveedor, Categoria, Detalle, Cantidad, Dias, VrUnitario, VrTotal) values('$numeroprod','$proveedor','$categoria','$detalle','$cantidad','$dias','$valoru','$valort')";		
			}

			$creadet=mysql_query($sqldet,$cnn) or die(mysql_error());
			$sqlsobra="DELETE FROM ".$nomtabla." WHERE ((Cantidad=0) OR (Dias=0))";	
			$cltsobre=mysql_query($sqlsobra,$cnn);
		}

	}

	$totalpres=$valorpres;
	$totalprod=$valorprod;
	$rent=(($totalpres-$totalprod)/$totalpres);

	$sqlrent="UPDATE produccion SET Rentabilidad=".$rent." WHERE IdProduccion='".$numeroprod."'";
	$cltrent=mysql_query($sqlrent,$cnn) or die(mysql_error());

	mysql_close($cnn);
	header("Location: ../inicio.php?location=confprod");
}

?>