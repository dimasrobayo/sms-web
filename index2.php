<?php 
require("conexion/aut_verifica.inc.php");
$nivel_acceso=10; // Nivel de acceso para esta pagina.
// se chequea si el usuario tiene un nivel inferior
// al del nivel de acceso definido para esta pagina.
// Si no es correcto, se manda a la pagina que lo llamo con
// la variable de $error_login definida con el n de error segun el array de
// aut_mensaje_error.inc.php
$type=$_GET["type"];
if ($type)
{
    if($type=="out")
    {
    // le damos un mobre a la sesion (por si quisieramos identificarla)
    session_name($usuarios_sesion);
    // iniciamos sesiones
    session_start();
    // destruimos la session de usuarios.
    session_unset();
    session_destroy();

    }
}

// Error reporting:
error_reporting(E_ALL^E_NOTICE);

// Including the DB connection file:
require 'conexion/aut_config.inc.php';
$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

//filtro para mostrar las notas adhesicas por usuarios
$var_cedula = $_SESSION['cedula'];
$query = pg_query("SELECT * FROM notes, usuarios where notes.cedula_para = usuarios.cedula and notes.cedula_para = $var_cedula ORDER BY notes.id DESC");

$notes = '';
$left='';
$top='';
$zindex='';
	
while($row=pg_fetch_assoc($query))
{
    // The xyz column holds the position and z-index in the form 200x100x10:
    list($left,$top,$zindex) = explode('x',$row['xyz']);

    $notes.= '
    <div class="note '.$row['color'].'" style="left:'.$left.'px;top:'.$top.'px;z-index:'.$zindex.'">
        '.htmlspecialchars($row['text']).'
        <div class="author">'.htmlspecialchars($row['name']).'</div>
        <span class="data">'.$row['id'].'</span>
    </div>';
}
?>

<html>
<head>
    <title><?php echo $sistema_name; ?>-<?php echo $empresa; ?></title>	
    <meta charset="utf8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="images/favicon.png" />

    <link rel="stylesheet" href="css/template_css.css" type="text/css" />
    <link rel="stylesheet" href="css/table_css.css" type="text/css" />
    <link type="text/css" rel="stylesheet" href="js/calendario/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
    <link rel="stylesheet" type="text/css" href="css/notas/styles.css" />
    <link rel="stylesheet" type="text/css" href="css/notas/jquery.fancybox-1.2.6.css" media="screen" />

    <SCRIPT type="text/javascript" src="js/calendario/dhtmlgoodies_calendar.js?random=20060118"></script>
    <script language="JavaScript" src="js/JSCookMenu_mini.js" type="text/javascript"></script>	
    <script src="js/jquery.min.js"></script>
    <script src="js/login.js"></script>
    <script type="text/javascript" SRC="js/ajax.js"></script>
    <script type="text/javascript" SRC="js/lib_javascript.js"></script>
    <script type="text/javascript" SRC="js/livevalidation_standalone.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/notas/query.min.js"></script>
    <script type="text/javascript" src="js/notas/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/notas/jquery.fancybox-1.2.6.pack.js"></script>
    <script type="text/javascript" src="js/notas/script.js"></script>
	
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() 
        {
            $('#tabla').dataTable();
        } );
    </script>
	
    <script type="text/javascript">
    $().ready(function() 
    {	
            // Configuramos la validación de los distintos campos del formulario
            $("#signupForm").validate({
                    // Empezamos por las reglas
                    rules: {
                            firstname: "required", // Para el campo firstname(nombre) pedimos que sea requerido.
                            lastname: "required",  // Lo mismo para el campo lastname.
                            username: { // Cuando hay mas de una regla abriremos llaves, aqui validamos username
                                    required: true, // Tienes que ser requerido
                                    minlength: 2    // Tiene que tener un tamaño mayor o igual a dos caracteres
                            },
                            password: {  // reglas para el campo password
                                    required: true, // Tienes que ser requerido
                                    minlength: 5    // Tiene que tener un tamaño mayor o igual a cinco caracteres
                            },
                            confirm_password: { // reglas para el campo confirm_password
                                    required: true, // Tienes que ser requerido 
                                    minlength: 5,   // Tiene que tener un tamaño mayor o igual a cinco caracteres
                                    equalTo: "#password"  // Tiene que ser igual que el campo password y para ello indicamos su id
                            },
                            email: {  // un nuevo caso es identificar que es un email valido osea que tiene formato de email
                                    required: true, 
                                    email: true  // para ello el metodo email: true comprobara esta validación
                            },
                            age: {  // Otros ejemplos podrian ser valor minimo o valor maximo
                                    required: true,
                                    min: 18,  // determina el valor minimo
                                    max:99    // determina el valor maximo
                            },
                            year: {  // Una cantidad entre un rango
                                    required: true,
                                    range: [1911, 1992]  // Aqui indico que no puede ser menor de 1911 ni mayor de 1992
                            },	
                            agree: "required"  // Este input es de typo checkbox si quiero que sea obligatorio marcarlo le doy el valor required
                    },
                    messages: { // La segunda parte es configurar los mensajes, por lo que tengo que ir indicando para cada campo y cada regla el mensaje que quiero mostrar si no se cumple.
                            firstname: "Por favor, introduzca su Nombre",
                            lastname: "Por favor, introduzca sus Apellidos",
                            username: {
                                    required: "Por favor, introduzca su Nombre de Usuario",
                                    minlength: "El Nombre de usuario debe de tener al menos 2 caracteres"
                            },
                            password: {
                                    required: "Por favor, introduzca su password",
                                    minlength: "Su password debe de tener al menos 5 caracteres"
                            },
                            confirm_password: {
                                    required: "Por favor, introduzca de nuevo su password",
                                    minlength: "Su password debe de tener al menos 5 caracteres",
                                    equalTo: "Las password introducidas no son iguales"
                            },
                            email: "Por favor, introduzca un email valido",
                            age: {
                                    required: "Por favor, introduzca su edad",
                                    min: "La edad no puede ser menor de 18 años",
                                    max: "La edad tiene que ser menor de 99 años"
                            },
                            year: {
                                    required: "Por favor, introduzca su año de nacimiento",
                                    range: "Tiene que poner un año entre 1911 y 1992",

                            },
                            agree: "Por favor acepte nuestra politica"
                    }
            });
    });
    </script>	
	
    <script type="text/javascript" >
        function ventanamilitante() //esta es la funcion para abrir el catalogo de conceptos para facturar.
        { 
            miPopup = window.open("contactado/catalogo_militante.php","miwin","width=1100,height=500,scrollbars=yes");
            miPopup.focus();
        }
        
    </script>
</head>

<body> 
	<?php
	switch ($type)
	{
		case "registrar": echo 'onload="desactivar(); desactivarf(); activartipo(); return false;"';
		break;
		case "insertarfor":echo 'onload="desactivar();"';
		break;
	}
	?>

	<div id="bar">
		<div id="joomla">
			<a href="http://www.visionhannah.com" target="_blank"><img src="images/logo_head.png" alt="logo_head" border="0"></a>
		</div>
		
		<div id="loginContainer"> 
			<?php
				include("tb_top_menu.php");
			?>
		</div>
	</div>
	
	<div id="contenido">
		<?php include ('cont.php')?>
	</div>
</body>
</html>