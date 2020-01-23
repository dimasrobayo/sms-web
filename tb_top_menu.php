<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<TD>
	<?php
		$m=date("n");
		switch($m) {
		   case 1:
		          $mes="Enero"; 
		          break;
		   case 2:
		          $mes="Febrero"; 
		          break;
		   case 3:
		          $mes="Marzo"; 
		          break;
		   case 4:
		          $mes="Abril"; 
		          break;
		   case 5:
		          $mes="Mayo"; 
		          break;
		   case 6:
		          $mes="Junio"; 
		          break;
		   case 7:
		          $mes="Julio"; 
		          break;
		   case 8:
		          $mes="Agosto"; 
		          break;
		   case 9:
		          $mes="Septiembre"; 
		          break;
		   case 10:
		          $mes="Octubre"; 
		          break;
		   case 11:
		          $mes="Noviembre"; 
		          break;
		   case 12:
		          $mes="Diciembre"; 
		          break; 
			  
		}
		$fecha=date("d")." de ".$mes." de ".date("Y");
		//validacion para la impresion de la fecha	
		?>
		
        </TD>
	
	<TD class="menubackgr" align="right" style="padding-right:5px;">
		<strong>Bienvenido(a): <?php echo $_SESSION['usuario_nombre']?> <?php echo $_SESSION['usuario_apellido']?></strong>	
		<br>
		<?php
			echo $fecha; //imprimo mi variable de la fecha.
		?>		
	</TD>
</tr>
</table>