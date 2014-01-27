<?php

if(isset($_SESSION['usuario'])){
	session_destroy();
}		
	include '../Connections/cnn.php';
	include '../funciones.php';
	echo'
		<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			<script src="js/funciones.js" type="text/javascript"></script>
			<script src="js/control.js" type="text/javascript"></script>
			<title>Sistema de Administraci&oacute;n y Control ESL</title>
		</head>
		<body>
		<form action="ingreso.php" method="post" id="inicial" name="inicial">
			<div align="center">
			<table>
				<tr>
					<td><img id="iminicio" name="iminicio" src="images/eslbn.jpg" width="120px" height="100px"/></td>
					<td><br /><h3>Sistema de Administración y Control ESL</h3></td>
				<tr>
				<tr>
					<td colspan="3">
						<div align="center">
						<table>
							<tr>
							<td colspan="2">
								<div align="center"><h4><label>Ingreso al Sistema</label></h4></div>
							</td>
							</tr>
							<tr>
								<td>Usuario:</td>
								<td><input type="text" id="usuario" name="usuario" size="27" maxlength="20" /></td>
							</tr>
							<tr>
							<td>Password:</td>
							<td><input type="password" id="password" name="password" size="27" maxlength="20"  /></td>
							</tr>
							<tr>
								<td colspan="2">
								<div align="center">
                                    <input type="submit" style="background-color:white; font-weight:bold; font-size:12px; width:280px" value="Ingreso al Sistema" size="80"/>
								</div>
								</td>
							</tr>
							<tr>
							<td colspan="2"><br /></td>
							</tr>
						</table>
						<br />
						<hr>
						<div><b><label>Ingreso Habilitado solo a usuarios Administradores</label></b></div>
					</div>
				</td>
			</tr>
		</table>
		</div>
		</form>
		<body>
		</html>';
        //<input type="button" onclick="validarform(\'inicial\',\'inicio\')" value="     Ingreso al Sistema    " size="80"/>
?>