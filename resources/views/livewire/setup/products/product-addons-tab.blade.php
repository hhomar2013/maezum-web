
@if($show_addons)
    @include('livewire.setup.products.add-product-addons')
@endif

<div class="row">
    <div class="col-lg-4">
        <table class="table table-bordered  text-dark text-center table-striped">
            <thead class="bg-primary text-white">
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('Name') }}</th>
                <th scope="col">{{ __('price') }}</th>
                <th scope="col" ><i class="fa fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
                <?php $i =1; ?>
                @forelse ($product->addons as $addons)
                   <tr wire.key="{{ $addons->addons['id'] }}">
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $addons->addons['name']  }}</td>
                        <td>{{ $addons->addons['price']  }}</td>
                        <td>
                            <button class="btn btn-outline-secondary btn-rounded" wire:click="edit_addons({{ $addons->addons['id']  }})">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                @empty

                @endforelse

            </tbody>
        </table>
    </div>
</div>


