<?php //seccion de mensajes del sistema.
	$redir=$_SERVER['HTTP_REFERER']; // Ruta para redireccionar a la pagina que nos llamo
	$pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
	$type=$_GET["type"];
	$pagina=$pag.'?type='.$type;

//Conexion a la base de datos
$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_empresa password=$sql_pass");
?>

<?php //seccion para recibir los datos y modificarlos.
if (isset($_GET['codigo_cargo'])){
	$datos_modificar= $_GET['codigo_cargo'];

	//se le hace el llamado al archivo de conexion y luego se realiza el enlace.	
	require("conexion/aut_config.inc.php");
	$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");	

	//se le hace el llamado a la funcion de insertar.	
	$datos_consulta = pg_query("SELECT * FROM cargo where codigo_cargo = $datos_modificar") or die("No se pudo realizar la consulta a la Base de datos");

	$resultados1=pg_fetch_array($datos_consulta);
	pg_free_result($datos_consulta);
	pg_close();
}
?> 

<?php 
if (isset($_POST[save]))
{//se resive los datos a ser modificados
	$codigo_cargo = $_POST['codigo_cargo'];
	$nombre_cargo = $_POST['nombre_cargo'];

		$error="bien";	
		//se le hace el llamado al archivo de conexion y luego se realiza el enlace.	
		require("conexion/aut_config.inc.php");
		$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");	

		//se le hace el llamado a la funcion de insertar.	
		$inserta_registro = pg_query("SELECT update_cargo($codigo_cargo,'$nombre_cargo')") or die('La consulta fall&oacute;: ' . pg_last_error());
		$result_insert=pg_fetch_array($inserta_registro);	
		$resultado_insert=$result_insert[0];

		pg_free_result($inserta_registro);
		//header ("Location: $pagina");
		pg_close();	//exit;	   
}//fin del procedimiento modificar.
?>

<div align="center" class="centermain">
	<div class="main">  
		<table class="admin_cargo">
			<tr>
				<th>
						Categor&iacute;a:
					<small>
						ACTUALIZACI&Oacute;N DE DATOS
					</small>
				</th>
			</tr>
		</table>
        
		<table class="adminform" border="0">
			<tr bgcolor="#55baf3">
				<th colspan="3">
					MODIFICAR DATOS DEL CATEGOR&Iacute;A
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
									<a href="index2.php?type=cargo">
										<img src="images/cargos.png" alt="salir" align="middle"  border="0" />
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
			<tr>
				<td width="15%">
					C&oacute;digo del Categor&iacute;a:				
				</td>
				
				<td width="85%">
					<input class="inputbox" type="text" id="codigo_cargo" name="codigo_cargo" readonly="true" value="<?php echo $resultados1[codigo_cargo]; ?>" maxlength="12" size="12"/>
					<font color="#ff0000">*</font>
					<script type="text/javascript">
         			var codigo = new LiveValidation('codigo_cargo');
            		codigo.add(Validate.Presence);
         		</script>				
         	</td>               
			</tr>
			
			<tr>
				<td>
					Categor&iacute;a:
				</td>
				
				<td>
					<input type="text" id="nombre_cargo" name="nombre_cargo" value="<?php echo $resultados1[nombre_cargo]; ?>" maxlength="45" size="45"/>
					<font color="#ff0000">*</font>
					<script type="text/javascript">
         			var codigo = new LiveValidation('nombre_cargo');
            		codigo.add(Validate.Presence);
         		</script>
				</td>						
			</tr>
						
			<tr bgcolor="#55baf3">
				<td colspan="3" align="center">
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