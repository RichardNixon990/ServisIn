<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{

    public function index(){
        try {
            $ratings = Rating::latest()->paginate(4);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
        // return view('User.listOrder', compact('orders'));
    }

    public function store(Request $request){
                $validate = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable',
        ]);

        if ($validate->fails()) {
             return redirect()->back()->withErrors($validate)->withInput();
    }

    try {
         $ratings = new Rating();
            $ratings->order_id = $request->input('order_id');
            $ratings->rating = $request->input('rating');
            $ratings->comment = $request->input('comment') ?? null;
            $ratings->save();
        return redirect()->back()->with('success', 'Rating berhasil dikirim!');
    } catch (Exception $e) {
        return response()->json([
            'message' => 'Internal Server Error',
            'error' => $e->getMessage()
        ], 500);
    }
    }


    public function delete(Request $request, Rating $ratings){
        try {
         $ratings->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
