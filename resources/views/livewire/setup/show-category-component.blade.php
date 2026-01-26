<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h5 class="card-title text-uppercase p-2">
                    {{ __('Categories') }}
                </h5>
            </div>
            <div class="col text-center">
                @include('tools.spinner')
            </div>
            <div class="col text-right text-dark">
                <button class="btn btn-primary btn-rounded text-white" wire:click="$set('addCategory',true)">
                   <i class="fa fa-plus"></i> {{ __('Add New') }}
                </button>
            </div>
        </div>

            <div class="input-group p-2">
                <div class="input-group-append">

                    {{-- <span class="input-group-text bg-dark text-white">{{ __('Pages') }}</span> --}}
                    <select class="form-select-sm" wire:model="numbers" wire:change="pages_num">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="500000000000">الكل</option>
                    </select>



                </div>

                {{-- <div class="col-md-6 ">
                    <div class="input-group-append">
                        <span class="input-group-text bg-dark text-white"><i class="fa fa-search"></i></span>
                        <input type="text" name="" id="search" class="form-control" wire:model.live="search"/>

                    </div>
                </div>
                <!--End of search  --> --}}

            </div>
        <hr>

        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('Name') }}</th>
                <th scope="col"> <i class="fa fa-image"></i></th></th>
                <th scope="col">{{ __('status') }}</th>
                <th scope="col"><i class="fa fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
                <?php $i = App\Helpers\PaginationHelper::getStartingNumber($categories); ?>


                @forelse ($categories as  $category)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <td>{{ $category->name }}</td>
                    <td>
                        <img class="" style="width: 50px; height: 50px;" src="{{ asset('storage/' . $category->image) }}" alt="">
                    </td>
                    <td>
                        @livewire('switcher', ['model' => $category, 'field' => 'status'], key("cat-".$category->id))
                    </td>
                    <td>
                        <button class="btn btn-success btn-rounded" wire:click="edit({{ $category->id }})" >
                            <i class="fa fa-edit text-white"></i>
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
            {{ $categories->links() }}
        </div>

    </div>
</div>
