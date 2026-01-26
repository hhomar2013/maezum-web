
<div class="card shadow">
    <div class="card-header">
        <h4>{{ __('Add New Product') }}</h4>
    </div>
    <div class="card-body">
        <form>
            <div class="form-group">
                <div class="row">

                    <div class="col-lg-4">
                        <label for="">{{ __('Arabic Name') }}</label>
                        <input type="text" wire:model="arName" class="form-control input-rounded @error('arName') is-invalid @enderror" placeholder="{{ __('Product Name') }}">
                        @error('arName') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-lg-4">
                        <label for="">{{ __('English Name') }}</label>
                        <input type="text" wire:model="enName" class="form-control input-rounded @error('enName') is-invalid @enderror" placeholder="{{ __('Product Name') }}">
                        @error('enName') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-lg-3">
                        <label for="">{{ __('Categories') }}</label>

                        <select  class="form-control " wire:model.live="categories_list">
                            <option value="">{{ __('Select an option') }}</option>
                            @foreach ($categories as $category )
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('categories_list') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
             </div>
             <div class="form-group">
                    <label for="">{{ __('Description') }}</label>
                    <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{ __('Description') }}"></textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
             </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">

                <label for="my-input">{{ __('Product Price') }}</label>
                <input type="number" wire:model="price" min="1" class="form-control input-rounded @error('price') is-invalid @enderror" placeholder="{{ __('Product Price') }}">
                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <button
                    wire:click.prevent="{{ $editProduct ? 'update' : 'save' }}"
                     type="submit" class="btn btn-rounded {{ $editProduct ? 'btn-dark' :'btn-primary' }} btn-block">
                        {{ $editProduct ? __('Update') :__('Save') }}
                        &nbsp;
                        <i class="fa fa-save"></i>
                    </button>
                </div>
                <div class="col-2">
                    <button wire:click.prevent="navigateTo('show.product')" type="submit" class="btn btn-rounded btn-danger btn-block">
                        {{ __('Back') }}&nbsp;
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    {{-- <div class="card-footer">
        <h5>{{ __('Show Products') }}</h5>

            @foreach ($products as $product)
                <ul class="list-group list-group-horizontal">
                    <li class="list-group-item w-50">{{ $product->name }}</li>
                    <li class="list-group-item w-50">{{ $product->price }}</li>
                    <li class="list-group-item w-50">
                        <a class="btn btn-danger text-white btn-rounded" href="{{ route('product.variants', $product->id) }}">{{ __('Manage Variants') }}</a>
                    </li>
                </ul>
            @endforeach
    </div> --}}
</div>
