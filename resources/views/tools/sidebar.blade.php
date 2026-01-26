<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">{{ __('Main Menu') }}</li>
            <li><a href="{{ route('dashboard') }}" class="">
                 {{-- <i class="icon icon-home"></i> --}}
                <i class="fa-solid fa-house"></i>
                 <span class="nav-text">{{ __('Dashboard') }}</span></a>
            </li>

            <li class="{{ Route::is(['products','product.*']) ? 'mm-active' : '' }}"><a href="{{ route('products') }}" class="">
                <i class="fa-solid fa-list-ul"></i>
                <span  class="nav-text">{{ __('Products') }}</span></a>
            </li>


            <li class="{{ Route::is(['admin.orders','admin.orders.*']) ? 'mm-active' : '' }}"><a href="{{ route('admin.orders') }}" class="">
                <i class="fa-solid fa-shopping-cart"></i>
                <span  class="nav-text">{{ __('Orders') }}</span></a>
            </li>

            <li class="nav-label">{{ __('Promo') }}</li>
            <li class="{{ Route::is(['offers','offers.*']) ? 'mm-active' : '' }}"><a href="{{ route('offers') }}" class="">
                <i class="fa-solid fa-hand-holding-dollar"></i>
                <span  class="nav-text">{{ __('Offers') }}</span></a>
            </li>

           <li><a href="{{ route('coupons') }}" class="">
                <i class="fa-solid fa-ticket"></i>
                <span  class="nav-text">{{ __('Coupons') }}</span></a>
            </li>


            <li class="nav-label first">{{ __('Reports') }}</li>
            <li><a href="{{ route('dashboard') }}" class="">
                 {{-- <i class="icon icon-home"></i> --}}
                 <i class="fa-solid fa-file-invoice"></i>
                 <span class="nav-text">{{ __('Dashboard') }}</span></a>
            </li>
            @can('AdminDashboard')
            <li class="nav-label">{{ __('Setup') }}</li>
            {{-- <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="fa fa-cog"></i><span class="nav-text">{{ __('Product Management') }}</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('products') }}">{{ __('Add New Product') }}</a></li>
                    <li><a href="app-calender.html">{{ __('Addons') }}</a></li>
                </ul>
            </li> --}}

            <li class="{{ Route::is('settings') ? 'mm-active' : '' }}"><a href="{{ route('settings') }}" >
                <i class="fa fa-cog"> </i>&nbsp;<span
               class="nav-text">{{ __('Settings') }}</span></a>
            </li>

            <li class="{{ Route::is('areas') ? 'mm-active' : '' }}"><a href="{{ route('areas') }}" >
                <i class="fa fa-map"> </i>&nbsp;<span
               class="nav-text">{{ __('Areas') }}</span></a>
            </li>
            @endcan

        </ul>
    </div>


</div>
