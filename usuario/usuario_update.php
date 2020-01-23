<?php //seccion de mensajes del sistema.
	$redir=$_SERVER['HTTP_REFERER']; // Ruta para redireccionar a la pagina que nos llamo
	$pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
	$type=$_GET["type"];
	$pagina=$pag.'?type='.$type;

//Conexion a la base de datos
$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_empresa password=$sql_pass");
?>

<?php //seccion para recibir los datos y modificarlos.
if (isset($_GET['cedula'])){
	$datos_modificar= $_GET['cedula'];

	//se le hace el llamado al archivo de conexion y luego se realiza el enlace.	
	require("conexion/aut_config.inc.php");
	$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");	

	//se le hace el llamado a la funcion de insertar.	
	$datos_consulta = pg_query("SELECT * FROM usuarios where cedula = $datos_modificar") or die("No se pudo realizar la consulta a la Base de datos");

	$resultados1=pg_fetch_array($datos_consulta);
	pg_free_result($datos_consulta);
	pg_close();
}
?> 

<?php 
if (isset($_POST[save]))
{
	$cedula = $_POST['cedula'];
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$usuario = $_POST['usuario'];
	$pass = $_POST['password'];
	$nivel = $_POST['nivel_acceso'];
	$status = $_POST['status'];
	$fecha = $_POST['fecha_registro'];
	$hora = $_POST['hora_registro'];
 
		$error="bien";	
		//se le hace el llamado al archivo de conexion y luego se realiza el enlace.	
		require("conexion/aut_config.inc.php");
		$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");	


		$passmd5=md5($pass);
		//se le hace el llamado a la funcion de insertar.	
		$inserta_registro = pg_query("SELECT update_usuario($cedula,'$nombre','$apellido','$usuario','$passmd5',$nivel, $status,'$fecha','$hora')") or die('La consulta fall&oacute;: ' . pg_last_error());	
		$result_insert=pg_fetch_array($inserta_registro);	
		$resultado_insert=$result_insert[0];

		pg_free_result($inserta_registro);
		//header ("Location: $pagina");
		pg_close();	//exit;	   
}//fin del procedimiento modificar.
?>

<div align="center" class="centermain">
	<div class="main">  
		<table class="admin_usuarios">
			<tr>
				<th>
						REGISTRO DE USUARIO:
					<small>
						CAMBIO DE CLAVE
					</small>
				</th>
			</tr>
		</table>
        
		<table class="adminform" border="0">
			<tr bgcolor="#55baf3">
				<th colspan="2">
					MODIFICAR DATOS DEL USUARIO
				</th>
			</tr>

			<?php 
			if ((isset($_POST[save])) and ($error=="bien"))
			{		
			?> 
			
			<tr>
				<td colspan="2" align="center">                        	
					<br />
					<strong>RESULTADO</strong>: 
					<?php 
					switch($resultado_insert)
					{
						case 0: 
							echo 'ESTE REGISTRO NO SE PUDO MODIFICAR.';
							break;
						case 1: 
							echo 'ESTE REGISTRO FUE MODIFICADO CON &Eacute;XITO.';	
							break;	
					}				
					echo '<br />'.$msg;
					?>
					<br />	
				</td>
			</tr> 
			
			<table class="adminform" align="center">
				<tr align="center">
					<td width="100%" valign="top" align="center">
						<div id="cpanel">
							<div style="float:right;">
								<div class="icon">
									<a href="index2.php?type=usuarios">
										<img src="images/usuarios.png" alt="salir" align="middle"  border="0" />
										<span>Gestor de Datos</span>
									</a>
								</div>
							</div>	
						</div>
					</td>
				</tr>
			</table>
		
			<?php 
			}
			else
			{
			?> 

 			<form method="POST" action="<?php echo $pagina?>" enctype="multipart/form-data">
			<input type="hidden" name="fecha_registro" value="<?php echo $resultados1[fecha_registro]; ?>"/>
			<input type="hidden" name="hora_registro" value="<?php echo $resultados1[hora_registro]; ?>"/>
			<input type="hidden" name="nivel_acceso" value="<?php echo $resultados1[nivel_acceso]; ?>"/>
			<input type="hidden" name="status" value="<?php echo $resultados1[status]; ?>"/>
			<input type="hidden" name="password" value="<?php echo $resultados1[password]; ?>"/>
			<tr>
				<td width="15%">
					C&eacute;dula:
				</td>
				
				<td width="85%">
					<input id="cedula" name="cedula" value="<?php echo $resultados1[cedula]; ?>" readonly="true" class="inputbox" type="text"/>
					<script type="text/javascript">
         			var codigo = new LiveValidation('cedula');
            		codigo.add(Validate.Presence);
            		codigo.add( Validate.Numericality );
         		</script>
				</td>                       
			</tr>
			
			<tr>
				<td>
					Nombres:
				</td>
				
				<td>
					<input value="<?php echo $resultados1[nombre_usuario]; ?>" class="inputbox" type="text" id="nombre" name="nombre" value="<?if ($error!="") echo $nombreapellido;?>" maxlength="25" size="25"/>
					<script type="text/javascript">
         			var codigo = new LiveValidation('nombre');
            		codigo.add(Validate.Presence);
            		codigo.add( Validate.texto );
         		</script>				
				</td>			
			</tr>
			
			<tr>
				<td>
					Apellidos:
				</td>
				
				<td>
					<input value="<?php echo $resultados1[apellido_usuario]; ?>" class="inputbox" type="text" id="apellido"  name="apellido" value="<?if ($error!="") echo $nombreapellido;?>" maxlength="25" size="25"/>
					<script type="text/javascript">
         			var codigo = new LiveValidation('apellido');
            		codigo.add(Validate.Presence);
         		</script>
				</td>			
			</tr>
			
			<tr>
				<td>
					Usuarios:
				</td>
				
				<td>
					<input value="<?php echo $resultados1[usuario]; ?>" type="text" id="usuario" name="usuario" value="<?if ($error!="") echo $nombreapellido;?>" maxlength="20" size="20"/>
					<script type="text/javascript">
         			var codigo = new LiveValidation('usuario');
            		codigo.add(Validate.Presence);
         		</script>				
				</td>			
			</tr>
			
			<tr bgcolor="#55baf3">
				<td colspan="2" align="center">
					<input type="submit" class="button" name="save" value="  Guardar  " >
					<input  class="button" type="button" onClick="history.back()" value="Regresar">
				</td>
			</tr>
		</form>			
		</table>
			<?php 
			}
			?> 		
	</div>
</div>
