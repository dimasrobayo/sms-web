<?php //ENRUTTADOR

if (isset($_GET['error']))
	$redir=$_SERVER['HTTP_REFERER']; // Ruta para redireccionar a la pagina que nos llamo
	$pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
	$type=$_GET["type"];
	$pagina=$pag.'?type='.$type;

//Conexion a la base de datos
$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_empresa password=$sql_pass");
?>

<?php //seccion para recibir los datos y borrar.
if (isset($_GET['cedula_militante'])){
	$datos_borrar= $_GET['cedula_militante'];

	//se le hace el llamado al archivo de conexion y luego se realiza el enlace.	
	require("conexion/aut_config.inc.php");
	$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");	

	$consulta = pg_query("SELECT * FROM militantes") or die(pg_last_error());
	$total_registros = pg_num_rows ($consulta);
	pg_free_result($consulta);
	
	if ($total_registros == 0)
	{
		$error="malo";	
	}
	else 
	{
		$error="bien";	
		unlink("fotos/$datos_borrar");
		//se le hace el llamado a la funcion de insertar.	
		$result_borrar=pg_query("SELECT drop_militante('$datos_borrar')") or die(pg_last_error());
		pg_close();
	}
}
?> 

<div align="center" class="centermain">
	<div class="main">  
		<table class="admin_militante">
			<tr>
				<th>
						MILITANTE:
					<small>
						BORRANDO REGISTRO
					</small>
				</th>
			</tr>
		</table>
        
		<table class="adminform" border="0">
			<tr bgcolor="#55baf3">
				<th colspan="2">
					BORRAR CONTACTOS
				</th>
			</tr>
			
			<tr>
				<td colspan="2" align="center">                        	
					<br />
					<strong>Resultado</strong>: 
					<?php 
					if ($error=="bien")
					{
						echo 'LOS DATOS FUERON ELIMINADOS CON  &Eacute;XITO!';
					}
					else 
					{
						echo 'LOS DATOS NO PUEDEN SER ELIMINADOS!';			
					}			
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
									<a href="index2.php?type=militante">
										<img src="images/militante.png" alt="salir" align="middle"  border="0" />
										<span>Gestor de Datos</span>
									</a>
								</div>
							</div>	
						</div>
					</td>
				</tr>
			</table>	
	</div>
</div>
