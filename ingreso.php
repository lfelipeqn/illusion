<?php
	session_start();
	include('Connections/cnn.php');
	$user=$_POST['usuario'];
	$pass=md5($_POST['password']);
	$unidad=$_POST['sunidad'];
	$sql = "SELECT usuarios.IdUsuario, usuarios.Usuario, usuarios.Password, usuarios.Nombre, usuarios.Correo, perfiles.Perfil FROM usuarios Inner Join perfiles ON usuarios.IdPerfil = perfiles.IdPerfil where ((Usuario='$user') AND (Password='$pass'))";
	$connect=mysql_select_db($database_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
	$existe=mysql_num_rows($consulta);
	if ($existe>0){
		$rsusuario=mysql_fetch_assoc($consulta);
		$_SESSION['usuario']=$user;
		$_SESSION['perfil']=$rsusuario['Perfil'];
		
		if($unidad==0){
			$sqlunidad="SELECT usuarios_unidades.usuario, usuarios_unidades.IdUnidad FROM usuarios_unidades WHERE usuarios_unidades.usuario = '".$user."'";
		}else{
			$sqlunidad="SELECT usuarios_unidades.usuario, usuarios_unidades.IdUnidad FROM usuarios_unidades WHERE usuarios_unidades.usuario = '".$user."' AND usuarios_unidades.IdUnidad='".$unidad."'";
		}
		$cltunidades=mysql_query($sqlunidad,$cnn) or die(mysql_error());
		$totuni=mysql_num_rows($cltunidades);
		
		if($totuni>=1){
			if($unidad==0){
				$_SESSION['unidad']=0;
			}else{
				$rsunidad=mysql_fetch_assoc($cltunidades);
				$_SESSION['unidad']=$rsunidad['IdUnidad'];
			}
			header('Location: inicio.php?location=inicio');
		}else{
			echo'
				<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					<title>ENTRETENIMIENTO SIN LIMITES</title>
				</head>
				<body>
				<form action="ingreso.php" method="post" id="inicial" name="inicial">
					<div align="center">
					<table>
						<tr>
							<td><img id="iminicio" name="iminicio" src="images/esl-ini.jpg"/></td>
							<td>&nbsp;</td>
							<td><br /><h3>Sistema de Gesti&oacute;n de Procesos ESL</h3></td>
						<tr>
						<tr>
							<td colspan="3">
								<div align="center">
								<table>
									<tr>
										<td>
											<div align="center"><h2>Acceso Denegado</h2></div>
										</td>
									</tr>
									<tr>
										<td><div align="center"><img src="images/denegado.jpg" /></div></td>
									</tr>
									<tr>
										<td>
											<div align="center">No Tiene Privilegios Suficientes para Ingresar a esta secci&oacute;n. Si est&aacute; seguro de que debe ingresar, por favor contacte a un administrador</div>
										</td>
									</tr>
								</table>
								<br />
								<hr>
								<div><b><label>El Ingreso no Autorizado est&aacute; sujeto a acciones civiles y penales</label></b></div>
							</div>
						</td>
					</tr>
				</table>
				</div>
				</form>
				<body>
				</html>';
		}
	}else{
		echo'
				<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					<title>ENTRETENIMIENTO SIN LIMITES</title>
				</head>
				<body>
				<form action="ingreso.php" method="post" id="inicial" name="inicial">
					<div align="center">
					<table>
						<tr>
							<td><img id="iminicio" name="iminicio" src="images/esl-ini.jpg"/></td>
							<td>&nbsp;</td>
							<td><br /><h3>Sistema de Gesti&oacute;n de Procesos ESL</h3></td>
						<tr>
						<tr>
							<td colspan="3">
								<div align="center">
								<table>
									<tr>
										<td>
											<div align="center"><h2>Usuario o Contrase&ntilde;a Incorrectos</h2></div>
										</td>
									</tr>
									<tr>
										<td><div align="center"><img src="images/denegado.jpg" /></div></td>
									</tr>
									<tr>
										<td>
											<div align="center">El Usuario y/o Contrase&ntilde;a suministrados no son v&aacute;lidos, Por favor, verifique los valores ingresados.</div>
										</td>
									</tr>
								</table>
								<br />
								<hr>
								<div><b><label>El Ingreso no Autorizado est&aacute; sujeto a acciones civiles y penales</label></b></div>
							</div>
						</td>
					</tr>
				</table>
				</div>
				</form>
				<body>
				</html>';
	}
?>