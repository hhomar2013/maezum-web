<?php

namespace App\Livewire\Setup\Offers;

use App\Helpers\PaginationHelper;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Offers;
use Livewire\WithFileUploads;

class OffersComponent extends Component
{
    use WithPagination ,WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $add =false;
    public $update = false;
    public $delete = false;
    public $numbers = 5;
    public $offer;
    public $startingNumber = 1;
    protected $listeners = ['refresh-offers' => '$refresh'];
    public $arName , $enName , $arDescription , $enDescription , $startDate,$expiryDate , $discount , $image ;


    public function reserForm()
    {
        $this->dispatch('refresh-offers');
        $this->add = false;
        $this->update = false;
        $this->delete = false;
        $this->arName = '';
        $this->enName = '';
        $this->arDescription = '';
        $this->enDescription = '';
        $this->startDate= '';
        $this->expiryDate = '';
        $this->discount = '';
        $this->image = '';
    }
    public function pages_num()
    {
        $this->numbers;
        $this->resetPage();
        $this->reserForm();
    }

    public function edit($id)
    {
        $offer = Offers::query()->find($id);
        $this->arName = $offer->getTranslation('name','ar');
        $this->enName = $offer->getTranslation('name','en');
        $this->arDescription = $offer->getTranslation('description','ar');
        $this->enDescription = $offer->getTranslation('description','en');
        $this->startDate = $offer->start_date;
        $this->expiryDate = $offer->end_date;
        $this->discount = $offer->discount;
        $this->offer = $offer;
        $this->add = true;
        $this->update = $offer->id;
    }
    public function save()
    {
        $this->validate([
            'arName' => 'required',
            'enName' => 'required',
            'arDescription' => 'required',
            'enDescription' => 'required',
            'startDate' => 'required|date',
            'expiryDate' => 'required|date',
            'discount' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


      $imageName = $this->image->store('offers', 'public');

        $offer = Offers::query()->create([
            'name' => [
                'ar' => $this->arName,
                'en' => $this->enName,
            ],
            'description' => [
                'ar' => $this->arDescription,
                'en' => $this->enDescription,
            ],
            'start_date' => $this->startDate,
            'end_date' => $this->expiryDate,
            'discount' => $this->discount,
            'image' => $imageName,
            'status' => 0,
        ]);

        $this->dispatch('message' , message: __('Done Save'));
        $this->reserForm();
    }

    public function updateOffers()
    {

        $this->validate([
            'arName' => 'required',
            'enName' => 'required',
            'arDescription' => 'required',
            'enDescription' => 'required',
            'startDate' => 'required|date',
            'expiryDate' => 'required|date',
            'discount' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = null;
        if($this->image){
            $imageName = $this->image->store('offers', 'public');
        }
        Offers::query()->where('id',$this->offer)->update([
            'name' => [
                'ar' => $this->arName,
                'en' => $this->enName,
            ],
            'description' => [
                'ar' => $this->arDescription,
                'en' => $this->enDescription,
            ],
           'start_date' => $this->startDate,
           'end_date' => $this->expiryDate,
            'discount' => $this->discount,
        ]);
        if($imageName){
            Offers::query()->where('id', $this->offer)->update(['image' => $imageName]);
        }
        $this->dispatch('message', message: __('Done Update'));
        $this->reserForm();
        $this->update = false;
        $this->add = false;

    }

    public function showDelete($id)
    {
        $this->delete = true;
        $offer = Offers::query()->find($id);
        $this->offer =  $offer;
    }
    public function deleteOffers($offer)
    {
       $delete = Offers::query()->find($offer);
       $delete->delete();
       if($delete){
            $this->dispatch('message', message: __('Your record has been deleted'));
            $this->reserForm();
        //    $this->dispatch('message', message: __('Done Delete'));
       }else {
           $this->dispatch('message', message: __('Failed Delete'));
       }


    }

    public function render()
    {
        $offers = Offers::query()->paginate($this->numbers);
        return view('livewire.setup.offers.offers-component' )
        ->with('offers', $offers)
        ->extends('layouts.app');
    }
}
