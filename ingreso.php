<?php

if (!empty($_POST['usuario'])) {

  $usuario = $_POST['usuario'];
} else {
  $usuario = NULL;
}

if (!empty($_REQUEST['pass'])) {

  $pass = $_REQUEST['pass'];
} else {
  $pass = NULL;
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



  if (!empty($usuario) && !empty($pass)) {

    //$sentenciaSql = "SELECT usuario FROM usuarios WHERE usuario = '$usuario' AND pass='$pass'";
    $sentenciaSql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultadoConsulta = mysqli_query($conexion, $sentenciaSql);
    $rowUsuario = mysqli_fetch_assoc($resultadoConsulta);

    if (empty($rowUsuario['usuario'])) {
      $errores[] = "Este usuario no existe";
    
    } else{
      $pass2 = $rowUsuario['pass'];

      if (password_verify($pass, $pass2)) {
        header("location:index.html");
            
      } else {
        $errores[] = "La contraseña es erronea";
      }

    }

  }

} // Finalizo del paso 2


?>


<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v4.1.1">
  <title>Ingreso</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/sign-in/">

  <!-- Bootstrap core CSS -->
  <link href="ejemplos/assets/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    .boton{
      background-color: #375A7F;
    }

    .boton:hover{
      background-color:#29425c;
    }

    .form-control{
    border: 1px solid #677079 !important;
    } 

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <!-- Custom styles for this template -->
  <link href="signin.css" rel="stylesheet">
  <link rel="stylesheet" href="css/ingreso.css">
</head>

<body class="text-center text-white bg-dark">

  <?php
  if (!empty($errores)) {
    foreach ($errores as $error) { // recorremos el arreglo



      echo "<div class='alert alert-danger alert-dismissible fade show fixed error' role='alert'>
            *   $error 
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
          </div>";
    }
  }
  ?>

  <form class="form-signin" action="ingreso.php" method="POST" target="_self">
    <input type="hidden" name="siguientePaso" value="2">

    <img class="mb-4" src="ejemplos/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Ingresa tus datos</h1>

    <label for="usuario" class="sr-only">Usuario</label>
    <input value="<?php echo $usuario; ?>" type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuario" required autofocus>

    <label for="pass" class="sr-only">Contrase&ntilde;a</label>
    <input value="<?php echo $pass; ?>" type="password" id="pass" name="pass" class="form-control" placeholder="Contrase&ntilde;a" required>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Recordar ingreso
      </label>
    </div>

    <button class="btn btn-lg btn-block text-white boton" type="submit">Ingresar</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
  </form>


  <script type="text/javascript" src="jquery/jquery-3.4.1.min.js"></script>
  <script src="jsBoots/bootstrap.min.js"></script>

</body>

</html>