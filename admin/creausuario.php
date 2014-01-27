<?php
     include('../Connections/cnn.php');
     $conecta=mysql_select_db($database_cnn,$cnn);
     
     $usuario=$_POST['idusuario'];
     $nombre=$_POST['nusuario'];
     $correo=$_POST['nmail'];
     $clave=md5($_POST['pass']);
     $grupo=$_POST['sgrupo'];
     
     $sqlusuarios="INSERT INTO usuarios (Usuario, Password, Nombre, Correo, IdPerfil) VALUES ('$usuario', '$clave', '$nombre', '$correo', '$grupo')";
     $cltusuario=mysql_query($sqlusuarios,$cnn);
     
     for($i=1;$i<=5;$i++){
        switch($i){
            case 1:
                if (isset($_POST['corporativo'])){
                    $sqlunidad="INSERT INTO usuarios_unidades (usuario, IdUnidad) VALUES ('$usuario', '1')";
                    $cltunidad=mysql_query($sqlunidad,$cnn) or die(mysql_error());
                }
                break;
            case 2:
                if (isset($_POST['digital'])){
                    $sqlunidad="INSERT INTO usuarios_unidades (usuario, IdUnidad) VALUES ('$usuario', '2')";
                    $cltunidad=mysql_query($sqlunidad,$cnn) or die(mysql_error());
                }
                break;
            case 3:
                if (isset($_POST['agora'])){
                    $sqlunidad="INSERT INTO usuarios_unidades (usuario, IdUnidad) VALUES ('$usuario', '3')";
                    $cltunidad=mysql_query($sqlunidad,$cnn) or die(mysql_error());
                }
                break;
            case 4:
                if (isset($_POST['saxo'])){
                    $sqlunidad="INSERT INTO usuarios_unidades (usuario, IdUnidad) VALUES ('$usuario', '4')";
                    $cltunidad=mysql_query($sqlunidad,$cnn) or die(mysql_error());
                }
                break;
            case 5:
                if (isset($_POST['envivo'])){
                    $sqlunidad="INSERT INTO usuarios_unidades (usuario, IdUnidad) VALUES ('$usuario', '5')";
                    $cltunidad=mysql_query($sqlunidad,$cnn) or die(mysql_error());
                }
                break;
        }
     }
     
     if($cltusuario){
        header("Location: admin.php?location=confusr");
     } 
?>