<div class="flex items-center pb-2 space-x-6 w-full">

    @if($company->logo)
        <div>
            <img
                class="w-16"
                src="{{ asset('storage/'.$company->logo)}}"
                alt="{{ config('app.frontend_url') }}"
            >
        </div>
    @endif

    <div>
        <ul>
            <li class="font-extrabold uppercase text-[10px]">{{ ucwords($company->company_name) }}</li>
            @if($company->vat_registration_number)
                <li class="font-bold leading-tight text-[10px]">
                    VAT NO: {{ $company->vat_registration_number  }}
                </li>
            @endif
            <li class="font-semibold leading-tight text-[10px]">{{ $company->phone }}</li>
            <li class="font-semibold leading-tight text-[10px]">{{ $company->email_address }}</li>
        </ul>
    </div>
</div>
