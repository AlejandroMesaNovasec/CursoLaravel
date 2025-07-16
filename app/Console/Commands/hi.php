<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class hi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hi {name : nombre de la persona } {--lastName=} {--uppercase}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Muestra un saludo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument("name");
        $lastName = $this->option("lastName");

        $uppercase = $this->option("uppercase");

        $message = "HOLA {$name} {$lastName}";
        if($uppercase){
            $message = strtoupper($message);
        }

        $this->info($message);
        //php artisan app:hi alejo --lastName=mesa --uppercase
    }
}
