<?php

namespace App\Business\Services;

use App\Business\Interfaces\MessageServiceInterfaces;

class HiUserService implements MessageServiceInterfaces{

    public function hi(){
        return "Hola Usuario Como estas?";
    }
}

