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
	$codigo_centro = $_POST['codigo_centro'];
	$codigo_parroquia = $_POST['codigo_parroquia'];
	$nombre_centro = $_POST['nombre_centro'];
	$direccion_centro = $_POST['direccion_centro'];
	$n_eje = $_POST['n_eje'];
    
	if (($nombre_centro=="") || ($codigo_parroquia==""))
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
		
		$inserta_usuario = pg_query("SELECT insert_centro_votacion($codigo_centro,$codigo_parroquia,'$nombre_centro','$direccion_centro','$n_eje')") or die("No se pudo insertar el registro en la Base de datos");
		$result_insert=pg_fetch_array($inserta_usuario);	
		pg_free_result($inserta_usuario);
		$resultado_insert=$result_insert[0];
		pg_close();	
		//exit;
	} 		   
}//fin del add        
?>

<div align="center" class="centermain">
	<div class="main">  
		<table class="admin_centro_votacion">
			<tr>
				<th>
					Centro de Votaci&oacute;n:
					<small>
						Nuevo
					</small>
				</th>
			</tr>
		</table>
        
		<table class="adminform" border="0">
			<tr bgcolor="#55baf3">
				<th colspan="2">
					Registro de un Nuevo Centro
				</th>
			</tr>
			
			<tr>
				<th colspan="2">
					<font color="#ff0000">Los Campos con * son Obligatorios</font>
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
							echo 'No se pudo Procesar el Registro porque ya est&aacute; registrado en el sistema.';
							break;
						case 1: 
							echo 'Registro Procesado con &eacute;xito';	
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
									<a href="index2.php?type=centro_votacion">
										<img src="images/centro_votacion.png" alt="salir" align="middle"  border="0" />
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
					Codigo:
				</td>
				
				<td width="85%">
					<input class="inputbox" type="text" id="codigo_centro" name="codigo_centro" maxlength="12" size="12"/>
					<font color="#ff0000">*</font>
					<script type="text/javascript">
         			var codigo = new LiveValidation('codigo_centro');
            		codigo.add(Validate.Presence);
         		</script>
				</td>                       
			</tr>
			
			<tr>
				<td>
					Nombre del Centro:
				</td>
				
				<td>
					<input class="inputbox" type="text" id="nombre_centro" name="nombre_centro" maxlength="25" size="25"/>
					<font color="#ff0000">*</font>
					<script type="text/javascript">
         			var codigo = new LiveValidation('nombre_centro');
            		codigo.add(Validate.Presence);
         		</script>				
				</td>			
			</tr>
			
			<tr>
				<td>
					Parroquia:
				</td>
				
				<td>
					<select id="codigo_parroquia" name="codigo_parroquia">
						<option value="">---</option>
						<?php 
			  				$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
							$consulta=pg_query("SELECT * FROM parroquia order by parroquia.nombre_parroquia");
							while ($array_consulta=pg_fetch_array($consulta))
							{
								echo '<option value="'.$array_consulta[0].'">'.$array_consulta[1].'</option>';
							}
							pg_free_result($consulta);
						?>
					</select>
					<font color="#ff0000">*</font>
					<script type="text/javascript">
         			var codigo = new LiveValidation('codigo_parroquia');
            		codigo.add(Validate.Presence);
         		</script>
				</td>			
			</tr>
			
			<tr>
				<td>
					N de Eje:
				</td>
				
				<td>
					<input class="inputbox" type="text" id="n_eje" name="n_eje" maxlength="12" size="12"/>
					<font color="#ff0000">*</font>
					<script type="text/javascript">
         			var codigo = new LiveValidation('n_eje');
            		codigo.add(Validate.Presence);
            		codigo.add(Validate.Numericality);
         		</script>	
				</td>			
			</tr>
			
			<tr>
				<td>
					Direcci&oacute;n del Centro:
				</td>
				
				<td>
					<textarea class="inputbox" name="direccion_centro" id="direccion_centro" cols="70" rows="3"></textarea>
					<font color="#ff0000">*</font>
					<script type="text/javascript">
         			var codigo = new LiveValidation('direccion_centro');
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
