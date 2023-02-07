<?php

namespace App\Http\Livewire\SystemSettings;

use App\Models\SystemSetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

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

    public function mount()
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
        $this->bank_branch = $this->company->bank_branch;
        $this->bank_branch_no = $this->company->bank_branch_no;
        $this->bank_account_no = $this->company->bank_account_no;
        $this->company_registration_number = $this->company->company_registration_number;
        $this->vat_registration_number = $this->company->vat_registration_number;
        $this->logo = $this->company->logo;
    }

    public function updatedCompany()
    {
        $this->validate([
            'company_name' => 'required',
        ]);

        $this->company->update([
            'company_name' => $this->company_name,
        ]);
    }

    public function updatedEmailAddress()
    {
        $this->company->update([
            'email_address' => $this->email_address,
        ]);
    }

    public function updatedPhone()
    {
        $this->company->update([
            'phone' => $this->phone,
        ]);
    }

    public function updatedAddressLineOne()
    {
        $this->company->update([
            'address_line_one' => $this->address_line_one,
        ]);
    }

    public function updatedAddressLineTwo()
    {
        $this->company->update([
            'address_line_two' => $this->address_line_two,
        ]);
    }

    public function updatedSuburb()
    {
        $this->company->update([
            'suburb' => $this->suburb,
        ]);
    }

    public function updatedCity()
    {
        $this->company->update([
            'city' => $this->city,
        ]);
    }

    public function updatedPostalCode()
    {
        $this->company->update([
            'postal_code' => $this->postal_code,
        ]);
    }

    public function updatedCountry()
    {
        $this->company->update([
            'country' => $this->country,
        ]);
    }

    public function updatedVatRegistrationNumber()
    {
        $this->company->update([
            'vat_registration_number' => $this->vat_registration_number,
        ]);
    }

    public function updatedCompanyRegistrationNumber()
    {
        $this->company->update([
            'company_registration_number' => $this->company_registration_number,
        ]);
    }

    public function updatedBankName()
    {
        $this->company->update([
            'bank_name' => $this->bank_name,
        ]);
    }

    public function updatedBankAccountName()
    {
        $this->company->update([
            'bank_account_name' => $this->bank_account_name,
        ]);
    }

    public function updatedBankBranch()
    {
        $this->company->update([
            'bank_branch' => $this->bank_branch,
        ]);
    }

    public function updatedBankBranchNo()
    {
        $this->company->update([
            'bank_branch_no' => $this->bank_branch_no,
        ]);
    }

    public function updatedBankAccountNo()
    {
        $this->company->update([
            'bank_account_no' => $this->bank_account_no,
        ]);
    }

    public function updatedLogo()
    {
        $this->validate([
            'logo' => 'required|image|dimensions:1/1',
        ]);

        $this->company->update([
            'logo' => $this->logo->store('uploads', 'public'),
        ]);
    }

    public function deleteLogo()
    {
        $logo = $this->company->logo;

        if (Storage::disk('public')->exists($logo)) {
            Storage::disk('public')->delete($logo);
        }

        $this->company->update([
            'logo' => null,
        ]);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.system-settings.index');
    }
}
