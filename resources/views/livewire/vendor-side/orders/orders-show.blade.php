<div>
    @section('title', $orderId)
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0 fw-bold">تفاصيل الطلب</h5>
            <button class="btn btn-outline-danger btn-rounded" wire:click="back">
                <i class="fa fa-arrow-left"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="container-fluid mt-4 text-dark">
                <!-- ===== Top Section ===== -->
                <div class="row g-3">
                    <div class="col-12">
                        <h5 class=" fw-bold text-danger"># : {{ $orderHead->id }}</h5>
                    </div>
                    <!-- Client Info -->
                    <div class="col-lg-8">
                        <div class="card shadow ">
                            <div class="card-header fw-bold bg-danger text-white">
                                <h5 class="text-white">بيانات العميل</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-2">
                                    <i class="bi bi-person-fill me-2 text-primary"></i>
                                    الاسم: <span class="fw-normal">{{ $orderHead->customer->name }}</span>
                                </h6>
                                <h6 class="mb-2">
                                    <i class="bi bi-telephone-fill me-2 text-success"></i>
                                    رقم الهاتف: <span class="fw-normal">{{ $orderHead->customer->phone }}</span>
                                </h6>
                                <h6 class="mb-0">
                                    <i class="bi bi-geo-alt-fill me-2 text-danger"></i>
                                    العنوان: <span class="fw-normal">{{ $orderHead->customer->address }}</span>
                                </h6>
                            </div>
                        </div>
                    </div>

                    <!-- Order Status -->
                    <div class="col-lg-4">
                        <div class="card shadow">
                            <div class="card-header fw-bold bg-danger text-white">
                                حالة الطلب
                            </div>
                            <div class="card-body">
                                <select class="form-control" wire:model.live="status_id">
                                    َ@foreach ($status as $key => $val)
                                        <option value="{{ $key }}">{{ $val }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" wire:click.prevent="changeStatus">تحديث الحالة</button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ===== Order Details Table ===== -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light fw-bold">
                                تفاصيل الأوردر
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive ">
                                    <table class="table table-striped table-bordered mb-0 ">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>اسم المنتج</th>
                                                <th>الكمية</th>
                                                {{-- <th>المتغير</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->item->name }}</td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ $item->quantity }}</span>
                                                    </td>
                                                    {{-- <td>{{ $item->variations->first()->name ?? 'لا يوجد متغير' }}</td> --}}
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


</div>
@script
    @include('tools.message')
@endscript
