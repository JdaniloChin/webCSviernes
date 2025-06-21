
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/estilo2.css">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Mi primera página PHP</h1>
    </header>
<?php
   $nombre="Maria";
   $a = 5; 
   $b = "5";
   $edad = 15;
   $edad2 = 35;
   $nota1 = 80;
   $nota2 = 65;
   $nota3 = 70.5;
   $nota4 = 40.2;
   $aprobado = true;
   echo "<h2>Bievenida $nombre a la clase de PHP</h2>";
    echo "<p>La variable \$nombre es de tipo " . gettype($nombre) . "</p>"; 
    
   echo "<section><h2>Variables</h2>"; 
    echo "<p>Se utiliza el <code>if (variable == variable)</code> para evaluar los valores</p>";
   if ($a == $b) {
        echo "<p>Los valores son iguales</p>";
   }
   else {
        echo "<p>Los valores son diferentes</p>";
   }
    echo "<p>Se utiliza el <code>if (variable === variable)</code> para evaluar los valores y los tipos</p>";
    if ($a === $b) {
          echo "<p>Los valores y tipos son iguales</p>";
    }
    else {
          echo "<p>Los valores o tipos son diferentes</p>";
    }   
   echo "</section>"; 
?> 
   
</body>
</html>