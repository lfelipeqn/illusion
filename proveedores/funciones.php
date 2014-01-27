<?
function Mensaje($asunto, $mensaje, $para){
    include '../Connections/cnn.php';
    $conecta=mysql_select_db($database_cnn,$cnn);
       
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $cabeceras .= 'From: administrador@eslcolombia.com.co'. "\r\n";  
    $cabeceras .= 'Bcc: lfelipeqn@gmail.com'. "\r\n";
        
    
    mail($rsalerta['Correo'],$asunto,$mensaje,$cabeceras);
        
}
?>