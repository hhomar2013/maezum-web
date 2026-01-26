
<div>
    <h2 class="text-lg font-semibold">{{ __('Manage Roles') }}</h2> <br>
       <a class="btn btn-primary right" wire:click.prevent="$set('show',true)" href=""> {{ __('Manage Permissions') }}</a>

    @if(session()->has('message'))
        <div class="p-2 bg-green-500 text-white">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="{{ $roleId ? 'updateRole' : 'createRole' }}">
        <label for="">{{ __('Role') }}</label>
        <input type="text" wire:model="name" placeholder="Role Name" class="form-control">
        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror

        <h3 class="mt-2">{{ __('Permissions') }}</h3>
        @foreach($allPermissions as $permission)
            <label class="flex items-center">
                <input type="checkbox" wire:model="permissions" value="{{ $permission }}">
                <span class="ml-2">{{ $permission }}</span>
            </label>
        @endforeach
            <br>
        <button type="submit" class="mt-2 p-2 btn btn-primary text-white">
            {{ $roleId ? __('Update') : __('Save') }}
        </button>
    </form>

    <h3 class="mt-4">Existing Roles:</h3>
    <table class="w-full border-collapse border mt-2">
        <tr>
            <th class="border p-2">Name</th>
            <th class="border p-2">Permissions</th>
            <th class="border p-2">Actions</th>
        </tr>
        @foreach($roles as $role)
            <tr>
                <td class="border p-2">{{ $role->name }}</td>
                <td class="border p-2">{{ implode(', ', $role->permissions->pluck('name')->toArray()) }}</td>
                <td class="border p-2">
                    <button wire:click="editRole({{ $role->id }})" class="btn btn-warning  text-white">Edit</button>
                    <button wire:click="deleteRole({{ $role->id }})" class="btn btn-danger text-white">Delete</button>
                </td>
            </tr>
        @endforeach
    </table>
</div>

