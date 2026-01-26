<?php

namespace App\Livewire\Setup\Market\Items;

use App\Models\Categories;
use App\Models\market_items;
use App\Models\market_section;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ItemComponent extends Component
{
    public $arName, $enName, $description, $category_id, $items, $itemsId, $logo, $itemsFetsh;
    public $variations = [];
    protected $listeners = ['loadItems'];
    use WithFileUploads;
    public function loadItems()
    {
        $this->reset(['arName', 'enName', 'description', 'category_id', 'itemsId', 'variations', 'logo', 'itemsFetsh']);
        $this->items = market_items::query()->with('category')->orderBy('id', 'desc')->get();
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
            'category_id' => 'required|exists:categories,id',
            'variations.*.name' => 'required|string',
            'variations.*.price' => 'required|numeric|min:0',
            'logo' => 'required|image|max:1024', // Validate image upload
        ]);

        $logoPath = $this->logo->store('MarketItems', 'public'); // Store image and get path

        $item = market_items::create([
            'category_id' => $this->category_id,
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
        $item = market_items::with('variations')->findOrFail($id);
        $this->itemsFetsh = $item;
        $this->arName = $item->getTranslation('name', 'ar');
        $this->enName = $item->getTranslation('name', 'ar');
        $this->description = $item->description;
        $this->category_id = $item->category_id;
        $this->variations = $item->variations->map(function ($variation) {
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
            'category_id' => 'required|exists:categories,id',
            'variations.*.name' => 'required|string',
            'variations.*.price' => 'required|numeric|min:0',
            'logo' => 'nullable|image|max:1024', // Optional image validation for update
        ]);

        $item = market_items::findOrFail($this->itemsId);

        $updateData = [
            'category_id' => $this->category_id,
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
        $item = market_items::findOrFail($id);

        // Delete image file if exists
        if ($item->logo && file_exists(storage_path('app/public/' . $item->logo))) {
            unlink(storage_path('app/public/' . $item->logo));
        }

        $item->variations()->delete(); // Delete related variations first
        $item->delete();
        $this->loadItems();
        $this->dispatch('message', message: __('Done Delete'));
    }


    public function render()
    {
        return view('livewire.setup.market.items.item-component', ['sections' => Categories::all(),])->extends('layouts.app');
    }
}
