<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">{{ __('Main Menu') }}</li>
            <li><a href="{{ route('vendors.dashboard') }}" class="">
                    {{-- <i class="icon icon-home"></i> --}}
                    <i class="fa-solid fa-house"></i>
                    <span class="nav-text">{{ __('Dashboard') }}</span></a>
            </li>

            <li class="{{ Route::is(['vendors.orders', 'vendors.orders.*']) ? 'mm-active' : '' }}"><a
                    href="{{ route('vendors.orders') }}" class="">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="nav-text">{{ __('Orders') }}</span></a>
            </li>

            <li class="nav-label">{{ __('Settings') }}</li>
            <li class="{{ Route::is(['vendors.section', 'vendors.section.*']) ? 'mm-active' : '' }}"><a
                    href="{{ route('vendors.section') }}" class="">
                    <i class="fa-solid fa-list-ul"></i>
                    <span class="nav-text">{{ __('Categories') }}</span></a>
            </li>

            <li class="{{ Route::is(['vendors.items', 'vendors.items.*']) ? 'mm-active' : '' }}"><a
                    href="{{ route('vendors.items') }}" class="">
                    <i class="fa-solid fa-list-ul"></i>
                    <span class="nav-text">{{ __('Products') }}</span></a>
            </li>

            <li class="{{ Route::is(['vendors.status', 'vendors.status.*']) ? 'mm-active' : '' }}"><a
                    href="{{ route('vendors.status') }}" class="">
                    <i class="fa-solid fa-list-ul"></i>
                    <span class="nav-text">{{ __('Status') }}</span></a>
            </li>
            {{-- <li class="{{ Route::is(['products','product.*']) ? 'mm-active' : '' }}"><a href="{{ route('products') }}" class="">
                    <i class="fa-solid fa-store"></i>
                    <span class="nav-text">{{ __('Orders') }}</span></a>
            </li> --}}
        </ul>
    </div>
</div>
