<div class="card">
    <div class="card-body">
        @include('tools.body_head_with_spinner_new',['pageTitleNew'=>__('Coupons')])

        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('Coupon Code') }}</th>
                <th scope="col">{{ __('Coupon Discount') }}</th>
                <th scope="col">{{ __('status') }}</th>
                <th scope="col"><i class="fa fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
                <?php $i = App\Helpers\PaginationHelper::getStartingNumber($coupons); ?>
                @forelse ($coupons as  $coupon)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <td>{{ $coupon->code }}</td>
                    <td>
                        {{ $coupon->discount }} %
                    </td>
                    <td>
                        @livewire('switcher', ['model' => $coupon, 'field' => 'status'], key("cat-".$coupon->id))
                    </td>
                    <td>
                        <button class="btn btn-success btn-rounded" wire:click="edit({{ $coupon->id }})" >
                            <i class="fa fa-edit text-white"></i>
                        </button> &nbsp;
                        <button class="btn btn-danger btn-rounded" wire:click="delete({{ $coupon->id }})" >
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
            {{ $coupons->links() }}
        </div>

    </div>
</div>
