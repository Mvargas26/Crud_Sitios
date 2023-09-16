<?php
include('../App/conexionMySQL.php');

if (isset($_POST['nombre'])) {
    
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $edad = $_POST['edad'];
    $altura = $_POST['altura'];


    $query = "INSERT INTO `agenda` (`nombre`, `apellidos`, `direccion`, `telefono`, `edad`, `altura`)
     VALUES ('$nombre', '$apellidos', '$direccion', '$telefono', '$edad', '$altura');";

    echo $query;
    $result = mysqli_query($connection,$query);

    if (!$result) {
       die('Fallo Insert');
    }

    echo 'Contacto Agregado';
};
?>