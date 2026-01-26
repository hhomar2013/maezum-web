<div>
    <div class="card text-primary">
        <div class="card-header">
            <h3>{{ __('Products') }}</h3>
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form wire:submit.prevent="{{ $itemsId ? 'update' : 'save' }}">
                    <div class="form-row">
                        <div class="form-group col">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="">{{ __('Arabic Name') }}</label>
                                    <input type="text" wire:model="arName" class="form-control mb-2"
                                        placeholder="{{ __('Arabic Name') }}">
                                    <label for="">{{ __('English Name') }}</label>
                                    <input type="text" wire:model="enName" class="form-control mb-2"
                                        placeholder="{{ __('English Name') }}">

                                    <hr>
                                    {{-- Image --}}
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="logo"
                                                class="btn btn-primary btn-rounded">{{ __('Choose') . ' ' . __('Photos') }}</label>
                                            <input id="logo" type="file" class="form-control" hidden
                                                wire:model="logo" />
                                            <br>

                                            @if ($logo)
                                                <label for="logo">
                                                    <img src="{{ $logo->temporaryUrl() }}" class="img-fluid rounded"
                                                        style="width: 100px; height: 100px" alt="logo">
                                                </label>
                                            @elseif($itemsFetsh)
                                                <label for="logo">
                                                    <img src="{{ asset('storage/' . $itemsFetsh->image) }}"
                                                        class="img-fluid rounded" style="width: 100px; height: 100px"
                                                        alt="logo">
                                                </label>
                                            @else
                                                <label for="logo">
                                                    <img src="{{ asset('assets/images/logo-1.png') }}"
                                                        class="img-fluid rounded" style="width: 100px; height: 100px"
                                                        alt="logo">
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- End Image --}}
                                </div>
                                <div class="col-lg-6">
                                    <label for="">{{ __('Categories') }}</label>
                                    <select wire:model="category_id" class="form-control mb-2">
                                        <option value="">اختر القسم</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <h5>{{ __('Variations') }}</h5>
                                    @foreach ($variations as $index => $variation)
                                        <div class="d-flex mb-2 gap-2">
                                            <input type="text" wire:model="variations.{{ $index }}.name"
                                                class="form-control" placeholder="الاسم">
                                            <input type="number" wire:model="variations.{{ $index }}.price"
                                                class="form-control" placeholder="السعر">
                                            <button type="button" wire:click="removeVariation({{ $index }})"
                                                class="btn btn-sm btn-danger">-</button>
                                        </div>
                                    @endforeach

                                    <button type="button" wire:click="addVariation" class="btn btn-sm btn-info mb-2"> +
                                        {{ __('Add New') }}</button>

                                </div>
                            </div>
                            <label for="">{{ __('Description') }}</label>
                            <textarea wire:model="description" class="form-control mb-2"></textarea>
                        </div>
                    </div>
                    <button class="btn btn-success">حفظ الصنف</button>
                </form>
            </div>


        </div>

        <div class="card-footer">
            <ul class="list-group">

                @foreach ($items->groupBy('category_id') as $sectionItems)
                    <li class="list-group-item active">
                        <strong>{{ $sectionItems->first()->category->name }}</strong>
                    </li>
                    @foreach ($sectionItems as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="col-10">
                                <strong>{{ $item->name }}</strong><br>

                                @foreach ($item->variations as $variation)
                                    <small>
                                        <b>{{ $variation->name }} - {{ $variation->price }}</b>
                                    </small><br>
                                @endforeach
                            </div>

                            <div class="col-2 d-flex justify-content-end">
                                <button wire:click="edit({{ $item->id }})"
                                    class="btn btn-sm btn-warning btn-rounded">
                                    {{ __('Update') }}
                                </button>&nbsp;

                                <button wire:click="delete({{ $item->id }})"
                                    class="btn btn-sm btn-danger btn-rounded">
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </li>
                    @endforeach
                @endforeach

            </ul>
        </div>
    </div>




</div>
@section('title', __('Products'))
@script
    @include('tools.message')
@endscript
