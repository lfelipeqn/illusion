<?
	session_start();  	
	$location=$_GET['location']; if (empty($location)) { $location='inicio'; }
    if((!isset($_SESSION['usuario']))|| ($location=='registro')){
        $nuevo='1';
    }else{
        $nuevo='0';
    }
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" >
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.0.js" ></script>
        <script type="text/javascript" src="scripts/jquery.validate.js" ></script>        
        <script type="text/javascript" src="scripts/css-dock/js/interface.js"></script>
        <script type="text/javascript" src="scripts/datatables/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="scripts/jquery-ui/js/jquery-ui-1.9.0.custom.js"></script>
        <script type="text/javascript" src="scripts/funciones.js"></script>
        <link type="text/css" href="scripts/jquery-ui/css/custom-theme/jquery-ui-1.9.0.custom.css" rel="stylesheet"/>
        <link type="text/css" href="scripts/datatables/media/css/jquery.dataTables.css" rel="stylesheet"/>
        <link href="scripts/css-dock/style.css" rel="stylesheet" type="text/css" />
        <link href="styles/estilo.css" rel="stylesheet" type="text/css" />
			
		<script type="text/javascript" src="scripts/tigra_calendar/1-simple-calendar/tcal.js"></script>
        <link type="text/css" href="scripts/tigra_calendar/1-simple-calendar/tcal.css" rel="stylesheet"/>        
        
        <title>Portal Proveedores ESL</title>
    </head>
    <body>
    <div class="dock" id="dock">
        <div class="dock-container" style="left: 563px; width: 240px; ">
            <a class="dock-item" href="inicio.php?location=inicio" style="width: 40px; left: 0px; ">
                <img src="scripts/css-dock/images/home.png" alt="home"/>
                <span style="display: none; ">Inicio</span>
            </a>
            <?
            if($nuevo==1){
            ?>
            <a class="dock-item" href="inicio.php?location=registro" style="width: 40px; left: 80px; ">
                <img src="scripts/css-dock/images/new.png" alt="registro"/>
                <span style="display: none; ">Registro</span>
            </a>
            <?
            }
            if($nuevo!=1){
            ?>
            <a class="dock-item" href="inicio.php?location=ordenes" style="width: 40px; left: 80px; ">
                <img src="scripts/css-dock/images/portfolio.png" alt="portfolio"/>
                <span style="display: none; ">Ordenes de Compra</span>
            </a>           
            <a class="dock-item" href="inicio.php?location=inicio" style="width: 40px; left: 40px; ">
                <img src="scripts/css-dock/images/email.png" alt="contact"/>
                <span style="display: none; ">Correo ESL</span>
            </a>
            <a class="dock-item" href="inicio.php?location=actualiza" style="width: 40px; left: 200px; ">
                <img src="scripts/css-dock/images/data.png" alt="Actualiza Datos"/>
                <span style="display: none; ">Actualizacion Datos</span>
            </a>
            <a class="dock-item" href="inicio.php?location=cambiarpass" style="width: 40px; left: 200px; ">
                <img src="scripts/css-dock/images/secure.png" alt="Cambiar Clave"/>
                <span style="display: none; ">Cambio Clave</span>
            </a>
            <?
            }
            ?>
            <a class="dock-item" href="index.php" style="width: 40px; left: 160px; ">
                <img src="scripts/css-dock/images/off.png" alt="Salir"/>
                <span style="display: none; ">Salida</span>
            </a>
        </div>
    </div>
    <br />
    <div align="center" style="margin-top: 50px;">
    <table>
        <tr>
            <td width="100%" valign="top"> <? changelocation($location); ?> </td>
        </tr>
    </table>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#dock').Fisheye({
				maxWidth: 50,
				items: 'a',
				itemsText: 'span',
				container: '.dock-container',
				itemWidth: 40,
				proximity: 90,
				halign : 'center'
            })
        });
    </script>
    </body>
</html>

<?

function changelocation($location) {
	switch ($location) {
		case 'inicio':
			include ('actualindex.php'); 	
			break;
        case 'ordenes':
			include ('ordenes/ordencompra.php'); 	
			break;
        case 'verorden':
			include ('ordenes/verordencompra.php'); 	
			break;
        case 'actualiza':
			include ('informacion/actualizadatos.php'); 	
			break;
        case 'cambiarpass':
            include ('cambio.php'); 	
			break;
        case 'registro':
            include ('registro.php'); 	
			break;
	}	
}

?>