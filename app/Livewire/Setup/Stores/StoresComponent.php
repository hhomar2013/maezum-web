<?php

namespace App\Livewire\Setup\Stores;

use App\Models\Stores;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class StoresComponent extends Component
{
    protected $listeners = ['refresh-stores' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    public $add = false;
    public $update = false;
    use WithPagination, WithFileUploads;
    public $numbers = 5;
    public $arName;
    public $enName;
    public $logo;
    public $desc;

    public function back()
    {
        $this->add = false;
        $this->update = false;
        $this->reset_form();
    }
    public function page_num($number)
    {
        $this->numbers = $number;
        $this->resetPage();
    }

    public function reset_form()
    {
        $this->reset(['arName', 'enName', 'logo', 'desc', 'add', 'update']);
    }

    public function save()
    {
        $this->validate([
            'arName' => 'required',
            'enName' => 'required',
            'logo' => 'required',
            'desc' => 'required',
        ]);
        $store = new Stores();
        $store->setTranslation('name', 'ar', $this->arName);
        $store->setTranslation('name', 'en', $this->enName);
        $store->setTranslation('description', 'ar', $this->desc);
        $store->logo = $this->logo->store('stores', 'public');
        $store->save();
        $this->dispatch('refresh-stores');
        $this->dispatch('message',message: __('Done Save'));
        $this->reset_form();
    } //save

    public function edit($id)
    {

        $this->add=true;
        $this->update = $id;
        $store = Stores::find($id);
        $this->arName = $store->getTranslation('name', 'ar');
        $this->enName = $store->getTranslation('name', 'en');
        $this->desc = $store->getTranslation('description', 'ar');
        if ($store->logo) {
            $this->logo = $store->logo;
        }

    } //edit
    public function updateStores()
    {

        $this->validate([
            'arName' =>'required',
            'enName' =>'required',

        ]);

        $store = Stores::find($this->update);
        // dd($this->logo.'-'.$store->logo);
        $store->setTranslation('name', 'ar', $this->arName);
        $store->setTranslation('name', 'en', $this->enName);
        $store->setTranslation('description', 'ar', $this->desc);

        if ($this->logo != $store->logo) {
            $store->logo = $this->logo->store('stores', 'public');
        }
        $store->save();
        $this->dispatch('refresh-stores');
        $this->dispatch('message',message: __('Done Update'));
        $this->reset_form();
    }
    public function render()
    {
        $stores = Stores::query()->paginate($this->numbers);
        return view('livewire.setup.stores.stores-component')->with('stores', $stores);
    }
}
