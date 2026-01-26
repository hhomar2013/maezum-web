<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col text-left">
                <h5 class="card-title">
                    {{ __('Stores') }}
                </h5>
            </div>
            <div class="col text-center">
                @include('tools.spinner')
            </div>
            <div class="col text-right">
                <button wire:click="back" class="btn btn-danger btn-rounded text-white">
                    {{__('Back')}}
                    <i class="fa fa-arrow-left"></i>
                </button>
            </div>
        </div>
        <hr>

        <div class="basic-form">
            <form wire:submit.prevent="{{ $update ? 'updateStores' : 'save' }}">

                <div class="form-row">
                    <div class="form-group col">
                        <div class="col-lg-6">
                            <label>{{ __('Arabic Name') }}</label>
                            <input type="text" class="form-control rounded-pill" placeholder="" wire:model="arName" />
                        </div>
                        <div class="col-lg-6">
                            <label>{{ __('English Name') }}</label>
                            <input type="text" class="form-control rounded-pill" placeholder="" wire:model="enName" />
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <label for="">{{ __('Description') }}</label>
                    <textarea wire:model="desc" class="form-control summernote" name="" id="" cols="30" rows="10" placeholder="{{ __('Description') }}"></textarea>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="logo" class="btn btn-primary btn-rounded">{{   __('Choose').' '.__('Photos') }}</label>
                        <input id="logo" type="file" class="form-control" hidden wire:model="logo" />
                        <br>
                        @if($logo)
                            <label for="logo">
                                <img src="{{ $update ? asset('storage/' .$logo) : $logo->temporaryUrl()}}" class="img-fluid rounded" style="width: 200px; height: 200px" alt="logo">
                            </label>
                            @else
                            <label for="logo">
                                <img src="{{ asset('assets/images/logo-1.png') }}" class="img-fluid rounded" style="width: 200px; height: 200px" alt="logo">
                            </label>
                        @endif
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

