
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                @error('image') <span class="error">{{ $message }}</span> @enderror
            </h4>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="image" class="btn btn-primary btn-rounded">{{   __('Choose').' '.__('Product Image') }}</label>
                    <input id="image" type="file" class="form-control" hidden wire:model="image" />
                    <br>
                    @if($image)
                    <label for="image">
                        <img src="{{ $image->temporaryUrl() }}" class="img-fluid rounded" style="width: 200px; height: 200px" alt="image">
                    </label>

                    @elseif($product->image)
                        <label for="image">
                            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" style="width: 200px; height: 200px" alt="image">
                        </label>
                        @else
                        <label for="image">
                            <img src="{{ asset('assets/images/logo-1.png') }}" class="img-fluid rounded" style="width: 200px; height: 200px" alt="image">
                        </label>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" wire:click.prevent="saveImage"  class="btn btn-primary btn-rounded p-2 w-10" {{ $image ? '' : 'disabled' }}>
                <i class="fa fa-save"></i>&nbsp;
                {{ __('Save') }}

            </button>
        </div>
    </div>


