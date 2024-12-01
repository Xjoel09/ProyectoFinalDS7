<?php
try {
    // Configuración de la conexión
    $server = "tcp:desarrolloproyectos.database.windows.net,1433";
    $database = "procyfinal";
    $username = "desarrolladores";
    $password = "m936x9soHJ8A962EW8x6";

    // Crear la instancia de PDO
    $pdo = new PDO("sqlsrv:server=$server;Database=$database", $username, $password);

    // Configurar el modo de error de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //echo "Conexión exitosa a SQL Server usando PDO.";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

