<?php
	include_once("./backendBD/validarSesion_bd.php");
	ValidarSesion("./login_bd.html");
?>
<!doctype html>
<html>
<head>
	<title>Empleados con base de datos</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script type="text/javascript" src="./javascript/funcionesBD.js"></script>
</head>
<body>
	<div class="container">
		<div style="width:1550px">
			<table>
				<tbody>
					<tr>
						<td width="95%">
							<div id="divFrm" style="height:500px;overflow:visible"></div>
						</td>
						<td rowspan="2">
							<div id="divEmpleados" style="height:500px;overflow:visible"></div>
						</td>
					</tr>
				</tbody>
			</table>
			<footer align=center >
				<h4 style="display:block;border:solid;padding:10px;">
				<a href="./backendBD/cerrarSesion_bd.php">Cerrar sesion</a>
				</h4>
			</footer>
		</div>
	</div>
</body>
</html>