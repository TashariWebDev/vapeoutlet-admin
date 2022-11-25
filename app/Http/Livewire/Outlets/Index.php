<?php

namespace App\Http\Livewire\Outlets;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Outlet;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithNotifications;
    use WithPagination;

    public $searchQuery;

    protected $listeners = ['updateFormData' => '$refresh'];

    public function disableShipping(Outlet $outlet)
    {
        $outlet->allows_shipping = false;
        $outlet->save();

        $this->notify($outlet->name.'shipping disabled');
    }

    public function enableShipping(Outlet $outlet)
    {
        $outlet->allows_shipping = true;
        $outlet->save();

        $this->notify($outlet->name.'shipping enabled');
    }

    public function deleteOutlet(Outlet $outlet)
    {
        $outlet->delete();

        $this->notify('Outlet deleted');
    }

    public function render()
    {
        return view('livewire.outlets.index', [
            'outlets' => Outlet::query()
                ->when(
                    $this->searchQuery,
                    fn ($query) => $query->where(
                        'name',
                        'like',
                        $this->searchQuery.'%'
                    )
                )
                ->paginate(10),
        ]);
    }
}
