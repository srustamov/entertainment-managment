<?php

use App\Components\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
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

        if (! $token = auth()->attempt($credentials)) {
            return api([])->setCode(401)->setError('Unauthorized');
        }

        return $this->respondWithToken($token);
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

        return api()->setMessage('Successfully logged out');
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
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
