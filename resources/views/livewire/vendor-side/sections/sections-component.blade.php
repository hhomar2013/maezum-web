<div>
    <div class="card text-primary">
        <div class="card-header">
            <h3>{{ __('Your Own Categories') }}</h3>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="{{ $sectionsFitch  ? 'update':'save' }}">
                <div class="form-row">
                    <div class="form-group col">
                        <div class="col-lg-4">
                            <label>{{ __('Arabic Name') }}</label>
                            <input type="text" class="form-control rounded-pill" placeholder="" wire:model="arName" />
                        </div>
                        <div class="col-lg-4">
                            <label>{{ __('English Name') }}</label>
                            <input type="text" class="form-control rounded-pill" placeholder="" wire:model="enName" />
                        </div>
                    </div>
                </div>
                {{-- Image --}}
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="logo"
                            class="btn btn-primary btn-rounded">{{ __('Choose') . ' ' . __('Photos') }}</label>
                        <input id="logo" type="file" class="form-control" hidden wire:model="logo" />
                        <br>

                        @if ($logo)
                            <label for="logo">
                                <img src="{{ $logo->temporaryUrl() }}" class="img-fluid rounded"
                                    style="width: 200px; height: 200px" alt="logo">
                            </label>
                        @elseif($sectionsFitch)
                            <label for="logo">
                                <img src="{{ asset('storage/' . $sectionsFitch->image) }}" class="img-fluid rounded"
                                    style="width: 200px; height: 200px" alt="logo">
                            </label>
                        @else
                            <label for="logo">
                                <img src="{{ asset('assets/images/logo-1.png') }}" class="img-fluid rounded"
                                    style="width: 200px; height: 200px" alt="logo">
                            </label>
                        @endif
                    </div>
                </div>
                {{-- End Image --}}
                <button class="btn btn-success btn-primary">{{ __('Save') }}</button>
            </form>


        </div>
        <div class="card-footer">
            <ul class="list-group">
                @foreach ($sections as $section)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="col-10">
                            <strong>{{ $section->name }}</strong><br>
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <button wire:click="edit({{ $section->id }})"
                                class="btn btn-sm btn-warning btn-rounded">{{ __('Update') }}</button>&nbsp;
                            <button wire:click="delete({{ $section->id }})"
                                class="btn btn-sm btn-danger btn-rounded">{{ __('Delete') }}</button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@section('title',__('Categories'))
@script
    @include('tools.message')
@endscript
