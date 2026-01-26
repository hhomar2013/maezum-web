<?php

namespace App\Livewire\VendorSide\Tools;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserMenue extends Component
{

    protected $listeners = [
        'userMenuUpdated' => 'render',
    ];

    public function render()
    {
        return view('livewire.vendor-side.tools.user-menue');
    }
}
