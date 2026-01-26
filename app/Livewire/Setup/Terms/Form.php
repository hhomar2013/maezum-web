<?php
namespace App\Livewire\Setup\Terms;

use App\Models\Term;
use Livewire\Component;

class Form extends Component
{
    public $term;
    public bool $add    = false;
    public bool $update = false;
    public $TermId;
    public $type;
    public string $title   = '';
    public string $content = '';
    protected $listeners = ['resetFormTerms' => 'resetForm'];

    public function mount($id = null)
    {
        if ($id) {
            $this->term    = Term::findOrFail($id);
            $this->TermId  = $this->term->id;
            $this->title   = $this->term->title;
            $this->content = $this->term->content;
            $this->update  = true;
        } else {
            $this->add = true;
        }
    }

    public function resetForm()
    {
        $this->reset(['TermId', 'title', 'content']);
        $this->add    = false;
        $this->update = false;
    }

    public function save()
    {
        $this->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Term::updateOrCreate(
            ['id' => $this->TermId],
            [
                'title'   => $this->title,
                'content' => $this->content,
            ]
        );

        $this->dispatch('load-Term');
        $this->dispatch('message', message: __('Done Save'));
        $this->dispatch('resetFormTerms');

    }
    public function render()
    {
        return view('livewire.setup.terms.form');
    }
}
