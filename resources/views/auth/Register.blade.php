<form action={{ route('authregisterAction')}} method="POST">
@csrf

        <label for="name">Nama Lengkap:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Kata Sandi:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="password_confirmation">Konfirmasi Kata Sandi:</label><br>
        <input type="password" id="password_confirmation" name="password_confirmation" required><br><br>

        <label for="phone">Nomor Telepon:</label><br>
        <input type="text" id="phone" name="phone" required><br><br>

        <label for="address">Alamat:</label><br>
        <textarea id="address" name="address" rows="3" required></textarea><br><br>

        <button type="submit">Daftar</button>
</form>
