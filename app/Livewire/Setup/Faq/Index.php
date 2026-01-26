<?php
namespace App\Livewire\Setup\Faq;

use App\Models\Faq;
use Livewire\Component;

class Index extends Component
{
    public $faqs;
    public $add    = false;
    public $update = false;

    protected $listeners = ['faqUpdated' => 'loadFaqs'];

    public function mount()
    {
        $this->loadFaqs();
    }

    public function loadFaqs()
    {
        $this->add= false;
        $this->update= false;
        $this->faqs = Faq::latest()->get();
    }

    public function editFaq($id)
    {

        $this->update = $id;

        // $this->('openFaqForm', ['id' => $id]);
    }

    public function delete($id)
    {
        Faq::findOrFail($id)->delete();
        $this->loadFaqs();
    }
    public function render()
    {
        return view('livewire.setup.faq.index');
    }
}
