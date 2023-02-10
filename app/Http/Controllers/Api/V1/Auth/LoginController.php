<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = Customer::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            abort(403);
        }

        return response()->json([
            'user' => new CustomerResource($user),
            'token' => $user->createToken($request->device_name)->plainTextToken,
        ]);
    }

    public function destroy(Request $request)
    {
        try {
            $user = Customer::where('email', $request->email)->first();
            $user->tokens()->delete();

            return response()->json([
                'message' => 'success',
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'An error occurred',
            ], 500);
        }
    }
}
