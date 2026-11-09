<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'dokumens';

    protected $fillable = [
        'ajuan_id',
        'temuan_id',
        'jenis_dokumen',
        'nama_file',
        'path_file',
        'uploaded_by',
    ];

    public function ajuan(): BelongsTo
    {
        return $this->belongsTo(Ajuan::class);
    }

    public function temuan(): BelongsTo
    {
        return $this->belongsTo(Temuan::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Dapatkan URL file dari Supabase (atau fallback ke local public disk jika ada di lokal)
     */
    public function getFileUrlAttribute(): string
    {
        if (!$this->path_file) {
            return '#';
        }

        // Fallback untuk file lama yang masih ada di storage local public
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->path_file)) {
            return \Illuminate\Support\Facades\Storage::disk('public')->url($this->path_file);
        }

        // URL() dari adapter S3 Supabase dapat menunjuk ke endpoint S3
        // (/storage/v1/s3) yang membutuhkan header apikey. Karena bucket
        // Dokumen-ITSA bersifat public, gunakan endpoint object public.
        $endpoint = config('filesystems.disks.supabase.endpoint');
        $endpointUrl = parse_url($endpoint ?: '');
        $host = $endpointUrl['host'] ?? null;

        if ($host) {
            $host = preg_replace('/\.storage\.supabase\.co$/', '.supabase.co', $host);
            $bucket = rawurlencode((string) config('filesystems.disks.supabase.bucket'));
            $path = implode('/', array_map('rawurlencode', explode('/', ltrim($this->path_file, '/'))));

            return sprintf(
                '%s://%s/storage/v1/object/public/%s/%s',
                $endpointUrl['scheme'] ?? 'https',
                $host,
                $bucket,
                $path
            );
        }

        return \Illuminate\Support\Facades\Storage::disk('supabase')->url($this->path_file);
    }
}
