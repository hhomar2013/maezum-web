<?php

namespace App\Livewire;

use App\Models\Offers;
use App\Models\Stores;
use Livewire\Livewire;
use App\Models\coupons;
use App\Models\Product;
use App\Models\Vendors;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use App\Events\NewOrderCreated;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class DashboardComponent extends Component
{
    public $stores = [];
    public $vendors = [];
    public $products = [];
    public $coupons = [];
    public $offers = [];
    protected $listeners = ['refreshDashboard' => 'updateProducts', 'newOrderReceived' => 'handleNewOrder'];
    #[On('register')]
    public function mount()
    {
        $this->stores = Stores::query()->count();
        $this->vendors = Vendors::query()->count();
        $this->products = Product::query()->count();
        $this->coupons = coupons::query()->count();
        $this->offers = Offers::query()->count();


        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        $user->fcm_token = csrf_token();
        $user->save();
    }



    #[On('order.sent')]
    public function handleIncomingOrder($data)
    {
        $newOrderId = $data['orderId'];
        dd($newOrderId);
        // تشغيل صوت الإشعار
        $this->dispatch('play-notification-sound');
    }


    public function updateProducts()
    {
        $this->products = Product::query()->count();
    }

    public function sendNotification()
    {

        $firebase = new FirebaseService();
        $user = auth()->user();
        $firebase->sendNotification(
            $user->fcm_token,
            'طلب جديد',
            'تم تأكيد طلبك رقم #' . 10001,
            [
                'order_id' => 1,
                'type' => 'new_order'
            ]
        );
    }

    public function handleNewOrder($data)
    {
        $message = $data['message'] ?? 'طلب جديد';
        $sound = $data['sound'] ?? 'order.mp3';

        // لو عايز تحدث بيانات أو تسجل الإشعار
        $this->dispatch('new-order', [
            'message' => $message,
            'sound' => $sound,
        ]);
        event(new NewOrderCreated($message, $sound));
    }





    public function testNotification()
    {

        // dd('Omar');
        //   $this->dispatch('newOrderReceived', [
        //     'message' => 'طلب جديد من العميل أحمد',
        //     'sound' => 'order.mp3'
        // ]);

    }

    public function render()
    {
        return view('livewire.dashboard-component')->extends('layouts.app');
    }
}
