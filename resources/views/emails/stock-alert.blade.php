@extends('emails.layout')

@section('content')
    <div>
        <h1 class="font-bold text-2xl">Product now in stock!!</h1>

        <div class="py-6">
            <div>
                <p>This is an automated message to inform you that {{ $name }} is back in stock!</p>
            </div>
            <div class="mt-4">
                <a href="{{ $link }}"
                   class="disabled:opacity-50 disabled:cursor-default capitalize inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Buy now
                </a>
            </div>
        </div>
    </div>
@endsection
