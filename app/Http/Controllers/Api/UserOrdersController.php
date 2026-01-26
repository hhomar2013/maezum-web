<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserOrdersController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        return $this->apiRsponse('UserData' ,'User Orders Geted' ,200);
    }
}
