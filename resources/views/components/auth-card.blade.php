<div class="flex flex-col items-center pt-6 min-h-screen sm:justify-center sm:pt-0 bg-slate-900">
    <div>
        <p class="text-2xl font-extrabold">{{ config('app.name') }}</p>
    </div>

    <div class="overflow-hidden py-4 px-6 mt-6 w-full shadow-md sm:max-w-md sm:rounded-lg bg-slate-800">
        {{ $slot }}
    </div>
</div>
