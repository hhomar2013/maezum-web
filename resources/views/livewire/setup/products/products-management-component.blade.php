<div>
   @section('title',__('Products'))
    @switch($navigate)
        @case('show.product')
            @include('livewire.setup.products.show-product-component')
            @break
        @case('add.product')
            @include('livewire.setup.products.add-products-component')
        @break

        @case('product-details')
        @include('livewire.setup.products.product-component')

        @break
        @default

    @endswitch
</div>

@script
    @include('tools.message')
@endscript
<script>
    document.addEventListener('livewire:init', () => {
    Livewire.on('update-url', (data) => {
        const eventData = data[0];

        try {
            const url = new URL(window.location.href);
            if (eventData.navigate) {
                url.searchParams.set('navigate', eventData.navigate);
            }
            if (eventData.productId) {
                url.searchParams.set('product_id', eventData.productId);
            }
            window.history.replaceState(null, '', url.toString());
        } catch (error) {
            // console.error('Error updating URL:', error);
        }
    });
});

</script>
