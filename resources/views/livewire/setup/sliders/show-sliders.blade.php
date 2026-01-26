<div class="card">
    <div class="card-body">
       @include('tools.body_head_with_spinner_new',['pageTitleNew'=>__('Sliders')])

        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('Slider Title') }}</th>
                {{-- <th scope="col">{{ __('Sliders Image') }}</th> --}}
                <th scope="col">{{ __('status') }}</th>
                <th scope="col"><i class="fa fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
                <?php $i = App\Helpers\PaginationHelper::getStartingNumber($sliders); ?>
                @forelse ($sliders as  $slide)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <td>{{ $slide->title }}</td>
                    {{-- <td>
                        <img class="" style="width: 50px; height: 50px;" src="{{ asset('storage/' . $slide->image) }}" alt="">
                    </td> --}}
                    <td>
                        @livewire('switcher', ['model' => $slide, 'field' => 'status'], key("slide-".$slide->id))
                    </td>
                    <td>
                        <button class="btn btn-success btn-rounded" wire:click="edit({{ $slide->id }})" >
                            <i class="fa fa-edit text-white"></i>
                        </button> &nbsp;
                        <button class="btn btn-danger btn-rounded" wire:click="delete({{ $slide->id }})" >
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
            {{ $sliders->links() }}
        </div>

    </div>
</div>
