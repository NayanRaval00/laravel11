<?php

namespace App\Http\Controllers;

use App\Exceptions\FailResponseException;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            throw new FailResponseException(__('auth.user_not_found'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (!Hash::check($request->password, $user->password)) {
            throw new FailResponseException(__('auth.password'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        Log::info('ccc');

        return (new UserResource($request))
            ->additional(
                [
                    'message' => __('auth.user_login'),
                    'data' => [
                        'user' => $user,
                        'token' => $user->createToken(env('APP_NAME'), ['api'])->accessToken,
                    ],
                    'status' => 200
                ]
            );
    }


    public function register(CreateUserRequest $request)
    {
        User::create($request->all());
        return new JsonResponse([
            'status' => 'success',
            'message' => __('auth.user_register'),
        ], Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return new JsonResponse([
            'status' => 'success',
            'message' => __('auth.user_logout'),
        ], Response::HTTP_OK);
    }
}
