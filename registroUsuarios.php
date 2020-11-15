<?php

// Autor: Josafat Muñoz Valverde 5oG
// Mi trabajo lleva un boton para regresar al index porque hice un indice.
// los estilos no van a cargar tampoco
// Tambien subí mi pagina, el url es: https://josafat.herokuapp.com
// Tambien lo subí a github, el url es: https://github.com/Josa010/Yautli

if (!empty($_POST['nombre'])) {

	$nombre = $_POST['nombre'];
	unset($_POST['nombre']);
} else {
	$nombre = NULL;
}


if (!empty($_POST['segundoNombre'])) {

	$segundoNombre = $_POST['segundoNombre'];
	unset($_POST['segundoNombre']);
} else {
	$segundoNombre = NULL;
}


if (!empty($_POST['apellidoPaterno'])) {

	$apellidoPaterno = $_POST['apellidoPaterno'];
	unset($_POST['apellidoPaterno']);
} else {
	$apellidoPaterno = NULL;
}


if (!empty($_POST['apellidoMaterno'])) {

	$apellidoMaterno = $_POST['apellidoMaterno'];
	unset($_POST['apellidoMaterno']);
} else {
	$apellidoMaterno = NULL;
}


if (!empty($_POST['correoElectronico'])) {

	$correoElectronico = $_POST['correoElectronico'];
	unset($_POST['correoElectronico']);
} else {
	$correoElectronico = NULL;
}


if (!empty($_POST['nivel'])) {

	$nivel = $_POST['nivel'];
	unset($_POST['nivel']);
} else {
	$nivel = NULL;
}


if (!empty($_POST['usuario'])) {

	$usuario = $_POST['usuario'];
	unset($_POST['usuario']);
} else {
	$usuario = NULL;
}


if (!empty($_POST['pass'])) {

	$pass = $_POST['pass'];
	unset($_POST['pass']);
} else {
	$pass = NULL;
}


if (!empty($_POST['passConfirmado'])) {

	$passConfirmado = $_POST['passConfirmado'];
	unset($_POST['passConfirmado']);
} else {
	$passConfirmado = NULL;
}


if (!empty($_POST['siguientePaso'])) {

	$siguientePaso = $_POST['siguientePaso'];
	unset($_POST['siguientePaso']);
} else {
	$siguientePaso = NULL;
}



if ($siguientePaso == 2) { // Este paso es cuando se enviaron el formulario

	if ($conexion = @mysqli_connect('localhost', 'root', '')) {
		if (!mysqli_select_db($conexion, 'tienda')) {
			mysqli_close($conexion);
			$error['noDB'] = "Error 1002: No se pudo conectar con la base de datos.";
		}
	} else {
		$errores['noCxn'] = "Error: 1001. No fue posible realizar la conexi&oacute;n";
	}

	if (empty($nombre)) {
		$errores[] = "Debe de escribir el nombre del usuario.";
	}

	if (empty($apellidoPaterno)) {
		$errores[] = "Debe de escribir el apellido paterno.";
	}

	if (!empty($correoElectronico)) {

		$sentenciaSql = "SELECT correoElectronico FROM usuarios WHERE correoElectronico = '$correoElectronico' AND activo='1' LIMIT 1";
		$resultadoConsulta = mysqli_query($conexion, $sentenciaSql);
		$dato = mysqli_fetch_assoc($resultadoConsulta);
		if (!empty($dato)) {
			$errores[] = 'Ya existe un usuario con ese correo. Favor de escribir uno diferente.';
		}
	} else {
		$errores[] = "Debe proporcionar un correo electr&oacute;nico.";
	}



	if (empty($nivel)) {
		$errores[] = "Debe de escribir un nivel correcto.";
	}



	if (!empty($usuario)) {

		$sentenciaSql = "SELECT usuario FROM usuarios WHERE usuario = '$usuario' AND activo='1' LIMIT 1";
		$resultadoConsulta = mysqli_query($conexion, $sentenciaSql);
		$dato = mysqli_fetch_assoc($resultadoConsulta);
		if (!empty($dato)) {
			$errores[] = 'Ya existe un usuario con ese nickname. Favor de escribir uno diferente.';
		}
	} else {
		$errores[] = "No ha escrito el usuario.";
	}




	if (empty($pass)) {
		$errores[] = "Debe escribir una contrase&ntilde;a.";
	}

	if (empty($passConfirmado)) {
		$errores[] = "Debe confirmar la contrase&ntilde;a.";
	}

	if ($pass != $passConfirmado) {
		$errores[] = "La contrase&ntilde;a no coinciden";
	}

	if (empty($errores)) {
		// Para guardar los datos

		//$pass = sha1($pass);
		$pass = password_hash($pass, PASSWORD_DEFAULT);


		$sentenciaSql = "INSERT INTO usuarios(nombre, segundoNombre, apellidoPaterno, apellidoMaterno, correoElectronico, nivel, usuario, pass)
				VALUES('$nombre', '$segundoNombre', '$apellidoPaterno', '$apellidoMaterno', '$correoElectronico', '$nivel', '$usuario', '$pass')";

		if (mysqli_query($conexion, $sentenciaSql)) {
			$siguientePaso = 3;
		} else {
			echo "ERROR AL GUARDAR LA INFORMACIÓN";
		}
	} else {
		$siguientePaso = NULL;
	}
} // Finalizo del paso 2

?>

<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Registro de usuarios</title>
	<link rel="stylesheet" href="cssBoots/bootstrap.css">
	<link rel="stylesheet" href="css/registroUsuarios.css"> 
</head>

<body class="bg-dark">




	<nav class="navbar navbar-expand-lg navbar-light mb-3">
		<a class="navbar-brand text-white" href="index.html">Inicio</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item active">
					<a class="nav-link text-white" href="registroUsuarios.php">Registro de usuarios <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link text-white" href="registroClientes.php">Registro de clientes</a>
				</li>
				<li class="nav-item">
					<a class="nav-link text-white" href="subirArchivos.php">Subir archivos</a>
				</li>
			</ul>
		</div>
	</nav>





	<h1 align="center" class="mb-3">Registro de usuarios</h1>

	<?php
	if (!empty($errores)) {
		foreach ($errores as $error) { // recorremos el arreglo



			echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
					*   $error 
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    					<span aria-hidden='true'>&times;</span>
				  	</button>
				</div>";
			
			
		}
	}
	?>


	<?php if ($siguientePaso == 3) { ?>
		<h3 align="center">La informaci&oacute;n se ha guardado correctamente</h3>
		<a href="registroUsuarios.php" target="_self" class="btn btn-sm btn-block text-white w-50 mx-auto" style="background-color: #375A7F;">Regresar</a>
	<?php }	?>

	<?php if (empty($siguientePaso)) { ?>

		<form action="registroUsuarios.php" method="POST" target="_self">
			<input type="hidden" name="siguientePaso" value="2">

			<div class="container">
				<div class="row p-2">
					<div class="col-2 text-right">Nombre:</div>
					<div class="col-4">
						<input class="form-control" type="text" name="nombre" required value="<?php echo $nombre; ?>" placeholder="Nombre de usuario">
					</div>
					<div class="col-2 text-right">Segundo nombre:</div>
					<div class="col-4">
						<input class="form-control" type="text" name="nombre" required value="<?php echo $nombre; ?>" placeholder="Nombre de usuario">
					</div>
				</div>

				<div class="row p-2">
					<div class="col-2 text-right">Apellido Paterno:</div>
					<div class="col-4">
						<input class="form-control" type="text" name="apellidoPaterno" required value="<?php echo $apellidoPaterno; ?>" placeholder="Apellido paterno">
					</div>
					<div class="col-2 text-right">Apellido Materno:</div>
					<div class="col-4">
						<input class="form-control" type="text" name="apellidoMaterno" value="<?php echo $apellidoMaterno; ?>" placeholder="Apellido materno">
					</div>
				</div>

				<div class="row p-2">
					<div class="col-2 text-right">Correo electr&oacute;nico:</div>
					<div class="col-4">
						<input class="form-control" type="email" name="correoElectronico" required value="<?php echo $correoElectronico; ?>" placeholder="Correo electr&oacute;nico">
					</div>
					<div class="col-2 text-right">Nivel:</div>
					<div class="col-4">
						<input class="form-control" type="text" name="nivel" required value="<?php echo $nivel; ?>" placeholder="Nivel">
					</div>
				</div>

				<div class="row p-2">
					<div class="col-2 text-right">Usuario:</div>
					<div class="col-4">
						<input class="form-control" type="text" name="usuario" required value="<?php echo $usuario; ?>" placeholder="Usuario">
					</div>
				</div>

				<div class="row p-2">
					<div class="col-2 text-right">Contrase&ntilde;a:</div>
					<div class="col-4">
						<input class="form-control" type="password" name="pass" required value="<?php echo $pass; ?>">
					</div>
					<div class="col-2 text-right">Confirmar contrase&ntilde;a:</div>
					<div class="col-4">
						<input class="form-control" type="password" name="passConfirmado" required value="<?php echo $passConfirmado; ?>">
					</div>
				</div>

				<div class="row p-2">
					<input class="btn btn-block btn-lg" type="submit" value="Registrar">
				</div>

			</div>


		</form>

		
	<?php }	?>
	
	<script type="text/javascript" src="jquery/jquery-3.4.1.min.js"></script>
	<script src="jsBoots/bootstrap.min.js"></script>
	
</body>

</html>