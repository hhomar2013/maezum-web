<?php

namespace App\Livewire\VendorSide\Status;

use App\Helpers\WithPreviewHelper;
use App\Models\VendorStatus;
use Livewire\Component;
use Livewire\WithFileUploads;

class StatusComponent extends Component
{
    use WithFileUploads, WithPreviewHelper;

    public $type = 'text';
    public $content;
    public $colors;
    public $font_color;
    public $editing = false;
    public $imagePreview = null, $extention = null;
    public $image = null;
    public $file;
    public $myStatus;
    public function mount()
    {
        $this->type = 'text';
        $this->content = '';
        $this->font_color = '#ffffff';
        $this->colors = '#000000';
        $this->myStatus = VendorStatus::query()->where('vendor_id', auth()->id())->get();
    }

    public function updatedFile()
    {
        $extention = $this->file->getClientOriginalExtension(); // مثل jpg أو mp4

        if (in_array($extention, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $this->extention = 'image';
            $this->imagePreview = $this->file->temporaryUrl();
        } elseif (in_array($extention, ['mp4', 'mov', 'avi', 'webm'])) {
            $this->extention = 'video';
        } else {
            // غير مدعوم
        }
    }

    public  function save()
    {
        $this->validate(
            [
                'type' => 'required',
                'colors' => 'required',
                'font_color' => 'required',
                'file' => 'nullable',
            ]
        );
        if ($this->type === 'file' && $this->file) {
            $path = $this->file->store('VendorStatus', 'public');
            $this->content = $path;
        }

        $save = VendorStatus::query()->create([
            'vendor_id' => auth()->id(),
            'type' => $this->extention ?? 'text',
            'content' => $this->content,
            'background_color' => [
                'backgroud' => $this->colors,
                'font_color' => $this->font_color
            ],
            'expires_at' => now()->addHour(24),
        ]);

        if ($save) {
            $this->mount();
            $this->dispatch('message', message: __('Done Save'));
        }
    }

    public function delete($id)
    {
        $delete = VendorStatus::query()->where('id', $id)->delete();
        if ($delete) {
            $this->mount();
            $this->dispatch('message', message: __('Done Delete'));
        }
    }


    public function render()
    {
        return view('livewire.vendor-side.status.status-component')->extends('layouts.app');
    }
}
