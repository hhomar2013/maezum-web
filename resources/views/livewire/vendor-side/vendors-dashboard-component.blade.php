@section('title', Auth::user()->name)
<div>
    <div class="container-fluied" wire:poll wire:ignore>
        @include('tools.page_header')
        {{-- <div class="col-md-2 p-4">
            <label for="">{{ __('t.date') }}</label>
        <input type="date" name="" id="" class="form-control" wire:model="date">
    </div> --}}
        <div class="row">
            @include('livewire.vendor-side.dashboard-tools.card', [
                'title' => __('Total Products'),
                'total' => $totalItems,
                'route' => 'vendors.items',
            ])
            @include('livewire.vendor-side.dashboard-tools.card', [
                'title' => __('Total Orders'),
                'total' => $totalOrders,
                'route' => 'vendors.orders',
            ])
        </div>

    </div>
</div>
