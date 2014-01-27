<?php
	session_start();
	if(isset($_SESSION['usuario'])){
	include ('Connections/cnn.php');
	$proyecto=$_GET['seguimiento'];
	
	$sql = "select * from proyectos WHERE IdProyecto= '".$proyecto."'";
	
	$connect=mysql_select_db($database_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
	
echo'
<div class="cuerpo">
			<h3>Actualizaci&oacute;n de <span>Proyectos</span></h3>
			<p>A Continuaci&oacute;n se presenta la información asociada al proyecto seleccionado</p>
	<form action="proyectos/actualizaproy.php" method="post" id="modproyecto">
	<fieldset>
	<table id="results">
	<tr>
		<td colspan="4" >
			<div align="center">
				<b><label>INFORMACION DEL PROYECTO</label></b>
			</div>
		</td>
	</tr>';
	$rs=mysql_fetch_assoc($consulta);
	$fecha=NormalFecha($rs['FechaEvento']);
	$fecham=NormalFecha($rs['FechaMontaje']);
	$fechad=NormalFecha($rs['FechaDesmontaje']);
echo '
	<tr>
		<td><div align="left"><b><label>Nombre del Proyecto</label></b></div></td>
		<td>
			<div align="right">
			<input type="hidden" id="codp" name="codp" value="'.$proyecto.'"/>
			<input type="text" id="nproy" name="nproy" size="60" value="'.strtoupper($rs['NombreProyecto']).'"/>
			</div>
		</td>
	</tr>
	<tr>
		<td><div align="left"><b><label>Nombre del Contacto</label></b></div></td>
		<td>
			<div align="right">
			<input type="text" id="ncontac" name="ncontac" size="60" value="'.strtoupper($rs['NombreContacto']).'"/>
			</div>
		</td>
	</tr>
	<tr>
		<td><div align="left"><b><label>Email del Contacto</label></b></div></td>
		<td>
			<div align="right">
			<input type="text" id="nmail" name="nmail" size="60" value="'.strtolower($rs['EmailContacto']).'"/>
			</div>
		</td>
	</tr>
	<tr>
		<td><div align="left"><b><label>Tel&eacute;fono del Contacto</label></b></div></td>
		<td>
			<div align="right">
			<input type="text" id="ntelcontac" name="ntelcontac" size="40" value="'.strtoupper($rs['TelefonoContacto']).'"/>
			</div>
		</td>
	</tr>
	<tr>
		<td><div align="left"><b><label>Ciudades</label></b></div></td>
		<td>
			<div align="right">
			<input type="text" id="ncity" name="ncity" size="60" value="'.strtoupper($rs['Ciudades']).'"/>
			</div>
		</td>
	</tr>
	<tr>
		<td><div align="left"><b><label>Lugar del Evento</label></b></div></td>
		<td>
			<div align="right">
			<input type="text" id="nlugar" name="nlugar" size="60" value="'.strtoupper($rs['LugarEvento']).'"/>
			</div>
		</td>
	</tr>
	<tr>
		<td><div align="left"><b><label>Fecha del Evento</label></b></div></td>
		<td>
			<div align="right">
			<input type="text" id="nfechae" name="nfechae" value="'.$fecha.'" READONLY title="MM/DD/YYYY" onClick="displayCalendar(this);"/>
			</div>
		</td>
	</tr>
	<tr>
		<td><div align="left"><b><label>Fecha de Montaje</label></b></div></td>
		<td>
			<div align="right">
			<input type="text" id="nfecham" name="nfecham" value="'.$fecham.'" READONLY title="MM/DD/YYYY" onClick="displayCalendar(this);"/>
			</div>
		</td>
	</tr>
	<tr>
		<td><div align="left"><b><label>Fecha de Desmontaje</label></b></div></td>
		<td>
			<div align="right">
			<input type="text" id="nfechad" name="nfechad" value="'.$fechad.'" READONLY title="MM/DD/YYYY" onClick="displayCalendar(this);"/>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2"><div align="left">
		<div>&nbsp;</div>
		<b><label>Observaciones</label></b>
		</div></td>
	</tr>
	<tr>
		<td colspan="2" rowspan="6">
		<div align="justify">
		<input type="text" id="nobs" name="nobs" size="100" value="'.strtoupper($rs['Observaciones']).'"/>
		</div>
		</td>
	</tr>
	</table>
	<div align="justify">
	<input type="button" onclick="validarform(\'modproyecto\', \'mproyecto\')" name="enviar"  value="  Actualizar Datos del Proyecto  " />
	</div>
</fieldset>
</form>
</div>';
mysql_close($cnn);
	}
?>