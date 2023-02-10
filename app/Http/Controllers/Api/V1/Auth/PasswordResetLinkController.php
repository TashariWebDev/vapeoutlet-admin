<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Validator;

class PasswordResetLinkController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->only('email'), [
            'email' => ['required', 'string', 'email', 'max:255', 'exists:customers'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $response = \Password::broker('customers')->sendResetLink([
            'email' => $request->email,
        ]);

        return response()->json(['message' => 'Password reset link sent to your email']);
    }

    public function broker()
    {
        return Password::broker('customer');
    }
}
