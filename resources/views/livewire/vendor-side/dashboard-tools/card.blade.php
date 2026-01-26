    <div class="col-lg-3 col-sm-6">
        <div class="card shadow" style="border-radius: 6%">
            <div class="stat-widget-two card-body ">
                <div class="stat-content">
                    <div class="stat-text">{{ $title }}</div>
                    <div class="stat-digit">
                        <h1>
                            <b>{{ $total }}</b>
                        </h1>
                    </div>
                </div>
                <div class="">
                    <hr>
                    <a href="{{ route($route) }}" class="btn btn-primary btn-rounded">
                        {{ __('Load More') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
