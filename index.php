<?php




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio de prueba de autenticacion</title>
</head>
<body>
    <?php
    if(!file_exists("../config/config.php")){
        
        header("Location: ./install/install.php");
        
    }?>
</body>
</html>