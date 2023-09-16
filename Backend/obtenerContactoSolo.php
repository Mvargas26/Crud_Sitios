<?php
include('../App/conexionMySQL.php');

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
?>