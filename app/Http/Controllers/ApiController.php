<?php

namespace App\Http\Controllers;

use App\ExternalService\ApiService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    

    public function __construct(protected ApiService $apiService){
        
    }

    public function get(){
        $data = $this->apiService->getData();
        return response()->json($data);
    }
}
