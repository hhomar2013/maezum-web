<div>
    @section('title',__('Offers'))

    <div class="card">
        <div class="card-header">
           <h3>{{ __('offer') }} - {{ $offer->name }}</h3>
        </div>
        <div class="card-body">
            <h5 class="card-title ">{{ __('Products') }}</h5>
            <hr>

            <div class="row">
                <div class="col-md-3">
                    <label for="">{{ __('Products') }}</label>
                    <select name="" id="" class="form-control @error('product_id') is-invalid @enderror" wire:model.live="product_id">
                        <option value="">{{ __('Select an option') }}</option>
                        @foreach ($products as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
            </div>
            <br>
            @if($product_id)
                <button type="submit" class="btn btn-primary" wire:click.prevent="addProduct">
                    <i class="fa fa-save"></i> {{ __('Save') }}
                </button>
            @endif


        </div>
        <div class="card-footer">
            <table class="table table-bordered table-hover">
                <thead class="bg-primary text-white">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('Products') }}</th>
                    <th scope="col">{{ __('price') }}</th>
                    <th scope="col"><i class="fa fa-cogs"></i></th>
                  </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @forelse ($offer->products as  $products)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $products->name }}</td>
                        <td>{{ $products->price }} {{ getAppSetting('current_currency') }}</td>
                        <td>

                            <button class="btn btn-danger btn-rounded" wire:click="removeProduct({{ $products->id }})" >
                                <i class="fa fa-trash text-white"></i>
                            </button>
                        </td>
                      </tr>
                    @empty
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>
@script
    @include('tools.message')
@endscript
