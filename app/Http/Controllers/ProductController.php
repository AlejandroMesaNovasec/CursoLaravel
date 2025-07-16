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
        $validateData = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:category,id' 
        ], [
            'name.required' => "Eyy care monda necesitas porner un name"
        ]);

        $product = Product::create($validateData);

        return response()->json($product, Response::HTTP_OK); 
    }

    public function update(UpdateProductRequest $request, Product $product){
        // 1. Obtiene los datos que ya fueron validados por el Form Request.
        $validatedData = $request->validated();

        // 2. Actualiza el producto en la base de datos.
        $product->update($validatedData);

        // 3. Devuelve la respuesta JSON correcta con un código 200 OK.
        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'product' => $product->fresh() // Usamos fresh() para obtener el modelo actualizado
        ], Response::HTTP_OK);
    }

    public function destroy(Product $product){
            $product->delete();
            return response()->json(["message"=>"Producto Eliminado","Producto"=>$product]);
    }

}
