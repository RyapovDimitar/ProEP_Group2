<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserDetails;
use Illuminate\Support\Facades\Response;

class UsersController extends Controller
{
    public function register(Request $request){
//        return Response::json([
//            'message' => 'User created successfully2.'
//        ], 200);
        if(!isset($request->username)||!isset($request->password)
            ||!isset($request->fname)||!isset($request->lname)||!isset($request->phone)||!isset($request->email))
        {
            return Response::json([
                'message' => 'Incorrect input!'
            ], 201);
        }
        else{
            $user = new User();
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->token = str_random(10);
            $user->is_admin = false;
            $user->save();
//            return Response::json([
//                'message' => 'User created successfully.'
//            ], 200);
            $details = new UserDetails();
            $user_id = User::where('username', $request->username)->first()->id;
            $details->user_id = $user_id;
            $details->fname = $request->fname;
            $details->lname = $request->lname;
            $details->phone = $request->phone;
            $details->email = $request->email;
            $details->save();
            return Response::json([
                'message' => 'User created successfully.'
            ], 200);
        }
    }
}
