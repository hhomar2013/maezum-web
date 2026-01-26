<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;

class UsersComponent extends Component
{
    use WithPagination;
    public $name, $email, $password, $userId;
    public $roles = [], $allRoles = [];

    #[Title('Users')]

    public function mount()
    {
        $this->allRoles = Role::pluck('name')->toArray();
    }

    public function createUser()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'roles' => 'array'
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->syncRoles($this->roles);

        session()->flash('message', 'User created successfully.');
        $this->reset(['name', 'email', 'password', 'roles']);
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->roles = $user->roles->pluck('name')->toArray();
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'roles' => 'array'
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $user->syncRoles($this->roles);

        session()->flash('message', 'User updated successfully.');
        $this->reset(['name', 'email', 'roles', 'userId']);
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function render()
    {

        $data = User::orderBy('id','DESC')->paginate(5);

        return view('livewire.users.users-component',
        [ 'users' => User::with('roles')->get(),]
        )->extends('layouts.app');


    }
}
