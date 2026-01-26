    <div class="card">
        <div class="card-body">
            @include('tools.body_head_with_spinner_back',['pageTiltleBack'=>__('Add New Hint')])
            <div class="basic-form">
                <form wire:submit.prevent="save">
                 <div class="form-row">
                    <div class="form-group col">
                        <div class="col-lg-6">
                            <label>{{ __('Hint content') }}</label>
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
                    <div class="form-group col-md-4">
                        <label for="image" class="btn btn-primary btn-rounded">{{   __('Choose').' '.__('Photos') }}</label>
                        <input id="image" type="file" class="form-control" hidden wire:model="image" />
                        <br>
                        @if($image)
                        <label for="image">
                            <img src="{{ $editing ? asset('storage/' . $imagePreview->image) : $image->temporaryUrl() }}" class="img-fluid rounded" style="width: 200px; height: 200px" alt="image">
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
                <button type="submit" class="btn btn-primary px-4 py-2 rounded">{{ $editing ? __('Update') : __('Save') }}</button>
                </form>
            </div>


        </div>

    </div>
