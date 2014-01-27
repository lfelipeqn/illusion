<?php
	session_start();
if(isset($_SESSION['usuario'])){
	include('../Connections/cnn.php');
	include('../funciones.php');
	$conect=mysql_select_db($database_cnn,$cnn);
	$proyecto=$_POST['codp'];
	
	for($i=1;$i<=10;$i++){
		switch($i){
			case 1:
				$str="Update proyectos set NombreProyecto='".$_POST['nproy']."' where (IdProyecto='".$proyecto."')";	
				break;
			case 2:
				$str="Update proyectos set NombreContacto='".$_POST['ncontac']."' where (IdProyecto='".$proyecto."')";
				break;
			case 3:
				$str="Update proyectos set EmailContacto='".strtolower($_POST['nmail'])."' where (IdProyecto='".$proyecto."')";
				break;
			case 4:
				$str="Update proyectos set TelefonoContacto='".$_POST['ntelcontac']."' where (IdProyecto='".$proyecto."')";
				break;
			case 5:
				$str="Update proyectos set Ciudades='".$_POST['ncity']."' where (IdProyecto='".$proyecto."')";
				break;
			case 6:
				$str="Update proyectos set LugarEvento='".$_POST['nlugar']."' where (IdProyecto='".$proyecto."')";
				break;
			case 7:
				$str="Update proyectos set FechaEvento='".aMySQL($_POST['nfechae'])."' where (IdProyecto='".$proyecto."')";
				break;
			case 8:
				$str="Update proyectos set FechaMontaje='".aMySQL($_POST['nfecham'])."' where (IdProyecto='".$proyecto."')";
				break;
			case 9:
				$str="Update proyectos set FechaDesmontaje='".aMySQL($_POST['nfechad'])."' where (IdProyecto='".$proyecto."')";
				break;
			case 10:
				$str="Update proyectos set Observaciones='".strtoupper($_POST['nobs'])."' where (IdProyecto='".$proyecto."')";
				brak;
		}
		$actual=mysql_query($str,$cnn) or die (mysql_error());	
	}

	mysql_close($cnn);
	header("Location: ../inicio.php?location=confactproy");
}
?>