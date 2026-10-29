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

        // Cek jika file tersimpan di supabase
        try {
            if (\Illuminate\Support\Facades\Storage::disk('supabase')->exists($this->path_file)) {
                return \Illuminate\Support\Facades\Storage::disk('supabase')->url($this->path_file);
            }
        } catch (\Throwable $e) {
            // Ignore error jika koneksi gagal
        }

        // Fallback untuk file lama yang masih ada di storage local public
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->path_file)) {
            return \Illuminate\Support\Facades\Storage::disk('public')->url($this->path_file);
        }

        return \Illuminate\Support\Facades\Storage::disk('supabase')->url($this->path_file);
    }
}
