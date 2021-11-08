<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Http\Traits\JsonTrait;
use Illuminate\Support\Facades\Gate;



class ApiController extends Controller
{
    use JsonTrait;
    // public function __construct() {
    //     $this->middleware('auth:api', ['except' => ['login', 'register']]);
    // }


    /**
     * User API
     * Get all the user by pagination
     * @bodyParam page int Page number for pagination. Example: 1
     * @authenticated
     * @header Authorization Bearer {{token}}
     */
    public function users(){

        $user = User::where('id',auth()->user()->id)->first();
        $response = Gate::inspect('update', $user);

        if ($response->allowed()) {
            // The action is authorized...
            $users = User::paginate(10);
            return $this->jsonResponse(
                UserResource::collection($users)
            );
        } else {
            echo $response->message();
        }

    }

    /**
     * Dashboard
     *
     * Check that the service is up. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with a 400 error, and a response listing the failed services.
     *
     * @authenticated
     * @header Authorization Bearer {{token}}
     * @response 401 scenario="invalid token"
     */

    public function dashboard(Request $request){
        $user_total = User::count();
        $code=0;

        return $this->jsonSuccessResponse(compact('user_total', 'code'),'',200);
        // return response()->json(
        //     compact('user_total','code')
        // );
    }

    /**
     * Login Api.
     *
     * @bodyParam email string required User email. Example: superadmin@invoke.com
     * @bodyParam password string required User password. Example: password
     * @bodyParam user_id int optional The id of the user. Example: 9
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(
                $validator->errors(),
                'Invalid Input Parameters',
                422);
            // return response()->json($validator->errors(), 422);
        }

        if (! $token = JWTAuth::attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return $this->jsonResponse(
                $validator->errors(),
                'Invalid Input Parameters',
                422
            );
            // return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }


}
