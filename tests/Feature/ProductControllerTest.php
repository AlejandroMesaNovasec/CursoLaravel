<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

uses(RefreshDatabase::class);

beforeEach(function(){
    $this->withoutMiddleware(\Tymon\JWTAuth\Http\Middleware\Authenticate::class);
});

test('devuelve una lista paginada de 5 productos', function () {

    $user = User::factory()->create();

    $token = JWTAuth::fromUser($user);

    Product::factory()->count(10)->create();

    $response = $this->withHeader("Authorization", "Bearer $token")
        ->getJson('/api/products?per_page=5&page=1');

    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonCount(5)
        ->assertJsonStructure([
            '*' => ['id', 'name', 'price', 'description', 'category_id']
        ]);

});

test('Crear producto de manera correcta', function() {
    $category = Category::factory()->create();

    $productData = [
        'name' => 'Producto A',
        'price' => 99.99,
        'description' => 'Descripción de A',
        'category_id' => $category->id,
    ];

    $response = $this->postJson(route("products.store"), $productData);

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(['id', 'name', 'price', 'description', 'category_id'])
        ->assertJson($productData);

    $this->assertDatabaseHas('product', $productData);
});

test('Datos invalidos de producto al mandarse a crear', function () {
    $invalidProductData = [
        'name' => '',
        'price' => 'texto',
        'description' => str_repeat("a", 3000),
        'category_id' => 99985
    ];

    $response = $this->postJson(route("products.store"), $invalidProductData);

    // dd($response->json());
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['name', 'price', 'description', 'category_id']);
});

test('Actualizar un producto correctamente', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'category_id' => $category->id
    ]);

    $newCategory = Category::factory()->create();

    $data = [
        'name' => 'Producto actualizado',
        'price' => 199.99,
        'description' => 'Una descripción',
        'category_id' => $newCategory->id
    ];

    $response = $this->putJson(route("products.update", $product), $data);

    $response->assertStatus(Response::HTTP_OK)
        ->assertJson([
            'message' => 'Producto actualizado exitosamente',
            'product' => [
                'id' => $product->id,
                'name' => 'Producto actualizado',
                'price' => 199.99,
                'description' => 'Una descripción',
                'category_id' => $newCategory->id
            ]
        ]);

    $this->assertDatabaseHas("product", [
        'id' => $product->id,
        'name' => 'Producto actualizado',
        'price' => 199.99,
        'description' => 'Una descripción',
        'category_id' => $newCategory->id
    ]);
});

test('falla si category_id no existe en la base de datos', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $category->id]);

    $data = [
        'name' => 'Producto con categoria inválida',
        'price' => 175.75,
        'category_id' => 99999
    ];

    $response = $this->putJson(route('products.update', $product), $data);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['category_id']);
});

test('Elimina un producto correctamente', function () {
    $product = Product::factory()->create();

    $response = $this->deleteJson(route('products.destroy', $product));

    $response->assertStatus(Response::HTTP_OK)
    ->assertJsonFragment(['message' => 'Producto Eliminado']); 

    $this->assertSoftDeleted("product", ["id" => $product->id]);
});