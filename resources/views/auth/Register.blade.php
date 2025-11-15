@extends('layout.main')
@section('content')

<!-- Background Decorative -->
<div class="absolute inset-0 -z-10 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/60 to-gray-100/60"></div>
    <div class="absolute top-1/3 left-1/4 w-48 h-48 md:w-64 md:h-64 rounded-full bg-blue-200/30 blur-3xl"></div>
    <div class="absolute bottom-1/3 right-1/4 w-48 h-48 md:w-64 md:h-64 rounded-full bg-blue-300/20 blur-3xl"></div>
</div>

<!-- Register Wrapper -->
<div class="flex justify-center mt-28 mb-12 px-4">
    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-3xl border border-gray-100 transition-all duration-300 hover:shadow-2xl">

        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-center shadow-md">
                <i data-feather="user-plus" class="text-white w-8 h-8"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Create Account</h1>
            <p class="text-gray-500 text-sm mt-1">Join ServisIn to manage your service orders easily</p>
        </div>

        <form action="{{ route('authregisterAction') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf

            <div class="relative">
                <i data-feather="user" class="absolute left-3 top-3.5 text-gray-400 w-5 h-5"></i>
                <input type="text" name="name" placeholder="Full Name"
                    class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
            </div>

            <div class="relative">
                <i data-feather="mail" class="absolute left-3 top-3.5 text-gray-400 w-5 h-5"></i>
                <input type="email" name="email" placeholder="Email Address"
                    class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
            </div>

            <div class="relative">
                <i data-feather="lock" class="absolute left-3 top-3.5 text-gray-400 w-5 h-5"></i>
                <input type="password" name="password" placeholder="Password"
                    class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
            </div>

            <div class="relative">
                <i data-feather="lock" class="absolute left-3 top-3.5 text-gray-400 w-5 h-5"></i>
                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                    class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
            </div>

            <div class="relative">
                <i data-feather="phone" class="absolute left-3 top-3.5 text-gray-400 w-5 h-5"></i>
                <input type="tel" name="phone" placeholder="Phone Number"
                    class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
            </div>

            <div class="relative">
                <i data-feather="map-pin" class="absolute left-3 top-3.5 text-gray-400 w-5 h-5"></i>
                <input type="text" name="address" placeholder="Address"
                    class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
            </div>

            <div class="md:col-span-2 mt-4">
                <button type="submit"
                    class="w-full py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-medium shadow-md hover:shadow-lg transition-all duration-200">
                    Register
                </button>
            </div>

            <div class="md:col-span-2 text-center text-sm text-gray-500 mt-2">
                Have an account?
                <a href="{{ route('authlogin') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">Log in</a>
            </div>
        </form>

        <p class="text-xs text-gray-500 text-center mt-6 border-t pt-4">
            © 2025 ServisIn. All rights reserved.
        </p>
    </div>
</div>

@endsection
