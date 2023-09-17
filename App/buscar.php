<?php
include('../App/conexionMySQL.php');
include('../App/config.php');
include('../App/conexionSQLServer.php');

 $resultadoBusqueda =$_POST['resultadoBusqueda'];

if (isset($_POST['param2']) && $_POST['param2'] === 'SQLServer') {
  
   $configSQLServer = getConfigSQLServer(); 

  try {
      $conexion = new conexionSQLServer($configSQLServer);
      $pdo = $conexion->getConnection();
      $query = "SELECT * FROM agenda WHERE nombre LIKE '$resultadoBusqueda%'"; // Consulta de ejemplo en SQL Server
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
  } catch (Exception $e) {
      die('Error de conexión a SQL Server: ' . $e->getMessage());
  }
} else {
  
  if (!empty($resultadoBusqueda)) {

       $query = "SELECT * FROM agenda WHERE nombre LIKE '$resultadoBusqueda%'";
       $result = mysqli_query($connection,$query);
    
       if (!$result) {
        die('query Error '.mysqli_error($connection));
       }
    
       $jason=array();
       while ($row=mysqli_fetch_array($result)) {
         $jason[]=array(
             'nombre'=>$row['nombre'],
             'apellidos'=>$row['apellidos'],
             'direccion'=>$row['direccion'],
             'telefono'=>$row['telefono'],
             'edad'=>$row['edad'],
             'altura'=>$row['altura']
         );
       }
       
       $jsonString=json_encode($jason);
       echo $jsonString; //retorna el stringJson
     }
}

?>