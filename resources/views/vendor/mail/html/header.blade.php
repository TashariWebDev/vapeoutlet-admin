<tr>
    @php
        $company = App\Models\SystemSetting::query()->first();
    @endphp
    
    <td class="header">
        <a href="{{ $url }}"
           style="display: inline-block;"
        >
            @if($company->logo)
                <img src="{{ asset('storage').'/'. $company->logo }}"
                     class="logo"
                     alt="{{config('app.name')}} Logo"
                >
            @else
                {{ ucwords($company->company_name) }}
            @endif
        </a>
    </td>
</tr>
