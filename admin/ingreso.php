<?php
	session_start();
	include('../Connections/cnn.php');
	$user=$_POST['usuario'];
	$pass=md5($_POST['password']);
	$sql = "SELECT usuarios.IdUsuario, usuarios.Usuario, usuarios.Password, usuarios.Nombre, usuarios.Correo, perfiles.Perfil FROM usuarios Inner Join perfiles ON usuarios.IdPerfil = perfiles.IdPerfil where ((Usuario='$user') AND (Password='$pass'))";
	$connect=mysql_select_db($database_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
	$existe=mysql_num_rows($consulta);

	$rsusuario=mysql_fetch_assoc($consulta);
	$_SESSION['usuario']=$user;
	$_SESSION['perfil']=$rsusuario['Perfil'];
    if ($_SESSION['perfil']=='Administrador'){
        header('Location: admin.php?location=admin');
    }else{
		echo'
			<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                <script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
                <script src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js" type="text/javascript"></script>
				<title>Sistema de Administraci&oacute;n y Control ESL</title>
			</head>
			<body>
			<form action="ingreso.php" method="post" id="inicial" name="inicial">
				<div align="center">
				<table>
					<tr>
						<td><img id="iminicio" name="iminicio" src="images/eslbn.jpg" width="120px" height="100px"/></td>
						<td>&nbsp;</td>
						<td><br /><h3>Sistema de Administraci&oacute;n y Control ESL</h3></td>
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
							<div><b><label>Ingreso habilitado solo para usuarios Administradores</label></b></div>
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