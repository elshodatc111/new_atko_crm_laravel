<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone1',
        'phone2',
        'addres',
        'tkun',
        'smm',
        'status',
        'commit',
        'user_id',
        'meneger',
    ];
}
