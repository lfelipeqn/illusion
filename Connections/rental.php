<?php
	session_start();
	include '../funciones.php';
	$location=$_GET['location']; if (empty($location)) { $location='rental'; }
	$privilegio=$_SESSION['perfil'];
if($privilegio!=''){
		/*<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
			<script src="js/cufon-yui.js" type="text/javascript"></script>
			<script src="js/cufon-replace.js" type="text/javascript"></script>
			<script src="js/Myriad_Pro_300.font.js" type="text/javascript"></script>
			<script src="js/Myriad_Pro_400.font.js" type="text/javascript"></script>
			<script src="js/control.js" type="text/javascript"></script>
			<script src="js/calendario.js" type="text/javascript"></script>
			<script src="js/paginar.js" type="text/javascript" ></script>
			<script src="js/subtotal.js" type="text/javascript"></script>
			<script src="js/funciones.js" type="text/javascript"></script>
			<script src="js/produccion.js" type="text/javascript"></script>
			<script type="text/javascript" src="js/ddaccordion.js"></script>
			<script type="text/javascript" src="js/selaccordion.js"></script>
			<link href="styles/calendario.css" rel="stylesheet" type="text/css" />
			<link href="styles/style.css" rel="stylesheet" type="text/css" />
			<link href="styles/indice.css" rel="stylesheet" type="text/css" />
			<link href="styles/tablas.css" rel="stylesheet" type="text/css" />*/
		echo'
		<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			<link href="styles/style.css" rel="stylesheet" type="text/css" />
			<link href="styles/tablas.css" rel="stylesheet" type="text/css" />
			<script src="../js/paginar.js" type="text/javascript" ></script>
			<title>RENTAL ESL</title>
		</head>
		<body>';
			echo '
			<table>
				<tr>
					<td>'; 
						include ('header.php');
				echo'</td>
				</tr>
				<tr>
					<td valign="top">';
						changelocation($location, $privilegio);
					echo '</td>
				</tr>
			</table>';
		echo '
	</body>
	</html>';
}


function changelocation($location, $privilegio) {
	switch ($location) {
		case 'rental':
			include ('actualindex.php'); 	
			break;
		case 'invt':
			include ('inventario/consultainventario.php');
			break;
	}	
}
?>