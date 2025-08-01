<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consumo de API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
<div class="container-fluid">
<div class="row min-vh-100">
  <?php include 'include/menu.php'; ?>
  <main class="col-md-9 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Consumo de API</h3>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>API de Ejemplo</h5>
                </div>
                <div class="card-body">
                    <p>Aquí puedes agregar el consumo de APIs externas.</p>
                    <button class="btn btn-primary" id="btnConsumir">Consumir API</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Resultados</h5>
                </div>
                <div class="card-body" id="resultados">
                    <p class="text-muted">Los resultados aparecerán aquí...</p>
                </div>
            </div>
        </div>
    </div>
</main>
</div>
</div>

<script>
$(document).ready(function() {
    $('#btnConsumir').on('click', function() {
        const vPokemon = prompt("Ingrese nombre o id del pokemon: ","pikachu");

        if(!vPokemon){
            $('#resultados').html('<p class="text-danger"><strong>Debe ingresar nombre o id del pokemon</strong></p>');
        }

        const url = `https://pokeapi.co/api/v2/pokemon/${vPokemon.toLowerCase()}`;

        $.get(url)
            .done(function(data){
                const tipos = data.types.map(t => t.type.name).join(', ');
                const habilidades = data.abilities;
                const tablaHabilidades = [];
                let completadas = 0;

                //Mostrar informacion pokemon mientras carga habilidades
                $('#resultados').html(`
                <div class="text-center">
                    <h5 class="text-success text-capitalize">${data.name}</h5>
                    <img src="${data.sprites.front_default}" alt="${data.name}" class="img-fluid mb-3" width="150">
                </div>
                <p><strong>ID:</strong> ${data.id}</p>
                <p><strong>Tipo(s):</strong> ${tipos}</p>
                <p id="mensaje">Cargando habilidades...</p>
                `);

                habilidades.forEach((hab, index) =>{
                    $.get(hab.ability.url)
                    .done(function(detalle) {
                        const efecto = detalle.effect_entries.find(e => e.language.name === "es")?.effect ||
                                       detalle.effect_entries.find(e => e.language.name === "en")?.effect || 
                                       "Sin descripcion disponible";
                        
                        tablaHabilidades.push(`
                        <tr>
                            <td>${index + 1}</td>
                            <td class="text-capitalize">${hab.ability.name}</td>
                            <td>${efecto}</td>
                        </tr>`);
                    })
                    .fail(function() {
                        tablaHabilidades.push(`
                        <tr>
                            <td>${index + 1}</td>
                            <td class="text-capitalize">${hab.ability.name}</td>
                            <td class="text-danger">Error al obtener efecto</td>
                        </tr>`);
                    })
                    .always(function () {
                        completadas++;

                        if (completadas === habilidades.length) {
                            const tabla = `
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Efecto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${tablaHabilidades.join("")}
                                </tbody>
                            </table>`;

                            $('#resultados').append(tabla);
                            $('#mensaje').html("");
                        }
                    });
                });
            })
            .fail(function() {
                $('#resultados').html('<p class="text-danger"><strong>Pokémon no encontrado</strong></p>');
            });

        
    });
});
</script>
</body>
</html>
