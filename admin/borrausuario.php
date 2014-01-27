<?php
     include('../Connections/cnn.php');
     $conecta=mysql_select_db($database_cnn,$cnn);
     $usuario=$_GET['usuario'];
     $sql="DELETE FROM usuarios WHERE usuarios.usuario='$usuario'";
     $clt=mysql_query($sql,$cnn) or die(mysql_error());
     
     if($clt){
        header("Location: admin.php?location=confdeluser");   
     }

?>