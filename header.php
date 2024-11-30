<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloPagina ?? 'E-commerce'; ?></title>
    <link href="FrontEnd/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="FrontEnd/assets/bootstrap/js/jquery.js"></script>
    <script src="FrontEnd/assets/bootstrap/js/bootstrap.min.js"></script>
    
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Source+Serif+Pro:wght@300;400;600;700&family=Ubuntu:ital,wght@0,400;0,500;1,700&display=swap');


*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root{
    font-size: 62.5;
    line-height: 1.7rem;
}


body{
font-family: 'Source Serif Pro', serif;
}

.navbar{
    display: flex;
    align-items: center;
    padding: 1.8rem;
}

.logo h1{
    color: #000;
    font-size: 2.2rem;
}

.logo span{
    color: #ff523b;
    font-size: 2.2rem;
}

nav{
    flex: 1;
    text-align: right;
}

nav ul{
    display: inline-block;
    list-style: none;
}

nav ul li a:hover{
    color: #ff523b;
    transition: 0.3s ease-in-out;
}

nav ul li{
    display: inline-block;
    margin-right: 2rem;
}

.barra{
    text-decoration: none;
    font-size: 1.8rem;
    color: #555;
}


.container{
    max-width: 1300px;
    margin: auto;
    padding-left: 2.5rem;
    padding-right: 2.5rem;
}

.header{
    background: radial-gradient(#fff,#ffd6d6);
}


</style>
<body>
    
