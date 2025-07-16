<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ProductInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:product-info {id : Id del producto a consultar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consulta la informacion de un producto en la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument("id");

        $product = Product::find($id);

        if(!$product){
            $this->error("Producto Invalido");
            return Command::FAILURE;
        }

        $this->info("Nombre: {$product->name}");
        $this->info("Description: {$product->Description}");
        $this->info("Precio: {$product->price}");
    }
}
