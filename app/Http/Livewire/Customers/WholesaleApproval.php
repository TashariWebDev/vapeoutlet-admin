<?php

namespace App\Http\Livewire\Customers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Customer;
use App\Notifications\WholesaleDeclineNotification;
use App\Notifications\WholesaleWelcomeNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class WholesaleApproval extends Component
{
    use WithNotifications;

    public $modal = false;

    public $selectedImage;

    public Customer $customer;

    public function mount()
    {
        $this->customer = Customer::query()
            ->with(['businessImages', 'addresses'])
            ->where('id', '=', request('id'))
            ->where('is_wholesale', false)
            ->first();
        $this->customer->makeVisible(['id_document', 'cipc_documents']);
    }
    

    public function approve()
    {
        $this->customer->update([
            'is_wholesale' => true,
            'requested_wholesale_account' => false,
        ]);

        $this->customer->notify(new WholesaleWelcomeNotification($this->customer));
        $this->notify('The customer has been notified');

        $this->redirect('/customers/wholesale/applications');
    }

    public function decline()
    {
        $this->customer->update([
            'requested_wholesale_account' => false,
        ]);

        $this->customer->notify(new WholesaleDeclineNotification($this->customer));

        $this->notify('The customer has been notified');

        $this->redirect('/customers/wholesale/applications');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.customers.wholesale-approval');
    }
}
