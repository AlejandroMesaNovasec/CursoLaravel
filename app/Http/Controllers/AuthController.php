<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(UserRequest $request){
        $validatedData = $request->validated();
        $user  = User::create([
            'name' => $validatedData["name"],
            'email' => $validatedData["email"],
            'password' => $validatedData["password"]
        ]);
        return response()->json(["message" => "Usuario registrado correctamente"], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request){
        $validatedData = $request->validated();
        $credentials  = [
            'email' => $validatedData["email"],
            'password' => $validatedData["password"]
        ];

        try {
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(["message" => "Usuario o Contraseña invalida"], Response::HTTP_UNAUTHORIZED);
            }
           
        } catch (JWTException ) {
             return response()->json(["message" => "No se pudo generar el token"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        // return response()->json(["token" => $token]);
        return $this->respondWithToken($token);

    }

    protected function respondWithToken($token){
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function who(){
        $user = auth()->user();
        return response()->json($user);
    }

    public function logout(){
        try{
          $token = JWTAuth::getToken();
          JWTAuth::invalidate($token);
          return response()->json(["message" => "sesion cerrada correctamente","Usuario"=> $this->who()]);
        }catch(JWTException $e){
               return response()->json(["message" => "No se pudo cerrar la sesion , token no valido"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function refresh(){
        try {
            $token = JWTAuth::getToken();
            $newToken= auth()->refresh();
            JWTAuth::invalidate($token);
            return $this->respondWithToken($newToken);

        } catch (\Throwable $th) {
            return response()->json(["message" => "No se pudo refrescar el token"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
