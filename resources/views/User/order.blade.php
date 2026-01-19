@extends('layout.main')
@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-6 md:pt-32">
        <div class="max-w-4xl mx-auto">
            
            <div class="mb-8">
                <a href={{ route('orderlist') }}
                    class="inline-flex items-center text-blue-600 hover:text-blue-700 transition-colors duration-200 mb-6 group">
                    <i data-feather="arrow-left" class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform"></i>
                    <span class="font-medium">Kembali ke Daftar Pesanan</span>
                </a>
                <div class="text-center mb-2">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">
                        Buat Pesanan <span class="text-blue-600">Baru</span>
                    </h1>
                    <p class="text-base text-gray-600 max-w-2xl mx-auto">
                        Isi detail perangkat dan keluhan Anda. Teknisi terbaik kami akan segera membantu memperbaiki
                        perangkat Anda.
                    </p>
                </div>
            </div>

            
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i data-feather="clipboard" class="w-6 h-6 mr-3"></i>
                        Detail Pesanan
                    </h2>
                </div>

                <form action="{{ route('orderstore') }}" method="POST" enctype="multipart/form-data"
                    class="p-8 md:p-10 space-y-6" id="order-form" data-errors="{{ $errors->any() ? json_encode($errors->all()) : '[]' }}">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i data-feather="smartphone" class="w-4 h-4 mr-2 text-blue-600"></i>
                                Jenis Perangkat
                            </label>
                            <div class="relative">
                                <select name="device_type" id="device_type" required
                                    class="w-full pl-4 pr-10 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white hover:border-gray-300 cursor-pointer">
                                    <option value="" selected disabled>Pilih Jenis Perangkat</option>
                                    <option value="hp">HP</option>
                                    <option value="laptop">Laptop</option>
                                    <option value="tablet">Tablet</option>
                                </select>
                                <i data-feather="chevron-down"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5 pointer-events-none"></i>
                            </div>
                        </div>

                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i data-feather="tag" class="w-4 h-4 mr-2 text-blue-600"></i>
                                Merek Perangkat
                            </label>
                            <input type="text" name="brand" id="brand" required placeholder="Contoh: Samsung, Apple, Asus..."
                                class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300">
                        </div>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i data-feather="alert-circle" class="w-4 h-4 mr-2 text-blue-600"></i>
                            Deskripsi Kerusakan
                        </label>
                        <textarea name="issue_description" id="issue_description" rows="5" required
                            placeholder="Jelaskan secara detail masalah yang dialami perangkat Anda..."
                            class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none hover:border-gray-300"></textarea>
                    </div>

                    
                    <div class="grid md:grid-cols-2 gap-6">
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i data-feather="calendar" class="w-4 h-4 mr-2 text-blue-600"></i>
                                Tanggal Penjadwalan
                            </label>
                            <input type="date" name="schedule_date" id="schedule_date" required
                                class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300">
                        </div>

                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i data-feather="map-pin" class="w-4 h-4 mr-2 text-blue-600"></i>
                                Alamat Lengkap Perbaikan
                            </label>

                            <input type="text" name="address" id="address" value="{{ auth()->user()->address }}"
                                placeholder="Masukkan alamat lengkap jika berbeda dari alamat akun..."
                                class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300">
                            <p class="text-xs text-gray-500 mt-1">
                                Biarkan seperti ini untuk menggunakan alamat dari akun Anda.
                            </p>
                        </div>

                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i data-feather="image" class="w-4 h-4 mr-2 text-blue-600"></i>
                                Upload Foto Kerusakan
                                <span class="ml-2 text-xs font-normal text-gray-500">(Opsional)</span>
                            </label>

                            <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition-all duration-200 bg-gray-50 hover:bg-blue-50 cursor-pointer group"
                                id="upload-area">
                                <input type="file" name="photo" id="photo-input"
                                    accept="image/png,image/jpeg,image/jpg"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                                
                                <div class="flex flex-col items-center" id="upload-placeholder">
                                    <div
                                        class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
                                        <i data-feather="upload-cloud" class="w-8 h-8 text-blue-600"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-700 mb-1">Klik untuk upload atau drag & drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG atau JPEG (Max. 2MB)</p>
                                </div>

                                
                                <div class="hidden" id="image-preview-container">
                                    <img src="" alt="Preview" id="image-preview"
                                        class="max-h-48 mx-auto rounded-lg shadow-md mb-3">
                                    <p class="text-sm font-medium text-gray-700 mb-2" id="file-name"></p>
                                    <button type="button" id="remove-image"
                                        class="text-xs text-red-600 hover:text-red-800 font-medium flex items-center justify-center mx-auto">
                                        <i data-feather="x-circle" class="w-4 h-4 mr-1"></i>
                                        Hapus Foto
                                    </button>
                                </div>
                            </div>
                        </div>

                        
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-2xl hover:scale-[1.02] active:scale-95 transition-all duration-200 flex items-center justify-center group">
                                <i data-feather="send"
                                    class="w-5 h-5 mr-3 group-hover:translate-x-1 transition-transform"></i>
                                Kirim Pesanan Sekarang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
@endsection
@push('script')
<script src="{{ asset('js/User/order.js') }}" defer></script>
@endpush

