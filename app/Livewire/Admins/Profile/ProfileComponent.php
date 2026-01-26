<?php

namespace App\Livewire\Admins\Profile;

use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ProfileComponent extends Component
{

    public $user;
    public $name;
    public $email;
    public $password;
    public $re_password;
    public $image;
    public $get_image;
     protected $listeners = ['refresh-profile' => '$refresh'];
    use WithFileUploads;

    public function mount()
    {
        $this->user = auth()->user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        // if ($this->user->image){
        //     $this->get_image = $this->user->image;
        // }
    }


    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
        ]);

        // Add password validation rules if password is provided
        if ($this->password) {
            $this->validate([
                'password' => 'required',
                're_password' => 'required|same:password',
            ]);
            $this->user->password = bcrypt($this->password);
        }

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->save();
        $this->reset(['password', 're_password']);
        $this->dispatch('refresh-header');
        $this->dispatch('refresh-profile');
        $this->dispatch('message', message: __('Profile Updated Successfully'));
    }

    public function ImageStore()
    {
        if ($this->image) {
            // Delete old image if exists
            if ($this->user->image && file_exists(public_path('storage/' . $this->user->image))) {
                unlink(public_path('storage/' . $this->user->image));
            }

            // Store new image
            $imagePath = $this->image->store('profile-images', 'public');
            $this->user->image = $imagePath;
            $this->user->save();
            $this->dispatch('message', message: __('Done Save'));
            $this->reset('image');
        }
    }

    public function render()
    {
        return view('livewire.admins.profile.profile-component')->extends('layouts.app');
    }
}
