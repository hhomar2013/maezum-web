<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col text-left">
                <h5 class="card-title">
                    {{ __('Offers') }}
                </h5>
            </div>
            <div class="col text-center">
                @include('tools.spinner')
            </div>
            <div class="col text-right">

            </div>
        </div>
        <hr>

        <div class="basic-form">
            <form>

                <div class="form-row">
                    <div class="form-group col-lg-4 ">
                        <h3>{{ __('Are you sure?') }}</h3>

                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-danger btn-rounded" wire:click.prevent="deleteOffers('{{ $offer->id }}')">
                    <i class="fa fa-times"></i>
                    {{ __('Delete') }}
                </button> &nbsp;
                <button type="submit" wire:click.prevent="reserForm" class="btn btn-warning btn-rounded text-white">
                    {{__('Back')}}
                    <i class="fa fa-arrow-left"></i>
                </button>

            </form>
        </div>

    </div>
</div>

