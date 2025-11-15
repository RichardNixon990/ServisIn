<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repositories\FileUploadRepository;

class OrderController extends Controller
{
    protected $upload;

    public function __construct()
    {
        $this->upload = new FileUploadRepository();
    }

    public function index(){
        try {
            $user = Auth::user();
            if($user->role === 'admin' || $user->role === 'technician'){
                $orders = Order::latest()->paginate(10);
            }else{
                $orders = Order::where('user_id', $user->id)
                ->latest()->paginate(10);
            }
            return view('User.listOrder', compact('orders'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function create(){
        return view('User.order');
    }

    public function store(Request $request){
        $validate = Validator::make($request->all(), [
            'technician_id' => 'nullable|exists:users,id',
            'device_type' => 'required|in:hp,laptop,tablet',
            'brand' => 'required',
            'issue_description' => 'required',
            'address' => 'nullable',
            'schedule_date' => 'required',
            'estimated_cost' => 'nullable',
            'final_cost' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'notes' => 'nullable'
        ]);

        if ($validate->fails()) {
             return redirect()->back()->withErrors($validate)->withInput();
    }
        try {
            $orders = new Order();
            $orders->user_id = auth()->id(); // user login
            $orders->technician_id = $request->input('technician_id') ?? null;
            $orders->device_type = $request->input('device_type');
            $orders->brand = $request->input('brand');
            $orders->issue_description = $request->input('issue_description');
            $orders->address = $request->input('address') ?? auth()->user()->address;
            $orders->schedule_date = $request->input('schedule_date');
            $orders->status = 'pending'; // default
            $orders->estimated_cost = $request->input('estimated_cost') ?? null;
            $orders->final_cost = $request->input('final_cost') ?? null;
            // $orders->notes = $request->input('notes') ?? null;
            $orders->save();

            if ($request->hasFile('photo')) {
                $path = $this->upload->upload($request->file('photo'), 'orders');
                $orders->photo = $path;
            } else {
                $orders->photo = null;
            }
            return redirect()->route('orderlist')->with('success', 'Order berhasil ditambahkan.');
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function takeorder(Request $request, Order $orders){
        try {
                   $user = Auth::user();

            if ($user->role->nama_role !== 'technician') {
                return back()->with('error', 'Hanya teknisi yang dapat mengambil pesanan.');
            }

            if ($orders->technician_id !== null) {
                return back()->with('error', 'Pesanan sudah diambil oleh teknisi lain.');
            }

            $activeOrdersCount = Order::where('technician_id', $user->id)
                ->where('status', 'on_process')
                ->count();

            if ($activeOrdersCount >= 5) {
                return back()->with('error', 'Anda telah mencapai batas maksimal 5 pesanan yang sedang dikerjakan.');
            }


            $orders->update([
                'technician_id' => $user->id,
                'status' => 'on_process'
            ]);

            return back()->with('success', 'Pesanan berhasil diambil!');
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function Cancel(Request $request, Order $orders){
        try {

            if (auth()->id() !== $orders->user_id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk membatalkan pesanan ini.');
            }

            $orders->status = 'cancelled';
            $orders->save();

            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // public function delete(Request $request, Order $orders){
    //     try {
    //         if ($orders->photo) {
    //         $this->upload->delete($orders->photo);
    //     }

    //     $orders->delete();

    //     return redirect()->back()->with('success', 'Pesanan berhasil dihapus.');
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'message' => 'Internal Server Error',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }

    // }


}
