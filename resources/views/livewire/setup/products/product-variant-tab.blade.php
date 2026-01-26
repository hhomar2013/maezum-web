@forelse($product->variants as $variant)
<div class="col-lg-4">

    <div class="card shadow">
        <div class="card-header">
        <h4>{{ $variant->attribute->name }}</h4>
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
    </div>
</div>
@empty
<div class="col-lg-4">
    <span>{{ __('There is no data') }}</span>
</div>
@endforelse
<hr>
<a class="btn btn-danger text-white btn-rounded" href="{{ route('product.variants', $product->id) }}">{{ __('Manage Variants') }}</a>
