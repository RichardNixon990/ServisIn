@extends('layout.main')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8 px-4 sm:px-6 lg:px-8 pt-28 md:pt-32">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <a href="/" class="hover:text-blue-600">Home</a>
                <i data-feather="chevron-right" class="w-4 h-4 mx-2"></i>
                <span class="text-gray-900 font-medium">Profil Saya</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">
                <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Profil Saya</span>
            </h1>
            <p class="text-gray-600 mt-1">
                Kelola informasi profil Anda untuk mengontrol dan mengamankan akun Anda.
            </p>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Side (Info Card) -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-2xl transition-all">
                <div class="space-y-2 mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">John Doe</h2>
                    <p class="text-gray-500 text-sm flex items-center">
                        <i data-feather="calendar" class="w-3 h-3 mr-1.5"></i>
                        Member sejak Nov 2024
                    </p>
                    <p class="text-gray-700 mt-3">
                        <i data-feather="mail" class="w-4 h-4 inline mr-1 text-blue-600"></i>
                        johndoe@email.com
                    </p>
                    <p class="text-gray-700">
                        <i data-feather="phone" class="w-4 h-4 inline mr-1 text-blue-600"></i>
                        +62 812-3456-7890
                    </p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-3 text-center border-t border-gray-100 pt-4">
                    <div>
                        <p class="text-xl font-bold text-gray-900">15</p>
                        <p class="text-xs text-gray-500">Pesanan</p>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-gray-900">12</p>
                        <p class="text-xs text-gray-500">Selesai</p>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-gray-900">4.8</p>
                        <p class="text-xs text-gray-500">Rating</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 space-y-3">
                    <a href="#" class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-xl font-semibold shadow hover:shadow-lg transition-all">
                        <i data-feather="shopping-bag" class="w-5 h-5 mr-2"></i> Lihat Pesanan
                    </a>
                    <a href="#" class="w-full flex items-center justify-center px-4 py-3 border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white rounded-xl font-semibold transition-all">
                        <i data-feather="settings" class="w-5 h-5 mr-2"></i> Pengaturan Akun
                    </a>
                </div>
            </div>

            <!-- Right Side -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Pribadi -->
                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                                <i data-feather="user" class="w-5 h-5 text-blue-600"></i>
                            </div>
                            Informasi Pribadi
                        </h2>
                        <button onclick="toggleEdit('personal')" class="flex items-center px-4 py-2 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg border-2 border-blue-600 transition-all duration-300">
                            <i data-feather="edit-2" class="w-4 h-4 mr-2"></i>
                            <span id="personalEditText">Edit</span>
                        </button>
                    </div>

                    <form id="personalForm" class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" value="John Doe" disabled
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl disabled:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" value="johndoe@email.com" disabled
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl disabled:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                            <textarea disabled rows="3"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl disabled:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">Jl. Merdeka No. 123, Bandung</textarea>
                        </div>

                        <div id="personalButtons" class="hidden flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <button type="button" onclick="toggleEdit('personal')" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition">Batal</button>
                            <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">Simpan</button>
                        </div>
                    </form>
                </div>

                <!-- Logout -->
                <div class="bg-white rounded-2xl shadow p-6 border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center mb-3">
                        <i data-feather="log-out" class="w-5 h-5 mr-2 text-blue-600"></i> Logout
                    </h2>
                    <p class="text-gray-600 text-sm mb-4">
                        Anda akan keluar dari akun ini. Pastikan semua perubahan sudah disimpan.
                    </p>
                    <form action="" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl shadow hover:shadow-lg transition-all">
                            Keluar Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function toggleEdit(formType) {
        const form = document.getElementById(`${formType}Form`);
        const buttons = document.getElementById(`${formType}Buttons`);
        const inputs = form.querySelectorAll('input, textarea');
        const editText = document.getElementById(`${formType}EditText`);

        const isDisabled = inputs[0].disabled;
        inputs.forEach(input => input.disabled = !isDisabled);
        buttons.classList.toggle('hidden');
        editText.textContent = isDisabled ? 'Batal' : 'Edit';
        feather.replace();
    }
</script>
@endsection
a
