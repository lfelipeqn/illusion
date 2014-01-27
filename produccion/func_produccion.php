<?php
function SelContenido($tipo, $idconsulta,$estado){
	include ("Connections/cnn.php");
	$connect=mysql_select_db($database_cnn,$cnn);
	$resultado='';
	if($tipo=='Proveedor'){
	  $sqlpv="SELECT proveedores.Identificacion, proveedores.NombreProveedor FROM proveedores ORDER BY proveedores.NombreProveedor";
	  $cltpv=mysql_query($sqlpv,$cnn);
	  $resultado='<option value="0"><label>---  Elija Proveedor ---</label></option>';
	  echo $resultado;
	  while($rspv=mysql_fetch_assoc($cltpv)){
		  if($estado==1){
		  	if($idconsulta==$rspv['Identificacion']){
				$resultado='<option value="'.$rspv['Identificacion'].'" selected="selected">'.$rspv['NombreProveedor'].'</option>';
			}
		  }else{
			$resultado.='<option value="'.$rspv['Identificacion'].'"';
		  	if($idconsulta==$rspv['Identificacion']) $resultado.=' selected="selected"';
		  	$resultado.='>'.$rspv['NombreProveedor'].'</option>';  
		  }
	  }
	}
	
	if($tipo=='Gasto'){
		$sqlgasto="SELECT gastos_produccion.IdGasto, gastos_produccion.Gasto FROM gastos_produccion";	
		$cltgas=mysql_query($sqlgasto) or die(mysql_error());
		$resultado='<option value="0"><label>---  Elija Tipo Gasto ---</label></option>';
		while($rsgas=mysql_fetch_assoc($cltgas)){
			if($estado==1){
				if($idconsulta==$rsgas['IdGasto']){
					$resultado='<option value="'.$rsgas['IdGasto'].'" selected="selected">'.$rsgas['Gasto'].'</option>';
				}
			}else{
				$resultado.='<option value="'.$rsgas['IdGasto'].'"';
				if($idconsulta==$rsgas['IdGasto']) $resultado.=' selected="selected"';
				$resultado.='>'.$rsgas['Gasto'].'</option>';	
			}
		}		
	}
	
	if($tipo=='Profesional'){
		$sqlper="SELECT usuarios.Usuario, usuarios.Nombre FROM usuarios WHERE usuarios.IdPerfil = 2 OR usuarios.IdPerfil = 3 OR usuarios.IdPerfil = 6";
		$cltper=mysql_query($sqlper,$cnn);
		$resultado='<option value="0"><label>---  Elija un Especialista ---</label></option>';
		while($rsper=mysql_fetch_assoc($cltper)){
			if($estado==1){
				if($idconsulta==$rsper['Usuario']){
					$resultado='<option value="'.$rsper['Usuario'].'" selected="selected">'.$rsper['Nombre'].'</option>';		
				}
			}else{
				$resultado.='<option value="'.$rsper['Usuario'].'"';
				if($idconsulta==$rsper['Usuario']) $resultado.=' selected="selected"';
				$resultado.='>'.$rsper['Nombre'].'</option>';	
			}
		}
	}
	return $resultado;
}

function TipoFila($orden, $categoria){
	include ("Connections/cnn.php");
	$connect=mysql_select_db($database_cnn,$cnn);
	$sql="SELECT produccion_filas.IdRegistro, produccion_filas.apertura, produccion_filas.tag, produccion_filas.type, produccion_filas.style, produccion_filas.size, produccion_filas.src, produccion_filas.readonly, produccion_filas.orden, produccion_filas.cierre, produccion_filas.tagcierre, produccion_filas.cont_tipo, produccion_filas.cont_campo, produccion_filas.cont_depen, produccion_filas.IdCategoria FROM produccion_filas WHERE produccion_filas.IdCategoria=$categoria AND produccion_filas.orden=$orden";
	$clt=mysql_query($sql,$cnn) or die(mysql_error());
	$rst=mysql_fetch_array($clt);
	return $rst;
}
?>