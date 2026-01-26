<?php

namespace App\Livewire\Setup\Offers;

use App\Models\offer_product;
use App\Models\Offers;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;


class OfferProductComponent extends Component
{
    public $product_id;
    public $offer;
    protected $listeners = ['refreshOfferProduct' => '$refresh'];

    public function mount($offerId){
        $this->offer = Offers::query()->with(['products'])->find($offerId);
    }


    public function addProduct(){
        $offer_id = $this->offer->id;
        $rules = [
            'product_id' => [
                    // 'required',
                    // Rule::unique('offer_products')
                    // ->where('offer_id', $offer_id)
                    // ->when($this->offer->product_id, function ($rule) {
                    //     return $rule->ignore($this->offer->product_id);
                    // })

                    'required',
                    // الشرط الأول: لا يتكرر في نفس العرض
                    Rule::unique('offer_products')->where(function ($query) {
                        return $query->where('offer_id',$this->offer->id );
                    }),
                    // الشرط الثاني: غير موجود في أي عرض نشط آخر
                    function ($attribute, $value, $fail) {
                        $existsInActiveOffer = DB::table('offer_products')
                            ->join('offers', 'offer_products.offer_id', '=', 'offers.id')
                            ->where('offer_products.product_id', $value)
                            ->where('offers.end_date','>=', Carbon::now())
                            // ->where('offers.status', 1) // 1 يعني العرض نشط
                            ->exists();

                        if ($existsInActiveOffer) {
                            $fail('هذا المنتج مضاف بالفعل في عرض نشط آخر ولا يمكن إضافته مرة أخرى.');
                        }
                    }
            ],
        ];

        $this->validate($rules);

        $add = offer_product::query()->create([
           'product_id' => $this->product_id,
           'offer_id' => $this->offer->id,
        ]);

        $this->dispatch('message', __('Done Save'));
        $this->reset('product_id');

    }


    public function removeProduct($productId){
        offer_product::query()->where('product_id', $productId)->where('offer_id', $this->offer->id)->delete();
        $this->dispatch('message', __('Done Delete'));
    }

    public function render()
    {
        $product_list = Product::query()->get();
        return view('livewire.setup.offers.offer-product-component',['products'=>$product_list])->extends('layouts.app');
    }
}
