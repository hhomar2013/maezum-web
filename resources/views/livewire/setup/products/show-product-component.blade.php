<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h5 class="card-title text-uppercase p-2">
                    {{ __('Products') }}
                </h5>
            </div>
            <div class="col text-center">
                @include('tools.spinner')
            </div>
            <div class="col text-right text-dark">
                <button  type="submit" class="btn btn-primary btn-rounded text-white"
                 wire:click.prevent="navigateTo('add.product')">
                   <i class="fa fa-plus"></i> {{ __('Add New') }}
                </button>
            </div>
        </div>

            <div class="input-group p-2">
                <div class="input-group-append">

                    {{-- <span class="input-group-text bg-dark text-white">{{ __('Pages') }}</span> --}}
                    <select class="form-control" wire:model="numbers" wire:change="pages_num">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="500000000000">الكل</option>
                    </select>



                </div>

                <div class="col-md-6 ">
                    <div class="input-group-append">
                        <span class="input-group-text bg-dark text-white"><i class="fa fa-search"></i></span>
                        <input type="text" name="" id="search" class="form-control" wire:model.live="search"/>

                    </div>
                </div>


            </div>
        <hr>

        <table class="table table-bordered  text-dark text-center table-striped">
            <thead class="bg-primary text-white">
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('Name') }}</th>
                <th scope="col">{{ __('price') }}</th>
                {{-- <th scope="col"> <i class="fa fa-image"></i></th></th> --}}
                <th scope="col">{{ __('status') }}</th>
                <th scope="col" ><i class="fa fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
                <?php $i = App\Helpers\PaginationHelper::getStartingNumber($products); ?>
                @forelse ($products as  $product)
                <tr wire.key="{{ $product->id }}">
                    <th scope="row">{{ $i++ }}</th>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    {{-- <td>
                        <img class="" style="width: 50px; height: 50px;" src="{{ asset('storage/' . $category->image) }}" alt="">
                    </td> --}}
                    <td>
                        @livewire('switcher', ['model' => $product, 'field' => 'status'], key("cat-".$product->id))
                    </td>
                    <td>
                        <button class="btn btn-outline-info btn-rounded text-secondary" wire:click="show({{ $product->id }})" >
                            {{ __('Show') }}
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-rounded" wire:click="edit({{ $product->id }})">
                            {{ __('Edit') }}
                            <i class="fa-solid fa-edit"></i>
                        </button>

                    </td>
                  </tr>

                @empty

                @endforelse

            </tbody>
        </table>

    </div>
    <div class="card-footer">
        <div class="pagination-circle">
            {{ $products->links() }}
        </div>

    </div>
</div>
