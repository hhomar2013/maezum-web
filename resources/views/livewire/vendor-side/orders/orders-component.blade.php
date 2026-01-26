<div>
    @section('title', __('Orders'))
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('Orders') }}</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped verticle-middle table-responsive-sm text-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"> {{ __('Order Number') }} </th>
                            <th scope="col"> {{ __('customer') }} </th>
                            <th scope="col"> {{ __('Phone Number') }} </th>
                            <th scope="col"> {{ __('total') }} </th>
                            <th scope="col"> {{ __('Order Date') }} </th>
                            <th scope="col"> {{ __('Order Time') }} </th>
                            <th scope="col"> {{ __('Status') }} </th>
                            <th scope="col"> {{ __('Action') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ $order->customer->phone }}</td>
                                <td>{{ $order->total }} {{ $currency }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('h:i A') }}</td>

                                <td><span
                                        class="badge rounded-pill text-white {{ $order->status === 'delivered' ? 'bg-success' : ($order->status === 'pending' ? 'bg-warning' : ($order->status === 'cancelled' ? 'bg-danger' : 'bg-dark')) }}">
                                        @foreach ($status as $key => $val)
                                            @if ($order->status == $key)
                                                {{ $val }}
                                            @endif
                                        @endforeach
                                    </span>
                                </td>
                                <td>
                                    @if ($order->status !== 'cancelled' && $order->status !== 'delivered')
                                        <span><a href="{{ route('vendors.orders.show', $order->id) }}"
                                                class="mr-4 btn btn-primary btn-rounded" data-toggle="tooltip"
                                                data-placement="top" title="View"><i class="fa fa-eye"></i>
                                            </a></span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
