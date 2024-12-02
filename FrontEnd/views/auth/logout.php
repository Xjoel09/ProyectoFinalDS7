<?php
//logout.php
session_start();

if (!empty($_SESSION)) {
    $_SESSION = [];
    header("Location: /ProyectoFinalDS7/index.php?url=home");
} else {
    header("Location: /ProyectoFinalDS7/index.php?url=home");
}