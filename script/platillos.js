$(document).ready(function(){

    $('#Agregar_Platillo_Form').submit(function(e){

        e.preventDefault();
        var nombre = $('#nombre_platillo').val();
        var precio = $('#precio').val();
        var cantidad = $('#cantidad').val();
        
        $.ajax({
            url: '../php/agregarPlatillo_Process.php',
            method: 'POST',

            data: {
                nombre: nombre,
                precio: precio,
                cantidad: cantidad,
            },

            success: function(response){
                console.log(response)
                alert("Platillo agregado correctamente!");
                window.location.href = "agregarPlatillo.php";
            }
        });
    });
});