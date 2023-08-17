<x-mail-layout>

    <div class="px-4 pt-10 w-full">
        <p class="text-lg font-bold">Hi {{ $customer->name }}</p>
        <p class="text-lg">
            We have received your order and out team will be jumping on it right away.
        </p>
        <p>
            Thank you for your support!
        </p>
    </div>

    <div class="py-6 px-6">
        <p>** Important **</p>
        <div class="px-1 text-lg">
            <p class="font-semibold">* Orders not paid for within 60 Minutes will be cancelled.</p>
            <p class="font-semibold">* Orders will only be released or dispatched once funds have been cleared.</p>
            <p class="font-semibold">* No cash on delivery</p>
        </div>
    </div>

    <div class="flex justify-start items-center py-6">
        <a href="{{ config('app.frontend_url') }}/dashboard"
           class="py-4 px-6 font-semibold text-white rounded-lg shadow-lg bg-sky-600"
        >
            View order
        </a>

        <a href="{{ config('app.frontend_url') }}/order-tracking"
           class="py-4 px-6 ml-6 font-semibold text-white rounded-lg shadow-lg bg-sky-600"
        >
            Track order
        </a>
    </div>

</x-mail-layout>
