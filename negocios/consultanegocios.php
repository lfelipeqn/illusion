<?php
	//session_start();
	include ('Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$opcion=$_GET['tipo'];
	$valor=$_GET['valor'];

	switch($opcion){
		case 0:
			$sql = "SELECT vw_negocios.IdNegocio, vw_negocios.IdPresupuesto, vw_negocios.FechaCreacion, vw_negocios.Anticipo, vw_negocios.PorcAnticipo, vw_negocios.Comercial, vw_negocios.ComisionExternos, vw_negocios.ComisionESL, vw_negocios.PagoComisiones, vw_negocios.Observaciones, vw_negocios.NombreCliente, vw_negocios.Identificacion, vw_negocios.DV, vw_negocios.email, vw_negocios.SubEspectaculos, vw_negocios.SubEventosCorp, vw_negocios.SubNuevasTec, vw_negocios.SubProduccion, vw_negocios.Subtotal, vw_negocios.NombreProyecto, vw_negocios.TipoEmpresa, vw_negocios.NombreContacto, vw_negocios.LugarEvento, vw_negocios.Descuento, vw_negocios.KnowHow, vw_negocios.Total, vw_negocios.EmailContacto, vw_negocios.IdUnidad, vw_negocios.IdProyecto, vw_negocios.Productor, usuarios_unidades.usuario, vw_negocios.IdCliente FROM vw_negocios INNER JOIN usuarios_unidades ON vw_negocios.IdUnidad = usuarios_unidades.IdUnidad WHERE Usuario = '".$_SESSION['usuario']."'";
			break;
		case 1:
			$sql = "SELECT vw_negocios.IdNegocio, vw_negocios.IdPresupuesto, vw_negocios.FechaCreacion, vw_negocios.Anticipo, vw_negocios.PorcAnticipo, vw_negocios.Comercial, vw_negocios.ComisionExternos, vw_negocios.ComisionESL, vw_negocios.PagoComisiones, vw_negocios.Observaciones, vw_negocios.NombreCliente, vw_negocios.Identificacion, vw_negocios.DV, vw_negocios.email, vw_negocios.SubEspectaculos, vw_negocios.SubEventosCorp, vw_negocios.SubNuevasTec, vw_negocios.SubProduccion, vw_negocios.Subtotal, vw_negocios.NombreProyecto, vw_negocios.TipoEmpresa, vw_negocios.NombreContacto, vw_negocios.LugarEvento, vw_negocios.Descuento, vw_negocios.KnowHow, vw_negocios.Total, vw_negocios.EmailContacto, vw_negocios.IdUnidad, vw_negocios.IdProyecto, vw_negocios.Productor, usuarios_unidades.usuario, vw_negocios.IdCliente FROM vw_negocios INNER JOIN usuarios_unidades ON vw_negocios.IdUnidad = usuarios_unidades.IdUnidad WHERE Usuario = '".$_SESSION['usuario']."'";
			break;
		case 2:
			$sql = "SELECT vw_negocios.IdNegocio, vw_negocios.IdPresupuesto, vw_negocios.FechaCreacion, vw_negocios.Anticipo, vw_negocios.PorcAnticipo, vw_negocios.Comercial, vw_negocios.ComisionExternos, vw_negocios.ComisionESL, vw_negocios.PagoComisiones, vw_negocios.Observaciones, vw_negocios.NombreCliente, vw_negocios.Identificacion, vw_negocios.DV, vw_negocios.email, vw_negocios.SubEspectaculos, vw_negocios.SubEventosCorp, vw_negocios.SubNuevasTec, vw_negocios.SubProduccion, vw_negocios.Subtotal, vw_negocios.NombreProyecto, vw_negocios.TipoEmpresa, vw_negocios.NombreContacto, vw_negocios.LugarEvento, vw_negocios.Descuento, vw_negocios.KnowHow, vw_negocios.Total, vw_negocios.EmailContacto, vw_negocios.IdUnidad, vw_negocios.IdProyecto, vw_negocios.Productor, usuarios_unidades.usuario, vw_negocios.IdCliente FROM vw_negocios INNER JOIN usuarios_unidades ON vw_negocios.IdUnidad = usuarios_unidades.IdUnidad WHERE NombreCliente LIKE '%".$valor."%' AND Usuario = '".$_SESSION['usuario']."'";
			break;
		case 3:
			$sql = "SELECT vw_negocios.IdNegocio, vw_negocios.IdPresupuesto, vw_negocios.FechaCreacion, vw_negocios.Anticipo, vw_negocios.PorcAnticipo, vw_negocios.Comercial, vw_negocios.ComisionExternos, vw_negocios.ComisionESL, vw_negocios.PagoComisiones, vw_negocios.Observaciones, vw_negocios.NombreCliente, vw_negocios.Identificacion, vw_negocios.DV, vw_negocios.email, vw_negocios.SubEspectaculos, vw_negocios.SubEventosCorp, vw_negocios.SubNuevasTec, vw_negocios.SubProduccion, vw_negocios.Subtotal, vw_negocios.NombreProyecto, vw_negocios.TipoEmpresa, vw_negocios.NombreContacto, vw_negocios.LugarEvento, vw_negocios.Descuento, vw_negocios.KnowHow, vw_negocios.Total, vw_negocios.EmailContacto, vw_negocios.IdUnidad,  vw_negocios.IdProyecto, vw_negocios.Productor, usuarios_unidades.usuario, vw_negocios.IdCliente FROM vw_negocios INNER JOIN usuarios_unidades ON vw_negocios.IdUnidad = usuarios_unidades.IdUnidad WHERE NombreProyecto LIKE '%".$valor."%' AND Usuario = '".$_SESSION['usuario']."'";
			break;
		case 4:
			$sql = "SELECT vw_negocios.IdNegocio, vw_negocios.IdPresupuesto, vw_negocios.FechaCreacion, vw_negocios.Anticipo, vw_negocios.PorcAnticipo, vw_negocios.Comercial, vw_negocios.ComisionExternos, vw_negocios.ComisionESL, vw_negocios.PagoComisiones, vw_negocios.Observaciones, vw_negocios.NombreCliente, vw_negocios.Identificacion, vw_negocios.DV, vw_negocios.email, vw_negocios.SubEspectaculos, vw_negocios.SubEventosCorp, vw_negocios.SubNuevasTec, vw_negocios.SubProduccion, vw_negocios.Subtotal, vw_negocios.NombreProyecto, vw_negocios.TipoEmpresa, vw_negocios.NombreContacto, vw_negocios.LugarEvento, vw_negocios.Descuento, vw_negocios.KnowHow, vw_negocios.Total, vw_negocios.EmailContacto, vw_negocios.IdUnidad, vw_negocios.IdProyecto, vw_negocios.Productor, usuarios_unidades.usuario, vw_negocios.IdCliente FROM vw_negocios INNER JOIN usuarios_unidades ON vw_negocios.IdUnidad = usuarios_unidades.IdUnidad WHERE NombreContacto LIKE '%".$valor."%' AND Usuario = '".$_SESSION['usuario']."'";
			break;
		case 5:
			$sql = "SELECT vw_negocios.IdNegocio, vw_negocios.IdPresupuesto, vw_negocios.FechaCreacion, vw_negocios.Anticipo, vw_negocios.PorcAnticipo, vw_negocios.Comercial, vw_negocios.ComisionExternos, vw_negocios.ComisionESL, vw_negocios.PagoComisiones, vw_negocios.Observaciones, vw_negocios.NombreCliente, vw_negocios.Identificacion, vw_negocios.DV, vw_negocios.email, vw_negocios.SubEspectaculos, vw_negocios.SubEventosCorp, vw_negocios.SubNuevasTec, vw_negocios.SubProduccion, vw_negocios.Subtotal, vw_negocios.NombreProyecto, vw_negocios.TipoEmpresa, vw_negocios.NombreContacto, vw_negocios.LugarEvento, vw_negocios.Descuento, vw_negocios.KnowHow, vw_negocios.Total, vw_negocios.EmailContacto, vw_negocios.IdUnidad, vw_negocios.IdProyecto, vw_negocios.Productor, usuarios_unidades.usuario, vw_negocios.IdCliente FROM vw_negocios INNER JOIN usuarios_unidades ON vw_negocios.IdUnidad = usuarios_unidades.IdUnidad WHERE vw_negocios.IdProyecto='".$valor."' AND Usuario = '".$_SESSION['usuario']."'";
			break;
	}

	if($_SESSION['unidad']!=0){
		$sql.=" AND vw_negocios.IdUnidad = '".$_SESSION['unidad']."'";
	}
	$sql.=" ORDER BY FechaCreacion DESC";

	$connect=mysql_select_db($database_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
?>
<div class="cuerpo">
	<h3>Consulta de <span>Negocios</span></h3>
	<p>A Continuaci&oacute;n se presenta el listado de los Negocios Disponibles para Consulta</p>
	<table id="results">
        <thead>
            <tr>
                <th><div align="center"><label>Opciones</label></div></th>
        		<th><div align="center"><label>Negocio</label></div></th>
        		<th><div align="center"><label>Cliente</label></div></th>
        		<th><div align="center"><label>Proyecto</label></div></th>
        		<th><div align="center"><label>Presupuesto</label></div></th>
        		<th><div align="center"><label>Fecha Creaci&oacute;n</label></div></th>
        <?
                if(Privilegios($_SESSION['perfil'],'AsignarProduccion')){
                    echo '<th><div align="center"><label>Produccion</label></div></th>';
                    echo '<th><div align="center"><label>Asignar</label></div></th>';
                }
        ?>
	   </tr>
       </thead>
       <tbody>
    <?
	$i=1;
	while ($rs=mysql_fetch_assoc($consulta)){
		$fecha=ConvFecha($rs['FechaCreacion']);
	//echo '<form action="produccion/creaproduccion.php?seguimiento='.$rs['IdNegocio'].'" method="post" id="aproduccion'.$i.'" name="aproduccion'.$i.'">';
	echo '
	<tr>		<form action="produccion/creaproduccion.php?seguimiento='.$rs['IdNegocio'].'" method="post" id="aproduccion'.$i.'" name="aproduccion'.$i.'">
		<td>
        <table class="tabla-opciones">
        <tr>
        <td>';
		$sqlverf="SELECT produccion.IdProyecto, produccion.Aprobada, produccion.Finalizada FROM produccion WHERE produccion.IdProyecto = '".$rs['IdProyecto']."' AND produccion.Finalizada = 1 AND produccion.Aprobada = 1";
		$cltverf=mysql_query($sqlverf,$cnn) or die(mysql_error());
		$verf=mysql_num_rows($cltverf);
		if(($verf>=1)||($_SESSION['perfil']=='Administrador')|| ($privilegio=='Supervisor')){
			echo '<div align="center"><a href="inicio.php?location=buss&negocio='.$rs['IdProyecto'].'"><img src="images/ver.png"/></a></div>';
		}
		echo '
        </td>
        <td>';
		if($_SESSION['perfil']=='Administrador'){
			$linkelimina="inicio.php?location=elmneg&negocio=".$rs['IdNegocio'];
			echo'<img src="images/elimina.png" onclick="ValidaAccion(\''.$linkelimina.'\')"/>';
		}
		echo '
		</td>
        </tr>
        </table>
        </td>
		<td><div align="left">'.$rs['IdProyecto'].'</div></td>
		<td><div align="left"><label>'.strtoupper($rs['NombreCliente']).'</label></div></td>
		<td><div align="left"><label>'.strtoupper($rs['NombreProyecto']).'</label></div></td>
		<td><div align="left"><label>'.strtoupper($rs['IdPresupuesto']).'</label></div></td>
		<td><div align="left"><label>'.$fecha.'</label></div></td>';

		$sqlproduccion="SELECT produccion.IdProduccion FROM produccion WHERE produccion.IdProyecto =".$rs['IdProyecto'];
		$cltproduccion=mysql_query($sqlproduccion,$cnn) or die(mysql_error());
		$totalproduccion=mysql_num_rows($cltproduccion);

		if(Privilegios($_SESSION['perfil'],'AsignarProduccion')){
		echo'<td>';
            if($totalproduccion>=1){
    				echo '<select id="sprod" name="sprod" disabled="disabled">';
    			}else{
    				echo '<select id="sprod" name="sprod">';
    			}
	            $cadprod="SELECT usuarios.Usuario, usuarios.Nombre FROM usuarios WHERE usuarios.IdPerfil = 3";
	            $cltprod=mysql_query($cadprod,$cnn) or die(mysql_error());

				echo '<option value="0">---- Elija un Productor ----</option>';
				while($rsprod=mysql_fetch_assoc($cltprod)){
					if($rs['Productor']==$rsprod['Usuario']){
						echo '<option value="'.$rsprod['Usuario'].'" selected="selected">'.$rsprod['Nombre'].'</option>';
					}else{
						echo '<option value="'.$rsprod['Usuario'].'">'.$rsprod['Nombre'].'</option>';	
					}
				}

				mysql_free_result($cltprod);
	         echo'</select>
            </td>';
            
      echo '<td>
                <input type="hidden" id="tipo" name="tipo" value="N"/>
                <input type="hidden" id="esnego" name="esnego" value="S"/>
                <input type="hidden" id="nego" name="nego" value="'.$rs['IdNegocio'].'"/>
                <input type="hidden" id="totpres" name="totpres" value="'.$rs['Total'].'"/>
                <input type="hidden" id="pproy" name="pproy" value="'.$rs['IdProyecto'].'"/>
                <input type="hidden" id="ncliente" name="ncliente" value="'.$rs['IdCliente'].'"/>';
                if($totalproduccion>=1){
                    echo '<input type="submit" value="Asignar Produccion" disabled="disabled"/>';
                }else{
                    echo '<input type="button" value="Asignar Produccion" onclick="validarform(\'aproduccion'.$i.'\',\'asigna\')"/>';
                }
    echo '</td>';
    }echo '</form>';
echo'</tr>';
        $i++;
        mysql_free_result($cltproduccion);
    }
    mysql_close($cnn);
?>
        </tbody>
    </table>
    <br />
</div>
<?
}
?>