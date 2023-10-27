<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\RegisterRequest;
use App\Http\Resources\API\User\RegisterResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User created successfully',
            'statusCode' => 201, // 'Created
            'token' => $token,
            'user' => new RegisterResource($user),
        ], 201);
    }
}
