<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://kit.fontawesome.com/988e31fec1.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css" type="text/css" rel="stylesheet">

    <title>Prueba</title>
    <style>
        .swal-button:focus {
            box-shadow: none;
        }
        .input-group-text{
            cursor:pointer;
        }
    </style>


</head>
<body>
    @section("prueba")
    @show
    @yield("container")



    <div class="modal fade" id="detalle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="detalle_titulo"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3"  id="prueba" novalidate" autocomplete="off">
                    <input type="hidden" name="detalle_idusuario">

                    <div class="col-12">
                        <label for="detalle_usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" name="detalle_usuario" required >
                        <div class="invalid-feedback feedback">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="detalle_contraseña" class="form-label">Contraseña  </label>
                        <div class="input-group mb-3">
                            
                            <input type="password" class="form-control" name="detalle_contraseña" required>
                            <span class="input-group-text"><i class="fa-solid fa-lock" id="togglePassword" ></i></span>
                            <div class="invalid-feedback feedback"></div>
                        </div>
                        

                    </div>
                    <div class="col-12">
                        <label for="detalle_correo" class="form-label">Correo</label>
                        <input type="text" class="form-control" name="detalle_correo" required>
                        <div class="invalid-feedback feedback">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="detalle_perfil" class="form-label">Perfil</label>
                            <select class="form-select" name="detalle_perfil">
                                <option selected value="0">PERFIL</option>
                                @foreach ($perfiles as $perfil)
                                    <option value="{{$perfil->idPerfil}}">{{$perfil->nombre}}</option>
                                @endforeach
                            </select>
                        <div class="invalid-feedback feedback">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button class="btn btn-success" type="submit" id="detalle_accion">Guardar</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
   
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.js" type="text/javascript" ></script>   
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>




</body>
</html>