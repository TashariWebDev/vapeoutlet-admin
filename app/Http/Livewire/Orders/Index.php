<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
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

    public function updatedSearchQuery(): void
    {
        $this->resetPage();
    }

    public function updatedFilter(): void
    {
        $this->resetPage();
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
            ])
            ->with([
                'customer:id,name,company,salesperson_id,is_wholesale',
                'customer.salesperson:id,name',
                'delivery',
                'notes',
                'items',
            ])
            ->withCount('notes')
            ->addSelect([
                'order_total' => OrderItem::query()
                    ->whereColumn('order_id', '=', 'orders.id')
                    ->selectRaw('sum(qty * price) as order_total'),
            ])
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
        $order->print();
    }

    public function render(): Factory|View|Application
    {

        return view('livewire.orders.index', [
            'orders' => $this->filteredOrders()->paginate($this->recordCount),
        ]);
    }
}
