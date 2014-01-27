<?php
	session_start();
	include('../Connections/cnn.php');
    include('../funciones.php');
	
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

		if(Privilegios($_SESSION['perfil'],'IngresoRental')){
			header('Location: rental.php');
		}else{
			header('Location: accesonegado.php');
		}
	}else{
		echo'
		<html>
		  <head>
		      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		      <title>RENTAL ESL</title>
		  </head>
		  <body>
		      <form action="ingreso.php" method="post" id="inicial" name="inicial">
                <div align="center">
                <table>
				    <tr>
				        <td><img id="iminicio" name="iminicio" src="images/esl-ini.jpg"/></td>
				        <td>&nbsp;</td>
				        <td><br /><h3>Sistema de Gesti&oacute;n de Procesos ESL</h3></td>
                    </tr>
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