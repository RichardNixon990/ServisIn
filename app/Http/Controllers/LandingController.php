<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index()
    {
        $testimonials = Rating::with('user')->where('rating', 5)->latest()->take(3)->get();

        $dummyTestimonials = collect([
            (object)[
                'name' => 'Sarah J.',
                'comment' => 'Layanan cepat dan teknisi sangat profesional!',
            ],
            (object)[
                'name' => 'Michael T.',
                'comment' => 'Perbaikan di rumah, praktis dan hasilnya memuaskan.',
            ],
            (object)[
                'name' => 'Priya K.',
                'comment' => 'Awalnya ragu, tapi hasilnya di luar ekspektasi.',
            ],
        ]);
        if ($testimonials->count() < 3) {
            $data = 3 - $testimonials->count();
            $testimonials = $testimonials->concat($dummyTestimonials->take($data));
        }

        return view('landing', compact('testimonials'));
    }
}
