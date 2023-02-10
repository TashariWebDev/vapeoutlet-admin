<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Validator;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->only('name', 'email', 'password',
            'password_confirmation', 'phone'), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'phone' => ['required', 'unique:customers,phone'],
            ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user = Customer::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            abort(403);
        }

        return response()->json([
            'user' => new CustomerResource($user),
            'message' => 'success',
            'token' => $user->createToken($request->device_name)->plainTextToken,
        ]);
    }
}
