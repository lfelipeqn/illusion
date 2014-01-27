<?php
	include 'Connections/cnn.php';
	include 'func_produccion.php';
if(isset($_SESSION['usuario'])){
	$nprod=$_GET['seguimiento'];
	
	$sql = "SELECT produccion.IdProduccion, produccion.IdCliente, produccion.IdProyecto, produccion.IdPresupuesto, produccion.ProductorEjecutivo, produccion.ProductorCampo, produccion.ValidaC, produccion.ValidaP FROM produccion WHERE produccion.IdProduccion =  '".$nprod."'";
	$connect=mysql_select_db($database_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
	$rsprod=mysql_fetch_assoc($consulta);
	
	$estado=$rsprod['ValidaC']+$rsprod['ValidaP'];
	$sqlcliente="SELECT clientes.IdCliente, clientes.NombreCliente, clientes.Identificacion, clientes.DV, tipoempresa.TipoEmpresa, clientes.email, clientes.PersonaContacto FROM clientes Inner Join tipoempresa ON clientes.TipoEmpresa = tipoempresa.IdTipo WHERE clientes.IdCliente =  '".$rsprod['IdCliente']."'";
	
	$cltcliente=mysql_query($sqlcliente,$cnn);
	$rscliente = mysql_fetch_assoc($cltcliente);

	$sqlproy="select proyectos.IdProyecto AS IdProyecto, proyectos.NombreProyecto AS NombreProyecto, proyectos.LugarEvento AS LugarEvento, proyectos.FechaEvento AS FechaEvento, proyectos.FechaMontaje AS FechaMontaje, proyectos.FechaDesmontaje AS FechaDesmontaje, proyectos.NombreContacto AS NombreContacto, presupuestos.Total AS Total, presupuestos.Presentadopor AS Comercial, presupuestos.Aprobabo AS Aprobabo, presupuestos.IdPresupuesto AS IdPresupuesto from (proyectos join presupuestos on(((proyectos.IdCliente = presupuestos.IdCliente) and (proyectos.IdProyecto = presupuestos.IdProyecto)))) where ((presupuestos.Aprobabo = '1') and (proyectos.IdProyecto = '".$rsprod['IdProyecto']."'))";
	
	$cltproy=mysql_query($sqlproy,$cnn);
	$rsproy=mysql_fetch_assoc($cltproy);
	
	$sqlnego="SELECT negocios.IdNegocio, negocios.IdCliente, negocios.IdProyecto, negocios.IdPresupuesto, negocios.FechaCreacion, negocios.TipoNegocio, negocios.PlazoPago, negocios.Anticipo, negocios.PorcAnticipo, negocios.Comercial, negocios.Productor, negocios.PorAD, negocios.ValAD, negocios.PorDG, negocios.ValDG, negocios.PorBM, negocios.ValBM, negocios.PorPR, negocios.ValPR FROM negocios WHERE negocios.IdProyecto ='".$rsprod['IdProyecto']."'";
	$cltnego=mysql_query($sqlnego,$cnn) or die(mysql_error());
	$rsnego=mysql_fetch_assoc($cltnego);
	
	
	$cltproveedor="select proveedores.Identificacion, proveedores.NombreProveedor from proveedores ORDER BY proveedores.NombreProveedor ASC";
	$xml = new DomDocument("1.0");
	$raiz=$xml->createElement("proveedores");
	$sprov=mysql_query($cltproveedor,$cnn) or die(mysql_error());
	while ($rsprov=mysql_fetch_assoc($sprov)){
			$proveedor=$xml->createElement("proveedor");
			$idproveedor=$proveedor->setAttribute("idproveedor",$rsprov['Identificacion']);
			$tnproveedor=$xml->createTextNode(utf8_encode($rsprov['NombreProveedor']));
			$proveedor->appendChild($tnproveedor);
			$raiz->appendChild($proveedor);
	}
	$xml->appendChild($raiz);
	$xml->save("proveedores.xml");
	
	$cltprofesionales="SELECT usuarios.Usuario, usuarios.Nombre FROM usuarios WHERE usuarios.IdPerfil = 2 OR usuarios.IdPerfil = 3 OR usuarios.IdPerfil = 6 ORDER BY usuarios.Nombre ASC";
	$xml = new DomDocument("1.0");
	$raiz=$xml->createElement("profesionales");
	$sprof=mysql_query($cltprofesionales,$cnn) or die(mysql_error());
	while ($rsprof=mysql_fetch_assoc($sprof)){
			$profesional=$xml->createElement("profesional");
			$idusuario=$profesional->setAttribute("idusuario",$rsprof['Usuario']);
			$tnusuario=$xml->createTextNode(utf8_encode($rsprof['Nombre']));
			$profesional->appendChild($tnusuario);
			$raiz->appendChild($profesional);
	}
	$xml->appendChild($raiz);
	$xml->save("profesionales.xml");
	
echo '
<div class="cuerpo">
        <form onclick="document.getElementById(\'validar\').disabled=true" action="produccion/creaproduccion.php" method="post" id="formingreso" name="formingreso">
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
                  	<select id="ncliente" name="ncliente" READONLY>';
					echo '<option value="'.$rscliente['IdCliente'].'" selected>'.$rscliente['NombreCliente'].'</option>';
   					echo '</select>
                  </td>
                  <td><label> Consecutivo Evento </label></td>
	              <td>
                  	<input type="text" id="consevt" name="consevt" READONLY value="'.$rsproy['IdProyecto'].'">
                  </td>
                </tr>
                <tr>
                  <td><label> NIT </label></td>
	              <td><input type="text" id="nnit" name="nnit" READONLY value="'.$rscliente['Identificacion'].'"></td>
                  <td><label>D.V.</label></td>
                  <td><input type="text" id="ndv" name="ndv" READONLY size="2" value="'.$rscliente['DV'].'"></td>
	              <td><label>Tipo de Empresa</label></td>
	              <td><input id="pptipoe" name="pptipoe" READONLY type="text"  value="'.$rscliente['TipoEmpresa'].'"/></td>
                </tr>
	            <tr>
                  <td colspan="2"><label>Contacto Cliente</label></td>
	              <td colspan="2"><input id="ncontactc" name="ncontactc" type="text" READONLY value="'.$rscliente['PersonaContacto'].'"/></td>
	              <td><label> Evento </label></td>
	              <td>
					<select id="pproy" name="pproy" READONLY>';
					echo '<option value="'.$rsproy['IdProyecto'].'" selected>'.$rsproy['NombreProyecto'].'</option>';
   					echo '</select>
                  </td>
                </tr>
                <tr>
	              <td colspan="2"><label>Lugar del Evento</label></td>
	              <td colspan="2"><input id="plugar" type="text" READONLY name="plugar" value="'.$rsproy['LugarEvento'].'"></td>
                  <td><label>Total Presupuesto</label></td>
	              <td><input id="totpres" name="totpres" type="text" READONLY value="'.aMoneda($rsproy['Total']-($rsnego['ValAD']+$rsnego['ValDG']+$rsnego['ValBM']+$rsnego['ValPR'])).'"/></td>
                </tr>
                <tr>
	              <td colspan="2"><label> Productor Ejecutivo </label></td>
	              <td colspan="2"><select id="prodej" name="prodej" READONLY>';
				  $cadpr="SELECT usuarios.IdUsuario, usuarios.Usuario, usuarios.Nombre, usuarios.Correo 
                  FROM usuarios 
                  WHERE usuarios.Usuario = '".$rsprod['ProductorEjecutivo']."'";
				  $clpr=mysql_query($cadpr,$cnn) or die(mysql_error());
				  while($rspr=mysql_fetch_assoc($clpr)){
				        if($rspr['Usuario']==$rsprod['ProductorEjecutivo']){
				            echo'<option value="'.$rspr['Usuario'].'" selected>'.$rspr['Nombre'].'</option>';
				        }
				  }
				  echo'</select></td>
	              <td><label>Email</label></td>
	              <td><input id="mailn" name="mailn" type="text" READONLY value="'.$rscliente['email'].'"/></td>
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
                        <td colspan="3">
                            <select id="prodcampo" name="prodcampo" READONLY>
                            <option value="">-- Elija Productor--</option>';
				  $cadprc="SELECT usuarios.IdUsuario, usuarios.Nombre, usuarios.Usuario, usuarios.Correo 
                  FROM usuarios WHERE usuarios.IdPerfil = 10";
				  $clprodc=mysql_query($cadprc,$cnn) or die(mysql_error());
				  while($rsprodc=mysql_fetch_assoc($clprodc)){
				        if($rsprodc['Usuario']==$rsprod['ProductorCampo']){
				            echo'<option value="'.$rsprodc['Usuario'].'" selected>'.$rsprodc['Nombre'].'</option>';
				        }
						echo'<option value="'.$rsprodc['Usuario'].'">'.$rsprodc['Nombre'].'</option>';
				  }
				  echo'</select>
                        </td>
                    	<td><label>Consecutivo P.G.</label></td>
                        <td><input type="text" id="conspg" name="conspg" READONLY/></td>
                    </tr>
                    <tr>
                        <td><label>Fecha de Montaje</label></td>
                        <td><input type="text" id="fechamon" name="fechamon" READONLY value="'.ConvFecha($rsproy['FechaMontaje']).'"/></td>
                        <td><label>Fecha de Evento</label></td>
                        <td><input type="text" id="fechaevt" name="fechaevt" READONLY value="'.ConvFecha($rsproy['FechaEvento']).'"/></td>
                        <td><label>Fecha de Desmontaje</label></td>
                        <td><input type="text" id="fechades" name="fechades" READONLY value="'.ConvFecha($rsproy['FechaDesmontaje']).'"/></td>
                    </tr>
                    <tr>
                    	<td><label>Direcci&oacute;n Montaje</label></td>
                        <td colspan="3">
                        	<input type="text" id="dmont" name="dmont" READONLY value="'.$rsproy['LugarEvento'].'"/>
                        </td>
                        <td><label>Contacto Evento</label></td>
                        <td><input type="text" id="contp" name="contp" READONLY value="'.$rsproy['NombreContacto'].'"/></td>
                    </tr>
                </table>
                </li>
                </ul>
                <div class="menuheaders">
                <div align="left"><h2>Informaci&oacute;n <span>Detallada</span></h2></div>
                </div>
                <ul class="menucontents">
                <li>';
				
$sqlcat="SELECT produccion_categoria.IdCategoria, produccion_categoria.Proveedor, produccion_categoria.Categoria, produccion_categoria.TablaHtml, produccion_categoria.NombreTabla, produccion_categoria.sigla FROM produccion_categoria ORDER BY produccion_categoria.IdCategoria ASC";
$cltcat=mysql_query($sqlcat,$cnn) or die(mysql_error());
				
while($rscat=mysql_fetch_assoc($cltcat)){
	$tabla=$rscat['NombreTabla'];
	$codcat=$rscat['IdCategoria'];
	$tablahtml=$rscat['TablaHtml'];
	$nombrecat=$rscat['Categoria'];
	$nsprov=$rscat['sigla'].'pv';
	$ncat=$rscat['sigla'].'ct';
	$nfila=$rscat['sigla'].'fl';
	$ncan=$rscat['sigla'].'cn';
	$ndet=$rscat['sigla'].'ds';
	$ndia=$rscat['sigla'].'dd';
	$nvuni=$rscat['sigla'].'vu';
	$nvtt=$rscat['sigla'].'vt';
					
	$sql="SELECT * FROM ".$tabla." WHERE ".$tabla.".IdProduccion='".$nprod."'";
	if($rscat['IdCategoria']==6){
		$sql.=' ORDER BY '.$tabla.'.IdPersona ASC';
	}else{
		$sql.=' ORDER BY '.$tabla.'.IdProveedor ASC';
	}				
					
	$clt=mysql_query($sql,$cnn);
					
	echo'<table id="'.$rscat['TablaHtml'].'" name="'.$rscat['TablaHtml'].'"><thead>';	
	echo'<tr><td colspan="6"><h1>'.$nombrecat.'</h1></td></tr><tr>';
	for($yy=0;$yy<=5;$yy++){
		if ($yy==0){
			echo '<td colspan="4">';
		}else{
			echo '<td>';
		}
		switch($yy){
			case 0:
				echo'<label>Opciones</label>';
				break;
			case 1:
				echo'<label>Detalle</label>';
				break;
			case 2:
				echo'<label>Cantidad</label>';
				break;
			case 3:
				echo'<label>Dias</label>';
				break;
			case 4:
				echo'<label>Vr. Unitario</label>';
				break;
			case 5:
				echo'<label>Vr. Total</label>';
				break;
		}
		echo '</td>';
	}
	echo'</tr>';	
	$fl=mysql_num_rows($clt);
	if($fl>=1){				
		echo '<tr><td><input type="hidden" id="tt'.$tablahtml.'" name="tt'.$tablahtml.'" value="'.$fl.'"/></td></tr><thead><tbody id="cuerpo'.$codcat.'">';
		$x=1;
		while($rst=mysql_fetch_assoc($clt)){
			echo'<tr id="'.$nfila.$x.'">';
			for ($l=0;$l<=8;$l++){
				$cadena='';
				switch($l){
					case 0:
						if(($estado==2 && $nombrecat!='Imprevistos')||($estado==1)){
							echo '<td><img src="images/mas.png"/></td>';			
						}else{
							echo '<td><img src="images/mas.png" onclick="NuevaAdicional(\''.$tablahtml.'\', this)"/></td>';	
						}
						break;
					case 1:
						if(($estado==2 && $nombrecat!='Imprevistos')||($estado==1)){
							echo '<td><img src="images/menos.png"/></td>';			
						}else{
							echo '<td><img src="images/menos.png" onclick="EliminaFilaP(\''.$tablahtml.'\', this, \'cuerpo'.$codcat.'\')"/></td>';
						}
						break;
					case 2:
						echo '<td>';
						echo '<input type="hidden" id="'.$ncat.$x.'" name="'.$ncat.$x.'" value="'.$nombrecat.'"/>';
						echo '</td>';
						break;
					case 3:
						echo '<td>';
						$fila=Tipofila($l,$rscat['IdCategoria']);
						$cadena=$fila['apertura'].$fila['tag'].$fila['type'].$fila['style'].$fila['size'].$fila['src'].$fila['readonly'];
						$cadena.=' id="'.$nsprov.$x.'" name="'.$nsprov.$x.'"';
						if($rscat['Proveedor']==0){
						  $cadena.=' disabled="disabled"';
					  	}
						if($rscat['IdCategoria']==6){
							$cadena.=' onchange="CalculaProd()" onfocus="Contenido(this, \'Profesional\')"';
						}else{
							$cadena.=' onchange="CalculaProd()" onfocus="Contenido(this, \'Proveedor\')';
						}
						$cadena.=$fila['cierre'];
						echo $cadena;
						echo SelContenido($fila['cont_tipo'],$rst[$fila['cont_campo']],$estado);	
						echo $fila['tagcierre'];
						echo '</td>';
						break;
					case 4:
						echo'<td>';
						$fila=Tipofila($l,$rscat['IdCategoria']);
						$cadena.=$fila['apertura'].$fila['tag'].$fila['type'].$fila['style'].$fila['size'].$fila['src'].$fila['readonly'];
										
						$cadena.=' id="'.$ndet.$x.'" name="'.$ndet.$x.'" value="'.$rst['Detalle'].'"';				
						$cadena.=' onblur="CalculaProd()"';
						if(($estado==2 && $nombrecat!='Imprevistos')||($estado==1)){
							$cadena.=' READONLY';
						}
						$cadena.=$fila['cierre'];
						echo $cadena;
						echo $fila['tagcierre'];
						echo '</td>';
						break;
				  case 5:
					  echo'<td>';
					  $fila=Tipofila($l,$rscat['IdCategoria']);
					  $cadena.=$fila['apertura'].$fila['tag'].$fila['type'].$fila['style'].$fila['size'].$fila['src'].$fila['readonly'];
					  $cadena.=' id="'.$ncan.$x.'" name="'.$ncan.$x.'" value="'.$rst['Cantidad'].'"';
					  $cadena.=' onchange="CalculaTotalProd(this), CalculaProd()"';
					  if(($estado==2 && $nombrecat!='Imprevistos')||($estado==1)){
						$cadena.=' READONLY';
					  }
					  $cadena.=$fila['cierre'];
					  echo $cadena.$fila['tagcierre'];
					  echo '</td>';
					  break;
				  case 6:
					  echo'<td>';
					  $fila=Tipofila($l,$rscat['IdCategoria']);
					  $cadena.=$fila['apertura'].$fila['tag'].$fila['type'].$fila['style'].$fila['size'].$fila['src'].$fila['readonly'];
					  $cadena.=' id="'.$ndia.$x.'" name="'.$ndia.$x.'" value="'.$rst['Dias'].'"';
					  $cadena.=' onchange="CalculaTotalProd(this), CalculaProd()"';
					  if(($estado==2 && $nombrecat!='Imprevistos')||($estado==1)){
						$cadena.=' READONLY';
					  }
					  $cadena.=$fila['cierre'];
					  echo $cadena.$fila['tagcierre'];
					  echo '</td>';
					  break;
				  case 7:
					  echo'<td>';
					  $fila=Tipofila($l,$rscat['IdCategoria']);
					  $cadena.=$fila['apertura'].$fila['tag'].$fila['type'].$fila['style'].$fila['size'].$fila['src'].$fila['readonly'];
					  $cadena.=' id="'.$nvuni.$x.'" name="'.$nvuni.$x.'" value="'.aMoneda($rst['VrUnitario']).'"';
					  $cadena.=' onchange="CalculaTotalProd(this)" onblur="FormatoN(this), CalculaProd()"';
					  if(($estado==2 && $nombrecat!='Imprevistos')||($estado==1)){
						$cadena.=' READONLY';
					  }
					  $cadena.=$fila['cierre'];
					  echo $cadena.$fila['tagcierre'];
					  echo '</td>';
					  break;
				  case 8:
					  echo'<td>';
					  $fila=Tipofila($l,$rscat['IdCategoria']);
					  $cadena.=$fila['apertura'].$fila['tag'].$fila['type'].$fila['style'].$fila['size'].$fila['src'].$fila['readonly'];
					  $cadena.=' id="'.$nvtt.$x.'" name="'.$nvtt.$x.'" value="'.aMoneda($rst['VrTotal']).'"';
					  if(($estado==2 && $nombrecat!='Imprevistos')||($estado==1)){
						$cadena.=' READONLY';
					  }
					  $cadena.=$fila['cierre'];
					  echo $cadena.$fila['tagcierre'];
					  echo '</td>';
					  break;
					}
			  }
			  echo '</tr>';
			  $x++;
		}
  	}else{
	  echo '<tr><td><input type="hidden" id="tt'.$tablahtml.'" name="tt'.$tablahtml.'" value="1"/></td></tr><thead><tbody id="cuerpo'.$codcat.'">';
	  $x=1;
		  echo'<tr id="'.$nfila.$x.'">';
		  for ($l=0;$l<=8;$l++){
			  $cadena='';
			  switch($l){
				  case 0:
				  	if(($estado==2 && $nombrecat!='Imprevistos')||($estado==1)){
						echo '<td><img src="images/mas.png"/></td>';			
					}else{
						echo '<td><img src="images/mas.png" onclick="NuevaAdicional(\''.$tablahtml.'\', this)"/></td>';
					}
					break;
				  case 1:
				  	if(($estado==2 && $nombrecat!='Imprevistos')||($estado==1)){
						echo '<td><img src="images/menos.png"/></td>';			
					}else{
						echo '<td><img src="images/menos.png" onclick="EliminaFilaP(\''.$tablahtml.'\', this, \'cuerpo'.$codcat.'\')"/></td>';
					}
					  break;
				  case 2:
					  echo '<td>';
					  echo '<input type="hidden" id="'.$ncat.$x.'" name="'.$ncat.$x.'" value="'.$nombrecat.'"/>';
					  echo '</td>';
					  break;
				  case 3:
					  echo '<td>';
					  $fila=Tipofila($l,$rscat['IdCategoria']);
					  $cadena=$fila['apertura'].$fila['tag'].$fila['type'].$fila['style'].$fila['size'].$fila['src'].$fila['readonly'];
					  $cadena.=' id="'.$nsprov.$x.'" name="'.$nsprov.$x.'"';
					  if($rscat['Proveedor']==0){
						  $cadena.=' disabled="disabled"';
					  }
					  if($rscat['IdCategoria']==6){
						  $cadena.=' onchange="CalculaProd()" onfocus="Contenido(this, \'Profesional\')"';
					  }else{
						  $cadena.=' onchange="CalculaProd()" onfocus="Contenido(this, \'Proveedor\')"';
					  }
					  $cadena.=$fila['cierre'];
					  echo $cadena;
					  echo SelContenido($fila['cont_tipo'],$rst[$fila['cont_campo']],$estado);
					  echo $fila['tagcierre'];
					  echo '</td>';
					  break;
				  case 4:
					  echo'<td>';
					  $fila=Tipofila($l,$rscat['IdCategoria']);
					  $cadena.=$fila['apertura'].$fila['tag'].$fila['type'].$fila['style'].$fila['size'].$fila['src'].$fila['readonly'];
					  $cadena.=' id="'.$ndet.$x.'" name="'.$ndet.$x.'"';
					  $cadena.=' onblur="CalculaProd()"';
					  if(($estado==2 && $nombrecat!='Imprevistos')||($estado==1)){
						$cadena.=' READONLY';
					  }
					  $cadena.=$fila['cierre'];
					  echo $cadena;
					  echo $fila['tagcierre'];
					  echo '</td>';
					  break;
				  case 5:
					  echo'<td>';
					  $fila=Tipofila($l,$rscat['IdCategoria']);
					  $cadena.=$fila['apertura'].$fila['tag'].$fila['type'].$fila['style'].$fila['size'].$fila['src'].$fila['readonly'];
					  $cadena.=' id="'.$ncan.$x.'" name="'.$ncan.$x.'"';
					  $cadena.=' onchange="CalculaTotalProd(this), CalculaProd()"';
					  if(($estado==2 && $nombrecat!='Imprevistos')||($estado==1)){
						$cadena.=' READONLY';
					  }
					  $cadena.=$fila['cierre'];
					  echo $cadena.$fila['tagcierre'];
					  echo '</td>';
					  break;
				  case 6:
					  echo'<td>';
					  $fila=Tipofila($l,$rscat['IdCategoria']);
					  $cadena.=$fila['apertura'].$fila['tag'].$fila['type'].$fila['style'].$fila['size'].$fila['src'].$fila['readonly'];
					  $cadena.=' id="'.$ndia.$x.'" name="'.$ndia.$x.'"';
					  $cadena.=' onchange="CalculaTotalProd(this), CalculaProd()"';
					  if(($estado==2 && $nombrecat!='Imprevistos')||($estado==1)){
						$cadena.=' READONLY';
					  }
					  $cadena.=$fila['cierre'];
					  echo $cadena.$fila['tagcierre'];
					  echo '</td>';
					  break;
				  case 7:
					  echo'<td>';
					  $fila=Tipofila($l,$rscat['IdCategoria']);
					  $cadena.=$fila['apertura'].$fila['tag'].$fila['type'].$fila['style'].$fila['size'].$fila['src'].$fila['readonly'];
					  $cadena.=' id="'.$nvuni.$x.'" name="'.$nvuni.$x.'"';
					  $cadena.=' onchange="CalculaTotalProd(this)" onblur="FormatoN(this), CalculaProd()"';
					  if(($estado==2 && $nombrecat!='Imprevistos')||($estado==1)){
						$cadena.=' READONLY';
					  }
					  $cadena.=$fila['cierre'];
					  echo $cadena.$fila['tagcierre'];
					  echo '</td>';
					  break;
				  case 8:
					  echo'<td>';
					  $fila=Tipofila($l,$rscat['IdCategoria']);
					  $cadena.=$fila['apertura'].$fila['tag'].$fila['type'].$fila['style'].$fila['size'].$fila['src'].$fila['readonly'];
					  $cadena.=' id="'.$nvtt.$x.'" name="'.$nvtt.$x.'" value="0"';
					  if(($estado==2 && $nombrecat!='Imprevistos')||($estado==1)){
						$cadena.=' READONLY';
					  }
					  $cadena.=$fila['cierre'];
					  echo $cadena.$fila['tagcierre'];
					  echo '</td>';
					  break;
				  }
		  }
		  echo '</tr>';
  	}
  	echo'</tbody></table>';
}
								
echo'
	<br />
	<h4>Resumen Costos Producci&oacute;n</h4>
	<table>
		<tr>
			<td><label>Rental Equipos</label></td>
			<td><input type="text" id="resge" name="resge" READONLY value="0"/></td>
			<td><label>Corporativo</label></td>
			<td><input type="text" id="resec" name="resec" READONLY value="0"/></td>
			<td><label>Digital</label></td>
			<td><input type="text" id="resnt" name="resnt" READONLY value="0"/></td>
		</tr>
		<tr>
			<td><label>Producci&oacute;n</label></td>
			<td><input type="text" id="respd" name="respd" READONLY value="0"/></td>
			<td><label>Imprevistos</label></td>
			<td><input type="text" id="resgi" name="resgi" READONLY value="0"/></td>
			<td><label>Personal</label></td>
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
	<table>
		<tr>
			<td><input style="width: 180px" type="button" id="validar" name="validar" onclick="CalculaProd(), openbox(1)" value="Validar Producci&oacute;n"';
			if($estado==2) echo ' disabled="disabled"';
			echo '/></td>
			<td><input style="width: 180px" type="button" name="enviar" id="enviar" value="Registrar Hoja de Producci&oacute;n" size="80" onclick="CalculaProd(), validarform(\'formingreso\',\'produccion\')"/></td>
		</tr>
	</table>
	<input type="hidden" name="seguimiento" value="'.$nprod.'">
	<input type="hidden" name="tipo" value="C">
	</div>
</fieldset>
</form>
</div>';
//Formulario para la Validación de la Hoja de Produción.
echo '
	<div id="filter"></div>
	<div id="box">
	<div align="right"><img src="images/closed.gif" onclick="closebox()" /></div>
	<div>
		<table>
			<tr>
				<td><img src="images/LogoEsl.jpg" width="70%" height="70%"/></td>
				<td><p style="padding-top: 8px"><h3>Validaci&oacute;n Hoja de Producci&oacute;n</h3></p></td>
			</tr>
		</table>
	</div>
	<form action="produccion/validarproduccion.php" method="post" id="validar">
	<input type="hidden" name="nhprod" value="'.$nprod.'">
	<input type="hidden" name="nproy" value="'.$rsprod['IdProyecto'].'">
	<input type="hidden" name="valpres" value="'.($rsproy['Total']-$rsnego['ValAD']).'">
	<input type="hidden" name="nfechae" value="'.$rsproy['FechaEvento'].'">
	<input type="hidden" name="nfecham" value="'.$rsproy['FechaMontaje'].'">
	<input type="hidden" name="nfechad" value="'.$rsproy['FechaDesmontaje'].'">
	<input type="hidden" name="ncom" value="'.$rsproy['Comercial'].'">
	<input type="hidden" name="npro" value="'.$rsnego['Productor'].'">
	<div align="center">
	<table>
			<tr>
				<td><b>Usuario:</b></td>
				<td><input type="text" id="nuser" name="nuser" /></td>
			</tr>
			<br />
			<tr>
				<td><b>Clave:</b></td>
				<td><input type="password" id="pass" name="pass" /></td>
			</tr>
	</table>
	</div>
	<br>
	<div align="center">
	<table>
		<tr>
			<td><input style="width: 140px" type="submit" value="Validar Producci&oacute;n"/></td>
			<td><input style="width: 140px" type="button" onclick="closebox()" value="Cancelar"/></td>
		</tr>
	</table>
	</div>
	</form>
	<br>
	<hr>
	</div>';
}
?>