<html>
<head>
	<?php include("conexion/aut_config.inc.php"); ?>
	<title><?php echo $sistema_name; ?>-<?php echo $empresa; ?></title>	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="stylesheet" href="css/template_css.css" />
	
	<script type="text/javascript" language="javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/login.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>	
	
	<link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
	<div id="bar">
			<div id="joomla">
				<a href="http://www.visionhannah.com" target="_blank"><img src="images/logo_head.png" alt="logo_head" border="0"></a>
			</div>
			
			<div id="loginContainer">
				<a href="#" id="loginButton">
					<span>Login</span>
				</a>
			</div>	

			<!-- Login Starts Here -->
			<div id="loginBox">             
				<form id="loginForm" action="index2.php" method="POST" name="loginForm" >
					<fieldset id="body">
						<fieldset>
							<label for="usuario">Usuario:</label>
							<input name="user" type="text" size="16" maxlength="16" />
						</fieldset>
							
						<fieldset>
							<label for="password">Password:</label>
							<input name="pass" type="password" size="16" maxlength="15"/>
						</fieldset>
								
						<input type="submit" id="login" value="Ingresar" />
						<label for="checkbox"><input type="checkbox" id="checkbox" />Recu&eacute;rdame</label>
					</fieldset>
					<span>
						<a href="#">Olvidaste tu Contraseña?</a>
					</span>
				</form>
			</div>
			<!-- Login Ends Here -->	
	</div>

<br>

	<?php 
		// Mostrar error de Autentificaci�n.
		include ("aut_mensaje_error.inc.php");
		if (isset($_GET['error_login']))
		{
			$error=$_GET['error_login'];
			echo '<h3 class="error">Error: '.$error_login_ms[$error].'</h3>';
		}
	?>

	<div id="contenido">

	</div>
	
	<div id="footer">
	<?php
		require_once("foot.php");
	?>
	</div>
</body>
</html>