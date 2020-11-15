CREATE DATABASE IF NOT EXISTS tienda;
USE tienda;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios(

  idUsuario  Int unsigned NOT NULL AUTO_INCREMENT,
  nombre  VARCHAR(45) NOT NULL,
  segundoNombre  VARCHAR(45) DEFAULT NULL,
  apellidoPaterno  VARCHAR(45) NOT NULL,
  apellidoMaterno VARCHAR(45) DEFAULT NULL,
  correoElectronico  VARCHAR(200) NOT NULL,
  nivel VARCHAR(100) NOT NULL,
  usuario  VARCHAR(45) NOT NULL,
  pass  VARCHAR(45) NOT NULL,
  fechaNacimiento DATE NOT NULL,
  fModificacion TIMESTAMP NOT NULL DEFAULT current_timestamp,
  activo CHAR(1) NOT NULL DEFAULT '1',
  PRIMARY KEY(idUsuario)

);


USE tienda;
DROP TABLE IF EXISTS clientes;

CREATE TABLE clientes(

  idCliente  Int unsigned NOT NULL AUTO_INCREMENT,
  nombre  VARCHAR(45) NOT NULL,
  segundoNombre  VARCHAR(45) DEFAULT NULL,
  apellidoPaterno  VARCHAR(45) NOT NULL,
  apellidoMaterno VARCHAR(45) DEFAULT NULL,
  correoElectronico  VARCHAR(200) NOT NULL,
  usuario  VARCHAR(45) NOT NULL,
  pass  VARCHAR(45) NOT NULL,
  fechaNacimiento DATE NOT NULL,
  fModificacion TIMESTAMP NOT NULL DEFAULT current_timestamp,
  activo CHAR(1) NOT NULL DEFAULT '1',
  PRIMARY KEY(idCliente)

);

CREATE TABLE archivos(

  id  Int unsigned NOT NULL AUTO_INCREMENT,
  nombreReferencia VARCHAR(45) NOT NULL, 
  nombreArchivo  VARCHAR(45) NOT NULL,
  fModificacion TIMESTAMP NOT NULL DEFAULT current_timestamp,
  activo CHAR(1) NOT NULL DEFAULT '1',
  PRIMARY KEY(id)

);
 $miArchivo=$_POST['miArchivo'];
            $ext = pathinfo($miArchivo, PATHINFO_EXTENSION);
            echo $ext;