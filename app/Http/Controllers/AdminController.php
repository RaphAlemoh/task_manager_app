<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        $users = User::all();
        if ($request->has('search')) {
            $users = User::where('username', 'like', "%{$request->search}%")->orWhere('email', 'like', "%{$request->search}%")->get();
        }
        return $this->showOne($users, 200);
    }

    public function show(User $user)
    {
        return $this->showOne($user, 200);

    }


    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role_id' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if ($user) {
            $user->roles()->attach($request->role_id);
            return $this->showOne("User Updated Succesfully", 200);
        }
        return $this->errorResponse("oops an error was encountered!", 400);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role_id' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);

        if ($user) {
            $user->roles()
                ->attach($request->role_id);

            return $this->showOne("User has been created successfully", 200);
        }
        return $this->errorResponse("oops an error was encountered!", 400);
    }

    public function destroy(User $user)
    {
        $user->delete();
        if ($user) {
            return $this->showOne("User Deleted Succesfully", 200);
        }
        return $this->errorResponse("oops an error was encountered!", 400);
    }

    public function roles()
    {
        return response()->json(Role::select('id', 'name')->get()->toArray());
    }
}
