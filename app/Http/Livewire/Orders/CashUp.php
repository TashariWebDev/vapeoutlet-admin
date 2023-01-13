<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\UpdateCustomerRunningBalanceJob;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SalesChannel;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class CashUp extends Component
{
    use WithPagination;
    use WithNotifications;

    public int $ordersCount = 0;

    public bool $showAddOrderForm = false;

    public bool $quickViewCustomerAccountModal = false;

    public $selectedCustomerLatestTransactions = [];

    public $searchQuery = '';

    public $customerType;

    public int $recordCount = 10;

    public string $direction = 'asc';

    public $defaultSalesChannel;

    public $salesChannels;

    public $statuses = [
        'received',
        'processed',
        'packed',
        'shipped',
        'completed',
        'cancelled',
    ];

    protected $queryString = [
        'customerType',
        'recordCount',
        'direction',
        'searchQuery',
    ];

    public $modal = false;

    public $reference;

    public $type = 'payment';

    public $amount;

    public $date;

    public $customerId;

    public $customer;

    public function rules(): array
    {
        return [
            'reference' => ['required'],
            'type' => ['required'],
            'amount' => ['required'],
            'date' => ['sometimes'],
        ];
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->salesChannels = SalesChannel::all();

        $this->defaultSalesChannel = $this->salesChannels
            ->where('name', 'warehouse')
            ->first()
            ->value('id');

        //        if (request()->has('filter')) {
        //            $this->filter = request('filter');
        //        }

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
            ])
            ->without(['items'])
            ->addSelect([
                'order_total' => OrderItem::query()
                    ->whereColumn('order_id', '=', 'orders.id')
                    ->selectRaw('sum(qty * price) as order_total'),
            ])
            ->when($this->defaultSalesChannel, function ($query) {
                $query->where('sales_channel_id', $this->defaultSalesChannel);
            })
            ->whereStatus('shipped')
            ->orderBy('created_at', $this->direction);

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
    }

    public function togglePaymentForm($customerId)
    {
        $this->modal = true;
        $this->customerId = $customerId;
        $this->customer = Customer::find($customerId);
    }

    public function save()
    {
        $additionalFields = [
            'customer_id' => $this->customerId,
            'created_by' => auth()->user()->name,
        ];

        $validatedData = $this->validate();
        $fields = array_merge($additionalFields, $validatedData);

        $fields['amount'] = 0 - $this->amount;

        Transaction::create($fields);

        UpdateCustomerRunningBalanceJob::dispatch($this->customerId);

        $this->notify('transaction created');
        $this->reset(
            'amount',
            'reference',
            'type',
            'date',
            'modal',
            'customerId'
        );
        $this->emit('updateData');
    }

    public function render()
    {
        return view('livewire.orders.cash-up', [
            'orders' => $this->filteredOrders()->paginate($this->recordCount),
        ]);
    }
}
