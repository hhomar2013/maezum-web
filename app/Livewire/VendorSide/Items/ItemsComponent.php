<?php

namespace App\Livewire\VendorSide\Items;

use App\Models\items;
use App\Models\sections;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ItemsComponent extends Component
{

    public $arName,$enName, $description, $section_id, $items ,$itemsId,$logo,$itemsFetsh;
    public $variations = [];
    protected $listeners = ['loadItems'];
    use WithFileUploads;
    public function loadItems(){
        $this->reset(['arName','enName','description','section_id','itemsId','variations','logo','itemsFetsh']);
        $this->items = items::where('vendor_id', Auth::id())->get();
    }
    public function mount()
    {
        $this->loadItems();
        $this->variations = [['name' => '', 'price' => '']];
    }
    public function addVariation()
    {
        $this->variations[] = ['name' => '', 'price' => ''];
    }

    public function removeVariation($index)
    {
        unset($this->variations[$index]);
        $this->variations = array_values($this->variations);
    }

    public function save()
    {
        $this->validate([
            'arName' => 'required',
            'enName' => 'required',
            'section_id' => 'required|exists:sections,id',
            'variations.*.name' => 'required|string',
            'variations.*.price' => 'required|numeric|min:0',
            'logo' => 'required|image|max:1024', // Validate image upload
        ]);

        $logoPath = $this->logo->store('items', 'public'); // Store image and get path

        $item = items::create([
            'vendor_id' => Auth::id(),
            'section_id' => $this->section_id,
            'name' =>
            [
                'ar' => $this->arName,
                'en' => $this->enName
            ],
            'description' => $this->description,
            'image' => $logoPath, // Save image path to database
        ]);

        foreach ($this->variations as $var) {
            $item->variations()->create($var);
        }

        $this->loadItems();
        $this->variations = [['name' => '', 'price' => '']];
        $this->reset('logo'); // Reset logo field
        $this->dispatch('message', message: __('Done Save'));
    }
        public function edit($id)
    {
        $this->itemsId = $id;
        $item = items::with('variations')->findOrFail($id);
        $this->itemsFetsh = $item;
        $this->arName = $item->getTranslation('name','ar');
        $this->enName = $item->getTranslation('name','ar');
        $this->description = $item->description;
        $this->section_id = $item->section_id;
        $this->variations = $item->variations->map(function($variation) {
            return [
                'name' => $variation->name,
                'price' => $variation->price
            ];
        })->toArray();

    }

    public function update()
    {
        $this->validate([
            'arName' => 'required',
            'enName' => 'required',
            'section_id' => 'required|exists:sections,id',
            'variations.*.name' => 'required|string',
            'variations.*.price' => 'required|numeric|min:0',
            'logo' => 'nullable|image|max:1024', // Optional image validation for update
        ]);

        $item = items::findOrFail($this->itemsId);

        $updateData = [
            'section_id' => $this->section_id,
            'name' => [
                'ar' => $this->arName,
                'en' => $this->enName
            ],
            'description' => $this->description,
        ];

        // Handle logo update if new image is uploaded
        if ($this->logo) {
            // Delete old image if exists
            if ($item->logo && file_exists(storage_path('app/public/' . $item->logo))) {
                unlink(storage_path('app/public/' . $item->logo));
            }

            $logoPath = $this->logo->store('items', 'public');
            $updateData['image'] = $logoPath;
        }

        $item->update($updateData);

        // Delete existing variations
        $item->variations()->delete();

        // Create new variations
        foreach ($this->variations as $var) {
            $item->variations()->create($var);
        }

        $this->loadItems();
        $this->variations = [['name' => '', 'price' => '']];
        $this->reset('logo'); // Reset logo field
        $this->dispatch('message', message: __('Done Update'));
    }

    public function delete($id)
    {
        $item = items::findOrFail($id);

        // Delete image file if exists
        if ($item->logo && file_exists(storage_path('app/public/' . $item->logo))) {
            unlink(storage_path('app/public/' . $item->logo));
        }

        $item->variations()->delete(); // Delete related variations first
        $item->delete();
        $this->dispatch('message', message: __('Done Delete'));
    }


    public function render()
    {
        return view('livewire.vendor-side.items.items-component',['sections' => sections::where('vendor_id', Auth::id())->get(),])->extends('layouts.app');
    }
}
