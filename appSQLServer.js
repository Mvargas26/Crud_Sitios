$(document).ready(function () {
    $('#contactoResult').hide();//oculta la tarjeta contactoResult cuando inicia
    listarContactos(); //ejecutamos el cargar contactos

    // *** VARIABLES ***
    let deseaEditar = false;
    let conexionElegida = 'SQLServer';  
    //funcion para que en el formulario de buscar verifique x cada letra coincidencias
    $("#search").on("input", function(e) {
        var searchTerm = $(this).val().trim();
    
        // Verifica si el campo de búsqueda está vacío
        if (searchTerm === "") {
          $("#contactoResult").hide(); // Oculta el contenedor si está vacío
        } else {
            if ($('#search').val())    // si hay un valor en #search hace la busqueda
            {
                let resultadoBusqueda = $('#search').val();
                $.ajax({
                    url: 'App/buscar.php',
                    type: 'POST',
                    data: { resultadoBusqueda },
                    success: function (response) {
                        //console.log(response);
                        let contactos = JSON.parse(response);
                        let template = '';
                        contactos.forEach(contacto => {
                            template += `<li>${contacto.nombre}</li>`
                        });
    
                        //selecciono el elemento #contactoResult que es un car y lo lleno con esta plantilla
                        $('#contactoResult').html(template);
                        $('#contactoResult').show();
                    }
                })
            }
        }
      });

    //Capturando evento submit del formulario agendaForm
    $('#agendaForm').submit(function (e) {
        const datosPost = {
            nombre: $('#nombre').val(),
            apellidos: $('#apellidos').val(),
            direccion: $('#direccion').val(),
            telefono: $('#telefono').val(),
            edad: $('#edad').val(),
            altura: $('#altura').val(),

            salvarID:$('#salvarID').val() //viene del input oculto en el form
        };
        //si deseaEditar es false url=Backend/agregarContacto.php sino url=Backend/editarContacto.php
        let url = deseaEditar === false ? 'Backend/agregarContacto.php': 'Backend/editarContacto.php';
        // if (deseaEditar) {
        //     url = 'Backend/editarContacto.php';
        // }else{
        //     url ='Backend/agregarContacto.php';
        // }
        
        $.post(url, datosPost,
            function (response) {
                listarContactos();// una ves que inserto, cargamos la tabla grande d enuevo
                $('#agendaForm').trigger('reset');//reseta el formulario, sea borra los campos
            }
        );


        e.preventDefault();//evita que al hacer submir del formulario agendaForm recargue la pag
    });//fn submit form

    function listarContactos() {
        let conexionElegida = 'SQLServer';  
        $.ajax({
            type: "GET",
            url: "Backend/listarContactos.php",
            data:{conexionElegida},
            success: function (response) {
                //console.log(response);
                let contactos = JSON.parse(response);
                let template = '';
                contactos.forEach(contacto => {
                    //estas comillas `` alt+ teclaParDeEnter me permite crear un string de varias lineas
                    template += ` 
                    <tr contactNombre="${contacto.nombre}" contactApellido="${contacto.apellidos}">
                    <td>
                    <a href="#" class="editContactoItem">${contacto.nombre}</a>
                    </td>
                    <td>${contacto.apellidos}</td>
                    <td>${contacto.direccion}</td>
                    <td>${contacto.telefono}</td>
                    <td>${contacto.edad}</td>
                    <td>${contacto.altura}</td>
                    <td>
                    <button class="btnEliminarContacto btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                    </tr>`
                });

                //selecciono el elemento #contactoResult que es un card y lo lleno con esta plantilla
                $('#tbAgenda').html(template);
                $('#tbAgenda').show();
            }
        });
    };//fn listarContactos

    $(document).on('click', '.btnEliminarContacto', function () {
        if (confirm('Esta seguro que desea eliminar este Contacto?')) {
            let elemento = $(this)[0].parentElement.parentElement;
            $nombreBorrar = $(elemento).attr('contactNombre');
            $apellidoBorrar = $(elemento).attr('contactApellido');
            let contactBorrar = [$nombreBorrar, $apellidoBorrar];

            $.post('Backend/borrarContacto.php',
                { contactBorrar },
                function (response) {
                    listarContactos();
                }
            );

        }
    });//fin click a eliminar

    $(document).on('click', '.editContactoItem', function () {
        let elemento = $(this)[0].parentElement.parentElement;
        $nombreEditar = $(elemento).attr('contactNombre');
        $apellidoEditar = $(elemento).attr('contactApellido');
        let contacEnFormulario = [$nombreEditar, $apellidoEditar];

            $.post('Backend/obtenerContactoSolo.php',
                {contacEnFormulario},
                function (response) {
                    const contactoEditar = JSON.parse(response);
                    $('#nombre').val(contactoEditar.nombre);
                    $('#apellidos').val(contactoEditar.apellidos);
                    $('#direccion').val(contactoEditar.direccion);
                    $('#telefono').val(contactoEditar.telefono);
                    $('#edad').val(contactoEditar.edad);
                    $('#altura').val(contactoEditar.altura);

                    $('#salvarID').val(contactoEditar.nombre+'&'+contactoEditar.apellidos);//viene del input oculto en el form
                    
                    deseaEditar=true; //ya dio clic en un editar
                }
            );
    });//fin click a editar

    $('#btnLimpiar').click(function () { 
        $('#agendaForm').trigger('reset');//reseta el formulario, sea borra los campos
        deseaEditar = false;
    });
});//fin document.ready