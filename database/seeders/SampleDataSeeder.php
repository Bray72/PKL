<?php

namespace Database\Seeders;

use App\Models\Ajuan;
use App\Models\Role;
use App\Models\Temuan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        Role::updateOrCreate(['id' => 1], ['name' => 'admin']);
        Role::updateOrCreate(['id' => 2], ['name' => 'opd']);

        // 2. Admin User
        User::updateOrCreate(
            ['email' => 'admin@jatimprov.go.id'],
            [
                'role_id' => 1,
                'name' => 'Administrator ITSA',
                'password' => Hash::make('password'),
                'instansi' => 'Dinas Kominfo Jatim',
            ]
        );

        // 3. OPD User 1: Dinas Kesehatan
        $dinkes = User::updateOrCreate(
            ['email' => 'dinkes@jatimprov.go.id'],
            [
                'role_id' => 2,
                'name' => 'Budi Santoso',
                'nip' => '198501012010011001',
                'jabatan' => 'Kepala Bidang TI',
                'instansi' => 'Dinas Kesehatan Prov. Jatim',
                'password' => Hash::make('password'),
            ]
        );

        // 4. OPD User 2: Dinas Pendidikan
        $dindik = User::updateOrCreate(
            ['email' => 'dindik@jatimprov.go.id'],
            [
                'role_id' => 2,
                'name' => 'Siti Rahma',
                'nip' => '198702022011012002',
                'jabatan' => 'Pranata Komputer',
                'instansi' => 'Dinas Pendidikan Prov. Jatim',
                'password' => Hash::make('password'),
            ]
        );

        // 5. Sample Ajuans for Dinkes
        $ajuan1 = Ajuan::updateOrCreate(
            ['nomor_ajuan' => 'AJU-2026-001'],
            [
                'user_id' => $dinkes->id,
                'nama_aplikasi' => 'Sistem Informasi Kepegawaian (SIMPEG)',
                'tujuan_assessment' => 'Assessment Rutin Tahunan Uji Penetrasi Web Application',
                'status' => 'Sedang Diproses',
                'tanggal_pengajuan' => now()->subDays(5),
                'catatan' => 'Mohon dipercepat untuk persiapan audit BPK',
            ]
        );

        $ajuan2 = Ajuan::updateOrCreate(
            ['nomor_ajuan' => 'AJU-2026-002'],
            [
                'user_id' => $dinkes->id,
                'nama_aplikasi' => 'Portal Pelayanan Publik (E-SBM)',
                'tujuan_assessment' => 'Uji Keamanan Aplikasi Publik',
                'status' => 'Selesai',
                'tanggal_pengajuan' => now()->subDays(12),
                'tanggal_assessment' => now()->subDays(2),
                'catatan' => 'Sertifikat keamanan telah diterbitkan',
            ]
        );

        // 6. Sample Ajuan for Dindik
        $ajuan3 = Ajuan::updateOrCreate(
            ['nomor_ajuan' => 'AJU-2026-003'],
            [
                'user_id' => $dindik->id,
                'nama_aplikasi' => 'Sistem PPDB Online Jatim',
                'tujuan_assessment' => 'Penetration Testing Sebelum Release',
                'status' => 'Perlu Verifikasi',
                'tanggal_pengajuan' => now()->subDay(),
                'catatan' => 'Berkas pengajuan lengkap',
            ]
        );

        // 7. Sample Temuan
        Temuan::updateOrCreate(
            [
                'ajuan_id' => $ajuan1->id,
                'judul' => 'SQL Injection pada Form Pencarian Pegawai',
            ],
            [
                'deskripsi' => 'Ditemukan celah keamanan SQLi pada parameter search',
                'severity' => 'High',
                'rekomendasi' => 'Gunakan prepared statement / Eloquent parameter binding',
                'status' => 'Perlu Perbaikan',
            ]
        );
    }
}
