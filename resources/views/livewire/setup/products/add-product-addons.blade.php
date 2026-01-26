<div class="basic-form">
    <form >

        <div class="form-row">
            <div class="form-group col-lg-4 ">
                <label>{{ __('Addons') }}</label>
                <select  class="form-control " wire:model.live="addons_list">
                    <option value="">{{ __('Select an option') }}</option>
                    @foreach ($addons as $val_addon )
                        <option value="{{ $val_addon->id }}">{{ $val_addon->name }}</option>
                    @endforeach
                </select>
                @error('addons_list') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary" wire:click.prevent={{ $update_addons ? 'updateAddons' : 'save_addons' }}>
            <i class="fa fa-save"></i>
            {{ $update_addons ? __('Update') : __('Save') }}
        </button>
        @if($update_addons)
        <button type="submit" class="btn btn-danger" wire:click.prevent="$set('update_addons',false)">
            <i class="fa fa-times"></i>
            {{  __('Cancel') }}
        </button>
        @endif
    </form>
</div>

<br>
