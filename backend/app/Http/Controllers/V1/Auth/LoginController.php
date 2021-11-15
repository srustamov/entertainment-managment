<?php

namespace App\Http\Controllers\V1\Auth;

use App\Components\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{

    public function boot()
    {
       // $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return Api
     */
    public function login(Request $request): Api
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth(guard: 'api')->attempt($credentials)) {
            return api(data:[],code: Response::HTTP_UNPROCESSABLE_ENTITY)
                ->setCode(422)
                ->notOk()
                ->setMessage(trans('auth.failed'));
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return Api
     */
    protected function respondWithToken(string $token): Api
    {
        return api([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return Api
     */
    public function user(): Api
    {
        return api([
            'user' => auth('api')->user()
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
