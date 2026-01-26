<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class FirebaseController extends Controller
{

    public function __invoke()
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ . 'maezum-a41d5-firebase-adminsdk-fbsvc-0d41279be0.json')
            ->withDatabaseUri(
                'https://maezum-a41d5-default-rtdb.firebaseio.com/'
            );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
