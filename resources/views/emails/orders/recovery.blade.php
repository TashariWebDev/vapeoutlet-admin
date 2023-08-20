<x-mail-layout>
    
    <div class="px-4 pt-10 w-full">
        <p class="text-lg font-bold">Hi {{ $order->customer->name }}</p>
        <p class="text-lg">
            Looks like you forgot to complete your order!
        </p>
        <p>
            It's not too late. Just click on the checkout button below, & we will get your order shipped to you ASAP.
        </p>
        <p>
            This is an automated reminder which will be sent daily. If you prefer not to receive this email,
            please click on Cancel order below.
        </p>
    </div>
    
    <div class="flex justify-start items-center py-6 space-x-8">
        <a href="{{ config('app.frontend_url') }}/checkout"
           class="py-2 px-6 font-semibold text-white rounded-lg shadow-lg bg-sky-600"
        >
            Checkout
        </a>
        
        <a href="{{ config('app.frontend_url') }}/cancel-order/{{ $order->id }}"
           class="py-2 px-6 font-semibold text-red-600"
        >
            Cancel order
        </a>
    </div>

</x-mail-layout>
