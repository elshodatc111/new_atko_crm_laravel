<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilialKassa extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'tulov_naqt',
        'tulov_naqt_chiqim',
        'tulov_naqt_chiqim_tasdiqlandi',
        'tulov_plastik',
        'tulov_plastik_chiqim',
        'tulov_plastik_chiqim_tasdiqlandi',
        'tulov_chegirma',
        'tulov_naqt_xarajat',
        'tulov_naqt_xarajat_tasdiqlandi',
        'tulov_plastik_xarajat',
        'tulov_plastik_xarajat_tasdiqlandi',
        'tulov_naqt_ish_haqi',
        'tulov_plastik_ish_haqi',
    ];
}
