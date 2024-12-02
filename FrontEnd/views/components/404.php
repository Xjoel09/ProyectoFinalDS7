<?php
// 404.php - Manejador de errores generales

// Configuración de encabezados para error 404
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");

// Página de error personalizada
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página No Encontrada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f4f4f4;
        }
        .error-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h1 {
            color: #d9534f;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Error 404 - Página No Encontrada</h1>
        <p>Lo sentimos, la página que buscas no existe o ha sido movida.</p>
        <p><a href="/">Volver a la página principal</a></p>
    </div>
</body>
</html>
<?php
// Log opcional de errores
error_log("Página no encontrada: " . $_SERVER['REQUEST_URI']);
exit;
?>