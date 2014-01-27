<?php
	//session_start();
	include('Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$connect=mysql_select_db($database_cnn,$cnn);
	$sql = "SELECT clientes.IdCliente, clientes.NombreCliente, clientes.Identificacion, clientes.DV, clientes.PersonaContacto, clientes.TelefonoContacto, clientes.CExtension, clientes.email, clientes.Direccion, clientes.Fax, clientes.FExtension, clientes.Pais, clientes.Ciudad, tipoempresa.TipoEmpresa FROM clientes INNER JOIN tipoempresa ON clientes.TipoEmpresa = tipoempresa.IdTipo INNER JOIN clientes_unidades ON clientes.IdCliente = clientes_unidades.IdCliente INNER JOIN usuarios_unidades ON clientes_unidades.IdUnidad = usuarios_unidades.IdUnidad WHERE usuarios_unidades.usuario ='".$_SESSION['usuario']."'";

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

			$sqlproyectos="SELECT proyectos.IdProyecto, proyectos.NombreProyecto, proyectos.LugarEvento, proyectos.NombreContacto, proyectos.EmailContacto, proyectos.IdUnidad FROM proyectos WHERE proyectos.IdCliente=".$res['IdCliente'];
			
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

	echo "\n
	<script type=\"text/javascript\">

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
					opcion.text=np
					dest.appendChild(opcion)
				}
			}		
		}
	}

	</script>";
    
	echo '
<div class="cuerpo">
	<form action="presupuestos/creapresup.php" method="post" id="formingreso">
		<fieldset>
			<div class="menuheaders">
			<div align="left"><h2>Datos <span>Generales</span></h2></div>
			</div>
			<ul class="menucontents">
			<li>
			<table>
			<tr>

			  <td colspan="4">

			  </td>

			</tr>

			<tr>

			  <td><label> Cliente </label></td>

			  <td>

				<select id="ncliente" name="ncliente" onfocus="Contenido(\'ncliente\')" onchange="Actualiza(\'ncliente\',\'pproy\')">

				</select>

			  </td>

			  <td><label> Proyecto </label></td>

			  <td>

				<select id="pproy" name="pproy">

				</select>

			  </td>

			</tr>

			</table>

			</li>

			</ul>

			<div class="menuheaders">

			<div align="left"><h2>Eventos <span>Corporativos</span></h2></div>

			</div>

			<ul class="menucontents">

			<li>

			<table id="eventmark" name="eventmark" >

			<tr>

				<td colspan="5">

					<div align="center">EVENT MARKETING</div>

				</td>

			</tr>

			<tr>

				<td colspan="2">

					<div align="center">OPCIONES</div>

				</td>

				<td>

					<div align="center">DESCRIPCI&Oacute;N</div>

				</td>

				<td>

					<div align="center">CANTIDAD</div>

				</td>

				<td>

					<div align="center">D&Iacute;AS</div>

				</td>

				<td>

					<div align="center">Vr. UNITARIO</div>

				</td>

				<td>

					<div align="center">Vr. TOTAL</div>

				</td>

			</tr>

			<tr>

				<input type="hidden" id="tteventmark" name="tteventmark" value=1 />

			</tr>

			<tbody>

			<tr>

				<td><img src="images/mas.png" onclick="NuevaFila(\'eventmark\')"/></td>

				<td><img src="images/menos.png" onclick="EliminaFila(\'eventmark\', this), CalculaST()"/></td>

				<td><input type="text" id="emds1" name="emds1" size="50" /></td>

				<td><input type="text" id="emcn1" name="emcn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'emcn1\', \'emdd1\', \'emvu1\', \'emvt1\')"/></td>

				<td><input type="text" id="emdd1" name="emdd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'emcn1\', \'emdd1\', \'emvu1\', \'emvt1\')"/></td>

				<td><input type="text" id="emvu1" name="emvu1" size="15" onblur="FormatoN(this)" onchange="CalculaTotal(\'emcn1\', \'emdd1\', \'emvu1\', \'emvt1\')"/></td>

				<td><input type="text" id="emvt1" name="emvt1" size="15" value="0" READONLY /></td>

			</tr>

			</tbody>

			</table>

			<table id="rentsupp" name="rentsupp" >

			<tr>

				<td colspan="5">

					<div align="center">RENTAL & SUPPORT</div>

				</td>

			</tr>

			<tr>

				<td colspan="2">

					<div align="center">OPCIONES</div>

				</td>

				<td>

					<div align="center">DESCRIPCI&Oacute;N</div>

				</td>

				<td>

					<div align="center">CANTIDAD</div>

				</td>

				<td>

					<div align="center">D&Iacute;AS</div>

				</td>

				<td>

					<div align="center">Vr. UNITARIO</div>

				</td>

				<td>

					<div align="center">Vr. TOTAL</div>

				</td>

			</tr>

			<tr>

				<input type="hidden" id="ttrentsupp" name="ttrentsupp" value=1 />

			</tr>

			<tbody>

			<tr>

				<td><img src="images/mas.png" onclick="NuevaFila(\'rentsupp\')"/></td>

				<td><img src="images/menos.png" onclick="EliminaFila(\'rentsupp\', this), CalculaST()"/></td>

				<td><input type="text" id="rsds1" name="rsds1" size="50" /></td>

				<td><input type="text" id="rscn1" name="rscn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'rscn1\', \'rsdd1\', \'rsvu1\', \'rsvt1\')"/></td>

				<td><input type="text" id="rsdd1" name="rsdd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'rscn1\', \'rsdd1\', \'rsvu1\', \'rsvt1\')"/></td>

				<td><input type="text" id="rsvu1" name="rsvu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'rscn1\', \'rsdd1\', \'rsvu1\', \'rsvt1\')"/></td>

				<td><input type="text" id="rsvt1" name="rsvt1" value="0" size="15" READONLY/></td>

			</tr>

			</tbody>

			</table>

			<br  />

			<br  />

			<hr />

			<div align="right">

			<table>

			<tr>

				<td><b><label>SUBTOTAL EVENTOS CORPORATIVOS</label>&nbsp;&nbsp;</b></td>

				<td><input type="text" id="stecvt1" name="stecvt1" onfocus="CalculaST()" value="0" READONLY size="50"/></td>

			</tr>

			</table>

			</div>

			</li>

			</ul>

			<div class="menuheaders">

			<div align="left"><h2>Nuevas <span>Tecnolog&iacute;as</span></h2></div>

			</div>

			<ul class="menucontents">

			<li>

			<table id="videohd3d" name="videohd3d">

			<tr>

				<td colspan="5">

					<div align="center">VIDEO HD & 3D</div>

				</td>

			</tr>

			<tr>

				<td colspan="2">

					<div align="center">OPCIONES</div>

				</td>

				<td>

					<div align="center">DESCRIPCI&Oacute;N</div>

				</td>

				<td>

					<div align="center">CANTIDAD</div>

				</td>

				<td>

					<div align="center">D&Iacute;AS</div>

				</td>

				<td>

					<div align="center">Vr. UNITARIO</div>

				</td>

				<td>

					<div align="center">Vr. TOTAL</div>

				</td>

			</tr>

			<tr>

				<input type="hidden" id="ttvideohd3d" name="ttvideohd3d" value=1 />

			</tr>

			<tbody>

			<tr>

				<td><img src="images/mas.png" onclick="NuevaFila(\'videohd3d\')"/></td>

				<td><img src="images/menos.png" onclick="EliminaFila(\'videohd3d\', this), CalculaST()"/></td>

				<td><input type="text" id="vdds1" name="vdds1" size="50" /></td>

				<td><input type="text" id="vdcn1" name="vdcn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'vdcn1\', \'vddd1\', \'vdvu1\', \'vdvt1\')"/></td>

				<td><input type="text" id="vddd1" name="vddd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'vdcn1\', \'vddd1\', \'vdvu1\', \'vdvt1\')"/></td>

				<td><input type="text" id="vdvu1" name="vdvu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'vdcn1\', \'vddd1\', \'vdvu1\', \'vdvt1\')"/></td>

				<td><input type="text" id="vdvt1" name="vdvt1" value="0" size="15" READONLY/></td>

			</tr>

			</tbody>

			</table>

			<table id="keynote" name="keynote">

			<tr>

				<td colspan="5">

					<div align="center">KEYNOTE</div>

				</td>

			</tr>

			<tr>

				<td colspan="2">

					<div align="center">OPCIONES</div>

				</td>

				<td>

					<div align="center">DESCRIPCI&Oacute;N</div>

				</td>

				<td>

					<div align="center">CANTIDAD</div>

				</td>

				<td>

					<div align="center">D&Iacute;AS</div>

				</td>

				<td>

					<div align="center">Vr. UNITARIO</div>

				</td>

				<td>

					<div align="center">Vr. TOTAL</div>

				</td>

			</tr>

			<tr>

				<input type="hidden" id="ttkeynote" name="ttkeynote" value=1 />

			</tr>

			<tbody>

			<tr>

				<td><img src="images/mas.png" onclick="NuevaFila(\'keynote\')"/></td>

				<td><img src="images/menos.png" onclick="EliminaFila(\'keynote\', this), CalculaST()"/></td>

				<td><input type="text" id="knds1" name="knds1" size="50" /></td>

				<td><input type="text" id="kncn1" name="kncn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'kncn1\', \'kndd1\', \'knvu1\', \'knvt1\')"/></td>

				<td><input type="text" id="kndd1" name="kndd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'kncn1\', \'kndd1\', \'knvu1\', \'knvt1\')"/></td>

				<td><input type="text" id="knvu1" name="knvu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'kncn1\', \'kndd1\', \'knvu1\', \'knvt1\')"/></td>

				<td><input type="text" id="knvt1" name="knvt1" value="0" size="15" READONLY/></td>

			</tr>

			</tbody>

			</table>

			<table id="visualex" name="visualex">

			<tr>

				<td colspan="5">

					<div align="center">VISSUAL EXPERIENCE</div>

				</td>

			</tr>

			<tr>

				<td colspan="2">

					<div align="center">OPCIONES</div>

				</td>

				<td>

					<div align="center">DESCRIPCI&Oacute;N</div>

				</td>

				<td>

					<div align="center">CANTIDAD</div>

				</td>

				<td>

					<div align="center">D&Iacute;AS</div>

				</td>

				<td>

					<div align="center">Vr. UNITARIO</div>

				</td>

				<td>

					<div align="center">Vr. TOTAL</div>

				</td>

			</tr>

			<tr>

			<input type="hidden" id="ttvisualex" name="ttvisualex" value=1 />

			</tr>

			<tbody>

			<tr>

				<td><img src="images/mas.png" onclick="NuevaFila(\'visualex\')"/></td>

				<td><img src="images/menos.png" onclick="EliminaFila(\'visualex\', this), CalculaST()"/></td>

				<td><input type="text" id="veds1" name="veds1" size="50" /></td>

				<td><input type="text" id="vecn1" name="vecn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'vecn1\', \'vedd1\', \'vevu1\', \'vevt1\')"/></td>

				<td><input type="text" id="vedd1" name="vedd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'vecn1\', \'vedd1\', \'vevu1\', \'vevt1\')"/></td>

				<td><input type="text" id="vevu1" name="vevu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'vecn1\', \'vedd1\', \'vevu1\', \'vevt1\')"/></td>

				<td><input type="text" id="vevt1" name="vevt1" value="0" size="15" READONLY/></td>

			</tr>

			</tbody>

			</table>

			<table id="branding" name="branding">

			<tr>

				<td colspan="5">

					<div align="center">BRANDING INTERACTION</div>

				</td>

			</tr>

			<tr>

				<td colspan="2">

					<div align="center">OPCIONES</div>

				</td>

				<td>

					<div align="center">DESCRIPCI&Oacute;N</div>

				</td>

				<td>

					<div align="center">CANTIDAD</div>

				</td>

				<td>

					<div align="center">D&Iacute;AS</div>

				</td>

				<td>

					<div align="center">Vr. UNITARIO</div>

				</td>

				<td>

					<div align="center">Vr. TOTAL</div>

				</td>

			</tr>

			<tr>

			<input type="hidden" id="ttbranding" name="ttbranding" value=1 />

			</tr>

			<tbody>

			<tr>

				<td><img src="images/mas.png" onclick="NuevaFila(\'branding\')"/></td>

				<td><img src="images/menos.png" onclick="EliminaFila(\'branding\', this), CalculaST()"/></td>

				<td><input type="text" id="bids1" name="bids1" size="50" /></td>

				<td><input type="text" id="bicn1" name="bicn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'bicn1\', \'bidd1\', \'bivu1\', \'bivt1\')"/></td>

				<td><input type="text" id="bidd1" name="bidd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'bicn1\', \'bidd1\', \'bivu1\', \'bivt1\')"/></td>

				<td><input type="text" id="bivu1" name="bivu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'bicn1\', \'bidd1\', \'bivu1\', \'bivt1\')"/></td>

				<td><input type="text" id="bivt1" name="bivt1" value="0" size="15" READONLY/></td>

			</tr>

			</tbody>

			</table>

			<br  />

			<br  />

			<hr />

			<div align="right">

			<table>

			<tr>

				<td><b><label>SUBTOTAL NUEVAS TECNOLOGIAS</label>&nbsp;&nbsp;</b></td>

				<td><input type="text" id="stntvt2" name="stntvt2" value="0" READONLY size="50" /></td>

			</tr>

			</table>

			</li>

			</ul>

			<div class="menuheaders">

			<div align="left"><h2>Espe<span>ct&aacute;culos</span></h2></div>

			</div>

			<ul class="menucontents">

			<li>

			<table id="performance" name="performance">

			<tr>

				<td colspan="5">

					<div align="center">PERFORMANCE</div>

				</td>

			</tr>

			<tr>

				<td colspan="2">

					<div align="center">OPCIONES</div>

				</td>

				<td>

					<div align="center">DESCRIPCI&Oacute;N</div>

				</td>

				<td>

					<div align="center">CANTIDAD</div>

				</td>

				<td>

					<div align="center">D&Iacute;AS</div>

				</td>

				<td>

					<div align="center">Vr. UNITARIO</div>

				</td>

				<td>

					<div align="center">Vr. TOTAL</div>

				</td>

			</tr>

			<tr>

				<input type="hidden" id="ttperformance" name="ttperformance" value=1 />

			</tr>

			<tbody>

			<tr>

				<td><img src="images/mas.png" onclick="NuevaFila(\'performance\')"/></td>

				<td><img src="images/menos.png" onclick="EliminaFila(\'performance\', this), CalculaST()"/></td>

				<td><input type="text" id="pfds1" name="pfds1" size="50" /></td>

				<td><input type="text" id="pfcn1" name="pfcn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'pfcn1\', \'pfdd1\', \'pfvu1\', \'pfvt1\')"/></td>

				<td><input type="text" id="pfdd1" name="pfdd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'pfcn1\', \'pfdd1\', \'pfvu1\', \'pfvt1\')"/></td>

				<td><input type="text" id="pfvu1" name="pfvu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'pfcn1\', \'pfdd1\', \'pfvu1\', \'pfvt1\')"/></td>

				<td><input type="text" id="pfvt1" name="pfvt1" value="0" size="15" READONLY/></td>

			</tr>

			</tbody>

			</table>

			<table id="management" name="management">

			<tr>

				<td colspan="5">

					<div align="center">MANAGEMENT</div>

				</td>

			</tr>

			<tr>

				<td colspan="2">

					<div align="center">OPCIONES</div>

				</td>

				<td>

					<div align="center">DESCRIPCI&Oacute;N</div>

				</td>

				<td>

					<div align="center">CANTIDAD</div>

				</td>

				<td>

					<div align="center">D&Iacute;AS</div>

				</td>

				<td>

					<div align="center">Vr. UNITARIO</div>

				</td>

				<td>

					<div align="center">Vr. TOTAL</div>

				</td>

			</tr>

			<tr>

				<input type="hidden" id="ttmanagement" name="ttmanagement" value=1 />

			</tr>

			<tbody>

			<tr>

				<td><img src="images/mas.png" onclick="NuevaFila(\'management\')"/></td>

				<td><img src="images/menos.png" onclick="EliminaFila(\'management\', this), CalculaST()"/></td>

				<td><input type="text" id="mgds1" name="mgds1" size="50" /></td>

				<td><input type="text" id="mgcn1" name="mgcn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'mgcn1\', \'mgdd1\', \'mgvu1\', \'mgvt1\')"/></td>

				<td><input type="text" id="mgdd1" name="mgdd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'mgcn1\', \'mgdd1\', \'mgvu1\', \'mgvt1\')"/></td>

				<td><input type="text" id="mgvu1" name="mgvu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'mgcn1\', \'mgdd1\', \'mgvu1\', \'mgvt1\')"/></td>

				<td><input type="text" id="mgvt1" name="mgvt1" value="0" size="15" READONLY/></td>

			</tr>

			</tbody>

			</table>

			

			<table id="own" name="own">

			<tr>

				<td colspan="5">

					<div align="center">OWN SHOWS</div>

				</td>

			</tr>

			<tr>

				<td colspan="2">

					<div align="center">OPCIONES</div>

				</td>

				<td>

					<div align="center">DESCRIPCI&Oacute;N</div>

				</td>

				<td>

					<div align="center">CANTIDAD</div>

				</td>

				<td>

					<div align="center">D&Iacute;AS</div>

				</td>

				<td>

					<div align="center">Vr. UNITARIO</div>

				</td>

				<td>

					<div align="center">Vr. TOTAL</div>

				</td>

			</tr>

			<tr>

			<input type="hidden" id="ttown" name="ttown" value=1 />

			</tr>

			<tbody>

			<tr>

				<td><img src="images/mas.png" onclick="NuevaFila(\'own\')"/></td>

				<td><img src="images/menos.png" onclick="EliminaFila(\'own\', this), CalculaST()"/></td>

				<td><input type="text" id="osds1" name="osds1" size="50" /></td>

				<td><input type="text" id="oscn1" name="oscn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'oscn1\', \'osdd1\', \'osvu1\', \'osvt1\')"/></td>

				<td><input type="text" id="osdd1" name="osdd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'oscn1\', \'osdd1\', \'osvu1\', \'osvt1\')"/></td>

				<td><input type="text" id="osvu1" name="osvu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'oscn1\', \'osdd1\', \'osvu1\', \'osvt1\')"/></td>

				<td><input type="text" id="osvt1" name="osvt1" value="0" size="15" READONLY/></td>

			</tr>

			</tbody>

			</table>

			<br  />

			<br  />

			<hr />

			<div align="right">

			<table>

			<tr>

				<td><b><label>SUBTOTAL ESPECTACULOS</label>&nbsp;&nbsp;</b></td>

				<td><input type="text" id="stesvt3" name="stesvt3" value="0" READONLY size="50" /></td>

			</tr>

			</table>

			</li>

			</ul>

			</li>

			</ul>

			<div class="menuheaders">

			<div align="left"><h2>Producci&oacute;n Ejecutiva y <span>de Campo</span></h2></div>

			</div>

			<ul class="menucontents">

			<li>

			<table id="produccion" name="produccion">

			<tr>

				<td colspan="5">

					<div align="center">PRODUCCI&Oacute;N EJECUTIVA Y DE CAMPO</div>

				</td>

			</tr>

			<tr>

				<td colspan="2">

					<div align="center">OPCIONES</div>

				</td>

				<td>

					<div align="center">DESCRIPCI&Oacute;N</div>

				</td>

				<td>

					<div align="center">CANTIDAD</div>

				</td>

				<td>

					<div align="center">D&Iacute;AS</div>

				</td>

				<td>

					<div align="center">Vr. UNITARIO</div>

				</td>

				<td>

					<div align="center">Vr. TOTAL</div>

				</td>

			</tr>

			<tr>

			<input type="hidden" id="ttproduccion" name="ttproduccion" value=1 />

			</tr>

			<tbody>

			<tr>

				<td><img src="images/mas.png" onclick="NuevaFila(\'produccion\')"/></td>

				<td><img src="images/menos.png" onclick="EliminaFila(\'produccion\', this), CalculaST()"/></td>

				<td><input type="text" id="peds1" name="peds1" size="50" /></td>

				<td><input type="text" id="pecn1" name="pecn1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'pecn1\', \'pedd1\', \'pevu1\', \'pevt1\')"/></td>

				<td><input type="text" id="pedd1" name="pedd1" size="15" onblur="CalculaST()" onchange="CalculaTotal(\'pecn1\', \'pedd1\', \'pevu1\', \'pevt1\')"/></td>

				<td><input type="text" id="pevu1" name="pevu1" size="15" onblur="CalculaST(), FormatoN(this)" onchange="CalculaTotal(\'pecn1\', \'pedd1\', \'pevu1\', \'pevt1\')"/></td>

				<td><input type="text" id="pevt1" name="pevt1" value="0" size="15" READONLY/></td>

			</tr>

			</tbody>

			</table>

			<br  />

			<br  />

			<hr />

			<div align="right">

			<table>

			<tr>

				<td><b><label>SUBTOTAL PRODUCCION EJECUTIVA Y DE CAMPO</label>&nbsp;&nbsp;</b></td>

				<td><input type="text" id="stpevt4" name="stpevt4" value="0" READONLY size="50" /></td>

			</tr>

			</table>

			</li>

			</ul>

			<table>

			<tr>

				<td><label>SUBTOTAL PROYECTO</label></td>

				<td><input type="text" id="stp" name="stp" value="0" READONLY onfocus="CalculaST(), TT(this, \'stecvt1\',\'stntvt2\',\'stesvt3\',\'stpevt4\')"/></td>

				<td><img src="images/fleft.png" width="15" height="15" onclick="CalculaST(), TT(\'stp\', \'stecvt1\',\'stntvt2\',\'stesvt3\',\'stpevt4\')"/></td>

			</tr>

			<tr>

				<td><label>DESCUENTO ESPECIAL</label></td>

				<td><input type="text" id="dse" name="dse" value="0" onchange="FormatoN(this)" onblur="TT(\'stds\', \'stp\',\'dse\',\'knh\')" /></td>

			</tr>

			<tr>

				<td><label>KNOW HOW</label></td>

				<td><input type="text" id="knh" name="knh" value="0" onchange="FormatoN(this)" onblur="TT(\'stds\', \'stp\',\'dse\',\'knh\')" /></td>

			</tr>

			<tr>

				<td><label>TOTAL CON DCTO.</label></td>

				<td><input type="text" id="stds" name="stds" value="0" READONLY onfocus="TG(\'stds\', \'stp\',\'dse\',\'knh\')" onblur="TG(\'stds\', \'stp\',\'dse\',\'knh\')"/></td>

				<td><img src="images/fleft.png" width="15" height="15" onclick="TG(\'stds\', \'stp\',\'dse\',\'knh\')"/></td>

			</table>

			<br  />

			<div align="left">

				<input type=button onclick="CalculaST(), TT(\'stp\',\'stecvt1\',\'stntvt2\',\'stesvt3\',\'stpevt4\'), TG(\'stds\', \'stp\',\'dse\',\'knh\'), validarform(\'formingreso\', \'presupuesto\')" name="enviar" value="Cargar Nuevo Presupuesto">

			</div>

			<br  />

		</fieldset>

	<form>

</div>';

}

?>