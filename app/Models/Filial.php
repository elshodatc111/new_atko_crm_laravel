<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filial extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_name',
        'filial_addres',
        'naqt',
        'xarajat_naqt',
        'plastik',
        'xarajat_plastik',
        'payme',
        'xarajat_payme',
    ];
}
