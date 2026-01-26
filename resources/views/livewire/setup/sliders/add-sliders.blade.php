<div class="card">
    <div class="card-body">
     @include('tools.body_head_with_spinner_back',['pageTiltleBack'=>__('Sliders')])

        <div class="basic-form">
            <form wire:submit.prevent="{{ $update ? 'updateSliders' : 'save' }}">

                <div class="form-row">
                    <div class="form-group col">
                        <div class="col-lg-6">
                            <label>{{ __('Slider Title') }}</label>
                            <input type="text" class="form-control rounded-pill" placeholder="" wire:model="title" />
                        </div>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <label for="">{{ __('Description') }}</label>
                    <textarea wire:model="discription" class="form-control summernote" name="" id="" cols="30" rows="10" placeholder="{{ __('Description') }}"></textarea>
                </div>
                @error('discription')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <br>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="image" class="btn btn-primary btn-rounded">{{   __('Choose').' '.__('Photos') }} {{ "1120PX * 400PX" }}</label>
                        <input id="image" type="file" class="form-control" hidden wire:model="image" />
                        <br>
                        @if($image)
                        <label for="image">
                            <img src="{{ $update ? asset('storage/' . $slider->image) : $image->temporaryUrl() }}" class="img-fluid rounded" style="width: 200px; height: 200px" alt="image">
                        </label>
                        @else
                        <label for="image">
                            <img src="{{ asset('assets/images/logo-1.png') }}" class="img-fluid rounded" style="width: 200px; height: 200px" alt="image">
                        </label>
                    @endif
                    </div>
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
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

