<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QueriesController;
use App\Http\Middleware\CheckValueInHeader;
use App\Http\Middleware\LogRequest;
use App\Http\Middleware\UppercaseName;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get("/test",function(){
    return "El backend esta funcionamiento";
});

Route::get("/backend",[BackendController::class, "getAll"])
    ->middleware("checkvalue:4545,pato");
Route::get("/backend/{id?}",[BackendController::class, "get"]);

Route::post("/backend",[BackendController::class, "create"]);
Route::put("/backend/{id}",[BackendController::class, "update"]);
Route::delete("/backend",[BackendController::class, "delete"]);

Route::get("/query",[QueriesController::class, "get"]);
Route::get("/query/{id}",[QueriesController::class, "getbyid"]);
Route::get("/query/method/names",[QueriesController::class, "getNames"])
            ->middleware(LogRequest::class);
Route::get("/query/method/search/{name}/{price}",[QueriesController::class, "getSearch"]);
Route::get("/query/method/searchString/{value}",[QueriesController::class, "SearchString"]);


Route::post("/query/method/advancedSearch",[QueriesController::class, "advancedSearch"])
             ->middleware(LogRequest::class);

Route::get("/query/method/join",[QueriesController::class, "join"]);
Route::get("/query/method/groupby",[QueriesController::class, "groupby"]);

Route::apiResource("/products",ProductController::class)
        // ->middleware([CheckValueInHeader::class,UppercaseName::class,LogRequest::class, "jwt.auth"] );
        ->middleware([LogRequest::class, "jwt.auth"] );

Route::post('/register',[AuthController::class , 'register']);
Route::post('/login',[AuthController::class , 'login'])->name("login");

Route::middleware("jwt.auth")->group(function(){
    Route::get('/who',[AuthController::class , 'who']);
    Route::post('/logout',[AuthController::class , 'logout']);
    Route::post('/refresh',[AuthController::class , 'refresh']);
});

Route::get("/info/message",[InfoController::class, "message"]);
Route::get("/info/tax/{id}",[InfoController::class, "iva"]);
Route::get("/info/encrypt/{data}",[InfoController::class, "encrypt"]);
Route::get("/info/decrypt/{data}",[InfoController::class, "decrypt"]);
Route::get("/info/encryptEmail/{id}",[InfoController::class, "encryptEmail"]);
Route::get("/info/encryptEmail2/{id}",[InfoController::class, "encryptEmail2"]);


Route::get("/info/singleton",[InfoController::class, "singleton"]);

