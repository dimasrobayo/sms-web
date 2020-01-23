<table border="0" cellpadding="10" cellspacing="10" width="100%">
	<tbody>
		<tr>
			<td bgcolor="#FFF7D7"> 
				<p class="gen" align="center">
					<font color="red">Usted ha sido desconectado correctamente del Sistema
						<br>
						<br>
						Haga click <a href="index.php">aqui</a> para ingresar de nuevo.
						<?php 
							// destruimos la session de usuarios.
							session_destroy();
						?>
					</font>
					</b>
				</p>
			</td>
		</tr> 			
	</tbody>
</table>