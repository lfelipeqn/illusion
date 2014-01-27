<?php
	include('../Connections/cnn.php');
	include('../funciones.php');
session_start();
if(isset($_SESSION['usuario'])){
	$conect=mysql_select_db($database_cnn,$cnn);
	$cadcual="SELECT presupuestos.IdPresupuesto, presupuestos.Presupuesto, presupuestos.Version, presupuestos.IdCliente, presupuestos.IdProyecto, presupuestos.IdUnidad FROM presupuestos WHERE IdCliente=".$_POST['ncliente']." AND IdProyecto=".$_POST['pproy']." ORDER BY Presupuesto ASC, Version ASC";
	$cltcual=mysql_query($cadcual,$cnn);
	$registros=mysql_num_rows($cltcual);
	if($registros<1){
		$npresupuesto=1;
		$nversion=1;
	}else{
		while($cual=mysql_fetch_assoc($cltcual)){
			$npresupuesto=$cual['Presupuesto'];
			$nversion=$cual['Version'];
		}
		if($nversion>=13){
			$npresupuesto++;
			$nversion=1;
		}else{
			$nversion++;
		}
	}

	$fecha=date("Y-m-d");
	$idpresup='pr'.$_POST['pproy'].'p'.$npresupuesto.'v'.$nversion;

	$str="insert into presupuestos(IdPresupuesto, Presupuesto, Version, IdCliente, IdProyecto, FechaPresentacion, Presentadopor, SubEspectaculos, SubEventosCorp, SubNuevasTec, SubProduccion, Subtotal, Descuento, KnowHow, Total, IdUnidad) values('$idpresup', '".$npresupuesto."','".$nversion."','".$_POST['ncliente']."','".$_POST['pproy']."','$fecha','".$_SESSION['usuario']."',".aNumero($_POST['stesvt3']).",".aNumero($_POST['stecvt1']).",".aNumero($_POST['stntvt2']).",".aNumero($_POST['stpevt4']).",".aNumero($_POST['stp']).",".aNumero($_POST['dse']).",".aNumero($_POST['knh']).",".aNumero($_POST['stds']).", '".$_SESSION['unidad']."')";
	$insert=mysql_query($str,$cnn) or die (mysql_error());

	$clave= array(1 => 'em',2 => 'rs',3 => 'vd',4 => 'kn',5 => 've',6 => 'bi', 7 => 'pf',8 => 'mg',9 => 'os',10 => 'pe');

	for ($j=1;$j<=10;$j++){
		switch($j){
			case 1:
				$tabla='pres_eventoscorporativos';
				$tipo='Event Marketing';
				$contador=$_POST['tteventmark'];
				break;
			case 2:
				$tabla='pres_eventoscorporativos';
				$tipo='Rental & Support';
				$contador=$_POST['ttrentsupp'];
				break;
			case 3:
				$tabla='pres_nuevastecnologias';
				$tipo='Video HD & 3D';
				$contador=$_POST['ttvideohd3d'];
				break;
			case 4:
				$tabla='pres_nuevastecnologias';
				$tipo='Keynote';
				$contador=$_POST['ttkeynote'];
				break;
			case 5:
				$tabla='pres_nuevastecnologias';
				$tipo='Visual Experience';
				$contador=$_POST['ttvisualex'];
				break;
			case 6:
				$tabla='pres_nuevastecnologias';
				$tipo='Branding Integration';
				$contador=$_POST['ttbranding'];
				break;
			case 7:
				$tabla='pres_espectaculos';
				$tipo='Performance';
				$contador=$_POST['ttperformance'];
				break;
			case 8:
				$tabla='pres_espectaculos';
				$tipo='Management';
				$contador=$_POST['ttmanagement'];
				break;
			case 9:
				$tabla='pres_espectaculos';
				$tipo='Own Shows';
				$contador=$_POST['ttown'];
				break;
			case 10:
				$tabla='pres_prodejecutivaycampo';
				$tipo='Produccion Ejecutiva y de Campo';
				$contador=$_POST['ttproduccion'];
				break;
		}

		for ($i=1;$i<=$contador;$i++){
			$val1=$_POST[$clave[$j].'ds'.$i];
			$val2=$_POST[$clave[$j].'cn'.$i];
			$val3=$_POST[$clave[$j].'dd'.$i];
			$val4=aNumero($_POST[$clave[$j].'vu'.$i]);
			$val5=aNumero($_POST[$clave[$j].'vt'.$i]);

			if (($val1!= null) and ($val5>0)){

			$sql="insert $tabla(IdPresupuesto, Tipo, Descripcion, Cantidad, Dias, VrUnitario, VrTotal) values ('$idpresup', '$tipo', '$val1', '$val2', '$val3', '$val4', '$val5')";
			$nuevo=mysql_query($sql,$cnn) or die (mysql_error());
			}
		}
	}

	mysql_close($cnn);
	if ($insert){
		header("Location: ../inicio.php?location=confpres");
	}else{
		echo 'No ha Sido Posible Insertar los Datos, Por Favor, Intente Nuevamente';
	}
}
?>