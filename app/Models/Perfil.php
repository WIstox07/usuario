<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Perfil extends Model
{
    use HasFactory;


    public static function listar_perfiles(){
        return DB::select("CALL sp_ListarPerfil()");
    }
}
