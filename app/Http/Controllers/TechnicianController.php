<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Order;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class TechnicianController extends Controller
{
    public function dashboard(){
        try {
        $technicianId = auth()->id();

        $stats =[
            'available' => Order::where('status', 'pending')->count(),

            'active' => Order::where('status', 'on_process')->where('technician_id', $technicianId)->count(),

            'completed' => Order::where('status', 'completed')->whereDate('updated_at', today())->where('technician_id', $technicianId)->count(),
             'total_completed' => Order::where('status', 'completed')->where('technician_id', $technicianId)->count()

        ];
        $orders = Order::where('status', 'pending')->paginate(9);
        $technicianStatus = Auth::user()->technician->status ?? 'offline';
        return view('technician.technician', compact('orders', 'stats', 'technicianStatus'));

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }

    }
    public function myOrder(){
        try {
        $technicianId = auth()->user()->technician->id;
        $orders = Order::where('technician_id', $technicianId)
                          ->whereIn('status', ['on_process', 'completed'])
                          ->with('user')
                          ->latest()
                          ->paginate(10);

            return view('technician.myOrder', compact('orders'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }

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
            'status' => 'nullable|in:online,offline',
        ]);

        if ($validate->fails()) {
             return redirect()->back()->withErrors($validate)->withInput();
    }
    $role = Role::where('nama_role', 'technician')->first();

    if (!$role) {
        return back()->with('error', 'Role technician tidak ditemukan.');
    }
    try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->role_id = $role->id;
            $user->save();
            $technician = new Technician();
            $technician->user_id = $user->id;
            $technician->specialization = $request->input('specialization');
            $technician->experience_years = $request->input('experience_years');
            $technician->status = $request->status ?? 'offline';
            $technician->save();

        return redirect()->back()->with('success', 'Technician Berhasil dibuat');
    } catch (Exception $e) {
        return response()->json([
            'message' => 'Internal Server Error',
            'error' => $e->getMessage()
        ], 500);
    }

    }

    public function updateStatus(Request $request, Technician $technician){
          try {
        $validated = $request->validate([
            'status' => 'required|in:online,offline'
        ]);

        $technician = auth()->user()->technician;

        if (!$technician) {
            return back()->with('error', 'Technician tidak ditemukan.');
        }

        $technician->update([
            'status' => $validated['status']
        ]);

        return back()->with('success', 'Status berhasil diperbarui.');

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Technician $technician){
        try {
            $validate = Validator::make($request->all(), [
              'name' => 'nullable|string|max:255',
              'email' => 'nullable|email|unique:users,email,' . $technician->user_id,
              'phone' => 'nullable|string|max:20',
              'address' => 'nullable|string',
              'specialization' => 'nullable|string|max:255',
              'experience_years' => 'nullable|integer|min:0',
              'status' => 'nullable|in:online,offline',
          ]);


          if ($validate->fails()) {
               return redirect()->back()->withErrors($validate)->withInput();
      }
   // Update user data
        $technician->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Update technician data
        $technician->update([
            'specialization' => $request->specialization,
            'experience_years' => $request->experience_years,
            'status' => $request->status,
        ]);
 return redirect()->back()->with('success', 'Data teknisi berhasil diupdate!');

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request, Technician $technician){
        try {
            $technician->user()->delete();

            $technician->delete();

            return redirect()->back()->with('success', 'Pesanan berhasil dihapus.');
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
