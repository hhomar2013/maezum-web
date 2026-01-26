<div>

    <div class="card shadow">

        <div class="card-body text-dark">
            <div class="row">
                <div class="col text-right">
                    @include('tools.spinner')
                 </div>
                <div class="col text-right">
                    <button class="btn btn-rounded btn-danger" wire:click.prevent="navigateTo('show.product')">
                        {{ __('Back') }} <i class="fa fa-arrow-left"></i>
                    </button>
                </div>

            </div>

            {{-- @include('tools.spinner') --}}
            <ul class="nav nav-pills mb-4">
                <li class=" nav-item">
                    <a href="#" class="nav-link {{ $activeTab === 'tab1' ? 'active' : '' }}"
                     data-toggle="tab" aria-expanded="false"
                     wire:click.prevent="selectTab('tab1')"
                     >
                        <i class="fa-solid fa-circle-info"></i>&nbsp;
                        {{__('Product details')}}</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ $activeTab === 'tab2' ? 'active' : '' }}"
                    data-toggle="tab" aria-expanded="false"
                    wire:click.prevent="selectTab('tab2')"
                    >
                        <i class="fa-solid fa-images"></i>&nbsp;
                        {{__('Product Image')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ $activeTab === 'tab3' ? 'active' : '' }}"
                    data-toggle="tab" aria-expanded="false"
                    wire:click.prevent="selectTab('tab3')"
                    >
                    <i class="fa-solid fa-rectangle-list"></i>&nbsp;
                    {{__('Variants')}}
                </a>

                <li class="nav-item">
                    <a href="#" class="nav-link {{ $activeTab === 'tab4' ? 'active' : '' }}"
                    data-toggle="tab" aria-expanded="false"
                    wire:click.prevent="selectTab('tab4')"
                    >
                    <i class="fa-solid fa-puzzle-piece"></i>&nbsp;
                    {{__('Addons')}}
                </a>
                </li>
            </ul>
            <div class="tab-content">
                <div  class="tab-pane {{ $activeTab === 'tab1' ? 'active' : '' }}">
                    @include('livewire.setup.products.product-info-tab')
                </div>
                <div id="navpills-2" class="tab-pane {{ $activeTab === 'tab2' ? 'active' : '' }}">
                    @include('livewire.setup.products.product-image-tab')
                </div>
                <div  class="tab-pane {{ $activeTab === 'tab3' ? 'active' : '' }}">
                    @include('livewire.setup.products.product-variant-tab')
                </div>
                <div  class="tab-pane {{ $activeTab === 'tab4' ? 'active' : '' }}">
                    @include('livewire.setup.products.product-addons-tab')
                </div>
            </div>
        </div>
    </div>
</div>
