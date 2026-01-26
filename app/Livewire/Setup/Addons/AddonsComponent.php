<?php

namespace App\Livewire\Setup\Addons;

use App\Models\addons;
use Livewire\Component;
use Livewire\WithPagination;

class AddonsComponent extends Component
{
    use WithPagination;
    public  $add = false;
    public  $update = false;
    public  $numbers = 5;
    public  $arName;
    public  $enName;
    public  $price;
    // public  $search;
    protected $listeners = ['refresh-addons' => '$refresh'];
    public function edit($id){

        $addons = addons::query()->find($id);
        $this->arName = $addons->getTranslation('name','ar');
        $this->enName = $addons->getTranslation('name','en');
        $this->price = $addons->price;
        $this->add = true;
        $this->update = $addons->id;
    }

    public function update(){
        $this->validate([
            'arName' => 'required',
            'enName' => 'required',
            'price' => 'required',
        ]);
        $addons = addons::query()->find($this->update());
        $addons->update([
            'name' =>[
                'ar'=>$this->arName,
                'en'=>$this->enName,
                'price' => $this->price
            ]
            ]);
    }

    public function save(){
        $this->validate([
            'arName' => 'required',
            'enName' => 'required',
            'price' => 'required',
        ]);

        $save = addons::query()->create([
            'name' =>[
                'ar' =>$this->arName,
                'en' =>$this->enName,
            ],
            'price'=> $this->price,
            'status'=>0
        ]);

        $this->dispatch('message' , message: __('Done Save'));
        $this->dispatch('refresh-addons');
        $this->resetForm();
    }

    public function resetForm(){
        $this->reset([
            'add',
            'update',
            'arName',
            'enName',
            'price',
        ]);
    }

    public function pages_num()
    {
        $this->numbers;
        $this->resetPage();
    }

    public function render()
    {
        $addons = addons::query()
        // ->where('name','like',$this->search)
        ->paginate($this->numbers);
        return view('livewire.setup.addons.addons-component',['addons'=>$addons]);
    }
}
