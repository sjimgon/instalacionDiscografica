<?php


if(isset($_POST['host']) && isset($_POST['user']) && isset($_POST['password']) && isset($_POST['database']) && isset($_POST['port']) && isset($_POST['install'])){
    $contenido = "<?php 
    define('HOST','".$_POST["host"]."');
    define('USER','".$_POST['user']."');
    define('PASSWORD','".$_POST['password']."');
    define('NAMEDB','".$_POST['database']."');
    define('PORT','".$_POST['port']."');
    ?>";

    if(!file_exists("../config/config.php")){

        if(!is_dir("../config")){
            mkdir("../config");
        }

        $file = fopen("../config/config.php","w");
        fwrite($file,$contenido);
        fclose($file);
        echo "Configuración guardada correctamente";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalacón app</title>
</head>
<body>

<?php
if(!file_exists("../config/config.php")){?>
    <h1>Instalación de la aplicacion</h1>
     <p>Para una correcta instalación vamos a necesitar algunos datos relativos a la base de datos</p>

     <form action="" method="post">
            <label for="host">Host</label>
            <input type="text" name="host" id="host" required>
            <br>
            <label for="user">Usuario</label>
            <input type="text" name="user" id="user" required>
            <br>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
            <br>
            <label for="database">Nombre de la base de datos</label>
            <input type="text" name="database" id="database" required>
            <br>
            <label for="port">Puerto</label>
            <input type="text" name="port" id="port" required>
            <input type="submit" value="Instalar" name="install">
     </form>

<?php }else{

    include_once("../config/config.php");
    $conexion = new mysqli(HOST,USER,PASSWORD,"",PORT);
    if($conexion->connect_errno){
        echo "Error al conectar a la base de datos";
    }
     
    $sql = "CREATE DATABASE IF NOT EXISTS `".NAMEDB."` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    
    if ($conexion->query($sql) === TRUE) {
        echo "Base de datos creada correctamente.";
    } else {
        echo "Error al crear la base de datos: " . $conexion->error;
    }

    $conexion->select_db(NAMEDB);

    //creamos las tablas de la base de datos, nos podemos ayudar de phpmyadmin
    
    $sql = "CREATE TABLE IF NOT EXISTS cantantes (
        idCantante INT AUTO_INCREMENT PRIMARY KEY,
        Nombre VARCHAR(255) NOT NULL,
        Apellidos VARCHAR(255) NOT NULL,
        Pais VARCHAR(255) NOT NULL
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
    $conexion->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS album (
        Titulo VARCHAR(255) NOT NULL,
        Genero VARCHAR(255) NOT NULL,
        idCantante INT NOT NULL,
        cancionesAlbum INT NOT NULL,
        duracionAlbum INT NOT NULL,
        FOREIGN KEY (idCantante) REFERENCES cantantes(idCantante)
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
    $conexion->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS usuarios (
        login VARCHAR(255) NOT NULL,
        nombre VARCHAR(255) NOT NULL,
        salt VARCHAR(512) NOT NULL,
        password VARCHAR(512) NOT NULL,
        rol ENUM('admin', 'user') NOT NULL,
        PRIMARY KEY (login)
    ) ENGINE = InnoDB;";
    $conexion->query($sql);
    $conexion->close();

}
?>
    
</body>
</html>