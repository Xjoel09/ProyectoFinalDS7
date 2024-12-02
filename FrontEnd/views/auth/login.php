<?php
session_start();
require_once __DIR__ . '/../../../BackEnd/config/conexion.php';
/*include 'conexion.php';*/

if(isset($_SESSION['codusuario']) && $_SESSION['nombre'] && $_SESSION['apellido']) {
    header("Location: /ProyectoFinalDS7/index.php?url=home");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = str_replace(" ", "", $_POST['Usuario'] ?? '');
    $contrasena = str_replace(" ","", $_POST['Contrasena'] ?? '');

    try {
        $stmt = $pdo->prepare("SELECT * FROM [Users] WHERE usuario = :usuario AND contrasena = :contrasena");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && $contrasena === $user['contrasena']) {//$user && password_verify($contrasena, $user['contrasena'])
            $_SESSION['codusuario'] = $user['codusuario'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['apellido'] = $user['apellido'];
            header('Location: /ProyectoFinalDS7/index.php?url=home');
            exit();
        } else {
            echo "Usuario o contraseña incorrectos";
        }
    } catch (PDOException $e) {
        echo "<p>Error en la base de datos: " . htmlspecialchars($e->getMessage()) . "</p>";
    }

    $stmt = $pdo->prepare("SELECT * FROM [Users] WHERE usuario = :usuario AND contrasena = :contrasena");
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && $contrasena === $user['contrasena']) {//$user && password_verify($contrasena, $user['contrasena'])
        $_SESSION['codusuario'] = $user['codusuario'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['apellido'] = $user['apellido'];
        header('Location: /ProyectoFinalDS7/index.php?url=home');
        exit();
    } else {
        echo "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeCommers</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Libre+Baskerville:wght@400;700&display=swap');

    *{
    font-family: 'Libre Baskerville', serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
    html{
    font-size: 62.5%;
}
    body{
    background: linear-gradient(rgba(0,0,0,0.4),rgba(0,0,0,0.4)) , url(../../assets/img/1.jpg);
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}


.container{
    box-shadow: rgba(0, 0, 0, 0.4) 0px 54px 55px, rgba(0, 0, 0, 0.3) 0px -12px 30px, rgba(0, 0, 0, 0.2) 0px 4px 6px, rgba(0, 0, 0, 0.5) 0px 12px 13px, rgba(0, 0, 0, 0.5) 0px -3px 5px;
    width: 350px;
    height: auto;
}

.container > h1{
    font-family: 'Cinzel', serif;
    font-size: 3.5rem;
    text-align: center;
    margin-top: 1rem;
    letter-spacing: 0.1em;
    color: #f5f5f5;
    border-bottom: 4px solid #f5f5f5;
}

.form{
    width: 100%;
    height: 100%;
    display:flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.form-group{
    background: transparent;
    padding: 1rem 3rem;
    display: inline-block;
    color: #9ababa;
}

.form-control{
    background: transparent;
    width: 220px;
    height: 35px;
    padding: 0.5rem 1.5rem;
    opacity: 0.9;
    margin-left: 1.2rem;
    color: #f5f5f5;
    border: none;
    outline: none;
    box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px;
}

.form-control::placeholder{
    color: #f5f5f5;
    font-size: 1.6rem;
}

.btn{
    font-family: 'Libre Baskerville', serif;
    padding: 0.8rem 1.8rem;
    margin-top: 1.5rem;
    background: transparent;
    border: none;
    font-size: 1.2rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    cursor: pointer;
    color: #f5f5f5;
    text-align: center;
    transition: all 0.4s ease;
    box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px;
    /*box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;*/
}

.btn:hover{
    background: #9ababa;
    color: #F5f5f5;
}

</style>
<body>
<div class="container">
    <h1>Login</h1>
    <form class="form" method="POST" action="">
    <div class="form-group">
    <i class="fa-solid fa-user fa-2x"></i>
        <input type="text" class="form-control" name="Usuario" placeholder="Usuario" required>
    </div>
    <div class="form-group">
    <i class="fa-solid fa-lock fa-flip fa-2x"></i>
        <input type="password" class="form-control" name="Contrasena" placeholder="Contraseña" required>
    </div>
        <button class="btn" type="submit" >Iniciar Sesion</button><br><br>
        <a class="btn"href="register.php" >¿No Tienes Cuenta?</a>
    </form>
    
</div>
    
</body>

</html>