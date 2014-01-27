<?php
	//session_start();
	include '../Connections/cnn.php';
if(isset($_SESSION['usuario'])){
	$contador=1;
	$connect=mysql_select_db($rental_cnn,$cnn);
	$evento=$_GET['codigo'];
    $horas=$_GET['horas'];
	$tipoprecio=$_GET['tprec'];
	ListaInventario();
	
	$xml = new DomDocument("1.0");
	$raiz=$xml->createElement("proveedores");
	$sql="SELECT proveedores.Identificacion, proveedores.NombreProveedor, proveedores_tipo.IdTipo, proveedores_tipo.Tipo FROM proveedores INNER JOIN proveedores_tipo ON proveedores.IdTipoProveedor = proveedores_tipo.IdTipo";
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
	while($res = mysql_fetch_assoc($consulta)){ 
		$proveedor=$xml->createElement("proveedor");
		$idproveedor=$proveedor->setAttribute("idproveedor",$res['Identificacion']);
		$idtipo=$proveedor->setAttribute("idtipo",$res['IdTipo']);
		$tipoprov=$proveedor->setAttribute("tipo",$res['Tipo']);
		$nombreprov=$proveedor->setAttribute("nombre",utf8_encode($res['NombreProveedor']));
		$raiz->appendChild($proveedor);
	}

	$xml->appendChild($raiz);
	$xml->save("eventos/proveedores.xml");
    
    
    $xml= new DOMDocument("1.0");
    $raiz=$xml->createElement("costos");
    $sqltipo="SELECT proveedores_tipo.IdTipo, proveedores_tipo.Tipo FROM proveedores_tipo";
    $clttipo=mysql_query($sqltipo,$cnn) or die(mysql_error());
    while($rstipo=mysql_fetch_assoc($clttipo)){
        $tipo=$rstipo['IdTipo'];
        $nntipo=$rstipo['Tipo'];
        $sqlnivel="SELECT proveedores_nivel.IdNivel, proveedores_nivel.Nivel FROM proveedores_nivel";
        $cltnivel=mysql_query($sqlnivel,$cnn) or die(mysql_error());
        while($rsnivel=mysql_fetch_assoc($cltnivel)){
            $nivel=$rsnivel['IdNivel'];
            $nnivel=$rsnivel['Nivel'];
            $sqlprecio="SELECT proveedores_tipo_nivel.IdTipo, proveedores_tipo_nivel.IdNivel, proveedores_tipo_nivel.IdentificacionProveedor, proveedores_tipo_nivel.MediaJornada, proveedores_tipo_nivel.Jornada, proveedores_tipo_nivel.JornadaExtendida, proveedores_tipo_nivel.HoraAdicional, proveedores_tipo_nivel.HoraAdicionalNoche FROM proveedores_tipo_nivel WHERE proveedores_tipo_nivel.IdTipo='".$tipo."' AND proveedores_tipo_nivel.IdNivel='".$nivel."'";
            $cltprecio=mysql_query($sqlprecio,$cnn)or die(mysql_error());
            $filas=mysql_num_rows($cltprecio);
            if($filas>0){
                $rscosto=mysql_fetch_assoc($cltprecio);
                $precio=$xml->createElement("costo");
                $idnivelp=$precio->setAttribute("idnivel",$rscosto['IdNivel']);
                $nnivel=$precio->setAttribute("nnivel",utf8_encode($nnivel));
                $idtipop=$precio->setAttribute("idtipo",$rscosto['IdTipo']);
                $ntipo=$precio->setAttribute("ntipo",utf8_encode($nntipo));
                $mediajornada=$precio->setAttribute("mediajornada",$rscosto['MediaJornada']);
                $jornada=$precio->setAttribute("jornada",$rscosto['Jornada']);
                $jornadaextendida=$precio->setAttribute("jornadaextendida",$rscosto['JornadaExtendida']);
                $horaadicional=$precio->setAttribute("horaadicional",$rscosto['HoraAdicional']);
                $horaadicionalnoche=$precio->setAttribute("horaadicionalnoche",$rscosto['HoraAdicionalNoche']);
                $idproveedor=$precio->setAttribute("idproveedor",$rscosto['IdentificacionProveedor']);
                $raiz->appendChild($precio);
            }
        }
    }
    $xml->appendChild($raiz);
    $xml->save("eventos/costos.xml");
    
    $xml = new DomDocument("1.0");
	$raiz=$xml->createElement("niveles");
	$sqlnivel="SELECT proveedores_nivel.IdNivel, proveedores_nivel.Nivel FROM proveedores_nivel";
	$cltnivel=mysql_query($sqlnivel,$cnn) or die(mysql_error());
	while($rsnivel = mysql_fetch_assoc($cltnivel)){ 
		$nivel=$xml->createElement("nivel");
		$idnivel=$nivel->setAttribute("idnivel",$rsnivel['IdNivel']);
		$tnivel=$nivel->setAttribute("nivel",$rsnivel['Nivel']);
		$raiz->appendChild($nivel);
	}

	$xml->appendChild($raiz);
	$xml->save("eventos/niveles.xml");
    
    $sqldetalle="SELECT eventos_detalle.Codigo, inventario.Articulo, eventos_detalle.ValorEquipo, estados.IdEstado, estados.Estado FROM eventos_detalle INNER JOIN inventario ON eventos_detalle.Codigo = inventario.Codigo INNER JOIN estados ON inventario.IdEstado = estados.IdEstado WHERE eventos_detalle.IdEvento=$evento";
    $cltdetalle=mysql_query($sqldetalle,$cnn) or die(mysql_error());
    $totalequipos=mysql_num_rows($cltdetalle);
    
    $sqlproveedores="SELECT proveedores.Identificacion, proveedores.NombreProveedor, proveedores_tipo.IdTipo, proveedores_tipo.Tipo, proveedores_nivel.IdNivel, proveedores_nivel.Nivel, eventos_proveedores.Valor FROM eventos_proveedores INNER JOIN proveedores ON eventos_proveedores.IdProveedor = proveedores.Identificacion INNER JOIN proveedores_tipo ON eventos_proveedores.IdTipo = proveedores_tipo.IdTipo INNER JOIN proveedores_nivel ON eventos_proveedores.IdNivel = proveedores_nivel.IdNivel WHERE eventos_proveedores.IdEvento =$evento";
    $cltproveedores=mysql_query($sqlproveedores,$cnn) or die(mysql_error());
    $totalproveedores=mysql_num_rows($cltproveedores);
    
echo '
<div class="cuerpo">
  <form action="eventos/registrarsalida.php" method="post" id="formdetalle">';
  	 if($totalequipos>1){
  	     echo '<input type="hidden" id="nequipos" name="nequipos" value="'.($totalequipos+1).'"/>';   
  	 }else{
  	     echo '<input type="hidden" id="nequipos" name="nequipos" value="1"/>';
  	 }
     if($totalproveedores>1){
        echo '<input type="hidden" id="npersona" name="npersona" value="'.$totalproveedores.'"/>';
     }else{
        echo '<input type="hidden" id="npersona" name="npersona" value="1"/>';
     }
echo '<input type="hidden" id="idevento" name="idevento" value="'.$evento.'"/>
	<input type="hidden" id="tipop" name="tipop" value="'.$tipoprecio.'"/>
    <input type="hidden" id="horas" name="horas" value="'.$horas.'"/>
		<div align="left"><h2><span>Alistamiento de </span>Equipos</h2></div>
		<hr>
		<p>Por Favor ejecute ahora la lectura de los codigos de cada equipo a incluir en el evento o digite manualmente el c&oacute;digo del mismo.</p>';
		echo '<table>
			     <tr>
                    <td valign="top" rowspan="2">';
					echo '<table id="tequipos" name="tequipos">
					<thead>
					<tr>
						<td class="estilocelda"><label>Opciones</label></td>
						<td class="estilocelda"><label>Codigo Equipo</label></td>
						<td class="estilocelda"><label>Nombre Equipo</label></td>
						<td class="estilocelda"><label>Valor Equipos</label></td>
					</tr>
					</thead>
					<tbody id="cuerpo" name="cuerpo">';
                    if($totalequipos<=1){
                        echo '<tr><td class="estilocontenido"><img src="images/elimina.gif" onclick="EliminaFila(\'tequipos\',this,\'cuerpo\')"/></td><td class="estilocontenido"><input type="text" style="width:100px" id="ceq1" name="ceq1" autocomplete="off" onkeyup="Alistamiento(event, this, \'tipop\', \'Salida\')" /></td><td class="estilocontenido"><input type="text" id="neq1" name="neq1" READONLY /></td><td class="estilocontenido"><input type="text" style="width:120px" id="veq1" name="veq1" READONLY /></td></tr>';   
                    }else{
                        $x=1;
                        while($rsdetalle=mysql_fetch_assoc($cltdetalle)){
                            echo '<tr><td class="estilocontenido"><img src="images/elimina.gif" onclick="EliminaFila(\'tequipos\',this,\'cuerpo\')"/></td><td class="estilocontenido"><input type="text" style="width:100px" id="ceq'.$x.'" name="ceq'.$x.'" value="0'.$rsdetalle['Codigo'].'" autocomplete="off" onkeyup="Alistamiento(event, this, \'tipop\', \'Salida\')" /></td><td class="estilocontenido"><input type="text" id="neq'.$x.'" name="neq'.$x.'" value="'.$rsdetalle['Articulo'].'" READONLY /></td><td class="estilocontenido"><input type="text" style="width:120px" id="veq'.$x.'" name="veq'.$x.'" value="'.$rsdetalle['ValorEquipo'].'" READONLY /></td></tr>';
                            $x++;
                        }
                        echo '<tr><td class="estilocontenido"><img src="images/elimina.gif" onclick="EliminaFila(\'tequipos\',this,\'cuerpo\')"/></td><td class="estilocontenido"><input type="text" style="width:100px" id="ceq'.$x.'" name="ceq'.$x.'" autocomplete="off" onkeyup="Alistamiento(event, this, \'tipop\', \'Salida\')" /></td><td class="estilocontenido"><input type="text" id="neq'.$x.'" name="neq'.$x.'" READONLY /></td><td class="estilocontenido"><input type="text" style="width:120px" id="veq'.$x.'" name="veq'.$x.'" READONLY /></td></tr>';
                    }
                    echo '</tbody>
				        </table>
                    </td>';
				echo'<td valign="top">
                    <table id="adicionales" name="adicionales">
                    <thead>
                        <tr>
                            <th class="estiloceldabl">Concepto</th>
                            <th class="estiloceldabl">Valor</th>
                        </tr>
                    </thead>
                    <tbody>';
                        $sqlconcepto="SELECT conceptos.IdConcepto, conceptos.Concepto FROM conceptos ORDER BY conceptos.IdConcepto ASC";
                        $cltconcepto=mysql_query($sqlconcepto,$cnn) or die(mysql_error());
                        $total=mysql_num_rows($cltconcepto);
                        $x=1;
                        while($rsconcepto=mysql_fetch_assoc($cltconcepto)){
                            //$sqlconcepto="SELECT eventos_conceptos.ValorConcepto, eventos_conceptos.IdConcepto, conceptos.Concepto FROM eventos_conceptos INNER JOIN conceptos ON eventos_conceptos.IdConcepto = conceptos.IdConcepto WHERE eventos_conceptos.IdEvento =$evento ORDER BY conceptos.IdConcepto ASC";
                            $sqlvalor ="SELECT eventos_conceptos.IdEvento, eventos_conceptos.IdConcepto, eventos_conceptos.ValorConcepto FROM eventos_conceptos WHERE eventos_conceptos.IdEvento =".$evento." AND eventos_conceptos.IdConcepto =".$rsconcepto['IdConcepto'];
                            $clconcept=mysql_query($sqlvalor,$cnn) or die(mysql_error());
                            $rsconcept=mysql_fetch_assoc($clconcept);
                            $filas=mysql_num_rows($clconcept);
                            echo '<tr>';
                            if ($filas>=1){
                                echo '<td><input type="hidden" id="concepto'.$x.'" name="concepto'.$x.'" value="'.$rsconcepto['IdConcepto'].'"/><label style="font-weight:bold;font-size:10px">'.$rsconcepto['Concepto'].'</label></td>';
                                echo '<td><input type="text" id="valconcepto'.$x.'" name="valconcepto'.$x.'" value="'.aMoneda($rsconcept['ValorConcepto']).'" onblur="FormatoN(this)"/></td>';    
                            }else{
                                echo '<td><input type="hidden" id="concepto'.$x.'" name="concepto'.$x.'" value="'.$rsconcepto['IdConcepto'].'"/><label style="font-weight:bold;font-size:10px">'.$rsconcepto['Concepto'].'</label></td>';
                                echo '<td><input type="text" id="valconcepto'.$x.'" name="valconcepto'.$x.'" value="'.aMoneda(0).'" onblur="FormatoN(this)"/></td>';
                            }
                            echo '</tr>';
                            $x++;
                        }
                        $x--;
              echo '</tbody><input type="hidden" id="tfilas" name="tfilas" value="'.$total.'"/></table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">';
                        echo '<table id="tpersonas" name="tpersonas">
					<thead>
					<tr>
						<td class="estiloceldagr" colspan="2"><label>Opciones</label></td>
						<td class="estiloceldagr"><label>Especialidad</label></td>
						<td class="estiloceldagr"><label>Proveedor</label></td>
						<td class="estiloceldagr"><label>Nivel</label></td>
						<td class="estiloceldagr"><label>Valor</label></td>
					</tr>
					</thead>
					<tbody id="cuerpoper" name="cuerpoper">';
                        if($totalproveedores>=1){
                         $k=1;
                         while($rsproveedores=mysql_fetch_assoc($cltproveedores)){
                            echo'<tr><td class="estilocontenido"><img src="images/elimina.gif" onclick="EliminaProveedor(\'tpersonas\',this,\'cuerpoper\',\'npersona\')"/></td><td class="estilocontenido"><img src="images/mas.png" onclick="NuevoProveedor(\'tpersonas\',this)"/></td><td class="estilocontenido">';
							$sqltipop="SELECT proveedores_tipo.IdTipo, proveedores_tipo.Tipo FROM proveedores_tipo";
							$clttipop=mysql_query($sqltipop,$cnn) or die(mysql_error());
							echo '<select id="tipop'.$k.'" name="tipop'.$k.'" style="width:120px" onchange="CambiaLista(\'tipop'.$k.'\', \'prov'.$k.'\',\'esp'.$k.'\',\'val'.$k.'\')"><option value="0">-- Especialidad --</option>';
							while($rstipop=mysql_fetch_assoc($clttipop)){
		                       if($rstipop['IdTipo']==$rsproveedores['IdTipo']){
		                          echo '<option value="'.$rstipop['IdTipo'].'" selected="selected">'.$rstipop['Tipo'].'</option>';
		                       }else{
		                          echo '<option value="'.$rstipop['IdTipo'].'">'.$rstipop['Tipo'].'</option>';
		                       }   
							}
							echo'</select></td>';
                            
                            $sqlprov="SELECT proveedores.Identificacion, proveedores.NombreProveedor FROM proveedores WHERE proveedores.IdTipoProveedor =".$rsproveedores['IdTipo'];
                            $cltprov=mysql_query($sqlprov) or die(mysql_error());
                            
							echo '<td class="estilocontenido">';
                            echo '<select id="prov'.$k.'" name="prov'.$k.'" style="width:230px" onchange="CargaNivel(\'prov'.$k.'\', \'esp'.$k.'\',\'val'.$k.'\')">';
                            echo '<option value="0">--- Elija un Proveedor ---</option>';
                                while($rsprov=mysql_fetch_assoc($cltprov)){
                                    if($rsprov['Identificacion']==$rsproveedores['Identificacion']){
                                        echo '<option value="'.$rsprov['Identificacion'].'" selected="selected">'.$rsprov['NombreProveedor'].'</option>';
                                    }else{
                                        echo '<option value="'.$rsprov['Identificacion'].'">'.$rsprov['NombreProveedor'].'</option>';
                                    }    
                                }
                            echo '</select>';
                            echo '</td>';
                            echo '<td>';
                            echo '<select id="esp'.$k.'" name="esp'.$k.'" style="width:150px" onchange="ValorProv(\'tipop'.$k.'\', \'esp'.$k.'\', \'val'.$k.'\', \'prov'.$k.'\')">';
                            echo '<option value="0">---- Elija Nivel -----</option>';
                                $sqlnivel="SELECT proveedores_nivel.IdNivel, proveedores_nivel.Nivel FROM proveedores_nivel";
                                $cltnivel=mysql_query($sqlnivel,$cnn) or die(mysql_error());
                                while($rsnivel=mysql_fetch_assoc($cltnivel)){
                                    if($rsnivel['IdNivel']==$rsproveedores['IdNivel']){
                                        echo '<option value="'.$rsnivel['IdNivel'].'" selected="selected">'.$rsnivel['Nivel'].'</option>';   
                                    }else{
                                        echo '<option value="'.$rsnivel['IdNivel'].'">'.$rsnivel['Nivel'].'</option>';
                                    }
                                }
                                
							echo'</select>';
                            echo '</td>';
                            echo '<td class="estilocontenido">';
                            echo '<input type="text" style="width:100px" id="val'.$k.'" name="val'.$k.'" value="'.aMoneda($rsproveedores['Valor']).'" onblur="FormatoN(this)" />';
                            echo '</td>';
                            echo '</tr>';
                            $k++;       
                         }
                        }else{
                            echo'<tr><td class="estilocontenido"><img src="images/elimina.gif" onclick="EliminaProveedor(\'tpersonas\',this,\'cuerpoper\',\'npersona\')"/></td><td class="estilocontenido"><img src="images/mas.png" onclick="NuevoProveedor(\'tpersonas\',this)"/></td><td class="estilocontenido">';
							$sqltipop="SELECT proveedores_tipo.IdTipo, proveedores_tipo.Tipo FROM proveedores_tipo";
							$clttipop=mysql_query($sqltipop,$cnn) or die(mysql_error());
							echo '<select id="tipop1" name="tipop1" style="width:120px" onchange="CambiaLista(\'tipop1\', \'prov1\',\'esp1\',\'val1\')"><option value="0">-- Especialidad --</option>';
							while($rstipop=mysql_fetch_assoc($clttipop)){
								echo '<option value="'.$rstipop['IdTipo'].'">'.$rstipop['Tipo'].'</option>';
							}
							echo'</select></td>';
							echo '<td class="estilocontenido"><select id="prov1" name="prov1" style="width:230px" onchange="CargaNivel(\'prov1\', \'esp1\',\'val1\')"><option value="0">--- Elija un Proveedor ---</option></select></td><td><select id="esp1" name="esp1" style="width:150px" onchange="ValorProv(\'tipop1\', \'esp1\', \'val1\', \'prov1\')"><option value="0">---- Elija Nivel -----</option>';
							echo'</select></td><td class="estilocontenido"><input type="text" style="width:100px" id="val1" name="val1" onblur="FormatoN(this)"/></td></tr>';
                        }    
                    echo '</tbody></table></td>
                </tr>
                </table>';
		echo '<div align="center"><input type="button" class="boton" value="Registrar Hoja de Trabajo" style="width:500px;" onclick="confirmar(\'formdetalle\')"/></div>
  </form>
</div>';
}
?>