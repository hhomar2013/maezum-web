<?php
namespace App\Livewire\Setup\Faq;

use App\Models\Faq;
use Livewire\Component;

class Form extends Component
{
    public $add    = false;
    public $update = false;
    public $faq_id, $question, $answer;

    protected $rules = [
        'question' => 'required|string|max:255',
        'answer'   => 'required|string',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $faq            = Faq::findOrFail($id);
            $this->faq_id   = $faq->id;
            $this->question = $faq->question;
            $this->answer   = $faq->answer;
        }
    }

    public function save()
    {
        $this->validate();

        Faq::updateOrCreate(
            ['id' => $this->faq_id],
            [
                'question' => $this->question,
                'answer'   => $this->answer,
            ]
        );

        $this->reset(['faq_id', 'question', 'answer']);
        $this->dispatch('message' , message: __('Done Save'));
        $this->dispatch('faqUpdated');
    }
    public function render()
    {
        return view('livewire.setup.faq.form');
    }
}
