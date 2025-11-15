<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Order;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class TechnicianController extends Controller
{
    public function dashboard(){
        $orders = Order::where('status', 'pending')->get();
        return view('technician.technician', compact('orders'));
    }
    public function myOrder(){
       $orders = Order::where('technician_id', auth()->id())
                          ->whereIn('status', ['on_process', 'completed'])
                          ->with('user')
                          ->latest()
                          ->paginate(10);

            return view('technician.myOrder', compact('orders'));
    }


    public function create(){
        return view('test');
    }

    public function store(Request $request){
        $validate = validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()],
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
        ]);

        if ($validate->fails()) {
             return redirect()->back()->withErrors($validate)->withInput();
    }
    try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->role_id = 3;
            $user->save();
            $technician = new Technician();
            $technician->user_id = $user->id;
            $technician->specialization = $request->input('specialization');
            $technician->experience_years = $request->input('experience_years');
            $technician->save();

        return redirect()->back()->with('success', 'Technician Berhasil dibuat');
    } catch (Exception $e) {
        return response()->json([
            'message' => 'Internal Server Error',
            'error' => $e->getMessage()
        ], 500);
    }

    }


}
