<?php
	session_start();
	include 'funciones.php';
	$ua=Navegador();
	$location=$_GET['location']; if (empty($location)) { $location='inicio'; }
	$privilegio=$_SESSION['perfil'];
if($privilegio!=''){
//	if($ua['name']=='Mozilla Firefox'){
		echo'
		<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			<!--<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>-->
            <script src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js" type="text/javascript"></script>            
			<script src="js/cufon-yui.js" type="text/javascript"></script>
            <script src="js/jquery.js" type="text/javascript"></script>
			<script src="js/cufon-replace.js" type="text/javascript"></script>
			<script src="js/Myriad_Pro_300.font.js" type="text/javascript"></script>
			<script src="js/Myriad_Pro_400.font.js" type="text/javascript"></script>
			<script src="js/control.js" type="text/javascript"></script>
			<script src="js/calendario.js" type="text/javascript"></script>
			<script src="js/paginar.js" type="text/javascript" ></script>
			<script src="js/subtotal.js" type="text/javascript"></script>
			<script src="js/funciones.js" type="text/javascript"></script>
			<script src="js/produccion.js" type="text/javascript"></script>
			<script src="js/negocios.js" type="text/javascript"></script>
			<script type="text/javascript" src="js/ddaccordion.js"></script>
			<script type="text/javascript" src="js/selaccordion.js"></script>
			<script type="text/javascript" src="js/lightbox.js"></script>
            
            <script type="text/javascript" src="js/datatables/js/jquery.dataTables.js"></script>
            <script type="text/javascript" src="js/datatables/media/js/TableTools.js"></script>
            <script type="text/javascript" src="js/datatables/media/js/ZeroClipboard.js"></script>
            <link href="js/datatables/media/css/TableTools.css" rel="stylesheet" type="text/css" />
            <link href="js/datatables/media/css/TableTools_JUI.css" rel="stylesheet" type="text/css" />
            <link href="js/datatables/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
			<link href="styles/lightbox.css" rel="stylesheet" type="text/css" />
			<link href="styles/calendario.css" rel="stylesheet" type="text/css" />
			<link href="styles/style.css" rel="stylesheet" type="text/css" />
			<link href="styles/indice.css" rel="stylesheet" type="text/css" />
			<link href="styles/tablas.css" rel="stylesheet" type="text/css" />
			<title>ENTRETENIMIENTO SIN LIMITES</title>
		</head>
		<body>';
			echo '
			<table>
				<tr>
					<td colspan="2">'; 
						include ('header.php');
				echo'</td>
				</tr>
				<tr>
					<td rowspan="3">';
						include('indice.php');
				echo'</td>
					<td valign="top">';
						changelocation($location, $privilegio);
					echo '</td>
				</tr>
			</table>';
?>
            <script>
                $(document).ready(function(){
                    $('#results').dataTable({
                		"oLanguage": {
                			"sLengthMenu": "Mostrar _MENU_ registros",
                			"sZeroRecords": "No se han encontrado registros",
                			"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                			"sInfoEmpty": "mostrando 0 a 0 de 0 registros",
                			"sInfoFiltered": "(Filtrado de _MAX_ registros totales)",
                			"sSearch": "Filtrar: ",
                			'oPaginate': {
                        			'sFirst':    "Primero",
                        			'sPrevious': "Anterior",
                        			'sNext':     "Siguiente",
                        			'sLast':     "Ultimo"
                    		},
                    		"bAutoWidth": false
                		},
                        "sDom": 'T<"clear">lfrtip',
                        "oTableTools": {
                            "sSwfPath": "js/datatables/media/swf/copy_csv_xls_pdf.swf",
                            "aButtons": [
            				    {
            					   "sExtends": "copy",
            					   "sButtonText": "Copiar"
            				    },
            				    {
            					   "sExtends": "csv",
            					   "sButtonText": "Exportar a CSV"
            				    },
            				    {
            					   "sExtends": "xls",
            					   "sButtonText": "Exportar a Excel"
            				    }
            	           ]
                        }
                  	   });    
                    })
            </script>
<?
		echo '
	</body>
	</html>';
	//}
}

/*
<tr>
	<td><div align="center" widht="100%">';
					$unidad=$_SESSION['unidad'];

					switch($unidad){

						case '0':

							echo '<img src="images/esl-ini.jpg"/>';

							break;

						case '1':

							echo '<img src="images/corporativo.png"/>';

							break;

						case '2':

							echo '<img src="images/digital.png"/>';

							break;

						case '3':

							echo '<img src="images/agora.png"/>';

							break;

						case '4':

							echo '<img src="images/saxo.png"/>';

							break;

					}

				echo'</div></td>

			</tr>

<tr>

	<td colspan="2">

		<div align="center">

			Copyright - <a href="mailto:lfelipeqn@gmail.com">Luis Felipe Qui&ntilde;ones Nieto</a><br />

			<a href="">Para Entretenimiento Sin Limites LTDA</a><br />

	</div>

	</td>

</tr>*/

function changelocation($location, $privilegio) {
	switch ($location) {
		case 'inicio':
			include ('actualindex.php'); 	
			break;
		//************************************* CLIENTES ******************************************
		case 'clientes':
			if(Privilegios($privilegio,'ConsultarClientes')){
				include ('clientes.php');
			}else{
				include ('accesonegado.php');
			}
			break;

		case 'addcliente':
			if(Privilegios($privilegio,'CrearClientes')){
				include ('clientes/nuevocliente.php');
			}else{
				include ('accesonegado.php');
			}
			break;

		case 'confirma':
			if(Privilegios($privilegio,'ConsultarClientes')){
				include ('clientes/confirmacioncliente.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;

		case 'listclie':
			if(Privilegios($privilegio,'ConsultarClientes')){
				include('clientes/cltcliente.php');
			}else{
				include ('accesonegado.php');
			}
			break;

		case 'consultacl':
			if(Privilegios($privilegio,'ConsultarClientes')){
				include('clientes/buscaclientes.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'updcliente':
			if(Privilegios($privilegio,'ActualizarClientes')){
				include('clientes/actualizacioncliente.php');
			}else{
				include ('accesonegado.php');
			}
			break;

		case 'confirmaactualiza':
			if(Privilegios($privilegio,'ActualizarClientes')){
				include('clientes/confirmacionactualizacion.php');
			}else{
				include ('accesonegado.php');
			}
			break;

//************************************* PROYECTOS ******************************************

		case 'proyectos': 	
			if(Privilegios($privilegio,'ConsultarProyecto')){
				include ('proyectos.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;

		case 'nproy';
			if(Privilegios($privilegio,'CrearProyecto')){
				include('proyectos/nproyecto.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'confirmaproy';
			if(Privilegios($privilegio,'CrearProyecto')){
				include('proyectos/confirmacionproyecto.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'cltproy';
			if(Privilegios($privilegio,'ConsultarProyecto')){
				include('proyectos/buscaproyectos.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'listproy';
			if(Privilegios($privilegio,'ConsultarProyecto')){
				include('proyectos/consultaproyectos.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'brief';
			if(Privilegios($privilegio,'ConsultarProyecto')){
				include('proyectos/briefproyecto.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'editaproy':
			if(Privilegios($privilegio,'ActualizarProyecto')){
				include('proyectos/actualizarproyecto.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'confactproy':
			if(Privilegios($privilegio,'ActualizarProyecto')){
				include('proyectos/confirmaactualizap.php');
			}else{
				include ('accesonegado.php');
			}
			break;

//************************************* PROCESOS ******************************************
		case 'procesos': 	
			include ('procesos.php'); 	
			break;
		case 'comercial': 	
			include ('procesos/pcomercial.php'); 	
			break;
		case 'negocios': 	
			include ('procesos/pnegocios.php'); 	
			break;
		case 'produccion': 	
			include ('procesos/pproduccion.php'); 	
			break;
		case 'cg': 	
			include ('procesos/pcg.php'); 	
			break;
		case 'factura': 	
			include ('procesos/pfactura.php'); 	
			break;
		case 'recaudo': 	
			include ('procesos/precaudo.php'); 	
			break;
		case 'crm': 	
			include ('procesos/pcrm.php'); 	
			break;

//************************************* PROVEEDORES ******************************************
		case 'proveedores':
			if(Privilegios($privilegio,'ConsultarProveedor')){
				include ('proveedores.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'addproveedor':
			if(Privilegios($privilegio,'CrearProveedor')){
				include ('proveedores/nuevoproveedor.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;

		case 'confirmaprov':
			if(Privilegios($privilegio,'CrearProveedor')){
				include ('proveedores/confirmanuevo.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'ctlprv':
			if(Privilegios($privilegio,'ConsultarProveedor')){
				include ('proveedores/buscaproveedor.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'listprov':
			if(Privilegios($privilegio,'ConsultarProveedor')){
				include ('proveedores/cltproveedor.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'borrarprov':
			if(Privilegios($privilegio,'EliminarProveedor')){
				include ('proveedores/eliminaproveedor.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'verprov':
			if(Privilegios($privilegio,'VerProveedor')){
				include('proveedores/verproveedor.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'editprov':
			if(Privilegios($privilegio,'ActualizarProveedor')){
				include('proveedores/actproveedor.php');
			}else{
				include('accesonegado.php');
			}
			break;
		case 'confactprov':
			if(Privilegios($privilegio,'ActualizarProveedor')){
				include('proveedores/confactproveedor.php');
			}else{
				include ('accesonegado.php');
			}
			break;
        case 'rgoc';
            if(Privilegios($privilegio,'EstadoOrdenCompra')){
				include('recepcion/radicaproveedor.php');
			}else{
				include ('accesonegado.php');
			}
			break;

//************************************* REPORTES ***********************************************
		case 'report':
			if(($privilegio=='Administrador') || ($privilegio=='Operativo')|| ($privilegio=='Supervisor')){
				include ('reportes.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'reptecnica';
			if(($privilegio=='Administrador')||($privilegio=='Productor General')|| ($privilegio=='Supervisor')){
				include ('reportes/pagostecnica.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'expagostecnica':
			if(($privilegio=='Administrador')||($privilegio=='Productor General')|| ($privilegio=='Supervisor')){
				include ('reportes/reppagostecnica.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'represup':
			if(($privilegio=='Administrador')||($privilegio=='Comercial')|| ($privilegio=='Supervisor')){
				include ('reportes/reppresupuestos.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'reprent':
			if(($privilegio=='Administrador')|| ($privilegio=='Supervisor')){
				include ('reportes/reprentabilidad.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'repnego':
			if(($privilegio=='Administrador')||($privilegio=='Productor General')|| ($privilegio=='Supervisor')){
				include ('reportes/repnegocios.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'repasigna':
			if($privilegio=='Administrador'){
				include ('reportes/repasignacion.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'repanego':
			if($privilegio=='Administrador'){
				include ('reportes/repanego.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;

//************************************* PRESUPUESTOS ******************************************
		case 'gnpres':
			if(Privilegios($privilegio,'ConsultarPresupuesto')){
				include ('presupuesto.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'cltpres':
			if(Privilegios($privilegio,'ConsultarPresupuesto')){
				include ('presupuestos/buscarpresupuesto.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'listpres':
			if(Privilegios($privilegio,'ConsultarPresupuesto')){
				include ('presupuestos/consultapresupuesto.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'npresup':
			if(Privilegios($privilegio,'CrearPresupuesto')){
				include ('presupuestos/nuevopresupuesto.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'confpres':
			if(Privilegios($privilegio,'CrearPresupuesto')){
				include ('presupuestos/confirmapresupuesto.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'verpresup':
			if(Privilegios($privilegio,'VerPresupuesto')){
				include ('presupuestos/verpresupuesto.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'aprobarpres':
			if(Privilegios($privilegio,'AprobarPresupuesto')){
				include ('presupuestos/aprobarpresupuesto.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'borrarpres':
			if(Privilegios($privilegio,'EliminarPresupuesto')){
				include ('presupuestos/eliminapresupuesto.php');
			}else{
				include ('accesonegado.php');
			}
			break;

		case 'continuepres':
			if(Privilegios($privilegio,'ActualizarPresupuesto')){
				include ('presupuestos/continuapresupuesto.php');
			}else{
				include ('accesonegado.php');
			}
			break;

//************************************* NEGOCIOS ******************************************
		case 'nnegocio':
			if(Privilegios($privilegio,'CrearNegocio')){
				include ('negocios/nuevonegocio.php');
			}else{
				include ('accesonegado.php');
			}
			break;

		case 'confnegocio':
			if(Privilegios($privilegio,'CrearNegocio')){
				include('negocios/confirmanegocio.php');
			}else{
				include ('accesonegado.php');
			}
			break;

		case 'cltnego':
			if(Privilegios($privilegio,'ConsultarNegocio')){
				include('negocios/buscarnegocio.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'listnego':
			if(Privilegios($privilegio,'ConsultarNegocio')){
				include('negocios/consultanegocios.php');
			}else{
				include ('accesonegado.php');
			}
			break;

		case 'buss':
			if(Privilegios($privilegio,'VerNegocio')){
				include('negocios/hojanegocio.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'elmneg':
			if(Privilegios($privilegio,'EliminarNegocio')){
				include('negocios/eliminanegocio.php');
			}else{
				include ('accesonegado.php');
			}
			break;

//************************************* PRODUCCION ******************************************
		/*case 'nprod':
			if(($privilegio=='Administrador') || ($privilegio=='Productor General') || ($privilegio=='Productor')){
				include('produccion/nuevaproduccion.php');
			}else{
				include ('accesonegado.php');
			}
			break;*/
		case 'confprod':
			if(Privilegios($privilegio,'CrearNegocio')){
				include('produccion/confirmaprod.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'aprobprod':
			if(Privilegios($privilegio,'AprobarProduccion')){
				include('produccion/aprobarprod.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'finprod':
			if(Privilegios($privilegio,'FinalizarProduccion')){
				include('produccion/finalizarprod.php');
			}else{
				include ('accesonegado.php');
			}
			break;

		case 'cltpro':
			if(Privilegios($privilegio,'ConsultarProduccion')){
				include('produccion/buscarproduccion.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'listpro':
			if(Privilegios($privilegio,'ConsultarProduccion')){
				include('produccion/consultaproduccion.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'verprod':
			if(Privilegios($privilegio,'VerProduccion')){
				include('produccion/hojaproduccion.php');
			}else{
				include ('accesonegado.php');
			}
			break;

		case 'contprod':
			if(Privilegios($privilegio,'EditarProduccion')){
				include('produccion/continuaproduccion.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'borrarprod':
			if(Privilegios($privilegio,'EliminarProduccion')){
				include('produccion/borrarproduccion.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'levprod':
			if(Privilegios($privilegio,'LevantarProduccion')){
				include('produccion/levantaproduccion.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'valid';
			include('produccion/confirmavalida.php');
			break;
		case 'invalid';
			include('produccion/responsables.php');
			break;
//************************************* COMPRAS ******************************************
		case 'ordcomp':
			if(Privilegios($privilegio,'CrearOrdenCompra')){
				include('produccion/ordendecompra.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'elmorden':
			if(Privilegios($privilegio,'CrearOrdenCompra')){
				include('produccion/borrarorden.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'detalleorden':
			if(Privilegios($privilegio,'CrearOrdenCompra')){
				include('produccion/detallecompra.php');
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'cltcompra':
			if(Privilegios($privilegio,'CrearOrdenCompra')){
				include('produccion/vercompra.php');
			}else{
				include ('accesonegado.php');
			}
			break;
			
//************************************* FACTURACION ******************************************
		case 'factura': 	
			if(Privilegios($privilegio,'CrearFactura')){
				include ('facturacion.php'); 	
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'menfact': 	
			if(Privilegios($privilegio,'CrearFactura')){
				include ('factura/menfactura.php'); 
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'nfact':
			if(Privilegios($privilegio,'CrearFactura')){
				include ('factura/registrofactura.php'); 
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'confact':
			if(Privilegios($privilegio,'CrearFactura')){
				include ('factura/confirmafactura.php'); 
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'clfact':
			if(Privilegios($privilegio,'CrearFactura')){
				include ('factura/consultafactura.php'); 
			}else{
				include ('accesonegado.php');
			}
			break;
		case 'mapa': 	
			include ('mapasitio.php'); 	
			break;
        case 'manual': 	
			include ('manuales/vermanual.php'); 	
			break;
	}	
}
?>