<?php

if (isset($_GET['error']))
{
	$error_accion_ms[0]= "La Empresa No puede ser Borrada.<br>Si desea borrarlo, primero cree uno nuevo.";
	$error_accion_ms[1]= "Datos incompletos.";
	$error_accion_ms[2]= "Contrase&ntilde;as no coinciden.";
	$error_accion_ms[3]= "El Nivel de Acceso ha de ser num&eacute;rico.";
	$error_accion_ms[4]= "El Usuario ya est&aacute; registrado.";
	$error_accion_ms[5]= "Ya existe un usuario con el n&uacute;mero de c&eacute;dula que usted introdujo.";
	$error_accion_ms[6]= "El n&uacute;mero de c&eacute;dula que usted introdujo no es v&aacute;lido.";
	$error_cod = $_GET['error'];
}

	$redir=$_SERVER['HTTP_REFERER']; // Ruta para redireccionar a la pagina que nos llamo
	$pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
	$type=$_GET["type"];
	$pagina=$pag.'?type='.$type;

//Conexion a la base de datos
$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
?>
	
<?php 
if (isset($_POST[save]))
{
	$cedula = $_POST['cedula'];
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$usuario = $_POST['usuario'];
	$password = $_POST['password'];
	$password1 = $_POST['confirm_password'];
	$nivel_acceso = $_POST['nivel_acceso'];
	$status = $_POST['status'];
	
	//aqui es para las fotos
	echo $nombre_archivo = $HTTP_POST_FILES['foto']['name'];
	$tipo_archivo = $HTTP_POST_FILES['foto']['type'];
	$tamano_archivo = $HTTP_POST_FILES['foto']['size'];  
    
	if (($status=="") || ($nivel_acceso==""))
	{
			$error='<div align="left">
							<h3 class="error">
								<font color="red" style="text-decoration:blink;">
									Error: Datos Incompletos, por favor verifique los datos!
								</font>
							</h3>
						</div>';
	}
		else
		{
			require("conexion/aut_config.inc.php");
			$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");	
			
			$error="bien";	
			$passmd5=md5($password);
			
			$inserta_usuario = pg_query("SELECT insert_usuario($cedula,'$nombre','$apellido','$usuario','$passmd5',$nivel_acceso, $status)") or die('La consulta fall&oacute;: ' . pg_last_error());	
			$result_insert=pg_fetch_array($inserta_usuario);	
			pg_free_result($inserta_usuario);
			$resultado_insert=$result_insert[0];
			//header ("Location: $pagina");
			//$consulta_carpeta = pg_query("SELECT carpeta_fotos from carreras,promociones where carreras.id=promociones.id_carrera AND promociones.id=$promocion");
		
			//$carpeta = pg_fetch_array($consulta_carpeta);
			//$carpeta = "carpeta";		
			//if (move_uploaded_file($HTTP_POST_FILES['foto']['tmp_name'], "images/fotos/$ced.jpg"))
			//{
			//	chmod( "images/fotos/$ced.jpg", 0755 );
			//	pg_free_result($consulta_carpeta);
			//	$msg="";
			//}
			//else 
			//	{
			//		if ($nombre_archivo!="")
			//		$msg="Ocurri&oacute; alg&uacute;n error al subir la foto. Por favor consulte la ayuda.";		  	
			//	}		
			pg_close();	
			//exit;
		}     
}//fin del add        
?>

<div align="center" class="centermain">
	<div class="main">  
		<table class="adminheading">
			<tr>
				<th class="usersadmin">
					Usuarios:
					<small>
						Nuevo
					</small>
				</th>
			</tr>
		</table>
        
		<table class="adminform" border="0">
			<tr bgcolor="#55baf3">
				<th colspan="2">
					Registro de un nuevo usuario
				</th>
			</tr>
			
			<?php 
			if ((isset($_POST[save])) and ($error=="bien"))
			{		
			?> 
			
			<tr>
				<td colspan="2" align="center">                        	
					<br />
					<strong>Resultado</strong>: 
					<?php 
					switch($resultado_insert)
					{
						case 0: 
							echo 'No se pudo registrar el usuario porque ya est&aacute; registrado en el sistema ';
							break;
						case 1: 
							echo 'Se Registro Un Nuevo Usuario del Sistema con &eacute;xito';	
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
			
			<?php echo $error;?>
	
 			<form method="POST" action="<?php echo $pagina?>" enctype="multipart/form-data">
			<tr>
				<td width="15%">
					C&eacute;dula:
				</td>
				
				<td width="85%">
					<input class="inputbox" type="text" id="cedula" name="cedula" maxlength="8" size="12"/>
					<script type="text/javascript">
         			var codigo = new LiveValidation('cedula');
            		codigo.add(Validate.Presence);
            		codigo.add( Validate.Numericality);
         		</script>
				</td>                       
			</tr>
			
			<tr>
				<td>
					Nombres:
				</td>
				
				<td>
					<input class="inputbox" type="text" id="nombre" name="nombre" value="<?if ($error!="") echo $nombreapellido;?>" maxlength="25" size="25"/>
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
					<input class="inputbox" type="text" id="apellido"  name="apellido" value="<?if ($error!="") echo $nombreapellido;?>" maxlength="25" size="25"/>
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
					<input type="text" id="usuario" name="usuario" value="<?if ($error!="") echo $nombreapellido;?>" maxlength="20" size="20"/>
					<script type="text/javascript">
         			var codigo = new LiveValidation('usuario');
            		codigo.add(Validate.Presence);
         		</script>				
				</td>			
			</tr>
			
			<tr>
				<td>
					Password:
				</td>
				
				<td>
					<input class="inputbox" id="password" name="password" type="password" value="<?if ($error!="") echo $nombreapellido;?>" maxlength="10" size="10"/>
					<script type="text/javascript">
         			var codigo = new LiveValidation('password');
            		codigo.add(Validate.Presence);
         		</script>	
				</td>			
			</tr>
			
			<tr>
				<td>
					Confirmar Password:
				</td>
				
				<td>
					<input class="inputbox" type="password" id="password1" name="confirm_password" value="<?if ($error!="") echo $nombreapellido;?>" maxlength="10" size="10"/>
					<script type="text/javascript">
         			var codigo = new LiveValidation('password1');
            		codigo.add(Validate.Presence);
            		codigo.add( Validate.Confirmation,  match: 'password');
         		</script>	
				</td>			
			</tr>

			<tr>
				<td>
					Nivel de Acceso:
				</td>
				
				<td>			
					<select id="nivel_acceso" name="nivel_acceso" size="0" class="options">	        
						<option value="">----</option>
						<option value="1">Consultor</option>
						<option value="0">Administrador</option>
					</select>	
					<script type="text/javascript">
         			var codigo = new LiveValidation('nivel_acceso');
            		codigo.add(Validate.Presence);
         		</script>
				</td>			
			</tr>

			<tr>
				<td>
					Status:
				</td>
				
				<td>			
					<select id="status" name="status" size="0" class="options">
						<option value="">----</option>	
						<option value="0">Bloqueado</option>
						<option value="1">Activo</option>
					</select>
					<script type="text/javascript">
         			var codigo = new LiveValidation('status');
            		codigo.add(Validate.Presence);
         		</script>
				</td>			
			</tr>

		
			<tr>
				<td bgcolor="#55baf3" colspan="2" align="center">
					<input type="submit" class="button" name="save" value="  Guardar  " >
					<input class="button" type="reset" value="Limpiar" name="Refresh"> 
					<input  class="button" type="button" onClick="history.back()" value="Regresar">
				</td>
			</tr>
		</table>
		</form>
			<?php 
			}
			?> 
	</div>
</div>
