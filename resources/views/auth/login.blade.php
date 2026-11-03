<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Portal ITSA - Diskominfo Prov. Jawa Timur</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .split-layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* ===== LEFT HERO SECTION ===== */
        .hero-section {
            flex: 1.15;
            position: relative;
            background-image: url('{{ asset('gedungkominfo.webp') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 56px 48px;
            color: #fff;
            overflow: hidden;
        }

        /* Overlay Gelap Elegan */
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15, 30, 54, 0.45) 0%, rgba(11, 23, 42, 0.88) 75%, rgba(9, 18, 34, 0.96) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 540px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #e2e8f0;
            margin-bottom: 20px;
        }

        .hero-badge-dot {
            width: 7px;
            height: 7px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 8px #10b981;
        }

        .hero-title {
            font-size: 38px;
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: -0.02em;
            margin: 0;
            color: #ffffff;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        /* ===== RIGHT FORM SECTION ===== */
        .form-section {
            flex: 0.95;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 32px;
            min-height: 100vh;
            box-sizing: border-box;
        }

        .form-container {
            width: 100%;
            max-width: 440px;
        }

        .welcome-kicker {
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #2563eb;
            margin-bottom: 8px;
        }

        .form-title {
            font-size: 30px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 8px 0;
            letter-spacing: -0.02em;
        }

        .form-subtitle {
            font-size: 14px;
            color: #64748b;
            margin: 0 0 28px 0;
        }

        /* Segmented Tabs */
        .segmented-tabs {
            display: flex;
            background: #f1f5f9;
            padding: 4px;
            border-radius: 14px;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
        }

        .tab-btn {
            flex: 1;
            padding: 10px 16px;
            border-radius: 11px;
            font-size: 13.5px;
            font-weight: 600;
            border: none;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            transition: all .2s ease;
            text-align: center;
        }

        .tab-btn.active {
            background: #ffffff;
            color: #0f172a;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        /* Form Inputs */
        .input-group {
            margin-bottom: 20px;
        }

        .input-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .input-label {
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
        }

        .forgot-link {
            font-size: 12.5px;
            font-weight: 600;
            color: #2563eb;
            text-decoration: none;
            transition: color .15s;
        }

        .forgot-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .input-field {
            width: 100%;
            padding: 13px 16px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            font-size: 14px;
            color: #0f172a;
            background: #ffffff;
            outline: none;
            box-sizing: border-box;
            transition: border-color .15s, box-shadow .15s;
        }

        .input-field:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .input-field::placeholder {
            color: #94a3b8;
        }

        /* Checkbox */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
            cursor: pointer;
            user-select: none;
        }

        .remember-checkbox {
            width: 17px;
            height: 17px;
            border-radius: 5px;
            border: 1px solid #cbd5e1;
            accent-color: #1b365d;
            cursor: pointer;
        }

        .remember-label {
            font-size: 13px;
            color: #475569;
            cursor: pointer;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #1b365d;
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all .2s;
            box-shadow: 0 4px 12px rgba(27, 54, 93, 0.2);
        }

        .btn-submit:hover {
            background: #132742;
            box-shadow: 0 6px 16px rgba(27, 54, 93, 0.28);
        }

        .btn-submit:active {
            transform: scale(0.99);
        }

        /* Register footer */
        .register-footer {
            text-align: center;
            font-size: 13px;
            color: #64748b;
            margin-top: 24px;
        }

        .register-link {
            font-weight: 700;
            color: #1b365d;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 960px) {
            .split-layout {
                flex-direction: column;
            }
            .hero-section {
                flex: none;
                min-height: 260px;
                padding: 36px 24px;
            }
            .hero-title {
                font-size: 26px;
            }
            .form-section {
                flex: none;
                min-height: auto;
                padding: 40px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="split-layout">

        {{-- LEFT COLUMN: Hero Gedung Kominfo --}}
        <div class="hero-section">
            <div class="hero-overlay"></div>
            
            <div class="hero-content">
                <h1 class="hero-title">
                    Menjaga keamanan layanan digital Jawa Timur
                </h1>
            </div>
        </div>

        {{-- RIGHT COLUMN: Login Form --}}
        <div class="form-section">
            <div class="form-container">

                <div class="welcome-kicker">SELAMAT DATANG</div>
                <h2 class="form-title">Masuk ke Portal ITSA</h2>
                <p class="form-subtitle">Gunakan akun instansi Anda untuk melanjutkan.</p>

                {{-- Alert Messages --}}
                @if (session('success'))
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; font-weight: 600;">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div style="background: #fef2f2; border: 1px solid #fecdd3; color: #991b1b; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px;">
                        <ul style="margin: 0; padding-left: 16px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.process') }}">
                    @csrf

                    {{-- NIP / Email Dinas --}}
                    <div class="input-group">
                        <label for="email" id="email-label" class="input-label" style="display: block; margin-bottom: 8px;">
                            NIP / Email Dinas
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="nama@opd.jatimprov.go.id"
                               required
                               autocomplete="email"
                               class="input-field">
                    </div>

                    {{-- Password --}}
                    <div class="input-group">
                        <div class="input-label-row">
                            <label for="password" class="input-label">Password</label>
                        </div>
                        <input type="password"
                               id="password"
                               name="password"
                               placeholder="Masukkan password"
                               required
                               autocomplete="current-password"
                               class="input-field">
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="btn-submit">
                        Masuk ke Portal
                    </button>
                </form>
                
            </div>
        </div>

    </div>

    <script>
        function switchRole(role) {
            const tabOpd = document.getElementById('tab-opd');
            const tabAdmin = document.getElementById('tab-admin');
            const emailInput = document.getElementById('email');

            if (role === 'opd') {
                tabOpd.classList.add('active');
                tabAdmin.classList.remove('active');
                emailInput.placeholder = 'nama@opd.jatimprov.go.id';
            } else {
                tabAdmin.classList.add('active');
                tabOpd.classList.remove('active');
                emailInput.placeholder = 'admin@jatimprov.go.id';
            }
        }
    </script>

</body>

</html>
