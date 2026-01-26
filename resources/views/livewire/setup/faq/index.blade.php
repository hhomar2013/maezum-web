<div>
    <div class="card">
        <div class="card-header">
            <h5>{{ __('FAQ') }}</h5>
            @if($add || $update)
            <button wire:click="loadFaqs" class="btn btn-secondary mb-3 btn-rounded">
                {{ __('Back To') .' '. __('FAQ') }}
            </button>
            @else
            <button wire:click="$set('add', true)" class="btn btn-primary mb-3 btn-rounded">
               {{ __('Add New') }}
            </button>
            @endif
        </div>
        <br>
        <div class="card-body text-dark">

            @if ($add)
            @livewire('setup.faq.form')
            @elseif($update )
            @livewire('setup.faq.form' ,['id' => $update])
            @else
            <ul class="list-group">
                @foreach($faqs as $faq)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="col-10">
                        <strong>{{ $faq->question }}</strong><br>
                        <small>{{Str::limit($faq->answer,100) }}</small>
                    </div>
                    <div class="col-2 d-flex justify-content-end">
                        <button wire:click="editFaq({{ $faq->id }})" class="btn btn-sm btn-warning btn-rounded">{{ __('Update') }}</button>&nbsp;
                        <button wire:click="delete({{ $faq->id }})" class="btn btn-sm btn-danger btn-rounded">{{__('Delete')}}</button>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
