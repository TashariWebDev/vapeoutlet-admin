@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-pink-600">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul class="mt-3 text-sm list-disc list-inside text-pink-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
