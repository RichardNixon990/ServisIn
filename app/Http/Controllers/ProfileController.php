<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view('User.profile', compact('user'));
    }

    public function update(Request $request, User $users){
        try {
            $validate = Validator::make($request->all(), [
                'name' => 'nullable',
                'email' => 'nullable|email',
                'phone' => 'nullable|integer',
                'address' => 'nullable',
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            $users->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
            return back()->with('success', 'berhasil mengupdate user');
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePassword(Request $request){
        try {
             $user = Auth::user();
            $validate = Validator::make($request->all(), [
               'old_password' => 'required',
               'new_password' => [ ['required',
                   Password::min(8)
                       ->mixedCase()
                       ->letters()
                       ->numbers()
                       ->symbols()],],
                'confirm_password' => 'required|string|same:new_password'
           ]);

           if (!Hash::check($request->old_password, $user->password)) {
           return response()->json([
               'success' => false,
               'message' => 'Password lama tidak sesuai'
           ], 422);
        }

           if (Hash::check($request->new_password, $user->password)) {
           return response()->json([
               'success' => false,
               'message' => 'Password baru tidak boleh sama dengan password lama'
           ], 422);
        }
           $user->password = Hash::make($request->new_password);
           $user->save();

           return back()->with('success', 'berhasil mengupdate user');

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
