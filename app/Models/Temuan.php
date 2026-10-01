<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ajuan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Temuan extends Model
{
    use HasFactory;

    protected $table = 'temuans';

    protected $fillable = [
        'ajuan_id',
        'judul',
        'deskripsi',
        'severity',
        'rekomendasi',
        'status',
        'catatan_validasi',
        'jenis_dokumen',
        'nama_file',
        'path_file',
        'uploaded_by',
    ];

    public function ajuan(): BelongsTo
    {
        // return $this->belongsTo(Ajuan::class);
        return $this->belongsTo(Ajuan::class, 'ajuan_id');
    }

    public function dokumens(): HasMany
    {
        return $this->hasMany(Dokumen::class);
    }
}
