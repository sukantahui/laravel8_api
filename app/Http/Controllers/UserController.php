<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register(Request $request)
    {


//        $user = User::create(['user_name'=>'Arindam Biswas2',
//                                'mobile1'=>'9836444999',
//                                'mobile2'=>'',
//                                'email'=>'arindam2',
//                                'password'=>"81dc9bdb52d04dc20036dbd8313ed055",
//                                'user_type_id'=>1]);

        $user = User::create([
            'email'    => $request->email,
            'password' => $request->password,
            'user_name' => $request->name,
            'user_type_id' => $request->user_type_id
        ]);

        return response()->json(['success'=>1,'data'=>$user], 200,[],JSON_NUMERIC_CHECK);

        //$token = auth()->login($user);
        return response()->json(['success'=>1,'data'=>$user], 200,[],JSON_NUMERIC_CHECK);
//        return $this->respondWithToken($token);
    }

    function login(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    function getUsers(){
        return User::get();
    }
}
