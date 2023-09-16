<?php
include('../App/conexionMySQL.php');


if (isset($_POST['nombre'])) {
    
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $edad = $_POST['edad'];
    $altura = $_POST['altura'];
   $salvarID=explode("&",$_POST['salvarID']);

   $query = " UPDATE `agenda` SET `nombre` = '$nombre', `apellidos`= '$apellidos', `direccion`= '$direccion', `telefono`= '$telefono'
   , `edad`= '$edad', `altura`= '$altura' WHERE `nombre` = '$salvarID[0]' AND `apellidos` = '$salvarID[1]'; ";
    

    echo $query;
    $result = mysqli_query($connection,$query);

    if (!$result) {
       die('Fallo Insert');
    }

    echo 'Contacto Editado';
 };
?>
