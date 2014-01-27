<?php
	session_start();
	include 'Connections/cnn.php';
if(isset($_SESSION['usuario'])){
	$sql = "SELECT clientes.IdCliente, clientes.NombreCliente, clientes.Identificacion, clientes.DV, clientes.PersonaContacto, clientes.TelefonoContacto, clientes.CExtension, clientes.email, clientes.Direccion, clientes.Fax, clientes.FExtension, clientes.Pais, clientes.Ciudad, tipoempresa.TipoEmpresa FROM clientes INNER JOIN tipoempresa ON clientes.TipoEmpresa = tipoempresa.IdTipo INNER JOIN clientes_unidades ON clientes.IdCliente = clientes_unidades.IdCliente INNER JOIN usuarios_unidades ON clientes_unidades.IdUnidad = usuarios_unidades.IdUnidad WHERE (usuarios_unidades.usuario='".$_SESSION['usuario']."')";
	
	if($_SESSION['unidad']!=0){
		$sql.=" AND (clientes_unidades.IdUnidad='".$_SESSION['unidad']."')";
	}
	
	$sql.=" GROUP BY clientes.IdCliente, clientes.NombreCliente, clientes.Identificacion, clientes.DV, clientes.PersonaContacto, clientes.TelefonoContacto, clientes.CExtension, clientes.email, clientes.Direccion, clientes.Fax, clientes.FExtension, clientes.Pais, clientes.Ciudad, tipoempresa.TipoEmpresa ORDER BY clientes.NombreCliente ASC";
	
	$xml = new DomDocument("1.0");
	$raiz=$xml->createElement("clientes");
	$connect=mysql_select_db($database_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
	while($res = mysql_fetch_assoc($consulta)){ 
			$cliente=$xml->createElement("cliente");
			$idcliente=$cliente->setAttribute("idcliente",$res['IdCliente']);
			$icliente=$cliente->setAttribute("identificacion",$res['Identificacion']);
			$dvcliente=$cliente->setAttribute("dv",$res['DV']);
			$tecliente=$cliente->setAttribute("tipoempresa",$res['TipoEmpresa']);
			$ncliente=$cliente->setAttribute("nombrecliente",utf8_encode($res['NombreCliente']));
			
			$sqlproyectos="SELECT proyectos.IdProyecto, proyectos.NombreProyecto, proyectos.LugarEvento, proyectos.NombreContacto, proyectos.EmailContacto, proyectos.IdUnidad FROM proyectos INNER JOIN usuarios_unidades ON proyectos.IdUnidad = usuarios_unidades.IdUnidad WHERE proyectos.IdCliente='".$res['IdCliente']."' AND usuarios_unidades.usuario='".$_SESSION['usuario']."'";
			
			if($_SESSION['unidad']!=0){
				$sqlproyectos.=" AND usuarios_unidades.IdUnidad='".$_SESSION['unidad']."'";
			}
			
			$cltproyectos=mysql_query($sqlproyectos,$cnn) or die(mysql_error());
			while($rsproyectos=mysql_fetch_assoc($cltproyectos)){
				$proyecto=$xml->createElement("proyecto");
				$idproyecto=$proyecto->setAttribute("idproyecto",$rsproyectos['IdProyecto']);
				$lgproyecto=$proyecto->setAttribute("lugar",utf8_encode($rsproyectos['LugarEvento']));
				$cnproyecto=$proyecto->setAttribute("contacto",utf8_encode($rsproyectos['NombreContacto']));
				$emproyecto=$proyecto->setAttribute("mail",utf8_encode($rsproyectos['EmailContacto']));
				$nproyecto=$proyecto->setAttribute("nombreproyecto",utf8_encode($rsproyectos['NombreProyecto']));
				$cliente->appendChild($proyecto);
			}
			$raiz->appendChild($cliente);
	}
	$xml->appendChild($raiz);
	$xml->save("clientes.xml");
	
	$xml = new DomDocument("1.0");
	$raiz=$xml->createElement("proyectos");
	
	$xmlnego = new DomDocument("1.0");
	$root=$xmlnego->createElement("proyectos");
			
	$sqlproyectos="SELECT proyectos.IdProyecto, proyectos.NombreProyecto, proyectos.LugarEvento, proyectos.NombreContacto, proyectos.EmailContacto, proyectos.FechaEvento, proyectos.FechaMontaje, proyectos.FechaDesmontaje FROM proyectos INNER JOIN usuarios_unidades ON proyectos.IdUnidad = usuarios_unidades.IdUnidad WHERE usuarios_unidades.usuario='".$_SESSION['usuario']."'";
	
	if($_SESSION['unidad']!=0){
		$sqlproyectos.=" AND usuarios_unidades.IdUnidad='".$_SESSION['unidad']."'";
	}
	
	$cltproyectos=mysql_query($sqlproyectos,$cnn) or die(mysql_error());
	while($rsproyectos=mysql_fetch_assoc($cltproyectos)){
		$proyecto=$xml->createElement("proyecto");		
		$idproyecto=$proyecto->setAttribute("idproyecto",$rsproyectos['IdProyecto']);
		$lgproyecto=$proyecto->setAttribute("lugar",utf8_encode($rsproyectos['LugarEvento']));
		$cnproyecto=$proyecto->setAttribute("contacto",utf8_encode($rsproyectos['NombreContacto']));
		$emproyecto=$proyecto->setAttribute("mail",utf8_encode($rsproyectos['EmailContacto']));
		$nproyecto=$proyecto->setAttribute("nombreproyecto",utf8_encode($rsproyectos['NombreProyecto']));
		$fevento=$proyecto->setAttribute("fechaevento",$rsproyectos['FechaEvento']);
		$fmontaje=$proyecto->setAttribute("fechamontaje",$rsproyectos['FechaMontaje']);
		$fdesmontaje=$proyecto->setAttribute("fechadesmontaje",$rsproyectos['FechaDesmontaje']);
		
		$negoproy=$xmlnego->createElement("proyecto");
		$negoidproy=$negoproy->setAttribute("idproyecto",$rsproyectos['IdProyecto']);
		$negonproy=$negoproy->setAttribute("nombreproyecto",utf8_encode($rsproyectos['NombreProyecto']));
		
		$sqlnego="SELECT negocios.IdNegocio, negocios.IdCliente, negocios.IdProyecto, negocios.IdPresupuesto, negocios.FechaCreacion FROM negocios WHERE negocios.IdProyecto='".$rsproyectos['IdProyecto']."'";
		$cltnego=mysql_query($sqlnego,$cnn) or die(mysql_error());
		while($rsnego=mysql_fetch_assoc($cltnego)){
			$negocio=$xmlnego->createElement("negocio");
			$idnego=$negocio->setAttribute("idnegocio",$rsnego['IdNegocio']);
			$idclie=$negocio->setAttribute("idcliente",$rsnego['IdCliente']);
			$idproy=$negocio->setAttribute("idproyecto",$rsnego['IdProyecto']);
			$idpresup=$negocio->setAttribute("idpresupuesto",$rsnego['IdPresupuesto']);
			$fechac=$negocio->setAttribute("fechacreacion",$rsnego['FechaCreacion']);
			$negoproy->appendChild($negocio);
		}		
				
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
	$root->appendChild($negoproy);
	}
	$xml->appendChild($raiz);
	$xml->save("infoproyecto.xml");
	
	$xmlnego->appendChild($root);
	$xmlnego->save("infonegocio.xml");
	
	$cltproveedor="select proveedores.IdProveedor, proveedores.NombreProveedor from proveedores ORDER BY proveedores.NombreProveedor ASC";
	$xml = new DomDocument("1.0");
	$raiz=$xml->createElement("proveedores");
	$sprov=mysql_query($cltproveedor,$cnn) or die(mysql_error());
	while ($rsprov=mysql_fetch_assoc($sprov)){
			$proveedor=$xml->createElement("proveedor");
			$idproveedor=$proveedor->setAttribute("idproveedor",$rsprov['IdProveedor']);
			$tnproveedor=$xml->createTextNode(utf8_encode($rsprov['NombreProveedor']));
			$proveedor->appendChild($tnproveedor);
			$raiz->appendChild($proveedor);
	}
	$xml->appendChild($raiz);
	$xml->save("proveedores.xml");
	
	$xml = new DomDocument("1.0");
	$raiz=$xml->createElement("cargos");
	$cltesp="SELECT cargos.IdCargo, cargos.NombreCargo FROM cargos";
	$scargo=mysql_query($cltesp,$cnn) or die(mysql_error());
	while ($rsesp=mysql_fetch_assoc($scargo)){
		$cargo=$xml->createElement("cargo");
		$idcargo=$cargo->setAttribute("idcargo",$rsesp['IdCargo']);
		$nombrecargo=$cargo->setAttribute("nombrecargo",utf8_encode($rsesp['NombreCargo']));
		$stperson="SELECT cargos_personas.IdUsuario, cargos_personas.Usuario, usuarios.Nombre, cargos_personas.IdCargo FROM cargos_personas Inner Join usuarios ON cargos_personas.IdUsuario = usuarios.IdUsuario WHERE cargos_personas.IdCargo =  '".$rsesp['IdCargo']."'";
		$cltperson=mysql_query($stperson,$cnn) or die(mysql_error());
		while($rsperson=mysql_fetch_assoc($cltperson)){
			$especialista=$xml->createElement("especialista");
			$idesp=$especialista->setAttribute("usuario",utf8_encode($rsperson['Usuario']));
			$nombre=$especialista->setAttribute("nombre",utf8_encode($rsperson['Nombre']));
			$cargo->appendChild($especialista);
		}
		$raiz->appendChild($cargo);
	}
	$xml->appendChild($raiz);
	$xml->save("especialidades.xml");

echo '
<div class="cuerpo">
        <form action="produccion/creaproduccion.php" method="post" id="formingreso" name="formingreso">
    		<fieldset>
            	<div class="menuheaders">
        		<div align="left"><h2>Hoja de <span>Producci&oacute;n</span></h2></div>
                </div>
                <ul class="menucontents">
                <li>
	          	<table>
	            <tr>
	              <td><label> Cliente </label></td>
	              <td colspan="3">
                  	<select id="ncliente" name="ncliente" onchange="Actualiza(\'ncliente\',\'pproy\')" onfocus="Contenido(\'ncliente\')">
   					</select>
                  </td>
                  <td><label> Consecutivo Evento </label></td>
	              <td>
                  	<input type="text" id="consevt" name="consevt" READONLY >
                  </td>
                </tr>
                <tr>
                  <td><label> NIT </label></td>
	              <td><input type="text" id="nnit" name="nnit" READONLY></td>
                  <td><label>D.V.</label></td>
                  <td><input type="text" id="ndv" name="ndv" READONLY size="2"></td>
	              <td><label>Tipo de Empresa</label></td>
	              <td><input id="pptipoe" name="pptipoe" READONLY type="text"/></td>
                </tr>
	            <tr>
                  <td colspan="2"><label>Contacto Evento</label></td>
	              <td colspan="2"><input id="ncontactc" name="ncontactc" type="text" READONLY/></td>
	              <td><label> Evento </label></td>
	              <td>
					<select id="pproy" name="pproy" onchange="DProyecto(\'pproy\')">
   					</select>
                  </td>
                </tr>
                <tr>
	              <td colspan="2"><label>Lugar del Evento</label></td>
	              <td colspan="2"><input id="plugar" type="text" READONLY name="plugar"></td>
                  <td><label>Total Presupuesto</label></td>
	              <td><input id="totpres" name="totpres" type="text" READONLY/></td>
                </tr>
                <tr>
	              <td colspan="2"><label> Productor Ejecutivo </label></td>
	              <td colspan="2"><select id="prodej" name="prodej">';
				  $cadpr="select usuarios.Nombre AS Nombre, cargos_personas.IdUsuario AS IdUsuario, cargos_personas.Usuario AS Usuario, cargos.NombreCargo AS NombreCargo from ((cargos_personas join usuarios on((cargos_personas.IdUsuario = usuarios.IdUsuario))) join cargos on((cargos_personas.IdCargo = cargos.IdCargo))) WHERE cargos.NombreCargo =  'Productor Ejecutivo'";
				  echo '<option value="0"> No Aplica</option>';
				  $clprod=mysql_query($cadpr,$cnn) or die(mysql_error());
				  while($rsprod=mysql_fetch_assoc($clprod)){
						echo'<option value="'.$rsprod['IdUsuario'].'">'.$rsprod['Nombre'].'</option>';
				  }
				  echo'</select></td>
	              <td><label>Email del Contacto</label></td>
	              <td><input id="mailn" name="mailn" type="text" READONLY/></td>
                </tr>
                </table>
                </li>
                </ul>
                <div class="menuheaders">
                <div align="left"><h2>Informaci&oacute;n <span>Ejecutiva</span></h2></div>
                </div>
                <ul class="menucontents">
                <li>
                <table>
                	<tr>
                        <td><label>Productor de Campo</label></td>
                        <td colspan="3"><select id="prodcampo" name="prodcampo">';
				  $cadprc="SELECT usuarios.IdUsuario, usuarios.Nombre, cargos.NombreCargo FROM cargos_personas Inner Join cargos ON cargos_personas.IdCargo = cargos.IdCargo Inner Join usuarios ON usuarios.IdUsuario = cargos_personas.IdUsuario WHERE cargos.NombreCargo =  'Productor'";
				  $clprodc=mysql_query($cadprc,$cnn) or die(mysql_error());
				  echo '<option value="0"> No Aplica</option>';
				  while($rsprodc=mysql_fetch_assoc($clprodc)){
						echo'<option value="'.$rsprodc['IdUsuario'].'">'.$rsprodc['Nombre'].'</option>';
				  }
				  echo'</select>
                        </td>
                    	<td><label>Consecutivo P.G.</label></td>
                        <td><input type="text" id="conspg" name="conspg" READONLY/></td>
                    </tr>
                    <tr>
                        <td><label>Fecha de Montaje</label></td>
                        <td><input type="text" id="fechamon" name="fechamon" READONLY/></td>
                        <td><label>Fecha de Evento</label></td>
                        <td><input type="text" id="fechaevt" name="fechaevt" READONLY/></td>
                        <td><label>Fecha de Desmontaje</label></td>
                        <td><input type="text" id="fechades" name="fechades" READONLY/></td>
                    </tr>
                    <tr>
                    	<td><label>Direcci&oacute;n Montaje</label></td>
                        <td colspan="3">
                        	<input type="text" id="dmont" name="dmont" size="50"/>
                        </td>                       
                    </tr>
                </table>
                </li>
                </ul>
                <div class="menuheaders">
                <div align="left"><h2>Informaci&oacute;n <span>Detallada</span></h2></div>
                </div>
                <ul class="menucontents">
                <li>
                <table id="eventocorporativo" name="eventocorporativo"></table>
				<table id="nvatecnologia" name="nvatecnologia"></table>
				<table id="equiposesl" name="equiposesl"></table>
				<table id="gastosprod" name="gastosprod"></table>
				<table id="imprevistos" name="imprevistos"></table>
				<table id="personal" name="personal"></table>
				<br />
				<h4>Resumen Costos Producci&oacute;n</h4>
				<table>
					<tr>
						<td><label>Gastos Equipos ESL</label></td>
						<td><input type="text" id="resge" name="resge" READONLY value="0"/></td>
						<td><label>Gastos Eventos Corporativos</label></td>
						<td><input type="text" id="resec" name="resec" READONLY value="0"/></td>
						<td><label>Gastos Nvas. Tecnologias</label></td>
						<td><input type="text" id="resnt" name="resnt" READONLY value="0"/></td>
					</tr>
					<tr>
						<td><label>Gastos Producci&oacute;n</label></td>
						<td><input type="text" id="respd" name="respd" READONLY value="0"/></td>
						<td><label>Gastos Imprevistos</label></td>
						<td><input type="text" id="resgi" name="resgi" READONLY value="0"/></td>
						<td><label>Gastos Personal</label></td>
						<td><input type="text" id="respr" name="respr" READONLY value="0"/></td>
					</tr>
					<tr>
						<td colspan="2"><div align="right"><b><label>TOTAL GASTOS</label></b></right></td>
						<td colspan="2"><div align="right"><input type="text" id="resvt" name="resvt" READONLY value="0"/></div></td>
					</tr>
				</table>
                </li>
                </ul>
                <div align="center">
				<input type="button" name="enviar" id="enviar" value="Registrar Hoja de Producci&oacute;n" size="80" onclick="CalculaProd(), validarform(\'formingreso\',\'produccion\')"/>
				<input type="hidden" name="seguimiento" value="">
				<input type="hidden" name="tipo" value="N">
				</div>
                <div align="left">
                	<p>NOTA: La informaci&oacute;n presentada en este formulario est&aacute; sujeta al contrato o los acuerdos establecidos entre el proveedor y la Compa&ntilde;ia.</p>
                </div>
			</fieldset>
	    </form>
</div>';
}
?>