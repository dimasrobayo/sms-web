<?php
	$pag=$_SERVER['PHP_SELF']; 
	$type=$_GET["type"];
	$pagina=$pag.'?type='.$type;

	if (isset($_GET['error']))
	{
		$error_accion_ms[0]= "El Usuario No puede ser Borrado.<br>Si desea borrarlo, primero cree uno nuevo.";
		$error_accion_ms[1]= "Datos incompletos.";
		$error_accion_ms[2]= "Contrase&ntilde;as no coinciden.";
		$error_accion_ms[3]= "El Nivel de Acceso ha de ser num&eacute;rico.";
		$error_accion_ms[4]= "El Usuario ya est&aacute; registrado.";
		$error_accion_ms[5]= "Ya existe un usuario con el n&uacute;mero de c&eacute;dula que usted introdujo.";
		$error_accion_ms[6]= "El n&uacute;mero de c&eacute;dula que usted introdujo no es v&aacute;lido.";
		$error_cod = $_GET['error'];
	}
	
	//Conexion a la base de datos
	$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
	
	//codigo para colocar la hora.
	$hora=date("h").":".date("i")." ".date("a");

if (!isset($_GET['accion']))
{
	$datos_consulta = pg_query("SELECT * FROM sentitems") or die("No se pudo realizar la consulta a la Base de datos");
?>

<div align="center" class="centermain">
	<div>  
		<div align="center">
			<font color="red" style="text-decoration:blink;">
				<?php $error_accion_ms[$error_cod]?>
			</font>
		</div>

		<table class="admin_enviados">
			<tr>
				<th>
					SMS - Enviados:
					<small>
					Gesti&oacute;n
					</small>
				</th>
			</tr>
		</table>

<br>

<!--Estructura de Tabla de Contedinos de la Tabla usuario-->
		<table class="display" id="tabla">
		<thead>
			<tr bgcolor="#55baf3">
				<th align="center" width="20%">
					Enviado a
				</th>
				
				<th align="center" width="20%">
					Fecha
				</th>

				<th width="50%" align="center">
					Mensaje
				</th>
				
				<th width="10%" align="center">
					Status
				</th>
			</tr>
		</thead>

<?php
$xxx=0;
while($resultados = pg_fetch_array($datos_consulta))
{
	$xxx=$xxx+1;
?>

				<td align="center">
					<?php echo $resultados[DestinationNumber];?>
				</td>

				<td>
					<?php echo $resultados[SendingDateTime];?>
				</td>
				
				<td>
					<?php echo $resultados[TextDecoded];?>
				</td>
				
				<td>
					<?php if ($resultados[Status]=="SendingError"){
						echo "Error";
					}
					else {	echo "Enviados";}
					?>
				</td>
			</tr>

<?php
}
?>

			<tfoot>
				<tr align="center">
					<th colspan="9" align="center">
						<div id="cpanel">
							<div style="float:right;">
								<div class="icon">
									<a href="index2.php">
									<img src="images/cpanel.png" alt="salir" align="middle"  border="0" />
									<span>Salir</span>
									</a>
								</div>
							</div>
							
							<div style="float:right;">
								<div class="icon">
									<a href="fpdf/imprimir_enviados.php" target="_blank">
										<img src="images/printer.png" alt="agregar" align="middle"  border="0" />
										<span>Imprimir</span>
									</a>
								</div>
							</div>
						</div>
					</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<?php
pg_free_result($datos_consulta);
pg_close();
}
?>