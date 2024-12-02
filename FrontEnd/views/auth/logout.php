<?php
session_start();

if (!empty($_SESSION)) {
    $_SESSION = [];
    header("Location: /ProyectoFinal/index.php?url=home");
} else {
    header("Location: /ProyectoFinal/index.php?url=home");
}