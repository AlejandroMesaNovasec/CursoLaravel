<?php

namespace App\Business\Services;

use App\Business\Interfaces\MessageServiceInterfaces;

class HiService implements MessageServiceInterfaces{

    public function hi(){
        return "Hola mundo";
    }
}

