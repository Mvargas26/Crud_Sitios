<?php
include('../App/conexionMySQL.php');

$query = "SELECT * FROM `agenda`;";

$result = mysqli_query($connection,$query);

if (!$result) {
    die('Fallo Consulta '.mysqli_error($connection));
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
echo $jsonString;
?>