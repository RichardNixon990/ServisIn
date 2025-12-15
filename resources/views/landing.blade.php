@extends('layout.main')
@section('content')

    <!-- Hero Section -->
    <section class="py-16 md:py-24 px-6 md:pt-32">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Perbaikan perangkat jadi
                    <span class="text-blue-600">mudah</span> dan
                    <span class="text-blue-600">terpercaya</span>
                </h1>
                <p class="text-lg text-gray-600">
                    Terhubung dengan teknisi bersertifikat yang siap datang ke lokasi Anda untuk perbaikan cepat dan
                    terjangkau untuk ponsel, laptop, dan elektronik lainnya.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    @if (auth()->check())
                    @if (Auth::user()->role->nama_role == 'admin')
                    <a
                    href={{route('adminDashboard')}}
                    class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium rounded-full px-8 py-4 text-center shadow-lg hover:shadow-xl transition-all duration-200">
                    Pesan Teknisi Sekarang
                </a>
                @elseif (Auth::user()->role->nama_role == 'technician')
                <a
                href={{route('technicianDashboard')}}
                class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium rounded-full px-8 py-4 text-center shadow-lg hover:shadow-xl transition-all duration-200">
                Pesan Teknisi Sekarang
            </a>
            @else
            <a
            href={{route('orderlist')}}
            class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium rounded-full px-8 py-4 text-center shadow-lg hover:shadow-xl transition-all duration-200">
            Pesan Teknisi Sekarang
        </a>

                    @endif

                @else
                <a href={{route('authlogin')}}
                class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium rounded-full px-8 py-4 text-center shadow-lg hover:shadow-xl transition-all duration-200">
                Pesan Teknisi Sekarang
            </a>
                    @endif
                    <a href="#how-it-works"
                        class="border-2 border-blue-600 text-blue-600 font-medium rounded-full px-8 py-4 text-center hover:bg-blue-50 transition-all duration-200">
                        Cara Kerja
                    </a>
                </div>
            </div>
            <div class="relative">
                <img src="http://static.photos/technology/1024x576/1" alt="Teknisi memperbaiki ponsel"
                    class="rounded-2xl shadow-xl w-full">
                <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-blue-100 rounded-2xl -z-10"></div>
                <div class="absolute -top-6 -right-6 w-20 h-20 bg-blue-200 rounded-full -z-10"></div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Mengapa Memilih ServisIn</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-md transition-all duration-200">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <i data-feather="clock" class="text-blue-600 w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Layanan Cepat</h3>
                    <p class="text-gray-600">Rata-rata waktu respon di bawah 2 jam untuk area perkotaan.</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-md transition-all duration-200">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <i data-feather="shield" class="text-blue-600 w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Teknisi Terverifikasi</h3>
                    <p class="text-gray-600">Semua teknisi telah melalui pemeriksaan latar belakang dan bersertifikat.</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-md transition-all duration-200">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <i data-feather="map-pin" class="text-blue-600 w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Pantau Status</h3>
                    <p class="text-gray-600">Lihat pembaruan teknisi.</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-2xl hover:shadow-md transition-all duration-200">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <i data-feather="headphones" class="text-blue-600 w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Dukungan 24/7</h3>
                    <p class="text-gray-600">Tim kami selalu siap membantu kapan pun Anda butuh.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16">Cara Kerja</h2>
            <div class="grid md:grid-cols-4 gap-8">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="text-white font-bold text-xl">{{ $i }}</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">
                            {{ ['Pesan', 'Terhubung', 'Perbaiki', 'Selesai'][$i - 1] }}
                        </h3>
                        <p class="text-gray-600">
                            {{ [
                                'Ceritakan perangkat dan masalah yang Anda alami.',
                                'Kami akan mencarikan teknisi terdekat untuk Anda.',
                                'Teknisi datang dan memperbaiki perangkat Anda.',
                                'Nikmati kembali perangkat Anda yang sudah berfungsi dengan baik!',
                            ][$i - 1] }}
                        </p>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Apa Kata Pelanggan Kami</h2>
            <div class="grid md:grid-cols-3 gap-8">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="bg-gray-50 p-8 rounded-2xl">
                        <div class="flex items-center mb-6">
                            <img src="http://static.photos/people/200x200/{{ $i }}" alt="Pelanggan"
                                class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-semibold">{{ ['Sarah J.', 'Michael T.', 'Priya K.'][$i - 1] }}</h4>
                                <div class="flex text-yellow-400">
                                    @for ($s = 0; $s < 5; $s++)
                                        <i data-feather="star" class="w-4 h-4 fill-current"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600">
                            {{ [
                                '"Layar ponsel saya retak dan saya dapat layanan di hari yang sama. Teknisi sangat profesional dan selesai dalam waktu kurang dari satu jam!"',
                                '"Laptop saya tidak mau menyala setelah terkena air. ServisIn membantu saya menemukan teknisi ahli yang memperbaikinya di kantor saya."',
                                '"Awalnya ragu perbaikan di rumah, tapi teknisinya sangat berpengalaman dan tablet saya kembali normal seperti baru!"',
                            ][$i - 1] }}
                        </p>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="book" class="py-16 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="max-w-4xl mx-auto text-center px-6">
            <h2 class="text-3xl font-bold mb-6">Siap memperbaiki perangkat Anda?</h2>
            <p class="text-lg mb-8 opacity-90">Bergabunglah dengan ribuan pelanggan puas yang sudah memperbaiki perangkat
                mereka dengan cepat dan hemat.</p>
            <a href="#"
                class="bg-white text-blue-600 hover:bg-gray-100 font-medium rounded-full px-8 py-4 inline-block shadow-lg hover:shadow-xl transition-all duration-200">
                Pesan Teknisi Sekarang
            </a>
        </div>
    </section>
@endsection
