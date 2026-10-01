<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Daftar Akun OPD - Portal ITSA Prov. Jawa Timur</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>

</head>

<body
      class="bg-[#ebf1f6] min-h-screen flex flex-col justify-center items-center py-10 px-4 antialiased selection:bg-[#1b365d] selection:text-white">


    <!-- Top Logo & Header -->
    <div class="flex flex-col items-center mb-6 text-center">

        <!-- Logo Icon -->
        <div
             class="w-14 h-14 bg-[#1b365d] rounded-2xl flex items-center justify-center shadow-md mb-4">

            <span class="text-white font-extrabold text-xl tracking-wider">IT</span>

        </div>


        <!-- Header Text -->
        <h1
            class="text-2xl md:text-[28px] font-bold text-[#1b365d] tracking-tight mb-1">

            Daftar Akun OPD

        </h1>

        <p class="text-slate-500 text-sm md:text-base font-normal">

            Portal ITSA Prov. Jawa Timur

        </p>

    </div>


    <!-- Main Card Container -->
    <div
         class="w-full max-w-[620px] bg-white rounded-[24px] shadow-[0_10px_35px_rgba(0,0,0,0.03)] border border-slate-100 p-7 md:p-10">


        <!-- Error Notification -->
        @if ($errors->any())

            <div
                 class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm">

                <div class="font-semibold mb-1">Terjadi kesalahan:</div>

                <ul class="list-disc list-inside space-y-1 text-xs">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form method="POST"
              action="{{ route('register.process') }}"
              class="space-y-4">

            @csrf


            <!-- Form Fields Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">


                <!-- Nama Lengkap -->
                <div>

                    <label for="name"
                           class="block text-xs md:text-sm font-semibold text-[#1b365d] mb-1.5">

                        Nama Lengkap

                    </label>

                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="Nama sesuai NIP"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1b365d]/20 focus:border-[#1b365d] transition-all">

                </div>


                <!-- NIP -->
                <!-- <div>

                    <label for="nip"
                           class="block text-xs md:text-sm font-semibold text-[#1b365d] mb-1.5">

                        NIP

                    </label>

                    <input type="text"
                           id="nip"
                           name="nip"
                           value="{{ old('nip') }}"
                           placeholder="198xxxxxx"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1b365d]/20 focus:border-[#1b365d] transition-all">

                </div> -->


                <!-- Email Dinas -->
                <div>

                    <label for="email"
                           class="block text-xs md:text-sm font-semibold text-[#1b365d] mb-1.5">

                        Email Dinas

                    </label>

                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="nama@dinas.jatimprov.go.id"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1b365d]/20 focus:border-[#1b365d] transition-all">

                </div>


                <!-- Jabatan -->
                <!-- <div>

                    <label for="jabatan"
                           class="block text-xs md:text-sm font-semibold text-[#1b365d] mb-1.5">

                        Jabatan

                    </label>

                    <input type="text"
                           id="jabatan"
                           name="jabatan"
                           value="{{ old('jabatan') }}"
                           placeholder="Kepala Bidang..."
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1b365d]/20 focus:border-[#1b365d] transition-all">

                </div> -->


                <!-- Nama OPD (Full Width) -->
                <div class="md:col-span-2">

                    <label for="biro"
                           class="block text-xs md:text-sm font-semibold text-[#1b365d] mb-1.5">

                        Nama BIRO

                    </label>

                    <input type="text"
                           id="biro"
                           name="biro"
                           value="{{ old('biro') }}"
                           placeholder="Dinas / Badan / Biro..."
                           required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1b365d]/20 focus:border-[#1b365d] transition-all">

                </div>


                <!-- Password -->
                <div>

                    <label for="password"
                           class="block text-xs md:text-sm font-semibold text-[#1b365d] mb-1.5">

                        Password

                    </label>

                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="Min. 8 karakter"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1b365d]/20 focus:border-[#1b365d] transition-all">

                </div>

                
                <!-- Konfirmasi Password -->
                <div>

                    <label for="password_confirmation"
                           class="block text-xs md:text-sm font-semibold text-[#1b365d] mb-1.5">

                        Konfirmasi Password

                    </label>

                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           placeholder="Ulangi password"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1b365d]/20 focus:border-[#1b365d] transition-all">

                </div>


            </div>


            <!-- Submit Button -->
            <div class="pt-2">

                <button type="submit"
                        class="w-full py-3.5 px-4 bg-[#1b365d] hover:bg-[#142948] active:scale-[0.99] text-white font-semibold rounded-xl text-sm md:text-base shadow-sm transition-all duration-200 cursor-pointer">

                    Daftar Akun

                </button>

            </div>

        </form>


        <!-- Bottom Link -->
        <div class="text-center text-sm text-slate-500 mt-6">

            Sudah punya akun?

            <a href="{{ route('login') }}"
               class="font-bold text-[#1b365d] hover:underline">

                Masuk

            </a>

        </div>


    </div>


</body>

</html>