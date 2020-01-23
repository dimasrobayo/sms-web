<html>
<head>
	<title>BUSCAR CLIENTE</title>
	<link href="../css/template_css.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="../css/table_css.css" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>

	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() 
		{
			$('#tabla').dataTable();
		} );
	</script>
	
	<script language="javascript">
	function pon_prefijo(cedula,nombre,apellido)
		{
			parent.opener.document.frm_contactado.cedula_militante.value=cedula;
			parent.opener.document.frm_contactado.nombre_militante.value=nombre + " " + apellido;
			parent.opener.document.frm_contactado.cargar.focus();
			parent.window.close();
		}
	</script>
</head>

<?php
    require("../conexion/aut_config.inc.php");
    /*este es el enlace de conexion a la base de datos*/
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

if (!isset($_GET['accion']))
{
    $datos_consulta = pg_query("SELECT * FROM militantes order by militantes.cedula_militante") or die("No se pudo realizar la consulta a la Base de datos");
?>

<body>

<div align="center" class="centermain">
    <div class="main">  
        <div align="center">
            <font color="red" style="text-decoration:blink;"><?php $error_accion_ms[$error_cod]?></font>
        </div>

        <table class="admin_MILITANTES">
            <tr>
                <th>
                    CATALOGO DE MILITANTES:
                    <small>
                    GESTI&Oacute;N
                    </small>
                </th>
            </tr>
        </table>

<!--Estructura de Tabla de Contenidos de la Tabla usuario-->
        <table border="0" class="display" id="tabla">
            <thead>
            <tr>
                <th align="center" width="10%">
                    C&Eacute;DULA
                </th>

                <th width="50%" align="center">
                    NOMBRE Y APELLIDO
                </th>
                
                <th width="25%" align="center">
                    TELEFONO
                </th>

                <th width="10%" align="center">
                    ACCIONES
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
                <td  align="center">
                     <?php echo $resultados[cedula_militante];?>
                </td>

                <td  align="left">
                    <?php echo $resultados[nombre_militante]; echo " "; echo $resultados[apellido_militante];?>
                </td>
                
                <td  align="center">
                    <?php echo $resultados[telefono_militante];?>
                </td>

                <td align="center"> 
                    <a href="javascript:pon_prefijo(<?php echo $resultados[cedula_militante];?>,'<?php echo $resultados[nombre_militante];?>','<?php echo $resultados[apellido_militante];?>')" title="Pulse para Modificar el Nivel de Acceso">
                        <img src="../images/botonagregar.jpg" alt="borrar" onclick="actualizar_importe()">
                    </a>
                </td>
            </tr>	
<?php
}
?>
			<tfoot>
				<tr align="right">
					<th colspan="6" align="center">
						<div id="cpanel">
							<div style="float:left;">
								<div class="icon">
									<a onclick="parent.window.close();">
									<img src="../images/cpanel.png" alt="salir" align="middle"  border="0" />
									<span>Salir</span>
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
</body>
</html>