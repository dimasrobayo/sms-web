<?php 
switch ($type)
{
case "": include("hola.php");
break;

case "out": include("logout.php");
break;

case "creditos": include("credits.php");
break;

/***USUARIO****/

case "usuarios": include("usuario/aut_gestion_usuario.php");
break;

case "usuarios_add": include("usuario/usuario_add.php");
break;

case "usuario_update": include("usuario/usuario_update.php");
break;

case "usuario_update_clave": include("usuario/usuario_update_clave.php");
break;

case "usuario_update_nivel": include("usuario/usuario_update_nivel.php");
break;

case "usuario_unlock": include("usuario/usuario_unlock.php");
break;

case "usuario_drop": include("usuario/usuario_drop.php");
break;

/***PARROQUIA****/

case "parroquia": include("parroquia/aut_gestion_parroquia.php");
break;

case "parroquia_add": include("parroquia/parroquia_add.php");
break;

case "parroquia_update": include("parroquia/parroquia_update.php");
break;

case "parroquia_drop": include("parroquia/parroquia_drop.php");
break;

/***CARGO****/

case "cargo": include("cargo/aut_gestion_cargo.php");
break;

case "cargo_add": include("cargo/cargo_add.php");
break;

case "cargo_update": include("cargo/cargo_update.php");
break;

case "cargo_drop": include("cargo/cargo_drop.php");
break;

/***CENTRO DE VOTACION****/

case "centro_votacion": include("centro_votacion/aut_gestion_centro_votacion.php");
break;

case "centro_votacion_add": include("centro_votacion/centro_votacion_add.php");
break;

case "centro_votacion_update": include("centro_votacion/centro_votacion_update.php");
break;

case "centro_votacion_drop": include("centro_votacion/centro_votacion_drop.php");
break;

/***MILITANTES****/
case "militante": include("militante/aut_gestion_militante.php");
break;

case "militante_add": include("militante/militante_add.php");
break;

case "militante_sms": include("militante/militante_sms.php");
break;

case "militante_update": include("militante/militante_update.php");
break;

case "militante_drop": include("militante/militante_drop.php");
break;


/***CONTACTADOS****/
case "contactado": include("contactado/aut_gestion_contactado.php");
break;

case "contactado_add": include("contactado/contactado_add.php");
break;

case "contactado_update": include("contactado/contactado_update.php");
break;

case "contactado_drop": include("contactado/contactado_drop.php");
break;

/***SMS - MASIVOS****/
case "sms_masivo": include("sms_masivo/sms_masivo_add.php");
break;

/***SMS - RECIBIDOS****/
case "recibidos": include("recibidos/aut_gestion_recibido.php");
break;

/***SMS - POR ENVIAR****/
case "por_enviar": include("por_enviar/aut_gestion_por_enviar.php");
break;

case "enviando_drop": include("por_enviar/enviando_drop.php");
break;

/***SMS - ENVIADOS****/
case "enviados": include("enviados/aut_gestion_enviado.php");
break;

/*****AUTIDORIA******/
case "auditoria": include("auditoria/aut_gestion_auditoria.php");
break;

/*****NOTAS ADHESIVAS******/
case "notas": include("notas/aut_gestion_notas.php");
break;

case "notas_add": include("notas/notas_add.php");
break;

case "notas_update": include("notas/notas_update.php");
break;

case "notas_drop": include("notas/notas_drop.php");
break;
}
?>
