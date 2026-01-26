<?php

namespace App\Livewire;

use Livewire\Component;

class Modalcomponent extends Component
{
    public $isOpen = false; // للتحكم في إظهار وإخفاء المودال

    protected $listeners = ['openModal', 'closeModal'];

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }
    public function render()
    {
        return view('livewire.modalcomponent');
    }
}
