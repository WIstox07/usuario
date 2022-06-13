@extends("base")
@section("container")
<div class="container">
        <h1>Boostrap</h1>
        <div class="row">
            <div class="col-2">
                <label class="form-label">Usuario</label>
                <select class="form-select" name="f_usuario">
                    <option selected value="0">USUARIO</option>

                    @foreach ($usuarios as $usuario)
                        <option value="{{$usuario->idUsuario}}">{{$usuario->usuario}}</option>
                    @endforeach

                </select>
            </div>
            <div class="col-2">
                <label class="form-label">Perfil</label>
                <select class="form-select" name="f_perfil">
                <option selected value="0">PERFIL</option>
                @foreach ($perfiles as $perfil)
                        <option value="{{$perfil->idPerfil}}">{{$perfil->nombre}}</option>
                @endforeach
                </select>
            </div>
            <div class="col-2">
                <label class="form-label">Fecha Inicio</label>
                <input type="date" class="form-control" name="f_fechainicio" value="{{ date('Y-05-01') }}">
            </div>
            <div class="col-2">
                <label class="form-label">Fecha Fin</label>
                <input type="date" class="form-control" name="f_fechafin" value="{{ date('Y-m-d') }}"> 
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-2">
                <button type="button" class="btn btn-primary text-light" id="modal_detalle"><i class="fa-solid fa-plus"></i> Nuevo</button>
            </div>
        </div>

        <table id="prueba" class="table table-bordered">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Correo</th>
                <th>Fecha Registro</th>
                <th>Perfil</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Correo</th>
                <th>Fecha Registro</th>
                <th>Perfil</th>
                <th>Acciones</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection

