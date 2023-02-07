<div class="rounded border">
    <div class="px-1 bg-gray-700 rounded-t border border-gray-700">
        <p class="text-xs font-semibold text-white uppercase">Banking Details</p>
    </div>
    <ul class="p-1 text-xs">
        <li class="font-semibold">{{ ucwords($company->bank_account_name) }}</li>
        <li class="font-semibold">{{ ucwords($company->bank_name) }}</li>
        <li class="font-semibold">{{ ucwords($company->bank_branch) }} {{ ucwords($company->bank_branch_no) }}</li>
        <li class="mt-2 font-mono">ACC: {{ ucwords($company->bank_account_no) }}</li>
        <li class="font-mono">REF: {{ $reference}}</li>
    </ul>
</div>
