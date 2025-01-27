<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murojat extends Model
{
    use HasFactory;
    protected $fillable = [
        'filial_id',
        'user_id',
        'user_type',
        'admin_id',
        'admin_type',
        'status',
        'text',
    ];
}
