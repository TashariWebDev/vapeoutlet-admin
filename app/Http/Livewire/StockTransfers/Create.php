<?php

namespace App\Http\Livewire\StockTransfers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Outlet;
use App\Models\StockTransfer;
use Livewire\Component;

class Create extends Component
{
    use WithNotifications;

    public $slide = false;

    public $receivers = [];

    public $dispatchers = [];

    public $receiver_id;

    public $dispatcher_id;

    public $date;

    public $user_id;

    public $is_processed = false;

    protected $listeners = ['refreshData' => '$refresh'];

    public function rules(): array
    {
        return [
            'receiver_id' => ['required', 'integer'],
            'dispatcher_id' => ['required', 'integer'],
            'date' => ['required', 'date'],
            'is_processed' => ['required'],
            'user_id' => ['required'],
        ];
    }

    public function mount()
    {
        $this->user_id = auth()->id();
        $this->date = now();
    }

    public function updatedSlide()
    {
        if ($this->slide) {
            $this->dispatchers = Outlet::query()
                ->hasStock()
                ->select(['id', 'name'])
                ->orderBy('name')
                ->get();
        } else {
            $this->emitSelf('refreshData');
            $this->reset(
                'dispatchers',
                'receivers',
                'slide',
                'dispatcher_id',
                'receiver_id'
            );
        }
    }

    public function updatedDispatcherId()
    {
        $this->receivers = Outlet::query()
            ->whereNotIn('id', [$this->dispatcher_id])
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();
    }

    public function save()
    {
        $validatedData = $this->validate();

        $transfer = StockTransfer::create($validatedData);

        $this->redirectRoute('stock-transfers/edit', [
            'id' => $transfer->id,
        ]);
    }

    public function render()
    {
        if (! $this->slide) {
            $this->reset('dispatchers', 'receivers', 'slide', 'dispatcher_id');
        }

        return view('livewire.stock-transfers.create');
    }
}
