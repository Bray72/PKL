<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login - Portal ITSA</title>

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

            Portal ITSA

        </h1>

        <p class="text-slate-500 text-sm md:text-base font-normal">

            Pemerintah Provinsi Jawa Timur

        </p>

    </div>


    <!-- Main Card Container -->
    <div
         class="w-full max-w-[450px] bg-white rounded-[24px] shadow-[0_10px_35px_rgba(0,0,0,0.03)] border border-slate-100 p-7 md:p-9">


        <!-- Card Title -->
        <h2 class="text-center text-xl font-bold text-[#1b365d] mb-5">

            Masuk ke Akun

        </h2>


        <!-- Role Segmented Control (Tabs) -->
        <!-- <div class="bg-[#f1f5f9] p-1.5 rounded-2xl flex mb-6">

            <button type="button"
                    id="tab-opd"
                    onclick="switchTab('opd')"
                    class="flex-1 py-2.5 rounded-xl text-sm font-bold text-center transition-all bg-white text-[#1b365d] shadow-sm cursor-pointer">

                OPD

            </button>

            <button type="button"
                    id="tab-admin"
                    onclick="switchTab('admin')"
                    class="flex-1 py-2.5 rounded-xl text-sm font-medium text-center transition-all text-slate-500 hover:text-slate-700 cursor-pointer">

                Admin ITSA

            </button>

        </div> -->


        <!-- Success Notification -->
        @if (session('success'))

            <div
                 class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">

                {{ session('success') }}

            </div>

        @endif


        <!-- Error Notification -->
        @if ($errors->any())

            <div
                 class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm">

                <div class="font-semibold mb-1">Terjadi kesalahan:</div>

                <ul class="list-disc list-inside space-y-1 text-xs">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form method="POST"
              action="{{ route('login.process') }}"
              class="space-y-4">

            @csrf


            <!-- Email -->
            <div>

                <label for="email"
                       class="block text-xs md:text-sm font-semibold text-[#1b365d] mb-1.5">

                    Email

                </label>

                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="opd@jatimprov.go.id"
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
                       placeholder="••••••••"
                       required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1b365d]/20 focus:border-[#1b365d] transition-all">

            </div>


            <!-- Submit Button -->
            <div class="pt-2">

                <button type="submit"
                        class="w-full py-3.5 px-4 bg-[#1b365d] hover:bg-[#142948] active:scale-[0.99] text-white font-semibold rounded-xl text-sm md:text-base shadow-sm transition-all duration-200 cursor-pointer">

                    Masuk

                </button>

            </div>

        </form>


        <!-- Bottom Link -->
        <div class="text-center text-sm text-slate-500 mt-6">

            Belum punya akun?

            <a href="{{ route('register') }}"
               class="font-bold text-[#1b365d] hover:underline">

                Daftar di sini

            </a>

        </div>


    </div>


    <!-- Footer -->
    <div class="text-center text-xs text-slate-400 mt-8 font-normal">

        © 2026 Dinas Kominfo Prov. Jawa Timur

    </div>


    <script>
        function switchTab(role) {

            const tabOpd = document.getElementById('tab-opd');

            const tabAdmin = document.getElementById('tab-admin');

            const emailInput = document.getElementById('email');


            if (role === 'opd') {

                tabOpd.className =
                    'flex-1 py-2.5 rounded-xl text-sm font-bold text-center transition-all bg-white text-[#1b365d] shadow-sm cursor-pointer';

                tabAdmin.className =
                    'flex-1 py-2.5 rounded-xl text-sm font-medium text-center transition-all text-slate-500 hover:text-slate-700 cursor-pointer';

                emailInput.placeholder = 'opd@jatimprov.go.id';

            } else {

                tabAdmin.className =
                    'flex-1 py-2.5 rounded-xl text-sm font-bold text-center transition-all bg-white text-[#1b365d] shadow-sm cursor-pointer';

                tabOpd.className =
                    'flex-1 py-2.5 rounded-xl text-sm font-medium text-center transition-all text-slate-500 hover:text-slate-700 cursor-pointer';

                emailInput.placeholder = 'admin@jatimprov.go.id';

            }

        }
    </script>


</body>

</html>