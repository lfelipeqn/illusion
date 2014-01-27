<?php

if(isset($_SESSION['usuario'])){
	session_destroy();
}		
	include 'Connections/cnn.php';
    $connect=mysql_select_db($database_cnn,$cnn);
	include 'funciones.php';
	/*$ua=Navegador();
	if($ua['name']=='Mozilla Firefox'){*/
		echo'
			<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
				<script src="js/funciones.js" type="text/javascript"></script>
				<script src="js/control.js" type="text/javascript"></script>
				<title>ENTRETENIMIENTO SIN LIMITES</title>
                
                <script type="text/javascript">
                    function CambiaLogo(imag){
                    	var img = document.getElementById(imag)
                        
                    	var sel = document.getElementById(\'sunidad\').value
                        switch (sel){';
                        
                        $sqlunidad="SELECT unidades.IdUnidad, unidades.RutaLogo FROM unidades";
                        $cltunidad=mysql_query($sqlunidad,$cnn) or die(mysql_error());
                        while($rsunidad=mysql_fetch_assoc($cltunidad)){
                            echo '
                                case \''.$rsunidad['IdUnidad'].'\':
                                img.src=\''.$rsunidad['RutaLogo'].'\'
                                break;';
                        }
                    	echo '}
                    }
                </script>
                
			</head>
			<body>
			<form action="ingreso.php" method="post" id="inicial" name="inicial">
				<div align="center">
				<table>
					<tr>
						<td><img id="iminicio" name="iminicio" src="images/eslini.jpg"/></td>
						<td><br /><h3>Sistema de Procesos no Transaccionales</h3></td>
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
								<td><input type="password" id="password" name="password" size="27" maxlength="20" /></td>
								</tr>';
								
								$sql = "SELECT unidades.IdUnidad, unidades.Unidad FROM unidades";
								$xml = new DomDocument("1.0");
								$raiz=$xml->createElement("unidades");
								$consulta=mysql_query($sql,$cnn) or die(mysql_error());
								while($res = mysql_fetch_assoc($consulta)){ 
										$unidad=$xml->createElement("unidad");
										$idunidad=$unidad->setAttribute("idunidad",$res['IdUnidad']);
										$nunidad=$unidad->setAttribute("nombreunidad",utf8_encode($res['Unidad']));
										$raiz->appendChild($unidad);
								}
								$xml->appendChild($raiz);
								$xml->save("unidades.xml");

								echo '
								<tr>
									<td>Unidad de Negocio:</td>
									<td>
										<select id="sunidad" name="sunidad" onfocus="ListaXML(\'sunidad\',\'unidades.xml\',\'---- Todas las Unidades ----\')" onchange="CambiaLogo(\'iminicio\')"></select>
									</td>
								</tr>
								<tr>
									<td colspan="2">
									<div align="center">
										<input type="button" onclick="validarform(\'inicial\',\'inicio\')" value="     Ingreso al Sistema    " size="80"/>
									</div>
									</td>
								</tr>
								<tr>
								<td colspan="2"><br /></td>
								</tr>
								<tr>
									<td colspan="2"><div align="center"><a href="cambiopass.php">Cambiar Mi Contrase&ntilde;a</a></div></td>
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
	/*}else{
		echo '
		<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
				<title>ENTRETENIMIENTO SIN LIMITES</title>
			</head>
			<body>
				<div align="center">
					<img id="iminicio" name="iminicio" src="images/esl-ini.jpg"/>
				</div>
				<div align="center"><p>Esta Aplicaci&oacute;n ha sido dise&ntilde;ada para trabajar con el Navegador <a href="http://www.mozilla.com">Mozilla Firefox</a> Por favor Ingrese &uacute;nicamente usando este navegador ya que de lo contrario puede presentar inconvenientes con algunas funcionalidades.</p>
				<p><a href="http://www.mozilla.com">Descargue Mozilla Firefox Aqui</a></p></div>
			</body>
			</html>';	
	}*/
?>