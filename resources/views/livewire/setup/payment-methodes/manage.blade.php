<div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ __('Payment Methods') }}
            </h3>
        </div>

        <div class="card-body text-dark">

            <form wire:submit.prevent="{{ $editMode ? 'update' : 'save' }}" class="space-y-2 mb-4">
                <input  type="text" wire:model="name" placeholder="الاسم" class="w-full p-2 border rounded">
                <input  type="text" wire:model="code" placeholder="الكود" class="w-full p-2 border rounded">
                <input  type="text" wire:model="provider" placeholder="المزود" class="w-full p-2 border rounded">
                <br><br>
                  <h4>{{ __('Config') }}</h4>  <button type="button" wire:click="addConfig" class="btn btn-warning">{{ __('Add New') }}</button>
                <br>
                <br>
                @foreach ($configItems as $index => $item)
                <div class="flex gap-2 mb-2">
                    <input type="text" wire:model="configItems.{{ $index }}.key" placeholder="المفتاح" class="w-1/3 p-2 border rounded">
                    <input type="text" wire:model="configItems.{{ $index }}.value" placeholder="القيمة" class="w-1/2 p-2 border rounded">
                    <button type="button" wire:click="removeConfig({{ $index }})" class="btn btn-danger"> ✕ </button>
                </div>
                @endforeach

                <br>
                  <label for="image" class="btn btn-primary">{{ __('Choose') . ' ' . __('Payment Method Image')}}</label>
                <input id="image" class="form-control"  type="file" wire:model="image" class="w-full p-2 border rounded" hidden>

                  @if ($image)
                <img src="{{ $image->temporaryUrl() }}" class="w-20 h-20 object-contain mt-2">
                @endif


                <br>
                <h4>
                   {{ __('status') }}
                </h4>

                <div class="custom-control custom-switch">
                    <input class="custom-control-input " type="checkbox" id="is_active" wire:model="is_active" name="is_active">
                    <label class="custom-control-label" id="is_active" for="is_active"></label>
                </div>
                <br>
                <button type="submit" class="btn btn-primary text-white btn-rounded">
                    {{ $editMode ? __('Update') : __('Save') }}
                </button>
            </form>
        </div>
        <div class="card-footer">

            <div class="row text-sm">
                @foreach ($methods as $method)
                <div class="card col-lg-4 ">
                    <div class=" p-5 shadow rounded-lg">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('storage/' . $method->image) }}" alt="{{ $method->name }}" class="w-100">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $method->name }}</h3>
                                <p class="text-sm text-gray-500">{{ strtoupper($method->code) }}</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button wire:click="edit('{{ $method->id }}')" class="btn btn-primary btn-rounded w-25">
                                {{ __('Choose') }}
                            </button>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
            {{ $methods->links() }}
        </div>


    </div>








</div>
