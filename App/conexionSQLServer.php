<?php
require_once 'config.php';

class conexionSQLServer {
    private $conexionSQLSrv;

    public function __construct($config) {
        try {
            $this->conexionSQLSrv = new PDO("sqlsrv:server={$config['server']};database={$config['database']}", $config['username'], $config['password']);
            $this->conexionSQLSrv->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Error de conexión a SQL Server: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conexionSQLSrv;
    }
}
?>
