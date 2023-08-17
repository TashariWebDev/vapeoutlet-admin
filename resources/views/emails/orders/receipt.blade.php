<x-mail-layout>
    
    <div class="px-4 pt-10 w-full">
        <p class="text-lg font-bold">Hi {{ $order->customer->name }}</p>
        <p class="text-lg">
            Thank you for your payment.
        </p>
        <div class="py-6">
            <p>Order number: {{ strtoupper($order->number) }}</p>
            <p>Amount: R {{ (0 - $transaction->amount) }}</p>
            <p>Gateway: {{ ucwords($createdBy) }}</p>
        </div>
    
    </div>
    
    <div class="flex justify-start items-center py-6">
        <a href="https://vapeoutlet.co.za"
           class="py-4 px-6 font-semibold text-white rounded-lg shadow-lg bg-sky-600"
        >
            Sign in
        </a>
    </div>

</x-mail-layout>
