<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h5 class="card-title text-uppercase p-2">
                    {{ __('Attributes') }}
                </h5>
            </div>
            <div class="col text-center">
                @include('tools.spinner')
            </div>
            <div class="col text-right text-dark">
                <button class="btn btn-primary btn-rounded text-white" wire:click="$set('addAtt',true)">
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
                <th scope="col">{{ __('status') }}</th>
                <th scope="col"><i class="fa fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
                <?php $i =1; ?>

                @forelse ($attributes as  $attribute)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <td>{{ $attribute->name }}</td>
                    <td>
                        @livewire('switcher', ['model' => $attribute, 'field' => 'status'], key("cat-".$attribute->id))
                    </td>
                    <td>
                        <button class="btn btn-success btn-rounded btn-sm" wire:click="edit({{ $attribute->id }})" >
                            <i class="fa fa-edit text-white"></i>
                        </button>
                        &nbsp;
                        <button class="btn btn-danger btn-rounded btn-sm" wire:click="deleteConfirm({{ $attribute->id }})" >
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
            {{ $attributes->links() }}
        </div>

    </div>
</div>
