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

<?php //seccion para recibir los datos y modificarlos.
if (isset($_GET['cedula_militante'])){
	$datos_modificar= $_GET['cedula_militante'];

	//se le hace el llamado a la funcion de insertar.	
	$datos_consulta = pg_query("SELECT * FROM militantes where cedula_militante= '$datos_modificar'") or die("No se pudo realizar la consulta a la Base de datos");

	$resultados1=pg_fetch_array($datos_consulta);
	pg_free_result($datos_consulta);
	pg_close();
}
?> 
	
<?php 
if (isset($_POST[save]))
{
	$destino=$_POST['destino'];
	$sms=$_POST['sms'];
	
	require("conexion/aut_config.inc.php");
	$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

if ($sms and $destino)
	{
		$array_cell=explode(',', $destino);
		foreach ($array_cell as $dest)
		{
			str_replace('.','',$dest);
			if ( strlen($dest)==11 and ((stristr($dest, '0414') or stristr($dest, '0424') or stristr($dest, '0426') or stristr($dest, '0416') or stristr($dest, '0412') )))
			{
				$datoom=date('Y').date('m').date('d').date('H').date('i').date('s');
				$creatorId= $_SESSION['usuario_nombre'];
				$send = pg_query("SELECT insert_outbox('$dest','$sms','$creatorId')") or die('La consulta fall&oacute;: ' . pg_last_error());	
				$result_insert=pg_fetch_array($send);	
				pg_free_result($send);
				$resultado_insert=$result_insert[0];
				$error="bien";
				if ($send)
				{
					$out=$out."SMS enviado a $dest<br>";
				}
				else
				{
					$out=$out."Error al enviar SMS a $dest<br>";
				}
			}
			else
			{
				$out='Número Telefónico no Válido';
			}
		}
		unset ($GLOBALS);
		//unset ($_POST['cant']);
		//unset($_POST['cant']);
		$sms="";
		$cel="";
		$dest="";
	}

}//fin del add        
?>

<div align="center" class="centermain">
	<div class="main">  
		<table class="admin_sms_por_enviar">
			<tr>
				<th>
					SMS - Contactos:
					<small>
						Nuevo
					</small>
				</th>
			</tr>
		</table>
        
		<table class="adminform" border="0">
			<tr bgcolor="#55baf3">
				<th colspan="2">
					Envio de SMS
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
									<a href="index2.php?type=por_enviar">
										<img src="images/sms_por_enviar.png" alt="salir" align="middle"  border="0" />
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
			<tr width="15%">
				<td>
					Telefono:
				</td>
				
				<td width="85%">
					<input class="inputbox" type="text" id="destino" name="destino" readonly="true" value="<?php echo $resultados1[telefono_militante]; ?>"/>
					<font color="#ff0000">*</font>
					<script type="text/javascript">
         			var codigo = new LiveValidation('destino');
         			codigo.add(Validate.Presence);
            		codigo.add( Validate.Numericality);
         		</script>
				</td>			
			</tr>

			<tr>
				<td>
					Mensaje:
				</td>
				
				<td width="90%">
					
					<textarea class="inputbox" name="sms" id="sms" cols="70" rows="6" maxlength="160"></textarea>
					<font color="#ff0000">*</font>
					<script type="text/javascript">
         			var codigo = new LiveValidation('sms');
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
