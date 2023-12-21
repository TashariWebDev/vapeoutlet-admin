<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\BulkInvoiceDownloadJob;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class Index extends Component
{
    use WithNotifications;
    use WithPagination;

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

    public $customerType = 'all';

    public int $recordCount = 10;

    public string $direction = 'asc';

    public $fromDate;

    public $toDate;

    public $tags = [];

    public $defaultSalesChannel;

    public $statuses = [
        'received',
        'processed',
        'packed',
        'shipped',
        'completed',
        'cancelled',
        'pending',
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
            $this->selectedOrders = $this->filteredOrders()
                ->whereDate('created_at', '>=', $this->fromDate)
                ->whereDate('created_at', '<=', $this->toDate)
                ->pluck('id');
        } else {
            $this->selectedOrders = [];
        }
    }

    public function updatedFromDate(): void
    {
        $this->selectedOrders = [];
        $this->reset('selectedAllOrders');
    }

    public function updatedToDate(): void
    {
        $this->selectedOrders = [];
        $this->reset('selectedAllOrders');
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

        $this->tags = Tag::all();

        $this->fromDate = today()->subMonth()->startOfMonth()->toDateString();
        $this->toDate = today()->toDateString();

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
            $this->customerType = request('customerType');
        }

        if (request()->has('recordCount')) {
            $this->recordCount = request('recordCount');
        }

        if (request()->has('direction')) {
            $this->direction = request('direction');
        }
    }

    public function addTag(Order $order, $tagId): void
    {
        $order->tags()->syncWithoutDetaching($tagId);

        $this->notify('Tag added to order '.$order->number);
    }

    public function removeTag(Order $order, $tagId): void
    {
        $order->tags()->detach($tagId);

        $this->notify('Tag removed from order '.$order->number);
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

    public function filteredOrders(): Builder
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
                'tags',
            ])
            ->withCount('notes')
            ->where('sales_channel_id', $this->defaultSalesChannel->id)
            ->orderBy('created_at', $this->direction);

        if ($this->filter === 'pending') {
            $orders->whereNull('status');
        } else {
            $orders->whereStatus($this->filter);
        }

        if ($this->customerType === 'wholesale') {
            $orders->whereRelation('customer', 'is_wholesale', '=', true);
        }

        if ($this->customerType === 'retail') {
            $orders->whereRelation('customer', 'is_wholesale', '=', false);
        }

        if ($this->searchQuery) {
            $orders->search($this->searchQuery);
        }

        return $orders;
    }

    public function printInvoicesInBulk(): void
    {
        $orders = Order::find($this->selectedOrders);

        foreach ($orders->chunk(50) as $batch) {
            dispatch(new BulkInvoiceDownloadJob($batch))->onQueue('bulk');
        }

        $this->notify('Processing your request. You will receive as email shortly');

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

    public function pushToComplete($orderId): void
    {
        $order = Order::findOrFail($orderId);
        $order->updateStatus('completed');
        $this->notify('order completed');
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getDocument(Order $order): void
    {
        $order->increment('printed_count');
        $order->print();
    }

    public function sendReminder(Order $order): void
    {
        Artisan::call('recover:cart', [
            'order' => $order->id,
        ]);
        $this->notify('Reminder sent');
    }

    public function render(): Factory|View|Application
    {

        return view('livewire.orders.index', [
            'orders' => $this->filteredOrders()
                ->whereDate('created_at', '>=', $this->fromDate)
                ->whereDate('created_at', '<=', $this->toDate)
                ->paginate($this->recordCount),
        ]);
    }
}
