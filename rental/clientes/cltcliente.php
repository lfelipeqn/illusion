<?php

	//session_start();

if(isset($_SESSION['usuario'])){

	include ('../Connections/cnn.php');

	

	$sql = "SELECT clientes.Identificacion, clientes.NombreCliente, clientes.Digito, clientes.Telefono, clientes.Extension, clientes.Email, clientes.Direccion, clientes.Fax, clientes.ExtensionFax FROM clientes";

	$connect=mysql_select_db($rental_cnn,$cnn);

	$consulta=mysql_query($sql,$cnn) or die(mysql_error());

	echo'<div class="cuerpo">

		<h2><span>Consulta de </span>Clientes</h2>

        </br>

		<div align="center">

		<table id="results" class="estilotabla"><tr>';

	echo '<td class="estilocelda"><div align="center"><label>Opciones</label></div></td>';

	echo '<td class="estilocelda"><div align="center"><label>Nombre Cliente</label></div></td>';

	echo '<td class="estilocelda"><div align="center"><label>Identificaci&oacute;n</label></div></td>';

	echo '<td class="estilocelda"><div align="center"><label>Digito Verificaci&oacute;n</label></div></td>';

	echo '<td class="estilocelda"><div align="center"><label>Telefono</label></div></td>';

	echo '<td class="estilocelda"><div align="center"><label>Extensi&oacute;n</label></div></td>';

	echo '<td class="estilocelda"><div align="center"><label>Direcci&oacute;n</label></div></td>';

	echo '<td class="estilocelda"><div align="center"><label>Correo</label></div></td>';

	echo '<td class="estilocelda"><div align="center"><label>Fax</label></div></td>';

	echo '<td class="estilocelda"><div align="center"><label>Extensi&oacute;n Fax</label></div></td>';

	while($registros=mysql_fetch_assoc($consulta)){

		echo '<tr>';

		echo '<td class="estilocontenido"><a href="rental.php?location=clieedit&codigo='.$registros['Identificacion'].'"><img src="images/editar.png"/></a></td>';

		echo '<td class="estilocontenido"><div>'.$registros['NombreCliente'].'</div></td>';

		echo '<td class="estilocontenido"><div>'.$registros['Identificacion'].'</div></td>';

		echo '<td class="estilocontenido"><div>'.$registros['Digito'].'</div></td>';

		echo '<td class="estilocontenido"><div>'.$registros['Telefono'].'</div></td>';

		echo '<td class="estilocontenido"><div>'.$registros['Extension'].'</div></td>';

		echo '<td class="estilocontenido"><div>'.$registros['Direccion'].'</div></td>';

		echo '<td class="estilocontenido"><div>'.$registros['Email'].'</div></td>';

		echo '<td class="estilocontenido"><div>'.$registros['Fax'].'</div></td>';

		echo '<td class="estilocontenido"><div>'.$registros['ExtensionFax'].'</div></td>';

		echo '</tr>';

	}

	echo '</table></div><br /><div align="center" id="pageNavPosition" class="paginador"></div>';

	echo '</div>';

	mysql_close($cnn);

	echo '

	 <script type="text/javascript">

        var pager = new Pager(\'results\', 10); 

        pager.init(); 

        pager.showPageNav(\'pager\', \'pageNavPosition\'); 

        pager.showPage(1);

    </script>

	';

}

?>