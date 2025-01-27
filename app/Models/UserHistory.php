<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'user_id',
        'status',
        'type',
        'summa',
        'xisoblash',
        'balans',
    ];
}
