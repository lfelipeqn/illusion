<?php
	session_start();
	include '../funciones.php';
	$location=$_GET['location']; if (empty($location)) { $location='admin'; }
	$privilegio=$_SESSION['perfil'];
    
    echo'
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
        <script src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js" type="text/javascript"></script>
        <script class="jsbin" src="http://datatables.net/download/build/jquery.dataTables.nightly.js"></script>
        <script src="scripts/menu.js" type="text/javascript"></script>
        <script src="scripts/tablas.js" type="text/javascript"></script>
        <script src="scripts/control.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="styles/menu.css" />
        <link rel="stylesheet" type="text/css" href="styles/tabla.css" />
        <title>Sistema de Administraci&oacute;n y Control ESL</title>
    </head>
    <body>';
    
if($privilegio=='Administrador'){
  echo '<table>
            <tr>
                <td>
                    <div id="menu-container">
                        <ul id="navigationMenu">
                            <li><a href="admin.php?location=usuarios" class="normalMenu">Administrar Usuarios</a></li>
                            <li><a href="admin.php?location=privilegios" class="normalMenu">Administrar Privilegios</a></li>
                            <li><a href="admin.php?location=grupos" class="normalMenu">Administrar Grupos</a></li>
                            <li><a href="admin.php?location=notificaciones" class="normalMenu">Administrar Notificaciones</a></li>
                            <li><a href="admin.php?location=unidades" class="normalMenu">Administrar Unidades</a></li>
                            <li><a href="admin.php?location=manuales" class="normalMenu">Manual del Usuario</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top">';
                    changelocation($location);
                echo'</td>
            </tr>
        </table>
        </body>
</html>';  
}
function changelocation($location) {
    switch ($location) {
		case 'admin':
			include ('actualindex.php'); 	
			break;
        case 'usuarios':
			include ('usuarios.php'); 	
			break;
        case 'privilegios':
			include ('privilegios.php'); 	
			break;
        case 'grupos':
			include ('grupos.php'); 	
			break;
        case 'ngrupo':
            include('creagrupo.php');
            break;
        case 'confgrupo':
            include('confirmagrupo.php');
            break;
        case 'egrupo':
            include('editagrupo.php');
            break;
        case 'confedgrupo':
            include('confedgrupo.php');
            break;
        case 'notificaciones':
			include ('notificaciones.php'); 	
			break;
        case 'confnotif':
			include ('confnotificaciones.php'); 	
			break;
        case 'confpvr':
            include ('confirmaactualizacion.php');
            break;
        case 'nwusr';
            include ('nuevousuario.php');
            break;
        case 'delusr';
            include ('borrausuario.php');
            break;
        case 'confdeluser':
            include ('confeliminausuario.php');
            break;
        case 'confusr':
            include ('confnuevousuario.php');
            break;
        case 'updusr':
            include('actualizausuario.php');
            break;
        case 'confedusr':
            include('confirmaactuser.php');
            break;
        case 'unidades':
            include('unidades.php');
            break;
        case 'manuales':
            include('manuales/vermanual.php');
            break;
    }
}
?>