<?php

	// Mi trabajo lleva un boton para regresar al index porque hice un indice.
	// los estilos no van a cargar tampoco
	// Tambien subí mi pagina el url es: https://josafat.herokuapp.com

	if (!empty($_POST['nombre'])) {

		$nombre=$_POST['nombre'];
		unset($_POST['nombre']);
		
	} else {
		$nombre=NULL;
	}


	if (!empty($_POST['segundoNombre'])) {

		$segundoNombre=$_POST['segundoNombre'];
		unset($_POST['segundoNombre']);
		
	} else {
		$segundoNombre=NULL;
	}


	if (!empty($_POST['apellidoPaterno'])) {

		$apellidoPaterno=$_POST['apellidoPaterno'];
		unset($_POST['apellidoPaterno']);
		
	} else {
		$apellidoPaterno=NULL;
	}


	if (!empty($_POST['apellidoMaterno'])) {

		$apellidoMaterno=$_POST['apellidoMaterno'];
		unset($_POST['apellidoMaterno']);
		
	} else {
		$apellidoMaterno=NULL;
	}


	if (!empty($_POST['correoElectronico'])) {

		$correoElectronico=$_POST['correoElectronico'];
		unset($_POST['correoElectronico']);
		
	} else {
		$correoElectronico=NULL;
    }
    

    if (!empty($_POST['nivel'])) {

		$nivel=$_POST['nivel'];
		unset($_POST['nivel']);
		
	} else {
		$nivel=NULL;
	}


	if (!empty($_POST['usuario'])) {

		$usuario=$_POST['usuario'];
		unset($_POST['usuario']);
		
	} else {
		$usuario=NULL;
	}


	if (!empty($_POST['pass'])) {

		$pass=$_POST['pass'];
		unset($_POST['pass']);
		
	} else {
		$pass=NULL;
	}


	if (!empty($_POST['passConfirmado'])) {

		$passConfirmado=$_POST['passConfirmado'];
		unset($_POST['passConfirmado']);
		
	} else {
		$passConfirmado=NULL;
	}


	if (!empty($_POST['siguientePaso'])) {

		$siguientePaso=$_POST['siguientePaso'];
		unset($_POST['siguientePaso']);
		
	} else {
		$siguientePaso=NULL;
	}



	if ($siguientePaso==2) { // Este paso es cuando se enviaron el formulario
		
		if ($conexion = @mysqli_connect('localhost','root','')) {
		if (!mysqli_select_db($conexion, 'tienda')) {
				mysqli_close($conexion); $error['noDB'] = "Error 1002: No se pudo conectar con la base de datos.";
			}

		} else {
			$errores['noCxn']="Error: 1001. No fue posible realizar la conexi&oacute;n";
		}

		if (empty($nombre)) {
			$errores[] = "Debe de escribir el nombre del usuario.";
		}
		
		if (empty($apellidoPaterno)) {
			$errores[] = "Debe de escribir el apellido paterno.";
		}

		if (!empty($correoElectronico)) {

			$sentenciaSql = "SELECT correoElectronico FROM usuarios WHERE correoElectronico = '$correoElectronico' AND activo='1' LIMIT 1";
			$resultadoConsulta = mysqli_query($conexion,$sentenciaSql);
			$dato = mysqli_fetch_assoc($resultadoConsulta);
			if (!empty($dato)) {
				$errores[] = 'Ya existe un usuario con ese correo. Favor de escribir uno diferente.';
			}
			


		} else{
			$errores[] = "Debe proporcionar un correo electr&oacute;nico.";
		}



        if (empty($nivel)) {
			$errores[] = "Debe de escribir un nivel correcto.";
		}

		

		if (!empty($usuario)) {

			$sentenciaSql = "SELECT usuario FROM usuarios WHERE usuario = '$usuario' AND activo='1' LIMIT 1";
			$resultadoConsulta = mysqli_query($conexion,$sentenciaSql);
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

		if ($pass!=$passConfirmado) {
			$errores[] = "La contrase&ntilde;a no coinciden";
		}

		if (empty($errores)) {
			// Para guardar los datos

			$pass=sha1($pass);


			$sentenciaSql="INSERT INTO usuarios(nombre, segundoNombre, apellidoPaterno, apellidoMaterno, correoElectronico, nivel, usuario, pass)
				VALUES('$nombre', '$segundoNombre', '$apellidoPaterno', '$apellidoMaterno', '$correoElectronico', '$nivel', '$usuario', '$pass')";

			if (mysqli_query($conexion,$sentenciaSql)) {
				$siguientePaso = 3;
			} else{
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
    <title>Registro de usuarios</title>
	<link rel="stylesheet" href="css/registroUsuarios.css">
</head>
<body>

	<div id="boton-regresar">
		<a href="index.html" id="regresar">Regresar al indice</a>
	</div>

	<h1 align="center">Registro de usuarios</h1>

	<?php
		if (!empty($errores)) {
			foreach($errores as $error){ // recorremos el arreglo
				echo "<p class='error'>* ". $error. "</p><br>";
			}
		}
	?>


	<?php if ($siguientePaso==3) {?>
		<h3 align="center">La informaci&oacute;n se ha guardado correctamente</h3>
		<a href="registroUsuarios.php" target="_self">Regresar</a>
	<?php }	?>

	<?php if (empty($siguientePaso)) {?>
		
		<form action="registroUsuarios.php" method="POST" target="_self">
		<input type="hidden" name="siguientePaso" value="2">
		<table align="center" border="0" cellpadding="0" cellspacing="0">
		    <tr>
			    <td>Nombre:</td>
			    <td><input type="text" name="nombre" required value="<?php echo $nombre; ?>" placeholder="Nombre de usuario"></td>
		    </tr>
		    <tr>
			    <td>Segundo nombre:</td>
			    <td><input type="text" name="segundoNombre" value="<?php echo $segundoNombre; ?>" placeholder="Segundo nombre"></td>
		    </tr>
		    <tr>
			    <td>Apellido Paterno:</td>
			    <td><input type="text" name="apellidoPaterno" required value="<?php echo $apellidoPaterno; ?>" placeholder="Apellido paterno"></td>
		    </tr>
		    <tr>
			    <td>Apellido Materno:</td>
			    <td><input type="text" name="apellidoMaterno" value="<?php echo $apellidoMaterno; ?>" placeholder="Apellido materno"></td>
		    </tr>
		    <tr>
			    <td>Correo electr&oacute;nico:</td>
			    <td><input type="email" name="correoElectronico" required value="<?php echo $correoElectronico; ?>" placeholder="Correo electr&oacute;nico"></td>
            </tr>
            <tr>
			    <td>Nivel:</td>
			    <td><input type="text" name="nivel" required value="<?php echo $nivel; ?>" placeholder="Nivel"></td>
		    </tr>
		    <tr>
			    <td>Usuario:</td>
			    <td><input type="text" name="usuario" required value="<?php echo $usuario; ?>" placeholder="Usuario"></td>
		    </tr>
		    <tr>
			    <td>Contrase&ntilde;a:</td>
			    <td><input type="password" name="pass" required value="<?php echo $pass; ?>"></td>
			</tr>
			<tr>
			    <td>Confirmar contrase&ntilde;a:</td>
			    <td><input type="password" name="passConfirmado" required value="<?php echo $passConfirmado; ?>"></td>
		    </tr>
		    <tr>
			    <td colspan="2"><input type="submit" value="Registrar"></td>
		    </tr>
		</table>
	</form>

	<?php }	?>
	
	
</body>
</html>
