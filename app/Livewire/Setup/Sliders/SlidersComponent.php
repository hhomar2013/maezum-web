<?php

namespace App\Livewire\Setup\Sliders;

use App\Models\sliders;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class SlidersComponent extends Component
{
    use WithPagination, WithFileUploads;
    public $add = false;
    public $update = false;
    public $slider;
    public $numbers = 5;
    protected $listeners = ['refreshSliders' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    public $title, $image, $discription, $editImage;


    public function reserForm()
    {
        $this->reset(['title', 'image', 'discription']);
        $this->resetValidation();
        $this->resetPage();
        $this->add = false;
        $this->update = false;
        $this->title;
        $this->image;
        $this->discription;
        $this->dispatch('refreshSliders');
    }


    public function pagenateNumber()
    {
        $this->reserForm();
        $this->resetPage();
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'image' => 'required',
            'discription' => 'nullable|string',
        ]);

        $imagePath = $this->image->store('sliders', 'public');

        sliders::create([
            'title' => $this->title,
            'image' => $imagePath,
            'discription' => $this->discription,
        ]);

        $this->reserForm();
        $this->add = false;
        $this->dispatch('message', message: __('Done Save'));
    }

    public function edit($id)
    {
        $slider = sliders::findOrFail($id);
        $this->title = $slider->title;
        // $this->image = $slider->image;
        $this->discription = $slider->discription;
        $this->update = $id;
        $this->add = true;
        $this->slider = $slider;
    }

    public function updateSliders()
    {
        $id = $this->slider->id;
        $this->validate([
            'title' => 'required|string|max:255',
        ]);

        $slider = sliders::find($id);

        if ($this->image && is_object($this->image)) {
            $this->validate(['image' => 'image']);
            $imageName = $this->image->store('sliders', 'public');
            $slider->image = $imageName;
        }

        $slider->title = $this->title;
        $slider->discription = $this->discription;
        $slider->save();


        $this->dispatch('message', message: __('Done Update'));

        $this->reserForm();
        $this->update = false;
    }

    public function delete($id)
    {
        $slider = sliders::findOrFail($id);
        $slider->delete();

        $this->reserForm();
        $this->dispatch('message', message: __('Done Delete'));
    }


    public function render()
    {
        $sliders = sliders::query()->paginate($this->numbers);
        return view('livewire.setup.sliders.sliders-component', ['sliders' => $sliders]);
    }
}
