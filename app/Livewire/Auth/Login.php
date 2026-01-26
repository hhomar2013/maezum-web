<?php
namespace App\Livewire\Auth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Login extends Component
{
    use Authenticatable;

    public $email, $password, $remember, $type = "web";

    public function login()
    {

        $this->validate([
            'type'     => 'required|in:web,vendor',
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = ['email' => $this->email, 'password' => $this->password];

        if (Auth::guard($this->type)->attempt($credentials, $this->remember)) {
            return $this->redirect(
                $this->type === 'vendor'
                ? route('vendors.dashboard')
                : route('dashboard')
            );
        }

        session()->flash('error', __('auth.failed'));
    }

    public function logout()
    {
        $guard = Auth::guard('vendor')->check() ? 'vendor' : 'web';
        Auth::guard($guard)->logout();
        session()->invalidate();
        session()->regenerateToken();
        session()->flush();
        return $this->redirectRoute('login');
    }

    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.auth');
    }
}
