<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsComponent extends Component
{
    public $name, $permissionId;
    public $roles = [], $allRoles = [];

    public function mount()
    {
        $this->allRoles = Role::pluck('name')->toArray();
    }

    public function createPermission()
    {
        $this->validate([
            'name' => 'required|unique:permissions,name',
            'roles' => 'array'
        ]);

        $permission = Permission::create(['name' => $this->name]);
        foreach ($this->roles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->givePermissionTo($permission);
            }
        }

        session()->flash('message', 'Permission created successfully.');
        $this->reset(['name', 'roles']);
    }

    public function editPermission($id)
    {
        $permission = Permission::findOrFail($id);
        $this->permissionId = $permission->id;
        $this->name = $permission->name;
        $this->roles = $permission->roles->pluck('name')->toArray();
    }

    public function updatePermission()
    {
        $this->validate([
            'name' => 'required|unique:permissions,name,' . $this->permissionId,
            'roles' => 'array'
        ]);

        $permission = Permission::findOrFail($this->permissionId);
        $permission->update(['name' => $this->name]);

        // تحديث الأدوار المرتبطة بالصلاحية
        $permission->syncRoles($this->roles);

        session()->flash('message', 'Permission updated successfully.');
        $this->reset(['name', 'roles', 'permissionId']);
    }

    public function deletePermission($id)
    {
        Permission::findOrFail($id)->delete();
        session()->flash('message', 'Permission deleted successfully.');
    }

    public function render()
    {
        return view('livewire.permissions-component', [
            'permissions' => Permission::with('roles')->get(),
        ])->extends('layouts.app');
    }
}
