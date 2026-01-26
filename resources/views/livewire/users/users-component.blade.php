<div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h2 class="text-lg font-semibold">Manage Users</h2>

                @if(session()->has('message'))
                    <div class="p-2 bg-green-500 text-white">{{ session('message') }}</div>
                @endif

                <form wire:submit.prevent="{{ $userId ? 'updateUser' : 'createUser' }}">
                    <label for="">{{ __('Name') }}</label>
                    <input type="text" wire:model="name" placeholder="Full Name" class="form-control">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror<br>
                    <label for="">{{ __('Email') }}</label>
                    <input type="email" wire:model="email" placeholder="Email" class="form-control">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror<br>

                    @if(!$userId)
                        <label for="">{{ __('Password') }}</label>
                        <input type="password" wire:model="password" placeholder="Password" class="form-control">
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror<br>
                    @endif

                    <h3 class="mt-2">Assign Roles:</h3>
                    @foreach($allRoles as $role)
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="roles" value="{{ $role }}">
                            <span class="ml-2">{{ $role }}</span>
                        </label>
                    @endforeach
                        <br>
                    <button type="submit" class="btn btn-primary btn-rounded mt-2">
                        <i class="fa fa-user"></i> {{ $userId ? 'Update User' : 'Create User' }}
                    </button>
                </form>

                <h3 class="mt-4">Existing Users:</h3>
                <table class="w-full border-collapse border mt-2 w-full">
                    <tr class="bg-primary text-white">
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Email</th>
                        <th class="border p-2">Roles</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td class="border p-2">{{ $user->name }}</td>
                            <td class="border p-2">{{ $user->email }}</td>
                            <td class="border p-2">{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                            <td class="border p-2">
                                <button wire:click="editUser({{ $user->id }})" class="btn btn-warning btn-rounded text-white">Edit</button>
                                <button wire:click="deleteUser({{ $user->id }})" class="btn btn-danger btn-rounded text-white">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>
   </div>
