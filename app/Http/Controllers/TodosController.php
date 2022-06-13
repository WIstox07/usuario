<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Todo;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use League\Config\Exception\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class TodosController extends Controller
{
    public function return_json($mensaje){
       //$opciones = ["Content-Type" => "application/json","Charset" => "utf-8"];
       $opciones = ["Content-Type" => "text/html;charset=UTF-8","Charset" => "utf-8"];
       
        return response()->json($mensaje,200,$opciones,JSON_UNESCAPED_UNICODE);
    }
    //
    /**
     * index para mostrar todos los todos
     * store para guardar 
     * update para actualizar
     * destroy para eliminar
     * edit para mostrar el formulario de edicion
     */

    public function index(){
    
        $usuarios = Usuario::listar_usuarios();
        $perfiles = Perfil::listar_perfiles();

        //return view("base",["data" => $data]);
        return view("usuarios.container", compact(["usuarios", "perfiles"]));



    }
    public function guardar(Request $request){
        try
        {
            $rules = [
                "usuario" => "required",
                "contraseña" => ["required", Password::min(8)
                                ->numbers()
                                ->symbols()
                                ->mixedCase()
                                ->letters()
                                //->uncompromised()
                             ],
                "correo" => "required|email",
                "idPerfil" => "required|numeric"
            ];
            
            $validator = Validator::make($request->input(),$rules);
            
            if($validator->fails()){
            //if($validator->stopOnFirstFailure()->fails()){
                return $this->return_json( ["error" =>1, "mensaje" => $validator->errors()->all()]); 
            }
            
            $usuario = $request->usuario;
            $contraseña = $request->contraseña;
            $correo = $request->correo;
            $idPerfil = $request->idPerfil;

            Usuario::registrar_usuario($usuario,$contraseña,$correo,$idPerfil);
            return $this->return_json( ["error" =>0, "mensaje" => "Todo registrado satisfactoriamente"]);
        }
        catch(Exception  $ex){
            return $this->return_json( ["error" =>1, "mensaje" => $ex->getMessage()]);
        }
        


        /*
        $todo = new Todo;
        $todo->title = $request->title;
        $todo->save();
        */

    }

    public function listar(Request $request){
      
        try{
            
            $rules = [
                "idUsuario" => "required|numeric",
                "fechaInicio" => "required|date_format:Y-m-d",
                "fechaFin" => "required|date_format:Y-m-d|after_or_equal:fechaInicio",
                "idPerfil" => "required|numeric"
            ];

            
            $validator = Validator::make($request->input(),$rules);

            if($validator->fails()){
                return $this->return_json( ["error" =>1, "mensaje" => $validator->errors()->all()]); 
            }
             

            $idUsuario = $request->idUsuario;
            $fechaInicio = $request->fechaInicio;
            $fechaFin = $request->fechaFin;
            $idPerfil = $request->idPerfil;

            $todos = Usuario::listar_data_usuario($idUsuario,$fechaInicio,$fechaFin,$idPerfil);
            return $this->return_json(["data" =>$todos]);
            //return view("todos.index",["todos" => $todos]);
        }
        catch(Exception $ex)
        {
            return $this->return_json( ["error" =>1, "mensaje" => $ex->getMessage()]);
        }

    }

    public function obtener($id){
     
        try{
            $rules = [
                "idUsuario" => "required|numeric"
            ];
            $validator = Validator::make(["idUsuario" => $id],$rules);
            if($validator->fails()){
                return $this->return_json( ["error" =>1, "mensaje" => $validator->errors()->all()]); 
            }

            $todo = Usuario::obtener_usuario($id);
            return ($todo) ?  $this->return_json($todo[0]) : $this->return_json( ["error" =>1, "mensaje" => "No se encontraron datos"]);
           // return view("todos.show",["todo" => $todo[0]]);
        }
        catch(Exception $ex)
        {
            return $this->return_json( ["error" =>1, "mensaje" => $ex->getMessage()]);
        }


    }

    public function actualizar(Request $request ,$id){
        try{
            $request->merge(["idUsuario" => $id]);
            $rules = [
                "idUsuario" => "required|numeric",
                "usuario" => "required",
                "contraseña" => ["required", Password::min(8)
                                ->numbers()
                                ->symbols()
                                ->mixedCase()
                                ->letters()
                                //->uncompromised()
                             ],
                "correo" => "required|email",
                "idPerfil" => "required|numeric"
            ];
            
            $validator = Validator::make($request->input(),$rules);
            
            if($validator->fails()){
                return $this->return_json( ["error" =>1, "mensaje" => $validator->errors()->all()]); 
            }

            $usuario = $request->usuario;
            $contraseña = $request->contraseña;
            $correo = $request->correo;
            $idPerfl = $request->idPerfil;
            Usuario::actualizar_usuario($id,$usuario,$contraseña,$correo,$idPerfl);
            return $this->return_json( ["error" =>0, "mensaje" => "Todo actualizado satisfactoriamente"]);
            //return redirect()->route("todos")->with("success" ,"Tarea actualizada");
        }
        catch(Exception $ex)
        {
            return $this->return_json( ["error" =>1, "mensaje" => $ex->getMessage()]);
        }



/*
        $todo = Todo::find($id);
        $todo->title = $request->title;
        $todo->save();
        return redirect()->route("todos")->with("success" ,"Tarea actualizada");
        */

    }

    public function eliminar($id){

        
        //$todo = Todo::find($id);
        //$todo->delete();
        try{
            $rules = [
                "idUsuario" => "required|numeric"
            ];
            $validator = Validator::make(["idUsuario" => $id],$rules);
            if($validator->fails()){
                return $this->return_json( ["error" =>1, "mensaje" => $validator->errors()->all()]); 
            }
            Usuario::eliminar_usuario($id);
            return $this->return_json( ["error" =>0, "mensaje" => "Todo eliminado satisfactoriamente"]);
        }
        catch(Exception $ex){
            return $this->return_json( ["error" =>1, "mensaje" => $ex->getMessage()]);
           
        }
    }
}
