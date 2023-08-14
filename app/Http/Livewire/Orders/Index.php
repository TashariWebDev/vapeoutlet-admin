<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class Index extends Component
{
    use WithPagination;
    use WithNotifications;

    public $selectedOrders = [];

    public $selectedAllOrders;

    public $showBulkActions = false;

    public bool $showAddOrderForm = false;

    public bool $quickViewCustomerAccountModal = false;

    public $selectedCustomerLatestTransactions = [];

    public $selectedOrderNotes;

    public $quickViewNotesModal = false;

    public $searchQuery = '';

    public string $filter = 'received';

    public $customerType;

    public int $recordCount = 10;

    public string $direction = 'asc';

    public $defaultSalesChannel;

    public $statuses = [
        'received',
        'processed',
        'packed',
        'shipped',
        'completed',
        'cancelled',
    ];

    protected $queryString = [
        'filter',
        'customerType',
        'recordCount',
        'direction',
        'searchQuery',
    ];

    public function updatedSelectedAllOrders(): void
    {
        if ($this->selectedAllOrders) {
            $this->selectedOrders = $this->filteredOrders()->pluck('id');
        } else {
            $this->selectedOrders = [];
        }
    }

    public function updatedSearchQuery(): void
    {
        $this->resetPage();
        $this->selectedOrders = [];
        $this->selectedAllOrders = false;
    }

    public function updatedFilter(): void
    {
        $this->resetPage();
        $this->selectedOrders = [];
        $this->selectedAllOrders = false;
    }

    public function mount(): void
    {

        \App\Models\Note::where('body', '=', '')->delete();

        $this->defaultSalesChannel = auth()
            ->user()
            ->defaultSalesChannel();

        if (request()->has('filter')) {
            $this->filter = request('filter');
        }

        if (request()->has('searchQuery')) {
            $this->searchQuery = request('searchQuery');
        }

        if (request()->has('customerType')) {
            if (request('customerType') === true) {
                $this->customerType = true;
            }
            if (request('customerType') === false) {
                $this->customerType = false;
            }
        }

        if (! request()->has('customerType')) {
            $this->customerType = null;
        }

        if (request()->has('recordCount')) {
            $this->recordCount = request('recordCount');
        }

        if (request()->has('direction')) {
            $this->direction = request('direction');
        }
    }

    public function updateStatusInBulk($status): void
    {
        if (! $status) {
            return;
        }

        if (empty($this->selectedOrders)) {
            return;
        }

        $orders = Order::find($this->selectedOrders);

        foreach ($orders as $order) {
            $order->updateStatus($status);
        }

        $this->selectedOrders = [];
        $this->showBulkActions = false;
        $this->selectedAllOrders = false;

        $this->notify('Orders updated');
    }

    public function filteredOrders()
    {
        $orders = Order::query()
            ->select([
                'id',
                'created_at',
                'status',
                'customer_id',
                'delivery_charge',
                'delivery_type_id',
                'waybill',
                'printed_count',
                'was_edited',
            ])
            ->with([
                'customer:id,name,company,salesperson_id,is_wholesale',
                'customer.salesperson:id,name',
                'delivery',
                'notes',
            ])
            ->withCount('notes')
            ->where('sales_channel_id', $this->defaultSalesChannel->id)
            ->whereNotNull('status')
            ->orderBy('created_at', $this->direction);

        if ($this->filter) {
            $orders->whereStatus($this->filter);
        }

        if ($this->customerType === true) {
            $orders->whereRelation('customer', 'is_wholesale', '=', true);
        }

        if ($this->customerType === false) {
            $orders->whereRelation('customer', 'is_wholesale', '=', false);
        }

        if ($this->searchQuery) {
            $orders->search($this->searchQuery);
        }

        return $orders;
    }

    public function selectedCustomerLatestTransactions(): void
    {
        if ($this->quickViewCustomerAccountModal === false) {
            $this->selectedCustomerLatestTransactions = [];
        }
    }

    public function quickViewCustomerAccount(Customer $customer): void
    {
        $customer->load('lastFiveTransactions');
        $this->selectedCustomerLatestTransactions =
            $customer->lastFiveTransactions;

        $this->quickViewCustomerAccountModal = true;
    }

    public function quickViewNotes(Order $order): void
    {
        $this->selectedOrderNotes = $order->notes;

        $this->quickViewNotesModal = true;
    }

    public function pushToComplete($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->updateStatus('completed');
        $this->notify('order completed');
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getDocument(Order $order)
    {
        $order->increment('printed_count');
        $order->print();
    }

    public function render(): Factory|View|Application
    {

        return view('livewire.orders.index', [
            'orders' => $this->filteredOrders()->paginate($this->recordCount),
        ]);
    }
}
