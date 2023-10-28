<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\AuthRequest;
use App\Models\User;
use App\Service\UserGlobalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\API\User\RegisterResource;

class AuthController extends Controller
{
    public function login(AuthRequest $request): \Illuminate\Http\JsonResponse
    {
        if (!isset($request->firebase_uid) && Auth::attempt($request->validated())) {
            $user = Auth::user();
        } else {
            $user = User::where('firebase_uid', $request->firebase_uid)->first();
        }
        if ($user) {
            $token = UserGlobalService::createTokenIfUserAuthenticated($user);
            return response()->json([
                'message' => 'User logged in successfully.',
                'statusCode' => 200,
                'token' => $token,
                'user' => new RegisterResource($user) // UserResource is a resource class that returns the user data in a specific format.
            ]);
        }
        return response()->json([
            'message' => 'Invalid credentials.',
            'statusCode' => 401,
        ], 401);
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'User logged out successfully.',
            'statusCode' => 200,
        ]);
    }
}
