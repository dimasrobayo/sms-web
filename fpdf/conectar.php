<?php 
require("../conexion/aut_config.inc.php");

/*este es el enlace de conexion a la base de datos*/
$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
?>
