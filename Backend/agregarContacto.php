<?php
include('../App/conexionMySQL.php');
include('../App/config.php');
include('../App/conexionSQLServer.php');

if (isset($_POST['conexionElegida']) && $_POST['conexionElegida'] === 'SQLServer') {

    $configSQLServer = getConfigSQLServer(); 
 
   try {
       $conexion = new conexionSQLServer($configSQLServer);
       $pdo = $conexion->getConnection();
       if (isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $edad = $_POST['edad'];
        $altura = $_POST['altura'];


        $query = "INSERT INTO agenda (nombre, apellidos, direccion, telefono, edad, altura)
        VALUES ('$nombre', '$apellidos', '$direccion',$telefono, $edad, $altura);";
        //echo($query);
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

       }
   } catch (Exception $e) {
       die('Error de conexión a SQL Server: ' . $e->getMessage());
   }
 }else{
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
 }
?>