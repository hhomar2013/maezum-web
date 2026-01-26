<div class="card">
    <div class="card-body">
       @include('tools.body_head_with_spinner_new',['pageTitleNew'=>__('Hints')])

        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('Hint content') }}</th>
                <th scope="col">📷</th>
                <th scope="col"><i class="fa fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>


                @forelse ($mainTips as $mainTip)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <td>{{ $mainTip->title}}</td>
                    <td>
                         @if ($mainTip->image)
                        <img class="" style="width: 50px; height: 50px;" src="{{ asset('storage/' . $mainTip->image) }}" alt="">
                        @endif
                    </td>

                    <td>
                          <a class="btn btn-info btn-rounded" href="{{ route('sup-tips',$mainTip->id) }}">
                            <i class="fa fa-cart-plus text-white"></i>
                        </a> &nbsp;
                        <button class="btn btn-success btn-rounded" wire:click="edit({{ $mainTip->id }})" >
                            <i class="fa fa-edit text-white"></i>
                        </button> &nbsp;
                        <button class="btn btn-danger btn-rounded" wire:click="delete({{ $mainTip->id }})" >
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



    </div>
</div>
