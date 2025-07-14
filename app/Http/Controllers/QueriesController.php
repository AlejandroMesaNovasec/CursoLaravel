<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

use function Laravel\Prompts\select;

class QueriesController extends Controller
{
    public function get(){
        $products = Product::all();
        return response()->json($products);
    }

    public function getById(int $id = 0){
        $product = Product::find($id);
        if (!($product)) {
            return response()->json(["message"=>"Producto no encotrado"],Response::HTTP_NOT_FOUND);
        }
            return response()->json($product);
    }

    public function getNames(){
        $productsNames = Product::select("name")
                                    ->orderBy("name","desc")
                                    ->get();
        return response()->json($productsNames);
    }

    public function getSearch(string $name , int $price){
        $products = Product::where("name", $name)
                ->where("price" , ">" , $price)
                ->select("name","price")
                ->get();

        return response()->json($products);

    }

    public function SearchString(string $value){
        $products = Product::WHERE("description", "like" ,"%{$value}%")
                    ->orwhere("name" ,"like " ,"%{$value}%")
                    ->get();
        return response()->json($products);

    }

    public function advancedSearch(Request $request){
        $products = Product::where(function($query) use($request){
            if ($request->input("name")) {
                $query->where("name" ,"like" ,"%{$request->input("name")}%");
            }
        })
        ->where(function($query) use($request){
            if ($request->input("description")) {
                $query->where("description" ,"like" ,"%{$request->input("description")}%");
            }
        })
        ->where(function($query) use($request){
            if ($request->input("price")) {
                $query->where("price" ,">" ,$request->input("price"));
            }
        })
        ->get();
        
        return response()->json($products);

    }

    public function join(){
         $products = Product::join("category" ,"product.category_id" ,"=" , "category.id")
            ->select("product.*" , "category.name as nombre de la categoria")
            ->get();
        
        return response()->json($products);

    }

    public function groupby(){
        $result = Product::join("category" ,"product.category_id" ,"=" , "category.id")
            ->select("category.name as nombre de la categoria" , DB::raw("count(product.id) as total"))
            ->groupby("category.name")
            ->get();

        return response()->json($result);
    }
}
