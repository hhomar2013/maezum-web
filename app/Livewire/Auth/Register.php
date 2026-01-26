<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Register extends Component
{
    #[Validate]
    public $name ,$email,$password;
    protected $listeners  = [
        'register'
    ];

    protected function rules()
    {
        return [
            'name'=>'required|min:3',
            'email'=>'required|email',
            'password'=>'required'
        ];
    }
    public function register(){
        $validated = $this->validate();
        User::query()->create($validated);

        if (auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->intended(route('dashboard'));
            $this->dispatch('message',message: __(''));
        }else{
            session()->flash('error', __('auth.failed'));
        }
    }
    public function render()
    {
        return view('livewire.auth.register')->extends('layouts.auth');
    }
}
