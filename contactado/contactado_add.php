<?php  // el NOMBRE y ruta de esta misma pagina.
	$redir=$_SERVER['HTTP_REFERER']; // Ruta para redireccionar a la pagina que nos llamo
	$pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
	$type=$_GET["type"];
	$pagina=$pag.'?type='.$type;

//Conexion a la base de datos
$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_empresa password=$sql_pass");
?>

	
<?php 
//procesando los datos para procesar el concepto de nomina al empleado
if (isset($_POST[cargar]))
{
	$cedula_responsable = $_POST['cedula_responsable'];
	$cedula_militante= $_POST['cedula_militante'];
	
	$error="bien";	
	//se le hace el llamado al archivo de conexion y luego se realiza el enlace.	
	require("conexion/aut_config.inc.php");
	$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");	

	//se le hace el llamado a la funcion de insertar.	
	$inserta_registro = pg_query("insert into contactado (cedula_responsable,cedula_militante) values ('$cedula_responsable','$cedula_militante')") or die('La consulta fall&oacute;: ' . pg_last_error());		
	$result_insert=pg_fetch_array($inserta_registro);	
	$resultado_insert=$result_insert[0];


	pg_free_result($inserta_registro);
	//header ("Location: $pagina");
	pg_close();
	//exit;
}//fin del procedimiento save.


// consultar datos de estudiante en la inscripción del introductorio y verificar que este aprobado
if($_POST['submit']=='Buscar')

{
	if ((isset($_POST['consultar_cedula']))) 
	{
		$cedula= $_POST['consultar_cedula'];
		$tipo_consulta = pg_query("select * from militantes where militantes.cedula_militante='$_POST[consultar_cedula]'") or die('La consulta fall&oacute;: ' . pg_last_error());	
		$count=pg_num_rows($tipo_consulta);
			if($count==0) 
			{
				$div_menssage='<div align="left"><h3 class="error"><font color="#CC0000">Error: El Militante con la C&eacute;dula de Identidad Nº: <font color="blue">'.$_POST['consultar_cedula'].'</font>, No se Encuestra Registrado en Nuestro Sistema como Personal de la Empresa; <br> Por Favor Verifique los Datos en el Modulo <font color="blue">"PERSONAL"<font color="blue">!</font></h3></div>';
			}
			else
		 	{
				unset($div_menssage);
				$resultados = pg_fetch_array($tipo_consulta);
			}				
	}		
}
?>

<div align="center" class="centermain">
	<?php echo $div_menssage; ?>
	<div class="main">
		<table class="admin_contactado">
			<tr>
				<th>
						Grupos:
						<small>
						NUEVO
						</small>
				</th>
			</tr>
		</table>
        
		<table class="adminform" border="0">
			<tr bgcolor="#55baf3">
				<th colspan="2">
					REGISTRO DE 1 x 10
				</th>
			</tr>
			
			<tr>
				<td class="rowformleft" colSpan="4" width="100%"  height="16">
					<span class="font_form_est_prof_small">Los campos con <font color="Red">(*)</font> son obligatorios</span>
				</td>
			</tr>
		
			<?php 
			if ((isset($_POST[cargar])) and ($error=="bien"))
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
							echo 'SE ALMACENO UN NUEVO REGISTRO CON &Eacute;XITO!';	
							break;
						case 1: 
							echo 'NO SE PUEDE PROCESAR EL REGISTRO PORQUE YA EST&Aacute; ALMACENADO EN EL SISTEMA';
							break;
					}				
					echo '<br />'.$msg;
					?>
					<br /><br />		
				</td>
			</tr> 
			
			<table class="adminform" align="center">
				<tr align="center">
					<td width="100%" valign="top" align="center">
						<div id="cpanel">
							<div style="float:right;">
								<div class="icon">
									<a href="index2.php?type=contactado">
										<img src="images/contactado.png" alt="salir" align="middle"  border="0" />
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
			
			<form id="responsable_buscar" name="responsable_buscar" method="POST" action="<?php echo $pagina?>" enctype="multipart/form-data">
			<tr>
				<td>
					CEDULA DE IDENTIDAD:
				</td>					
				<td width="85%">					
					<input class="inputbox" type="text" id="consultar_cedula" name="consultar_cedula" value="<?php echo $resultados[cedula_alumno];?>" maxlength="8" size="12" />
					<script type="text/javascript">
         			var codigo = new LiveValidation('consultar_cedula');
            		codigo.add(Validate.Presence);
            		codigo.add(Validate.Numericality);
         		</script>
					<input class="button" type="submit" name="submit" value="Buscar">					
				</td>
				
			</tr>						
			</form>	
				
			<?php
				if(($count!=0) and ($cedula !=0))
				{ 
			?>		
			
			<tr>
				<td>
					CEDULA DEL RESPONSABLE:
				</td>
		
				<td>
					<?php echo $resultados[cedula_militante];?>				
				</td>
			</tr>
			
			<tr>
				<td>
					NOMBRE Y APELLIDO:
				</td>
		
				<td>
					<?php echo $resultados[nombre_militante]; echo " "; echo $resultados[apellido_militante];?>				
				</td>
			</tr>
			
			<tr>
				<th class="rowformleft" colSpan="4" width="100%"  height="16">
					<hr size="1" width="100%" color="black" noshade>									
					CONTACTADOS DEL 1 X 10</span>
					<hr size="1" width="100%" color="black" noshade>				
				</th>
			</tr>

 			<form id="frm_contactado" name="frm_contactado" method="POST" action="<?php echo $pagina?>" enctype="multipart/form-data">  				
				<input type="hidden" id="cedula_responsable" name="cedula_responsable" value="<?php echo $resultados[cedula_militante]?>">	
				<tr id="periodo">
					<td>
						Datos del Contactado:
					</td>
					
					<td>
						<input class="inputbox" type="text" id="cedula_militante" name="cedula_militante" readonly="true" maxlength="15" size="15"/>
						<img src="images/ver.png" width="16" height="16" onClick="ventanamilitante()" onMouseOver="style.cursor=cursor">
						<br>         		
						<textarea name="nombre_militante" id="nombre_militante" readonly="true" cols="60" rows="2"></textarea>
						<script type="text/javascript">
			   			var codigo = new LiveValidation('nombre_militante');
			      		codigo.add(Validate.Presence);
			      		codigo.add( Validate.texto );
			   		</script>
			   		<font color="Red">
							(*)
						</font>				
					</td>			
				</tr>	
				
				<tr>
					<td colspan="2" align="center">
						<input type="submit" class="button" id="cargar" name="cargar" value=" Asignar " >					
					</td>
				</tr>
			</form>	
						
				<tr>
					<td colspan="2" align="center">
						<br /><br />
						<table class="gen_table_form" cellspacing="1" cellpadding="2" width="900" border="1" align="center">
						 	<tbody>
						 		<tr>
						 			<th class="section_name" align="center" colspan="7">CONTACTADOS</th>
								</tr>
	
	<?php //consulta para montrar los conceptos cargados por personal
			$consulta_detalle = pg_query("select * from militantes,contactado where militantes.cedula_militante = contactado.cedula_militante and contactado.cedula_responsable='$resultados[cedula_militante]' order by militantes.cedula_militante") or die("No se pudo realizar la consulta a la Base de datos");
	?>
								
							   <tr>											
									<th width="15%"  align="center">C&eacute;digo</th>											
									<th width="70%" align="center">Nombre y Apellido</th>																					
									<th width="15%" align="center">Tel&eacute;fono</th>
									<th width="20%" align="center">A</th>
								</tr>
								
	<?php
	while($resultados_concepto = pg_fetch_array($consulta_detalle))
	{
	?>							
								
								<tr class="item_claro"> 
									<td align="center">
										<?php  echo $resultados_concepto['cedula_militante']; ?>
									</td>
									
									<td>															
								      <font color="blue">
								      	<?php  echo $resultados_concepto['nombre_militante']; echo " "; echo $resultados_concepto['apellido_militante']; ?>
								      </font>
									</td>
	
									<td align="right">
										<?php  echo $resultados_concepto['telefono_militante']; ?>
									</td>
	
									<td align="center">
										<a onclick="return confirm('Esta seguro que desea eliminar el registro?');" href="index2.php?type=contactado_drop&cedula_militante=<?php echo $resultados_concepto['cedula_militante'];?>" title="Pulse para eliminar el registro">
											<img border="0" src="images/borrar.png" alt="borrar">
										</a>
									</td>	
								</tr>	
	<?php
	}
	?>
							</tbody>
						</table>	
					</td>
				</tr>
	
				<?php
				} //fin del arreglo
				?>
	
				<tr align="center">
					<th colspan="8" align="center">
						<div id="cpanel">
							<div style="float:right;">
								<div class="icon">
									<a href="index2.php?type=contactado">
									<img src="images/contactado.png" alt="salir" align="middle"  border="0" />
									<span>Salir</span>
									</a>
								</div>
							</div>								
						</div>
					</th>
				</tr>
			</table>
		
		<?php if ($ini=="Submit")
		{
		pg_free_result($tipo_consulta);
		pg_close();
		}
		?>	
		
		<?php 
		}
		?> 
		
	</div>
</div>

<script type="text/javascript" >
	function ventanaproyecto_oferta_inscripcion(){
		frm = document.inscripcion;
	  	codigo_periodo  = frm.codigo_periodo.value; 
	  	codigo_carrera  = frm.codigo_carrera.value; 
	  	codigo_sede  = frm.codigo_sede.value; 
	  
	  	if (codigo_periodo != "") {
	      //window.open(","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=650,height=400,left=50,top=50,location=no,resizable=no");
	      miPopup = window.open("seco/inscripcion/catalogo_oferta_proyecto.php?codigo_periodo="+codigo_periodo+"&codigo_carrera="+codigo_carrera+"&codigo_sede="+codigo_sede,"Catalogo","width=800,height=500,scrollbars=yes");
			miPopup.focus();			   					  
		} else  {
		  alert("Debe seleccionar un Periodo !!!");
		}		
	}
</script>