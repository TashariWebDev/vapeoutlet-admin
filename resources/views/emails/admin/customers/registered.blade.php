<x-mail-layout>

    <div class="px-4 pt-10 w-full">
        <p class="text-lg font-bold">Hi Admin</p>
        <p class="text-lg">
            {{ ucwords($customer->name) }} has registered on the website.
        </p>
    </div>

    <div class="flex justify-start items-center py-6">
        <a href="{{ config('app.url') }}"
           class="py-4 px-6 font-semibold text-white rounded-lg shadow-lg bg-sky-600"
        >
            Sign in
        </a>
    </div>


</x-mail-layout>
