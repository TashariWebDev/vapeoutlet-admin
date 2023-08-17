<x-mail-layout>

    <div class="px-4 pt-10 w-full">
        <p class="text-lg font-bold">Hi admin</p>
        <p class="text-lg">
            You have received a new online order from {{ ucwords($customer->name) }}.
        </p>
        <div class="py-4">
            <p>
                Order number: {{ strtoupper($order->number) }}.
            </p>
            <p>
                Order total: R {{ strtoupper($order->getTotal()) }}.
            </p>
        </div>
    </div>

    <div class="flex justify-start items-center py-6">
        <a href="https://admin.vapeoutlet.co.za"
           class="py-4 px-6 font-semibold text-white rounded-lg shadow-lg bg-sky-600"
        >
            Sign in
        </a>
    </div>

</x-mail-layout>
