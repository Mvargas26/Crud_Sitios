<?php
include('../App/conexionMySQL.php');

if (isset($_POST['contactBorrar'])) {
   $array = $_POST['contactBorrar'];

   $nombre = $array[0];
   $apellidos = $array[1];

   $query = "DELETE FROM `agenda` WHERE `nombre` = '$nombre' AND `apellidos` = '$apellidos';";
   $result = mysqli_query($connection,$query);

   if (!$result) {
    die('fallo Eliminar');
   }
   echo 'Eliminado';
}

?>