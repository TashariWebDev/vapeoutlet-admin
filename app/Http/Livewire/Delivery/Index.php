<?php

namespace App\Http\Livewire\Delivery;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Delivery;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithNotifications;
    use WithPagination;

    public $delivery;

    public $showDeliveryCreateForm = false;

    public $provinces = [
        'gauteng',
        'kwazulu natal',
        'limpopo',
        'mpumalanga',
        'north west',
        'free state',
        'northern cape',
        'western cape',
        'eastern cape',
    ];

    protected function rules()
    {
        return [
            'delivery.type' => ['required'],
            'delivery.description' => ['required'],
            'delivery.price' => ['required'],
            'delivery.waiver_value' => ['nullable'],
            'delivery.selectable' => ['nullable'],
            'delivery.province' => ['nullable'],
            'delivery.customer_type' => ['nullable'],
        ];
    }

    public function edit($deliveryId = null)
    {
        $this->delivery = Delivery::firstOrNew(['id' => $deliveryId]);
        $this->showDeliveryCreateForm = true;
    }

    public function save()
    {
        $this->validate();
        $this->delivery->save();
        $this->showDeliveryCreateForm = false;
        $this->resetValidation();

        $this->notify('Delivery saved');

        $this->delivery->refresh();
    }

    public function delete(Delivery $delivery)
    {
        $delivery->delete();
        $this->notify('Delivery deleted');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.delivery.index', [
            'deliveries' => Delivery::query()
                ->orderBy('province')
                ->paginate(10),
        ]);
    }
}
