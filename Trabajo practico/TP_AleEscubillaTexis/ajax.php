<?php
	include_once("./backend/validarSesion.php");
	ValidarSesion("./login.html");
?>
<!doctype html>
<html>
<head>
	<title>Empleados con archivos</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script type="text/javascript" src="./javascript/funciones.js"></script>
</head>
<body>
	<div class="container">
		<div style="width:1550px">
			<table>
				<tbody>
					<tr>
						<td width="95%">
							<div id="divFrm" style="height:500px;overflow:visible;"></div>
						</td>
						<td rowspan="2">
							<div id="divEmpleados" style="height:500px;overflow:visible;"></div>
						</td>
					</tr>
				</tbody>
			</table>
			<br>
			<footer align=center >
				<h4 style="display:block;padding:10px;">
				<a href="./backend/cerrarSesion.php">Cerrar sesion</a>
				</h4>
			</footer>
		</div>
	</div>
</body>
</html>