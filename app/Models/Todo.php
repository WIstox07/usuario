<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Todo extends Model
{
    use HasFactory;

    public static function obtener_usuarios(){
        DB::select("CALL sp_insertarTodo(?)");
    }
}
