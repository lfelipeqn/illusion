<?php
      echo '
	  <script type="text/javascript" language="javascript">
	  	function Coincidencia(nueva,verifica){
			var n = document.getElementById(nueva)
			var v = document.getElementById(verifica)
			if(n.value==v.value){
					document.getElementById(\'igual\').style.visibility = \'visible\'
					document.getElementById(\'diferente\').style.visibility = \'hidden\'
					document.getElementById(\'valida\').value=1
			}else{
					document.getElementById(\'diferente\').style.visibility = \'visible\'
					document.getElementById(\'igual\').style.visibility = \'hidden\'
					document.getElementById(\'valida\').value=0
			}
		}
	  </script>
	  <form action="cambiarpass.php" method="post">
	  <div align="center">
	  <table>
	  	<tr>
			<td><img src="images/esl.jpg" width="125" height="120"/></td>
			<td>&nbsp;</td>
			<td><br /><h3>Sistema de Gesti&oacute;n de Procesos ESL</h3></td>
		<tr>
	  	<tr>
			<td colspan="3">
				<div align="center">
				<table>
					<tr>
					<td colspan="2">
						<div align="center"><h4><label>Cambio de Contrase&ntilde;a</label></h4></div>
					</td>
					</tr>
					<tr>
						<td>Usuario:</td>
						<td><input type="text" name="usuario" size="20" maxlength="20" /></td>
					</tr>
					<tr>
						<td>Contrase&ntilde;a Actual:</td>
						<td><input type="password" name="password" size="20" maxlength="20" /></td>
					</tr>
					<tr>
						<td>Contrase&ntilde;a Nueva:</td>
						<td><input type="password" id="npassword" name="npassword" size="20" maxlength="20" /></td>
					</tr>
					<tr>
						<td>Confirmar Contrase&ntilde;a Nueva:</td>
						<td>
							<input type="password" id="cnpassword" name="cnpassword" size="20" maxlength="20" onblur="Coincidencia(\'npassword\',\'cnpassword\')"/>
						</td>
						<td>
							<input type="hidden" id="valida" name="valida" value="0"/>
							<div id="diferente" style="visibility:hidden"><img src="images/denegado.png" width="16" height="16" /></div>
							<div id="igual" style="visibility:hidden"><img src="images/aprobado.png" width="16" height="16" /></div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
						<div align="right">
							<input type="submit" value=" Cambiar Mi Contrase&ntilde;a " size="80"/>
						</div>
						</td>
					</tr>
					<tr>
					<td colspan="2"><br /></td>
					</tr>
				</table>
				<br />
				<hr>
				</div>
			</td>
		</tr>
		</table>
		</div>
      </form>';
?>