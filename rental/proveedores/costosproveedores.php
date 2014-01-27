<?php
	//session_start();
	include ('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
    $connect=mysql_select_db($rental_cnn,$cnn);
    
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
	$xml->save("proveedores/proveedores.xml");
    
	echo'
	<div class="cuerpo">
		<h2><span>Costos de </span>Proveedores</h2>
		<div align="left">
		<form action="proveedores/regcostos.php" id="fprov" name="fprov" method="post" class="formulario">
		<table>
			<tr>
				<td><label>Tipo de Proveedor</label></td>
				<td>
                    <select id="stipo" name="stipo" onchange="EligeProveedor(\'stipo\', \'sprov\')">
                        <option value="0"> -- Elija Tipo de Proveedor -- </option>';
                $sqltipo="SELECT proveedores_tipo.IdTipo, proveedores_tipo.Tipo FROM proveedores_tipo WHERE proveedores_tipo.IdTipo <> 2 AND proveedores_tipo.IdTipo <> 5";
                $clttipo=mysql_query($sqltipo,$cnn) or die(mysql_error());
                while($rstipo=mysql_fetch_assoc($clttipo)){
                    echo '<option value="'.$rstipo['IdTipo'].'">'.$rstipo['Tipo'].'</option>';
                }
                echo '</select></td>
            </tr>
            <tr>
				<td><label>Nombre Proveedor</label></td>
				<td>
                    <select id="sprov" name="sprov">
                        <option>--- Elija el Proveedor ---</option>
                    </select>
                </td>
			</tr>';
            $sqlniveles="SELECT proveedores_nivel.IdNivel, proveedores_nivel.Nivel FROM proveedores_nivel";
            $cltniveles=mysql_query($sqlniveles,$cnn) or die(mysql_error());
            echo'<tr>
                <td style="background-color:silver"><label style="font-weight:bold">Nivel de Especialidad</label></td>
                <td style="background-color:silver"><label style="font-weight:bold">Valor Media Jornada</label></td>
                <td style="background-color:silver"><label style="font-weight:bold">Valor Jornada</label></td>
                <td style="background-color:silver"><label style="font-weight:bold">Valor Jornada Extendida</label></td>
                <td style="background-color:silver"><label style="font-weight:bold">Valor Hora Adicional</label></td>
                <td style="background-color:silver"><label style="font-weight:bold">Valor Adicional Noche</label></td>
            </tr>';
            $i=1;
            while($rsniveles=mysql_fetch_assoc($cltniveles)){
                echo '<tr>
				        <td style="background-color:silver">
                            <input type="hidden" id="nivel'.$i.'" name="nivel'.$i.'" value="'.$rsniveles['IdNivel'].'" />
                            <label style="font-weight:bold">'.$rsniveles['Nivel'].'</label>
                        </td>
                        <td><input type="text" id="media'.$i.'" name="media'.$i.'" value="0" onblur="FormatoN(this)" /></td>
                        <td><input type="text" id="jornada'.$i.'" name="jornada'.$i.'" value="0" onblur="FormatoN(this)" /></td>
                        <td><input type="text" id="extendida'.$i.'" name="extendida'.$i.'" value="0" onblur="FormatoN(this)" /></td>
                        <td><input type="text" id="hora'.$i.'" name="hora'.$i.'" value="0" onblur="FormatoN(this)" /></td>
                        <td><input type="text" id="adicnoche'.$i.'" name="adicnoche'.$i.'" value="0" onblur="FormatoN(this)" /></td>
			     </tr>';
                 $i++;
            }
            $i--;
			echo '<tr>
				<td colspan="6">
                <input type="hidden" id="total" name="total" value="'.$i.'" /> 
                <div align="center">
                    <input type="button" id="bbreg" name="bbreg" class="boton" style="width:350px;" value="Registrar Costos Proveedor" onclick="validarform(\'fprov\',\'costos\')"/>
                </div>
                </td>
			</tr>
		</table>
		</form>
		</div>
	</div>';
}
?>