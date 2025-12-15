<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Technician;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function Dashboard(){
        try {

            $orders = Order::with(['user', 'technician.user'])->latest()->paginate(10);
            $technicians = Technician::with(['user'])->withCount([
                'orders as total_orders',
                'orders as active_orders' => function ($q) {
                    $q->where('status', 'on_process');
                },
                'orders as completed_orders' => function ($q) {
                    $q->where('status', 'completed');
                }
            ])->get();

            foreach ($technicians as $technician) {
                $averageRating = $technician->ratings()->avg('rating');
                $technician->average_rating = $averageRating ?? 0;
            }


            $deviceStats = [
                'hp' => Order::where('device_type', 'hp')->count(),
                'laptop' => Order::where('device_type', 'laptop')->count(),
                'tablet' => Order::where('device_type', 'tablet')->count(),
            ];
            $totalOrders = array_sum($deviceStats);

            $barDevice = [
                'hp' => $totalOrders > 0 ? ($deviceStats['hp'] / $totalOrders) * 100 : 0,
                'laptop' => $totalOrders > 0 ? ($deviceStats['laptop'] / $totalOrders) * 100 : 0,
                'tablet' => $totalOrders > 0 ? ($deviceStats['tablet'] / $totalOrders) * 100 : 0,
            ];

            $statusStats = [
                'pending' => Order::where('status', 'pending')->count(),
                'on_process' => Order::where('status', 'on_process')->count(),
                'completed' => Order::where('status', 'completed')->count(),
                'cancelled' => Order::where('status', 'cancelled')->count(),
            ];
            $totalStatus = array_sum($statusStats);
            $barStatus =[
                'pending' => $totalStatus > 0 ? ($statusStats['pending'] / $totalStatus) * 100 : 0,
                'on_process' => $totalStatus > 0 ? ($statusStats['on_process'] / $totalStatus) * 100 : 0,
                'completed' => $totalStatus > 0 ? ($statusStats['completed'] / $totalStatus) * 100 : 0,
                'cancelled' => $totalStatus > 0 ? ($statusStats['cancelled'] / $totalStatus) * 100 : 0,

            ];

            $completedToday = Order::where('status', 'completed')->whereDate('updated_at', today())->count();

            $role = Role::where('nama_role', 'user')->first();
            $users = User::withCount('orders')->where('role_id', $role->id)->latest()->paginate(10);
            $totalUser = User::where('role_id', $role->id)->count();
            $totalTechnician = Technician::count();
            return view('admin.dashboardAdmin', compact('orders', 'users', 'barDevice', 'deviceStats', 'technicians', 'barStatus', 'statusStats', 'totalStatus','totalUser','completedToday', 'totalTechnician' ));

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showTechnicianOrders(Technician $technician, Request $request)
    {
        try {
            $orders = $technician->orders()
                    ->with('user')
                    ->latest()
                    ->paginate(10);

        return view('admin.showOrderTechnician', compact('technician', 'orders'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function exportPdf(){
        $orders = Order::with(['user', 'technician.user'])->latest()->get();
            $deviceStats = [
                'hp' => Order::where('device_type', 'hp')->count(),
                'laptop' => Order::where('device_type', 'laptop')->count(),
                'tablet' => Order::where('device_type', 'tablet')->count(),
            ];
            $totalOrders = array_sum($deviceStats);

                $technicians = Technician::with(['user'])->withCount([
                'orders as total_orders',
                'orders as active_orders' => function ($q) {
                    $q->where('status', 'on_process');
                },
                'orders as completed_orders' => function ($q) {
                    $q->where('status', 'completed');
                }
            ])->get();

            foreach ($technicians as $technician) {
                $averageRating = $technician->ratings()->avg('rating');
                $technician->average_rating = $averageRating ?? 0;
            }

            $statusStats = [
                'pending' => Order::where('status', 'pending')->count(),
                'on_process' => Order::where('status', 'on_process')->count(),
                'completed' => Order::where('status', 'completed')->count(),
                'cancelled' => Order::where('status', 'cancelled')->count(),
            ];
            $totalStatus = array_sum($statusStats);


        $pdf = Pdf::loadView('admin.exportPdf', compact('orders', 'deviceStats', 'totalOrders', 'technicians', 'statusStats', 'totalStatus'))->setPaper('a4', 'portrait');
        return $pdf->download('Laporan-order-' . date('F-Y') . '.pdf');
        // return view('admin.exportPdf', compact('orders', 'deviceStats', 'totalOrders', 'technicians', 'statusStats', 'totalStatus'));
    }

    
}
