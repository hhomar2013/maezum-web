<?php

namespace App\Livewire\Setup\Terms;

use App\Models\Term;
use Livewire\Component;

class Index extends Component
{
    use \Livewire\WithFileUploads;

    public $add = false;
    public $update = false;
    public $terms;

    protected $listeners = ['refresh-terms' => '$refresh' , 'load-Term' => 'loadTerms'];


    public function mount()
    {
        $this->loadTerms();
    }

    public function addTerm()
    {
        $this->add = true;
        $this->update = false;
        $this->reset(['update']);
    }
    public function back()
    {
        $this->dispatch('resetFormTerms');
        $this->add = false;
        $this->update = false;
        $this->reset(['add', 'update']);
        $this->loadTerms();
    }

    public function editTerm($id)
    {
        $this->update = $id;
        $this->add = false;
        $this->reset(['add']);
    }

    public function loadTerms()
    {
        $this->terms = Term::query()->get();
        $this->reset(['add', 'update']);
        $this->dispatch('refresh-terms');
    }

   public function delete($id)
    {
        Term::findOrFail($id)->delete();
        session()->flash('success', 'تم الحذف بنجاح');
    }

    public function render()
    {
        return view('livewire.setup.terms.index');
    }
}
