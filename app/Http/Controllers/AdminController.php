<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Auth;


class AdminController extends Controller
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

        if(Auth::guard('admin')->attempt(['email'=>$input['email'],'password'=>$input['password']])){
            $user = Auth::guard('admin')->user();
            $success = $user->createToken('myApp',['role:admin'])->plainTextToken;
            return response()->json($success,200);
        }

        

    }
    public function register(Request $request){
        $input = $request->all();

        $validator = Validator::make($input,[
            'name'=>'required',
            'email'=>'required|unique:admins,email',
            'password' => 'required',
            'confirmed_password' => 'required|same:password'
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }

        $user = Admin::create($input);
        
        $success['token'] = $user->createToken('myApp',['role:admin'])->plainTextToken;

        return response()->json($success,200);

    }
    
}
