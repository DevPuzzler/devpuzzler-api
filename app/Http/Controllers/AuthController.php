<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Interfaces\Responses\JsonResponseInterface;
use App\Http\Responses\JSON\{
    DefaultErrorResponse,
    PostResponse
};
use App\Tools\ValueObjects\Responses\{
    JsonResponseDataVO,
    JsonResponseErrorVO
};
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponseInterface
    {
        if (! $token = auth()->attempt($request->validated())) {

            return new DefaultErrorResponse(
                    new JsonResponseDataVO(),
                    new JsonResponseErrorVO('Unauthorized'),
                    Response::HTTP_UNAUTHORIZED
                );
        }

        return $this->respondWithToken($token);
    }

    public function me(): JsonResponseInterface
    {
        return new PostResponse(
            new JsonResponseDataVO([
                'user' => auth()->user()
            ]),
            new JsonResponseErrorVO()
        );
    }

    public function logout(): JsonResponseInterface
    {
        auth()->logout();
        return new PostResponse(
            new JsonResponseDataVO([
                'message' => 'Successfully logged out'
            ]),
            new JsonResponseErrorVO()
        );
    }

    public function refresh(): JsonResponseInterface
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token): JsonResponseInterface
    {
        return new PostResponse(
            new JsonResponseDataVO([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60
                ]),
            new JsonResponseErrorVO()
        );
    }
}
