<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil | {{ config('app.name') }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Roboto, sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }
        .input-field {
            transition: all 0.2s ease;
            background-color: #f8fafc;
        }
        .input-field:focus {
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>
<body class="py-10 px-4 flex justify-center items-center">

    <div class="w-full max-w-3xl space-y-8">

        <!-- Pesan Sukses -->
        @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
            <div id="status-message" class="p-4 bg-green-500 text-white font-medium rounded-2xl shadow-lg flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Perubahan berhasil disimpan!</span>
                </div>
            </div>
            <script>setTimeout(() => { document.getElementById('status-message')?.remove(); }, 4000);</script>
        @endif

        <!-- KARTU 1: Informas Profil & Foto -->
        <div class="glass-card rounded-3xl p-8">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Informasi Profil</h2>
                <p class="text-sm text-gray-500">Perbarui foto, nama, dan alamat email akun Anda.</p>
            </div>

            <!-- Tambahkan enctype="multipart/form-data" jika ingin mendukung unggah foto -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('patch')

                <!-- Fitur 1: Foto Profil / Avatar -->
                <div class="flex items-center gap-6 pb-2">
                    <div class="relative">
                        <img id="avatar-preview" 
                             src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=3b82f6&color=fff' }}" 
                             alt="Avatar" 
                             class="w-20 h-20 rounded-full object-cover border-4 border-blue-100 shadow-md">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Profil</label>
                        <input type="file" name="avatar" id="avatar-input" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, max 2MB.</p>
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Alamat Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    
                    <!-- Fitur 2: Status Verifikasi Email -->
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2 p-3 bg-amber-50 rounded-xl border border-amber-200 text-sm text-amber-800">
                            Email Anda belum diverifikasi. 
                            <button form="send-verification" class="underline font-semibold hover:text-amber-900">Kirim ulang email verifikasi.</button>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-md transition">Simpan Profil</button>
                </div>
            </form>
        </div>

        <!-- KARTU 2: Fitur Ubah Password -->
        <div class="glass-card rounded-3xl p-8">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Ubah Kata Sandi</h2>
                <p class="text-sm text-gray-500">Pastikan akun Anda menggunakan kata sandi yang kuat dan aman.</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('put')

                <div>
                    <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-1">Kata Sandi Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                    @error('current_password', 'updatePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Kata Sandi Baru</label>
                    <input type="password" id="password" name="password" class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                    @error('password', 'updatePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                    @error('password_confirmation', 'updatePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-gray-800 hover:bg-black text-white font-bold px-6 py-2.5 rounded-xl shadow-md transition">Update Password</button>
                </div>
            </form>
        </div>

    </div>

    <!-- Script Preview Gambar Otomatis -->
    <script>
        document.getElementById('avatar-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                document.getElementById('avatar-preview').src = URL.createObjectURL(file);
            }
        });
    </script>
</body>
</html>