<?php

namespace App\Http\Response\Admin;

use App\Models\Administrator;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class LoginResponse implements Responsable
{

    private string $token;
    private Administrator $administrator;

    /**
     * @param string $token
     * @param Administrator $administrator
     */
    public function __construct(string $token, Administrator $administrator)
    {
        $this->token = $token;
        $this->administrator = $administrator;
    }


    public function toResponse($request): JsonResponse
    {
        $response = array('token' => $this->token, 'administrator' => $this->administrator);
        return response()->json($response);
    }
}
