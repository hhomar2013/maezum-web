<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h5 class="card-title text-uppercase p-2">
                    {{ __('Offers') }}
                </h5>
            </div>
            <div class="col text-center">
                @include('tools.spinner')
            </div>
            <div class="col text-right text-dark">
                <button class="btn btn-primary btn-rounded text-white" wire:click="$set('add',true)">
                   <i class="fa fa-plus"></i> {{ __('Add New Offer') }}
                </button>
            </div>
        </div>

            <div class="input-group p-2">
                <div class="input-group-append">
                    <select class="form-control" wire:model="numbers" wire:change="pages_num">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="100000000000">{{ __('Select all') }}</option>
                    </select>
                </div>

                {{-- <div class="col-md-6 ">
                    <div class="input-group-append">
                        <span class="input-group-text bg-dark text-white"><i class="fa fa-search"></i></span>
                        <input type="text" name="" id="search" class="form-control" wire:model.live="search"/>

                    </div>
                </div> --}}
                <!--End of search  -->

            </div>
        <hr>

        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('Offer Name') }}</th>
                <th scope="col">{{ __('Offer Discount') }}</th>
                <th scope="col"><i class="fa fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
                <?php $i = App\Helpers\PaginationHelper::getStartingNumber($offers); ?>
                @forelse ($offers as  $offer)
                <tr>
                    <th scope="row">{{ $startingNumber++ }}</th>
                    <td>{{ $offer->name }}</td>
                    <td>{{ $offer->discount }}</td>
                    {{-- <td>
                        <img class="" style="width: 50px; height: 50px;" src="{{ asset('storage/' . $offer->image) }}" alt="">
                    </td> --}}
                    <td>
                        <a class="btn btn-dark btn-rounded" href="{{ route('offers.products', $offer->id) }}" >
                            <i class="fa-solid fa-cart-plus"></i>
                        </a>

                        <button class="btn btn-success btn-rounded" wire:click="edit({{ $offer->id }})" >
                            <i class="fa fa-edit text-white"></i>
                        </button>
                        &nbsp;
                        <button class="btn btn-danger btn-rounded" wire:click="deleteOffers({{ $offer->id }})" >
                            <i class="fa fa-trash text-white"></i>
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
            {{ $offers->links() }}
        </div>

    </div>
</div>
