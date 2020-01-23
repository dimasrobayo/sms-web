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
	$datos_consulta = pg_query("SELECT * FROM cargo, militantes where cargo.codigo_cargo = militantes.codigo_cargo order by militantes.cedula_militante") or die("No se pudo realizar la consulta a la Base de datos");
?>

<div align="center" class="centermain">
	<div>  
		<div align="center">
			<font color="red" style="text-decoration:blink;">
				<?php $error_accion_ms[$error_cod]?>
			</font>
		</div>

		<table class="admin_militante">
			<tr>
				<th>
					Contactos:
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
				<th align="center" width="8%">
					Foto
				</th>
				
				<th align="center" width="10%">
					C&eacute;dula
				</th>

				<th width="34%" align="center">
					Nombre y Apellido
				</th>
				
				<th width="10%" align="center">
					Categor&iacute;a
				</th>
				
				<th width="10%" align="center">
					Tel&eacute;fono
				</th>

				<th width="12%" align="center">
					Acciones
				</th>
			</tr>
		</thead>

<?php
$xxx=0;
while($resultados = pg_fetch_array($datos_consulta))
{
	$xxx=$xxx+1;
?>

			<tr class="row0">
				<td align="center">
					<ul class="gallery clearfix">
						<a href="fotos/<?php echo $resultados[cedula_militante]; ?>" rel="prettyPhoto" title="<?php echo $resultados[nombre_militante]; echo " "; echo $resultados[apellido_militante];?>">
							<img width="22" height="26" src="fotos/<?php echo $resultados[foto]; ?>" / ><?php ?>
						</a>
					</ul>
				</td>
			
				<td align="center">
					<a href="index2.php?type=militante_update&cedula_militante=<?php echo $resultados[cedula_militante];?>" title="Pulse para Modificar los datos personales">
						<?php echo $resultados[cedula_militante];?>
					</a> 
				</td>

				<td>
					<?php echo $resultados[nombre_militante]; echo " "; echo $resultados[apellido_militante];?>
				</td>
				
				<td align="center">
					<?php echo $resultados[nombre_cargo];?>
				</td>
				
				<td  align="center">
					<?php echo $resultados[telefono_militante];?>
				</td>

				<td align="center"> 
					<a onclick="return confirm('Esta seguro que desea eliminar el registro?');" href="index2.php?type=militante_drop&cedula_militante=<?php echo $resultados[cedula_militante];?>" title="Pulse para eliminar el registro">
						Borrar
					</a>
					
					<a  href="index2.php?type=militante_sms&cedula_militante=<?php echo $resultados[cedula_militante];?>" title="Pulse para Enviar un SMS">
						SMS
					</a>
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
									<a href="fpdf/imprimir_militante.php" target="_blank">
										<img src="images/printer.png" alt="agregar" align="middle"  border="0" />
										<span>Imprimir</span>
									</a>
								</div>
							</div>
							
							<div style="float:right;">
								<div class="icon">
									<a href="index2.php?type=militante_add">
										<img src="images/nuevo.png" alt="agregar" align="middle"  border="0" />
										<span>Agregar</span>
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