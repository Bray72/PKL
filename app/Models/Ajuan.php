<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Temuan;

class Ajuan extends Model
{
    use HasFactory;

    protected $table = 'ajuans';

    protected $fillable = [
        'user_id',
        'nomor_ajuan',
        'nama_aplikasi',
        'tujuan_assessment',
        'status',
        'tanggal_pengajuan',
        'tanggal_assessment',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengajuan' => 'date',
            'tanggal_assessment' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function temuans(): HasMany
    {
        // return $this->hasMany(Temuan::class);
        return $this->hasMany(Temuan::class, 'ajuan_id');
    }

    public function dokumens(): HasMany
    {
        return $this->hasMany(Dokumen::class);
    }
}
