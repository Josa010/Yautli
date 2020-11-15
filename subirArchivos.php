<?php

    function extensionDelArchivo($nombreDelArchivo){
        $cadena = explode('.',$nombreDelArchivo);
        return $cadena[1];
    }

    $verArchivo = false;

    if (!empty($_FILES['miArchivo']['name'])) { // Si el usuario envio un archivo
        if ($_FILES['miArchivo']['size']<5000000) { //Si el archivo es menor a 5 mb, lo puede subir
            
           

            $nuevoNombre = date('ymdHis').rand(100,999).'.'.extensionDelArchivo($_FILES['miArchivo']['name']);
            if(move_uploaded_file($_FILES['miArchivo']['tmp_name'],'uploads/'.$nuevoNombre)){

                if(!$conexion=mysqli_connect('localhost','root','','tienda')){
                    $error[] = "Error al conectar a la base";
                }

                $sql="INSERT INTO archivos(nombreReferencia, nombreArchivo) VALUES('tarea', '$nuevoNombre')";
                if(mysqli_query($conexion,$sql)){

                    
                    $verArchivo = true;

                } else { 
                    $error[]="El archivo se subio al servidor pero no pudo guardarse en la base";
                }
                
            
            } else { $error[] = "No fue posible guardar el archivo"; }

            

        } else { $error [] = "El archivo no puede ser mayor a 5mb."; }
    }

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Pagina para subir archivos</title>
    <link rel="stylesheet" href="cssBoots/bootstrap.css">
    <link rel="stylesheet" href="css/archivos.css">
    <script src="https://kit.fontawesome.com/05076beaa7.js" crossorigin="anonymous"></script>
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
    
    <h1 align="center">Subir archivos</h1>

    <?php
		if (!empty($error)) {
			foreach($error as $dato){ // recorremos el arreglo
				echo "<p class='error'>* ". $dato. "</p><br>";
			}
		}
    ?>


    <form action="subirArchivos.php" target="_self" method="POST" enctype="multipart/form-data">
        <span class="texto">Selecciona el archivo a enviar:</span> 
        <div class="archivo custom-input-file ">
            <span class="test"><i class="far fa-folder-open"></i></span>
            <input type="file" name="miArchivo">
        </div> <br>
        <input type="submit" value="Enviar archivo">
    </form>


    <?php

        if($verArchivo == 'true'){

             ?> 

            <div class='alert alert-success alert-dismissible fade show text-primary mt-3' role='alert'>
                El archivo se guard&oacute correctamente
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    				<span aria-hidden='true'>&times;</span>
				</button>
            </div>;
            
            <div class='alert alert-success alert-dismissible fade show mt-3' role='alert'>
                <a class='text-primary' href='uploads/$nuevoNombre' target='_blank'>ver archivo</a>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>;

            <?php

        }
    
    ?>




    <script type="text/javascript" src="jquery/jquery-3.4.1.min.js"></script>
	<script src="jsBoots/bootstrap.min.js"></script>

</body>
</html>