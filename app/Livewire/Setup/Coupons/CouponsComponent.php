<?php

namespace App\Livewire\Setup\Coupons;

use App\Models\coupons;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CouponsComponent extends Component
{
    use WithPagination ,WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $add =false;
    public $update = false;
    public $numbers;
    public $coupon;
    protected $listeners = ['refreshCoupons', '$refresh'];
    public $code ,$discount,$valid_from,$valid_to,$image,$description,$usage_limit,$arDescription,$enDescription;

    public function resetForm(){
        $this->add = false;
        $this->update = false;
        $this->code = '';
        $this->discount = '';
        $this->valid_from = '';
        $this->valid_to = '';
        $this->image = '';
        $this->description = '';
        $this->usage_limit = '';
        $this->arDescription = '';
        $this->enDescription = '';
        $this->resetPage();
        $this->add = false;
        $this->update = false;
        $this->dispatch('refreshCoupons');
    }

    public function paginateNumber(){
        $this->resetPage();
    }

    public function back(){

        $this->resetForm();
    }
    public function mount(){
        $this->add = false;
        $this->update = false;
        $this->dispatch('refreshCoupons');


    }

    public function save()
    {
         $this->validate([
            'code'=>'required',
            'discount'=>'required|numeric',
            'valid_from'=>'required',
            'valid_to'=>'required',
            'image'=>'required|image|max:2048',
            'arDescription'=>'required',
            'enDescription'=>'required',
            'usage_limit'=>'required|numeric'
        ]);
        $imageName = $this->image->store('coupons', 'public');
        coupons::create([
            'code'=>$this->code,
            'discount'=>$this->discount,
            'valid_from'=>$this->valid_from,
            'valid_to'=>$this->valid_to,
            'image'=>$imageName,
            'description'=>[
                'ar'=>$this->arDescription,
                'en'=>$this->enDescription,
            ],
            'usage_limit'=>$this->usage_limit,
            'used'=>0
        ]);
            $this->dispatch('message', __('Done Save'));
            $this->resetForm();
    }


    public function edit($couponId)
    {
        $this->add = true;
        $this->update = $couponId;
        $coupon = coupons::find($couponId);
        $this->coupon = $coupon;
        $this->code = $coupon->code;
        $this->discount = $coupon->discount;
        $this->valid_from = $coupon->valid_from;
        $this->valid_to = $coupon->valid_to;
        $this->image = $coupon->image;
        $this->usage_limit = $coupon->usage_limit;
        $this->arDescription = $coupon->getTranslation('description','ar');
        $this->enDescription = $coupon->getTranslation('description','en');
    }

    public function updateCoupon(){
        $this->validate([
            'code' => 'required',
            'discount' => 'required|numeric',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'arDescription' => 'required',
            'enDescription' => 'required',
            'usage_limit' => 'required|numeric',
        ]);

        $coupon = coupons::find($this->update);

        if ($this->image && is_object($this->image)) {
            $this->validate(['image' => 'image|max:2048']);
            $imageName = $this->image->store('coupons', 'public');
            $coupon->image = $imageName;
        }

        $coupon->update([
            'code' => $this->code,
            'discount' => $this->discount,
            'valid_from' => $this->valid_from,
            'valid_to' => $this->valid_to,
            'description' => [
                'ar' => $this->arDescription,
                'en' => $this->enDescription,
            ],
            'usage_limit' => $this->usage_limit,
        ]);


        $this->resetForm();
        $this->dispatch('message', __('Done Update'));
    }

    public function delete($couponId)
    {
        $coupon = coupons::find($couponId);

        if ($coupon) {
            if ($coupon->image && Storage::disk('public')->exists($coupon->image)) {
                Storage::disk('public')->delete($coupon->image);
            }
            $coupon->delete();

            $this->resetForm();
            $this->dispatch('message', __('Done Delete'));
        } else {
            $this->dispatch('message', __('Coupon Not Found'));
        }
    }
    public function render()
    {
        $coupons = coupons::query()->paginate($this->numbers);
        return view('livewire.setup.coupons.coupons-component',['coupons'=>$coupons])->extends('layouts.app');
    }
}
