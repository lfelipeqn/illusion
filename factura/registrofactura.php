<?php
	
if(isset($_SESSION['usuario'])){
	include('Connections/cnn.php');
	$connect=mysql_select_db($database_cnn,$cnn);
	$sql = "SELECT clientes.IdCliente, clientes.NombreCliente, clientes.Identificacion, clientes.DV, clientes.PersonaContacto, clientes.TelefonoContacto, clientes.CExtension, clientes.email, clientes.Direccion, clientes.Fax, clientes.FExtension, clientes.Pais, clientes.Ciudad, tipoempresa.TipoEmpresa FROM clientes INNER JOIN tipoempresa ON clientes.TipoEmpresa = tipoempresa.IdTipo INNER JOIN clientes_unidades ON clientes.IdCliente = clientes_unidades.IdCliente INNER JOIN usuarios_unidades ON clientes_unidades.IdUnidad = usuarios_unidades.IdUnidad INNER JOIN presupuestos ON presupuestos.IdCliente = clientes.IdCliente WHERE presupuestos.Aprobabo = 1 AND usuarios_unidades.usuario ='".$_SESSION['usuario']."'";
	
	if($_SESSION['unidad']!=0){
		$sql.=" AND usuarios_unidades.IdUnidad = '".$_SESSION['unidad']."'";
	}
	$sql.=" GROUP BY clientes.IdCliente, clientes.NombreCliente, clientes.Identificacion, clientes.DV, clientes.PersonaContacto, clientes.TelefonoContacto, clientes.CExtension, clientes.email, clientes.Direccion, clientes.Fax, clientes.FExtension, clientes.Pais, clientes.Ciudad, tipoempresa.TipoEmpresa ORDER BY clientes.NombreCliente ASC";
	
	$xml = new DomDocument("1.0");
	$raiz=$xml->createElement("clientes");
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
	while($res = mysql_fetch_assoc($consulta)){ 
			$cliente=$xml->createElement("cliente");
			$idcliente=$cliente->setAttribute("idcliente",$res['IdCliente']);
			$icliente=$cliente->setAttribute("identificacion",$res['Identificacion']);
			$dvcliente=$cliente->setAttribute("dv",$res['DV']);
			$tecliente=$cliente->setAttribute("tipoempresa",$res['TipoEmpresa']);
			$ncliente=$cliente->setAttribute("nombrecliente",utf8_encode($res['NombreCliente']));
			
			$sqlproyectos="SELECT proyectos.IdProyecto, proyectos.NombreProyecto, proyectos.LugarEvento, proyectos.NombreContacto, proyectos.EmailContacto, proyectos.IdUnidad FROM proyectos INNER JOIN presupuestos ON proyectos.IdProyecto = presupuestos.IdProyecto WHERE presupuestos.Aprobabo = 1 AND proyectos.IdCliente=".$res['IdCliente'];
			
			if($_SESSION['unidad']!=0){
				$sqlproyectos.=" AND proyectos.IdUnidad = '".$_SESSION['unidad']."'";
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
	$xml->save("prclientes.xml");
?>
<div class="cuerpo">
	<h3>Registro de <span>Facturas</span></h3>
	<form action="factura/nfactura.php" method="post" id="contacts-form">
		<fieldset>
			<table>
				<tr>
					<td><label style="font-size:13px"><b>No. de Factura:</b></label></td>
					<td colspan="3">
						<div align="right">
						<input type="text" id="nfact" name="nfact" style="font-weight:bold;width:120px;text-align:right;font-size:13px; color:FF0000";/>
						</div>
					</td>
				</tr>
				<tr>
					<td><label>Fecha de Emisi&oacute;n</label></td>
					<td><input type="text" id="femi" name="femi" READONLY title="MM/DD/YYYY" onClick="displayCalendar(this);"/></td>
					<td><label>Fecha de Vencimiento</label></td>
					<td><input type="text" id="fven" name="fven" READONLY title="MM/DD/YYYY" onClick="displayCalendar(this);"/></td>
				</tr>
				<tr>
					<td><label>Nombre del Cliente</label></td>
					<td><select id="ncliente" name="ncliente" onfocus="Contenido('ncliente')" onchange="; document.getElementById('tot').value=0; document.getElementById('subt').value=0; document.getElementById('iva').value=0; Actualiza('ncliente','pproy')" style="width:120px">
				</select></td>
					<td><label>Nombre del Proyecto</label></td>
					<td>
                        <select id="pproy" name="pproy" style="width:120px">
				        </select>
                    </td>
				</tr>
				<tr>
					<td colspan="3"><div align="left"><b><label>SUBTOTAL: </label></b></div></td>
					<td><input type="text" id="subt" name="subt" style="text-align:right; font-weight:bold" readonly="readonly" /></td>
				</tr>
				<tr>
					<td colspan="3"><div align="left"><b><label>IVA: </label></b></div></td>
					<td><input type="text" id="iva" name="iva" style="text-align:right; font-weight:bold" readonly="readonly" /></td>
				</tr>
				<tr>
					<td colspan="3"><div align="left"><b><label>TOTAL: </label></b></div></td>
					<td><input type="text" id="tot" name="tot" style="text-align:right; font-weight:bold" readonly="readonly" /></td>
				</tr>
			</table>
			<input type="button" style="font-weight:bold;width:480px" value="Registrar Factura" onclick="validarform('contacts-form','factura')"/>
		</fieldset>
	<form>
</div>

<script>
	
    $('#pproy').change(function(){
        var pres=$('#pproy').val();
        $.ajax({
            type:"post",
            url:"factura/ajaxfactura.php",
            data:{"proyecto":pres},
            success: function(response){
                var sub = '$ '+FormatoNum(response);
                var iva = '$ '+FormatoNum(response*0.16);
                var tot = '$ '+FormatoNum(response*1.16);
                
                $('#subt').val(sub)
                $('#iva').val(iva)
                $('#tot').val(tot)
                
            }
        })
    }) 
	
    
	function Contenido(elm){
		var lista = document.getElementById(elm)
		if (lista.childNodes.length<=1){
			var xmlDoc=CargaXML('prclientes.xml')
			var cero = document.createElement('option')
			cero.id='0'
			cero.text='-- Elija un Cliente --'
			lista.appendChild(cero)
			for (var i=0;xmlDoc.childNodes[0].childNodes.length;i++){
				var idc = xmlDoc.childNodes[0].childNodes[i].attributes[0].nodeValue
				var nombre = xmlDoc.childNodes[0].childNodes[i].attributes[4].nodeValue
				var opcion = document.createElement('option')
				opcion.value=idc
				opcion.text=nombre
				lista.appendChild(opcion)
			}
		}
	}
	
	function Actualiza(origen,destino){
		var cual
		var dest
		var nuevo
		cual=document.getElementById(origen)
		dest=document.getElementById(destino)
		
		var xmlDoc=CargaXML('prclientes.xml')
		for (var i=0;xmlDoc.childNodes[0].childNodes.length;i++){
			var id = xmlDoc.childNodes[0].childNodes[i].attributes[0].nodeValue
			if(id==cual.value){
				var cliente = xmlDoc.childNodes[0].childNodes[i]
				
				if ( dest.hasChildNodes() ){
					while ( dest.childNodes.length >= 1 ){
						dest.removeChild( dest.firstChild )
					} 
				}
				
				var cero = document.createElement('option')
				cero.id='0'
				cero.text='-- Elija un Proyecto --'
				dest.appendChild(cero)
				for (var j=0; cliente.childNodes.length;j++){
					var ip = cliente.childNodes[j].attributes[0].nodeValue
					var np = cliente.childNodes[j].attributes[4].nodeValue
					var opcion = document.createElement('option')
					opcion.value=ip
					opcion.text=ip+' - '+np
					dest.appendChild(opcion)
				}
			}		
		}
	}
	
</script>

<?
}
?>