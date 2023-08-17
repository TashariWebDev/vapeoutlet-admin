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
        <p>
            If you haven't made your payment as yet, You can be use the account details below.
        </p>
        <p>Use your order number or email as reference</p>
        <div class="px-1 text-lg">
            <p class="font-semibold">DEZINE HQ (PTY) LTD</p>
            <p class="font-semibold">First National Bank</p>
            <p class="font-semibold">250655</p>
            <p class="font-semibold">ACC: 63017884924</p>
        </div>
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
        <a href="https://vapeoutlet.co.za/dashboard"
           class="py-4 px-6 font-semibold text-white rounded-lg shadow-lg bg-sky-600"
        >
            View order
        </a>

        <a href="https://vapeoutlet.co.za/order-tracking"
           class="py-4 px-6 ml-6 font-semibold text-white rounded-lg shadow-lg bg-sky-600"
        >
            Track order
        </a>
    </div>

</x-mail-layout>
