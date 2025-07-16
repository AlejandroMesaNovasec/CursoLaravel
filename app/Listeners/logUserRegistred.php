<?php

namespace App\Listeners;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Events\UserRegistred;
use Exception;

class logUserRegistred implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    use InteractsWithQueue;
    public $tries =3;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistred $event): void
    {
        // $this->release(5);
        // throw new Exception("Ocurrio un error  {$this->attempts()}");
        Log::info("Nuevo usuario registrado", ["id" => $event->user->id]);
    }

    public function failed(UserRegistred $event,$exception){

        Log::critical("El registro en el log de usuario {$event->user["id"]}");

    }
    
}
