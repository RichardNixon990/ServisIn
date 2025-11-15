<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Teknisi</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6">Tambah Teknisi Baru</h2>

    <form action="{{(route('technicianstore'))}}" method="POST">
      <!-- Ganti URL di atas sesuai route store kamu -->

      <!-- Token CSRF -->
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="mb-4">
        <label for="name" class="block text-gray-700 font-semibold">Nama Lengkap</label>
        <input type="text" id="name" name="name" required
               class="w-full border border-gray-300 p-2 rounded mt-1 focus:ring focus:ring-indigo-200">
      </div>

      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-semibold">Email</label>
        <input type="email" id="email" name="email" required
               class="w-full border border-gray-300 p-2 rounded mt-1 focus:ring focus:ring-indigo-200">
      </div>

      <div class="mb-4">
        <label for="password" class="block text-gray-700 font-semibold">Password</label>
        <input type="password" id="password" name="password" required minlength="8"
               class="w-full border border-gray-300 p-2 rounded mt-1 focus:ring focus:ring-indigo-200">
      </div>

      <div class="mb-4">
        <label for="phone" class="block text-gray-700 font-semibold">Nomor Telepon</label>
        <input type="text" id="phone" name="phone" required maxlength="20"
               class="w-full border border-gray-300 p-2 rounded mt-1 focus:ring focus:ring-indigo-200">
      </div>

      <div class="mb-4">
        <label for="address" class="block text-gray-700 font-semibold">Alamat</label>
        <textarea id="address" name="address" required
                  class="w-full border border-gray-300 p-2 rounded mt-1 focus:ring focus:ring-indigo-200"></textarea>
      </div>

      <div class="mb-4">
        <label for="specialization" class="block text-gray-700 font-semibold">Spesialisasi</label>
        <input type="text" id="specialization" name="specialization" required
               class="w-full border border-gray-300 p-2 rounded mt-1 focus:ring focus:ring-indigo-200">
      </div>

      <div class="mb-4">
        <label for="experience_years" class="block text-gray-700 font-semibold">Pengalaman (Tahun)</label>
        <input type="number" id="experience_years" name="experience_years" required min="0"
               class="w-full border border-gray-300 p-2 rounded mt-1 focus:ring focus:ring-indigo-200">
      </div>

      <button type="submit"
              class="w-full bg-indigo-600 text-white p-2 rounded hover:bg-indigo-700 transition-colors">
        Simpan Teknisi
      </button>
    </form>
  </div>
</body>
</html>
