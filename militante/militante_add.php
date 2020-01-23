<?php
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
	$cedula_militante = $_POST['cedula_militante'];
	$codigo_cargo = $_POST['codigo_cargo'];
	$codigo_centro = $_POST['codigo_centro'];
	$nombre_militante = $_POST['nombre_militante'];
	$apellido_militante = $_POST['apellido_militante'];
	$telefono_militante = $_POST['telefono_militante'];
 
	//aqui es para los logos de la empresa
	$foto_persona = $_POST['cedula_militante'];
	$foto = $foto_persona;
	
	$foto_name = $HTTP_POST_FILES['foto_militante']['name'];
	$tipo_archivo = $HTTP_POST_FILES['foto_militante']['type'];
	$tamano_archivo = $HTTP_POST_FILES['foto_militante']['size']; 

	if (($cedula_militante=="")  || ($nombre_militante==""))
	{
			$error='<div align="left">
							<h3 class="error">
								<font color="red" style="text-decoration:blink;">
									Error: Datos Incompletos,  Intente Nuevamente!
								</font>
							</h3>
						</div>';
	}
		else
		{
			// guardamos el archivo a la carpeta files
			$destino =  "fotos/".$foto;
			if (copy($_FILES['foto_militante']['tmp_name'],$destino)) 
				{
					$status = "Archivo subido: <b>".$foto_name."</b>";
					
					require("conexion/aut_config.inc.php");
					$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");	
		
					$error="bien";	
					
					$inserta_usuario = pg_query("insert into militantes (cedula_militante,codigo_cargo,codigo_centro,nombre_militante,apellido_militante,telefono_militante,foto) values ('$cedula_militante',$codigo_cargo,$codigo_centro,'$nombre_militante','$apellido_militante','$telefono_militante','$foto')") or die('La consulta fall&oacute;: ' . pg_last_error());	
					$result_insert=pg_fetch_array($inserta_usuario);	
					pg_free_result($inserta_usuario);
					$resultado_insert=$result_insert[0];
					pg_close();	
				} 
				else 
				{
					$error = '<div align="left">
								<h3 class="error">
									<font color="red" style="text-decoration:blink;">
										Error: El Archivo no Pudo Ser Copiado!
									</font>
								</h3>
							</div>';
				}    
		}     
}//fin del add   
?>
<div align="center" class="centermain">
	<div class="main">  
		<table class="admin_militante">
			<tr>
				<th>
					Contactos:
					<small>
						Nuevo
					</small>
				</th>
			</tr>
		</table>
        
		<table class="adminform" border="0">
			<tr bgcolor="#55baf3">
				<th colspan="2">
					NUEVO REGISTRO A ALMACENAR
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
							echo 'El Registro fue procesado con &eacute;xito';	
							break;
						case 1: 
							echo 'No se pudo procesar el registro porque ya est&aacute; registrado en el sistema ';
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
									<a href="index2.php?type=militante_add">
										<img src="images/militante.png" alt="salir" align="middle"  border="0" />
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
 		<form id="personal_add" name="personal_add" method="POST" action="<?php echo $pagina?>" enctype="multipart/form-data">
			<tr>
				<td>
		 			<table class="borded" border="0" cellpadding="0" cellspacing="1" width="100%">
					<tbody>						
						<tr width="15%">
							<td>
								Cedula de Identidad:
							</td>
							
							<td width="85%">
								<input class="inputbox" type="text" id="cedula_militante" name="cedula_militante" maxlength="15" size="15"/>
								<font color="#ff0000">*</font>
								<script type="text/javascript">
			         			var codigo = new LiveValidation('cedula_militante');
			         			codigo.add(Validate.Presence);
			            		codigo.add( Validate.Numericality);
			         		</script>
							</td>			
						</tr>
						
						<tr>
							<td width="12%">
								Nombres:
							</td>
							
							<td>
								<input class="inputbox" type="text" id="nombre_militante" name="nombre_militante" maxlength="40" size="40"/>
								<script type="text/javascript">
			         			var codigo = new LiveValidation('nombre_militante');
			            		codigo.add(Validate.Presence);
			            		codigo.add( Validate.texto );
			         		</script>
			         		<font color="#ff0000">*</font>		
							</td>			
						</tr>
						
						<tr>
							<td width="12%">
								Apellidos:
							</td>
							
							<td>
								<input class="inputbox" type="text" id="apellido_militante" name="apellido_militante" maxlength="40" size="40"/>
								<script type="text/javascript">
			         			var codigo = new LiveValidation('apellido_militante');
			            		codigo.add(Validate.Presence);
			            		codigo.add( Validate.texto );
			         		</script>	
			         		<font color="#ff0000">*</font>			
							</td>			
						</tr>
						
						<tr width="15%">
							<td>
								Telefono Movil:
							</td>
							
							<td width="85%">
								<input class="inputbox" type="text" id="telefono_militante" name="telefono_militante" maxlength="11" size="15"/>
								<font color="#ff0000">*</font>
								<script type="text/javascript">
			         			var codigo = new LiveValidation('telefono_militante');
			         			codigo.add(Validate.Presence);
			            		codigo.add( Validate.Numericality);
			         		</script>
							</td>			
						</tr>
						
						<tr>
							<td width="12%">
								Cargo:
							</td>
							
							<td>
								<select id="codigo_cargo" name="codigo_cargo">
									<option value="">---</option>
									<?php 
						  				$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
										$consulta=pg_query("SELECT * FROM cargo order by cargo.nombre_cargo");
										while ($array_consulta=pg_fetch_array($consulta))
										{
											echo '<option value="'.$array_consulta[0].'">'.$array_consulta[1].'</option>';
										}
										pg_free_result($consulta);
									?>
								</select>
								<script type="text/javascript">
			         			var codigo = new LiveValidation('codigo_parroquia');
			            		codigo.add(Validate.Presence);
			            		codigo.add( Validate.texto );
			         		</script>	
			         		<font color="#ff0000">*</font>			
							</td>			
						</tr>
						
						<tr>
							<td width="12%">
								Centro de Votaci&oacute;n:
							</td>
							
							<td>
								<select id="codigo_centro" name="codigo_centro">
									<option value="">---</option>
									<?php 
						  				$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
										$consulta=pg_query("SELECT * FROM centro_votacion order by centro_votacion.nombre_centro");
										while ($array_consulta=pg_fetch_array($consulta))
										{
											echo '<option value="'.$array_consulta[0].'">'.$array_consulta[2].'</option>';
										}
										pg_free_result($consulta);
									?>
								</select>		
							</td>			
						</tr>
													
						<tr>
							<td>
								Fotos del Militante:
							</td>
							
							<td>
								<input type="file" id="foto_militante" name="foto_militante" maxlength="30" size="30" class="inputbox">
								<font size="1" color="#ff0000">(.jpg, m&aacute;ximo 50Kb)*</font>				
							</td>			
						</tr>
					</tbody>
					</table>				
				</td>
			</tr>	
								
			<tr>
				<td bgcolor="#55baf3" colspan="2" align="center">
					<input type="submit" class="button" name="save" value="  Guardar  " >
					<input class="button" type="reset" value="Limpiar" name="Refresh"> 
					<input  class="button" type="button" onClick="history.back()" value="Regresar">
				</td>
			</tr>
		</form>
			<?php 
			}
			?> 
	</div>
</div>