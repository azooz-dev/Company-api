<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Traits\StoreImage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class ApiController extends Controller
{
    use ApiResponser, StoreImage;
    public function __construct()
    {
        
    }

    protected function allowedAdminActions() {
        if (Gate::denies('allow-admin')) {
            return throw new AuthorizationException('You must be an administrator to execute this action');
        }
    }

}
