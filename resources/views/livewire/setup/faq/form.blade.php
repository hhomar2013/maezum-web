<div>
    <form wire:submit.prevent="save">
        <div class="form-group">
            <label>السؤال</label>
            <input type="text" class="form-control" wire:model.defer="question">
            @error('question') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>الإجابة</label>
            <textarea class="form-control" wire:model.defer="answer"></textarea>
            @error('answer') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-rounded px-4">حفظ</button>
    </form>
</div>
