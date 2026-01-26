<?php

namespace App\Livewire\Setup\Areas;

use App\Models\Area;
use App\Models\areas;
use Livewire\Component;
use Livewire\Attributes\On;

class AreaComponent extends Component
{
    public $name;
    public string $coordinates = '';
    public $areas = [];

    public function mount()
    {
        $this->areas = areas::all();
    }

    public function saveArea()
    {

        // Validate the input data
        $this->validate([
            'name' => 'required|string|max:255',
            'coordinates' => 'required|string',
        ]);

        areas::create([
            'name' => $this->name,
            'coordinates' => $this->coordinates,
        ]);

        $this->reset(['name', 'coordinates']);
        $this->areas = areas::all();
        $this->dispatch('areaSaved');
        $this->dispatch('message',message: __('Done Save'));

    }





        #[On('coordinatesUpdated')]
        public function updateCoordinates($data)
        {
        // في حالة تم إرسال كائن يحتوي على coordinates كنص
        if (isset($data['coordinates']) && is_string($data['coordinates'])) {
            $this->coordinates = $data['coordinates'];
        } elseif (is_string($data)) {
            $this->coordinates = $data; // fallback
        } else {
            $this->coordinates = json_encode($data); // worst case fallback
        }
        }




    public function render()
    {
        return view('livewire.setup.areas.area-component')
            ->extends('layouts.app');
    }
}
