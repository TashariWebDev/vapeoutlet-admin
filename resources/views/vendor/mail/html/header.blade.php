<tr>
    @php
        $company = App\Models\SystemSetting::query()->first();
    @endphp
    
    <td class="header">
        <p
            style="display: inline-block;"
        >
            {{ ucwords(config('app.name')) }}
        </p>
    </td>
</tr>
