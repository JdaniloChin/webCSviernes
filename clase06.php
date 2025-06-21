
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

    ?>
    <code><pre>if ($a == $b) {
        echo "<p>Los valores son iguales</p>";
   }
   else {
        echo "<p>Los valores son diferentes</p>";
   }</pre></code>

   <?php
   if ($a == $b) {
        echo "<p>Los valores son iguales</p>";
   }
   else {
        echo "<p>Los valores son diferentes</p>";
   }
   ?>
    <p>Se utiliza el <code>if (variable === variable)</code> para evaluar los valores y los tipos</p>
    <code><pre>if ($a === $b) {
          echo "<p>Los valores y tipos son iguales</p>";
    }
    else {
          echo "<p>Los valores o tipos son diferentes</p>";
    } </pre></code>

    <?php
    if ($a === $b) {
          echo "<p>Los valores y tipos son iguales</p>";
    }
    else {
          echo "<p>Los valores o tipos son diferentes</p>";
    }   
   echo "</section>"; 
   $suma = 0;
   $arr_notas = array($nota1, $nota2, $nota3, $nota4); 
    for ($i = 0; $i < count($arr_notas); $i++){
        $suma += $arr_notas[$i];
    } 

    $promedio = $suma / count($arr_notas);

    if($promedio < 70){
        $aprobado = false;
    }

    echo "<section><h2>Condicionales</h2>";
    echo "<p>El promedio de las notas es: $promedio</p>";
    if($aprobado){
        echo "<p>¡Felicidades! has aprobado</p>";
    } else {
        echo "<p>Lo siento, no has aprobado</p>";
    }

    switch($promedio){
        case $promedio >= 90:
            echo "<p>Excelente</p>";
            break;
        case $promedio >= 80:
            echo "<p>Muy bien</p>";
            break;     
        case $promedio >= 70:
            echo "<p>Bien</p>";
            break;  
        default:
            echo "<p>Necesitas mejorar</p>";
            break;  
    }
    echo "</section>";
    
    echo "<section><h2>Ciclos</h2>";
    $contador = 0;
    foreach ($arr_notas as $nota) {
        $contador++;
        if($nota < 70) {
        echo "<p>Nota$contador reprobada: $nota</p>";
        }else {
        echo "<p>Nota$contador aprobada: $nota</p>";
        }
    }
    echo "</section>";
    echo "<section><h2>Operadores logicos</h2>";

    if($edad >= 18 || $edad2 >= 18){
        echo "<p>Al menos una persona es mayor de edad</p>";
    } else {
        echo "<p>Ninguna persona es mayor de edad</p>";
    }

    if($edad >= 18 && $edad2 >= 18){
        echo "<p>Ambas personas son mayores de edad</p>";
    } else {
        echo "<p>Al menos una persona no es mayor de edad</p>";
    }

    if(!$aprobado){
        echo "<p>Lo siento, debe repetir el curso.</p>";
    } else {
        echo "<p>¡Felicidades! Nos vemos en el siguiente curso.</p>";
    }
?> 
   
</body>
</html>