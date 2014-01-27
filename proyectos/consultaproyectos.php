<?php
	if(isset($_SESSION['usuario'])){
	include ('Connections/cnn.php');
	$opcion=$_GET['tipo'];
	$valor=$_GET['valor'];
	if($opcion==1){
		$sql = "select * from proyectos INNER JOIN usuarios_unidades ON proyectos.IdUnidad = usuarios_unidades.IdUnidad WHERE Nombreproyecto LIKE '%".$valor."%' AND usuarios_unidades.usuario='".$_SESSION['usuario']."'";
	}else{
		$sql = "select * from proyectos INNER JOIN usuarios_unidades ON proyectos.IdUnidad = usuarios_unidades.IdUnidad WHERE usuarios_unidades.usuario='".$_SESSION['usuario']."'";
	}
	if($_SESSION['unidad']!=0){
			$sql.=" AND usuarios_unidades.IdUnidad = '".$_SESSION['unidad']."'";
	}
	$sql.=" ORDER BY FechaEvento DESC";
	$connect=mysql_select_db($database_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
?>
	
<div class="cuerpo">
    <h3>Consulta de <span>Proyectos</span></h3>
    <p>A Continuaci&oacute;n se presenta el listado de todos los proyectos Activos</p>
	<table id="results">
        <thead>
            <tr>
                <td><div align="center"><label>Opciones</label></div></td>
        		<td><div align="center"><label>Proyecto</label></div></td>
        		<td><div align="center"><label>Nombre Proyecto</label></div></td>
        		<td><div align="center"><label>Contacto</label></div></td>
        		<!--<td><div align="center"><label>E-Mail</label></div></td>-->
        		<td><div align="center"><label>Tel&eacute;fono</label></div></td>
        		<td><div align="center"><label>Ciudades</label></div></td>
        		<td><div align="center"><label>Lugar Evento</label></div></td>
        		<td><div align="center"><label>Fecha Evento</label></div></td>
        		<td><div align="center"><label>Fecha Montaje</label></div></td>
	       </tr>
        </thead>
        <tbody>
<?
        while ($rs=mysql_fetch_assoc($consulta)){
    		$fecha=ConvFecha($rs['FechaEvento']);
    		$fecham=ConvFecha($rs['FechaMontaje']);
    		$fechad=ConvFecha($rs['FechaDesmontaje']);
    		$linkeditar='inicio.php?location=editaproy&seguimiento='.$rs['IdProyecto'];
            echo '
            <tr>
                <td>
                    <table class="tabla-opciones">
                        <tr>
                            <td><div align="center"><a class="brief" href="inicio.php?location=brief&proyecto='.$rs['IdProyecto'].'" ><img src="images/ver.png"/></a></div></td>
                            <td><div align="left"><label><img src="images/editar.png" onclick="ValidaAccion(\''.$linkeditar.'\')"/></label></div></td>
                        </tr>
                    </table>
                </td>
                <td><div align="right"><b>'.$rs['IdProyecto'].'</b></div></td>
        		<td><div align="right" class="proyecto">'.strtoupper($rs['NombreProyecto']).'</div></td>
        		<td><div align="right"><label>'.strtoupper($rs['NombreContacto']).'</label></div></td>';
        		//<td><div align="right"><label>'.strtolower($rs['EmailContacto']).'</label></div></td>
        		echo '<td><div align="right"><label>'.strtoupper($rs['TelefonoContacto']).'</label></div></td>
        		<td><div align="right"><label>'.strtoupper($rs['Ciudades']).'</label></div></td>
        		<td><div align="right"><label>'.strtoupper($rs['LugarEvento']).'</label></div></td>
        		<td><div align="right"><label>'.$fecha.'</label></div></td>
        		<td><div align="right"><label>'.$fecham.'</label></div></td>
	       </tr>';
	   }
       mysql_close($cnn);
?>
        </tbody>
    </table>
<?
}
?>