<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => request('email'),
            'password' => request('password')
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success['token'] = $user->createToken('Ellipsis')->accessToken;
            $success['name'] = $user->name;
            $success['roles'] = $user->roles->map(function ($item) {
                return $item->name;
            });
            return response()->json(['success' => $success]);
        }

        return response()->json(['error' => 'Unauthorised'], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $user->roles()->attach(3);

        $success['token'] = $user->createToken('Ellipsis')->accessToken;
        $success['name'] = $user->name;



        return response()->json(['success' => $success]);
    }

    public function getDetails()
    {
        return response()->json(['success' => Auth::user()]);
    }

    public function logout(Request $request)
    {
        try {

            $user = User::find(Auth::id())->firstOrFail();

            $request->user()->token()->revoke();

            $success = true;
            $message = "Logout successfully";
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }
}
