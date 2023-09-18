<?php
include('../App/conexionMySQL.php');
include('../App/config.php');
include('../App/conexionSQLServer.php');

    
    if (isset($_POST['conexionElegida']) && $_POST['conexionElegida'] === 'SQLServer') {
        //echo($_POST['conexionElegida']);
        $configSQLServer = getConfigSQLServer(); 
     
       try {

           $conexion = new conexionSQLServer($configSQLServer);
           $pdo = $conexion->getConnection();
           
           if (isset($_POST['contacEnFormulario'])) {
            $array = $_POST['contacEnFormulario'];
        
            $nombre = $array[0];
            $apellidos = $array[1];    
    
            $query ="SELECT nombre,apellidos,direccion,telefono,edad,altura FROM agenda WHERE nombre = '$nombre' AND apellidos = '$apellidos';";
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
        if (isset($_POST['contacEnFormulario'])) {

            $array = $_POST['contacEnFormulario'];
        
            $nombre = $array[0];
            $apellidos = $array[1];
        
            $query ="SELECT nombre,apellidos,direccion,telefono,edad,altura FROM `agenda` WHERE `nombre` = '$nombre' AND `apellidos` = '$apellidos';";
            $result = mysqli_query($connection, $query);
        
            if (!$result) {
                die('fallo cONSULTAR sOLO');
            }
            $jason = array();
            while ($row = mysqli_fetch_array($result)) {
                $jason[] = array(
                    'nombre' => $row['nombre'],
                    'apellidos' => $row['apellidos'],
                    'direccion' => $row['direccion'],
                    'telefono' => $row['telefono'],
                    'edad' => $row['edad'],
                    'altura' => $row['altura'],
                );
            }
            $jsonString = json_encode($jason[0]);//solo codifica el primer elemento
            echo $jsonString;
        }


     }

?>