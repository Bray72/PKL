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
}
