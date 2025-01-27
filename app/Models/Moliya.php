<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moliya extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'xodisa',
        'summa',
        'type',
        'status',
        'about',
        'user_id',
        'admin_id',
    ];
}
