<div>
    <form wire:submit.prevent="save" class="text-dark">
        <div class="form-group mb-3">
            <label>العنوان</label>
            <input type="text" class="form-control" wire:model="title">
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group mb-3">
            <label>المحتوى</label>
            <textarea class="form-control" rows="5" wire:model="content"></textarea>
            @error('content') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-success">حفظ</button>
    </form>
</div>
