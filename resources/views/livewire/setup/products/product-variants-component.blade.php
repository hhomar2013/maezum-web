@section('title', $product->name)
<div>
    <div class="card">
        <div class="card-header">
            <h1>{{ $product->name }}</h1>
        </div>
        <div class="card-body">
            <div class="text-center" wire:loading>
                @include('tools.spinner')
            </div>

            <form wire:submit.prevent="addVariant">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="variantName">{{ __('Variants Name') }}</label>
                        {{-- <input type="text" id="variantName"
                        class="form-control input-rounded  @error('variantName') is-invalid @else   @enderror"
                        wire:model="variantName"> --}}
                        <select  class="form-control input-rounded
                        @error('variantName') is-invalid @else @enderror" wire:model.live="variantName">
                            <option value="">{{ __('Select an option') }}</option>
                            @foreach ($attributs as $attribut)
                                <option value="{{ $attribut->id }}">{{ $attribut->name }}</option>
                            @endforeach
                        </select>
                        @error('variantName') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="variantName">{{ __('Variants type') }}</label>
                        <select  class="form-control input-rounded
                        @error('type') is-invalid @else @enderror" wire:model.live="type">
                            <option value="">{{ __('Select an option') }}</option>
                            <option value="one choice">{{ __('one choice') }}</option>
                            <option value="multiple choices">{{ __('multiple choices') }}</option>
                        </select>
                        @error('type') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>
                </div>

                <div>
                    <h4>{{ __('Options') }}</h4>
                    @foreach($rows as $index => $row)
                    {{-- {{ dd($row) }} --}}
                    <div class="row" wire:key="row-{{ $index }}">

                            <div class="col">
                                <label>{{ __('Arabic Name') }}</label>
                                <input class="form-control input-rounded" type="text" wire:model="rows.{{ $index }}.arName">
                                @error('rows.' . $index . '.arName') <span class="text-danger">{{ $message }}</span> @enderror


                                <label>{{ __('English Name') }}</label>
                                <input class="form-control input-rounded" type="text" wire:model="rows.{{ $index }}.enName">
                                @error('rows.' . $index . '.enName') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>



                            <div class="col">

                            <label>{{ __('price') }}</label>
                            <input class="form-control input-rounded" min="0" type="number" wire:model="rows.{{ $index }}.price" step="0.01">
                            @error('rows.' . $index . '.price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            {{-- <div class="col">
                            <label>{{__('pictures')}}</label>
                            <input class="form-control input-rounded" type="file" wire:model="rows.{{ $index }}.image">
                            @error('rows.' . $index . '.image') <span class="text-danger">{{ $message }}</span> @enderror
                            </div> --}}

                            {{-- <div class="col">
                                @if(isset($row['image']) && is_string($row['image']))
                                    <img src="{{ asset('storage/' . $row['image']) }}" style="max-width: 200px;">
                                @endif
                            </div> --}}

                        <div class="col">
                            <label>{{ __('Actions') }}</label> <br>
                            <button type="button" class="btn btn-rounded btn-danger" wire:click="removeRow({{ $index }})">{{ __('Delete') }}</button>
                        </div>

                    </div><br>
                    @endforeach
                    @if ($variantName && $type)
                    <button type="button" wire:click="addRow" class="btn btn-rounded btn-dark text-white"> <i class="fa fa-plus"></i> {{ __('Add Option') }}</button>
                    @endif

                </div>
                <hr>
                <button type="submit" class="btn btn-rounded btn-primary">
                     {{-- <i class="fa fa-save"></i> {{ __('Save') }} --}}
                     {{ $editingVariantId ?  __('Update') :  __('Save') }}

                    </button>
                    @if($editingVariantId)
                    <button type="button" wire:click="resetForm" class="btn btn-rounded btn-dark">إلغاء التعديل</button>
                    @endif
                    <a href="{{ route('products') }}" class="btn btn-rounded btn-danger"> <i class="fa fa-arrow-left"></i> {{ __('Back') }} </a>
            </form>
        </div>
        <div class="card-footer">
            <div>
                <h3>{{ __('Added Options') }}</h3>
                <div class="row">
                    @foreach($product->variants as $variant)
                    <div class="col-lg-4">

                        <div class="card shadow">
                            <div class="card-header">
                            <h4>{{ $variant->attribute->name }}</h4> - <h3>{{ __($variant->type) }}</h3>
                            </div>
                            <div class="card-body">
                                @foreach(json_decode($variant->options, true) as $option)
                                    <li style="list-style-type:decimal;" class="list-group-item">
                                        {{-- <strong>{{ __('Variants Name') }}</strong> --}}
                                        @if (app()->getLocale() == 'en')
                                        {{ $option['name']['en'] }}
                                        @else
                                        {{$option['name']['ar']}}
                                        @endif
                                        &nbsp;
                                        {{-- <strong>{{ __('price') }} </strong> --}}
                                         -  {{ $option['price'] }}   {{ getAppSetting('current_currency') }}
                                        {{-- @if($option['image'])
                                            <img src="{{ asset('storage/' . $option['image']) }}" alt="{{ $option['name'] }}" style="max-width: 50px;">
                                        @endif --}}

                                    </li>
                                @endforeach
                            </div>
                            <div class="card-footer">
                                <button type="button" wire:click="editVariant({{ $variant->id }})" class="btn btn-rounded btn-dark"> <i class="fa fa-edit"></i></button>
                                <button type="button" wire:click="deleteVariant({{ $variant->id }})" class="btn btn-rounded btn-danger"> <i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
@section('js')
<script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins-init/select2-init.js') }}"></script>
@endsection

@section('css')
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}"> --}}
@endsection
