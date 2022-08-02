@extends('emails.layout')

@section('content')
    <div>
        <h1 class="font-bold text-2xl">We have received your order. </h1>

        <div class="py-6">
            <div>
                <div>
                    <p class="capitalize">Hi {{ $customer->name }}</p>
                </div>
                <div class="py-6">
                    <p>
                        Thank you for placing your order with <span class="font-bold">{{ config('app.name') }}.</span>
                    </p>
                    <p>Our team will be jumping on it right away.</p>
                    <p>Keep a look-out for updates in your email.</p>
                </div>
                <div>
                    <p>Regards,</p>
                    <p class="font-bold">The {{config('app.name')}} Team</p>
                </div>
            </div>
        </div>
    </div>
@endsection
