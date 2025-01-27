<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TulovDelete extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'filial_id',
        'user_id',
        'summa',
        'type',
        'admin_id',
    ];
}
