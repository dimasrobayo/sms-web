<?php 
if ($nivel_acceso <= $_SESSION['usuario_nivel'])
{
	header ("Location: $redir?error_login=5");
	exit;
}
?>

<?php echo $notes?>

<div align="center" class="centermain">
	<div class="main">
		<table class="adminheading" border="0">
			<tr>
				<th class="cpanel">
					Panel de Control Principal
				</th>
			</tr>
		</table>

<table class="adminform" align="center">
<tr align="center">
	<td width="100%" valign="top" align="center">
	<div id="cpanel">
		<div style="float:left;">
			<div class="icon">
				<a href="index2.php?type=parroquia">
					<img src="images/parroquia.png" alt="parroquia" align="middle"  border="0" />
					<span>Parroquias</span>
				</a>
			</div>
		</div>

		<div style="float:left;">
			<div class="icon">
				<a href="index2.php?type=cargo">
					<img src="images/cargos.png" alt="cargo" align="middle"  border="0" />
					<span>Categorias</span>
				</a>
			</div>
		</div> 

		<div style="float:left;">
			<div class="icon">
				<a href="index2.php?type=centro_votacion">
					<img src="images/centro_votacion.png" alt="centro_votacion" align="middle"  border="0" />
					<span>Centro de Votaci&oacute;n</span>
				</a>
			</div>
		</div>

		<div style="float:left;">
			<div class="icon">
				<a href="index2.php?type=militante">
					<img src="images/militante.png" alt="cuenta" align="middle"  border="0" />
					<span>Agenda</span>
				</a>
			</div>
		</div>
		
		<div style="float:left;">
			<div class="icon">
				<a href="index2.php?type=contactado">
					<img src="images/contactado.png" alt="cuenta" align="middle"  border="0" />
					<span>Grupos</span>
				</a>
			</div>
		</div>
		
		<div style="float:left;">
			<div class="icon">
				<a href="index2.php?type=sms_masivo">
					<img src="images/sms-grupo.png" alt="cuenta" align="middle"  border="0" />
					<span>SMS - Categoria</span>
				</a>
			</div>
		</div>
	</div>
	</td>
</tr>

<tr align="center">
	<td width="100%" valign="top" align="center">
	<div id="cpanel">
		<div style="float:left;">
			<div class="icon">
				<a href="index2.php?type=recibidos">
					<img src="images/sms_recibidos.png" alt="bandeja de entrada" align="middle"  border="0" />
					<span>SMS - Recibidos</span>
				</a>
			</div>
		</div>

		<div style="float:left;">
			<div class="icon">
				<a href="index2.php?type=por_enviar">
					<img src="images/sms_por_enviar.png" alt="Creditos" align="middle"  border="0" />
					<span>Por Enviar</span>
				</a>
			</div>
		</div>
		
		<div style="float:left;">
			<div class="icon">
				<a href="index2.php?type=enviados">
					<img src="images/sms_enviados.png" alt="Gestionar Administradores" align="middle"  border="0" />
					<span>SMS - Enviados</span>
				</a>
			</div>
		</div>
		
		<div style="float:left;">
			<div class="icon">
				<a href="index2.php?type=reporte">
					<img src="images/reporte.png" alt="g_permisos" align="middle"  border="0" />
					<span>Reportes</span>
				</a>
			</div>
		</div>

		<div style="float:left;">
			<div class="icon">
				<a href="index2.php?type=usuarios">
					<img src="images/usuarios.png" alt="Gestionar Administradores" align="middle"  border="0" />
					<span>Gestionar Permisos</span>
				</a>
			</div>
		</div>

		<div style="float:left;">
			<div class="icon">
				<a href="index2.php?type=out">
					<img src="images/salir.png" alt="Salir" align="middle"  border="0" />
					<span>Salir del Sistema</span>
				</a>
			</div>
		</div>
	</div>
	</td>
</tr>

<tr align="center">
	<td width="100%" valign="top" align="center">
		<div id="footer2" class="footer2" align="center">
			<div align="center">
				Sistema de Gestión de Militantes PSUV-GUANARE, desarrollado con herramientas de Software Libre.
				<br>
				Vision HannaH c.a Desarrollo e Innovaci&oacute;n a Medida.
			</div>
		</div>
	</td>
</tr>
</table>
	</div>
</div>

