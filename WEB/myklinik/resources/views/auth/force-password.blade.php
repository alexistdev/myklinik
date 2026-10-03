<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Demi keamanan, Anda harus mengganti password awal sebelum dapat menggunakan aplikasi.
    </div>

    <form method="POST" action="{{ route('password.force.update') }}">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" value="Password saat ini" />
            <x-text-input id="current_password" class="block mt-1 w-full" type="password" name="current_password" required autofocus autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password baru" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi password baru" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <button type="submit" form="logout-form" class="underline text-sm text-gray-600 hover:text-gray-900">Keluar</button>
            <x-primary-button>Simpan Password</x-primary-button>
        </div>
    </form>

    <form id="logout-form" method="POST" action="{{ route('logout') }}">@csrf</form>
</x-guest-layout>
