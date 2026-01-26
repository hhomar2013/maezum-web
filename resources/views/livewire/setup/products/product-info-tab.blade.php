<div class="card">
    <div class="card-body">
            <div class="row py-2">
                <div class="col-lg-6">
                   <b>{{ __('Product Name') }}</b> :  {{ $product->name }}
                    <br><br>
                   <b>{{ __('Categories') }}</b> :  {{ $product->categories->name }}
                   <br><br>
                   <b>{{ __('price') }}</b> :  {{ $product->price }}
                </div>

            </div>
    </div>


</div>
