<?php
if(isset($_SESSION['usuario'])){
	include('Connections/cnn.php');
echo'
<div class="cuerpo">
		<h3>Creaci&oacute;n de <span>Proyectos</span></h3>
        </br>
        <form action="proyectos/insertaproyecto.php" method="post" id="contacts-form">
    		<fieldset>
            	<table>
                	<tr>
                    	<td><label> Elija el Cliente: </label></td>
                        <td colspan="3">';
						$sql = "SELECT clientes.IdCliente, clientes.NombreCliente, clientes.PersonaContacto, clientes.TelefonoContacto, clientes.email FROM clientes INNER JOIN clientes_unidades ON clientes.IdCliente = clientes_unidades.IdCliente INNER JOIN usuarios_unidades ON clientes_unidades.IdUnidad = usuarios_unidades.IdUnidad WHERE usuarios_unidades.usuario='".$_SESSION['usuario']."'";
						if($_SESSION['unidad']!=0){
							$sql.=" AND usuarios_unidades.IdUnidad='".$_SESSION['unidad']."'";
						}
						$sql.=" ORDER BY clientes.NombreCliente ASC";
						$connect=mysql_select_db($database_cnn,$cnn);
						$consulta=mysql_query($sql,$cnn) or die(mysql_error());
						echo '<select id="scliente" name="scliente" onchange="ContactoXML(\'scliente\', \'contacts-form\', \'contacto.xml\')">
							<option value="0">---- Elija el Cliente a Consultar ----</option>';
						$xml = new DomDocument("1.0");
						$raiz=$xml->createElement("clientes");
						while($registros=mysql_fetch_assoc($consulta)){
							echo '<option value="'.$registros['IdCliente'].'" >'.$registros['NombreCliente'].'</option>';
							$cliente=$xml->createElement("cliente");
							$idcliente=$cliente->setAttribute("idcliente",$registros['IdCliente']);
							$ctcliente=$cliente->setAttribute("contacto",utf8_encode($registros['PersonaContacto']));
							$telcliente=$cliente->setAttribute("telefono",$registros['TelefonoContacto']);
							$mailcliente=$cliente->setAttribute("mail",utf8_encode($registros['email']));
							$raiz->appendChild($cliente);
						}
						$xml->appendChild($raiz);
						$xml->save("contacto.xml");
					echo '</select>
                        </td>
                    </tr>
					<tr>
						<td><label> Nombre del Proyecto </label></td>
                        <td><input type="text" id="nproy" name="nproy"/></td>
						<td><label>Nombre del Contacto</label></td>
                        <td><input type="text" id="ncontac" name="ncontac" /></td>
					</tr>
                    <tr>
						<td><label>Telefono del Contacto</label></td>
                        <td><input type="text" id="ntelcontac" name="ntelcontac"/></td>
						<td><label>Email del Contacto</label></td>
                        <td><input type="text" id="nmail" name="nmail" /></td>
                    </tr>
					<tr>
                    	<td><label>Ciudades</label></td>
                        <td><input type="text" id="ncity" name="ncity" /></td>
						<td><label>Lugar del Evento</label></td>
                        <td><input type="text" id="nlugar" name="nlugar"/></td>
                    </tr>
					<tr>
                    	<td><label>Fecha del Evento</label></td>
                        <td><input type="text" id="nfechae" name="nfechae" READONLY title="MM/DD/YYYY" onClick="displayCalendar(this);"/></td>
						<td><label>Fecha de Montaje</label></td>
                        <td><input type="text" id="nfecham" name="nfecham" READONLY title="MM/DD/YYYY" onClick="displayCalendar(this);"/></td>
                    </tr>
					<tr>
						<td><label>Fecha de Desmontaje</label></td>
                        <td><input type="text"id="nfechad" name="nfechad" READONLY title="MM/DD/YYYY" onClick="displayCalendar(this);"/></td>
						<td><label>Observaciones</label></td>
						<td >
						<input type="text" id="nobs" name="nobs">
						</td>
					</tr>
                    <tr>
                    	<td colspan="4">
                        	<div align="center">
                        	  <input type="button" id="enviar" name="enviar" value="Crear Nuevo Proyecto" onclick="validarform(\'contacts-form\',\'proyecto\')"/>
                        	</div>
                      </td>
                    </tr>
           		</table>
        	</fieldset>
	    <form>
</div>';
}
?>