<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\areas;

class AreaController extends Controller
{
    public function index()
    {
        $areas = areas::all();
        return view('map', compact('areas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'coordinates' => 'required|json',
        ]);

        areas::create($validated);

        return back()->with('success', 'تم حفظ المنطقة بنجاح');
    }
}
