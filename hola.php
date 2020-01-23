<?php 
if ($nivel_acceso <= $_SESSION['usuario_nivel'])
{
	header ("Location: $redir?error_login=5");
	exit;
}
	include ('menu/valida_menu.php')
?>

