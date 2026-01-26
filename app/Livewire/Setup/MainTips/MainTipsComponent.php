<?php

namespace App\Livewire\Setup\MainTips;

use App\Models\main_tips;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MainTipsComponent extends Component
{
   use WithFileUploads;

    public $title = '', $image, $imagePreview = '', $editing = false, $mainTipId , $add =false;
    public $mainTips;

    public function mount() { $this->load(); }

    public function load() { $this->mainTips = main_tips::query()->get(); }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'nullable|image|max:10240',
        ]);

        $this->imagePreview = $this->image?->temporaryUrl();
    }

    public function save() {
        $this->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:10240'
        ]);

            $pathImage = $this->image->store('tips', 'public');

        if ($this->editing && $this->mainTipId) {
            // main_tips::findOrFail($this->mainTipId)->update($data);
        } else {
            main_tips::create([
                'title' => $this->title,
                'image' => $pathImage ?? null,
            ]);
            $this->dispatch('message',message: __('Done Save'));
        }

        $this->reset(['title', 'image', 'imagePreview', 'editing', 'mainTipId','add']);
        $this->load();
    }

    public function edit($id) {
        $tip = main_tips::findOrFail($id);
        $this->title = $tip->title;
        $this->mainTipId = $tip->id;
        $this->imagePreview = $tip->image;
        $this->editing = true;
        $this->add = true;
    }

    public function delete($id) {
        main_tips::destroy($id);
        $this->load();
    }

    public function render()
    {
        return view('livewire.setup.main-tips.main-tips-component');
    }
}
