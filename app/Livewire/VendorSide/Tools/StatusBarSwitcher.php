<?php

namespace App\Livewire\VendorSide\Tools;

use Livewire\Component;

class StatusBarSwitcher extends Component
{
    public $status=false;

    public function render()
    {
        return view('livewire.vendor-side.tools.status-bar-switcher');
    }

    public function updating($field, $value)
    {

        $this->status = $value;
        session()->flash('message', __('t.status_message'));
        $this->dispatch('message', message: __('Done Successfully modified'));
    }
}
