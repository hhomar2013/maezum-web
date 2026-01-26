<?php

namespace App\Livewire\Setup\SupTips;

use App\Models\main_tips;
use App\Models\SubTip;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SuptipsComponet extends Component
{
    use WithFileUploads;

    public $mainTipId, $mainTipTitle;
    public $subTips, $content = '', $type = 'text', $colors = '#000', $font_color = "#FFFFFF", $file, $editing = false, $subTipId;
    public $imagePreview = null, $extention = null;
    public $image = null;
    public function mount($mainTipId)
    {
        $this->mainTipId = $mainTipId;
        $this->mainTipTitle = main_tips::findOrFail($mainTipId)->title;
        $this->load();
    }

    public function load()
    {
        $this->subTips = SubTip::where('main_tip_id', $this->mainTipId)->get();
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

    public function save()
    {
        $this->validate([
            'type' => 'required|in:text,file',
            'content' => 'required_if:type,text|nullable|string',
            'file' => 'nullable',
        ]);

        if ($this->type === 'file' && $this->file) {
            $path = $this->file->store('SupTips', 'public');
            $this->content = Storage::url($path);
        }

        if ($this->editing && $this->subTipId) {
            SubTip::findOrFail($this->subTipId)->update([
                'type' => $this->type,
                'content' => $this->content,
                'hex_color' => [
                    'background' => $this->colors,
                    'font_color' => $this->font_color,
                ],
            ]);
        } else {
            SubTip::create([
                'main_tip_id' => $this->mainTipId,
                'type' => $this->type,
                'content' => $this->content,
                'hex_color' => [
                    'background' => $this->colors,
                    'font_color' => $this->font_color,
                ],
            ]);
        }

        $this->reset(['type', 'content', 'file', 'editing', 'subTipId']);
        $this->load();
    }

    public function edit($id)
    {
        $tip = SubTip::findOrFail($id);
        $this->type = $tip->type;
        $this->content = $tip->content;
        $this->subTipId = $tip->id;
        $this->colors = $tip->hex_color['background'];
        $this->font_color = $tip->hex_color['font_color'];
        $this->editing = true;
    }

    public function delete($id)
    {
        SubTip::destroy($id);
        $this->load();
    }

    public function render()
    {
        return view('livewire.setup.sup-tips.suptips-componet')->extends('layouts.app');
    }
}
