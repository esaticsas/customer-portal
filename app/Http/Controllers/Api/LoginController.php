<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::query()->where('email', '=', $request->input('email'))->first();
        if ($user) {
            if (Hash::check($request->input('password'), $user->password)) {
                $token = $user->createToken(env('TOKEN_NAME'))->accessToken;
                return response()->json(['token' => $token, 'user' => $user]);
            }
        }
        return response()->json(['message' => __('auth.failed')], 401);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response()->json($response);
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function forgot(ForgotPasswordRequest $request): JsonResponse
    {
        Password::sendResetLink($request->all());
        return response()->json(['message' => __('password.sent')]);
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $resetPasswordStatus = Password::reset($$request->all(), function ($user, $password) {
            $user->password = $password;
            $user->save();
        });
        if ($resetPasswordStatus == Password::INVALID_TOKEN) {
            return response()->json(['message' => __('password.token')], 400);
        }
        return response()->json(['message' => __('password.reset')]);
    }
}
