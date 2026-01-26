<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col text-left">
                <h5 class="card-title">
                    {{ __('Offers') }}
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
            <form wire:submit.prevent="{{ $update ? 'updateOffers' : 'save' }}">

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

                        <label>{{ __('Offer Discount') }}</label>
                        <input type="number" min="0" class="form-control rounded-pill" placeholder="" wire:model="discount" />
                        @error('dicount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror


                        <label>{{ __('Offer Start Date') }}</label>
                        <input type="date"  class="form-control rounded-pill" placeholder="" wire:model="startDate" />
                        @error('startDate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror


                        <label>{{ __('Offer Expiry Date') }}</label>
                        <input type="date"  class="form-control rounded-pill" placeholder="" wire:model="expiryDate" />
                        @error('expiryDate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <br>
                        {{-- <label>{{ __('Offer Image') }}</label> --}}
                        <label for="image" class="btn btn-primary btn-rounded">{{   __('Choose').' '.__('Offer Image') }}</label>
                        <input id="image" type="file" class="form-control" hidden wire:model="image" />
                        <br>
                        @if($image)
                            <label for="image">
                                <img src="{{ $update ? asset('storage/' . $offer->image) : $image->temporaryUrl() }}" class="img-fluid rounded" style="width: 200px; height: 200px" alt="image">
                            </label>
                            @else
                            <label for="image">
                                <img src="{{ asset('assets/images/logo-1.png') }}" class="img-fluid rounded" style="width: 200px; height: 200px" alt="image">
                            </label>
                        @endif
                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <div class="form-group col-lg-4 ">
                        <label>{{ __('Ar Description') }}</label>
                        <textarea class="form-control" name="" id="" cols="30" rows="3" wire:model="arDescription"></textarea>
                        @error('arDescription')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label>{{ __('En Description') }}</label>
                        <textarea class="form-control" name="" id="" cols="30" rows="3" wire:model="enDescription"></textarea>
                        @error('enDescription')
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

