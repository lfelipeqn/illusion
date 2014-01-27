<?php

function ConvFecha($valfecha){
	return date("d-M-Y",strtotime($valfecha));
}

function NormalFecha($anorfecha){
	return date("d-M-Y",strtotime($anorfecha));
}

function aMySQL($norfecha){
	return date("Y-m-d",strtotime($norfecha));
}

function uPDF($medida, $resolucion=72){
   //// 2.54 cm / pulgada
   return ($medida/(2.54))*$resolucion;
}

	
function aMoneda($numero){
	$total = number_format($numero,2);
	return "$ ".$total;  
}  

function aNumero($num){
	$res=$num;
	$res=str_replace("%","",$res);
	$res=str_replace("$","",$res);
	$res=str_replace(",","",$res);
	return $res;
}


function NCampo($tabla){
	if ($tabla=='eventmark') $a='em';
	if ($tabla=='rentsupp') $a='rs';
	if ($tabla=='videohd3d') $a='vd';
	if ($tabla=='keynote') $a='kn';
	if ($tabla=='visualex') $a='ve';
	if ($tabla=='branding') $a='bi';
	if ($tabla=='performance') $a='pf';
	if ($tabla=='management') $a='mg';
	if ($tabla=='own') $a='os';
	if ($tabla=='produccion') $a='pe';
	if ($tabla=='transport') $a='tt';
	if ($tabla=='imprevistos') $a='im';
	if ($tabla=='personal') $a='pr';
	if ($tabla=='eventocorporativo') $a='ec';
	if ($tabla=='nvatecnologia') $a='nt';
	if ($tabla=='espectaculo') $a='es';
	if ($tabla=='equiposesl') $a='es';
	if ($tabla=='gastosprod') $a='gp';

	return $a;
}

function TresDigitos($numero){
	if (($numero>=0) && ($numero<10)){
		$resultado='00'.$numero;
	}
	if (($numero>=10) && ($numero<100)){
		$resultado='0'.$numero;
	}

	if (($numero>=100) && ($numero<1000)){
		$resultado=$numero;
	}
	return $resultado;
}

function ValidaMes($numero){
	switch ($numero){
		case 1:
			$elmes='Enero';
			break;
		case 2:
			$elmes='Febrero';	
			break;
		case 3:
			$elmes='Marzo';
			break;
		case 4:
			$elmes='Abril';
			break;
		case 5:
			$elmes='Mayo';
			break;
		case 6:
			$elmes='Junio';
			break;
		case 7:
			$elmes='Julio';
			break;
		case 8:
			$elmes='Agosto';
			break;
		case 9:
			$elmes='Septiembre';
			break;
		case 10:
			$elmes='Octubre';
			break;
		case 11:
			$elmes='Noviembre';
			break;
		case 12:
			$elmes='Diciembre';
			break;
	}
	return $elmes;
}



function Navegador() { 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)){ 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)){ 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)){ 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    }
    elseif(preg_match('/Opera/i',$u_agent)){ 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 

    elseif(preg_match('/Netscape/i',$u_agent)){ 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
	
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    $i = count($matches['browser']);
    if ($i != 1) {
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

function Privilegios($perfil, $tipo){
    include 'Connections/cnn.php';
    $conecta=mysql_select_db($database_cnn,$cnn);
    
    $sqlperfil="SELECT perfiles.".$tipo." FROM perfiles WHERE perfiles.Perfil='".$perfil."'";
    $cltperfil=mysql_query($sqlperfil,$cnn) or die(mysql_error());
    $rsperfil=mysql_fetch_assoc($cltperfil);
    
    return $rsperfil[$tipo];    
}

function Alerta($alerta, $asunto, $mensaje, $unidad){
    include 'Connections/cnn.php';
    $conecta=mysql_select_db($database_cnn,$cnn);
    
	 $sqlalerta="SELECT usuarios.Correo, usuarios.".$alerta." FROM usuarios INNER JOIN usuarios_unidades ON usuarios.Usuario = usuarios_unidades.usuario WHERE usuarios.".$alerta."=1 AND usuarios_unidades.IdUnidad =".$unidad;    
    
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $cabeceras .= 'From: administrador@eslcolombia.com.co'. "\r\n";  
    //$cabeceras .= 'Bcc: lfelipeqn@gmail.com';
        
    $cltalerta=mysql_query($sqlalerta,$cnn) or die(mysql_error());
    while($rsalerta=mysql_fetch_assoc($cltalerta)){
        mail($rsalerta['Correo'],$asunto,$mensaje,$cabeceras);
    }
    mysql_free_result($cltalerta);
    mysql_close($cnn);    
}

function Unidad($idunidad){
    include 'Connections/cnn.php';
    $conecta=mysql_select_db($database_cnn,$cnn);
    $sqlimagen="SELECT unidades.IdUnidad, unidades.Unidad, unidades.RutaLogo FROM unidades WHERE unidades.IdUnidad=$idunidad";
    $cltimagen=mysql_query($sqlimagen,$cnn) or die(mysql_error());
    $rsimagen=mysql_fetch_assoc($cltimagen);
    $ruta=$rsimagen['RutaLogo'];
    //mysql_close($cnn);
    return $ruta;
}

?>