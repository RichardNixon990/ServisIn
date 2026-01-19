<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function comfirmPayment(Request $request, Payment $payment){
    try {
        $payment->update([
            'payment_status' => 'paid',
            'paid_at' => now()
        ]);

        return redirect()->back()->with('success', 'Payment confirmed successfully.');
    } catch (Exception $e) {
        return response()->json([
            'message' => 'Internal Server Error',
            'error' => $e->getMessage()
        ], 500);
    }
    }

    // public function adminConfirmPayment(Request $request, Payment $payments){
    //     try {
    //         $payments->update([
    //             'payment_status' => 'paid',
    //             'confirmed_at' => now(),
    //             'confirmed_by' => auth()->id()
    //         ]);


    //         return redirect()->back()->with('success', 'Payment confirmed by admin successfully.');
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'message' => 'Internal Server Error',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
}
