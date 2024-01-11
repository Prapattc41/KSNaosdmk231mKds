<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function sign_in()
    {
        return view ('sign-in');
    }
    public function sign_up()
    {
        return view ('sign-up');
    }
    public function dashboard()
    {
        return view ('dashboard');
    }
    public function register(Request $request)
    {
        //ฟังชั่น Create
        $user = new User;
 
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = $request['password'];

        $user->save();

        return view('sign-in');
    }
    public function login(Request $request)
    {
        //ฟังชั่น Read กับ  Update
        $user = User::where('email', $request['email'])->first();

        if (Hash::check($request['password'], $user['password'])) {
            $uuid = Str::random(32);
            session(['uuid' => $uuid]);
            $email = ($user['email']);

            $user->update([
                'uuid' => $uuid,
            ]);

            return redirect('/dashboard')->with('uuid', $uuid)->with('email', $email);
        }
}

public function logout(Request $request)
{
    //ฟั่งชั่น Delete
    $user = User::where('email', $request['email'])->first();

    if($user)
    {
        $user->delete();
        return redirect('/sign-up');
    }
}
}
