<?php

namespace App\Livewire\Tools;

use Livewire\Component;

class HeaderComponent extends Component
{

     protected $listeners = ['refresh-header' => '$refresh'];
    public function render()
    {
        return view('livewire.tools.header-component');
    }
}
