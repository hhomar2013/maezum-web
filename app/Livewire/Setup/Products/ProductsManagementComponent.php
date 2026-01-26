<?php

namespace App\Livewire\Setup\Products;

use App\Models\addons;
use Livewire\Attributes\Url;
use App\Models\Attributes;
use App\Models\Categories;
use App\Models\Product;
use App\Models\productAddons;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;
use PhpParser\Node\Scalar\String_;

class ProductsManagementComponent extends Component
{
    use WithPagination , WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh-products' => '$refresh'];
    protected $queryString = ['navigate'];
    public $arName,$enName, $description, $price,$categories_list,$product , $image;
    public $rows = [];
    public $numbers = 5;
    public $editProduct = null;
    public $addProduct = null;
    public $navigate = 'show.product';
    public $activeTab = 'tab1';
    public $show_addons = true;
    public $update_addons;
    public $addons_list;
    #[Url()]
    public  $search='';

    public function pages_num(){

        $this->resetForm();
        $this->resetPage();
        $this->numbers;

    }
    public function selectTab($tab)
    {

        $this->activeTab = $tab;

    }

    public function mount()
    {

        $this->navigate = request()->query('navigate', 'show.product');
        $productId = request()->query('product_id');
        if ($productId) {
            $this->product = Product::findOrFail($productId);
        }


    }

    public function navigateTo($page ,$productId = null)
    {
        $this->navigate = $page;
        $this->dispatch('update-url', [
            'navigate' => $page,
            'productId' => $productId,
        ]);
    }

    public function render()
    {
        $addons = addons::query()->where('status',1)->get();
        $products = Product::query()
        // ->where('name', 'like' ,'%' . $this->search . '%')
        // ->search($this->search)
        ->latest()->with(['variants','categories','addons'])->paginate($this->numbers);
        $categories = Categories::query()->where('status',1)->get();
        return view('livewire.setup.products.products-management-component',
        [
          'products'=> $products,
          'categories'=>$categories,
          'addons'=>$addons
        ]
        )->extends('layouts.app');

    }

    public function show($productId)
    {
        $this->editProduct = $productId;
        $this->product = Product::findOrFail($productId);
        $this->navigateTo('product-details', $productId);
    }



    // save product
    public function save(){
        $this->validate([
            'arName' => 'required',
            'enName' => 'required',
            'price' => 'required|numeric',
            'categories_list' => 'required',
            // 'description' => 'required',
        ]);

        Product::create([
            'name' => [
                'ar'=>$this->arName,
                'en'=>$this->enName,
            ],
            'description' => $this->description,
            'price' => $this->price,
            'tax_id'=>1,
            'category_id'=>$this->categories_list,
        ]);
        $this->dispatch('refreshDashboard');
        $this->navigateTo('show.product');
        $this->dispatch('message', message: __('Done Save'));
        $this->resetForm();

    }

    public function resetForm()
    {
        $this->reset(
            ['arName',
            'enName',
             'description',
             'price',
             'editProduct',
             'addProduct',
             'categories_list',
             'image'
            ]);
            $this->dispatch('refresh-products');
    }


    public function saveImage()
    {
        $this->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $image = $this->image->store('products', 'public');
        $this->product->image = $image;
        $this->product->save();
        $this->dispatch('message', message: __('Done Save'));
        $this->reset('image');

    }

    public function edit($productId)
    {
        $this->editProduct = $productId;
        $this->product = Product::findOrFail($productId);
        $this->arName = $this->product->getTranslation('name', 'ar');
        $this->enName = $this->product->getTranslation('name', 'en');
        $this->description = $this->product->description;
        $this->price = $this->product->price;
        $this->categories_list = $this->product->category_id;
        $this->navigateTo('add.product', $productId);
    }

    public function update()
    {
        $this->validate([
            'arName' => 'required',
            'enName' => 'required',
            'price' => 'required|numeric',
            'categories_list' => 'required',
        ]);

        $this->product->update([
            'name' => [
                'ar' => $this->arName,
                'en' => $this->enName,
            ],
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->categories_list,
        ]);

        $this->navigateTo('show.product');
        $this->dispatch('message', message: __('Done Update'));
        $this->resetForm();
    }

    public function save_addons(){
        $this->validate([
            'addons_list' =>'required',
        ]);

        productAddons::query()->create(
            [
            'product_id' => $this->product->id
            , 'addon_id' => $this->addons_list
            ]
        );

        $this->dispatch('message', message: __('Done Save'));
        // $this->reset('addons_list');

    }

    public function edit_addons($id)
    {
        $this->show_addons = true; //

        $addons = productAddons::query()->where('addon_id', $id)->first();
        $this->update_addons =  $addons->id;
        $this->addons_list = $addons->addon_id;
    }

    public function updateAddons(){
        $this->validate([
            'addons_list' =>'required|unique:product_addons,addon_id'
        ]);

        productAddons::where('id', $this->update_addons)->update(
            ['addon_id' => $this->addons_list]
        );

        $this->dispatch('message', message: __('Done Update'));
        $this->reset('update_addons');
    }
}
