<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index(Request $request){
        $perPage = $request-> query("per_page",10);
        $page = $request-> query("page",0);
        $offset = $page * $perPage;

        $products = Product::skip($offset)->take($perPage)->get();

        return response()->json($products);
    }

    public function store(Request $request){
        try {
            $validateData= $request->validate([
            'name'=> 'required|string|max:150',
            'description' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:category,id'
            
            ],[
                'name.required'=> "Eyy care monda necesitas porner un name"
            ]);
            
            
            ;
            $product = Product::create($validateData);
            return response()->json($product);

        } catch (ValidationException $e) {
            return response()->json(["error"=>$e->errors()],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }

    public function update(UpdateProductRequest $request, Product $product){
        try{
            $validateData= $request->validate();
            $product->update($validateData);
            return response()->json(["message"=>"Producto actualizado correctamente","Producto"=>$product],Response::HTTP_NOT_FOUND);

        }catch (Exception $e) {
            return response()->json(["error"=>$e],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Product $product){
        $product->delete();
        return response()->json(["message"=>"Producto Eliminado","Producto"=>$product]);
    }

}
