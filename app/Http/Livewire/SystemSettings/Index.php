<?php

namespace App\Http\Livewire\SystemSettings;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\SystemSetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;
    use WithNotifications;

    public $isInMaintenance = false;

    public $company;

    public $company_name;

    public $company_registration_number;

    public $vat_registration_number;

    public $email_address;

    public $phone;

    public $address_line_one;

    public $address_line_two;

    public $suburb;

    public $city;

    public $province;

    public $postal_code;

    public $country;

    public $bank_name;

    public $bank_branch;

    public $bank_branch_no;

    public $bank_account_no;

    public $bank_account_name;

    public $logo;

    public function mount(): void
    {
        $this->company = SystemSetting::first();

        $this->company_name = $this->company->company_name;
        $this->email_address = $this->company->email_address;
        $this->phone = $this->company->phone;
        $this->address_line_one = $this->company->address_line_one;
        $this->address_line_two = $this->company->address_line_two;
        $this->suburb = $this->company->suburb;
        $this->city = $this->company->city;
        $this->province = $this->company->province;
        $this->postal_code = $this->company->postal_code;
        $this->country = $this->company->country;
        $this->bank_name = $this->company->bank_name;
        $this->bank_account_name = $this->company->bank_account_name;
        $this->bank_branch = $this->company->bank_branch;
        $this->bank_branch_no = $this->company->bank_branch_no;
        $this->bank_account_no = $this->company->bank_account_no;
        $this->company_registration_number =
            $this->company->company_registration_number;
        $this->vat_registration_number =
            $this->company->vat_registration_number;
        $this->logo = $this->company->logo;
    }

    public function updated(): void
    {
        $this->company->update([
            'company_name' => $this->company_name,
            'email_address' => $this->email_address,
            'phone' => $this->phone,
            'address_line_one' => $this->address_line_one,
            'address_line_two' => $this->address_line_two,
            'suburb' => $this->suburb,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'bank_name' => $this->bank_name,
            'bank_account_name' => $this->bank_account_name,
            'bank_branch' => $this->bank_branch,
            'bank_branch_no' => $this->bank_branch_no,
            'bank_account_no' => $this->bank_account_no,
            'company_registration_number' => $this->company_registration_number,
            'vat_registration_number' => $this->vat_registration_number,
        ]);
    }

    public function updatedLogo(): void
    {
        $this->validate([
            'logo' => 'required|image|dimensions:1/1',
        ]);

        $this->company->update([
            'logo' => $this->logo->store(
                config('app.storage_folder').'/uploads',
                'public'
            ),
        ]);
    }

    public function deleteLogo(): void
    {
        $logo = $this->company->logo;

        if (Storage::disk('public')->exists($logo)) {
            Storage::disk('public')->delete($logo);
        }

        $this->company->update([
            'logo' => null,
        ]);
    }

    public function disableFrontend(): void
    {
        $url = config('app.frontend_url').'/api/offline';

        $data = [
            'referrer' => config('app.url'),
        ];

        \Http::get($url, $data);

        $this->isInMaintenance = $this->checkIfFrontendIsOffline();

        $this->notify('app disabled');
    }

    public function enableFrontend(): void
    {
        $url = config('app.frontend_url').'/api/online';

        $data = [
            'referrer' => config('app.url'),
        ];

        \Http::get($url, $data);

        $this->isInMaintenance = $this->checkIfFrontendIsOffline();

        $this->notify('app enabled');
    }

    public function checkIfFrontendIsOffline(): string
    {
        $url = config('app.frontend_url').'/api/check-maintenance';

        $response = Http::get($url);

        if ($response->status() === 503) {
            return true;
        }

        return false;

    }

    public function render(): Factory|View|Application
    {
        return view('livewire.system-settings.index');
    }
}
