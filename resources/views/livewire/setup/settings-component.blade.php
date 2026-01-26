<div>
    @section('title')
        {{ __('Settings') }}
    @endsection
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <div class="list-group list-group-flush pb-1">
                            <a href="#" class="list-group-item list-group-item-action rounded {{ $navigate == 'general' ? 'active' :'' }}"
                                wire:click.prevent="navigateTo('general')">
                                {{-- <i class="fa fa-globe"></i> --}}
                                <i class="fa-solid fa-earth-asia"></i>
                                <span class="nav-text">{{ __('General Settings') }} </span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action rounded {{ $navigate == 'categories' ? 'active' :'' }}"
                            wire:click.prevent="navigateTo('categories')">
                            {{-- <i class="fa-solid fa-bars"></i> --}}
                            <i class="{{ $navigate == 'categories' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle'}}"></i> &nbsp;                                <span
                               class="nav-text">{{ __('Categories') }}</span>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action rounded {{ $navigate == 'attributes' ? 'active' :'' }}"
                            wire:click.prevent="navigateTo('attributes')">
                                {{-- <i class="fa-solid fa-bars"></i> --}}
                                {{-- <i class="fa-regular fa-circle-dot"></i> --}}
                                <i class="{{ $navigate == 'attributes' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle'}}"></i> &nbsp;
                                 <span
                               class="nav-text">{{ __('Attributes') }}</span>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action rounded {{ $navigate == 'addons' ? 'active' :'' }}"
                            wire:click.prevent="navigateTo('addons')">
                            <i class="{{ $navigate == 'addons' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle'}}"></i> &nbsp;
                                 <span
                               class="nav-text">{{ __('Addons') }}</span>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action rounded {{ $navigate == 'roles' ? 'active' :'' }}"
                            wire:click.prevent="navigateTo('roles')">
                            <i class="{{ $navigate == 'roles' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle'}}"></i> &nbsp;
                                 <span
                               class="nav-text">{{ __('Roles & Permissions') }}</span>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action rounded {{ $navigate == 'stores' ? 'active' :'' }}"
                            wire:click.prevent="navigateTo('stores')">
                            <i class="{{ $navigate == 'stores' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle'}}"></i> &nbsp;
                                 <span
                               class="nav-text">{{ __('Stores') }}</span>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action rounded {{ $navigate == 'vendors' ? 'active' :'' }}"
                            wire:click.prevent="navigateTo('vendors')">
                            <i class="{{ $navigate == 'vendors' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle'}}"></i> &nbsp;
                                 <span
                               class="nav-text">{{ __('Vendors') }}</span>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action rounded {{ $navigate == 'sliders' ? 'active' :'' }}"
                            wire:click.prevent="navigateTo('sliders')">
                            <i class="{{ $navigate == 'sliders' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle'}}"></i> &nbsp;
                                 <span
                               class="nav-text">{{ __('Sliders') }}</span>
                            </a>

                             <a href="#" class="list-group-item list-group-item-action rounded {{ $navigate == 'hints' ? 'active' :'' }}"
                            wire:click.prevent="navigateTo('hints')">
                            <i class="{{ $navigate == 'hints' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle'}}"></i> &nbsp;
                                 <span
                               class="nav-text">{{ __('Hints') }}</span>
                            </a>


                             <a href="#" class="list-group-item list-group-item-action rounded {{ $navigate == 'faq' ? 'active' :'' }}"
                            wire:click.prevent="navigateTo('faq')">
                            <i class="{{ $navigate == 'faq' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle'}}"></i> &nbsp;
                                 <span
                               class="nav-text">{{ __('FAQ') }}</span>
                            </a>


                            <a href="#" class="list-group-item list-group-item-action rounded {{ $navigate == 'terms' ? 'active' :'' }}"
                            wire:click.prevent="navigateTo('terms')">
                            <i class="{{ $navigate == 'terms' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle'}}"></i> &nbsp;
                                 <span
                               class="nav-text">{{ __('Terms') }}</span>
                            </a>


                             <a href="#" class="list-group-item list-group-item-action rounded {{ $navigate == 'payment_methods' ? 'active' :'' }}"
                            wire:click.prevent="navigateTo('payment_methods')">
                            <i class="{{ $navigate == 'payment_methods' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle'}}"></i> &nbsp;
                                 <span
                               class="nav-text">{{ __('Payment Methods') }}</span>
                            </a>


                          </div>
                    </div>
                </div>
            </div>

            <div class="col-8">

                @switch($navigate)
                    @case('general')
                        @livewire('setup.general-component')
                        @break
                    @case('categories')
                        @livewire('setup.categories-component')
                        @break
                    @case('attributes')
                        @livewire('setup.attributes-component')
                        @break
                    @case('addons')
                        @livewire('setup.addons.addons-component')
                        @break
                    @case('roles')
                        @livewire('roles')
                    @break
                    @case('roles.permissions')
                        @livewire('permissions')
                    @break
                    @case('stores')
                        @livewire('setup.stores.stores-component')
                    @break
                    @case('vendors')
                        @livewire('setup.vendors.vendors-component')
                    @break
                    @case('sliders')
                        @livewire('setup.sliders.sliders-component')
                    @break
                    @case('hints')
                        @livewire('setup.main-tips.main-tips-component')
                    @break
                     @case('faq')
                        @livewire('setup.faq.index')
                    @break
                      @case('terms')
                        @livewire('setup.terms.index')
                    @break
                     @case('payment_methods')
                        @livewire('setup.payment-methodes.manage')
                    @break
                    @default
                @endswitch
            </div>
        </div>
</div>
@script
    @include('tools.message')
@endscript
@script
   <script>
     document.addEventListener('livewire:init', () => {
        Livewire.on('update-url', (navigate) => {
            history.pushState(null, '', `?navigate=${navigate.navigate}`);
        });
    });
   </script>
@endscript

