<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JatahCuti extends Model
{
    use HasFactory;

    protected $fillable = [
        'NIP',
        'tahun',
        'jatah'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'NIP', 'NIP');
    }
}
