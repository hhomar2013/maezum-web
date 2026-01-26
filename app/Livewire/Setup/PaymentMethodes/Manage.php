<?php
namespace App\Livewire\Setup\PaymentMethodes;

use App\Models\PaymentMethod;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Manage extends Component
{

    use WithPagination, WithFileUploads;

    public $name, $code, $provider, $is_active = true, $method_id, $image;
    public $editMode                           = false;
    public $configItems                        = [['key' => '', 'value' => '']];

    protected $rules = [
        'name'      => 'required|string',
        'code'      => 'required|string',
        'provider'  => 'required|string',
        'configItems.*.key'    => 'required',
        'configItems.*.value'    => 'required',
        'is_active' => 'boolean',
    ];

    public function save()
    {
        $this->validate();
        $imagePath = $this->image ? $this->image->store('payment_images', 'public') : null;

        PaymentMethod::create([
            'name'      => $this->name,
            'code'      => $this->code,
            'provider'  => $this->provider,
            'image'     => $imagePath,
            'config'    => collect($this->configItems)
                ->filter(fn($item) => $item['key'] !== '')
                ->pluck('value', 'key')
                ->toArray(),
            'is_active' => $this->is_active,
        ]);

        $this->resetFields();
    }

    public function edit($id)
    {
        $method            = PaymentMethod::findOrFail($id);
        $this->method_id   = $method->id;
        $this->name        = $method->name;
        $this->code        = $method->code;
        $this->provider    = $method->provider;
        $this->is_active   = $method->is_active;
        $this->editMode    = true;
        $this->image       = $method->image ? null : $method->image;
        $this->configItems = collect($method->config)->map(function ($value, $key) {
            return ['key' => $key, 'value' => $value];
        })->values()->toArray();
    }

    public function update()
    {
        $method = PaymentMethod::findOrFail($this->method_id);

        $imagePath = $this->image
        ? $this->image->store('payment_images', 'public')
        : $method->image;

        $method->update([
            'name'      => $this->name,
            'code'      => $this->code,
            'provider'  => $this->provider,
            'image'     => $imagePath,
            'config'    => collect($this->configItems)
                ->filter(fn($item) => $item['key'] !== '')
                ->pluck('value', 'key')
                ->toArray(),
            'is_active' => $this->is_active,
        ]);

        $this->resetFields();
    }

    public function delete($id)
    {
        PaymentMethod::destroy($id);
    }

    public function toggleStatus($id)
    {
        $method = PaymentMethod::findOrFail($id);
        $method->update(['is_active' => ! $method->is_active]);
    }

    private function resetFields()
    {
        $this->reset(['name', 'code', 'provider', 'configItems', 'is_active', 'editMode', 'method_id']);
    }

    public function render()
    {
        return view('livewire.setup.payment-methodes.manage', [
            'methods' => PaymentMethod::paginate(10),
        ]);
    }

    public function addConfig()
    {
        $this->configItems[] = ['key' => '', 'value' => ''];
    }

    public function removeConfig($index)
    {
        unset($this->configItems[$index]);
        $this->configItems = array_values($this->configItems); // إعادة ترتيب الأندكسات
    }
}
