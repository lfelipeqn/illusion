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
				<title>RENTAL ESL</title>
			</head>
			<body>
			<form action="ingreso.php" method="post" id="inicial" name="inicial">
				<div align="center" style="padding-top: 130px;">
				<table>
					<tr>
						<td colspan="2"><img id="iminicio" name="iminicio" src="images/rental_peq.png"/></td>
					<tr>
					<tr>
						<td colspan="3">
							<div align="center">
							<table>
								<tr>
									<td>Usuario:</td>
									<td><input type="text" id="usuario" name="usuario" size="27" maxlength="20" /></td>
								</tr>
								<tr>
								<td>Password:</td>
								<td><input type="password" id="password" name="password" size="27" maxlength="20" /></td>
								</tr>
								<tr>
									<td colspan="2">
									<div align="center">
										<input type="submit" style="background-color:white; font-weight:bold;width:265px;" value="Ingreso al Sistema" size="80"/>
									</div>
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
?>