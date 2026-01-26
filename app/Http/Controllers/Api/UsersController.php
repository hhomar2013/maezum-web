<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $user = User::query()->get();
        return $this->apiRsponse($user,__('Data received'),200);
    }
}
