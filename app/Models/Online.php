<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Online extends Model
{
    use HasFactory;
    protected $fillable = [
        'cours_id',
        'cours_id_api',
        'cours_id_api_name',
        'meneger',
    ];
}
