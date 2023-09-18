<?php
include('../App/conexionMySQL.php');
include('../App/config.php');
include('../App/conexionSQLServer.php');

$array=$_POST['contactBorrar'];
$configSQLServer = getConfigSQLServer();

if ($array[2] === 'SQLServer') {
   try {
      $conexion = new conexionSQLServer($configSQLServer);
      $pdo = $conexion->getConnection();
      $nombre = $array[0];
      $apellidos = $array[1];

      $query = "DELETE FROM agenda WHERE nombre = '$nombre' AND apellidos = '$apellidos';";

      $stmt = $pdo->query($query);

      if ($stmt) {
         $jason = array();
         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $jason[] = $row;
         }

         $jsonString = json_encode($jason);
         echo $jsonString;
      } else {
         die('Fallo Consulta en SQL Server');
      }
   } catch (\Throwable $e) {
      die('Error de conexión a SQL Server: ' . $e->getMessage());
   }
} else {

   if (isset($_POST['contactBorrar'])) {
      $array = $_POST['contactBorrar'];

      $nombre = $array[0];
      $apellidos = $array[1];

      $query = "DELETE FROM `agenda` WHERE `nombre` = '$nombre' AND `apellidos` = '$apellidos';";
      $result = mysqli_query($connection, $query);

      if (!$result) {
         die('fallo Eliminar');
      }
      echo 'Eliminado';
   }
}
?>