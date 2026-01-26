<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\vendor_reservation;
use Illuminate\Http\Request;

class reservations extends Controller
{
    use ApiResponseTrait;


    public function index(){
        $reservations = vendor_reservation::all();
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required|email'
        ]);
        $reservations = new vendor_reservation();
        $reservations->name = $request->name;
        $reservations->phone = $request->phone;
        $reservations->email = $request->email;
        $reservations->address = $request->address ?? '';
        $reservations->info = $request->info ?? '';
        $reservations->save();
        return $this->apiRsponse($reservations, 'Reservation created successfully', 200);
    }
}
