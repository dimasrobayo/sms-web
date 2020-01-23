//-------------------------------------------------------------------------------------------------//
//-----------------------------------funciones para los formularios -------------------------------//
//-------------------------------------------------------------------------------------------------//

function setFocus() 
{
	document.loginForm.user.select();
	document.loginForm.user.focus();
}
	

function verinsertados(){
	var contenedor;
	contenedor = document.getElementById('div_datos');
	ajax=nuevoAjax();
	ajax.open("GET", "procesos.php?ver=1",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
		   contenedor.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}
		
		
		
function validarexiste(){
	var d1,contenedor;
	contenedor = document.getElementById('validar');
	d1 = document.QForm.cedula_pac.value;
	d2=location.href;
	ajax=nuevoAjax();
	ajax.open("GET", "procesos.php?valcodigo="+d1+"&dir="+d2,true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
		   contenedor.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}
		
					
		
function cargarContenidoMunicipio(){
	var d1,contenedor;
	contenedor = document.getElementById('contenedor2');
	d1 = document.QForm.codest.options[document.QForm.codest.selectedIndex].value;
	d2=location.href;
	ajax=nuevoAjax();
	ajax.open("GET", "procesos.php?codest="+d1+"&dir="+d2,true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			contenedor.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}		
		
function cargarContenidoParroquia(){
	var d1,d2,d3,contenedor;
	contenedor = document.getElementById('contenedor3');
	d1 = document.QForm.codmun.options[document.QForm.codmun.selectedIndex].value;
	d2 = document.QForm.codest.value;
	d3=location.href;
	ajax=nuevoAjax();
	ajax.open("GET", "procesos.php?codmun="+d1+"&codestado="+d2+"&dir="+d3,true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			contenedor.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}		
		