<?php

namespace App\ExternalService;

use App\ExternalService\Events\DataGet;
use Illuminate\Support\Facades\Http;

class ApiService{
    protected string $url;

    public function __construct($url)
    {
        $this->url= $url;
    }

    public function getData(){
        $response = Http::get($this->url);

        if($response->successful()){

            event(new DataGet($response->json()));
            return $response->json();
        }
        return ["eror" => "Ocurrio un error al obtener la informacion"];

    }

}