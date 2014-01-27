<?php
function ListaInventario(){	
	include('../Connections/cnn.php');
	$connect = mysql_select_db($rental_cnn,$cnn);
	$cltinventario="SELECT inventario.Codigo, inventario.Articulo, inventario.PrecioComercial, inventario.PrecioAlianza, inventario.IdEstado, estados.Estado FROM inventario INNER JOIN estados ON inventario.IdEstado = estados.IdEstado";
	$xml = new DomDocument("1.0");
	$raiz=$xml->createElement("inventario");
	$sinv=mysql_query($cltinventario,$cnn) or die(mysql_error());
	while ($rsinv=mysql_fetch_assoc($sinv)){
			$equipo=$xml->createElement("equipo");
			$idequipo=$equipo->setAttribute("idequipo",$rsinv['Codigo']);
			$pcomer=$equipo->setAttribute("comercial",$rsinv['PrecioComercial']);
			$palian=$equipo->setAttribute("alianza",$rsinv['PrecioAlianza']);
			$estado=$equipo->setAttribute("estado",$rsinv['Estado']);
			$nequipo=$xml->createTextNode(utf8_encode($rsinv['Articulo']));
			$equipo->appendChild($nequipo);
			$raiz->appendChild($equipo);
	}
	$xml->appendChild($raiz);
	$xml->save("eventos/inventario.xml");
}
?>