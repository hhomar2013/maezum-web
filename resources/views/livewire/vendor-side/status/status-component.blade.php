<div>
    @section('title', __('Status'))
    <h2 class="text-xl font-bold mb-4"> 📰 {{ __('Status') }}</h2>
    <div class="row">
        <div class="col-lg-6">
            <form wire:submit.prevent="save">



                <div class="mb-2">
                    <select wire:model.live="type" class="border p-2 rounded">
                        <option value="text">{{ __('Text') }}</option>
                        <option value="file">{{ __('Files') }}</option>
                    </select>
                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                @if ($type === 'text')
                    <div class="row">
                        <div class="col-3">
                            <label for="myColor" class="form-label">{{ __('Background Color') }}</label>
                            <input wire:model.live="colors" type="color" class="form-control form-control-color"
                                id="myColor" value="#CCCCCC" title="Choose a color">
                            @error('colors') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>


                        <div class="col-3">
                            <label for="myFontColor" class="form-label">{{ __('Font Color') }}</label>
                            <input wire:model.live="font_color" type="color" class="form-control form-control-color"
                                id="myFontColor" value="#CCCCCC" title="Choose a color">
                            @error('font_color') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    <hr>
                    <label for="">{{ __('Hint content') }}</label>
                    <textarea wire:model.live="content" placeholder="أكتب حالتك هنا" class="form-control w-full p-2 border rounded mb-2" rows="10"></textarea>
                    @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                @else
                    <label for="file"
                        class="btn btn-primary rounded p-4 cursor-pointer">{{ __('Choose File') }}</label>
                    <input type="file" id="file" wire:model="file" class="mb-2" hidden>
                    @error('file') <span class="text-danger">{{ $message }}</span> @enderror
                @endif
                <hr>
                <button type="submit" wire:loading.attr="disabled"
                    class="btn btn-primary px-4 py-2 rounded">{{ $editing ? __('Update') : __('Save') }}</button>




            </form>
        </div>
        @if ($type === 'text')
            <div class="col-lg-3">
                <div
                    style="height: 500px; background-color: {{ $colors }};
                 border-radius: 10px; margin-top: 10px; display: flex; align-items: center; justify-content: center;">

                    <p class="text-center"
                        style="color: {{ $font_color }};
                        font-size: 20px;

                    margin: 0;">

                        {!! $content != '' ? nl2br(e($content)) : 'أكتب حالتك هنا' !!}</p>

                </div>
            </div>
        @else
            <div class="col-lg-3">
                @if ($extention)
                    @if ($extention == 'image')
                        @if ($file)
                            <img src="{{ $file ? $this->getPreviewUrl($file) : '' }}" alt="" srcset=""
                                class="w-full h-full object-cover"
                                style="width: 100%;height: 500px;border-radius: 10px; margin-top: 10px; display: flex; align-items: center; justify-content: center;">
                        @endif
                    @else
                        <div style="height: 500px;">
                            <video autoplay muted loop playsinline
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: fill; z-index: 0;">
                                <source src="{{ $file ? $file->temporaryUrl() : '' }}" type="video/mp4">
                                المتصفح لا يدعم تشغيل الفيديو
                            </video>
                        </div>
                    @endif
                @endif
                <hr>
                @include('tools.spinner', ['action' => 'file'])
            </div>
        @endif
    </div>


    <hr class="my-4">

    <ul class="list-group list-group-numbered">
        @foreach ($myStatus as $tip)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    @if ($tip->type === 'text')
                        <p>{{ $tip->content }}</p>
                    @else
                        @php $ext = pathinfo($tip->content, PATHINFO_EXTENSION); @endphp
                        @if (in_array($ext, ['mp4', 'webm', 'ogg']))
                            <video controls class="w-40 h-24">
                                <source src="{{ asset($tip->content) }}">
                            </video>
                        @else
                            <img style="height: 150px; width: 100px" src="{{ asset($tip->content) }}"
                                class="w-24 h-24 object-cover">
                        @endif
                    @endif
                </div>
                <div>

                    <button wire:click="delete({{ $tip->id }})"
                        class="btn btn-danger">{{ __('Delete') }}</button>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@script
    @include('tools.message')
@endscript
