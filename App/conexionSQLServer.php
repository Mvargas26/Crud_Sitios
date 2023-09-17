<?php
require_once 'config.php';

try {
    $connection = new PDO("sqlsrv:server={$config['server']};database={$config['database']}", $config['username'], $config['password']);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a SQL Server";
} catch (PDOException $e) {
    echo "Error de conexión a SQL Server: " . $e->getMessage();
}
?>
