<?php
	include ('../Connections/cnn.php');
	include ('../funciones.php');
	session_start();
if(isset($_SESSION['usuario'])){
	$idprod=$_POST['nhprod'];
	$user=$_POST['nuser'];
	$pass=md5($_POST['pass']);
	$fechae=$_POST['nfechae'];
	$fecham=$_POST['nfecham'];
	$fechad=$_POST['nfechad'];
	$proyecto=$_POST['nproy'];
	$valorpres=$_POST['valpres'];
	$comercial=$_POST['ncom'];
	$productor=$_POST['npro'];
	$connect=mysql_select_db($database_cnn,$cnn);

	if(validar($user,$pass)>=1){
		/*if($_SESSION['perfil']=='Productor'){
			if(strtotime(date("Y-m-d"))<strtotime($fecham)){
				$sqlpr="UPDATE negocios SET PorPR=(SELECT PorPR FROM negocios WHERE negocios.IdProyecto = '".$proyecto."'), ValPR=($valorpres*((SELECT PorPR FROM negocios WHERE negocios.IdProyecto = '".$proyecto."')/100)) WHERE negocios.IdProyecto='".$proyecto."'";
				$cltnego=mysql_query($sqlpr,$cnn) or die(mysql_error());
			}
		}*/
		if(($_SESSION['usuario']==$comercial)||($_SESSION['perfil']=='Administrador')){
			$sql="UPDATE produccion SET ValidaC=1, FechaValidaC='".date("Y-m-d")."', ComercialValida='".$user."' where IdProduccion='".$idprod."'";
			$cltvalida=mysql_query($sql,$cnn) or die(mysql_error());
            
            $mensaje='
            <html>
                <head>
                    <title>Negocio Validado por el Comercial</title>
                </head>
                <body>
                <p>El Presente a fin de confirmar la Validaci&oacute;n del Negocio'.$proyecto.' por parte del comercial: '.$user.'</p>
                <br />
                <br />
                <p>Cordial Saludo,</p>
                <p>Administrador ESL</p>
                <p>Por Favor <b>NO</b> responda este Mensaje</p>
                <img src="http://www.entretenimientosinlimites.co/images/esl.jpg" align="left" width="20%" height="20%">
                </body>
            </html>';

		Alerta('AlertaValidacion','Validaci&oacute;n Negocio '.$proyecto,$mensaje,$_SESSION['unidad']);
                        
		}else{
			header("Location: ../inicio.php?location=invalid");	
		}

		if(($_SESSION['usuario']==$productor)||($_SESSION['perfil']=='Administrador')){
			$sql="UPDATE produccion SET ValidaP=1, FechaValidaP='".date("Y-m-d")."', ProductorValida='".$user."' where IdProduccion='".$idprod."'";
			$cltvalida=mysql_query($sql,$cnn) or die(mysql_error());
            
            $sqlconf="SELECT usuarios.Correo, usuarios.AlertaValidacion FROM usuarios WHERE usuarios.Usuario = '".$user."' OR usuarios.IdPerfil=1";
            
            $mensaje='
            <html>
                <head>
                    <title>Negocio Validado por el Productor</title>
                </head>
                <body>
                <p>El Presente a fin de la Validaci&oacute;n del Negocio'.$proyecto.' por parte del productor: '.$user.'</p>
                <br />
                <br />
                <p>Cordial Saludo,</p>
                <p>Administrador ESL</p>
                <p>Por Favor <b>NO</b> responda este Mensaje</p>
                <img src="http://www.entretenimientosinlimites.co/images/esl.jpg" align="left" width="20%" height="20%">
                </body>
            </html>';

		Alerta('AlertaValidacion','Validaci%oacute;n Negocio '.$proyecto,$mensaje,$_SESSION['unidad']);
            
		}else{
			header("Location: ../inicio.php?location=invalid");	
		}
		header("Location: ../inicio.php?location=valid");
	}
}

function validar($user, $pass){
	include ('../Connections/cnn.php');
	$nconect=mysql_select_db($database_cnn,$cnn);
	$suser="SELECT usuarios.Usuario, usuarios.`Password` FROM usuarios WHERE usuarios.Usuario ='".$user."' AND usuarios.`Password`='".$pass."'";
	$cltuser=mysql_query($suser,$cnn) or die(mysql_error());
	$totalfilas=mysql_num_rows($cltuser);

	return $totalfilas;
}
mysql_close($cnn);

?>