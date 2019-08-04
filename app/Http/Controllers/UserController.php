<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles user auth and user name for the application. 
    |
    */  
 
    /**
     * Use for user object.
     *
     * @var string
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @param  $user User object
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [            
            'email' => 'required|email'
        ];

        return Validator::make($data, $rules);
    }     

    /**
     * Manage user auth.
     *
     * @param  Request  $request
     * @return json
     */
    public function auth(Request $request)
    {        
        // Check validation        
        $validator = $this->validator($request->all());  
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        // Get user data
        $res = $this->user->checkAuth($request->input('email'));        
        
        // Check user data
        if(!$res) {
            return response()->json([
                'error' => 'User does not exist.'
            ], 422);
        } else {
            return response()->json([
                'token' => $this->jwt($res) // return token
            ], 200);
        }
    }

    /**
     * Get user detail.
     *
     * @param  Request  $request
     * @return json
     */
    public function detail(Request $request)
    {   
        return response()->json([
            'name' => $request->auth->name
        ], 200);
    }  

    /**
     * Create jwt token.
     *
     * @param  object  $data
     * @return string
     */
    protected function jwt(object $data) {
         $token = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $data, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
        ];
        
        return JWT::encode($token, env('APP_NAME'));
    }
}
