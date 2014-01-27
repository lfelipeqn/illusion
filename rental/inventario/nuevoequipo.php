<?php
	//session_start();
	include ('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$connect=mysql_select_db($rental_cnn,$cnn);
	echo'
	<div class="cuerpo">
		<h2><span>Registro de </span>Equipos</h2>
		<div align="left">
		<form action="inventario/ingresaequipo.php" enctype="multipart/form-data" method="post" id="fnew" name="fnew">
		  <table id="results" class="estilotabla">
			<tr>
				<td><b>Categoria</b></td>';
				$sqlcat="SELECT categorias.IdCategoria, categorias.Categoria FROM categorias";
				$cltcat= mysql_query($sqlcat, $cnn) or die(mysql_error());
				echo '<td><select id="scateg" name="scateg">';
				while($rscat=mysql_fetch_assoc($cltcat)){
				    echo '<option value="'.$rscat['IdCategoria'].'">'.$rscat['Categoria'].'</option>';		
				}
				echo '</select></td>
                <td><label><b>Propietario Equipo</b></label></td>';
                echo '<td><select id="sown" name="sown">';
                $sqlown="SELECT propiedad_equipos.IdPropietario, propiedad_equipos.Propietario FROM propiedad_equipos";
				$cltown= mysql_query($sqlown, $cnn) or die(mysql_error());
				while($rsown=mysql_fetch_assoc($cltown)){
				    echo '<option value="'.$rsown['IdPropietario'].'">'.$rsown['Propietario'].'</option>';		
				}
                
                echo '</select></td>	
			</tr>
			<tr>
				<td><label><b>Nombre del Activo</b></label></td>
				<td><input type="text" id="nequ" name="nequ" /></td>
                <td><label><b>Marca</b></label></td>
				<td><input type="text" id="nmarca" name="nmarca" /></td>
			</tr>
            <tr>
				<td><label><b>Modelo</b></label></td>
				<td><input type="text" id="nmodel" name="nmodel" /></td>
				<td><label><b>Serie</b></label></td>
				<td><input type="text" id="nserie" name="nserie" /></td>
			</tr>
            <tr>
				<td><label><b>Precio Comercial</b></label></td>
				<td><input type="text" id="vcomer" name="vcomer" onblur="FormatoN(this)" /></td>
				<td><label><b>Precio Alianza</b></label></td>
				<td><input type="text"  id="valianz" name="valianz" onblur="FormatoN(this)" /></td>
			</tr>
			<tr>
				<td><label><b>Fecha Compra</b></label></td>
				<td><input type="text" id="fechac" name="fechac" READONLY title="MM/DD/YYYY" onClick="displayCalendar(this);" /></td>
			</tr>
            <tr>
                <td><label><b>ValorPresente</b></label></td>
                <td><input id="vpres" name="vpres" type="text" onblur="FormatoN(this)" /></td>
                <td><label><b>Peso (Kg)</b></label></td>
                <td><input id="peso" name="peso" type="text" onblur="this.value=this.value" /></td>
            </tr>
            <tr>
                <td><label><b>Amortizacion</b></label></td>
                <td><input id="amort" name="amort" type="text" onblur="FormatoN(this)" /></td>
                <td><label><b>Mantenimiento</b></label></td>
                <td><input id="mant" name="mant" type="text" onblur="FormatoN(this)" /></td>
            </tr>
            <tr>
                <td><label><b>IntKAnual</b></label></td>
                <td><input id="inter" name="inter" type="text" onblur="FormatoN(this)" /></td>
                <td><label><b>Seguro</b></label></td>
                <td><input id="seguro" name="seguro" type="text" onblur="FormatoN(this)" /></td>
            </tr>
            <tr>
                <td><label><b>Reposicion</b></label></td>
                <td><input id="repos" name="repos" type="text" onblur="FormatoN(this)" /></td>
                <td><label><b>CostoAlquiler</b></label></td>
                <td><input id="alquiler" name="alquiler" type="text" onblur="FormatoN(this)" /></td>
            </tr>
            <tr>
                <td><label><b>CostoFreelance</b></label></td>
                <td><input id="freelance" name="freelance" type="text" onblur="FormatoN(this)" /></td>
                <td><label><b>CostoTransporte</b></label></td>
                <td><input id="transporte" name="transporte" type="text" onblur="FormatoN(this)" /></td>
            </tr>
                <td><label><b>CostoOperacion</b></label></td>
                <td><input id="operacion" name="operacion" type="text" onblur="FormatoN(this)" /></td>
                <td><label><b>CostoTotal</b></label></td>
                <td><input id="total" name="total" type="text" onblur="FormatoN(this)" /></td>
            </tr>
                <td><label><b>VrIncluidoRentabilidad1</b></label></td>
                <td><input id="rent1" name="rent1" type="text" onblur="FormatoN(this)" /></td>
                <td><label><b>VrIncluidoRentabilidad2</b></label></td>
                <td><input id="rent2" name="rent2" type="text" onblur="FormatoN(this)" /></td>
            </tr>
            <tr>
                <td><label><b>Caracteristicas:</b></label></td>
                <td colspan="3">
                    <textarea id="caract" name="caract" rows="4" style="width:530px;">Descripci&oacute;n del Equipo.....</textarea>
                </td>
            </tr>
            <tr>
                <td><label><b>Fotografía Equipo:</b></label></td>
                <td colspan="3">
                    <input id="size" name="size" type="hidden" value="3000000">
                    <input id="image" name="image" accept="image/jpeg" type="file">
                </td>
            </tr>
			<tr>
				<td colspan="4"><div align="center"><input style="background-color:white; font-weight:bold;"type="submit" id="bbadd" name="bbadd" value="Ingresar Equipo a Inventario"/></div></td>
			</tr>
		</table>
		</form>
		</div>
	</div>';
	mysql_close($cnn);
}
?>