<div>
<div class="card">
    <div class="card-header text-white">
        <h4>{{ __('Terms') }}</h4><br>
        @if($add || $update)
        <a wire:click="loadTerms" class="btn btn-secondary mb-3  btn-rounded">{{ __('Back To') .' '. __('Terms') }}</a>
        @else
         <a wire:click="$set('add',true)" class="btn btn-primary mb-3  btn-rounded">{{ __('Add New') }}</a>

        @endif
    </div>
    <div class="card-body text-dark">
        @if ($add)
        @livewire('setup.terms.form')
        @elseif ($update)
        @livewire('setup.terms.form', ['id' => $update])
        @else
        <ul class="list-group">
            @foreach($terms as $term)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="col-10">
                    <strong>{{ $term->title }}</strong><br>
                    <small>{{ Str::limit($term->content, 200) }}</small>
                </div>
                <div class="col-2 d-flex justify-content-end">
                    <button wire:click="editTerm({{ $term->id }})" class="btn btn-sm btn-warning btn-rounded">{{ __('Update') }}</button> &nbsp;
                    <button wire:click="delete({{ $term->id }})" class="btn btn-sm btn-danger btn-rounded">{{ __('Delete') }}</button>
                </div>
            </li>
            @endforeach
        </ul>
        @endif
    </div>

</div>


</div>


