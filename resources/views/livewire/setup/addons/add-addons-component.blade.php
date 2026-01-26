<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col text-left">
                <h5 class="card-title">
                    {{ __('Addons') }}
                </h5>
            </div>
            <div class="col text-center">
                @include('tools.spinner')
            </div>
            <div class="col text-right">
                <button wire:click="$set('add',false)" class="btn btn-danger btn-rounded text-white">
                    {{__('Back')}}
                    <i class="fa fa-arrow-left"></i>
                </button>
            </div>
        </div>
        <hr>

        <div class="basic-form">
            <form wire:submit.prevent="{{ $update ? 'update' : 'save' }}">

                <div class="form-row">
                    <div class="form-group col-lg-4 ">
                        <label>{{ __('Arabic Name') }}</label>
                        <input type="text" class="form-control @error('arName') is-invalid @enderror rounded-pill" placeholder="" wire:model="arName" />
                        @error('arName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label>{{ __('English Name') }}</label>
                        <input type="text" class="form-control rounded-pill" placeholder="" wire:model="enName" />
                        @error('enName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label>{{ __('price') }}</label>
                        <input type="number" min="0" class="form-control rounded-pill" placeholder="" wire:model="price" />
                        @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary w-25">
                    <i class="fa fa-save"></i>
                    {{ $update ?  __('Update') :  __('Save') }}
                </button>
            </form>
        </div>

    </div>
</div>

