<?php

namespace App\Livewire\Setup\Vendors;

use App\Models\Vendors;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;

class VendorsComponent extends Component
{
    use WithoutUrlPagination , WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $add = false;
    public $update = false;
    public $numbers = 5;
    public $arName;
    public $enName;
    public $logo;
    public $desc;
    public $type;
    public $email;
    public $password;
    protected $listeners = ['refresh-vendors' => '$refresh'];

    public function back()
    {
        $this->add = false;
        $this->update = false;
        $this->reset_form();
    }

    public function page_num($number)
    {
        $this->numbers = $number;
        $this->resetPage();
    }

    public function reset_form()
    {
        $this->reset(['arName', 'enName', 'logo', 'desc', 'add', 'update','type','email','password']);
    }

    public function save()
    {
        $this->validate([
            'arName' => 'required',
            'enName' => 'required',
            'logo' => 'required',
            'desc' => 'required',
            'type' => 'required',
            'email' => 'required|email|unique:vendors,email',
            'password' => 'required|min:6',
        ]);

        Vendors::create([
            'name' => [
                'ar' => $this->arName,
                'en' => $this->enName,
            ],
            'logo' => $this->logo->store('vendors', 'public'),
            'description' => [
                'ar' => $this->desc,
            ],
            'type' => $this->type,
            'email'=>$this->email,
            'password'=> bcrypt($this->password),
        ]);

        $this->dispatch('refresh-vendors');
        $this->dispatch('message',message: __('Done Save'));
        $this->reset_form();

    }//save

    public function edit($id)
    {
        $this->add = true;
        $this->update = $id;
        $vendor = Vendors::find($id);
        $this->arName = $vendor->getTranslation('name', 'ar');
        $this->enName = $vendor->getTranslation('name', 'en');
        $this->desc = $vendor->getTranslation('description', 'ar');
        $this->type = $vendor->type;
        $this->email = $vendor->email;
        if ($vendor->logo) {
            $this->logo = $vendor->logo;
        }
    }

    public function render()
    {
        $vendors = Vendors::paginate($this->numbers);
        return view('livewire.setup.vendors.vendors-component')->with(['vendors' => $vendors]);
    }
}
