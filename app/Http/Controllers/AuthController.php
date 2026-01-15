<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginPage(){
        return view('auth.Login');
    }
    public function showRegisterPage(){
        return view('auth.Register');
    }

    public function login(Request $request){
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $role = $user->role->nama_role;

        if ($role === 'admin') {
            return redirect()->route('adminDashboard');
        } elseif ($role === 'technician') {
            return redirect()->route('technicianDashboard');
        } else{
            return redirect()->route('orderlist');
        }

        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function register(Request $request){
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => ['required','confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()],
            'phone' => 'required',
            'address' => 'required'
        ]);
           if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        $findUserRole = Role::where('nama_role', 'user')->first();
        if (!$findUserRole) {
            $addUserRole = new Role();
            $addUserRole->nama_role = 'user';
            $addUserRole->save();

            $id = $addUserRole->id;
        } else {
            $id = $findUserRole->id;
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->role_id = $id;
        $user->password = Hash::make($request->input('password'));
        $user->save();

        Auth::login($user);

        return redirect()->route('orderlist')->with('success', 'Registrasi berhasil dan Anda sudah login!');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Registrasi berhasil dan Anda sudah login!');
    }


}
