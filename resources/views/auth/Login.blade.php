@extends('layout.main')
@section('content')


<div class="absolute inset-0 -z-10 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/60 to-gray-100/60"></div>
    <div class="absolute top-1/3 left-1/4 w-48 h-48 md:w-64 md:h-64 rounded-full bg-blue-200/30 blur-3xl"></div>
    <div class="absolute bottom-1/3 right-1/4 w-48 h-48 md:w-64 md:h-64 rounded-full bg-blue-300/20 blur-3xl"></div>
</div>


<div class="w-full flex justify-center mt-28 mb-12 px-4">  
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
        <div class="flex flex-col items-center pt-8 pb-6 px-6 sm:px-8">

            
            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-lg mb-4 sm:mb-5">
                <i data-feather="tool" class="text-white w-6 h-6 sm:w-7 sm:h-7"></i>
            </div>

            
            <h1 class="text-2xl font-bold text-gray-800 mb-1">ServisIn</h1>
            <p class="text-gray-500 text-sm mb-6 text-center">Your mobile tech service solution</p>

            
            <form action="{{ route('authloginAction') }}" method="POST" class="w-full space-y-4">
                @csrf
                <div>
                    <label class="relative block">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i data-feather="mail" class="text-gray-400 w-5 h-5"></i>
                        </span>
                        <input type="email" id="email" name="email" placeholder="Email"
                            class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm"
                            required>
                    </label>
                </div>

                <div>
                    <label class="relative block">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i data-feather="lock" class="text-gray-400 w-5 h-5"></i>
                        </span>
                        <input type="password" id="password" name="password" placeholder="Password"
                            class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm"
                            required>
                    </label>
                </div>

                <button type="submit"
                    class="w-full py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-md transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Sign In
                </button>
            </form>

            
            <div class="text-center text-sm text-gray-500 mt-5">
                Don't have an account?
                <a href="{{ route('authregister') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">Create one</a>
            </div>
        </div>

        <div class="bg-gray-50 py-3 text-center text-xs text-gray-500 border-t border-gray-100">
            © 2025 ServisIn. All rights reserved.
        </div>
    </div>
</div>

@endsection

