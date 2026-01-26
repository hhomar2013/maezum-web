<?php

namespace App\Livewire\Setup;

use App\Models\mysettings;
use Livewire\Component;
use Livewire\WithFileUploads;

class GeneralComponent extends Component
{
    use WithFileUploads;
    public $nameAr,$nameEn;
    public $email;
    public $phone;
    public $currency;
    public $logo;
    public $favicon;
    public $mySettings;
    public $old_logo;
    public $old_favicon;
    protected $listeners = ['refresh-general' => '$refresh'];

    public function mount(mysettings $mySettings)
    {
        $mySettings = mysettings::query()->latest()->first();
        $this->mySettings = $mySettings;
        if ($mySettings) {
            $this->nameAr = $mySettings->getTranslation('app_name','ar');
            $this->nameEn = $mySettings->getTranslation('app_name','en');
            $this->email = $mySettings->app_email;
            $this->phone = $mySettings->app_phone;
            $this->currency = $mySettings->current_currency;
            $this->logo = $mySettings->logo;
            $this->favicon = $mySettings->favicon;
        }else{
            $this->mySettings = [
                'name_ar' =>null,
                'name_en' =>null,
                'app_email' =>null,
                'app_phone' =>null,
                'current_currency' =>null,
                'app_country' =>null,
                'app_logo' =>null,
                'app_favicon' =>null,
            ];
        }



    }//mount

    public function store()
    {
        $this->validate([
            'nameAr' => 'required',
            'nameEn' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'currency' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $logo = $this->logo->store('logo','public');
        $favicon = $this->favicon->store('favicon','public');
        mysettings::create([
            'app_name' => [
                'ar' => $this->nameAr,
                'en' => $this->nameEn,
            ],
            'app_email' => $this->email,
            'app_phone' => $this->phone,
            'current_currency' => $this->currency,
            'app_country' => "Saudi Arabia",
            'app_logo' => $logo,
            'app_favicon' => $favicon,
        ]);
        $this->dispatch('refresh-general');
        $this->dispatch('message', message: __('Done Save'));
        return redirect()->route('settings');
    }//store

    public function update()
    {
        $this->validate([
            'nameAr' => 'required',
            'nameEn' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'currency' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $mySettings = $this->mySettings;

        if ($this->logo) {
            $logo = $this->logo->store('logo', 'public');
            $mySettings->app_logo = $logo;
        }

        if ($this->favicon) {
            $favicon = $this->favicon->store('favicon', 'public');
            $mySettings->app_favicon = $favicon;
        }

        $mySettings->app_name = [
            'ar' => $this->nameAr,
            'en' => $this->nameEn,
        ];
        $mySettings->app_email = $this->email;
        $mySettings->app_phone = $this->phone;
        $mySettings->current_currency = $this->currency;
        $mySettings->app_country = "Saudi Arabia";
        $mySettings->save();

        $this->dispatch('refresh-general');
        $this->dispatch('message', message: __('Done Save'));

    }//update


    public function render()
    {
        return view('livewire.setup.general-component');
    }
}
