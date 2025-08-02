$(document).ready(function() {
    $('#btnConsumir').on('click', function() {
        const vPokemon = prompt("Ingrese el nombre o el id del pokémon.","pikachu");
        

        if(!vPokemon){
            $('#resultados').html('<p class="text-danger"><strong>¡Debe ingresar el nombre o el id del pokémon!</strong></p>');
        }

        const url = `https://pokeapi.co/api/v2/pokemon/${vPokemon.toLowerCase()}`;

        $.get(url)
            .done(function(data) {
                const tipos = data.types.map(t => t.type.name.charAt(0).toUpperCase() + t.type.name.slice(1)).join(', ')
                const habilidades = data.abilities;
                const tablaHabilidades = [];
                let completados = 0;

                 $('#resultados').html(`
                        <div class="text-center">
                            <h5 class="text-success text-capitalize">${data.name}</h5>
                            <img src="${data.sprites.front_default}" alt="${data.name}" class="img-fluid mb-3" width="150">
                        </div>
                        <p><strong>Id de Pokémon:</strong> ${data.id}</p>
                        <p><strong>Tipo(s):</strong> ${tipos}</p>
                        <p id="mensaje">Cargando Habilidades...</p>
                    `);
                
                habilidades.forEach((hab, index) => {
                    $.get(hab.ability.url)
                        .done(function(detalle) {
                            const efecto = detalle.effect_entries.find(e => e.language.name === "es")?.effect ||
                                            detalle.effect_entries.find(e => e.language.name === "en")?.effect ||
                                            "Sin descripción disponible.";
                            
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
                                    <td class="text-danger">Error al obtener el efecto de la habilidad.</td>
                                </tr>`);
                        })
                        .always(function() {
                            completados ++;
                            if(completados === habilidades.length){
                                const tabla = `
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <td>#</td>
                                            <td>Nombre</td>
                                            <td>Efecto</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${tablaHabilidades.join("")}
                                    </tbody>
                                </table>`;

                                setTimeout(() =>{ 
                                    $('#resultados').append(tabla);
                                    $('#mensaje').html('<h5 class="text-success">Habilidades del pokémon</h5>');
                                }, 1500);
                                
                            } 
                        });
                });
            })
            .fail(function() {
                $('#resultados').html('<p class="text-danger"><strong>¡Pokémon no encontrado!</strong></p>');
            });

        
    });
});