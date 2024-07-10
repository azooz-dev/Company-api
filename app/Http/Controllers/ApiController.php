<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Traits\StoreImage;

class ApiController extends Controller
{
    use ApiResponser, StoreImage;
    public function __construct()
    {
        
    }

}
