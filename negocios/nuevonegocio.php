<?php
	include 'Connections/cnn.php';
if(isset($_SESSION['usuario'])){
	$connect=mysql_select_db($database_cnn,$cnn);
	
	$sql = "SELECT clientes.IdCliente, clientes.NombreCliente, clientes.Identificacion, clientes.DV, clientes.PersonaContacto, clientes.TelefonoContacto, clientes.CExtension, clientes.email, clientes.Direccion, clientes.Fax, clientes.FExtension, clientes.Pais, clientes.Ciudad, tipoempresa.TipoEmpresa
FROM clientes INNER JOIN tipoempresa ON clientes.TipoEmpresa = tipoempresa.IdTipo INNER JOIN clientes_unidades ON clientes.IdCliente = clientes_unidades.IdCliente INNER JOIN usuarios_unidades ON clientes_unidades.IdUnidad = usuarios_unidades.IdUnidad WHERE usuarios_unidades.usuario='".$_SESSION['usuario']."'";
	
	if($_SESSION['unidad']!=0){
		$sql.=" AND usuarios_unidades.IdUnidad='".$_SESSION['unidad']."'";
	}
	
	$sql.=" GROUP BY clientes.IdCliente, clientes.NombreCliente, clientes.Identificacion, clientes.DV, clientes.PersonaContacto, clientes.TelefonoContacto, clientes.CExtension, clientes.email, clientes.Direccion, clientes.Fax, clientes.FExtension, clientes.Pais, clientes.Ciudad, tipoempresa.TipoEmpresa ORDER BY clientes.NombreCliente ASC";
	
	$xml = new DomDocument("1.0");
	$raiz=$xml->createElement("negocios");
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
	while($res = mysql_fetch_assoc($consulta)){ 
			$cliente=$xml->createElement("cliente");
			$idcliente=$cliente->setAttribute("idcliente",$res['IdCliente']);
			$icliente=$cliente->setAttribute("identificacion",$res['Identificacion']);
			$dvcliente=$cliente->setAttribute("dv",$res['DV']);
			$tecliente=$cliente->setAttribute("tipoempresa",$res['TipoEmpresa']);
			$ncliente=$cliente->setAttribute("nombrecliente",utf8_encode($res['NombreCliente']));
			
			$sqlproyectos="SELECT proyectos.IdProyecto, proyectos.NombreProyecto, proyectos.LugarEvento, proyectos.NombreContacto, proyectos.EmailContacto FROM proyectos INNER JOIN usuarios_unidades ON proyectos.IdUnidad = usuarios_unidades.IdUnidad WHERE proyectos.IdCliente=".$res['IdCliente']." AND usuarios_unidades.usuario='".$_SESSION['usuario']."'";
			
			if($_SESSION['unidad']!=0){
				$sqlproyectos.=" AND usuarios_unidades.IdUnidad='".$_SESSION['unidad']."'";
			}
	
			$sqlproyectos.=" ORDER BY proyectos.NombreProyecto ASC";
			
			$cltproyectos=mysql_query($sqlproyectos,$cnn) or die(mysql_error());
			while($rsproyectos=mysql_fetch_assoc($cltproyectos)){
				$proyecto=$xml->createElement("proyecto");
				$idproyecto=$proyecto->setAttribute("idproyecto",$rsproyectos['IdProyecto']);
				$lgproyecto=$proyecto->setAttribute("lugar",utf8_encode($rsproyectos['LugarEvento']));
				$cnproyecto=$proyecto->setAttribute("contacto",utf8_encode($rsproyectos['NombreContacto']));
				$emproyecto=$proyecto->setAttribute("mail",utf8_encode($rsproyectos['EmailContacto']));
				$nproyecto=$proyecto->setAttribute("nombreproyecto",utf8_encode($rsproyectos['NombreProyecto']));
				
				$sqlpresup="SELECT presupuestos.IdPresupuesto, presupuestos.SubEspectaculos, presupuestos.SubEventosCorp, presupuestos.SubNuevasTec, presupuestos.SubProduccion, presupuestos.Subtotal, presupuestos.Descuento, presupuestos.KnowHow, presupuestos.Total FROM presupuestos WHERE ((presupuestos.IdProyecto=".$rsproyectos['IdProyecto'].") AND ( presupuestos.Aprobabo=1))";
				$cltpresup=mysql_query($sqlpresup,$cnn) or die(mysql_error());
				while($rspresup=mysql_fetch_assoc($cltpresup)){
					$presupuesto=$xml->createElement("presupuesto");
					$espresup=$presupuesto->setAttribute("especta",$rspresup['SubEspectaculos']);
					$ecpresup=$presupuesto->setAttribute("eventoc",$rspresup['SubEventosCorp']);
					$ntpresup=$presupuesto->setAttribute("nuevat",$rspresup['SubNuevasTec']);
					$prpresup=$presupuesto->setAttribute("produccion",$rspresup['SubProduccion']);
					$stpresup=$presupuesto->setAttribute("subtotal",$rspresup['Subtotal']);
					$dspresup=$presupuesto->setAttribute("descuento",$rspresup['Descuento']);
					$knpresup=$presupuesto->setAttribute("knowhow",$rspresup['KnowHow']);
					$ttpresup=$presupuesto->setAttribute("total",$rspresup['Total']);
					$idpresupuesto=$presupuesto->setAttribute("idpresupuesto",utf8_encode($rspresup['IdPresupuesto']));
					$proyecto->appendChild($presupuesto);
				}
				$cliente->appendChild($proyecto);
			}
			$raiz->appendChild($cliente);
	}
	$xml->appendChild($raiz);
	$xml->save("negocios.xml");
	
	$xml = new DomDocument("1.0");
	$raiz=$xml->createElement("proyectos");
			
	$sqlproyectos="SELECT proyectos.IdProyecto, proyectos.NombreProyecto, proyectos.LugarEvento, proyectos.NombreContacto, proyectos.EmailContacto FROM proyectos INNER JOIN usuarios_unidades ON proyectos.IdUnidad = usuarios_unidades.IdUnidad WHERE usuarios_unidades.usuario='".$_SESSION['usuario']."'";
			
	if($_SESSION['unidad']!=0){
		$sqlproyectos.=" AND usuarios_unidades.IdUnidad='".$_SESSION['unidad']."'";
	}
	
	$sqlproyectos.=" ORDER BY proyectos.NombreProyecto ASC";
	
	$cltproyectos=mysql_query($sqlproyectos,$cnn) or die(mysql_error());
	while($rsproyectos=mysql_fetch_assoc($cltproyectos)){
		$proyecto=$xml->createElement("proyecto");
		$idproyecto=$proyecto->setAttribute("idproyecto",$rsproyectos['IdProyecto']);
		$lgproyecto=$proyecto->setAttribute("lugar",utf8_encode($rsproyectos['LugarEvento']));
		$cnproyecto=$proyecto->setAttribute("contacto",utf8_encode($rsproyectos['NombreContacto']));
		$emproyecto=$proyecto->setAttribute("mail",utf8_encode($rsproyectos['EmailContacto']));
		$nproyecto=$proyecto->setAttribute("nombreproyecto",utf8_encode($rsproyectos['NombreProyecto']));
				
		$sqlpresup="SELECT presupuestos.IdPresupuesto, presupuestos.SubEspectaculos, presupuestos.SubEventosCorp, presupuestos.SubNuevasTec, presupuestos.SubProduccion, presupuestos.Subtotal, presupuestos.Descuento, presupuestos.KnowHow, presupuestos.Total FROM presupuestos WHERE ((presupuestos.IdProyecto=".$rsproyectos['IdProyecto'].") AND ( presupuestos.Aprobabo=1))";
		$cltpresup=mysql_query($sqlpresup,$cnn) or die(mysql_error());
		while($rspresup=mysql_fetch_assoc($cltpresup)){
			$presupuesto=$xml->createElement("presupuesto");
			$espresup=$presupuesto->setAttribute("especta",$rspresup['SubEspectaculos']);
			$ecpresup=$presupuesto->setAttribute("eventoc",$rspresup['SubEventosCorp']);
			$ntpresup=$presupuesto->setAttribute("nuevat",$rspresup['SubNuevasTec']);
			$prpresup=$presupuesto->setAttribute("produccion",$rspresup['SubProduccion']);
			$stpresup=$presupuesto->setAttribute("subtotal",$rspresup['Subtotal']);
			$dspresup=$presupuesto->setAttribute("descuento",$rspresup['Descuento']);
			$knpresup=$presupuesto->setAttribute("knowhow",$rspresup['KnowHow']);
			$ttpresup=$presupuesto->setAttribute("total",$rspresup['Total']);
			$idpresupuesto=$presupuesto->setAttribute("idpresupuesto",utf8_encode($rspresup['IdPresupuesto']));
			$proyecto->appendChild($presupuesto);
	}
	$raiz->appendChild($proyecto);
	}
	$xml->appendChild($raiz);
	$xml->save("proyectos.xml");
	
echo '
<div class="cuerpo">
	<form action="negocios/creanegocio.php" method="post" id="formingreso" name="formingreso">
		<fieldset>
			<div class="menuheaders">
			<div align="left"><h2>Hoja de <span>Negocios</span></h2></div>
			</div>
			<ul class="menucontents">
			<li>
			<table>
			<tr>
			  <td><label> Cliente </label></td>
			  <td>
				<input type="hidden" id="tienepres" name="tienepres" value=0 />
				<select id="ncliente" name="ncliente" onfocus="Contenido(\'ncliente\')" onchange="Actualiza(\'ncliente\',\'pproy\')">
				</select>
			  </td>
			  <td><label> NIT </label></td>
			  <td>
				<div align="right">
				<input type="text" id="nnit" name="nnit" READONLY size="30">
				</div>
			  </td>
			  <td><label> D.V. </label></td>
			  <td>
				<div align="right">
				<input type="text" id="ndv" name="ndv" READONLY size="5">
				</div>
			  </td>
			</tr>
			<tr>
			  <td><label>Tipo de Empresa</label></td>
			  <td><div align="right"><input id="pptipoe" name="pptipoe" READONLY type="text"/></div></td>
			  <td><label>EMail</label></td>
			  <td colspan="3">
				<div align="right"><input id="mailn" name="mailn" type="text" READONLY size="57"/></div>
			  </td>
			</tr>
			<tr>
			  <td><label> Proyecto </label></td>
			  <td>
				<select id="pproy" name="pproy" onchange="DProyecto(\'pproy\')">
				</select>
			  </td>
			  <td><label>Lugar del Evento</label></td>
			  <td colspan="3">
				<div align="right"><input id="plugar" type="text" READONLY name="plugar" size="57"></div>
			  </td>
			</tr>
			<tr>
				<td><label>Plazo de Pago</label></td>
				<td colspan="7">
				<label><input type="radio" id="nplazon1" name="nplazo" value="1" />&nbsp;30 d&iacute;as&nbsp;</label>
				<label><input type="radio" id="nplazon2" name="nplazo" value="2" />&nbsp;45 d&iacute;as&nbsp;</label>
				<label><input type="radio" id="nplazon3" name="nplazo" value="3" />&nbsp;60 d&iacute;as&nbsp;</label>
				<label><input type="radio" id="nplazon4" name="nplazo" value="4" />&nbsp;90 d&iacute;as&nbsp;</label>
				<label><input type="radio" id="nplazon5" name="nplazo" value="5" />&nbsp;Contado&nbsp;</label>		
				<label><input type="checkbox" id="nplazon6" name="nplazon6" value="6" onclick="Habilitar(\'nplazon6\')"/>&nbsp;Anticipo&nbsp;</label>
				<label><input type="text" id="nantic" name="nantic" disabled="disabled" size="3" onblur="CalculaPorcentaje(\'vcompra\',\'nantic\', \'vanticipo\')"/> % Anticipo</label></td>
			</tr>
			<tr>
				<td><label>Otro / Observaciones</label></td>
				<td colspan="5">
				<input type="text" id="nobs" name="nobs" size="100" height="50"/>
				</td>
			</tr>
			</table>
			</li>
			</ul>
			<div class="menuheaders">
			<div align="left"><h2>Informaci&oacute;n del <span>Negocio</span></h2></div>
			</div>
			<ul class="menucontents">
			<li>
			<table>
				<tr>
					<td><label>CONS. PRESUPUESTO</label></td>
					<td><input type="text" id="consp" name="consp" value="0" READONLY style="width:142px"/></td>
					<td><label>TOTAL PRESUPUESTO:</label></td>
					<td colspan="3"><input type="text" id="totp" name="totp" value="0" READONLY style="width: 143px; text-align:right"/></td>
				</tr>
				<tr>
					<td><label>COSTOS ADMINISTRACION</label></td>
					<td>
						<input type="text" id="padm" name="padm" value="0" maxlength="6" style="width:30px" onblur="Pago(\'totp\', \'padm\', \'vadm\')"/><b>%</b>
						<input type="text" id="vadm" name="vadm" value="0" READONLY style="width:100px"/>
					</td>
					<td><label>COMISION DIRECTOR GENERAL</label></td>
					<td>
						<input type="text" id="pdg" name="pdg" value="0" maxlength="6" style="width:30px" onblur="Pago(\'totp\', \'pdg\', \'vdg\')"/><b>%</b>
						<input type="text" id="vdg" name="vdg" value="0" READONLY style="width:100px"/>
					</td>
                </tr>
                <tr>
					<td><label>COMISION COMERCIAL</label></td>
					<td>
						<input type="text" id="pbm" name="pbm" value="0" maxlength="6" style="width:30px" onblur="Pago(\'totp\', \'pbm\', \'vbm\')"/><b>%</b>
						<input type="text" id="vbm" name="vbm" value="0" READONLY style="width:100px"/>
					</td>
                    <td><label>COMISION PRODUCCION</label></td>
					<td>
						<input type="text" id="ppr" name="ppr" value="0" maxlength="6" style="width:30px" onblur="Pago(\'totp\', \'ppr\', \'vpr\')"/><b>%</b>
						<input type="text" id="vpr" name="vpr" value="0" READONLY style="width:100px"/>
					</td>
				</tr>
			</table>
			</li>
			</ul>
			<div align="center">
			<input type=button onclick="Pago(\'totp\', \'padm\', \'vadm\'), Pago(\'totp\', \'pdg\', \'vdg\'), Pago(\'totp\', \'pbm\', \'vbm\'), Pago(\'totp\', \'ppr\', \'vpr\'), validarform(\'formingreso\', \'negocio\')" name="enviar" value="Registrar Nuevo Negocio">
			</div>
			<div align="left">
				<p>NOTA: La informaci&oacute;n presentada en este formulario est&aacute; sujeta al contrato o los acuerdos establecidos entre el proveedor y la Compa&ntilde;ia.</p>
			</div>
		</fieldset>
	<form>
</div>';
}
?>