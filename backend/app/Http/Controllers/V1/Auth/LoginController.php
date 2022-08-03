<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Support\Api;
use App\Support\Interfaces\CurrentUser;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Api
     */
    public function login(Request $request): Api
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = auth(guard: 'api')->attempt($credentials)) {
            return api(data:[], code: Response::HTTP_UNPROCESSABLE_ENTITY)
                ->notOk()
                ->setMessage(trans('auth.failed'));
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string  $token
     * @return Api
     */
    protected function respondWithToken(string $token): Api
    {
        return api([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')?->factory()?->getTTL() * 60,
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @param  CurrentUser  $user
     * @return Api
     */
    #[Pure]
    public function user(CurrentUser $user): Api
    {
        return api([
            'user' => $user,
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return Api
     */
    public function logout(): Api
    {
        auth('api')->logout();

        return api()->setMessage(trans('auth.logged_out'));
    }

    /**
     * Refresh a token.
     *
     * @return Api
     */
    public function refresh(): Api
    {
        return $this->respondWithToken(auth('api')->refresh());
    }
}
