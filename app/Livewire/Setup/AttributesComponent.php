<?php

namespace App\Livewire\Setup;

use App\Models\Attributes;
use Livewire\Component;
use Livewire\WithPagination;

class AttributesComponent extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh-arrtibutes' => '$refresh'];
    public $addAtt = false;
    public $updateAtt = false;
    public $arName;
    public $enName;
    public $numbers = 5;

    public function reset_form()
    {
        $this->dispatch('refresh-arrtibutes');
        $this->reset(['arName','enName','addAtt', 'updateAtt']);
    }


    public function pages_num()
    {
        $this->numbers;
        $this->resetPage();
    }



    public function save()
    {
        $this->validate([
            'arName' => 'required',
            'enName' => 'required',
        ]);
        Attributes::query()->create([
            'name' =>
            [
                'ar' =>$this->arName,
                'en' =>$this->enName,
            ],
            'status'=>0
            ]);
            $this->dispatch('message',message: __('Done Save'));
            $this->reset_form();
    }//save


    public function edit($id){
        $attributes = Attributes::query()->find($id);
        $this->arName = $attributes->getTranslation('name','ar');
        $this->enName = $attributes->getTranslation('name','en');
        $this->addAtt = true;
        $this->updateAtt = $id;
    }

    public function update(){
        $this->validate([
            'arName' => 'required',
            'enName' => 'required',
        ]);
        $attributes = Attributes::query()->find( $this->updateAtt);
        $attributes->update([
            'name' => [
                'ar' =>$this->arName,
                'en' =>$this->enName,
            ]
        ]);
        if( $attributes){
            $this->dispatch('message',message: __('Done Successfully modified'));
            $this->reset_form();
        }

    }

    public function deleteConfirm($id)
    {
        $this->dispatch('swal:confirm', id: $id);
    }

    public function delete($id){
        Attributes::query()->find($id)->delete();
        $this->dispatch('message', message:  __('Your record has been deleted'));
        $this->reset_form();

    }
    public function render()
    {
        $attributes = Attributes::query()->paginate($this->numbers);
        return view('livewire.setup.attributes-component',['attributes'=>$attributes]);
    }
}
