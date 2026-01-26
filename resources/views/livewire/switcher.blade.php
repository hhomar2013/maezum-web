<div>
    <div class="custom-control custom-switch">
        <input class="custom-control-input " type="checkbox" id="toggle-{{ $model->id }}" wire:model.live="isPublished" name="toggle-{{ $model->id }}">
        <label class="custom-control-label" id="toggle-{{ $model->id }}" for="toggle-{{ $model->id }}"></label>
    </div>
</div>


{{-- @script
   @include('tools.message')
@endscript --}}
