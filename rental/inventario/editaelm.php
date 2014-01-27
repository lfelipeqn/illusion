<?php
	//session_start();
	include ('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$codigo=$_GET['seguimiento'];
	$connect=mysql_select_db($rental_cnn,$cnn);
	$sql="SELECT inventario.Codigo, categorias.IdCategoria, categorias.Categoria, categorias.Tabla, inventario.Articulo, inventario.Caracteristicas, inventario.Marca, inventario.Modelo, inventario.Serie, inventario.Cantidad, inventario.Compra, inventario.PrecioComercial, inventario.PrecioAlianza, inventario.Imagen FROM categorias INNER JOIN inventario ON inventario.IdCategoria = categorias.IdCategoria WHERE inventario.Codigo='".$codigo."'";

	$cltdet=mysql_query($sql,$cnn) or die(mysql_error());
	$rsdet=mysql_fetch_assoc($cltdet);
	echo'
	<div class="cuerpo">
		<h2><span>Edicion de </span>Elementos</h2>
		<div align="left">
		<form action="inventario/edicion.php" method="post" id="fedit" name="fedit">
			<input type="hidden" id="codigo" name="codigo" value="'.$rsdet['Codigo'].'" />
		  <table id="results" class="estilotabla">
			<tr>
				<td rowspan="9">';
				if(strlen($rsdet['Imagen'])<1){
				  echo 'NO HAY FOTO';
				}else{
				  echo'<img widht="200px" height="200px" src="inventario/verimagen.php?codigo='.$codigo.'" />';  
				}

				echo '</td>
				<td><b>Categoria</b></td>';
				$sqlcat="SELECT categorias.IdCategoria, categorias.Categoria FROM categorias";
				$cltcat= mysql_query($sqlcat, $cnn) or die(mysql_error());
				echo '<td><select id="scateg" name="scateg">';
				while($rscat=mysql_fetch_assoc($cltcat)){
					if($rscat['IdCategoria']==$rsdet['IdCategoria']){
						echo '<option value="'.$rscat['IdCategoria'].'" selected="selected">'.$rscat['Categoria'].'</option>';		
					}else{
						echo '<option value="'.$rscat['IdCategoria'].'">'.$rscat['Categoria'].'</option>';		
					}
				}
				echo '</select></td>	
			</tr>
			<tr>
				<td><label><b>Nombre del Activo</b></label></td>
				<td><input type="text" value="'.$rsdet['Articulo'].'" id="nequ" name="nequ" /></td>
			</tr>
			<tr>
				<td><label><b>Marca</b></label></td>
				<td><input type="text" value="'.$rsdet['Marca'].'" id="nmarca" name="nmarca" /></td>
			</tr>
			<tr>
				<td><label><b>Modelo</b></label></td>
				<td><input type="text" value="'.$rsdet['Modelo'].'" id="nmodel" name="nmodel" /></td>
			</tr>
			<tr>
				<td><label><b>Serie</b></label></td>
				<td><input type="text" value="'.$rsdet['Serie'].'" id="nserie" name="nserie" /></td>
			</tr>
			<tr>
				<td><label><b>Fecha Compra</b></label></td>
				<td><input type="text" value="'.$rsdet['Compra'].'" id="fechac" name="fechac" /></td>
			</tr>
			<tr>
				<td><label><b>Precio Comercial</b></label></td>
				<td><input type="text" value="'.aMoneda($rsdet['PrecioComercial']).'" id="vcomer" name="vcomer" onblur="FormatoN(this)" /></td>
			</tr>
			<tr>
				<td><label><b>Precio Alianza</b></label></td>
				<td><input type="text" value="'.aMoneda($rsdet['PrecioAlianza']).'" id="valianz" name="valianz" onblur="FormatoN(this)" /></td>
			</tr>
			<tr>
				<td colspan="2"><div align="center"><input type="submit" id="bbedit" name="bbedit" value="Actualizar Elemento"/></div></td>
			</tr>
		</table>
		</form>
		</div>
	</div>';
	mysql_close($cnn);
}
?>