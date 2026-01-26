<?php

namespace App\Livewire\VendorSide\Sections;

use App\Models\sections;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class SectionsComponent extends Component
{
    use WithFileUploads;
    public $arName,$enName, $sections, $logo ,$sectionsFitch;

    public function mount()
    {
        $this->loadSections();
    }

    public function loadSections()
    {
        $this->sections = sections::where('vendor_id', Auth::id())->get();
    }

    public function save()
    {
        $this->validate([
            'arName' => 'required|string|max:255',
            'enName' => 'required|string|max:255',
        ]);

        $section= new sections();
        $section->name = [
            'ar'=> $this->arName,
            'en'=> $this->enName,
        ];
        if($this->logo){
            $section->image = $this->logo->store('sections', 'public');
        }
        $section->vendor_id = Auth::id();
        $section->save();
        $this->reset();
        $this->loadSections();
        $this->dispatch('message',message: __('Done Save'));
    }

    public function delete($id)
    {
        sections::where('vendor_id', Auth::id())->where('id', $id)->delete();
        $this->loadSections();
    }


    public function edit($id){
        $section = sections::query()->find($id);
        $this->sectionsFitch =  $section;
        $this->arName = $section->getTranslation('name','ar');
        $this->enName = $section->getTranslation('name','en');
    }

    public function update(){
        $id = $this->sectionsFitch->id;
        $this->validate([
            'arName' => 'required|string|max:255',
            'enName' => 'required|string|max:255',
        ]);
        $section = sections::query()->find($id);
        $section->name = [
            'ar'=> $this->arName,
            'en'=> $this->enName,
        ];
        if($this->logo){
            $section->image = $this->logo->store('sections', 'public');
        }
        $section->save();
        $this->reset();
        $this->loadSections();
        $this->dispatch('message',message: __('Done Update'));
    }

    public function render()
    {
        return view('livewire.vendor-side.sections.sections-component')->extends('layouts.app');
    }
}
