@extends('emails.layout')

@section('content')
    <div>
        <h1 class="text-2xl font-bold">The status of your order has been updated. </h1>

        <div class="py-6">
            <div>
                <div>
                    <p class="capitalize">Hi {{ $order->customer->name }}</p>
                </div>
                <div class="py-6">
                    <p>
                        The status of order <span class="font-bold">{{ $order->number }} </span>is <span class="font-bold">{{ $status }}.</span>
                    </p>
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
