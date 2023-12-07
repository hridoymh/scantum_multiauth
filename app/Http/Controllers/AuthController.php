<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Auth;


class AuthController extends Controller
{
    use HasApiTokens;

    public function login(Request $request){
        $input = $request->all();

        $validator = Validator::make($input,[
            'email'=>'required',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }

        if(Auth::attempt(['email'=>$input['email'],'password'=>$input['password']])){
            $user = Auth::user();
            $success = $user->createToken('myApp',['role:user'])->plainTextToken;
            return response()->json($success,200);
        }

        

    }
    public function register(Request $request){
        $input = $request->all();

        $validator = Validator::make($input,[
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'password' => 'required',
            'confirmed_password' => 'required|same:password'
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }

        $user = User::create($input);
        
        $success['token'] = $user->createToken('myApp',['role:user'])->plainTextToken;

        return response()->json($success,200);

    }
    
}
