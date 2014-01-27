<?php
 include('../Connections/cnn.php');
 $conecta=mysql_select_db($database_cnn,$cnn);
 $sql="INSERT INTO perfiles (Perfil) VALUES ('".$_POST['nombregrupo']."')";
 $clt=mysql_query($sql,$cnn) or die(mysql_error());
 
 if($clt){
    header("Location: admin.php?location=confgrupo");   
 }

?>