<x-mail-layout>
    
    <div class="px-4 pt-10 w-full">
        <p class="text-lg font-bold">Hi admin</p>
        <p class="text-lg">
            You have received a new online enquiry.
        </p>
        <div class="py-6 text-lg">
            <p>Customer: {{ $data['name']}}</p>
            <p>Phone: {{ $data['phone']}}</p>
            <p>Email: {{ $data['email']}}</p>
            <p>Message: {{ $data['body']}}</p>
        </div>
    
    </div>
    
    <div class="flex justify-start items-center py-6">
        <a href="{{ config('app.url') }}"
           class="py-4 px-6 font-semibold text-white rounded-lg shadow-lg bg-sky-600"
        >
            Sign in
        </a>
    </div>

</x-mail-layout>
