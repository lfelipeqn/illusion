<?php
	//session_start();
	include ('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$connect=mysql_select_db($rental_cnn,$cnn);
	echo'
	<div class="cuerpo">
		<h2><span>Registro de </span>Adicionales</h2>
        <p>A trav&eacute;s de este registro se habilitan nuevas opciones adicionales a ingresar a la cotizaci&oacute;n. Por ejemplo: Transporte Equipos, Imprevistos, Gastos Adicionales, etc...</p>
		<div align="left">
		<form action="cotizaciones/ingresaconcepto.php" enctype="multipart/form-data" method="post" id="fnew" name="fnew">
		  <table id="results" class="estilotabla">
			<tr>
				<td><b>Nombre del Concepto</b></td>
				<td><input type="text" id="conc" name="conc" /></td>	
			</tr>
			<tr>
				<td colspan="2"><div align="center"><input style="background-color:white; font-weight:bold;"type="submit" id="bbadd" name="bbadd" value="Registrar Concepto Adicional"/></div></td>
			</tr>
		</table>
		</form>
		</div>
	</div>';
	mysql_close($cnn);
}
?>