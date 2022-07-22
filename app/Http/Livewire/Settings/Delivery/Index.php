<?php

namespace App\Http\Livewire\Settings\Delivery;

use App\Models\Delivery;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $delivery;

    public $showDeliveryCreateForm = false;

    protected function rules()
    {
        return [
            'delivery.type' => ['required'],
            'delivery.description' => ['required'],
            'delivery.price' => ['required'],
            'delivery.waiver_value' => ['nullable'],
            'delivery.selectable' => ['boolean'],
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
        $this->dispatchBrowserEvent('notification', ['body' => 'Delivery saved']);
        $this->delivery->refresh();
    }

    public function delete(Delivery $delivery)
    {
        $delivery->delete();

        $this->dispatchBrowserEvent('notification', ['body' => 'Delivery deleted']);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.settings.delivery.index', [
            'deliveries' => Delivery::query()
                ->orderBy('selectable', 'asc')
                ->simplePaginate(5)
        ]);
    }
}
