@extends('emails.old.layout')

@section('content')
    <div>
        <h1 class="text-2xl font-bold">New order. </h1>

        <div class="py-6">
            <div>
                <div>
                    <p class="capitalize">Hi Admin</p>
                </div>
                <div class="py-6">
                    <p>You have received a new order from <span class="font-bold capitalize">{{$customer->name}}.</span>
                    </p>
                </div>
                <div>
                    <p>Regards,</p>
                    <p class="font-bold">The {{config('app.name')}} Team</p>
                </div>
            </div>
        </div>
    </div>
@endsection
