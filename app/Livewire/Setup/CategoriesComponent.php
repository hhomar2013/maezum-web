<?php

namespace App\Livewire\Setup;

use App\Models\Categories;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CategoriesComponent extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh-categories' => '$refresh'];
    public $addCategory = false;
    public $updateCategory = false;
    public $arName,$enName;
    public $logo;
    public $CategoryFitch;
    public $numbers = 5;
    public $search='';

    public function reset_form()
    {
        $this->reset(['arName','enName', 'logo', 'addCategory', 'updateCategory','CategoryFitch']);
    }

    public function back()
    {
        $this->reset_form();
        $this->dispatch('refresh-categories');
    }

    public function pages_num()
    {
        $this->numbers;
        $this->resetPage();
    }

    public function edit($id)
    {
        $category = Categories::findOrFail($id);
        $this->arName = $category->getTranslation('name','ar');
        $this->enName = $category->getTranslation('name','en');
        // $this->logo = $category->image;
        $this->addCategory = true;
        $this->updateCategory = $id;
        $this->CategoryFitch = $category;
    }

    public function update()
    {
        $this->validate([
            'arName' => 'required|string|max:255',
            'enName' => 'required|string|max:255',
            'logo' => 'nullable|image|max:1024', // 1MB Max
        ]);

        $category = Categories::findOrFail($this->updateCategory);
        $category->name = [
            'ar'=>$this->arName,
            'en'=>$this->enName,
        ];

        if ($this->logo) {
            $category->image = $this->logo->store('categories', 'public');
        }

        $category->save();
        $this->dispatch('refresh-categories');
        $this->dispatch('message', message: __('Done Successfully modified'));
        $this->reset_form();
    }

    public function save()
    {
        $this->validate([
            'arName' => 'required|string|max:255',
            'enName' => 'required|string|max:255',
            'logo' => 'nullable|image|max:1024', // 1MB Max
        ]);

        $category = new Categories();
        $category->name = [
            'ar'=>$this->arName,
            'en'=>$this->enName,
        ];
        $category->status = 0;

        if ($this->logo) {
            $category->image = $this->logo->store('categories', 'public');
        }
        $category->save();
        $this->dispatch('refresh-categories');
        $this->dispatch('message',message: __('Done Save'));
        $this->reset_form();
    }


    // #[On('switch')]
    public function render()
    {
        $categories = Categories::query()
        // ->where('name','like','%' .$this->search . '%')
        ->paginate($this->numbers);
        return view('livewire.setup.categories-component',['categories'=>$categories]);
    }
}
