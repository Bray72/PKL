<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Portal ITSA')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{--
        Pakai entry vite yang SUDAH pasti ada di manifest: app.css / app.js
        (ini yang sebelumnya dipakai di halaman dashboard dan sudah jalan).
        resources/css/admin.css & resources/js/admin.js sengaja TIDAK dipakai
        lagi karena belum terdaftar sebagai entry vite (menyebabkan error
        "Unable to locate file in Vite manifest"). Navbar/sidebar di bawah ini
        sudah mandiri (pakai <style> & <script> biasa), jadi tidak butuh file
        itu sama sekali. Tidak ada perubahan di vite.config.js / npm run dev.
    --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{--
        Style khusus untuk NAVBAR + SIDEBAR.
        Ditulis sebagai CSS biasa (bukan Tailwind) supaya tidak bergantung pada
        proses build tambahan / npm run dev. Class di-prefix "itsa-" supaya
        tidak bentrok dengan class lama (.admin-navbar, .admin-sidebar, dst)
        yang mungkin masih dipakai di admin.css.
    --}}
    <style>
        :root {
            --itsa-navy: #16305a;
            --itsa-navy-dark: #0f2747;
            --itsa-indigo: #6366f1;
            --itsa-bg: #eef2f7;
            --itsa-sidebar-w: 264px;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--itsa-bg);
            color: #1e293b;
        }

        /* ============ LAYOUT SHELL ============ */
        .itsa-shell {
            display: flex;
            min-height: 100vh;
        }

        .itsa-main-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .itsa-content {
            flex: 1;
            padding: 32px 40px;
        }

        /* ============ SIDEBAR ============ */
        .itsa-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--itsa-sidebar-w);
            background: linear-gradient(180deg, var(--itsa-navy) 0%, var(--itsa-navy-dark) 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 24px 18px;
            z-index: 40;
            transform: translateX(-100%);
            transition: transform .25s ease;
        }

        .itsa-sidebar.is-open {
            transform: translateX(0);
        }

        .itsa-sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 6px 20px 6px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            margin-bottom: 20px;
        }

        .itsa-sidebar-logo {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            background: #fff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
            color: var(--itsa-navy);
        }

        .itsa-sidebar-title {
            margin: 0;
            font-size: 16px;
            font-weight: 800;
            line-height: 1.1;
            color: #fff;
        }

        .itsa-sidebar-subtitle {
            margin: 4px 0 0;
            font-size: 11.5px;
            color: rgba(255,255,255,.55);
            font-weight: 500;
        }

        .itsa-sidebar-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: rgba(255,255,255,.4);
            padding: 0 10px;
            margin: 4px 0 10px;
        }

        .itsa-sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .itsa-sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 12px;
            color: rgba(255,255,255,.72);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            transition: background .15s ease, color .15s ease;
        }

        .itsa-sidebar-link:hover {
            background: rgba(255,255,255,.07);
            color: #fff;
        }

        .itsa-sidebar-link.is-active {
            background: #fff;
            color: var(--itsa-navy);
            box-shadow: 0 4px 10px rgba(0,0,0,.15);
        }

        .itsa-sidebar-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .itsa-sidebar-icon svg { width: 20px; height: 20px; }

        /* user card pinned to bottom */
        .itsa-sidebar-user {
            margin-top: auto;
            padding-top: 16px;
        }

        .itsa-sidebar-user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 14px;
            padding: 10px 12px;
        }

        .itsa-sidebar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--itsa-indigo);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
            color: #fff;
            flex-shrink: 0;
        }

        .itsa-sidebar-user-name {
            margin: 0;
            font-size: 12.5px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .itsa-sidebar-user-role {
            margin: 2px 0 0;
            font-size: 11px;
            color: rgba(255,255,255,.5);
        }

        .itsa-sidebar-logout {
            margin-left: auto;
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 8px;
            background: transparent;
            color: rgba(255,255,255,.55);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            transition: background .15s ease, color .15s ease;
        }

        .itsa-sidebar-logout:hover {
            background: rgba(244,63,94,.15);
            color: #fda4af;
        }

        /* backdrop for mobile */
        .itsa-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,.5);
            z-index: 30;
        }

        .itsa-overlay.is-open { display: block; }

        /* ============ TOPBAR (mobile only) ============ */
        .itsa-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 10px 16px;
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .itsa-topbar-brand {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .itsa-topbar-brand .itsa-sidebar-logo {
            width: 32px;
            height: 32px;
            font-size: 12px;
            border-radius: 9px;
            color: var(--itsa-navy);
        }

        .itsa-topbar-title {
            font-size: 14px;
            font-weight: 800;
            color: var(--itsa-navy);
            margin: 0;
        }

        .itsa-menu-button {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #fff;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--itsa-navy);
        }

        .itsa-topbar-logout {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid #fecdd3;
            background: #fff1f2;
            color: #e11d48;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* ============ FOOTER ============ */
        .itsa-footer {
            text-align: center;
            font-size: 11.5px;
            color: #94a3b8;
            padding: 20px 16px 28px;
        }

        /* ============ DESKTOP (>=1024px) ============ */
        @media (min-width: 1024px) {
            .itsa-sidebar {
                transform: translateX(0);
            }

            .itsa-main-wrap {
                margin-left: var(--itsa-sidebar-w);
            }

            .itsa-topbar {
                display: none;
            }

            .itsa-overlay {
                display: none !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="itsa-shell">

        {{-- ================= SIDEBAR ================= --}}
        <aside class="itsa-sidebar" id="itsaSidebar">

            <div class="itsa-sidebar-brand">
                <div class="itsa-sidebar-logo">IT</div>
                <div>
                    <p class="itsa-sidebar-title">Portal ITSA</p>
                    <p class="itsa-sidebar-subtitle">Prov. Jawa Timur</p>
                </div>
            </div>

            <p class="itsa-sidebar-label">Admin ITSA</p>

            <nav class="itsa-sidebar-nav">

                <a href="{{ route('admin.dashboard') }}"
                   class="itsa-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                    <span class="itsa-sidebar-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 0h6v6h-6v-6z"/>
                        </svg>
                    </span>
                    Dashboard
                </a>

                <a href="{{ route('admin.pengajuan.index') }}"
                   class="itsa-sidebar-link {{ request()->routeIs('admin.pengajuan.*') ? 'is-active' : '' }}">
                    <span class="itsa-sidebar-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M12 3l1.6 4.9L18 9l-4.4 1.6L12 15l-1.6-4.4L6 9l4.4-1.1L12 3z"/>
                        </svg>
                    </span>
                    Pengajuan ITSA
                </a>

                <a href="{{ route('admin.temuan.index') }}" 
                class="itsa-sidebar-link {{ request()->routeIs('admin.temuan.*') ? 'is-active' : '' }}">
                    <span class="itsa-sidebar-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M12 3l7 9-7 9-7-9 7-9z"/>
                        </svg>
                    </span>
                    Kelola Temuan
                </a>

                <a href="{{ route('dokumen.index') }}"
                    class="itsa-sidebar-link {{ request()->routeIs('dokumen.*') ? 'is-active' : '' }}">
                        <span class="itsa-sidebar-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M6 3h8l4 4v14H6V3z"/>
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M14 3v5h5"/>
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M9 13h6M9 17h6"/>
                            </svg>
                        </span>
                        Upload Dokumen
                    </a>

            </nav>

            <div class="itsa-sidebar-user">
                <div class="itsa-sidebar-user-card">

                    <div class="itsa-sidebar-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>

                    <div style="min-width:0;">
                        <p class="itsa-sidebar-user-name">
                            {{ auth()->user()->name ?? 'Admin ITSA' }}
                        </p>
                        <p class="itsa-sidebar-user-role">Tim ITSA Jatim</p>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" style="margin-left:auto;">
                        @csrf
                        <button type="submit" class="itsa-sidebar-logout" title="Logout" aria-label="Logout">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>

                </div>
            </div>

        </aside>

        {{-- backdrop, hanya aktif di mobile saat sidebar dibuka --}}
        <div class="itsa-overlay" id="itsaOverlay" data-sidebar-toggle></div>

        <div class="itsa-main-wrap">

            {{-- ================= TOPBAR (tampil di mobile saja) ================= --}}
            <header class="itsa-topbar">

                <button type="button" class="itsa-menu-button" data-sidebar-toggle aria-label="Buka menu">
                    ☰
                </button>

                <div class="itsa-topbar-brand">
                    <div class="itsa-sidebar-logo">IT</div>
                    <p class="itsa-topbar-title">Portal ITSA</p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="itsa-topbar-logout" title="Logout" aria-label="Logout">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>

            </header>

            {{-- ================= KONTEN HALAMAN ================= --}}
            <main class="itsa-content">
                @yield('content')
            </main>

            <footer class="itsa-footer">
                © {{ date('Y') }} Dinas Komunikasi dan Informatika Provinsi Jawa Timur
            </footer>

        </div>

    </div>

    {{-- Vanilla JS untuk toggle sidebar di mobile, tidak butuh build/npm run dev --}}
    <script>
        (function () {
            var sidebar = document.getElementById('itsaSidebar');
            var overlay = document.getElementById('itsaOverlay');

            document.querySelectorAll('[data-sidebar-toggle]').forEach(function (el) {
                el.addEventListener('click', function () {
                    sidebar.classList.toggle('is-open');
                    overlay.classList.toggle('is-open');
                });
            });
        })();
    </script>

    @stack('scripts')

</body>
</html>