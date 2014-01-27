<?php
	session_start();
	include '../funciones.php';
	include 'funciones_rental.php';
    include '../classes/fpdf.php';
	date_default_timezone_set("America/Bogota");
	if(!isset($_GET['location'])){
		$location='rental';
	}else{
		$location=$_GET['location'];	
	}
	
	$privilegio=$_SESSION['perfil'];
if($privilegio!=''){
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <link href="styles/style.css" rel="stylesheet" type="text/css" />
        <link href="styles/tablas.css" rel="stylesheet" type="text/css" />
        <link href="styles/calendario.css" rel="stylesheet" type="text/css" />
        <link href="styles/fpdf.css" rel="stylesheet" type="text/css" />
        
        <link href="js/jquery-ui/css/custom-theme/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css" />
        <script src="js/jquery-ui/js/jquery-ui-1.9.1.custom.js" type="text/javascript" ></script>
        
        <script type="text/javascript" src="js/tigra_calendar/1-simple-calendar/tcal.js"></script>
        <link type="text/css" href="js/tigra_calendar/1-simple-calendar/tcal.css" rel="stylesheet"/>
        
        <script type="text/javascript" src="js/jquery-validation/js/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="js/jquery-validation/js/languages/jquery.validationEngine-es.js"></script>
        <link type="text/css" href="js/jquery-validation/css/validationEngine.jquery.css" rel="stylesheet"/>
        
        <script src="js/paginar.js" type="text/javascript" ></script>
        <script src="js/calendario.js" type="text/javascript"></script>
        <script src="js/funciones.js" type="text/javascript"></script>
        <script src="js/control.js" type="text/javascript"></script>
        
            
        <title>RENTAL ESL</title>
    </head>
    <body>
        <div align="center">
        <table>
            <tr>
                <td>
                <?
                    include ('header.php');
                ?>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <br />
                    <div align="center">
                    <?
                        changelocation($location, $privilegio);
                    ?>
                    </div></td>
            </tr>
        </table>
        </div>
    </body>
</html>
<?
}

function changelocation($location, $privilegio) {
	switch ($location) {
		case 'rental':
			include ('actualindex.php'); 	
			break;
/*-------------  MANUAL DEL USUARIO  -----------------*/
        case 'manual':
            include('manuales/vermanual.php');
            break;
/*-------------  ADMINISTRACION DE CLIENTES  -----------------*/
		case 'ncclie':
            if(Privilegios($privilegio,'CrearClientes')){
				include ('clientes/nuevocliente.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'confcliente':
            if(Privilegios($privilegio,'CrearClientes')){
	           include ('clientes/confcliente.php');
            }else{
				include ('../accesonegado.php');
			}   
			break;
		case 'clclie':
            if(Privilegios($privilegio,'ConsultarClientes')){
				include ('clientes/cltcliente.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'clieedit':
            if(Privilegios($privilegio,'ActualizarClientes')){
				include ('clientes/edtcliente.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'confactcliente':
            if(Privilegios($privilegio,'ActualizarClientes')){
				include ('clientes/confactcliente.php');
			}else{
				include ('../accesonegado.php');
			}
			break;

/*------------- ADMINISTRACION DE INVENTARIO -----------------*/
		case 'nequip':
            include ('inventario/nuevoequipo.php');
			break;
        case 'confnequip':
            include ('inventario/confirmanuevo.php');
			break;
        case 'invt':
			include ('inventario/consultainventario.php');
			break;
		case 'elm':
			include('inventario/elemento.php');
			break;
		case 'invedit':
			include('inventario/editaelm.php');
			break;
		case 'invelim':
			include('inventario/eliminaelm.php');
			break;
		case 'confirmaact':
			include('inventario/confelm.php');
			break;
        case 'salmant':
			include ('inventario/regmantenimiento.php');
			break;
		case 'entmant':
			include ('inventario/finmantenimiento.php');
			break;
		case 'confmant':
			include ('inventario/confmantenimiento.php');
			break;
		case 'conftmant':
			include ('inventario/conftmantenimiento.php');
			break;
/*------------- ADMINISTRACION DE PROYECTOS  -------------------*/
        case 'nproy':
            include ('proyectos/nuevoproyecto.php');
			break;
        case 'bproy':
            include ('proyectos/buscaproyecto.php');
			break;
        case 'cproy':
            include ('proyectos/clproyectos.php');
			break;
        case 'edpr':
            include ('proyectos/editaproyecto.php');
			break;
        case 'confirmact':
            include ('proyectos/confirmaact.php');
			break;
        case 'confirmaproy':
            include ('proyectos/confirmanuevo.php');
			break;
            
/*------------- ADMINISTRACION DE COTIZACIONES -----------------*/
		case 'cotiz':
            if(Privilegios($privilegio,'CrearPresupuesto')){
				include ('cotizaciones/ncotizacion.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'buscotiz':
            if(Privilegios($privilegio,'ConsultarPresupuesto')){
				include ('cotizaciones/buscarcotizacion.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'cltcotiz':
            if(Privilegios($privilegio,'ConsultarPresupuesto')){
				include ('cotizaciones/cltcotizacion.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'confcot':
            if(Privilegios($privilegio,'CrearPresupuesto')){
				include ('cotizaciones/confcot.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'verct':
            if(Privilegios($privilegio,'VerPresupuesto')){
				include ('cotizaciones/vercotizacion.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'delct':
            if(Privilegios($privilegio,'EliminarPresupuesto')){
				include ('cotizaciones/eliminacotizacion.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'aprct':
            if(Privilegios($privilegio,'AprobarPresupuesto')){
				include ('cotizaciones/aprobarcotizacion.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'edct':
            if(Privilegios($privilegio,'ActualizarPresupuesto')){
				include ('cotizaciones/editacotizacion.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'confdesc':
            if(Privilegios($privilegio,'CrearPresupuesto')){
				include ('cotizaciones/confirmadescuento.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'addconc':
            if(Privilegios($privilegio,'CrearPresupuesto')){
				include ('cotizaciones/nuevoconcepto.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'confconc':
            if(Privilegios($privilegio,'CrearPresupuesto')){
				include ('cotizaciones/confirmaconcepto.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
/*------------- ADMINISTRACION DE EVENTOS -----------------*/
		case 'als':
            if(Privilegios($privilegio,'CrearProyecto')){
				include('eventos/evento.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'confirmaevn':
            if(Privilegios($privilegio,'CrearProyecto')){
				include('eventos/registroevt.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'busevento':
            if(Privilegios($privilegio,'ConsultarProyecto')){
				include ('eventos/buscarevento.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'delevt':
            if(Privilegios($privilegio,'EliminarProduccion')){
				include ('eventos/eliminaevento.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'clevt':
            if(Privilegios($privilegio,'ConsultarProyecto')){
				include('eventos/clteventos.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'detevent':
            if(Privilegios($privilegio,'CrearProyecto')){
				include('eventos/detallevento.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'goevent':
            if(Privilegios($privilegio,'CrearProyecto')){
				include('eventos/saleevento.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'confsalida':
            if(Privilegios($privilegio,'CrearProyecto')){
				include('eventos/confsalidaevt.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'entequipo':
            if(Privilegios($privilegio,'CrearProyecto')){
				include('eventos/entradaequipo.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'confentrada':
            if(Privilegios($privilegio,'CrearProyecto')){
				include('eventos/confentradaevt.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'novalida':
            if(Privilegios($privilegio,'CrearProyecto')){
				include('eventos/faltaequipos.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'muestraevt':
            if(Privilegios($privilegio,'VerProyecto')){
				include('eventos/verevento.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'finevent':
            if(Privilegios($privilegio,'FinalizarProduccion')){
				include('eventos/finevento.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'confinaliza':
            if(Privilegios($privilegio,'FinalizarProduccion')){
				include('eventos/confinaliza.php');
			}else{
				include ('../accesonegado.php');
			}
			break;

/*------------- ADMINISTRACION DE PROVEEDORES --------------*/

		case 'nprov':
            if(Privilegios($privilegio,'CrearProveedor')){
				include('proveedores/nuevoproveedor.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'cltprov':
            if(Privilegios($privilegio,'ConsultarProveedor')){
				include('proveedores/buscaproveedor.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'confirmaprov':
            if(Privilegios($privilegio,'CrearProveedor')){
				include('proveedores/confirmanuevo.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'listprov':
            if(Privilegios($privilegio,'ConsultarProveedor')){
				include('proveedores/cltproveedor.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'verprov':
            if(Privilegios($privilegio,'VerProveedor')){
				include('proveedores/verproveedor.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'editprov':
            if(Privilegios($privilegio,'ActualizarProveedor')){
				include('proveedores/actproveedor.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'borrarprov':
            if(Privilegios($privilegio,'EliminarProveedor')){
				include('proveedores/eliminaproveedor.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'confactprov':
            if(Privilegios($privilegio,'ActualizarProveedor')){
				include('proveedores/confactproveedor.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'costprov':
            if(Privilegios($privilegio,'CrearProveedor')){
				include('proveedores/costosproveedores.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'confvalprov':
            if(Privilegios($privilegio,'CrearProveedor')){
				include('proveedores/confirmavalores.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
/*------------- ORDENES DE COMPRA --------------*/		
		case 'ordcomp':
            if(Privilegios($privilegio,'CrearOrdenCompra')){
				include('eventos/cltordenes.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
		case 'detorden':
            if(Privilegios($privilegio,'CrearOrdenCompra')){
				include('eventos/ordencompra.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
/*------------- ADMINISTRACION DE FACTURAS --------------*/
        case 'genfact':
            if(Privilegios($privilegio,'CrearFactura')){
				include('facturas/facturas.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'factcreada':
            if(Privilegios($privilegio,'CrearFactura')){
				include('facturas/confirmafactura.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'cltfact':
            if(Privilegios($privilegio,'CrearFactura')){
				include('facturas/consultafactura.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'verfact':
            if(Privilegios($privilegio,'CrearFactura')){
				include('facturas/creafactura.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
        case 'muestrafac':
            if(Privilegios($privilegio,'CrearFactura')){
				include('facturas/verfactura.php');
			}else{
				include ('../accesonegado.php');
			}
			break;
	}	
}
?>