1.
"tymon/jwt-auth": "1.0.0-rc.2"
compser update

2.
config/app.php
providers = [
   Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
]

'aliases' => [
    'JWTAuth' => Tymon\JWTAuth\Facades\JWTAuth::class, 
    'JWTFactory' => Tymon\JWTAuth\Facades\JWTFactory::class
 ]
 
3.
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret

4.
app/http/Kernel.php
protected $routeMiddleware = [
...
    'jwt.auth' => 'Tymon\JWTAuth\Middleware\GetUserFromToken',
    'jwt.refresh' => 'Tymon\JWTAuth\Middleware\RefreshToken',
];

5. App\User.php
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
6. app/jwt.php

'providers' => [
        'user' => 'Tymon\JWTAuth\Providers\User\EloquentUserAdapter',

        /*
        |--------------------------------------------------------------------------
        | JWT Provider
        |--------------------------------------------------------------------------
        |
        | Specify the provider that is used to create and decode the tokens.
        |
        */

        'jwt' => 'Tymon\JWTAuth\Providers\JWT\Namshi',

        /*
        |--------------------------------------------------------------------------
        | Authentication Provider
        |--------------------------------------------------------------------------
        |
        | Specify the provider that is used to authenticate users.
        |
        */

        'auth' => Tymon\JWTAuth\Providers\Auth\Illuminate::class,

        /*
        |--------------------------------------------------------------------------
        | Storage Provider
        |--------------------------------------------------------------------------
        |
        | Specify the provider that is used to store tokens in the blacklist.
        |
        */

        'storage' => Tymon\JWTAuth\Providers\Storage\Illuminate::class,

    ],
6. routes/api.php

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::group(['middleware' => ['jwt.auth']], function() {

    Route::get('logout', 'AuthController@logout');

    Route::get('refresh', "AuthController@refresh");

});

7. AuthController.php


public function login(Request $request)
    {
        $credentials = $request->only('codetoken_mb', 'email');
        
        try {
            $user = Users::where('email', $credentials['email'])->first();
            if ($user) {
                $check = $credentials['codetoken_mb'] . $credentials['email'];
                if (!Hash::check($check, $user->logintoken_mb)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Can not find user.'
                    ], 404);
                } else {
                    if (!$userToken = JWTAuth::fromUser($user)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Invalid credentials'
                        ], 401);
                    } 
                    else{
                        // $user->logintoken_mb = null;
                        // $user->save();
                        return response()->json([
                            'success' => true,
                            'data' => ['token' => $userToken]
                        ], 200);
                    }
                }
            }
            return response()->json([
                'success' => false,
                'message' => 'Email not found.'
            ], 404);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to login, please try again.'
            ], 500);
        }
    }


    public function logout(Request $request)
    {
        // $currentUser = JWTAuth::toUser();
        // dd($currentUser);
        $credentials = $request->only('token');
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages()
            ], 401);
        }
        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json([
                'success' => true,
                'message' => "You have successfully logged out."
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to logout, please try again.'
            ], 500);
        }
    }


    function refresh(){
        $refreshed = JWTAuth::refresh(JWTAuth::getToken());
        $user = JWTAuth::setToken($refreshed)->toUser();
        header('Authorization: Bearer ' . $refreshed);
        return response()->json(['token'=>$refreshed]);
    }




















