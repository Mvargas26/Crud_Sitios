<?php
include('../App/conexionMySQL.php');

$resultadoBusqueda =$_POST['resultadoBusqueda'];

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

?>