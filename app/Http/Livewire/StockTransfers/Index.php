<?php

namespace App\Http\Livewire\StockTransfers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\StockTransfer;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithNotifications;
    use WithPagination;

    public $searchQuery;

    protected $listeners = ['updateFormData' => '$refresh'];

    public function deleteTransfer(StockTransfer $transfer)
    {
        $transfer->delete();

        $this->notify('SalesChannel cancelled');
    }

    public function render()
    {
        return view('livewire.stock-transfers.index', [
            'transfers' => StockTransfer::query()
                ->with(['receiver', 'dispatcher', 'user'])
                ->when(
                    $this->searchQuery,
                    fn ($query) => $query
                        ->where('date', '=', $this->searchQuery)
                        ->orWhereHas('user', function ($query) {
                            $query->where(
                                'name',
                                'like',
                                $this->searchQuery.'%'
                            );
                        })
                        ->orWhereHas('receiver', function ($query) {
                            $query->where(
                                'name',
                                'like',
                                $this->searchQuery.'%'
                            );
                        })
                        ->orWhereHas('dispatcher', function ($query) {
                            $query->where(
                                'name',
                                'like',
                                $this->searchQuery.'%'
                            );
                        })
                )
                ->latest('date')
                ->paginate(10),
        ]);
    }
}
