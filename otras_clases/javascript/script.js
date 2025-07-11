function mostrarVariables() {
    let nombre = "Juan";
    var edad = 30;
    let ciudad = "Madrid";
    const PI = 3.14;

    console.log("Nombre: " + nombre);
    console.log("Edad: " + edad);
    console.log("Ciudad: " + ciudad);
    console.log("PI: " + PI);
}

function evaluarEdad(){
    let edad = 15
    if (edad >= 18) {
        console.log("Eres mayor de edad.");
    } else {
        console.log("Eres menor de edad.");
    }
}

document.getElementById("btnSaludo").addEventListener("click", function() {
   
    alert("¡Hola este es el evento click!");

    Swal.fire({
        title: '¡Hola!',
        text: 'Has hecho clic en el botón',
        icon: 'info',
        confirmButtonText: 'Aceptar'
    });
});