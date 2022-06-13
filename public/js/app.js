(function(){
    const expresiones = {
        usuario: { regex :/^[áéíóúa-zA-Z1-9_-]+$/ ,mensajeError:"El campo usuario solo puede permitir letras, números y/o guiones"},
        contraseña: { 
            regex:{
                logitud : /^.{8,}$/,
                mayusculas : /[A-ZÁÉÍÓÚ]+/,
                minusculas : /[a-záéíóú]+/,
                caracter_especial : /[\_\@.\/#&\+\-°!"#$%&()=?¿¡\*¨¨\]\[:;]+/
            },
            mensajeError:"La contraseña debe tener como minimo 8 caracteres,una minuscula,una mayuscula y un caracter especial"
        },
        correo: {regex: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/ , mensajeError: "Ingrese un formato de correo valido"}
    }


    

    const mensajes = {
        inputVacio: "Este campo no puede estar vacio",
        selectVacio: "Se debe seleccionar algun valor de la lista"
    }

    let campos ={
        detalle_usuario: false,
        detalle_contraseña:false,
        detalle_correo:false,
        detalle_perfil:false
    }

    

    let table = $('#prueba').DataTable({
        "ajax":{
            "url" : "/tareas",
            "type" : "GET",
            "data" : function(d) {
                d.idUsuario = $("select[name=f_usuario]").val(),
                d.fechaInicio = $('input[name=f_fechainicio]').val(),
                d.fechaFin = $('input[name=f_fechafin]').val(),
                d.idPerfil = $("select[name=f_perfil]").val()
            },
            "error": function (request, status, error) {
                    swal({
                        title: "Error",
                        text: "No fue posible cargar la información de los usuarios",
                        icon: "error",
                    });
                
            }
        },
        "columns": [
            { "data": "usuario" },
            { "data": "contraseña" },
            { "data": "correo" },
            { "data": "fechaRegistro" },
            { "data": "perfil" },
            {
            render : function ( data, type, full, meta ) {
                 return `<button class="btn btn-success" id="btn_editar" data-id="${full.idUsuario}">Editar</button>
                 <button class="btn btn-danger" id="btn_eliminar" data-id="${full.idUsuario}">Eliminar</button>`;
                }
            }
        ],
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "_MENU_",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "",
            "sSearchPlaceholder": "Buscar",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        'order': [],

        /*"columns":[
            {data :"usuario"},
            {data: "contraseña"},
            {data: "correo"},
            {data: "fechaRegistro"},
            {data: "perfil"}
        ]
        */
        
    });
    function eliminarUsuario(idUsuario){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $("meta[name=csrf-token]").attr("content")
            },
            type:'DELETE',
            url: `tareas/${idUsuario}`,
            success: function(data){
                
                result =JSON.parse(data);
                console.log(result);
                if(result.error){
                    swal({
                        title: "Error",
                        text: "No fue posible eliminar el usuario",
                        icon: "error",
                    });
                }else {
                    swal( {
                        title: "Eliminar",
                        text: "Usuario eliminado satisfactoriamente",
                        icon: "success",
                        timer: 3000
                      });
                      table.ajax.reload();
                   
                }
            },
            error: function (request, status, error) {
                swal({
                    title: "Error",
                    text: "No fue posible eliminar el usuario",
                    icon: "error",
                });
                
            }
        });
    }
 
    function insertarUsuario(){
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $("meta[name=csrf-token]").attr("content")
                },
            type:'POST',
            url: "/tareas",
            data:{
               usuario : $("input[name=detalle_usuario]").val(),
               contraseña: $("input[name=detalle_contraseña]").val(),
               correo: $("input[name=detalle_correo]").val(),
               idPerfil: $("select[name=detalle_perfil]").val()
            },
            success: function(data){
                var result = JSON.parse(data);
                if(result.error){
                    console.error(result.mensaje);
                    $("#detalle").modal("hide");
                    swal({
                        title: "Error",
                        text: "No fue posible registrar el usuario",
                        icon: "error",
                    });
                    
                }else {
                    $("#detalle").modal("hide");
                    swal( {
                        title: "Registrar",
                        text: "Usuario registrado satisfactoriamente",
                        icon: "success",
                        timer: 3000
                      });
                    table.ajax.reload();
                }
            },
            error: function (request, status, error) {
                console.error(request);
                $("#detalle").modal("hide");
                swal({
                    title: "Error",
                    text: "No fue posible registrar el usuario",
                    icon: "error",
                });
                
                
            }
        });
    }
 
    function obtenerUsuario(idUsuario)
    {
     $.ajax({
        headers: {
            'X-CSRF-TOKEN': $("meta[name=csrf-token]").attr("content")
        },
         type:'GET',
         url: `tareas/${idUsuario}`,
         //data:{idUsuario : idUsuario},
         success: function(data){
             var result = JSON.parse(data);
             if(result.error){
                console.error(result.mensaje);
                swal({
                    title: "Error",
                    text: "No fue posible obtener el usuario",
                    icon: "error"
                });
                
             }
             else{
                //Limpiando  datos
                $("input[name=detalle_idusuario]").removeClass("is-valid is-invalid");
                $("input[name=detalle_usuario]").removeClass("is-valid is-invalid");
                $("input[name=detalle_contraseña]").removeClass("is-valid is-invalid");
                $("input[name=detalle_correo]").removeClass("is-valid is-invalid");
                $("select[name=detalle_perfil]").removeClass("is-valid is-invalid");
                $("input[name=detalle_contraseña]").attr("type","password");
                $("#togglePassword").attr("class","fa-solid fa-lock");

                $("input[name=detalle_idusuario]").val("");
                $("input[name=detalle_usuario]").val("");
                $("input[name=detalle_contraseña]").val("");
                $("input[name=detalle_correo]").val("");
                $("select[name=detalle_perfil] option[value=0]").remove();
                $("#detalle_titulo").text("Editar Usuario");

                //rellenado de datos
                $("input[name=detalle_idusuario]").val(result.idUsuario);
                $("input[name=detalle_usuario]").val(result.usuario);
                $("input[name=detalle_contraseña]").val(result.contraseña);
                $("input[name=detalle_correo]").val(result.correo);
                $("select[name=detalle_perfil]").val(result.idPerfil);
                $("#detalle").modal("show");
             }
         },
         error: function (request, status, error) {
            console.error(request);
            swal({
                title: "Error",
                text: "No fue posible obtener el usuario",
                icon: "error",
            });
            
         }
     });
 
    }
    function actualizarUsuario(idUsuario)
    {
        console.log(idUsuario);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $("meta[name=csrf-token]").attr("content")
            },
            type:'PATCH',
            url: `tareas/${idUsuario}`,
            data:{
               usuario : $("input[name=detalle_usuario]").val(),
               contraseña: $("input[name=detalle_contraseña]").val(),
               correo: $("input[name=detalle_correo]").val(),
               idPerfil: $("select[name=detalle_perfil]").val()
            },
            success: function(data){
                console.log(data);
                var result = JSON.parse(data);
                if(result.error){
                   
                    $("#detalle").modal("hide");
                    swal({
                        title: "Error",
                        text: "No fue posible actualizar el usuario",
                        icon: "error",
                    });
                }else {
                    $("#detalle").modal("hide");
                    swal( {
                        title: "Actualizar",
                        text: "Usuario actualizado satisfactoriamente",
                        icon: "success",
                        timer: 3000
                      });
                    table.ajax.reload();
                }
            },
            error: function (request, status, error) {
                console.error(request);
                $("#detalle").modal("hide");
                swal({
                    title: "Error",
                    text: "No fue posible actualizar el usuario",
                    icon: "error",
                });
                
            }
        });
    }



    function validarSelectVacio(input){
        if(input.val() ==0){
            let $mensajeError = input.siblings(".feedback");
            $mensajeError.text(mensajes.selectVacio);
            input.addClass("is-invalid");
            campos[input.attr("name")] = false;
        }
        else{
            input.removeClass("is-invalid");
            input.addClass("is-valid");
            campos[input.attr("name")] = true;
        }
    }
    function validarRegex(input,expresion){
        
        if(input.val() ==0){
            let $mensajeError = input.siblings(".feedback");
            $mensajeError.text(mensajes.inputVacio);
            input.addClass("is-invalid");
            campos[input.attr("name")] = false;
            
        }else if(!expresion.regex.test(input.val())){
    
            let $mensajeError = input.siblings(".feedback");;
            $mensajeError.text(expresion.mensajeError);
            input.addClass("is-invalid");
            campos[input.attr("name")] = false;
        }else{

            //console.log(input.attr("name"));
            input.removeClass("is-invalid");
            input.addClass("is-valid");
            campos[input.attr("name")] = true;
        }
    }
    function validarContraseña(input){
        if(input.val() ==0){
            let $mensajeError = input.siblings(".feedback");
            console.log($mensajeError); 
            $mensajeError.text(mensajes.inputVacio);
            input.addClass("is-invalid");
            campos[input.attr("name")] = false;
            
        }else if(!expresiones.contraseña.regex.logitud.test(input.val())){
            let $mensajeError = input.siblings(".feedback");
            console.log($mensajeError);
            $mensajeError.text(expresiones.contraseña.mensajeError);
            input.addClass("is-invalid");
            campos[input.attr("name")] = false;

        }else if(!expresiones.contraseña.regex.mayusculas.test(input.val())){
            let $mensajeError = input.siblings(".feedback");
            $mensajeError.text(expresiones.contraseña.mensajeError);
            input.addClass("is-invalid");
            campos[input.attr("name")] = false;
        }else if(!expresiones.contraseña.regex.minusculas.test(input.val())){
            let $mensajeError = input.siblings(".feedback");
            $mensajeError.text(expresiones.contraseña.regex.mensajeError);
            input.addClass("is-invalid");
            campos[input.attr("name")] = false;
        }else if(!expresiones.contraseña.regex.caracter_especial.test(input.val())){
            let $mensajeError = input.siblings(".feedback");
            $mensajeError.text(expresiones.contraseña.mensajeError);
            input.addClass("is-invalid");
            campos[input.attr("name")] = false;
        }else{
            
            input.removeClass("is-invalid");
            input.addClass("is-valid");
            campos[input.attr("name")] = true;
        }
    }

    function validarCampos(input){
        switch (input.attr("name")) {
            case "detalle_usuario":
                validarRegex(input,expresiones.usuario);
            break;
            case "detalle_contraseña":
               validarContraseña(input);
            break;
            case "detalle_correo":
               validarRegex(input,expresiones.correo);
            break;
                case "detalle_perfil":
                validarSelectVacio(input);
            break;
    
            default:
            break;
        }
    }


    $(".input-group-text").on("click",function(){
        const tipo = ($("input[name=detalle_contraseña]").attr("type") == "text") ? "password" : "text";
        const clase = ($("#togglePassword").attr("class") == "fa-solid fa-lock") ? "fa-solid fa-lock-open" : "fa-solid fa-lock";
        $("input[name=detalle_contraseña]").attr("type",tipo);
        $("#togglePassword").attr("class",clase);
        
    });
    $("select[name=f_usuario]").on("change", function() {
        table.ajax.reload();

        //Solicitud.handleFilterRecords(true);
    });
    $("select[name=f_perfil]").on("change", function() {
        table.ajax.reload();

        //Solicitud.handleFilterRecords(true);
    });
    $("input[name=f_fechainicio], input[name=f_fechafin]").on('blur', function() {
        table.ajax.reload();
    });

    $("input[name=detalle_usuario], input[name=detalle_contraseña], input[name=detalle_correo]").on("keyup", function(){
        validarCampos($(this));
    })
    $("input[name=detalle_usuario], input[name=detalle_contraseña], input[name=detalle_correo]").on("blur", function(){
        validarCampos($(this));
    })
    $("select[name=detalle_perfil]").on("change", function(){
        validarCampos($(this));
    })
    $("select[name=detalle_perfil]").on("blur", function(){
        validarCampos($(this));
    })



    $("#modal_detalle").click(function() {
        //eliminando datos de validacion
        $("input[name=detalle_idusuario]").removeClass("is-valid is-invalid");
        $("input[name=detalle_usuario]").removeClass("is-valid is-invalid");
        $("input[name=detalle_contraseña]").removeClass("is-valid is-invalid");
        $("input[name=detalle_correo]").removeClass("is-valid is-invalid");
        $("select[name=detalle_perfil]").removeClass("is-valid is-invalid");
        $("input[name=detalle_contraseña]").attr("type","password");
        $("#togglePassword").attr("class","fa-solid fa-lock");

        $("input[name=detalle_idusuario]").val("");
        $("input[name=detalle_usuario]").val("");
        $("input[name=detalle_contraseña]").val("");
        $("input[name=detalle_correo]").val("");
        ($("select[name=detalle_perfil] option[value=0]").length == 0) ? $("select[name=detalle_perfil]").prepend("<option value='0' selected>SELECIONE</option>") : $("select[name=detalle_perfil]").val("0");
        $("#detalle_titulo").text("Agregar Usuario");
        $("#detalle").modal("show");
    });


    $('#prueba tbody').on( 'click', '#btn_editar', function () {

        var idUsuario = $(this).data("id");
        obtenerUsuario(idUsuario);
        
   } );

   $('#prueba tbody').on( 'click', '#btn_eliminar', function () {
    var idUsuario = $(this).data("id");
        
        swal({
            title: "Eliminar",
            text: "¿Está seguro de eliminar al usuario?",
            icon: "warning",
            buttons: {
                cancel: 'Cancelar',
                delete: 'Sí'
            }
        }).then(function(isConfirm){
            if (isConfirm) {
                eliminarUsuario(idUsuario);
            }
        });
    });

   $("#detalle_accion").click(function() {
        if(campos.detalle_usuario && campos.detalle_contraseña && campos.detalle_correo && campos.detalle_perfil){
            
            if($("input[name=detalle_idusuario]").val()) {
                actualizarUsuario($("input[name=detalle_idusuario]").val())
            }else{
                insertarUsuario()
            }
        }
        else{
            //$('#prueba input:not([type=hidden]), #prueba select').each(
            $('#prueba input:not([type=hidden])').each(function(){
                validarCampos($(this));
            });
            $('#prueba select').each(function(){
                validarSelectVacio($(this));
            });        
        }
        
    });


})();