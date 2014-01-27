<?php
	//session_start();
	include '../Connections/cnn.php';
if(isset($_SESSION['usuario'])){
	$contador=1;
	$connect=mysql_select_db($rental_cnn,$cnn);
	$evento=$_GET['codigo'];
	$precio=$_GET['tprec'];
	ListaInventario();
	
echo '
<div class="cuerpo">
  <form action="eventos/registrarentrada.php" method="post" id="formdetalle">
  	<input type="hidden" id="nequipos" name="nequipos" value="1"/>
	<input type="hidden" id="idevento" name="idevento" value="'.$evento.'"/>
	<input type="hidden" id="tipop" name="tipop" value="'.$precio.'"/>
		<div align="left"><h2><span>Entrada de </span>Equipos</h2></div>
		<hr>
		<p>Por Favor ejecute ahora la lectura de los codigos de cada equipo a ingresar en el almac&eacute;n o digite manualmente el c&oacute;digo del mismo.</p>';
		echo '<table id="tequipos" name="tequipos">
		<thead>
		<tr>
			<td class="estilocelda"><label>Opciones</label></td>
			<td class="estilocelda"><label>Codigo Equipo</label></td>
			<td class="estilocelda"><label>Nombre Equipo</label></td>
			<td class="estilocelda"><label>Valor Equipos</label></td>
		</tr>
		</thead>
		<tbody id="cuerpo" name="cuerpo"><tr><td class="estilocontenido"><img src="images/elimina.gif" onclick="EliminaFila(\'tequipos\',this,\'cuerpo\',\'nequipos\')"/></td><td class="estilocontenido"><input type="text" style="width:100px" id="ceq1" name="ceq1" autocomplete="off" onkeyup="Alistamiento(event, this, \'tipop\', \'Entrada\')" /></td><td class="estilocontenido"><input type="text" id="neq1" name="neq1" READONLY /></td><td class="estilocontenido"><input type="text" style="width:120px" id="veq1" name="veq1" READONLY /></td></tr></tbody>
	</table>';
		echo '<div align="center"><input type="button" value="Registrar Entrada de Equipos" style="width:500px;" onclick="confirmar(\'formdetalle\')"/></div>
  </form>
</div>';
}
?>