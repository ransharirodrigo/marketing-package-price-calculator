<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {

        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        } else if (!Auth::check()) {
            return view("login");
        }
    }

    public function adminLogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where("email", $email)->where("password", $password)->first();;

        if ($user) {
            Auth::login($user);
            return redirect()->route('admin.dashboard');
        } else {
            return back()->withErrors(['message' => 'Invalid credentials']);
        }
    }


    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['success' => true]);
    } 
}
