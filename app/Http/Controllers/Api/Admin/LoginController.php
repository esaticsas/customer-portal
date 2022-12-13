<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Response\Admin\LoginResponse;
use App\Models\Administrator;
use Esatic\Suitecrm\Exceptions\CrmException;
use Esatic\Suitecrm\Services\AuthApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Esatic\Suitecrm\Exceptions\AuthenticationException;

class LoginController extends Controller
{

    private AuthApi $authApiService;

    /**
     * @param AuthApi $authApiService
     */
    public function __construct(AuthApi $authApiService)
    {
        $this->authApiService = $authApiService;
    }

    /**
     * Handle the incoming request.
     *
     * @param LoginRequest $request
     * @return JsonResponse|LoginResponse
     * @throws AuthenticationException|CrmException
     */
    public function __invoke(LoginRequest $request)
    {
        $result = $this->authApiService->dynamicAuth($request->input('username'), $request->input('password'), env('TOKEN_NAME'));
        if ($result->getSessionId()) {
            /** @var Administrator $admin */
            $admin = Administrator::query()->where('username', '=', $request->input('username'))->firstOrNew();
            $admin->username = $request->input('username');
            $admin->name = $result->getUserName();
            $admin->save();
            auth()->login($admin);
            $token = $admin->createToken(env('TOKEN_NAME'))->accessToken;
            return new LoginResponse($token, $admin);
        }
        return \response()->json(['message' => 'Username or password is incorrect'], 401);
    }
}
