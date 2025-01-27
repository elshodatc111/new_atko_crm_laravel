<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TulovSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'status',
        'tulov_summa',
        'chegirma',
        'admin_chegirma',
    ];
}
