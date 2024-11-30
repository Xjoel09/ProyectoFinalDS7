

<?php
// Capturar la URL solicitada
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';

include 'header.php';
include 'nav.php';

switch ($url) {
    case 'home':
      $tituloPagina = 'Home'; 
        include 'FrontEnd/views/components/Home.php'; 
        break;
    case 'catalogo':
      $tituloPagina = 'Catalogo'; 
        include 'FrontEnd/views/components/Catalogo.php';
        break;
    case 'contacto':
      $tituloPagina = 'Contacto'; 
        include 'FrontEnd/views/components/Contacto.php';
        break;
    case 'cuenta':
      $tituloPagina = 'Cuenta'; 
        include 'FrontEnd/views/components/Cuenta.php';
        break;
    case 'carrito':
      $tituloPagina = 'Carrito De Compras'; 
        include 'FrontEnd/views/components/CarritoCompras.php';
        break;
    default:
        include 'FrontEnd/views/components/404.php'; 
        break;
}
include 'footer.php';
?>
