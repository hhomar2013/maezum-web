<div>
    @section('title')
        {{ __('Dashboard') }}
    @endsection
    @include('tools.page_header')
    <hr>
    <button class="btn btn-primary" wire:click="testNotification">Send Notification</button>
    <hr>
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        {{-- <i class="ti-shopping-cart text-success border-success"></i> --}}
                        <i class="ti-shopping-cart-full text-dark border-dark"></i>
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">{{ __('Stores') }}</div>
                        <div class="stat-digit">{{ $stores }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-user text-primary border-primary"></i>
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">{{ __('Vendors') }}</div>
                        <div class="stat-digit">{{ $vendors }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-layout-grid2 text-pink border-pink"></i>
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">{{ __('Products') }}</div>
                        <div class="stat-digit" wire:poll.5s="updateProducts">{{ $products }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-ticket text-success border-success"></i>
                        {{-- <i class="fa-solid fa-ticket"></i> --}}
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">{{ __('Coupons') }}</div>
                        <div class="stat-digit">{{ $coupons }}</div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-gift text-info border-info"></i>
                        {{-- <i class="fa-solid fa-ticket"></i> --}}
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">{{ __('Offers') }}</div>
                        <div class="stat-digit">{{ $offers }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-xl-4 col-xxl-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Timeline</h4>
                </div>
                <div class="card-body">
                    <div class="widget-timeline">
                        <ul class="timeline">
                            <li>
                                <div class="timeline-badge primary"></div>
                                <a class="timeline-panel text-muted" href="#">
                                    <span>10 minutes ago</span>
                                    <h6 class="m-t-5">Youtube, a video-sharing website, goes live.</h6>
                                </a>
                            </li>

                            <li>
                                <div class="timeline-badge warning">
                                </div>
                                <a class="timeline-panel text-muted" href="#">
                                    <span>20 minutes ago</span>
                                    <h6 class="m-t-5">Mashable, a news website and blog, goes live.</h6>
                                </a>
                            </li>

                            <li>
                                <div class="timeline-badge danger">
                                </div>
                                <a class="timeline-panel text-muted" href="#">
                                    <span>30 minutes ago</span>
                                    <h6 class="m-t-5">Google acquires Youtube.</h6>
                                </a>
                            </li>

                            <li>
                                <div class="timeline-badge success">
                                </div>
                                <a class="timeline-panel text-muted" href="#">
                                    <span>15 minutes ago</span>
                                    <h6 class="m-t-5">StumbleUpon is acquired by eBay. </h6>
                                </a>
                            </li>

                            <li>
                                <div class="timeline-badge warning">
                                </div>
                                <a class="timeline-panel text-muted" href="#">
                                    <span>20 minutes ago</span>
                                    <h6 class="m-t-5">Mashable, a news website and blog, goes live.</h6>
                                </a>
                            </li>

                            <li>
                                <div class="timeline-badge dark">
                                </div>
                                <a class="timeline-panel text-muted" href="#">
                                    <span>20 minutes ago</span>
                                    <h6 class="m-t-5">Mashable, a news website and blog, goes live.</h6>
                                </a>
                            </li>

                            <li>
                                <div class="timeline-badge info">
                                </div>
                                <a class="timeline-panel text-muted" href="#">
                                    <span>30 minutes ago</span>
                                    <h6 class="m-t-5">Google acquires Youtube.</h6>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>




@script
    <script>
        Livewire.on('play-notification-sound', () => {
            const audio = new Audio(`storage/sounds/${data.sound}`);
            audio.play();
        });
    </script>
@endscript


@script
    <script>
        $wire.on('message', (event) => {
            // window.livewire.on('message', (event) => {
            Swal.fire({
                position: "top-start",
                icon: "success",
                title: event.message,
                showConfirmButton: false,
                timer: 1500
            });
        });
    </script>
@endscript
