<div class="flex items-center pb-2 space-x-6 w-full">
    @if($company->logo)
        <div>
            <img
                class="w-16"
                src="{{ asset('storage/'.$company->logo)}}"
                alt="Vape Crew"
            >
        </div>
    @endif
    <div>
        <ul>
            <li class="text-sm font-bold">{{ ucwords($company->company_name) }}</li>
            <li class="text-xs">{{ $company->vat_registration_number }}
                | {{ $company->company_registration_number }}</li>
            <li class="text-xs">{{ $company->phone }}</li>
            <li class="text-xs">{{ $company->email_address }}</li>
        </ul>
    </div>
</div>
