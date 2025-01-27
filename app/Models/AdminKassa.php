<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminKassa extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'user_id',
        'naqt',
        'plastik',
        'chegirma',
        'qaytarildi',
        'tashriflar',
    ];
}
