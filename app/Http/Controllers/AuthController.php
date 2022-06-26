<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Interfaces\Responses\JsonResponseInterface;
use App\Http\Responses\JSON\{
    DefaultErrorResponse,
    PostResponse
};
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponseInterface
    {
        if (! $token = auth()->attempt($request->validated())) {

            return DefaultErrorResponse::create(
                null,
                'Unauthorized',
                [],
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $this->respondWithToken($token);
    }

    public function me(): JsonResponseInterface
    {
        return PostResponse::create([
            'user' => auth()->user()
        ]);
    }

    public function logout(): JsonResponseInterface
    {
        auth()->logout();

        return PostResponse::create( ['message' => 'Successfully logged out'] );
    }

    public function refresh(): JsonResponseInterface
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token): JsonResponseInterface
    {
        return PostResponse::create(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        );
    }
}
