<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ajuan;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Temuan extends Model
{
    use HasFactory;

    protected $table = 'temuans';

    protected $fillable = [
        'ajuan_id',
        'created_by',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeVisibleToAdmin(Builder $query, User $user): Builder
    {
        // Role 1 adalah Superadmin, dapat melihat semua temuan
        if ((int) $user->role_id === 1) {
            return $query;
        }

        // Role 2 & 3 (Admin) hanya bisa melihat temuan yang dibuat oleh dirinya sendiri
        return $query->where('created_by', $user->id);
    }
}
