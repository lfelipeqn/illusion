<?php
	include('Connections/cnn.php');
	$usuario=$_POST['usuario'];
	$password=md5($_POST['password']);
	$nueva=md5($_POST['npassword']);
	$verifica=md5($_POST['cnpassword']);
	$igual=$_POST['valida'];
	
	if($igual==0){
		echo '
	  <div align="center">
	  <table>
	  	<tr>
			<td><img src="images/esl.jpg" width="125" height="120"/></td>
			<td>&nbsp;</td>
			<td><br /><h3>Error al Cambiar la Contrase&ntilde;a</h3></td>
		<tr>
	  	<tr>
			<td colspan="3">
				<div align="center">
				La Contrase&ntilde;a Nueva y la Verificaci&oacute;n No coinciden, por favor, verifique los valores e <a href="cambiopass.php" >Intente Nuevamente</a>
				<br />
				<hr>
				</div>
			</td>
		</tr>
		</table>
		</div>';
	}else{
	
	$conecta=mysql_select_db($database_cnn,$cnn);
	$cadcambio="SELECT usuarios.Usuario, usuarios.Password FROM usuarios WHERE usuarios.Usuario =  '$usuario' AND usuarios.Password = '$password'";
	
	$cltcambio=mysql_query($cadcambio,$cnn) or die(mysql_error());
	$totalfilas=mysql_num_rows($cltcambio);
	
	if($totalfilas>0){
		$cadactualiza="UPDATE usuarios SET Password='$nueva' WHERE Usuario='$usuario' AND Password='$password'";
		$cltactualiza=mysql_query($cadactualiza,$cnn) or die(mysql_error());
		echo '
	  <div align="center">
	  <table>
	  	<tr>
			<td><img src="images/esl.jpg" width="125" height="120"/></td>
			<td>&nbsp;</td>
			<td><br /><h3>Cambio de Contrase&ntilde;a Exitoso</h3></td>
		<tr>
	  	<tr>
			<td colspan="3">
				<div align="center">
				La Contrase&ntilde;a ha sido cambiada con &eacute;xito. Para Ingresar al sistema haga <a href="index.php" >Click ac&aacute;</a>
				<br />
				<hr>
				</div>
			</td>
		</tr>
		</table>
		</div>';
	}else{
		echo '
	  <div align="center">
	  <table>
	  	<tr>
			<td><img src="images/esl.jpg" width="125" height="120"/></td>
			<td>&nbsp;</td>
			<td><br /><h3>Datos Incorrectos</h3></td>
		<tr>
	  	<tr>
			<td colspan="3">
				<div align="center">
				El Usuario o la Contrase&ntilde;a ingresados no son v&aacute;lidos. verifique los datos e <a href="cambiopass.php" >Intente de Nuevo</a>
				<br />
				<hr>
				</div>
			</td>
		</tr>
		</table>
		</div>';
	}
}
?>