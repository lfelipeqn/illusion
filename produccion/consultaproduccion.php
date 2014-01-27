<?php
	include ('Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$opcion=$_GET['tipo'];
	$valor=$_GET['valor'];
	$privilegio=$_SESSION['perfil'];
	switch($opcion){
		case 0:
				$sql = "SELECT
produccion.IdProduccion,
produccion.Finalizada,
produccion.Aprobada,
clientes.NombreCliente,
produccion.IdPresupuesto,
produccion.ProductorEjecutivo,
proyectos.IdProyecto,
proyectos.NombreProyecto,
proyectos.NombreContacto,
produccion.ProductorCampo,
produccion.TotalTerceros,
produccion.TotalESL,
produccion.GranTotal AS CostoProduccion,
produccion.Rentabilidad,
negocios.ValAD AS ValorAdministracion,
negocios.ValDG AS ValorDirector,
negocios.ValBM AS ValorComercial,
negocios.ValPR AS ValorProduccion,
presupuestos.Total AS TotalPresupuesto
FROM
produccion
INNER JOIN clientes ON clientes.IdCliente = produccion.IdCliente
INNER JOIN proyectos ON produccion.IdProyecto = proyectos.IdProyecto
INNER JOIN usuarios_unidades ON produccion.IdUnidad = usuarios_unidades.IdUnidad
INNER JOIN negocios ON produccion.IdPresupuesto = negocios.IdPresupuesto AND produccion.IdProyecto = negocios.IdProyecto AND produccion.IdCliente = negocios.IdCliente
INNER JOIN presupuestos ON produccion.IdPresupuesto = presupuestos.IdPresupuesto WHERE usuarios_unidades.usuario='".$_SESSION['usuario']."'";
			break;
		case 1:
				$sql = "SELECT
produccion.IdProduccion,
produccion.Finalizada,
produccion.Aprobada,
clientes.NombreCliente,
produccion.IdPresupuesto,
produccion.ProductorEjecutivo,
proyectos.IdProyecto,
proyectos.NombreProyecto,
proyectos.NombreContacto,
produccion.ProductorCampo,
produccion.TotalTerceros,
produccion.TotalESL,
produccion.GranTotal AS CostoProduccion,
produccion.Rentabilidad,
negocios.ValAD AS ValorAdministracion,
negocios.ValDG AS ValorDirector,
negocios.ValBM AS ValorComercial,
negocios.ValPR AS ValorProduccion,
presupuestos.Total AS TotalPresupuesto
FROM
produccion
INNER JOIN clientes ON clientes.IdCliente = produccion.IdCliente
INNER JOIN proyectos ON produccion.IdProyecto = proyectos.IdProyecto
INNER JOIN usuarios_unidades ON produccion.IdUnidad = usuarios_unidades.IdUnidad
INNER JOIN negocios ON produccion.IdPresupuesto = negocios.IdPresupuesto AND produccion.IdProyecto = negocios.IdProyecto AND produccion.IdCliente = negocios.IdCliente
INNER JOIN presupuestos ON produccion.IdPresupuesto = presupuestos.IdPresupuesto WHERE usuarios_unidades.usuario='".$_SESSION['usuario']."'";
			break;
		case 2:
				$sql = "SELECT
produccion.IdProduccion,
produccion.Finalizada,
produccion.Aprobada,
clientes.NombreCliente,
produccion.IdPresupuesto,
produccion.ProductorEjecutivo,
proyectos.IdProyecto,
proyectos.NombreProyecto,
proyectos.NombreContacto,
produccion.ProductorCampo,
produccion.TotalTerceros,
produccion.TotalESL,
produccion.GranTotal AS CostoProduccion,
produccion.Rentabilidad,
negocios.ValAD AS ValorAdministracion,
negocios.ValDG AS ValorDirector,
negocios.ValBM AS ValorComercial,
negocios.ValPR AS ValorProduccion,
presupuestos.Total AS TotalPresupuesto
FROM
produccion
INNER JOIN clientes ON clientes.IdCliente = produccion.IdCliente
INNER JOIN proyectos ON produccion.IdProyecto = proyectos.IdProyecto
INNER JOIN usuarios_unidades ON produccion.IdUnidad = usuarios_unidades.IdUnidad
INNER JOIN negocios ON produccion.IdPresupuesto = negocios.IdPresupuesto AND produccion.IdProyecto = negocios.IdProyecto AND produccion.IdCliente = negocios.IdCliente
INNER JOIN presupuestos ON produccion.IdPresupuesto = presupuestos.IdPresupuesto WHERE NombreCliente LIKE '%".$valor."%' AND usuarios_unidades.usuario='".$_SESSION['usuario']."'";	
			break;
		case 3:
				$sql = "SELECT
produccion.IdProduccion,
produccion.Finalizada,
produccion.Aprobada,
clientes.NombreCliente,
produccion.IdPresupuesto,
produccion.ProductorEjecutivo,
proyectos.IdProyecto,
proyectos.NombreProyecto,
proyectos.NombreContacto,
produccion.ProductorCampo,
produccion.TotalTerceros,
produccion.TotalESL,
produccion.GranTotal AS CostoProduccion,
produccion.Rentabilidad,
negocios.ValAD AS ValorAdministracion,
negocios.ValDG AS ValorDirector,
negocios.ValBM AS ValorComercial,
negocios.ValPR AS ValorProduccion,
presupuestos.Total AS TotalPresupuesto
FROM
produccion
INNER JOIN clientes ON clientes.IdCliente = produccion.IdCliente
INNER JOIN proyectos ON produccion.IdProyecto = proyectos.IdProyecto
INNER JOIN usuarios_unidades ON produccion.IdUnidad = usuarios_unidades.IdUnidad
INNER JOIN negocios ON produccion.IdPresupuesto = negocios.IdPresupuesto AND produccion.IdProyecto = negocios.IdProyecto AND produccion.IdCliente = negocios.IdCliente
INNER JOIN presupuestos ON produccion.IdPresupuesto = presupuestos.IdPresupuesto WHERE NombreProyecto LIKE '%".$valor."%' AND usuarios_unidades.usuario='".$_SESSION['usuario']."'";	
			break;
		case 4:
				$sql = "SELECT
produccion.IdProduccion,
produccion.Finalizada,
produccion.Aprobada,
clientes.NombreCliente,
produccion.IdPresupuesto,
produccion.ProductorEjecutivo,
proyectos.IdProyecto,
proyectos.NombreProyecto,
proyectos.NombreContacto,
produccion.ProductorCampo,
produccion.TotalTerceros,
produccion.TotalESL,
produccion.GranTotal AS CostoProduccion,
produccion.Rentabilidad,
negocios.ValAD AS ValorAdministracion,
negocios.ValDG AS ValorDirector,
negocios.ValBM AS ValorComercial,
negocios.ValPR AS ValorProduccion,
presupuestos.Total AS TotalPresupuesto
FROM
produccion
INNER JOIN clientes ON clientes.IdCliente = produccion.IdCliente
INNER JOIN proyectos ON produccion.IdProyecto = proyectos.IdProyecto
INNER JOIN usuarios_unidades ON produccion.IdUnidad = usuarios_unidades.IdUnidad
INNER JOIN negocios ON produccion.IdPresupuesto = negocios.IdPresupuesto AND produccion.IdProyecto = negocios.IdProyecto AND produccion.IdCliente = negocios.IdCliente
INNER JOIN presupuestos ON produccion.IdPresupuesto = presupuestos.IdPresupuesto WHERE NombreContacto LIKE '%".$valor."%' AND usuarios_unidades.usuario='".$_SESSION['usuario']."'";
			break;
		case 5:
			$sql = "SELECT
produccion.IdProduccion,
produccion.Finalizada,
produccion.Aprobada,
clientes.NombreCliente,
produccion.IdPresupuesto,
produccion.ProductorEjecutivo,
proyectos.IdProyecto,
proyectos.NombreProyecto,
proyectos.NombreContacto,
produccion.ProductorCampo,
produccion.TotalTerceros,
produccion.TotalESL,
produccion.GranTotal AS CostoProduccion,
produccion.Rentabilidad,
negocios.ValAD AS ValorAdministracion,
negocios.ValDG AS ValorDirector,
negocios.ValBM AS ValorComercial,
negocios.ValPR AS ValorProduccion,
presupuestos.Total AS TotalPresupuesto
FROM
produccion
INNER JOIN clientes ON clientes.IdCliente = produccion.IdCliente
INNER JOIN proyectos ON produccion.IdProyecto = proyectos.IdProyecto
INNER JOIN usuarios_unidades ON produccion.IdUnidad = usuarios_unidades.IdUnidad
INNER JOIN negocios ON produccion.IdPresupuesto = negocios.IdPresupuesto AND produccion.IdProyecto = negocios.IdProyecto AND produccion.IdCliente = negocios.IdCliente
INNER JOIN presupuestos ON produccion.IdPresupuesto = presupuestos.IdPresupuesto WHERE produccion.IdProyecto='".$valor."' AND usuarios_unidades.usuario='".$_SESSION['usuario']."'";
			break;
	}

	if($_SESSION['unidad']!=0){
		$sql.=" AND usuarios_unidades.IdUnidad='".$_SESSION['unidad']."'";
	}

	$sql.=" ORDER BY produccion.IdProduccion ASC";

	$connect=mysql_select_db($database_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
?>
<div class="cuerpo">
    <h3>Consulta de Hoja <span>de Producci&oacute;n</span></h3>
    <table>
        <tr>
            <td><img src="images/aprobado.png"/></td>
            <td><label>Finalizada / Aprobada</label></td>
            <td><img src="images/noaprobado.png"/></td>
            <td><label>No Finalizada</label></td>
            <td><img src="images/denegado.png"/></td>
            <td><label>No Aprobada</label></td>
        </tr>
    </table>
    <br />
	<table id="results" class="estilotabla">
        <thead>
        <tr>
            <th><div align="center"><label>Opciones</label></div></th>
            <th><div align="center"><label>Finalizada</label></div></th>
            <th><div align="center"><label>Aprobada</label></div></th>
            <th><div align="center"><label>No. Negocio</label></div></th>
            <th><div align="center"><label>Nombre Cliente</label></div></th>
            <th><div align="center"><label>Nombre Proyecto</label></div></th>
            <?
            if (Privilegios($privilegio,'VerRentabilidad')){
	           echo '<th><div align="center"><label>Rentabilidad</label></div></th>';
            }
            ?>
            <th><div align="center"><label>Productor Ejecutivo</label></div></th>
            <th><div align="center"><label>Total Producci&oacute;n</label></div></th>
        </tr>
        </thead>
        <tbody>
<?
            while($registros=mysql_fetch_assoc($consulta)){
                $seguimiento=$registros['IdProduccion'];
                $valter=aMoneda($registros['TotalTerceros']);
                $valesl=aMoneda($registros['TotalESL']);
                $valtot=aMoneda($registros['CostoProduccion']);
                echo '<tr>';
                    echo '<td>
                            <table class="tabla-opciones">
                                <tr>
                                    <td>';
                                    if(($registros['Finalizada']==1) && (Privilegios($privilegio,'VerProduccion'))){
                                        echo '<a href="inicio.php?location=verprod&seguimiento='.$seguimiento.'"><img src="images/ver.png"  /></a>';
                                    }
		                      echo '</td>';
		                      echo '<td>';
		                      if(($registros['Finalizada']==1) && (Privilegios($privilegio,'LevantarProduccion'))){
			                     $linklevanta="inicio.php?location=levprod&seguimiento=".$seguimiento;
			                     echo '<img src="images/candado.png" onclick="ValidaAccion(\''.$linklevanta.'\')" />';
		                      }
		                      echo '</td>';
		                      echo '<td>';
		                      if (Privilegios($privilegio,'EditarProduccion')){
			                     if($registros['Finalizada']==0){
				                    $linkfinaliza='inicio.php?location=contprod&seguimiento='.$seguimiento;
				                    if($_SESSION['unidad']!=0){
					                   echo '<img src="images/editar.png" onclick="ValidaAccion(\''.$linkfinaliza.'\')"/>';
				                    }
			                     }
		                      }
		                      echo '</td>';
                              $linkelimina='inicio.php?location=borrarprod&seguimiento='.$seguimiento;
		                      echo '<td>';
		                      if (Privilegios($privilegio,'EliminarProduccion') && ($registros['Finalizada']!=1) && ($registros['Aprobada']!=1)){
			                     echo '<img src="images/elimina.png" onclick="ValidaAccion(\''.$linkelimina.'\')"/>';
		                      }
		                      echo '</td>';
		                      echo '<td>';
//		if(($registros['Finalizada']==1) && ($registros['Aprobada']==1)){
			                     $linkcompra='inicio.php?location=ordcomp&seguimiento='.$seguimiento.'&estado='.$registros['Finalizada'];
			                     echo '<img src="images/compra.png" onclick="ValidaAccion(\''.$linkcompra.'\')" />';
                              echo '</td>
                              </tr>
                        </table>
                    </td>';
                    if($registros['Finalizada']==1){
                        echo '<td><div align="center"><img src="images/aprobado.png"></div></td>';
                    }else{
                        $linkfinalizar='inicio.php?location=finprod&seguimiento='.$seguimiento;
                        echo '<td><div align="center"><img src="images/noaprobado.png" onclick="ValidaAccion(\''.$linkfinalizar.'\')"/></div></td>';
                    }
                    
                    if($registros['Aprobada']==1){
                        echo '<td><div align="center"><img src="images/aprobado.png"></div></td>';
                    }else{
                        if(Privilegios($privilegio,'AprobarProduccion')) {
                            $linkaprobar='inicio.php?location=aprobprod&seguimiento='.$seguimiento;
                            echo '<td><div align="center"><img src="images/denegado.png" onclick="ValidaAccion(\''.$linkaprobar.'\')"/></div></td>';
                        }else{
                            echo '<td><div align="center"><img src="images/denegado.png" onclick="alert(\'Solo un Administrador Puede Usar esta Función\')"/></div></td>';
                        }
                    }		

        		echo '<td><div>'.$registros['IdProyecto'].'</div></td>';
        		echo '<td><div>'.$registros['NombreCliente'].'</div></td>';
        		echo '<td><div>'.$registros['NombreProyecto'].'</div></td>';
        
        		if (Privilegios($privilegio,'VerRentabilidad')){
  		            $rent_negocio=($registros['TotalPresupuesto']-($registros['CostoProduccion']+$registros['ValorAdministracion']+$registros['ValorDirector']+$registros['ValorComercial']+$registros['ValorProduccion']))/$registros['TotalPresupuesto'];
        			echo '<td><div align="center">'.number_format($rent_negocio*100,2).'&nbsp;%&nbsp;</div></td>';
        		}

/*		$cadprode="SELECT * FROM usuarios WHERE IdUsuario=".$registros['ProductorEjecutivo'];
		$cltprode=mysql_query($cadprode,$cnn);
		$rsprode=mysql_fetch_assoc($cltprode);
		echo '<td><div>'.$rsprode['Nombre'].'</div></td>';*/

		$cadprodc="SELECT usuarios.IdUsuario, usuarios.Usuario, usuarios.Nombre, usuarios.Correo 
        FROM usuarios 
        WHERE usuarios.Usuario = '".$registros['ProductorEjecutivo']."'";
		$cltprodc=mysql_query($cadprodc,$cnn);
		$rsprodc=mysql_fetch_assoc($cltprodc);

		echo '<td><div>'.$rsprodc['Nombre'].'</div></td>';
		echo '<td><div>'.$valtot.'</div></td>';
		echo '</tr>';
	}
    mysql_close($cnn);
?>
	   </tbody>
    </table>
</div>


<?
}
?>