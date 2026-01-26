<?php

namespace App\Livewire\Setup\Products;

use App\Models\Attributes;
use App\Models\Product;
use App\Models\Variant;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ProductVariantsComponent extends Component
{
    public $editingVariantId = null;
    public $oldImages = [];
    public $rows = [];
    public $rowsEdit = [];
    public $variantName;
    public $selectedValue;
    public $type;
    public $product;
    public $sku, $price, $quantity, $options = [];

    protected $listeners = ['valueUpdated' => 'updatedSelectedValue'];

    use WithFileUploads;


    // public function updatedSelectedValue($value)
    // {
    //     dd($value);
    // }
    public function mount($productId)
    {
        $this->product = Product::findOrFail($productId);
    }

    public function addRow()
    {
        $this->rows[] =
         [
            'name' => '',
            'price' => '',
            'image' => null,
        ];
    }

    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
    }

    public function render()
    {
        $attributs = Attributes::query()->where('status', 1)->get();
        return view('livewire.setup.products.product-variants-component',[
            'variants' => $this->product->variants,
            'attributs' => $attributs,
        ])->extends('layouts.app');
    }


    public function addVariant()
{

    $this->validate([
        'variantName' => 'required|max:255',
        'rows' => 'required|array',
        'rows.*.arName' => 'required|string|max:255',
        'rows.*.enName' => 'required|string|max:255',
        'rows.*.price' => 'required|numeric',
        // 'rows.*.image' => 'image|max:2048',
    ]);

    $options = [];
    foreach ($this->rows as $index => $row) {
        $options[] = [
            'name'  => [
                'ar' => $row['arName'],
                'en' => $row['enName']
            ],
            'price' => $row['price'],
        ];
    }
    if ($this->editingVariantId) {
        // dd($this->type);
        $variant = Variant::findOrFail($this->editingVariantId);
        $variant->update([
            'attribute_id' => $this->variantName,
            'type' => $this->type,
            'options' => json_encode($options),
        ]);
    } else {
        Variant::create([
            'product_id' => $this->product->id,
            'attribute_id' => $this->variantName,
            'type' => $this->type,
            'options' => json_encode($options),
        ]);
    }

    $this->resetForm();
}



public function editVariant($variantId)
{

    $variant = Variant::findOrFail($variantId);
    $this->editingVariantId = $variant->id;
    $this->variantName = $variant->attribute_id;
    $this->type = $variant->type;
    $this->rows = json_decode($variant->options, true);
    foreach($this->rows as $index=>$val){
        $this->rows[$index]['arName'] = $val['name']['ar'];
        $this->rows[$index]['enName'] = $val['name']['en'];
    }
}

public function resetForm()
{
    $this->reset(['variantName', 'rows', 'editingVariantId', 'oldImages' ,'type']);
}

public function deleteVariant($variantId)
{
    Variant::findOrFail($variantId)->delete();

}

}
