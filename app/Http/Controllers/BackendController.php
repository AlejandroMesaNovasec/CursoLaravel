<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class BackendController extends Controller
{

    private $names = [
        1 => ['name' => 'Alejo', 'age'=> 20],        
        2 => ['name' => 'Julian', 'age'=> 13],
        3 => ['name' => 'Rosman', 'age'=> 50],
    ];

    public function getAll(){
        return response() -> json($this->names);
    }

    public function get(int $id = 0){
        if ($id == 0){
            return ['name' => 'none', 'age'=> 0];
        }else if (isset($this -> names[$id])) {
           return response()->json([ $this->names[$id]]);
        }else{
            return response()-> json(['error' => "No se encontro ese id"],Response::HTTP_NOT_FOUND);
        }
    }


    public function create(Request $request){
        $person = [
            "id" => count($this->names)+1,
            "name"=> $request -> input("name"),
            "age"=> $request -> input("age"),

        ]; 

        $this ->names[$person["id"]] = $person;
        return response() -> json(["message"=> "Persona Creada", "person" => $person]
        ,Response::HTTP_CREATED);
    }

    public function update(Request $request ,int $id){

        if(isset($this->names[$id])){
            $this->names[$id]["name"] = $request ->input("name",$this->names[$id]["name"]);
            $this->names[$id]["age"] = $request ->input("age");
            return response()->json(["message" => "Persona  actualizada",
                                    "Persona " => $this->names[$id]]);
        }

        return response()->json(["error" => "Persona no ecnotrada"], Response::HTTP_NOT_FOUND);

    }

    public function delete (int $id){
        if (isset($this -> names[$id])) {
            unset($this -> names [$id]);
            return response()->json([ "message" => "Persona Eliminada"]);
        }

        return response()->json(["error" => "Persona no ecnotrada"], Response::HTTP_NOT_FOUND);
    }
}
