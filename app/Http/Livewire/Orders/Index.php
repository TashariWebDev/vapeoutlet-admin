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

    public int $ordersCount = 0;

    public bool $showAddOrderForm = false;

    public bool $quickViewCustomerAccountModal = false;

    public $selectedCustomerLatestTransactions = [];

    public $searchTerm = '';

    public string $filter = 'received';

    public $customerType;

    public int $recordCount = 10;

    public string $direction = 'asc';

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
        'searchTerm',
    ];

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function getTotalActiveOrdersProperty(): int
    {
        return Order::query()
            ->where('status', '=', 'received')
            ->orWhere('status', '=', 'processed')
            ->orWhere('status', '=', 'packed')
            ->count();
    }

    public function selectedCustomerLatestTransactions()
    {
        if ($this->quickViewCustomerAccountModal === false) {
            $this->selectedCustomerLatestTransactions = [];
        }
    }

    public function quickViewCustomerAccount(Customer $customer)
    {
        $customer->load('lastFivetransactions');
        $this->selectedCustomerLatestTransactions =
            $customer->lastFiveTransactions;

        $this->quickViewCustomerAccountModal = true;
    }

    public function pushToComplete($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->updateStatus('completed');
        $this->notify('order completed');
        $this->redirect('/orders?filter=shipped');
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getDocument(Order $order)
    {
        $order->print();
    }

    public function filteredOrders()
    {
        $orders = Order::query()
            ->select(['id', 'created_at', 'status', 'customer_id'])
            ->with([
                'customer:id,name,company,salesperson_id,is_wholesale',
                'customer.salesperson:id,name',
            ])
            ->without(['items'])
            ->addSelect([
                'order_total' => OrderItem::query()
                    ->whereColumn('order_id', '=', 'orders.id')
                    ->selectRaw('sum(qty * price) as order_total'),
            ])
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

        if ($this->searchTerm) {
            $orders->search($this->searchTerm);
        }

        return $orders;
    }

    public function mount()
    {
        if (request()->has('filter')) {
            $this->filter = request('filter');
        }

        if (request()->has('searchTerm')) {
            $this->searchTerm = request('searchTerm');
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

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function render(): Factory|View|Application
    {
        $this->ordersCount = $this->filteredOrders()->count();

        return view('livewire.orders.index', [
            'orders' => $this->filteredOrders()->paginate($this->recordCount),
        ]);
    }
}
