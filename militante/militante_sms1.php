<?
{
	require("aut_verifica.inc.php");
	$nivel_acceso=10; // Nivel de acceso para esta pп·б╘Б∙╚ina.
	// se chequea si el usuario tiene un nivel inferior
	// al del nivel de acceso definido para esta pп·б╘Б∙╚ina.
	// Si no es correcto, se mada a la pп·б╘Б∙╚ina que lo llamo con
	// la variable de $error_login definida con el n de error segun el array de
	// aut_mensaje_error.inc.php
	if ($nivel_acceso <= $_SESSION['usuario_nivel']){
	header ("Location: $redir?error_login=5");
	exit;
	}
}
?>
<form id="formu" name="formu" action="index.php?Itemid=3&accion=5" method="post">
<table border="0" align="center" class="table1">
	<tbody>
		<TR class="rowH">
			<TD align="center">
				Destino <br>(para varios destinatarios use como separador punto y coma (;) )
			</TD>
			
			<TD align="center">
				SMS
			</TD>
		</TR>

		<tr class="rowA">
			<td align="center">
				<INPUT type="text" name="destino">
			</td>
			
			<td align="center">
				<textarea name="sms" cols="15" rows="5"></textarea>
				<input type="hidden" name="enviar" value="1">
			</td>
		</tr>
		
		<tr class="rowB" >
			<td colspan="2" align="center">
				<input type="button" class="btnLogin" value="borrar"  onclick="formu.reset();">&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="button" class="btnLogin" value="Enviar" onclick="formu.submit();">
			</td>
		</tr>
	</tbody>
</table>
</form>

<?
require("conexion/aut_verifica.inc.php");
//Conexion a la base de datos
$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

$cmdo='ls /dev/ | grep ttyACM0';
$con = popen ($cmdo,'r');
$salida = fread($con, 2096);

if(!ereg('ttyACM0', $salida))
{
	echo '<div align="center"><font size="+1" color="red">El celular no se encuentra conectado o no esta disponible, por favor revise la conexión del equipo (Los mensajes serán enviados al ser conectado el celular).</font></div>';
}

$destino=$_POST['destino'];
$sms=$_POST['sms'];


if (isset ($_POST['enviar']))
{
if ($sms and $destino)
	{
		$array_cell=explode(',', $destino);
		foreach ($array_cell as $dest)
		{
			str_replace('.','',$dest);
			if ( strlen($dest)==11 and ((stristr($dest, '0414') or stristr($dest, '0424') or stristr($dest, '0426') or stristr($dest, '0416') or stristr($dest, '0412') )))
			{
				echo $datoom=date('Y').date('m').date('d').date('H').date('i').date('s');
				$creatorId=$_SESSION['usuario_nombre'];
				$send=mysql_query("insert into outbox(UpdatedInDB,InsertIntoDB,Class,DestinationNumber,TextDecoded,RelativeValidity,SenderID,Coding,CreatorID) VALUES(now(),now(),'-1','$dest','$sms','-1','','Default_No_Compression','$creatorId')") or die(mysql_error());
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
	else
	{
		$out="faltan datos por ingresar";
	}
	echo "<script language=\"javascript\">
	alert('$out')
	</script>";
}

?>
