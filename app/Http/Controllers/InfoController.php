<?php

namespace App\Http\Controllers;

use App\Business\Interfaces\MessageServiceInterfaces;
use App\Business\Services\HiService;
use App\Business\Services\ProductService;
use App\Business\Services\EncryptService;
use App\Business\Services\SingletonService;
use App\Business\Services\UserService;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InfoController extends Controller
{
    public function __construct(protected ProductService $productService,
    protected EncryptService $encryptService,
    protected UserService $userService,
    protected MessageServiceInterfaces $hiService,
    protected SingletonService $singletonService){
        
    }
    public function message(){
        return response()->json($this->hiService->hi());
    }

    public function iva (int $id){
        $product=Product::find($id);
        if (!$product) {
            return response()->json(["message" => "Producto no encontrado"], Response::HTTP_NOT_FOUND);
        }

        $priceWithIVA = $this->productService->calculateIVA($product->price);
        return response()->json(["Precio" => $product->price , "PrecioIva" => $priceWithIVA]);
    }

    public function encrypt($data){
        return response()->json($this->encryptService->encrypt($data));
    }

    public function decrypt($data){
        return response()->json($this->encryptService->decrypt($data));
    }

    public function encryptEmail(int $id){
        $emailEncrypted = $this->userService->encryptEmail($id);
        return response()->json($emailEncrypted);
    }

    public function encryptEmail2(int $id){
        $userService = app()->make(UserService::class);
        $emailEncrypted = $userService->encryptEmail($id);
        return response()->json($emailEncrypted);
    }

    public function singleton(SingletonService $singletonService2){
        return response()->json($this->singletonService->value." - ". $singletonService2->value);
    }

}
