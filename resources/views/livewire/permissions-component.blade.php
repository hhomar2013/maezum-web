<div>
    <h2 class="text-lg font-semibold">Manage Permissions</h2>

    @if(session()->has('message'))
        <div class="p-2 bg-green-500 text-white">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="{{ $permissionId ? 'updatePermission' : 'createPermission' }}">
        <input type="text" wire:model="name" placeholder="Permission Name" class="border p-2 w-full">
        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror

        <h3 class="mt-2">Assign to Roles:</h3>
        @foreach($allRoles as $role)
            <label class="flex items-center">
                <input type="checkbox" wire:model="roles" value="{{ $role }}">
                <span class="ml-2">{{ $role }}</span>
            </label>
        @endforeach

        <button type="submit" class="mt-2 p-2 bg-blue-500 text-white">
            {{ $permissionId ? 'Update Permission' : 'Create Permission' }}
        </button>
    </form>

    <h3 class="mt-4">Existing Permissions:</h3>
    <table class="w-full border-collapse border mt-2">
        <tr>
            <th class="border p-2">Name</th>
            <th class="border p-2">Roles</th>
            <th class="border p-2">Actions</th>
        </tr>
        @foreach($permissions as $permission)
            <tr>
                <td class="border p-2">{{ $permission->name }}</td>
                <td class="border p-2">{{ implode(', ', $permission->roles->pluck('name')->toArray()) }}</td>
                <td class="border p-2">
                    <button wire:click="editPermission({{ $permission->id }})" class="bg-yellow-500 p-1 text-white">Edit</button>
                    <button wire:click="deletePermission({{ $permission->id }})" class="bg-red-500 p-1 text-white">Delete</button>
                </td>
            </tr>
        @endforeach
    </table>
</div>
