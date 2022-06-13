<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usuario extends Model
{
    use HasFactory;

    public static function listar_usuarios(){
        return DB::select("CALL sp_ListarUsuario()");
    }

    public static function listar_data_usuario($idUsuario,$fechaInicio,$fechaFin,$idPerfil)
    {
        return DB::select("CALL sp_ListarDataUsuario(?,?,?,?)",[$idUsuario,$fechaInicio,$fechaFin,$idPerfil]);
    }

    public static function eliminar_usuario($idUsuario)
    {
        return DB::select("CALL sp_EliminarUsuario(?)",[$idUsuario]);
    }
    
    public static function obtener_usuario($idUsuario)
    {
        return DB::select("CALL sp_ObtenerUsuario(?)",[$idUsuario]);
    }
    public static function  actualizar_usuario($idUsuario,$usuario,$contraseña,$correo,$idPerfil)
    {
        return DB::select("CALL sp_ActualizarUsuario(?,?,?,?,?)",[$idUsuario,$usuario,$contraseña,$correo,$idPerfil]);
    }

    public static function  registrar_usuario($usuario,$contraseña,$correo,$idPerfil)
    {
        return DB::select("CALL sp_InsertarUsuario(?,?,?,?)",[$usuario,$contraseña,$correo,$idPerfil]);
    }


   
}


